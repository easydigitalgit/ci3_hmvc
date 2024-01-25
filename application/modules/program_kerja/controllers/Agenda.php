<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Agenda extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Agenda_model', 'AM');
        $this->load->library('encryption');
        $this->load->library('SelectOption');
        $this->load->library('parser');


        $this->UID  ? '' : $this->logOut();
    }

    private function _theme($data)
    {

        $data['libjs']          = jsbyEnv(array('libDataTables', 'libStandardCrud', 'libAgenda', 'libMapAgenda'));
        $data['libcss']         = '';
        $data['pjs']            = jsArray(array('bs4-datatables', 'select2', 'moment2.24', 'daterangepicker', 'lightbox', 'dual-listbox', 'leaflet', 'leaflet-popup-responsive', 'leaflet-marker-cluster'));
        $data['pcss']           = cssArray(array('datatables', 'select2', 'select2-bs5', 'daterangepicker', 'dual-listbox', 'dual-listbox-icon', 'leaflet', 'leaflet-popup-responsive', 'leaflet-marker-cluster', 'leaflet-marker-clusterDefault',));
        //$data['menu'] 		= 'admin/sideMenu';

        $this->theme->dashboard_theme($data);
    }

    // List all your items
    public function index()
    {

        $ulevel = $this->ULEVEL;

        if ($ulevel == '1' || $ulevel == '3') {

            $data['konten'] = 'agendaKonten';
            $data['libcss'] = '';
            $data['headTableAgenda'] = headBtnNoDelete('data_agenda');
            $this->_theme($data);
        } else {
            $this->logOut();
        }
    }

    public function table_data_agenda()
    {

        $table        = 'data_agenda';
        $col_order    = array('a.id');
        $col_search   = array('a.nama_agenda', 'a.tempat');
        $order        = array('a.id' => 'ASC');
        $query        = " a.*, b.nama as nama_prop, c.nama as nama_kab, d.nama as nama_kec , e.nama as nama_desa FROM data_agenda a LEFT JOIN propinsi b ON a.prop_kode = b.kode LEFT JOIN kabupaten c ON a.kab_kode = c.kode LEFT JOIN kecamatan d ON a.kec_kode = d.kode LEFT JOIN desa e ON a.desa_kode = e.kode ";
        $ulevel = $this->ULEVEL;
        $uid    = $this->UID;
        if ($ulevel == '1') {
            $filter       = array('');
        } else if ($ulevel == '3') {
            $filter       = array('caleg_akun_id' => $uid);
        } else {
            $filter       = array('1' => '0');
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
            $row[] = $da->nama_agenda;
            $row[] = $da->deskripsi;
            $row[] = date('d-m-Y', strtotime($da->waktu));
            $mapPin = ($da->pin_lat && $da->pin_long) ? '<span data-lat="' . $da->pin_lat . '" data-long="' . $da->pin_long . '">Lihat Peta</span>' : '';
            $row[] = $da->tempat . ' <br> ' . $da->nama_desa . ',' . $da->nama_kec . ',' . $da->nama_kab . ',' . $da->nama_prop . ' <br> ' . $mapPin;
            $row[] = badgeLabelStatusAgenda($da->status_agenda, $da->status_agenda);

            $row[] = actBtnAgenda($da->id, 'data_agenda');


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->AM->count_all_query($table, $filter),
            "recordsFiltered" => $this->AM->count_filtered($query, $filter, $filter),
            "data" => $data,
        );
        //output to json format
        $this->jsonOut($output);
    }

    // Add a new item
    public function add_data_agenda()
    {
        $this->form_validation->set_rules($this->AM->dataAgendaRules('add'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {

            $id = $this->input->post('id');
            $data['caleg_akun_id']      = $this->input->post('caleg_akun_id');
            $data['nama_agenda']        = $this->input->post('nama_agenda');
            $data['jenis_agenda_id']    = $this->input->post('jenis_agenda_id');
            $data['deskripsi']          = $this->input->post('deskripsi');
            $data['waktu']              = date('Y-m-d', strtotime($this->input->post('waktu')));
            $data['tempat']             = $this->input->post('tempat');
            $data['prop_kode']          = $this->input->post('prop_kode');
            $data['kab_kode']           = $this->input->post('kab_kode');
            $data['kec_kode']           = $this->input->post('kec_kode');
            $data['desa_kode']          = $this->input->post('desa_kode');
            $data['pin_lat']            = $this->input->post('pin_lat');
            $data['pin_long']           = $this->input->post('pin_long');
            $data['pin_description']    = $this->input->post('pin_description');
            $data['status_agenda']      = 'dijadwalkan';
            $data['create_by_akun_id']  = $this->UID;
            $data['keterangan_status']  = $this->input->post('keterangan_status');

            $data['last_update']        = date('Y-m-d H:i:s');

            $insert   = $this->AM->insertDb('data_agenda', $data, $id);


            if ($insert) {
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

    public function edit_data_agenda($idAgenda)
    {
        $q = $this->AM->getDataAgendaByID($idAgenda);
        if ($q->num_rows()) {
            $row = $q->row_array();

            $ret['status'] = true;
            $ret['data'] = $row;
        } else {
            $ret['status'] = false;
            $ret['data'] = '';
        }
        $this->jsonOut($ret);
    }

    public function update_data_agenda()
    {
    }

    public function delete_data_agenda()
    {
        $id = $this->input->post('id');
    }

    public function add_data_laporan_agenda()
    {
        $id =  $this->input->post('id');
        $tableName = 'data_agenda';
        $this->form_validation->set_rules($this->AM->addDataLaporanAgenda('add'));
        $this->form_validation->set_error_delimiters('<p class= "text-danger" >', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {
            $data['catatan_kegiatan'] = $this->input->post('catatan_kegiatan');
            $data['status_agenda'] = $this->input->post('status_agenda');
            $data['lampiran_foto'] = json_encode($this->input->post('lampiran_foto'));

            $tempFolder = $this->tempUpload;
            $targetFolder = $this->AppDoc . 'laporan/';
            if ($id) {


                $insert = $this->AM->insertDb($tableName, $data, $id);
                if ($insert) {
                    $ret = array('status' => true, 'msg' => 'Data laporan berhasil disimpan');
                    $foto = $this->input->post('lampiran_foto');
                    if (is_array($foto) && count($foto)) {
                        foreach ($foto as $value) {
                            if (is_file($tempFolder . $value)) {
                                rename($tempFolder . $value, $targetFolder . $value);
                            }
                        }
                    }
                } else {
                    $ret = array('status' => false, 'msg' => 'proses simpan data gagal');
                }
            } else {
                $ret = array('status' => false, 'msg' => 'proses simpan data gagal, data Agenda tidak ditemukan');
            }
        }
        $this->jsonOut($ret);
    }
    public function currentsessionname()
    {
        $data['nama'] = $this->UNAME;
        $this->jsonOut($data);
    }

    public function select_caleg()
    {
        $uid    = $this->UID;
        $ulevel = $this->ULEVEL;
        $uname  = $this->UNAME;
        if ($ulevel == '1') {
            echo $this->selectoption->selectCaleg();
        } else if ($ulevel == '3') {
            echo '<option value="' . $uid . '">[' . $uname . ']</option>';
        } else if ($ulevel == '4') {
            echo $this->selectoption->selectCalegByKordapil($uid);
        }
    }

    public function select_jenis_agenda()
    {
        echo $this->selectoption->selectJenisAgenda();
    }

    public  function nomor_agenda($calegID)
    {

        $uid = $this->UID;
        $ulevel = $this->ULEVEL;

        $currentDate = date('YmdHis');
        if ($calegID) {
            $ret = $calegID . $currentDate;
        } else {
            $ret = '';
        }

        return $ret;
    }

    public function upload_foto()
    {
        //$idFile     = $this->input->post('idFile');
        $uid        = $this->UID;
        $id        = $this->input->post('id');

        $fileFolder = 'tempUpload';

        if (!empty($_FILES['lampiranAgenda']['name'])) {
            $filename = $uid . '_' . $id . '_' . uniqid();
            $upload_file = $this->_upload_images('lampiranAgenda', $filename, $fileFolder);
            if ($upload_file['status']) {
                $ret['status'] = true;
                $ret['data']['fileName'] = $upload_file['filename'];
                $ret['data']['fileUrl'] = base_url() . 'AppDoc/tempUpload/' . $upload_file['filename'];

                $ret['msg']['success'] = 'file berhasil diupload';
            } else {
                $ret['status'] = false;
                $ret['msg']['error'] = $upload_file['error'];
            }
        } else {
            $ret['status'] = false;
            $ret['msg']['error'] = 'file not found';
        }


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
}



/* End of file Agenda.php */
/* Location: ./application/modules/program_kerja/controllers/Agenda.php */
