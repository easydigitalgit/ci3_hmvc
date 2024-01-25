<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_data extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        $this->load->model('Pengaturan_model', 'PM');
    }
    private function _theme($data)
    {

        $data['libjs']      = jsbyEnv(array('libStandardCrud', 'libDataTables', 'libMasterData'));
        $data['libcss']     = '';
        $data['pjs']        = jsArray(array('bs4-datatables', 'select2', 'chartjs'));
        $data['pcss']       = cssArray(array('datatables', 'select2', 'chartjs'));
        //$data['menu'] 		= 'admin/sideMenu';

        $this->theme->dashboard_theme($data);
    }

    // List all your items
    public function index()
    {
        $data['konten'] = 'masterDataKonten';

        $data['headDataTag'] = head_tbl_btn2('data_tag', true);
        $data['headDataDPC'] = head_tbl_btn2('data_dpc', true);

        $this->_theme($data);
    }

    public function table_data_wilayah()
    {
        $table            = 'desa';
        $col_order        = array('id');
        $col_search       = array('propinsi', 'kabupaten', 'kecamatan', 'nama');
        $order            = array('id' => 'ASC');
        $query            = " * FROM desa ";
        $uid              = $this->UID;
        $ulevel           = $this->ULEVEL;

        $filter       = array('prop_id' => '12');

        //get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
        $list  = $this->PM->get_datatables($table, $col_order, $col_search, $order, $query, $filter);
        $data  = array();
        $no    = $_POST['start'];
        foreach ($list as $da) {
            $no++;
            $row   = array();

            $row[] = $no;
            $row[] = $da->kode;
            $row[] = $da->propinsi;
            $row[] = $da->kabupaten;
            $row[] = $da->kecamatan;
            $row[] = $da->nama; // desa

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


    public function table_data_tag()
    {
        $table          = 'jenis_tag';
        $col_order      = array('id');
        $col_search     = array('kode_tag');
        $order          = array('id' => 'ASC');
        $query          = " * FROM jenis_tag ";
        $uid            = $this->UID;
        $ulevel         = $this->ULEVEL;

        $filter       = array();

        //get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
        $list  = $this->PM->get_datatables($table, $col_order, $col_search, $order, $query, $filter);
        $data  = array();
        $no    = $_POST['start'];
        foreach ($list as $da) {
            $no++;
            $row   = array();

            $row[] = $no;
            $row[] = $da->kode_tag;
            $row[] = $da->deskripsi_tag;
            $row[] = actbtn2($da->id, 'data_tag');

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
    public function add_data_tag()
    {
        $id =  $this->input->post('id');
        $tableName = 'jenis_tag';
        $this->form_validation->set_rules($this->PM->dataTagRules());
        $this->form_validation->set_error_delimiters('<p class= "text-danger" >', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {
            $data['kode_tag'] = $this->input->post('kode_tag');
            $data['deskripsi_tag'] = $this->input->post('deskripsi_tag');
            $insert = $this->PM->insertDb($tableName, $data, $id);
            if ($insert) {
                $ret = array('status' => true, 'msg' => 'proses simpan data berhasil');
            } else {
                $ret = array('status' => false, 'msg' => 'proses simpan data gagal');
            }
        }
        $this->jsonOut($ret);
    }


    public function edit_data_tag($id)
    {
        if ($id) {
            $data   = $this->PM->getByID('jenis_tag', $id);
            if ($data) {
                $ret['status'] = true;
                foreach ($data as $key => $value) {
                    $ret['data'][$key] = $value;
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

    public function edit_data($id)
    {
        $tableName = '';
        if ($id) {
            $data   = $this->PM->getByID($tableName, $id);
            if ($data) {
                $ret['status'] = true;
                foreach ($data as $key => $value) {
                    $ret['data'][$key] = $value;
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
}

/* End of file Master_data.php */
/* Location: ./application/modules/pengaturan/controllers/Master_data.php */
