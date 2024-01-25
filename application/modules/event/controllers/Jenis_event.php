<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_event extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
		$this->load->model('Event_model', 'EM');

	}
    //UlwCXakEbuNt

	  private function _theme($data)
    {

        $data['libjs']          = jsbyEnv('libJenisEvent');
        $data['libcss']         = '';
        $data['pjs']            = jsArray(array('bs4-datatables', 'select2', 'moment2.24', 'daterangepicker', 'lightbox'));
        $data['pcss']           = cssArray(array('datatables', 'select2', 'daterangepicker'));
        //$data['menu'] 		= 'admin/sideMenu';

        $this->theme->dashboard_theme($data);
    }

    // List all your items
    public function index()
    {
        $data['konten'] = 'jenisEventKonten';
        $data['libcss'] = '';
        $data['headJenisEvent'] = head_tbl_btn2('jenis_event', false);
        $this->_theme($data);
    }

    public function table_jenis_event()
    {
      
        $table        = 'jenis_event';
        $col_order    = array('id');
        $col_search   = array('kode_jenis_event', 'nama_jenis_event');
        $order        = array('id' => 'ASC');
        $query        = " * from jenis_event  ";


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
            $row[] = $da->nama_jenis_event;
            $row[] = $da->deskripsi;
           
           
            $row[] = actionBtn3($da->id, 'jenis_event');


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
    public function add_jenis_event()
    {
        $this->form_validation->set_rules($this->EM->dataJenisEvent('add'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {

        	$data['kode_jenis_event'] = $this->input->post('kode_jenis_event');
        	$data['nama_jenis_event'] = $this->input->post('nama_jenis_event');

            $data['deskripsi']        = $this->input->post('deskripsi');

           
            $data['last_update']    = date('Y-m-d H:i:s');
    
         

                $insert = $this->EM->save('jenis_event', $data);
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

    public function edit_jenis_event($id)
    {
        if ($id) {
            $data   = $this->EM->getJenisEventByID($id);
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
    public function update_jenis_event($id = NULL)
    {
        $id = $this->input->post('id');
        $this->form_validation->set_rules($this->EM->dataJenisEvent('add'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {

           	$id = $this->input->post('id');
           	$data['kode_jenis_event'] = $this->input->post('kode_jenis_event');
        	$data['nama_jenis_event'] = $this->input->post('nama_jenis_event');

            $data['deskripsi']        = $this->input->post('deskripsi');

           
            $data['last_update']    = date('Y-m-d H:i:s');

                $insert = $this->EM->update('jenis_event', array('id' =>  $id), $data);
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

    //Delete one item
    public function delete_jenis_event()
    {
        $data     = $this->input->post('id');
        $table     = 'jenis_event';

        $ret     = $this->DataDelete($table, $data);

        $this->jsonOut($ret);
    }


    public function verify()
    {
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

/* End of file Jenis_event.php */
/* Location: ./application/modules/event/controllers/Jenis_event.php */
