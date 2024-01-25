<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akses_pengguna extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
		$this->userType == 'admin' ? '' : $this->logout();
		$this->load->model('Pengaturan_model','PM');

	}

	
	private function _theme($data){
		
		
		//$data['menu'] 		= 'admin/sideMenu';
		
		return $this->theme->dashboard_theme($data);
	}
	// List all your items
	public function index()
	{
		$data['konten'] 	=  'hakAksesPengguna';
		$data['libcss'] 	=	'';
		$data['libjs'] 		= 	jsbyEnv('libPengaturan');
		$data['pjs'] 		=	jsArray(array('bs4-datatables','daterangepicker','select2'));
		$data['pcss'] 		=	cssArray(array('datatables','select2'));
		$data['head_data_modul'] = head_tbl_btn2('data_modul',true);
		$data['head_hak_akses'] = head_tbl_btn2('hak_akses',true);

		//$data['head_data_bidang_kerja'] = head_tbl_btn2('data_bidang_kerja',true);
		
		$this->_theme($data);
	}

	public function table_data_modul(){
		  $table        = 'app_class_method';
	      $col_order    = array('id'); 
	      $col_search   = array('menu_title','menu_module');
	      $order        = array('id' => 'DESC');
	      $query        = "  * FROM app_class_method";

	      $filter       = array();
	              //get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
	      $list  = $this ->PM->get_datatables($table,$col_order,$col_search,$order,$query,$filter);
	      $data  = array();
	      $no    = $_POST['start'];
      
      foreach ($list as $da) {
         $no++;
         $row   = array();
         $row[] = '<input type="checkbox" class="data-check" value="'.$da->id.'">';
         $row[] = $no; 
         $row[] = $da->menu_title;
         $row[] = $da->menu_url;
         $row[] = $da->menu_module;
         $row[] = $da->menu_parent; 
               
         
         $row[] = actbtn2($da->id,'data_modul'); 


         $data[] = $row;
     }

     $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this ->PM->count_all_query($table,$filter),
        "recordsFiltered" => $this ->PM->count_filtered($query,$filter,$filter),
        "data" => $data,
    );
        //output to json format
      $this->jsonOut($output);
	}

	public function add_data_modul(){

	}

	public function edit_data_modul(){

	}

	public function update_data_modul(){

	}
	public function delete_data_modul(){

	}

	// Add a new item
	public function add_hak_akses()
	{

	}
	public function edit_hak_akses(){

	}

	//Update one item
	public function update_hak_akses( $id = NULL )
	{

	}

	//Delete one item
	public function delete_hak_akses( $id = NULL )
	{

	}
}

/* End of file Hak_akses.php */
/* Location: ./application/modules/pengaturan/controllers/Hak_akses.php */
