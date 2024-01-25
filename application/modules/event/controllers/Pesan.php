<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pesan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        //$this->load->model('Admin_model', 'PM');
        $this->load->library('SelectOption');
        $this->load->helper('parser');
        $this->load->model('Event_model', 'EM');
        $this->UID  ? '' : $this->logOut();

        //Load Dependencies
    }

    private function _theme($data)
    {

        $data['libjs']          = jsbyEnv('libEvent');
        $data['libcss']         = '';
        $data['pjs']            = jsArray(array('bs4-datatables', 'select2', 'moment2.24', 'daterangepicker', 'lightbox', 'dual-listbox'));
        $data['pcss']           = cssArray(array('datatables', 'select2', 'select2-bs5', 'daterangepicker', 'dual-listbox', 'dual-listbox-icon'));
        //$data['menu'] 		= 'admin/sideMenu';

        $this->theme->dashboard_theme($data);
    }

    // List all your items
    public function index()
    {
        $lastCron = isset($this->EM->waCron('waterjadwal')->last_exec) ?  $this->EM->waCron('waterjadwal')->last_exec : null;
        $data['konten'] = 'pesanKonten';
        $data['libcss'] = '';
        $data['lastCronWaTerjadwal'] = $lastCron;
        $data['headDataPesanJadwal'] = head_tbl_btn2('whatsapp_terjadwal', false);
        $this->_theme($data);
    }



    public function table_whatsapp_terjadwal()
    {


        $table        = 'pesan_terjadwal';
        $col_order    = array('a.id');
        $col_search   = array('b.nama_event', 'a.jadwal_kirim');
        $order        = array('a.id' => 'ASC');
        $query        = " a.*, b.nama_event, b.tempat_event, b.tgl_event, b.deskripsi_event, b.template_wa FROM pesan_terjadwal a LEFT JOIN data_event b ON a.id_event = b.id ";


        $filter       = array();

        //get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
        $list  = $this->EM->get_datatables($table, $col_order, $col_search, $order, $query, $filter);
        $data  = array();
        $no    = $_POST['start'];
        foreach ($list as $da) {
            $no++;
            $row   = array();
            $row[] = '<input type="checkbox" class="data-check" value="' . $da->id . '">';
            $row[] = $no;
            $row[] = $da->nama_event;
            $row[] = $da->template_wa;
            $row[] = $da->jadwal_kirim;
            $row[] = '<span class="badge bg-info fs-6">' . $da->jumlah_penerima . '</span>'; //jumlah penerima pesan
            $row[] = $da->status;

            $row[] = actionBtn3($da->id, 'whatsapp_terjadwal');


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->EM->count_all_query($table, $filter),
            "recordsFiltered" => $this->EM->count_filtered($query, $filter),
            "data" => $data,
        );
        //output to json format
        $this->jsonOut($output);
    }

    public function add_whatsapp_terjadwal()
    {
        $ulevel = $this->ULEVEL;
        $uid = $this->UID;
        $this->form_validation->set_rules($this->EM->whatsappTerjadwalRules('add'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {

            //id_event , jadwal_kirim, id_koord_relawan[], id_relawan[], filterBy, anggota_id[], check_admin, check_anggota, check_koord
            $checkRelawan   = $this->input->post('check_relawan') == 'on' ? 'ALL' : 'SELECTED';
            $checkKoord     = $this->input->post('check_koord') == 'on' ? 'ALL' : 'SELECTED';
            $checkAnggota   = $this->input->post('check_anggota') == 'on' ? 'ALL' : 'SELECTED';

            $koord      = $this->input->post('id_koord_relawan');
            $relawan    = $this->input->post('id_relawan');
            $anggota    = $this->input->post('anggota_id');
            $wacenterID = $this->input->post('wa_center_id');
            $data['id_event']       = $this->input->post('id_event');
            $data['jadwal_kirim']   = date('Y-m-d H:i:s', strtotime($this->input->post('jadwal_kirim')));
            $data['check_relawan']  = $checkRelawan;
            $data['check_koord']    = $checkKoord;
            $data['check_anggota']  = $checkAnggota;
            $data['anggota_filterby'] = $checkAnggota == 'SELECTED' ? $this->input->post('filterBy') : 0;
            $insert = $this->EM->insertDb('pesan_terjadwal', $data);

            if ($checkRelawan == 'SELECTED') {
                //insert penerima admin
                if (is_array($relawan)) {
                    $dr = array();
                    foreach ($relawan as $r) {
                        $dt = array();
                        $dt['id_pesan_terjadwal']   = $insert;
                        $dt['id_relawan']           = $r;

                        $dr[] = $dt;
                    }
                    $insertRelawan = $this->EM->insertBatchDb('penerima_pesan_terjadwal', $dr);
                }
            } else if ($checkRelawan == 'ALL') {
                // relawan cek ALL
                if ($ulevel == '1') {
                    $qrelawan = $this->db->get('data_relawan');
                } else if ($ulevel == '3') {
                    // relawan by caleg
                    $qrelawan = $this->EM->getRelawanByCalegID($uid);
                } else if ($ulevel == '4') {
                    //relawan by kordapil
                    $qrelawan = $this->EM->getRelawanByKordapil($uid);
                } else {
                    $qrelawan = false;
                }

                if ($qrelawan->num_rows()) {
                    $dr = array();
                    foreach ($qrelawan->result() as $relawan) {
                        $dt = array();
                        if ($relawan->no_wa) {
                            $dt['id_relawan'] = $relawan->id;
                            $dt['id_pesan_terjadwal'] = $insert;
                        }
                        $dr[] = $dt;
                    }
                    $insertRelawan = $this->EM->insertBatchDb('penerima_pesan_terjadwal', $dr);
                }
            }

            if ($checkKoord == 'SELECTED') {
                // insert penerima koord_relawan
                if (is_array($koord)) {
                    $dk = array();
                    foreach ($koord as $r) {
                        $dt = array();
                        $dt['id_pesan_terjadwal']   = $insert;
                        $dt['id_koord_relawan']     = $r;

                        $dk[] = $dt;
                    }
                    $insertKoord = $this->EM->insertBatchDb('penerima_pesan_terjadwal', $dk);
                }
            } else if ($checkKoord == 'ALL') {
                //cek all data_koordinator
                if ($ulevel == '1') {
                    $qkoord = $this->db->get('data_koord_relawan');
                } else if ($ulevel == '3') {
                    // koordinator by caleg
                    $qkoord = $this->EM->getKoordRelawanByCalegID($uid);
                } else if ($ulevel == '4') {
                    // koordinator by kordapil
                    $qkoord = $this->EM->getKoordRelawanByKordapilID($uid);
                } else {
                    $qkoord = false;
                }

                if ($qkoord->num_rows()) {
                    $dk = array();
                    foreach ($qkoord->result() as $koord) {
                        if ($koord->no_wa) {
                            $dt = array();
                            $dt['id_koord_relawan'] = $koord->id;
                            $dt['id_pesan_terjadwal'] = $insert;
                        }
                        $dk[] = $dt;
                    }
                    $insertKoord = $this->EM->insertBatchDb('penerima_pesan_terjadwal', $dk);
                }
            }

            if ($checkAnggota == 'SELECTED') {
                //insert penerima anggota
                if (is_array($anggota) && count($anggota)) {
                    // log_message('debug','count anggota = '.count($anggota));
                    $anggotaSelect = json_decode($anggota[0], true);
                    // log_message('debug','anggotaSelect = '.print_r($anggotaSelect,true));

                    if ($anggotaSelect) {

                        $da = array();
                        foreach ($anggotaSelect as $value) {
                            $dt = array();
                            $dt['id_pesan_terjadwal']   = $insert;
                            $dt['id_anggota']           = $value['id'];
                            $da[] = $dt;
                        }
                        $insertAnggota = $this->EM->insertBatchDb('penerima_pesan_terjadwal', $da);
                    }
                }
            } else if ($checkAnggota == 'ALL') {
                // anggota cek all
                if ($ulevel == '1') {
                    $qanggota = $this->db->get('anggota');
                } else if ($ulevel == '3') {
                    // koordinator by caleg
                    $qanggota = $this->EM->getAnggotaByCalegID($uid);
                } else if ($ulevel == '4') {
                    // koordinator by kordapil
                    $qanggota = $this->EM->getAnggotaByKordapilID($uid);
                } else {
                    $qanggota = false;
                }

                if ($qanggota->num_rows()) {
                    $da = array();
                    foreach ($qanggota->result() as $anggota) {
                        if ($anggota->no_wa) {
                            $dt = array();
                            $dt['id_anggota'] = $anggota->id;
                            $dt['id_pesan_terjadwal'] = $insert;
                        }
                        $da[] = $dt;
                    }
                    $insertAnggota = $this->EM->insertBatchDb('penerima_pesan_terjadwal', $da);
                }
            }


            if ($insert) {
                $ret['status']              = true;
                $ret['data_pesan']          =  'data pesan berhasil disimpan';
                $ret['penerima_koord']      = isset($insertKoord) ? $insertKoord : 0;
                $ret['penerima_relawan']    = isset($insertRelawan) ? $insertRelawan : 0;
                $ret['penerima_anggota']    = isset($insertAnggota) ? $insertAnggota : 0;

                $jumlah['jumlah_penerima'] = $ret['penerima_koord'] + $ret['penerima_anggota'] + $ret['penerima_relawan'];
                $update = $this->EM->update('pesan_terjadwal', array('id' => $insert), $jumlah);
            } else {
                $ret['status'] = false;
            }
        }

        $this->jsonOut($ret);
    }




    public function edit_daftar_awal($id)
    {
        if ($id) {
            $data   = $this->EM->getDaftarAwalByID($id);


            if ($data) {
                $ret['status']     = true;
                $ret['data']     = $data->row();
            } else {
                $ret['status']     = false;
                $ret['data']     = 0;
            }
        } else {
            $ret['status']     = false;
            $ret['data']     = 0;
        }

        $this->jsonOut($ret);
    }



    //Delete one item
    public function delete_whatsapp_terjadwal()
    {
        //DELETE FROM pesan_terjadwal, penerima_pesan_terjadwal using pesan_terjadwal, penerima_pesan_terjadwal WHERE penerima_pesan_terjadwal.id_pesan_terjadwal = pesan_terjadwal.id AND pesan_terjadwal.id = 1
        $data     = $this->input->post('id');
        $table    = 'pesan_terjadwal';

        $q      = $this->EM->deleteWhatsappTerjadwal($data);
        if ($q > 0) {
            $ret['status'] = true;
            $ret['msg'] = $q . ' data_dihapus';
        } else {
            $ret['status'] = false;
            $ret['msg'] = 'terdapat kesalahan';
        }
        $this->jsonOut($ret);
    }

    public function add_pesan_langsung()
    {
        $uid = $this->UID;
        $ulevel = $this->ULEVEL;

        $checkRelawan   = $this->input->post('checkrelawan') == 'on' ? 'ALL' : 'SELECTED';
        $checkKoord     = $this->input->post('checkkoord') == 'on' ? 'ALL' : 'SELECTED';
        $checkAnggota   = $this->input->post('dm_check_anggota') == 'on' ? 'ALL' : 'SELECTED';

        $koord      = $this->input->post('dm_id_koord_relawan');
        $relawan    = $this->input->post('dm_id_relawan');
        $anggota    = $this->input->post('dm_anggota_id');
        $pesan      = $this->input->post('body_text');
        $wacenterID = $this->input->post('wa_center_id');

        $q = $this->db->get('konfigurasi');

        /* if($q->num_rows()){
                    foreach($q->result() as $val){
                        $namaCaleg      = $val->nama_caleg;
                        $noWa           = $val->wa_center;
                        $templateWa     = $val->wa_template;
                        $apikey         = $val->apikey;
                    }
                 } */

        // file = media_pesan  ext = docx, xlsx, pdf, jpg, png, mp4;
        $imageFolder = 'media';
        $ext = 'doc|docx|xls|xlsx|pdf|jpg|png|mp4';
        if (!empty($_FILES['media_pesan']['name'])) {
            $filename = 'file_' . (microtime(true) * 10000) . '_' . uniqid();
            $uplod_foto = $this->_upload_images('media_pesan', $filename, $imageFolder, true, $ext);
            if ($uplod_foto['status']) {
                $data['media_pesan']        = $uplod_foto['filename'];
                $ret['status_media']        = true;
                $mediaPesan = $uplod_foto['filename'];
            } else {
                $ret['msg']['media_pesan']  = $uplod_foto['error'];
                $ret['status_media']        = false;
                $mediaPesan = '';
            }
        } else {
            $ret['media_pesan']             = false;
            $ret['msg']['media_pesan']      = 'file media_pesan Tidak ditemukan';
            $mediaPesan = '';
        }


        if ($checkRelawan == 'SELECTED') {
            //insert penerima admin
            if (is_array($relawan)) {
                $dr = array();
                $qRelawan = $this->db->where_in('id', $relawan)->get('data_relawan');
                foreach ($qRelawan->result() as $r) {
                    $dt = array();
                    $dt['to_number']    = $r->no_wa;
                    $dt['body_text']    = $pesan;
                    $dt['wa_center_id'] = $wacenterID;
                    $dt['media_pesan']  = $mediaPesan;
                    $dt['createdby']    = $this->UID;
                    $dt['status_que']   = 1;
                    $dt['sender_number'] = isset($noWa) ? $noWa : 'notset';
                    $dt['jenis_cron'] = 'wadm';
                    $dr[] = $dt;
                }
                $insertRelawan = $this->EM->insertBatchDb('queue_pesan', $dr);
            }
        } else if ($checkRelawan == 'ALL') {


            if ($ulevel == '1') {
                $qrelawan = $this->db->get('data_relawan');
            } else if ($ulevel == '3') {
                // relawan by caleg
                $qrelawan = $this->EM->getRelawanByCalegID($uid);
            } else if ($ulevel == '4') {
                //relawan by kordapil
                $qrelawan = $this->EM->getRelawanByKordapil($uid);
            } else {
                $qrelawan = false;
            }



            if ($qrelawan->num_rows()) {
                $dr = array();

                foreach ($qrelawan->result() as $relawan) {
                    $dt = array();
                    $dt['to_number']    = $relawan->no_wa;
                    $dt['body_text']    = $pesan;
                    $dt['wa_center_id'] = $wacenterID;
                    $dt['media_pesan']  = $mediaPesan;
                    $dt['createdby']    = $this->UID;
                    $dt['status_que']   = 1;
                    $dt['sender_number'] = isset($noWa) ? $noWa : 'notset';
                    $dt['jenis_cron'] = 'wadm';


                    $dr[] = $dt;
                }
                $insertRelawan = $this->EM->insertBatchDb('queue_pesan', $dr);
            }
        }

        if ($checkKoord == 'SELECTED') {
            // insert penerima koord_relawan
            if (is_array($koord)) {
                $qkoord = $this->db->where_in('id', $koord)->get('data_koord_relawan');
                $dk = array();
                foreach ($qkoord->result() as $k) {
                    $dt = array();

                    $dt['to_number']    = $k->no_wa;
                    $dt['body_text']    = $pesan;
                    $dt['wa_center_id'] = $wacenterID;
                    $dt['media_pesan']  = $mediaPesan;
                    $dt['createdby']    = $this->UID;
                    $dt['status_que']   = 1;
                    $dt['sender_number'] = isset($noWa) ? $noWa : 'notset';
                    $dt['jenis_cron'] = 'wadm';

                    $dk[] = $dt;
                }
                $insertKoord = $this->EM->insertBatchDb('queue_pesan', $dk);
            }
        } else if ($checkKoord == 'ALL') {


            //cek all data_koordinator
            if ($ulevel == '1') {
                $qkoord = $this->db->get('data_koord_relawan');
            } else if ($ulevel == '3') {
                // koordinator by caleg
                $qkoord = $this->EM->getKoordRelawanByCalegID($uid);
            } else if ($ulevel == '4') {
                // koordinator by kordapil
                $qkoord = $this->EM->getKoordRelawanByKordapilID($uid);
            } else {
                $qkoord = false;
            }

            if ($qkoord->num_rows()) {
                $dk = array();
                foreach ($qkoord->result() as $koord) {
                    $dt = array();
                    $dt['to_number']    = $koord->no_wa;
                    $dt['body_text']    = $pesan;
                    $dt['wa_center_id'] = $wacenterID;
                    $dt['media_pesan']  = $mediaPesan;
                    $dt['createdby']    = $this->UID;
                    $dt['status_que']   = 1;
                    $dt['sender_number'] = isset($noWa) ? $noWa : 'notset';
                    $dt['jenis_cron'] = 'wadm';
                    $dk[] = $dt;
                }
                $insertKoord = $this->EM->insertBatchDb('queue_pesan', $dk);
            }
        }

        if ($checkAnggota == 'SELECTED') {
            //insert penerima anggota
            if (is_array($anggota) && count($anggota)) {
                // log_message('debug','count anggota = '.count($anggota));
                $anggotaSelect = json_decode($anggota[0], true);
                // log_message('debug','anggotaSelect = '.print_r($anggotaSelect,true));

                if ($anggotaSelect) {
                    //log_message('user_info','anggotaSelect = '. print_r($anggotaSelect,true));
                    $valID = array();
                    foreach ($anggotaSelect as $val) {
                        $valID[] = $val['id'];
                    }
                    $qanggota = $this->db->where_in('id', $valID)->get('anggota');
                    // log_message('user_info','dbq = '.$this->db->last_query());
                    $da = array();

                    foreach ($qanggota->result() as $a) {
                        $dt = array();
                        $dt['to_number']    = $a->no_wa;
                        $dt['body_text']    = $pesan;
                        $dt['wa_center_id'] = $wacenterID;
                        $dt['media_pesan']  = $mediaPesan;
                        $dt['createdby']    = $this->UID;
                        $dt['status_que']   = 1;
                        $dt['sender_number'] = isset($noWa) ? $noWa : 'notset';
                        $dt['jenis_cron'] = 'wadm';
                        $da[] = $dt;
                    }
                    $insertAnggota = $this->EM->insertBatchDb('queue_pesan', $da);
                }
            }
        } else if ($checkAnggota == 'ALL') {


            if ($ulevel == '1') {
                $qanggota = $this->db->get('anggota');
            } else if ($ulevel == '3') {
                // koordinator by caleg
                $qanggota = $this->EM->getAnggotaByCalegID($uid);
            } else if ($ulevel == '4') {
                // koordinator by kordapil
                $qanggota = $this->EM->getAnggotaByKordapilID($uid);
            } else {
                $qanggota = false;
            }

            if ($qanggota->num_rows()) {
                $da = array();
                foreach ($qanggota->result() as $anggota) {
                    if ($anggota->no_wa) {
                        $dt = array();
                        $dt['to_number']    = $anggota->no_wa;
                        $dt['body_text']    = $pesan;
                        $dt['wa_center_id'] = $wacenterID;
                        $dt['media_pesan']  = $mediaPesan;
                        $dt['createdby']    = $this->UID;
                        $dt['status_que']   = 1;
                        $dt['sender_number'] = isset($noWa) ? $noWa : 'notset';
                        $dt['jenis_cron'] = 'wadm';
                    }
                    $da[] = $dt;
                }
                $insertAnggota = $this->EM->insertBatchDb('queue_pesan', $da);
            }
        }

        $ret['status']              = true;
        $ret['data_pesan']          =  'data pesan berhasil disimpan';
        $ret['penerima_koord']      = isset($insertKoord) ? $insertKoord : 0;
        $ret['penerima_relawan']    = isset($insertRelawan) ? $insertRelawan : 0;
        $ret['penerima_anggota']    = isset($insertAnggota) ? $insertAnggota : 0;

        $ret['jumlah_penerima'] = $ret['penerima_koord'] + $ret['penerima_anggota'] + $ret['penerima_relawan'];


        $ret['msg'] = 'Jumlah Penerima Pesan = ' . $ret['jumlah_penerima'];
        $this->jsonOut($ret);
    }


    public function verify()
    {
    }

    public function select_jenjang_kelas($unitID)
    {
        if ($unitID) {
            echo $this->selectoption->selectJenjangKelas($unitID);
        }
    }


    public function _generateNoreg($id)
    {
        //PSB22040101
        $noreg = "PSB" . date('ymd') . $id;
        return $noreg;
    }

    private function _upload_images($fieldName, $name, $folder, $ovr = true, $ext = 'jpg|JPG|png|PNG', $maxSize = 2500, $maxWidth = 4500, $maxHeight = 4500)
    {
        //$userId = $this->session->userdata('userId');
        //$noref = $this->input->post('noref');
        $config = array();
        $config['upload_path']          = $this->AppDoc . $folder . '/';
        $config['allowed_types']        = $ext;
        $config['max_size']             = $maxSize; //set max size allowed in Kilobyte
        $config['max_width']            = $maxWidth; // set max width image allowed
        $config['max_height']           = $maxHeight; // set max height allowed
        $config['file_name']            = $fieldName . '_' . $name;
        $config['file_ext_tolower']     = TRUE;

        $this->load->library('upload', $config, $fieldName); // Create custom object for foto upload
        $this->$fieldName->initialize($config);
        $this->$fieldName->overwrite = $ovr;

        //upload and validate
        if ($this->$fieldName->do_upload($fieldName)) {
            $res['filename'] = $this->$fieldName->data('file_name');
            $res['error']    = '';
            $res['status']   = true;
        } else {
            $res['error']    =  $this->$fieldName->display_errors('<p class="text-danger">', '</p>');
            $res['filename'] = '';
            $res['status']   = false;
        }
        return $res;
    }


    public function selectidevent()
    {
        $table = 'data_event';
        $val = 'id';
        $text = 'nama_event';
        echo $this->selectoption->selectStd($table, $val, $text);
    }

    public function wa_template($idEvent = null)
    {
        if ($idEvent > 0) {
            $q = $this->db->get_where('data_event', array('id' => $idEvent));
            if ($q->num_rows()) {
                $res = $q->row();
                $ret['status'] = true;
                $ret['teks'] = $res->template_wa;
            } else {
                $ret['status'] = false;
            }
        } else {
            $ret['status'] = true;
        }

        $this->jsonOut($ret);
    }

    public function select_wacenter()
    {
        $uid    = $this->UID;
        $ulevel = $this->ULEVEL;

        $this->db->select(" b.id , b.no_wa, a.id_akun_caleg, a.kordapil_akun_id, c.nama FROM konfigurasi a LEFT JOIN wa_center b ON a.wa_center_id = b.id LEFT JOIN user_akun c ON a.id_akun_caleg = c.id ", false);
        if ($ulevel == '1') {
        } elseif ($ulevel == '3') {
            $this->db->where('a.id_akun_caleg', $uid);
        } elseif ($ulevel == '4') {
        } else {
            $this->db->where('1', '0');
        }

        $q = $this->db->get();


        if ($q->num_rows()) {
            $ret = '';

            foreach ($q->result() as $v) {
                $ret .= '<option value="' . $v->id . '">[' . $v->nama . '] ' . $v->no_wa . '</option>';
            }
        } else {
            $ret = '<option value="">--N/A--</option>';
        }

        echo $ret;
    }

    public function selectkoordrelawan($waCenterID = '0')
    {
        $uid = $this->UID;
        $ulevel = $this->ULEVEL;

        $q = $this->db->select("  a.id, b.nama, a.caleg_akun_id, c.kordapil_akun_id , c.wa_center_id FROM data_koord_relawan a LEFT JOIN user_akun b on a.akun_id = b.id LEFT JOIN konfigurasi c ON a.caleg_akun_id = c.id_akun_caleg ", false)->where('c.wa_center_id', $waCenterID)->group_by('a.id')->get();

        /* if ($ulevel == '1') {
            $q = $this->db->get();
        } else if ($ulevel == '3') {
            $q = $this->db->where('a.caleg_akun_id', $uid)->get();
        } else if ($ulevel == '4') {
            $q = $this->db->where('c.kordapil_akun_id', $uid)->get();
        } */


        if ($q->num_rows()) {
            $ret = '';

            foreach ($q->result() as $v) {
                $ret .= '<option value="' . $v->id . '">[' . $v->id . '] ' . $v->nama . '</option>';
            }
        } else {
            $ret = '<option value="">--N/A--</option>';
        }

        echo $ret;
    }

    public function selectrelawan($waCenterID = '0')
    {
        $uid = $this->UID;
        $ulevel = $this->ULEVEL;

        $q = $this->db->select("   a.id , a.nama_relawan, b.caleg_akun_id, c.kordapil_akun_id, c.wa_center_id FROM data_relawan a LEFT JOIN data_koord_relawan b ON a.koord_akun_id = b.akun_id LEFT JOIN konfigurasi c ON b.caleg_akun_id = c.id_akun_caleg ", false)->where('c.wa_center_id', $waCenterID)->group_by('a.id')->get();


        /* if ($ulevel == '1') {
            $q = $this->db->get();
        } else if ($ulevel == '3') {
            $q = $this->db->where('b.caleg_akun_id', $uid)->get();
        } else if ($ulevel == '4') {
            $q = $this->db->where('c.kordapil_akun_id', $uid)->get();
        } */

        if ($q->num_rows()) {
            $ret = '';

            foreach ($q->result() as $v) {
                $ret .= '<option value="' . $v->id . '">[' . $v->id . '] ' . $v->nama_relawan . '</option>';
            }
        } else {
            $ret = '<option value="">--N/A--</option>';
        }

        echo $ret;
    }

    public function selectanggota()
    {
        $uid = $this->UID;
        $ulevel = $this->ULEVEL;
        $tingkatCaleg = '';
        /*  if ($ulevel == '3') {
            $cekTingkatCaleg = $this->EM->getTingkatPemilihanByCalegID($uid);
            if ($cekTingkatCaleg->num_rows()) {
                $row = $cekTingkatCaleg->row();
                $tingkatCaleg = $row->tingkat_pemilihan_id;
            }
        } */
        $waCenter = $this->input->post('wacenter');
        $filter = $this->input->post('filter');
        /*  $q = ' a.id, a.relawan_id, a.kota, a.kec, a.nama as nama_anggota, b.nama as kabupaten, c.nama as kecamatan, e.nama_relawan, f.koord_akun_id, h.id_akun_caleg, h.kordapil_akun_id FROM anggota a LEFT JOIN kabupaten b ON a.kota = b.kode LEFT JOIN kecamatan c on a.kec = c.kode LEFT JOIN data_relawan e on a.relawan_id = e.id LEFT JOIN data_relawan f ON a.relawan_id = f.id LEFT JOIN data_koord_relawan g ON f.koord_akun_id = g.akun_id LEFT JOIN konfigurasi h ON g.caleg_akun_id = h.id_akun_caleg '; */

        $findTingkatPemilihan = $this->db->select(' b.tingkat_pemilihan_id, a.id_akun_caleg FROM konfigurasi a LEFT JOIN data_dapil b ON a.dapil_id = b.id ', false)->where('a.wa_center_id', $waCenter)->get();

        if ($findTingkatPemilihan->num_rows()) {
            $row = $findTingkatPemilihan->row();
            $tingkat = $row->tingkat_pemilihan_id;
            if ($tingkat == '1') {
                $this->db->select(' a.id, a.nik, a.nama, a.no_wa, a.propinsi as prop, a.kec, a.kota, a.desa, b.nama as namadesa , b.propinsi, b.kabupaten, b.kecamatan, c.nama_relawan, a.caleg_akun_id   from anggota_ri a', false);
            } else if ($tingkat == '2') {
                $this->db->select(' a.id, a.nik, a.nama, a.no_wa, a.propinsi as prop, a.kec, a.kota, a.desa, b.nama as namadesa , b.propinsi, b.kabupaten, b.kecamatan, c.nama_relawan , a.caleg_akun_id  FROM anggota_prop a', false);
            } else if ($tingkat == '3') {
                $this->db->select(' a.id, a.nik, a.nama, a.no_wa, a.propinsi as prop, a.kec, a.kota, a.desa, b.nama as namadesa , b.propinsi, b.kabupaten, b.kecamatan, c.nama_relawan , a.caleg_akun_id FROM anggota_kota a', false);
            } else {
                $this->db->select('0 from anggota a', false);
            }
            $this->db->join('desa b', 'a.desa = b.kode', 'left');
            $this->db->join('data_relawan c', 'a.relawan_id = c.id', 'left');
            $this->db->where('a.caleg_akun_id', $row->id_akun_caleg);

            //$filter 1 = relawan, 2= kecamatan, 3 = kabupaten
            // $this->db->select($q, false);
            /*   if ($ulevel == '1') {
            } else if ($ulevel == '3') {
                $this->db->where('h.id_akun_caleg', $uid);
            } else if ($ulevel == '4') {
                $this->db->where('h.kordapil_akun_id', $uid);
            } */



            if ($filter == 1) {
                $query = $this->db->order_by('a.relawan_id', 'ASC')->get();
                $totalRows = $query->num_rows();
                $dt = array();
                $d = array();
                $dg = array();
                $count = 0;

                $groupName = '';

                foreach ($query->result() as $val) {
                    $count++;
                    if ($groupName == '') {
                        //start first loop 
                        $groupName = $val->nama_relawan;
                        $dg['groupName'] = $val->nama_relawan;
                        $d['nama'] = $val->nama;
                        $d['id'] = $val->id;
                        $d['selected'] = false;
                        $dg['groupData'][] = $d;
                    } else {
                        //next loop
                        if ($groupName == $val->nama_relawan) {

                            $d['nama'] = $val->nama;
                            $d['id'] = $val->id;
                            $d['selected'] = false;
                            $dg['groupData'][] = $d;
                        } else {
                            //$dg['groupData'][] = $d;
                            $dt[] = $dg;
                            $dg = array();
                            $d = array();

                            $groupName = $val->nama_relawan;
                            $dg['groupName'] = $val->nama_relawan;
                            $d['nama'] = $val->nama;
                            $d['id'] = $val->id;
                            $d['selected'] = false;
                            $dg['groupData'][] = $d;
                        }
                    }

                    if ($count == $totalRows) {
                        $dt[] = $dg;
                    }
                }
            } elseif ($filter == 2) {
                $query = $this->db->order_by('b.kecamatan', 'ASC')->get();
                $totalRows = $query->num_rows();
                $dt = array();
                $d = array();
                $dg = array();
                $count = 0;

                $groupName = '';

                foreach ($query->result() as $val) {
                    $count++;
                    if ($groupName == '') {
                        //start first loop 
                        $groupName = $val->kecamatan;
                        $dg['groupName'] = $val->kecamatan;
                        $d['nama'] = $val->nama;
                        $d['id'] = $val->id;
                        $d['selected'] = false;
                        $dg['groupData'][] = $d;
                    } else {
                        //next loop
                        if ($groupName == $val->kecamatan) {

                            $d['nama'] = $val->nama;
                            $d['id'] = $val->id;
                            $d['selected'] = false;
                            $dg['groupData'][] = $d;
                        } else {
                            //$dg['groupData'][] = $d;
                            $dt[] = $dg;
                            $dg = array();
                            $d = array();

                            $groupName = $val->kecamatan;
                            $dg['groupName'] = $val->kecamatan;
                            $d['nama'] = $val->nama;
                            $d['id'] = $val->id;
                            $d['selected'] = false;
                            $dg['groupData'][] = $d;
                        }
                    }

                    if ($count == $totalRows) {
                        $dt[] = $dg;
                    }
                }
            } elseif ($filter == 3) {
                $query = $this->db->order_by('b.kabupaten', 'ASC')->get();
                $totalRows = $query->num_rows();
                $dt = array();
                $d = array();
                $dg = array();
                $count = 0;
                log_message('user_info', 'order by kota : ' . $this->db->last_query());
                $groupName = '';

                foreach ($query->result() as $val) {
                    $count++;
                    if ($groupName == '') {
                        //start first loop 
                        $groupName = $val->kabupaten;
                        $dg['groupName'] = $val->kabupaten;
                        $d['nama'] = $val->nama;
                        $d['id'] = $val->id;
                        $d['selected'] = false;
                        $dg['groupData'][] = $d;
                    } else {
                        //next loop
                        if ($groupName == $val->kabupaten) {

                            $d['nama'] = $val->nama;
                            $d['id'] = $val->id;
                            $d['selected'] = false;
                            $dg['groupData'][] = $d;
                        } else {
                            //$dg['groupData'][] = $d;
                            $dt[] = $dg;
                            $dg = array();
                            $d = array();

                            $groupName = $val->kabupaten;
                            $dg['groupName'] = $val->kabupaten;
                            $d['nama'] = $val->nama;
                            $d['id'] = $val->id;
                            $d['selected'] = false;
                            $dg['groupData'][] = $d;
                        }
                    }

                    if ($count == $totalRows) {
                        $dt[] = $dg;
                    }
                }
            } else {
            }


            $ret['status'] = true;

            $ret['data'] = $dt;
        } else {
            // tingkat pemilihan belum ditentukan


            $ret['status'] = false;
            $ret['data'] = null;
            $ret['msg'] = 'tingkat pemilihan belum ditentukan untuk Wa Center yang dipilih';
        }


        $this->jsonOut($ret);
    }
}

/* End of file Daftar_awal.php */
/* Location: ./application/modules/pendaftaran/controllers/Daftar_awal.php */
