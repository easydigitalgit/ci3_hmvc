<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Wacron extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->helper('starsender');
        $this->load->helper('writelog');
        $this->load->model('Cron_model', 'CM');
        $this->load->library('parser');
        $this->load->library('Telegram');
        //Load Dependencies


    }

    public $APIKEYSTARSENDER;
    public $NOWACENTER;
    public $NAMACALEG;
    public $TEMPLATEULTAH;

    /*
        PT1M => 1 menit interval
        PT1H => 1 Jam interval
        PT1S => 1 Detik Interval

    */

    // List all your items
    public function index()
    {
        $namalog = 'wadaftar';
        $datetime = new DateTimeImmutable();
        $lastExec = $datetime->format('Y-m-d H:i:s'); //current time
        $nextExec = $datetime->add(new DateInterval('PT1M'))->format('Y-m-d H:i:s'); // add 1 minute

        cronlog($namalog, $lastExec, $nextExec);
        //log_message('debug','Called Cron '.date('d-m-Y h:i:s')).PHP_EOL;
        /* $logData['nama_log'] = 'stdmsg';
        $logData['last_exec'] = */
        $query = ' a.*, b.no_wa, b.apikey FROM queue_pesan a LEFT JOIN wa_center b ON a.wa_center_id = b.id ';
        $q = $this->db->select($query, false)->where(array('a.status_que' => '1', 'a.jenis_cron' => 'wadaftar'))->limit(50)->get();

        /* if($q->num_rows()){
            foreach($q->result() as $val){
                $namaCaleg = $val->nama_caleg;
                $noWa = $val->wa_center;
                $templateWa = $val->wa_template;
                $apikey = $val->apikey;
            }
         }
        $que = $this->db->get_where('queue_pesan', array('status_que'=>'1','jenis_cron'=>'wadaftar'),50);*/
        if ($q->num_rows()) {
            foreach ($q->result() as  $val) {
                $queID       = $val->id;
                $to_number   = $val->to_number;
                $body_text   = $val->body_text;
                //$sender      = $val->sender_number;
                $apikey       = $val->apikey;

                $send = sendtext($to_number, $body_text, $apikey);
                $respon = json_decode($send, true);
                //log_message('debug','respon message = '.$send );
                $data['respon_server'] = $send;
                if ($respon['status'] == 'true') {
                    $data['status_que'] = '2';
                } elseif ($respon['status'] == 'false') {
                    $data['status_que'] = '3';
                } else {
                    $data['status_que'] = '3';
                }
                $update = $this->db->update('queue_pesan', $data, array('id' => $queID));
                log_message('user_info', 'wadaftar send to = ' . $to_number);
            }
        }
    }

    public function wa_terjadwal()
    {
        // ambil konfigurasi
        $namalog = 'waterjadwal';
        $datetime = new DateTimeImmutable();
        $lastExec = $datetime->format('Y-m-d H:i:s'); //current time
        $nextExec = $datetime->add(new DateInterval('PT1H'))->format('Y-m-d H:i:s'); // add 1 hour

        cronlog($namalog, $lastExec, $nextExec);

        $q = $this->db->get('konfigurasi');

        if ($q->num_rows()) {
            $val = $q->row();

            $this->NAMACALEG        = $val->nama_caleg;
            $this->NOWACENTER       = $val->wa_center;
            $this->APIKEYSTARSENDER = $val->apikey;
        }



        //cek pesan dengan status menunggu dan tanggal nya sama dengan hari ini;
        $tglnow1 = date('Y-m-d 00:00:00');
        $tglnow2 = date('Y-m-d 23:59:59');

        $q = $this->db->select(" g.template_wa, f.id as id_pesan, f.jadwal_kirim, a.*, b.nama , b.no_wa as wa_anggota, c.no_wa as wa_koord, d.nama_relawan, d.no_wa as wa_relawan, CONCAT( IFNULL(b.no_wa,''),IFNULL(c.no_wa,''),IFNULL(d.no_wa,'') ) as nomor_wa FROM penerima_pesan_terjadwal a LEFT JOIN anggota b on a.id_anggota = b.id LEFT JOIN data_koord_relawan c on a.id_koord_relawan = c.id LEFT JOIN data_relawan d on a.id_relawan = d.id LEFT JOIN pesan_terjadwal f on a.id_pesan_terjadwal = f.id LEFT JOIN data_event g on f.id_event = g.id WHERE a.id_pesan_terjadwal IN  ( SELECT e.id from pesan_terjadwal e WHERE e.jadwal_kirim BETWEEN '" . $tglnow1 . "' AND '" . $tglnow2 . "')  AND f.status = 'menunggu' ", false)->get();


        if ($q->num_rows()) {
            foreach ($q->result() as $val) {

                $idPesan        = $val->id_pesan;
                $queID          = $val->id;
                $jadwalKirim    = $val->jadwal_kirim;
                $waTemplate     = $val->template_wa;
                $nomorWA        = $val->nomor_wa;

                $send = sendTextTerjadwal($nomorWA, $waTemplate, $jadwalKirim, $this->APIKEYSTARSENDER);
                $respon = json_decode($send, true);
                log_message('debug', '$respon Wa = ' . print_r($respon, true));
                if ($respon['status'] == 'true') {
                    $data['respon_status'] = '2';
                } else {
                    $data['respon_status'] = '3';
                }

                // update status penerima_pesan
                $updatePenerima = $this->db->update('penerima_pesan_terjadwal', $data, array('id' => $queID));

                // update status pesan_terjadwal
                $updateStatus = $this->db->update('pesan_terjadwal', array('status' => 'dijadwalkan'), array('id' => $idPesan));
            }
        } else {
        }
    }

    public function ultah()
    {
        //SELECT id, nama, dob, TIMESTAMPDIFF(YEAR,dob,CURDATE()) AS age, no_wa FROM `anggota` WHERE substr(dob,6,5) = '08-18';
        $namalog = 'waultah';
        $datetime = new DateTimeImmutable();
        $lastExec = $datetime->format('Y-m-d H:i:s'); //current time
        $nextExec = $datetime->add(new DateInterval('P1D'))->format('Y-m-d H:i:s'); // add 1 day

        log_message('debug', 'WA-ultah executed :');
        $qultah = " z.*, b.relawan_id_ri, b.relawan_id_prop, b.relawan_id_kota, i.template_ultah as wari, j.template_ultah as waprop, k.template_ultah as wakot, l.no_wa as nowari, m.no_wa as nowaprop , n.no_wa as nowakot, l.apikey as apiri, m.apikey as apiprop, n.apikey as apikot,  l.id as centeridri, m.id as centeridprop, n.id as centeridkot FROM (
            SELECT a.id, a.nama, a.dob, a.no_wa, TIMESTAMPDIFF(YEAR,a.dob,CURDATE()) AS usia FROM anggota a WHERE substr(a.dob,6,5) =  '" . date('m-d') . "'
            ) z LEFT JOIN data_pilihan_caleg b ON z.id = b.anggota_id 
            LEFT JOIN data_relawan c ON b.relawan_id_ri = c.id 
            LEFT JOIN data_relawan d ON b.relawan_id_prop = d.id 
            LEFT JOIN data_relawan e ON b.relawan_id_kota = e.id 
            
            LEFT JOIN data_koord_relawan f ON f.akun_id = c.koord_akun_id
            LEFT JOIN data_koord_relawan g ON g.akun_id = d.koord_akun_id
            LEFT JOIN data_koord_relawan h ON h.akun_id = e.koord_akun_id
            
            LEFT JOIN konfigurasi i ON f.caleg_akun_id = i.id_akun_caleg
            LEFT JOIN konfigurasi j ON g.caleg_akun_id = j.id_akun_caleg
            LEFT JOIN konfigurasi k ON h.caleg_akun_id = k.id_akun_caleg
            
            LEFT JOIN wa_center l ON i.wa_center_id = l.id
            LEFT JOIN wa_center m on j.wa_center_id = m.id
            LEFT JOIN wa_center n ON k.wa_center_id = n.id
            
            WHERE (i.ultah_enable = '1' OR j.ultah_enable = '1' OR k.ultah_enable = '1') AND (l.apikey IS NOT NULL OR m.apikey IS NOT NULL OR n.apikey IS NOT NULL ) ";
        $query = $this->db->select($qultah, false)->get();
        //log_message('user_info', 'wacron ultah:' . $this->db->last_query());
        if ($query->num_rows()) {
            foreach ($query->result() as $val) {
                if ($val->no_wa) {

                    $d['nama'] = $val->nama;
                    $d['usia'] = $val->usia;
                    $noWa = $val->no_wa;

                    if ($val->apiri && $val->wari) {
                        $WAri = $val->wari;
                        $bodyRI = $this->parser->parse_string($WAri, $d);
                        $this->_runJobUltah($bodyRI, $noWa, $val->centeridri, $val->apiri, $d);
                    }
                    if ($val->apiprop && $val->waprop) {
                        $bodyProp = $this->parser->parse_string($val->waprop, $d);
                        $this->_runJobUltah($bodyProp, $noWa, $val->centeridprop, $val->apiprop, $d);
                    }
                    if ($val->apikot && $val->wakot) {
                        $bodykot = $this->parser->parse_string($val->wakot, $d);
                        $this->_runJobUltah($bodykot, $noWa, $val->centeridkot, $val->apikot, $d);
                    }
                } else {
                    log_message('user_info', 'CRON ULTAH : ' . $val->nik . " # " . $val->nama . " : Tidak memiliki NO WA");
                }
            }
        } else {
            log_message('user_info', 'cronjob ultah ; no ultah found');
        }
    }

    private function _runJobUltah($bodyText, $noWa, $centerID, $apikey, $data)
    {
        $jadwalKirim = date('Y-m-d 08:00:00');
        $send   = sendTextTerjadwal($noWa, $bodyText, $jadwalKirim, $apikey);
        // $respon = json_decode($send, true);
        // log_message('user_info','message');

        $u['to_number'] = $noWa;
        $u['body_text'] = $bodyText;
        $u['wa_center_id'] = $centerID;
        $u['respon_server'] = $send;
        $u['last_update'] = date('Y-m-d H:i:s');
        $u['jenis_pesan'] = 'ultah';
        $u['extra_info'] = 'Cronjob Ultah';

        $insert = $this->db->insert('log_pesan_terjadwal', $u);
        $tele = $this->telegram->sendChat('bangkitbersama ultah : ' . $noWa . '# usia : ' . $data['usia']);
        log_message('debug', 'WA-ultah :' . $noWa . " # ");
    }

    public function ultah_lama()
    {
        //SELECT id, nama, dob, TIMESTAMPDIFF(YEAR,dob,CURDATE()) AS age, no_wa FROM `anggota` WHERE substr(dob,6,5) = '08-18';
        $namalog = 'waultah';
        $datetime = new DateTimeImmutable();
        $lastExec = $datetime->format('Y-m-d H:i:s'); //current time
        $nextExec = $datetime->add(new DateInterval('P1D'))->format('Y-m-d H:i:s'); // add 1 day

        if ($this->config->item('whatsapp_ultah')) {
            $jadwalKirim = date('Y-m-d 05:00:00');

            $q = $this->db->get('konfigurasi');

            log_message('user_info', 'ultah ok');

            if ($q->num_rows()) {
                $val = $q->row();

                $this->NAMACALEG        = $val->nama_caleg;
                $this->NOWACENTER       = $val->wa_center;
                $this->APIKEYSTARSENDER = $val->apikey;
                $this->TEMPLATEULTAH    = $val->template_ultah;
            }

            if ($this->TEMPLATEULTAH) {
                $q = $this->db->select(" id,nama, dob, TIMESTAMPDIFF(YEAR,dob,CURDATE()) AS usia, no_wa FROM anggota WHERE substr(dob,6,5) = '" . date('m-d') . "'", false)->get();
                if ($q->num_rows()) {
                    foreach ($q->result() as $val) {
                        $bodyText = '';
                        $dt['nama']     = $val->nama;
                        $dt['usia']     = $val->usia;

                        $nomorWA          = $val->no_wa;

                        $bodyText      = $this->parser->parse_string($this->TEMPLATEULTAH, $dt);
                        log_message('user_info', 'message = ' . $bodyText);
                        $send   = sendTextTerjadwal($nomorWA, $bodyText, $jadwalKirim, $this->APIKEYSTARSENDER);
                        $respon = json_decode($send, true);

                        log_message('user_info', '$respon Wa = ' . print_r($respon, true));
                        if ($respon['status'] == 'true') {
                            $data['respon_status'] = '2';
                        } else {
                            $data['respon_status'] = '3';
                        }
                    }
                }
            } else {
                //template ultah kosong
            }
        } else {
            log_message('user_info', 'ultah NON AKTIF');
        }
    }

    public function direct_wa_msg()
    {
        $namalog = 'wadm';
        $datetime = new DateTimeImmutable();
        $lastExec = $datetime->format('Y-m-d H:i:s'); //current time
        $nextExec = $datetime->add(new DateInterval('PT1M'))->format('Y-m-d H:i:s'); // add 1 minute

        cronlog($namalog, $lastExec, $nextExec);
        //log_message('debug','Called Cron '.date('d-m-Y h:i:s')).PHP_EOL;
        /* $logData['nama_log'] = 'stdmsg';
        $logData['last_exec'] = */

        /*  $q = $this->db->get('konfigurasi');
         
        if($q->num_rows()){
            foreach($q->result() as $val){
                $namaCaleg = $val->nama_caleg;
                $noWa = $val->wa_center;
                $templateWa = $val->wa_template;
                $apikey = $val->apikey;
            }
         } */
        //$que = $this->db->get_where('queue_pesan', array('status_que' => '1', 'jenis_cron' => 'wadm'), 50);
        $que = $this->db->select(' a.*, b.apikey, b.no_wa, b.deskripsi FROM queue_pesan a LEFT JOIN wa_center b ON a.wa_center_id = b.id ', false)->where(array('status_que' => '1', 'jenis_cron' => 'wadm'))->limit(50)->get();
        $mediaFolder = $this->media;
        if ($que->num_rows()) {
            foreach ($que->result() as  $val) {
                $queID       = $val->id;
                $to_number   = $val->to_number;
                $body_text   = $val->body_text;
                $sender      = $val->sender_number;
                $mediaPesan  = $val->media_pesan;
                $apikey = $val->apikey;

                if ($mediaPesan) {
                    $mediaPath =  $mediaFolder . $mediaPesan;
                    $send = sendImageFile($to_number, $body_text, $mediaPath, $apikey);
                } else {
                    $send = sendtext($to_number, $body_text, $apikey);
                }


                $respon = json_decode($send, true);
                //log_message('debug','respon message = '.$send );
                $data['respon_server'] = $send;
                if ($respon['status'] == 'true') {
                    $data['status_que'] = '2';
                } elseif ($respon['status'] == 'false') {
                    $data['status_que'] = '3';
                } else {
                    $data['status_que'] = '3';
                }

                $update = $this->db->update('queue_pesan', $data, array('id' => $queID));
            }
        }
        log_message('user_info', 'wadm last query = ' . $this->db->last_query());
    }


    public function wahook()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json);
        $dt['msg_body'] = $data->message; // isi pesan
        $dt['msg_from'] = $data->from; // dari
        $dt['msg_timestamp'] = $data->timestamp; // timestamp

        $txt = $data->message;
        if (substr($txt, 0, 4) == "/cmd") {
            $dt['iscmd'] = 1;
            $dt['cmdstatus'] = 'received';
        } else {
            $dt['iscmd'] = 0;
            $dt['cmdstatus'] = null;
        }

        $insert = $this->CM->insertDb('wa_hook', $dt);
        log_message('user_info', 'wahook = ' . $this->db->last_query());
    }
}

/* End of file Daftar_awal.php */
/* Location: ./application/modules/pendaftaran/controllers/Daftar_awal.php */
