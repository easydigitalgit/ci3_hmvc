<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Master_tag extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
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

    public function index()
    {
        # code...
    }

    public function table_master_tag()
    {
        $table          = 'master_tag';
        $col_order      = array('id');
        $col_search     = array('');
        $order          = array('id' => 'ASC');
        $query          = ' * FROM $table ';
        $uid            = $this->UID;
        $ulevel         = $this->ULEVEL;
        $filter         = array('');
        $group_by       = null;


        $list  = $this->PM->get_datatables($table, $col_order, $col_search, $order, $query, $filter, $group_by);

        $data  = array();
        $no    = $_POST['start'];
        foreach ($list as $da) {
            $no++;
            $row   = array();
            $row[] = $no;
            $row[] = $da->data1;
            $row[] = $da->data2;
            $row[] = $da->data3;
            $data[] = $row;
        }
        $output = array(
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->PM->countAllQueryFiltered($query, $filter),
            'recordsFiltered' => $this->PM->count_filtered($query, $filter),
            'data' => $data,
        );
        $this->jsonOut($output);
    }
}

/* End of file: master_tag.php */
/* Location: application\modules\pengaturan\controllers\master_tag.php  */
