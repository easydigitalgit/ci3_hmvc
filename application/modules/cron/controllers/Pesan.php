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

        //Load Dependencies

    }

    private function _theme($data)
    {

        $data['libjs']          = jsbyEnv('libEvent');
        $data['libcss']         = '';
        $data['pjs']            = jsArray(array('bs4-datatables', 'select2', 'moment2.24', 'daterangepicker', 'lightbox'));
        $data['pcss']           = cssArray(array('datatables', 'select2', 'daterangepicker'));
        //$data['menu'] 		= 'admin/sideMenu';

        $this->theme->dashboard_theme($data);
    }

    // List all your items
    public function index()
    {
        $data['konten'] = 'pesanKonten';
        $data['libcss'] = '';
        $data['headDataPesan'] = head_tbl_btn2('pesan', false);
        $this->_theme($data);
    }

    public function table_anggota()
    {
        $genderArr = array('M' => 'Laki-laki', 'F' => 'Perempuan');

        $table        = 'anggota';
        $col_order    = array('id');
        $col_search   = array('nama', 'nik');
        $order        = array('id' => 'ASC');
        $query        = " * from anggota ";


        $filter       = array();

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
            $row[] = $da->pob . '/' . $da->dob;
            $row[] = $da->gender;
            $row[] = $da->alamat . '<br>' . $da->desa . '<br>' . $da->kec . '<br>' . $da->kota . '<br>' . $da->propinsi;
            $row[] = $da->no_wa;
            $imgFolder = base_url("AppDoc/");
            $row[] = lightbox($imgFolder . $da->scan_ktp, '', 'Scan KTP')  . lightbox($imgFolder . $da->foto, '', 'Foto');

            $row[] = actionBtn3($da->id, 'anggota');


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->PM->count_all_query($table, $filter),
            "recordsFiltered" => $this->PM->count_filtered($query, $filter, $filter),
            "data" => $data,
        );
        //output to json format
        $this->jsonOut($output);
    }


    // Add a new item
    public function add_anggota()
    {
        $this->form_validation->set_rules($this->PM->dataPendaftaranRules('add'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {


            $data['nik']            = $this->input->post('nik');
            $data['nama']           = $this->input->post('nama');
            $data['pob']            = $this->input->post('pob');
            $data['dob']            = $this->input->post('dob');
            $data['gender']         = $this->input->post('gender');
            $data['alamat']         = $this->input->post('alamat');
            $data['propinsi']       = $this->input->post('propinsi');
            $data['kota']           = $this->input->post('kota');
            $data['kec']            = $this->input->post('kec');
            $data['desa']           = $this->input->post('desa');
            $data['no_wa']          = $this->input->post('no_wa');
            $data['last_update']    = date('Y-m-d H:i:s');
            $data['created']        = date('Y-m-d H:i:s');
            $data['createdby']      = $this->session->userdata('id');


            $imageFolder = '';


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
                $insert = $this->PM->save('anggota', $data);
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

    public function edit_daftar_awal($id)
    {
        if ($id) {
            $data   = $this->PM->getDaftarAwalByID($id);


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
    public function update_daftar_awal($id = NULL)
    {
        $id = $this->input->post('id');
        $this->form_validation->set_rules($this->PM->dataPendaftaranRules('add'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {


            $data['nik']            = $this->input->post('nik');
            $data['nama']           = $this->input->post('nama');
            $data['pob']            = $this->input->post('pob');
            $data['dob']            = $this->input->post('dob');
            $data['gender']         = $this->input->post('gender');
            $data['alamat']         = $this->input->post('alamat');
            $data['propinsi']       = $this->input->post('propinsi');
            $data['kota']           = $this->input->post('kota');
            $data['kec']            = $this->input->post('kec');
            $data['desa']           = $this->input->post('desa');
            $data['no_wa']          = $this->input->post('no_wa');
            $data['last_update']    = date('Y-m-d H:i:s');
            $data['created']        = date('Y-m-d H:i:s');





            if (!empty($_FILES['scan_akte']['name'])) {
                $filename = $this->input->post('tingkat_id') . '_' . uniqid();
                $uplod_foto = $this->_upload_images('scan_akte', $filename, $imageFolder);
                if ($uplod_foto['status']) {
                    $data['scan_akte'] = $uplod_foto['filename'];
                    $ret['status'] = true;
                } else {
                    $ret['msg']['scan_akte'] = $uplod_foto['error'];
                    $ret['status'] = false;
                    $uploadError['scan_akte'] = $uplod_foto['error'];
                }
            } else {
                $ret['status'] = true;
            }


            if (!empty($_FILES['scan_payment']['name'])) {
                $filename = $this->input->post('tingkat_id') . '_' . uniqid();
                $uplod_foto = $this->_upload_images('scan_payment', $filename, $imageFolder);
                if ($uplod_foto['status']) {
                    $data['scan_payment'] = $uplod_foto['filename'];
                    $ret['status'] = true;
                } else {
                    $ret['msg']['scan_payment'] = $uplod_foto['error'];
                    $ret['status'] = false;
                    $uploadError['scan_payment'] = $uplod_foto['error'];
                }
            } else {
                $ret['status'] = true;
            }


            if ($ret['status']) {
                $insert = $this->PM->update('pendaftaran', array('id' => $id), $data);
                if ($insert) {
                    //$dt['noreg'] = $this->_generateNoreg($insert);
                    //$insertNoreg = $this->PM->update('pendaftaran', array('id'=>$insert), $dt);
                    $d = array();
                    $d['tanggal_tes']         = date('Y-m-d H:i:s', strtotime($this->input->post('tanggal_tes')));
                    $d['pendaftaran_id']     = $id;
                    $d['status_tes']         = '1';
                    $d['created']            = date('Y-m-d H:i:s');

                    $insertJadwal = $this->PM->insertOnDuplicate('jadwal_seleksi_psb', $d);

                    $ret['status']             = true;
                    $ret['msg']                 = "Data berhasil disimpan";

                    //$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
                } else {
                    $ret = array("status" => false, "msg" => "proses simpan data gagal");
                }
            }
        }




        $this->jsonOut($ret);
    }

    //Delete one item
    public function delete_daftar_awal()
    {
        $data     = $this->input->post('id');
        $table     = 'pendaftaran';

        $ret     = $this->DataDelete($table, $data);

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

/* End of file Daftar_awal.php */
/* Location: ./application/modules/pendaftaran/controllers/Daftar_awal.php */
