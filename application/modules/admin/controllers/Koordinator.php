<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Koordinator extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model', 'PM');
        $this->load->library('SelectOption');
    }

    private function _theme($data)
    {

        $data['libjs']          = jsbyEnv('libKoordRelawan');
        $data['libcss']         = '';
        $data['pjs']            = jsArray(array('bs4-datatables', 'select2', 'moment2.24', 'daterangepicker', 'lightbox'));
        $data['pcss']           = cssArray(array('datatables', 'select2', 'daterangepicker'));
        //$data['menu'] 		= 'admin/sideMenu';

        $this->theme->dashboard_theme($data);
    }

    // List all your items
    public function index()
    {
        $data['konten'] = 'dataKoordRelawan';
        $data['libcss'] = '';
        $data['headDataRelawan'] = head_tbl_btn2('koord_relawan', false);
        $this->_theme($data);
    }

    public function table_koord_relawan()
    {
        $genderArr = array('M' => 'Laki-laki', 'F' => 'Perempuan');
        $ulevel = $this->ULEVEL;
        $UID    = $this->UID;

        $table        = 'data_koord_relawan';
        $col_order    = array('a.id');
        $col_search   = array('f.nama', 'g.nama', 'a.nik', 'b.nama', 'c.nama', 'd.nama', 'e.nama');
        $order        = array('a.id' => 'ASC');
        $query        = " a.id, a.nik, f.nama, g.nama as nama_caleg, a.pob, a.dob, a.gender, a.alamat, a.no_wa, a.scan_ktp, a.foto, b.nama as propinsi, c.nama as kota, d.nama as kec, e.nama as desa, h.kordapil_akun_id from data_koord_relawan a LEFT JOIN propinsi b on a.prop_id = b.kode LEFT JOIN kabupaten c on a.kota_id = c.kode LEFT JOIN kecamatan d on a.kec_id = d.kode LEFT JOIN desa e ON a.desa_id = e.kode LEFT JOIN user_akun f ON a.akun_id = f.id LEFT JOIN user_akun g ON a.caleg_akun_id = g.id LEFT JOIN konfigurasi h ON h.id_akun_caleg = a.caleg_akun_id   ";

        if ($ulevel == '1') {
            $filter  = array();
        } else if ($ulevel == '3') {
            $filter  = array('g.id' => $UID);
        } else if ($ulevel == '4') {
            $filter = array('h.kordapil_akun_id' => $UID);
        } else {
            $filter  = array('1' => '0');
        }


        //get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
        $list  = $this->PM->get_datatables($table, $col_order, $col_search, $order, $query, $filter);
        $data  = array();
        $no    = $_POST['start'];
        foreach ($list as $da) {
            $no++;
            $row   = array();
            $row[] = '<input type="checkbox" class="data-check" value="' . $da->id . '">';
            $row[] = $no;
            $row[] = $da->nik;
            $row[] = $da->nama;
            $row[] = $da->pob . ', ' . date('d-m-Y', strtotime($da->dob));
            $row[] = $da->gender;
            // $row[] = $da->alamat . '<br>' . $da->desa . '<br>' . $da->kec . '<br>' . $da->kota . '<br>' . $da->propinsi;
            $row[] = $da->no_wa;
            $row[] = $da->nama_caleg;
            $imgFolder = base_url("AppDoc/relawan/");

            $ktp    = is_file($this->AppDoc . 'relawan/' . $da->scan_ktp) ? $da->scan_ktp : 'no-image.png';
            $foto   = is_file($this->AppDoc . 'relawan/' . $da->foto) ? $da->foto : 'no_foto.png';

            $row[] = lightbox($imgFolder . $ktp, '', 'Scan KTP');
            $row[] = lightbox($imgFolder . $foto, '', 'Foto');


            $row[] = actionBtn3($da->id, 'koord_relawan');


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


    // Add a new item
    public function add_koord_relawan()
    {
        $this->form_validation->set_rules($this->PM->dataPendaftaranKoordRelawanRules('add'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {

            $data['akun_id']        = $this->input->post('akun_id');
            $data['nik']            = $this->input->post('nik');
            $data['caleg_akun_id']  = $this->input->post('caleg_akun_id');
            $data['pob']            = $this->input->post('pob');
            $data['dob']            = date('Y-m-d', strtotime($this->input->post('dob')));
            $data['gender']         = $this->input->post('gender');
            $data['alamat']         = $this->input->post('alamat');
            $data['prop_id']        = $this->input->post('prop_id');
            $data['kota_id']        = $this->input->post('kota_id');
            $data['kec_id']         = $this->input->post('kec_id');
            $data['desa_id']        = $this->input->post('desa_id');
            $data['no_wa']          = $this->input->post('no_wa');
            $data['last_update']    = date('Y-m-d H:i:s');
            $data['created']        = date('Y-m-d H:i:s');
            $data['createdby']      = $this->session->userdata('uid');


            $imageFolder = 'relawan';


            if (!empty($_FILES['scan_ktp']['name'])) {
                $filename = $this->input->post('nik') . '_' . uniqid();
                $uplod_foto = $this->_upload_images('scan_ktp', $filename, $imageFolder);
                if ($uplod_foto['status']) {
                    $data['scan_ktp'] = $uplod_foto['filename'];
                    $ret['statusScanKtp']    = true;
                } else {
                    $ret['msg']['scan_ktp'] = $uplod_foto['error'];
                    $ret['status'] = false;
                    $uploadError['scan_ktp'] = $uplod_foto['error'];
                    $ret['statusScanKtp']    = false;
                }
            } else {
                $ret['statusScanKtp']       = false;
                $ret['msg']['scan_ktp']     = 'file KTP Tidak ditemukan';
            }


            if (!empty($_FILES['foto']['name'])) {
                $filename = $this->input->post('nik') . '_' . uniqid();
                $uplod_foto = $this->_upload_images('foto', $filename, $imageFolder);
                if ($uplod_foto['status']) {
                    $data['foto'] = $uplod_foto['filename'];
                    $ret['status'] = true;
                } else {
                    $ret['msg']['foto'] = $uplod_foto['error'];
                    $ret['status'] = false;
                    $uploadError['foto'] = $uplod_foto['error'];
                    $ret['statusfoto']    = false;
                }
            } else {
                $ret['status'] = true;
            }

            if ($ret['statusScanKtp']) {
                $insert = $this->PM->save('data_koord_relawan', $data);
                if ($insert) {

                    $ret['status'] = true;
                    $ret['msg'] = "Data berhasil disimpan";


                    //$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
                } else {
                    $ret['status']  = false;
                    $ret['msg']     =  "proses simpan data gagal";
                }
            } else {
                $ret['status']  = false;
                //$ret['msg']     = "Data berhasil disimpan";
            }
        }


        $this->jsonOut($ret);
    }

    public function edit_koord_relawan($id)
    {
        if ($id) {
            $data   = $this->PM->getKoordRelawanByID($id);
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

    //Update one item
    public function update_koord_relawan()
    {
        $id = $this->input->post('id');
        $this->form_validation->set_rules($this->PM->dataPendaftaranKoordRelawanRules('edit'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {

            $data['akun_id']        = $this->input->post('akun_id');
            $data['nik']            = $this->input->post('nik');
            $data['caleg_akun_id']  = $this->input->post('caleg_akun_id');
            $data['pob']            = $this->input->post('pob');
            $data['dob']            = date('Y-m-d', strtotime($this->input->post('dob')));
            $data['gender']         = $this->input->post('gender');
            $data['alamat']         = $this->input->post('alamat');
            $data['prop_id']       = $this->input->post('prop_id');
            $data['kota_id']           = $this->input->post('kota_id');
            $data['kec_id']            = $this->input->post('kec_id');
            $data['desa_id']           = $this->input->post('desa_id');
            $data['no_wa']          = $this->input->post('no_wa');
            $data['last_update']    = date('Y-m-d H:i:s');




            $imageFolder = 'relawan';



            if (!empty($_FILES['scan_ktp']['name'])) {
                $filename = $this->input->post('nik') . '_' . uniqid();
                $uplod_foto = $this->_upload_images('scan_ktp', $filename, $imageFolder);
                if ($uplod_foto['status']) {
                    $data['scan_ktp'] = $uplod_foto['filename'];
                    $ret['statusScanKtp']    = true;
                } else {
                    $ret['msg']['scan_ktp'] = $uplod_foto['error'];
                    $ret['status'] = false;
                    $uploadError['scan_ktp'] = $uplod_foto['error'];
                    $ret['statusScanKtp']    = false;
                }
            } else {
                $ret['statusScanKtp']       = true;
                $ret['msg']['scan_ktp']     = 'file KTP Tidak ditemukan';
            }


            if (!empty($_FILES['foto']['name'])) {
                $filename = $this->input->post('nik') . '_' . uniqid();
                $uplod_foto = $this->_upload_images('foto', $filename, $imageFolder);
                if ($uplod_foto['status']) {
                    $data['foto'] = $uplod_foto['filename'];
                    $ret['status'] = true;
                } else {
                    $ret['msg']['foto'] = $uplod_foto['error'];
                    $ret['status'] = false;
                    $uploadError['foto'] = $uplod_foto['error'];
                    $ret['statusfoto']    = false;
                }
            } else {
                $ret['status'] = true;
            }




            if ($ret['statusScanKtp']) {

                $insert = $this->PM->update('data_koord_relawan', array('id' =>  $id), $data);
                if ($insert) {

                    $ret['status'] = true;
                    $ret['msg'] = "Data berhasil disimpan";


                    //$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
                } else {
                    $ret['status']  = false;
                    $ret['msg']     =  "proses simpan data gagal";
                    log_message('user_info', 'last query = ' . $this->db->last_query());
                }
            } else {
                $ret['status']  = false;
                //$ret['msg']     = "Data berhasil disimpan";
            }
        }




        $this->jsonOut($ret);
    }

    //Delete one item
    public function delete_koord_relawan()
    {
        $ret['status'] = false;
        $ret['msg'] = 'Fitur dalam proses perbaikan';
        /* 
        $data     = $this->input->post('id');
        $table     = 'data_koord_relawan';

        $ret     = $this->DataDelete($table, $data); */

        $this->jsonOut($ret);
    }


    public function verify()
    {
    }



    public function select_akun_koord_relawan()
    {
        $ulevel = $this->ULEVEL;
        $uid    = $this->UID;
        $uname  = $this->UNAME;
        /*
            level 1 admin
            level 3 caleg
            level 4 kordapil
        */
        if ($ulevel == '1') {
            echo $this->selectoption->selectKoordRelawanID();
        } else if ($ulevel == '3') {
            echo $this->selectoption->selectKoordRelawanByCaleg($uid);
        } else if ($ulevel == '4') {
            echo $this->selectoption->selectKoordRelawanByKordapil($uid);
        } else {
        }
    }

    public function select_caleg()
    {
        $ulevel = $this->ULEVEL;
        $uid    = $this->UID;
        $uname  = $this->UNAME;
        /*
            level 1 admin
            level 3 caleg
            level 4 kordapil
        */
        if ($ulevel == '1') {
            echo $this->selectoption->selectCaleg();
        } else if ($ulevel == '3') {
            echo ' <option value="' . $uid . '">[' . $uname . ']</option>';
        } else if ($ulevel == '4') {
            echo $this->selectoption->selectCalegByKordapil($uid);
        } else {
        }
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
}

/* End of file Koordinator.php */
/* Location: ./application/modules/admin/controllers/Koordinator.php */
