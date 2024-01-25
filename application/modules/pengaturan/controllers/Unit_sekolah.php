<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit_sekolah extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pengaturan_model','PM');

	}
	private function _theme($data){
		
		$data['libjs']  		= jsbyEnv('libPengaturan');
		$data['libcss'] 		= '';
		$data['pjs']        	= jsArray(array('bs4-datatables','select2'));
  		$data['pcss']       	= cssArray(array('datatables','select2'));
		//$data['menu'] 		= 'admin/sideMenu';

		$this->theme->dashboard_theme($data);
	}


	// List all your items
	public function index( )
	{
		$data['konten'] = 'unitSekolahKonten';
		$data['libcss'] = '';
		
		$this->_theme($data);
	}

	public function table_unit_sekolah(){
	  $table        = 'unit_sekolah';
      $col_order    = array('id'); 
      $col_search   = array('kode','nama');
      $order        = array('id' => 'ASC');
      $query        = " * FROM unit_sekolah ";

    
      	$filter       = array();
 
              //get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
      $list  = $this->PM->get_datatables($table,$col_order,$col_search,$order,$query,$filter);
      $data  = array();
      $no    = $_POST['start'];
      foreach ($list as $da) {
         $no++;
         $row   = array();
         $row[] = '<input type="checkbox" class="data-check" value="'.$da->id.'">';
         $row[] = $no; 
         $row[] = $da->kode; 
         $row[] = $da->nama;
         
        
         $row[] = actbtn2($da->id,'unit_sekolah'); 


         $data[] = $row;
     }

     $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->PM->count_all_query($table,$filter),
        "recordsFiltered" => $this->PM->count_filtered($query,$filter,$filter),
        "data" => $data,
    );
        //output to json format
      $this->jsonOut($output);
	}
	public function add()
	{

	}

	//Update one item
	public function update( $id = NULL )
	{

	}

	//Delete one item
	public function delete( $id = NULL )
	{

	}
}

/* End of file Unit_sekolah.php */
/* Location: ./application/modules/pengaturan/controllers/Unit_sekolah.php */
