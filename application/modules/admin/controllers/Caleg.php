<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Caleg extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model', 'AM');
        $this->load->library('encryption');
        $this->load->library('SelectOption');
        $this->load->library('parser');


        $this->UID  ? '' : $this->logOut();
    }

    private function _theme($data)
    {

        $data['libjs']          = jsbyEnv(array('libDataTables', 'libStandardCrud', 'libDataCaleg'));
        $data['libcss']         = '';
        $data['pjs']            = jsArray(array('bs4-datatables', 'select2', 'moment2.24', 'daterangepicker', 'lightbox', 'dual-listbox'));
        $data['pcss']           = cssArray(array('datatables', 'select2', 'daterangepicker', 'dual-listbox', 'dual-listbox-icon'));
        //$data['menu'] 		= 'admin/sideMenu';

        $this->theme->dashboard_theme($data);
    }

    // List all your items

    // List all your items
    public function index()
    {

        $ulevel = $this->ULEVEL;

        if ($ulevel == '1') {

            $data['konten'] = 'konfigurasiKonten';
            $data['libcss'] = '';
            $data['headDataCaleg'] = headTableCaleg('data_caleg');
            $this->_theme($data);
        } else if ($ulevel == '4') {
            $data['konten'] = 'konfigurasiKonten';
            $data['libcss'] = '';
            $data['headDataCaleg'] = headTableCaleg('data_caleg');
            $this->_theme($data);
        } else {
            $this->logOut();
        }
    }


    //tampilkan  table data caleg
    //masing2 caleg punya konfigurasi sendiri


    public function table_data_caleg()
    {
        $genderArr = array('M' => 'Laki-laki', 'F' => 'Perempuan');
        $tingkatArray = array('1' => 'DPR RI', '2' => 'DPR PROPINSI', '3' => 'DPR KOTA/KABUPATEN');
        $table        = 'konfigurasi';
        $col_order    = array('a.id');
        $col_search   = array('a.nama_caleg', 'a.wa_center_id', 'b.nama_partai');
        $order        = array('a.id' => 'ASC');
        $query        = " a.id, a.id_akun_caleg, f.nama as nama_caleg, a.id_partai,a.dapil_id, a.parent_caleg_id, a.nomor_urut,wa_center_id, a.wa_template, a.small_logo, a.full_logo, c.nama_dapil, c.jumlah_tps, c.jumlah_dpt, b.nama_partai, d.no_wa, e.nama_tingkat FROM konfigurasi a LEFT JOIN partai b on a.id_partai = b.id LEFT JOIN data_dapil c on a.dapil_id = c.id LEFT JOIN wa_center d ON a.wa_center_id = d.id LEFT JOIN tingkat_pemilihan e ON c.tingkat_pemilihan_id = e.id LEFT JOIN user_akun f ON a.id_akun_caleg = f.id ";

        $uid    = $this->UID;
        $ulevel = $this->ULEVEL;
        if ($ulevel == '1') {
            $filter       = array();
        } else if ($ulevel == '4') {
            $filter       = array('a.kordapil_akun_id' => $uid);
        }

        //get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
        $list  = $this->AM->get_datatables($table, $col_order, $col_search, $order, $query, $filter);
        $data  = array();
        $no    = $_POST['start'];
        foreach ($list as $da) {
            $no++;
            $row   = array();
            $row[] = '<input type="checkbox" class="data-check" value="' . $da->id . '">';
            $row[] = $no;
            $row[] = $da->nama_caleg;
            $row[] = (isset($da->nama_tingkat) ? $da->nama_tingkat : '-') . ' / [Nomor Urut: #' . (int)$da->nomor_urut . ']';
            $row[] = $da->nama_partai;
            $row[] = (int)$da->jumlah_dpt . '/' . (int)$da->jumlah_tps;
            $row[] = $da->no_wa;



            $imgFolder  = base_url("AppDoc/konfig/");

            $smallLogo    = (file_exists($this->AppDoc . 'konfig/' . $da->small_logo) && $da->small_logo) ? $da->small_logo : 'no-image.png';
            $fullLogo     = (file_exists($this->AppDoc . 'konfig/' . $da->full_logo) && $da->full_logo) ? $da->full_logo : 'no_foto.png';


            $row[] = lightbox($imgFolder . $smallLogo, '', 'Small Logo') . lightbox($imgFolder . $fullLogo, '', 'Full Logo');


            $row[] = actionBtnRelawan($da->id, 'data_caleg');


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->AM->countAllQueryFiltered($query, $filter),
            "recordsFiltered" => $this->AM->count_filtered($query, $filter),
            "data" => $data,
        );
        //output to json format
        $this->jsonOut($output);
    }

    public function add_data_caleg()
    {
        $this->form_validation->set_rules($this->AM->dataKonfigurasiRules('add'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {

            $id = $this->input->post('id');

            $data['kordapil_akun_id']   = $this->input->post('kordapil_akun_id');
            $data['id_akun_caleg']      = $this->input->post('id_akun_caleg');
            $data['id_partai']          = $this->input->post('id_partai');
            $data['nomor_urut']         = $this->input->post('nomor_urut');
            $data['wa_caleg']           = $this->input->post('wa_caleg');
            $data['dapil_id']           = $this->input->post('dapil_id');
            $data['target_anggota']     = $this->input->post('target_anggota');
            $data['wa_center_id']       = $this->input->post('wa_center_id');
            $data['wa_template']        = $this->input->post('wa_template');
            $data['template_ultah']     = $this->input->post('template_ultah');


            $ultah = $this->input->post('ultah_enable');

            if ($ultah == 'on') {

                $data['ultah_enable'] = 1;
            } else {

                $data['ultah_enable'] = 0;
            }

            //$data['small_logo']         = $this->input->post('small_logo');
            //$data['full_logo']          = $this->input->post('full_logo');

            $data['last_update']        = date('Y-m-d H:i:s');

            /* $propdapil['prop_dapil']    = $this->input->post('prop_dapil');

            $kabdapil = $this->input->post('kab_dapil');
            $kecdapil = $this->input->post('kec_dapil'); */

            $imageFolder = 'konfig';


            if (!empty($_FILES['small_logo']['name'])) {
                $filename = 'small_logo_' . uniqid();
                $uplod_foto = $this->_upload_images('small_logo', $filename, $imageFolder);
                if ($uplod_foto['status']) {
                    $data['small_logo']         = $uplod_foto['filename'];
                    $ret['status_small_logo']   = true;
                } else {
                    $ret['msg']['small_logo'] = $uplod_foto['error'];
                    $ret['status_small_logo'] = false;
                }
            } else {
                $ret['status_small_logo']       = false;
                $ret['msg']['small_logo']       = 'small_logo Tidak ditemukan';
            }


            if (!empty($_FILES['full_logo']['name'])) {
                $filename = 'full_logo_' . uniqid();
                $uplod_foto = $this->_upload_images('full_logo', $filename, $imageFolder);

                if ($uplod_foto['status']) {
                    $data['full_logo']          = $uplod_foto['filename'];
                    $ret['status_full_logo']    = true;
                } else {
                    $ret['msg']['foto']         = $uplod_foto['error'];
                    $ret['status_full_logo']    = false;
                }
            } else {
                $ret['status_small_logo']           = false;
                $ret['msg']['status_full_logo']     = 'full_logo Tidak ditemukan';
            }

            $insert = $this->AM->insertDb('konfigurasi', $data, $id);


            if ($insert) {

                /*if(is_array($kabdapil) && count($kabdapil)){
                            $kab = array();

                            foreach ($kabdapil as $val) {
                               
                                $d['caleg_id']  = $id ? $id : $insert;
                                $d['kab_kode'] = $val;

                                $kab[] = $d;
                            }

                               if($id){
                                    $deleteKab = $this->AM->bulkDeleteKey('kab_dapil', 'caleg_id', $id); 
                               }
                               

                               $insertKab = $this->db->insert_batch('kab_dapil', $kab);
                    }
                   
                    if (is_array($kecdapil) && count($kecdapil) > 0 ) {
                           $kec = array();
                           //log_message('debug','$kecdapil = '.print_r($kecdapil,true));
                          // log_message('debug', '$kecdapil = '. print_r( json_decode($kecdapil[0],true), true) );
                           $KecDapil = json_decode($kecdapil[0],true);
                           if($KecDapil){
                                 foreach($KecDapil as $value){
                                    $dt['caleg_id']   = $id ? $id : $insert;
                                    $dt['kec_kode']    = $value['kode'];
                                        $kec[] = $dt;
                                   }
                                    if($id){

                                            $deleteKab = $this->AM->bulkDeleteKey('kec_dapil', 'caleg_id', $id);
                                    }
                                   $insertKec = $this->db->insert_batch('kec_dapil', $kec);
                           }
                          
                    }*/

                $ret['status'] = true;
                $ret['msg'] = "Data berhasil disimpan";


                //$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
            } else {
                $ret['status']  = false;
                $ret['msg']     =  "proses simpan data gagal";
            }
        }


        $this->jsonOut($ret);
    }

    public function table_konfigurasi()
    {
        $uid = $this->UID;
        $ulevel = $this->ULEVEL;

        $table        = 'konfigurasi';
        $col_order    = array('a.id');
        $col_search   = array('a.nama', 'a.nik', 'a.no_wa');
        $order        = array('a.id' => 'ASC');
        $query        = " a.id, a.nik, a.nama, a.pob, a.dob, a.gender, a.alamat, a.no_wa, a.scan_ktp, a.foto, a.createdby, b.nama as propinsi , c.nama as kota, d.nama as kec, e.nama as desa FROM anggota a 
                        LEFT JOIN propinsi b on a.propinsi = b.kode LEFT JOIN kabupaten c on a.kota = c.kode 
                        LEFT JOIN kecamatan d on a.kec = d.kode LEFT JOIN desa e ON a.desa = e.kode ";
        if ($ulevel == '1') {
            $filter       = array();
        } else if ($ulevel == '4') {
            $filter       = array('a.kordapil_akun_id' => $uid);
        }



        //get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
        $list  = $this->AM->get_datatables($table, $col_order, $col_search, $order, $query, $filter);
        $data  = array();
        $no    = $_POST['start'];
        foreach ($list as $da) {
            $no++;
            $row   = array();
            $row[] = '<input type="checkbox" class="data-check" value="' . $da->id . '">';
            $row[] = $no;
            $row[] = $da->nik;
            $row[] = $da->nama;
            $row[] = $da->pob . '/' . date('d-m-Y', strtotime($da->dob));
            $row[] = $da->gender;
            $row[] = $da->alamat . '<br> Kel.:' . $da->desa . '<br> Kec.:' . $da->kec . '<br> Kab./Kota:' . $da->kota . '<br> Prop.:' . $da->propinsi;
            $row[] = $da->no_wa;
            $imgFolder = base_url("AppDoc/anggota/");
            $row[] = lightbox($imgFolder . $da->scan_ktp, '', 'Scan KTP');
            $row[] = lightbox($imgFolder . $da->foto, '', 'Foto');
            $row[] = actionBtn3($da->id, 'anggota');


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->PM->countAllQueryFiltered($query, $filter),
            "recordsFiltered" => $this->PM->count_filtered($query, $filter),
            "data" => $data,
        );
        //output to json format
        $this->jsonOut($output);
    }

    public function edit_data_caleg($id)
    {
        $query = $this->AM->getDataCalegByID($id);
        if ($query->num_rows()) {
            $ret['status'] = true;
            $ret['data'] = $query->row();
            $ret['ultah'] = $this->config->item('whatsapp_ultah');
        } else {
            $ret['status'] = false;
            $ret['data'] = '';
        }
        $this->jsonOut($ret);
    }

    public function delete_data_caleg()
    {
        /* $ret['status'] = false;
        $ret['msg'] = 'Fitur dalam proses perbaikan';
        $this->jsonOut($ret);
        exit(); */
        // untuk menghindari salah delete dan memudahkan pengecekan anggota, maka bulkdelete di tiadakan
        // sebelum dihapus cek dulu apakah caleg masih memiliki anggota
        $confirm = $this->input->post('confirm');
        // tentukan tingkat caleg by id
        $konfigID = $this->input->post('id');
        $this->db->trans_start();
        $getDataCaleg = $this->AM->getDataCalegByID($konfigID);
        if ($getDataCaleg->num_rows()) {
            $calegRow = $getDataCaleg->row();
            $id = $calegRow->id_akun_caleg;
        } else {
            $id = 0;
        }
        $tingkat = $this->AM->getTingkatPemilihanByCalegID($id);
        if ($tingkat->num_rows()) {
            $t = $tingkat->row();
            $tingkatPemilihan = $t->tingkat_pemilihan_id;
            log_message('user_info', 'tingkat caleg : ' . $tingkatPemilihan);
            /*
                   UPDATE data_pilihan_caleg a 
                    LEFT JOIN anggota_kota b ON a.anggota_id = b.id 
                    SET a.relawan_id_kota = 0 , a.createdby_kota = 0
                    WHERE b.caleg_akun_id = 165;
                   */

            if ($tingkatPemilihan == 1) {
                $getAnggota = $this->db->get_where('anggota_ri', array('caleg_akun_id' => $id));
                if ($getAnggota->num_rows()) {
                    $this->db->query(" UPDATE data_pilihan_caleg a 
                    LEFT JOIN anggota_ri b ON a.anggota_id = b.id 
                    SET a.relawan_id_ri = 0 , a.createdby_ri = 0
                    WHERE b.caleg_akun_id = " . $id, false);

                    /* $this->db->set('a.relawan_id_ri', 0);
                    $this->db->set('a.createdby_ri', 0);
                    $this->db->from('data_pilihan_caleg a');
                    $this->db->join('anggota_ri b', 'a.anggota_id = b.id', 'left');
                    $this->db->where('b.caleg_akun_id', $id);
                    $this->db->update(); */
                }
            } else if ($tingkatPemilihan == 2) {
                $getAnggota = $this->db->get_where('anggota_propinsi', array('caleg_akun_id' => $id));
                if ($getAnggota->num_rows()) {
                    $this->db->query(" UPDATE data_pilihan_caleg a 
                    LEFT JOIN anggota_propinsi b ON a.anggota_id = b.id 
                    SET a.relawan_id_prop = 0 , a.createdby_prop = 0
                    WHERE b.caleg_akun_id = " . $id, false);
                }
            } else if ($tingkatPemilihan == 3) {
                $getAnggota = $this->db->get_where('anggota_kota', array('caleg_akun_id' => $id));
                if ($getAnggota->num_rows()) {

                    $this->db->query(" UPDATE data_pilihan_caleg a 
                    LEFT JOIN anggota_kota b ON a.anggota_id = b.id 
                    SET a.relawan_id_kota = 0 , a.createdby_kota = 0
                    WHERE b.caleg_akun_id = " . $id, false);
                }
            }
            $this->db->query("DELETE FROM data_relawan WHERE koord_akun_id IN (SELECT akun_id FROM data_koord_relawan WHERE caleg_akun_id = " . $id . ")", false);
            $this->db->query(" DELETE FROM data_koord_relawan WHERE caleg_akun_id =  " . $id, false);

            /* $delete =  $this->db->from('data_koord_relawan a')
                ->join('data_relawan b', 'b.koord_akun_id = a.akun_id', 'left')
                ->join('user_akun c', 'a.akun_id = c.id', 'left')
                ->where('a.caleg_akun_id', $id)
                ->delete('a, b, c'); */

            $deleteKonfig = $this->db->from('konfigurasi')->where('id_akun_caleg', $id)->delete();
            $deleteCalegAkun = $this->db->from('user_akun')->where('id', $id)->delete();
            $this->db->query(" DELETE FROM anggota WHERE id IN (SELECT anggota_id FROM data_pilihan_caleg WHERE relawan_id_ri = 0 AND relawan_id_prop = 0 AND relawan_id_kota = 0) ", false);

            /* $this->db->where_in('id', function ($subquery) {
                $subquery->select('anggota_id')jeffryan
                    ->from('data_pilihan_caleg')
                    ->where('relawan_id_ri', 0)
                    ->where('relawan_id_prop', 0)
                    ->where('relawan_id_kota', 0);
            });

            $this->db->delete('anggota');
 */
            /*
            DELETE a.*, b.*, c.*
            FROM data_koord_relawan a
            LEFT JOIN data_relawan b ON b.koord_akun_id = a.akun_id
            LEFT JOIN user_akun c ON a.akun_id = c.id
            WHERE a.caleg_akun_id = 165;
            */
        } else {
            log_message('user_info', 'tingkat caleg not found');
            log_message('user_info', $this->db->last_query());
        }
        // select anggota by caleg id
        // untuk setiap id anggota (caleg) di table data pilihan caleg set relawan_id = 0 and createdby = 0
        // select relawan dan koord relawan by caleg id , remove akun dan data nya
        // remove konfigurasi caleg di table konfigurasi
        // remove user akun caleg
        // remove id_anggota di table data_pilihan_caleg dan table anggota yang id_relawan nya 0 semua, sekalian jika ada foto dan ktp di unlink

        /* $list_id = $this->input->post('id');
        $table = 'konfigurasi';

        if (is_array($list_id)) {
            if (!empty($list_id)) {
                $del = $this->AM->bulk_delete($table, $list_id);
                if ($del) {
                    $ret['status'] = true;
                    $ret['msg'] = 'Data berhasil dihapus';
                } else {
                    $ret['status'] = false;
                    $ret['msg'] = 'Proses hapus data gagal';
                }
            }
        } elseif ($list_id) {
            $del = $this->AM->delete_by_id($table, $list_id);
            if ($del) {
                $ret['status'] = true;
                $ret['msg'] = 'Data berhasil dihapus';
            } else {
                $ret['status'] = false;
                $ret['msg'] = 'Proses hapus data gagal';
            }
        } else {
            $ret['status'] = false;
            $ret['msg'] = 'Data belum dipilih';
        } */

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            // Transaction failed
            $ret['status'] = false;
            $ret['msg'] = 'Proses hapus data gagal';
        } else {
            // Transaction succeeded
            $ret['status'] = true;
            $ret['msg'] = 'Data berhasil dihapus';
        }


        $this->jsonOut($ret);
    }

    public function get_konfig()
    {
        $query = $this->db->get_where('konfigurasi', array('id' => '1'));
        if ($query->num_rows()) {
            $ret['status'] = true;
            $ret['data'] = $query->row();
            $ret['ultah'] = $this->config->item('whatsapp_ultah');
        } else {
            $ret['status'] = false;
            $ret['data'] = '';
        }
        $this->jsonOut($ret);
    }

    public function reload_dapil($CalegID)
    {
        $propDapil = $this->db->get_where('prop_dapil', array('caleg_id' => $CalegID))->row();

        $kabDapil = $this->db->select(" a.*, b.nama FROM kab_dapil a LEFT JOIN kabupaten b on a.kab_kode = b.kode ", false)->where('a.caleg_id', $CalegID)->get();
        $kab = array();
        foreach ($kabDapil->result() as $val) {
            $kd['id']   = $val->kab_kode;
            $kd['text'] = $val->nama;
            $kab[] = $kd;
        }



        $kecDapil = $this->db->select(" a.*, b.nama, b.kab_kode, b.kabupaten FROM kec_dapil a LEFT JOIN kecamatan b ON a.kec_kode = b.kode ", false)->where('a.caleg_id', $CalegID)->get();


        $dt = array();
        $d = array();
        $dg = array();
        $count = 0;
        $totalRows = $kecDapil->num_rows();
        $groupName = '';

        foreach ($kecDapil->result() as $val) {
            $count++;
            if ($groupName == '') {
                //start first loop 
                $groupName = $val->kabupaten;
                $dg['groupName'] = $val->kabupaten;
                $d['nama'] = $val->nama;
                $d['kode'] = $val->kec_kode;
                $d['selected'] = true;
                $dg['groupData'][] = $d;
            } else {
                //next loop
                if ($groupName == $val->kabupaten) {

                    $d['nama'] = $val->nama;
                    $d['kode'] = $val->kec_kode;
                    $d['selected'] = true;
                    $dg['groupData'][] = $d;
                } else {
                    //$dg['groupData'][] = $d;
                    $dt[] = $dg;
                    $dg = array();
                    $d = array();

                    $groupName = $val->kabupaten;
                    $dg['groupName'] = $val->kabupaten;
                    $d['nama'] = $val->nama;
                    $d['kode'] = $val->kec_kode;
                    $d['selected'] = true;
                    $dg['groupData'][] = $d;
                }
            }

            if ($count == $totalRows) {
                $dt[] = $dg;
            }
        }
        // $ret['data'] = $dt;
        //$ret['count'] = $count;



        $ret['status'] = true;
        $ret['propDapil'] = $propDapil->prop_dapil;
        $ret['kabDapil'] = $kab;
        $ret['kecDapil'] = $dt;

        $this->jsonOut($ret);
    }



    private function _upload_images($fieldName, $name, $folder, $ovr = true, $ext = 'jpg|JPG|jpeg|JPEG|png|PNG', $maxSize = 2500, $maxWidth = 4500, $maxHeight = 4500)
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

    public function select_caleg()
    {

        echo $this->selectoption->selectCalegAkun();
    }

    public function selectpartai()
    {
        $table  = 'partai';
        $val    = 'id';
        $text   = 'nama_partai';

        echo $this->selectoption->selectStd($table, $val, $text);
    }

    public function selectkordapil()
    {
        $uid    = $this->UID;
        $ulevel = $this->ULEVEL;
        $unama  = $this->UNAME;
        if ($ulevel == '1') {
            //select all koord dapil
            echo $this->selectoption->selectAllKoordDapil();
        } else if ($ulevel == '4') {
            //select only this user
            echo '<option value="' . $uid . '" selected> ' . $unama . ' </option>';
        } else {
            //select none;
        }
    }

    public function select_wa_center()
    {
        $table  = 'wa_center';
        $val    = 'id';
        $text   = 'no_wa';

        echo $this->selectoption->selectStd($table, $val, $text);
    }

    public function selectdapil($id)
    {


        echo $this->selectoption->selectDataDapil($id);
    }
    public function data_dapil($id = 0)
    {

        $q = $this->AM->getDataDapilByID($id);
        if ($q->num_rows()) {
            $row = $q->row();
            $ret['status'] = true;
            $ret['data']['jumlahDPT'] = (int) $row->jumlah_dpt;
            $ret['data']['jumlahTPS'] = (int) $row->jumlah_tps;
        } else {
            $ret['status'] = false;
            $ret['msg'] = 'no data found';
        }

        $this->jsonOut($ret);
    }

    public function selectKabDapil()
    {
        $prop = $this->input->post('prop_dapil');
        if ($prop) {
            $q = $this->db->get_where('kecamatan', array('prop_id' => $prop));
            if ($q->num_rows()) {
                $dt     = array();
                $d      = array();
                $dg     = array();
                $count  = 0;
                $totalRows = $q->num_rows();

                $groupName = '';
                foreach ($q->result() as $val) {
                    $count++;
                    if ($groupName == '') {
                        //start first loop 
                        $groupName = $val->kabupaten;
                        $dg['groupName'] = $val->kabupaten;
                        $d['nama'] = $val->nama;
                        $d['kode'] = $val->kode;
                        $dg['groupData'][] = $d;
                    } else {
                        //next loop
                        if ($groupName == $val->kabupaten) {

                            $d['nama'] = $val->nama;
                            $d['kode'] = $val->kode;
                            $dg['groupData'][] = $d;
                        } else {
                            //$dg['groupData'][] = $d;
                            $dt[] = $dg;
                            $dg = array();
                            $d = array();

                            $groupName = $val->kabupaten;
                            $dg['groupName'] = $val->kabupaten;
                            $d['nama'] = $val->nama;
                            $d['kode'] = $val->kode;
                            $dg['groupData'][] = $d;
                        }
                    }

                    if ($count == $totalRows) {
                        $dt[] = $dg;
                    }
                }


                $ret['data'] = $dt;
                $ret['count'] = $count;
            } else {
                //prop id not found;
            }
        } else {
            // prop ID not found;
        }
        $this->jsonOut($ret);
    }


    public function selectKecDapil()
    {
        $kab = $this->input->post('kab_dapil');

        if (is_array($kab)) {
            $q = $this->db->where_in('kab_kode', $kab)->get('kecamatan');
            if ($q->num_rows()) {
                $ret['status'] = true;
                $dt = array();
                $d = array();
                $dg = array();
                $count = 0;
                $totalRows = $q->num_rows();
                $groupName = '';
                foreach ($q->result() as $val) {
                    $count++;
                    if ($groupName == '') {
                        //start first loop 
                        $groupName = $val->kabupaten;
                        $dg['groupName'] = $val->kabupaten;
                        $d['nama'] = $val->nama;
                        $d['kode'] = $val->kode;
                        $dg['groupData'][] = $d;
                    } else {
                        //next loop
                        if ($groupName == $val->kabupaten) {

                            $d['nama'] = $val->nama;
                            $d['kode'] = $val->kode;
                            $dg['groupData'][] = $d;
                        } else {
                            //$dg['groupData'][] = $d;
                            $dt[] = $dg;
                            $dg = array();
                            $d = array();

                            $groupName = $val->kabupaten;
                            $dg['groupName'] = $val->kabupaten;
                            $d['nama'] = $val->nama;
                            $d['kode'] = $val->kode;
                            $dg['groupData'][] = $d;
                        }
                    }

                    if ($count == $totalRows) {
                        $dt[] = $dg;
                    }
                }
                $ret['data'] = $dt;
                $ret['count'] = $count;
            } else {
                $ret = '';
            }
        } else {
            $ret = '';
        }
        $this->jsonOut($ret);
    }
}

/* End of file Konfigurasi.php */
/* Location: ./application/modules/admin/controllers/Konfigurasi.php */
