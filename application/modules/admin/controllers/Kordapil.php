<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kordapil extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->load->model('Admin_model', 'PM');
        $this->load->library('SelectOption');
    }
    private function _theme($data)
    {

        $data['libjs']          = jsbyEnv('libKordapil');
        $data['libcss']         = '';
        $data['pjs']            = jsArray(array('bs4-datatables', 'select2', 'moment2.24', 'daterangepicker', 'lightbox'));
        $data['pcss']           = cssArray(array('datatables', 'select2', 'daterangepicker'));
        //$data['menu'] 		= 'admin/sideMenu';

        $this->theme->dashboard_theme($data);
    }
    public function index()
    {
        $data['konten'] = 'dataKordapil';
        $data['libcss'] = '';
        $data['headDataKordapil'] = head_tbl_btn2('kordapil', false);
        $this->_theme($data);
    }


    public function table_kordapil()
    {
        $genderArr = array('M' => 'Laki-laki', 'F' => 'Perempuan');
        $ulevel = $this->ULEVEL;
        $UID    = $this->UID;

        $table        = 'data_kordapil';
        $col_order    = array('a.id');
        $col_search   = array('d.nama', 'b.nama_dapil', 'c.nama_tingkat');
        $order        = array('a.id' => 'ASC');
        $query        = " a.*, d.nama, b.nama_dapil, b.tingkat_pemilihan_id, c.nama_tingkat FROM data_kordapil a LEFT JOIN data_dapil b ON b.id = a.dapil_id LEFT JOIN tingkat_pemilihan c ON b.tingkat_pemilihan_id = c.id LEFT JOIN user_akun d ON a.kordapil_akun_id = d.id   ";

        if ($ulevel == '1') {
            $filter  = array();
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
            $row[] = $da->nama . ' <br> [' . $da->no_wa . ']';

            $row[] = '[' . $da->nama_tingkat . '] ' . $da->nama_dapil;

            $imgFolder = base_url("AppDoc/kordapil/");

            $ktp    = file_exists($this->AppDoc . 'kordapil/' . $da->scan_ktp) ? $da->scan_ktp : 'no-image.png';
            $foto   = file_exists($this->AppDoc . 'kordapil/' . $da->foto) ? $da->foto : 'no_foto.png';

            $row[] = lightbox($imgFolder . $ktp, '', 'Scan KTP');
            $row[] = lightbox($imgFolder . $foto, '', 'Foto');


            $row[] = actionBtn3($da->id, 'kordapil');


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
    public function add_kordapil()
    {
        $this->form_validation->set_rules($this->PM->dataKordapilRules('add'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {


            $data['nik']                = $this->input->post('nik');
            $data['kordapil_akun_id']      = $this->input->post('kordapil_akun_id');
            $data['dapil_id']             = $this->input->post('dapil_id');
            $data['no_wa']              = $this->input->post('no_wa');
            $data['last_update']        = date('Y-m-d H:i:s');



            $imageFolder = 'kordapil';


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
                $insert = $this->PM->save('data_kordapil', $data);
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

    public function edit_kordapil($id)
    {
        if ($id) {
            $data   = $this->PM->getKordapilByID($id);
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
    public function update_kordapil()
    {
        $id = $this->input->post('id');
        $this->form_validation->set_rules($this->PM->dataKordapilRules('edit'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {

            $data['nik']                = $this->input->post('nik');
            $data['kordapil_akun_id']      = $this->input->post('kordapil_akun_id');
            $data['dapil_id']             = $this->input->post('dapil_id');
            $data['no_wa']              = $this->input->post('no_wa');
            $data['last_update']        = date('Y-m-d H:i:s');




            $imageFolder = 'kordapil';



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

                $insert = $this->PM->update('data_kordapil', array('id' =>  $id), $data);
                if ($insert) {

                    $ret['status'] = true;
                    $ret['msg'] = "Data berhasil disimpan";


                    //$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
                } else {
                    $ret['status']  = false;
                    $ret['msg']     =  "proses simpan data gagal";
                    //log_message('user_info','last query = '.$this->db->last_query());
                }
            } else {
                $ret['status']  = false;
                //$ret['msg']     = "Data berhasil disimpan";
            }
        }




        $this->jsonOut($ret);
    }

    //Delete one item
    public function delete_kordapil()
    {
        $ret['status'] = false;
        $ret['msg'] = 'Fitur dalam proses perbaikan';

        /*  $data     = $this->input->post('id');
        $table     = 'data_kordapil';

        $ret     = $this->DataDelete($table, $data); */

        $this->jsonOut($ret);
    }


    public function verify()
    {
    }



    public function select_akun_koord_relawan()
    {
        echo $this->selectoption->selectKoordRelawanID();
    }

    public function select_caleg()
    {
        echo $this->selectoption->selectCaleg();
    }

    public function select_kordapil()
    {
        echo $this->selectoption->selectAllKoordDapil();
    }

    public function select_dapil()
    {
        echo $this->selectoption->selectAllDapil();
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


/* End of file Kordapil.php */
/* Location: ./application/modules/admin/controllers/Kordapil.php */
