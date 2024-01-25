<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Anggota extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model', 'PM');
        $this->load->library('SelectOption');
        $this->load->helper('parser');
        $this->load->helper('easysender');
        $this->UID ? '' : $this->logOut();
    }

    private function _theme($data)
    {

        $data['libjs']          = jsbyEnv('libAnggota');
        $data['libcss']         = '';
        $data['pjs']            = jsArray(array('bs4-datatables', 'select2', 'moment2.24', 'daterangepicker', 'lightbox'));
        $data['pcss']           = cssArray(array('datatables', 'select2', 'daterangepicker'));
        //$data['menu'] 		= 'admin/sideMenu';

        $this->theme->dashboard_theme($data);
    }

    // List all your items
    public function index()
    {
        $data['konten'] = 'dataAnggota';
        $data['libcss'] = '';
        $data['headDataAnggota'] = $this->ULEVEL == 1 ?  head_tbl_btn2('anggota', false) : headBtnNoDelete('anggota');
        $this->_theme($data);
    }

    public function table_anggota()
    {
        $genderArr = array('M' => 'Laki-laki', 'F' => 'Perempuan');

        $table        = 'anggota';
        $col_order    = array('a.id');
        $col_search   = array('a.nama', 'a.nik', 'a.no_wa','a.gender');
        $order        = array('a.id' => 'ASC');
        $query        = " a.id, a.nik, a.nama, a.pob, a.dob, a.gender, a.alamat, a.no_wa, a.scan_ktp, a.foto, a.createdby, b.nama as propinsi , c.nama as kota, d.nama as kec, e.nama as desa FROM anggota a 
                        LEFT JOIN propinsi b on a.propinsi = b.kode LEFT JOIN kabupaten c on a.kota = c.kode 
                        LEFT JOIN kecamatan d on a.kec = d.kode LEFT JOIN desa e ON a.desa = e.kode ";
        $uid = $this->UID;                
        $ulevel = $this->ULEVEL;
        if($ulevel == 1 || $ulevel == 3){
            $filter       = array();
        }
        elseif ($ulevel == 2) {
            $filter       = array('a.createdby'=>$uid);
        }
        else{
            $filter = array('1'=>'0');
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
            $row[] = $da->alamat . '<br> Kel.:' . $da->desa . '<br> Kec.:' . $da->kec . '<br> Kab./Kota:' . $da->kota . '<br> Prop.:' . $da->propinsi;
            $row[] = $da->no_wa;
            $imgFolder = base_url("AppDoc/anggota/");

          
            
                $ktp    = (file_exists( $this->AppDoc.'anggota/'.$da->scan_ktp ) && $da->scan_ktp) ? $da->scan_ktp : 'no-image.png';
                $foto   = (file_exists( $this->AppDoc.'anggota/'.$da->foto ) && $da->foto) ? $da->foto : 'no_foto.png';
           

            $row[] = lightbox($imgFolder . $ktp, '', 'Scan KTP') ;
            $row[] = lightbox($imgFolder . $foto, '', 'Foto') ;
            $row[] = $this->ULEVEL == 1 ? actionBtn3($da->id, 'anggota') : actEdit($da->id, 'anggota');


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
            $data['dob']            = date('Y-m-d', strtotime($this->input->post('dob')));
            $data['gender']         = $this->input->post('gender');
            $data['alamat']         = $this->input->post('alamat');
            $data['propinsi']       = $this->input->post('propinsi');
            $data['kota']           = $this->input->post('kota');
            $data['kec']            = $this->input->post('kec');
            $data['desa']           = $this->input->post('desa');
            $data['no_wa']          = $this->input->post('no_wa');
            $data['last_update']    = date('Y-m-d H:i:s');
            $data['created']        = date('Y-m-d H:i:s');
            $data['createdby']      = $this->session->userdata('uid');
            $data['relawan_id']     = $this->input->post('relawan_id');

            $imageFolder = 'anggota';


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
                   
                    $this->queueWApendaftaran($data);
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

    public function edit_anggota($id)
    {
        if ($id) {
            $data   = $this->PM->getAnggotaByID($id);
            if ($data) {
                $ret['status']   = true;
                $ret['data']     = $data->row();
            } else {
                $ret['status']   = false;
                $ret['data']     = 0;
            }
        } else {
            $ret['status']      = false;
            $ret['data']        = 0;
        }

        $this->jsonOut($ret);
    }

    //Update one item
    public function update_anggota()
    {
        $id = $this->input->post('id');
        $this->form_validation->set_rules($this->PM->dataPendaftaranRules('edit'));
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
            $data['dob']            = date('Y-m-d', strtotime($this->input->post('dob')));
            $data['gender']         = $this->input->post('gender');
            $data['alamat']         = $this->input->post('alamat');
            $data['propinsi']       = $this->input->post('propinsi');
            $data['kota']           = $this->input->post('kota');
            $data['kec']            = $this->input->post('kec');
            $data['desa']           = $this->input->post('desa');
            $data['no_wa']          = $this->input->post('no_wa');
            $data['last_update']    = date('Y-m-d H:i:s');
            $data['created']        = date('Y-m-d H:i:s');
             $data['relawan_id']     = $this->input->post('relawan_id');

             $imageFolder = 'anggota';

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
                 $insert = $this->PM->update('anggota', array('id' => $id), $data);
                if ($insert) {

                    $ret['status'] = true;
                    $ret['msg'] = "Data berhasil disimpan";
                   
                   // $this->queueWApendaftaran($data);
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

    //Delete one item
    public function delete_anggota()
    {
        $list_id = $this->input->post('id');
        $table = 'anggota';

        if (is_array($list_id)) {
            if (!empty($list_id)) {
                $del = $this->PM->bulk_delete($table, $list_id);
                if ($del) {
                    $ret['status'] = true;
                    $ret['msg'] = 'Data berhasil dihapus';
                } else {
                    $ret['status'] = false;
                    $ret['msg'] = 'Proses hapus data gagal';
                }
            }
        } elseif ($list_id) {
            $del = $this->PM->delete_by_id($table, $list_id);
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
        }

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

    public function select_relawan(){
        $id = $this->session->userdata('uid');

         echo $this->selectoption->selectRelawanID($id);
    }


   public function queueWApendaftaran($data=array()){
       
        $q = $this->db->get('konfigurasi');
         
        if($q->num_rows()){
            foreach($q->result() as $val){
                $namaCaleg = $val->nama_caleg;
                $noWa = $val->wa_center;
                $templateWa = $val->wa_template;

            }

                $dt['body_text']        = $templateWa;
                $dt['to_number']        = $data['no_wa'] ;
                $dt['jenis_pesan']      = 1;
                $dt['sender_number']    = $noWa;
                $dt['media_pesan']      = '';
                $dt['jenis_cron']       = 'wadaftar';
                $dt['createdby']        = $data['createdby'];
                $q = $this->PM->save('queue_pesan', $dt);

            if($q){
                $ret = true;
            }
            else{
                $ret = false;
            }
        }
        else{
            $ret  = false;
        }
       return $ret; 
       

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
