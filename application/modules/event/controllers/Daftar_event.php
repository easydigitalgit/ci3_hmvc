<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Daftar_event extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Event_model', 'EM');
        $this->load->library('SelectOption');
        $this->load->helper('parser');

        //Load Dependencies

    }

    private function _theme($data)
    {

        $data['libjs']          = jsbyEnv('libEvent');
        $data['libcss']         = '';
        $data['pjs']            = jsArray(array('bs4-datatables', 'select2', 'moment2.24', 'daterangepicker', 'lightbox'));
        $data['pcss']           = cssArray(array('datatables', 'select2', 'select2-bs5', 'daterangepicker'));
        //$data['menu'] 		= 'admin/sideMenu';

        $this->theme->dashboard_theme($data);
    }

    // List all your items
    public function index()
    {
        log_message('user_info', 'daftar event index');
        $data['konten'] = 'daftarEventKonten';
        $data['libcss'] = '';
        $data['headDataEvent'] = head_tbl_btn2('event', false);
        $this->_theme($data);
    }

    public function table_event()
    {

        $table        = 'data_event';
        $col_order    = array('a.id');
        $col_search   = array('a.nama_event', 'a.tgl_event', 'b.nama_jenis_event');
        $order        = array('a.id' => 'ASC');
        $query        = "  a.*, b.nama_jenis_event, b.kode_jenis_event FROM data_event a LEFT JOIN  jenis_event b on a.jenis_event_id = b.id ";


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
            $row[] = $da->kode_jenis_event;
            $row[] = $da->nama_event;
            $row[] = $da->tgl_event ? date('d-m-Y', strtotime($da->tgl_event)) : '';
            $row[] = $da->tempat_event;
            $row[] = $da->deskripsi_event;
            $row[] = '<p class="d-inline-block text-truncate" style="max-width: 150px;">  ' . $da->template_wa . '</p>';
            $row[] = actionBtn3($da->id, 'event');


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->EM->count_all_query($table, $filter),
            "recordsFiltered" => $this->EM->count_filtered($query, $filter, $filter),
            "data" => $data,
        );
        //output to json format
        $this->jsonOut($output);
    }


    // Add a new item
    public function add_event()
    {
        $this->form_validation->set_rules($this->EM->dataEventRules('add'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {


            $data['jenis_event_id']       = $this->input->post('jenis_event_id');
            $data['nama_event']           = $this->input->post('nama_event');
            $data['tgl_event']            = date('Y-m-d', strtotime($this->input->post('tgl_event')));
            $data['tempat_event']         = $this->input->post('tempat_event');
            $data['deskripsi_event']      = $this->input->post('deskripsi_event');
            $data['template_wa']          = $this->input->post('template_wa');

            $data['last_update']    = date('Y-m-d H:i:s');
            $data['created']        = date('Y-m-d H:i:s');
            $data['createdby']      = $this->UID;


            $insert = $this->EM->save('data_event', $data);
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

    public function edit_event($id)
    {
        if ($id) {
            $data   = $this->EM->getDataEventByID($id);


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
    public function update_event()
    {
        $id = $this->input->post('id');
        $this->form_validation->set_rules($this->EM->dataEventRules('edit'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {




            $data['jenis_event_id']       = $this->input->post('jenis_event_id');
            $data['nama_event']           = $this->input->post('nama_event');
            $data['tgl_event']            = date('Y-m-d', strtotime($this->input->post('tgl_event')));
            $data['tempat_event']         = $this->input->post('tempat_event');
            $data['deskripsi_event']      = $this->input->post('deskripsi_event');
            $data['template_wa']          = $this->input->post('template_wa');


            $data['last_update']    = date('Y-m-d H:i:s');


            $insert = $this->EM->update('data_event', array('id' => $id), $data);
            if ($insert) {
                $ret['status']   = true;
                $ret['msg']      = "Data berhasil disimpan";
            } else {
                $ret['status']   = false;
                $ret['msg']      = "proses simpan data gagal";
            }
        }

        $this->jsonOut($ret);
    }

    //Delete one item
    public function delete_event()
    {
        $data     = $this->input->post('id');
        $table     = 'data_event';

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

    public function select_jenis_event()
    {
        $this->jsonOut($this->EM->jenisEventSelect2());
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
