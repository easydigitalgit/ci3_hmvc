<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akun extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel', 'UM');
        $this->load->library('encryption');
        $this->load->library('token');
        $this->load->library('SelectOption');
        $this->load->helper('actionbtn');
    }

    private function _theme($data)
    {

        $data['libjs']      = jsbyEnv(array('libAkun'));
        $data['libcss']     = '';
        $data['pjs']        = jsArray(array('bs4-datatables', 'select2', 'chartjs'));
        $data['pcss']       = cssArray(array('datatables', 'select2', 'chartjs'));
        //$data['menu'] 		= 'admin/sideMenu';

        $this->theme->dashboard_theme($data);
    }

    // List all your items
    public function index()
    {


        $data['konten'] = 'akunKonten';

        $data['head_data_akun'] = head_tbl_btn2('data_akun', true);

        $this->_theme($data);
    }


    public function table_data_akun()
    {

        $ulevel = $this->ULEVEL;
        $UID    = $this->UID;
        $table  = 'user_akun';
        if ($ulevel == '1') {

            $col_order    = array('a.id');
            $col_search   = array('a.nama', 'b.nama_jenis', 'a.status_aktif');
            $order        = array('a.id' => 'ASC');
            $query        = " a.*, b.nama_jenis FROM user_akun a LEFT JOIN jenis_akun b on a.level_user_id = b.id  ";

            $filter       = array();
        } else if ($ulevel == '3') {

            $col_order    = array('a.id');
            $col_search   = array('a.nama', 'c.nama_jenis', 'a.status_aktif');
            $order        = array('a.id' => 'ASC');
            $query        = " a.id, a.nama, a.username, a.level_user_id, c.nama_jenis, a.status_aktif FROM user_akun a LEFT JOIN data_koord_relawan b ON a.id = b.akun_id LEFT JOIN jenis_akun c ON a.level_user_id = c.id ";

            $filter       = array('b.caleg_akun_id' => $UID);
        } else if ($ulevel == '4') {
            $col_order    = array('z.id');
            $col_search   = array('z.nama', 'x.nama_jenis', 'z.status_aktif');
            $order        = array('z.id' => 'ASC');
            $query        = " z.*, x.nama_jenis FROM ( SELECT b.id, a.kordapil_akun_id , c.nama as nama_kordapil , b.nama , b.username , b.level_user_id, b.status_aktif FROM konfigurasi a LEFT JOIN user_akun b ON a.id_akun_caleg = b.id LEFT JOIN user_akun c ON a.kordapil_akun_id = c.id UNION ALL SELECT f.id, g.kordapil_akun_id, h.nama as nama_kordapil , f.nama , f.username, f.level_user_id, f.status_aktif FROM data_koord_relawan e LEFT JOIN user_akun f ON e.akun_id = f.id LEFT JOIN konfigurasi g ON e.caleg_akun_id = g.id_akun_caleg LEFT JOIN user_akun h ON g.kordapil_akun_id = h.id ) z LEFT JOIN jenis_akun x ON z.level_user_id = x.id ";

            $filter       = array('z.kordapil_akun_id' => $UID);
        } else {
            $col_order    = array('id');
            $col_search   = array('');
            $order        = array('id' => 'ASC');
            $query        = " * from  " . $table;

            $filter       = array('1' => '0');
        }


        //get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
        $list  = $this->UM->get_datatables($table, $col_order, $col_search, $order, $query, $filter);
        $data  = array();
        $no    = $_POST['start'];
        foreach ($list as $da) {
            $no++;
            $row   = array();
            $row[] = '<input type="checkbox" class="data-check" value="' . $da->id . '">';
            $row[] = $no;
            $row[] = $da->nama;
            $row[] = $da->username;
            $row[] = $da->nama_jenis;
            $row[] = $da->status_aktif;
            $row[] = actbtn2($da->id, 'data_akun');


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->UM->countAllQueryFiltered($query, $filter),
            "recordsFiltered" => $this->UM->count_filtered($query, $filter),
            "data" => $data,
        );
        //output to json format
        $this->jsonOut($output);
    }


    // Add a new item
    public function add_data_akun()
    {
        $ulevel = $this->ULEVEL;
        $UID    = $this->UID;
        $this->form_validation->set_rules($this->UM->dataAkunRules('add'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {

            $data['nama']           = $this->input->post('nama');
            $data['username']       = $this->input->post('username');

            $data['status_aktif']   = $this->input->post('status_aktif');

            $data['password']       = $this->encryption->encrypt($this->input->post('password'));
            $data['level_user_id']  = $this->input->post('level_user_id');


            $data['created']        = date('Y-m-d H:i:s');





            $insert = $this->UM->insertDb('user_akun', $data);
            if ($insert) {
                $levelUser = $data['level_user_id'];
                if ($ulevel == '1') {
                    // kalo yang nginsert admin cek level user yang diinsert

                    if ($levelUser == '2') {
                        // level koord relawan, inputkan id caleg nya ke data_koord_relawan
                    } else if ($levelUser == '3') {
                        // level Caleg, inputkan id_kordapil nya Ke konfigurasi 
                    } else if ($levelUser == '4') {
                        //level kordapil, ga usah diapain
                    } else {
                        // level ga tersedia
                    }
                } else if ($ulevel == '3') {
                    // kalo yang nginsert caleg, langsung masukkan ke koord relawan

                    $d['akun_id']       = $insert;
                    $d['caleg_akun_id'] = $UID;
                    $insertKoordRelawan = $this->UM->insertDb('data_koord_relawan', $d);
                } else if ($ulevel == '4') {
                    // kalo yang nginsert kordapil, cek level user yang diinsert
                    if ($levelUser == '2') {
                        // level koord relawan, inputkan id caleg nya ke data_koord_relawan
                    } else if ($levelUser == '3') {
                        // level Caleg, inputkan id_kordapil nya Ke konfigurasi 
                        $d['kordapil_akun_id'] = $this->UID;
                        $d['id_akun_caleg'] = $insert;
                        $insertCalegKonfigurasi = $this->UM->insertDb('konfigurasi', $d);
                    }
                }

                $ret = array("status" => true, "msg" => "proses simpan data berhasil");
            } else {
                $ret = array("status" => false, "msg" => "proses simpan data gagal");
            }
        }

        $this->jsonOut($ret);
    }

    public function edit_data_akun($id)
    {
        if ($id) {
            $data   = $this->UM->getUserAkunByID($id);
            if ($data->num_rows()) {
                $ret['status'] = true;
                foreach ($data->row() as $key => $value) {
                    if ($key == 'password') {
                        $ret['data']['password'] = $this->encryption->decrypt($value);
                    } else {
                        $ret['data'][$key] = $value;
                    }
                }
            } else {
                $ret['status'] = false;
                $ret['data'] = 0;
            }
        } else {
            $ret['status'] = false;
            $ret['data'] = 0;
        }

        $this->jsonOut($ret);
    }

    //Update one item
    public function update_data_akun()
    {
        $id = $this->input->post('id');
        $this->form_validation->set_rules($this->UM->dataAkunRules('update'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {

            $data['nama']               = $this->input->post('nama');
            $data['username']           = $this->input->post('username');

            $data['status_aktif']       = $this->input->post('status_aktif');
            $data['level_user_id']      = $this->input->post('level_user_id');
            $data['password']           = $this->encryption->encrypt($this->input->post('password'));
            //$data['caleg_id']           = $this->input->post('caleg_id');


            $insert = $this->UM->update('user_akun', array('id' => $id), $data);
            if ($insert) {

                $ret = array("status" => true, "msg" => "proses simpan data berhasil");
            } else {
                $ret = array("status" => false, "msg" => "proses simpan data gagal");
            }
        }

        $this->jsonOut($ret);
    }

    //Delete one item
    public function delete_data_akun()
    {
        $ret['status'] = false;
        $ret['msg'] = 'Fitur dalam proses perbaikan';
        /* 
        $list_id = $this->input->post('id');
        $table = 'user_akun';

        if (is_array($list_id)) {
            if (!empty($list_id)) {
                $del = $this->UM->bulk_delete($table, $list_id);
                if ($del) {
                    $ret['status'] = true;
                    $ret['msg'] = 'Data berhasil dihapus';
                } else {
                    $ret['status'] = false;
                    $ret['msg'] = 'Proses hapus data gagal';
                }
            }
        } elseif ($list_id) {
            $del = $this->UM->delete_by_id($table, $list_id);
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

        $this->jsonOut($ret);
    }

    public function ganti_password()
    {
        $data['konten']         = 'changePasswordKonten';
        $data['head_data_akun'] = head_tbl_btn2('data_akun', true);
        $this->_theme($data);
    }

    public function select_caleg()
    {

        echo $this->selectoption->selectCaleg();
    }

    public function select_user_level()
    {
        $ulevel = $this->ULEVEL;
        echo $this->selectoption->selectUserLevelByULEVEL($ulevel);
    }

    private function _upload_images($fieldName, $name, $folder, $ovr = true, $ext = 'jpg|JPG|jpeg|JPEG|png|PNG', $maxSize = 2500, $maxWidth = 2500, $maxHeight = 2500)
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

/* End of file Akun.php */
/* Location: ./application/modules/admin/controllers/Akun.php */
