<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grup_pengguna extends MY_Controller {


public function __construct()
{
	parent::__construct();
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
		$data['konten'] 	=  'grupPengguna';
		$data['libcss'] 	=	'';
		$data['libjs'] 	= 	jsbyEnv('libPengaturan');
		$data['pjs'] 		=	jsArray(array('bs4-datatables','daterangepicker','select2'));
		$data['pcss'] 		=	cssArray(array('datatables','select2'));
		$data['head_grup_pengguna']= head_tbl_btn2('grup_pengguna',true);


		//$data['head_data_bidang_kerja'] = head_tbl_btn2('data_bidang_kerja',true);
		
		$this->_theme($data);
	}
	
	public function table_grup_pengguna(){
		$table        = 'user_grup';
      $col_order    = array('a.id'); 
      $col_search   = array('a.nama_grup','a.kode_grup', 'b.kode_struktur','c.user_level_name');
      $order        = array('a.id' => 'DESC');
      $query        = "  a.*, b.kode_struktur, c.user_level_name FROM `user_grup` a JOIN struktural b ON a.struktural_id = b.id JOIN user_level c ON a.user_level = c.id ";

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
         $row[] = $da->kode_grup; 
         $row[] = $da->nama_grup;
         $row[] = $da->kode_struktur;
         $row[] = $da->user_level_name;
         $row[] = $da->deskripsi_grup;
         
         $row[] = actbtn2($da->id,'grup_pengguna'); 


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
	
	// Add a new item
	public function add_grup_pengguna()
	{
			$this->form_validation->set_rules($this->PM->grupPenggunaRules('add')); 
	      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	      if ($this->form_validation->run() == FALSE ) {
	       $ret['status'] = false;
	           foreach ($_POST as $key => $value) {
	               $ret['msg'][$key] = form_error($key);
	           }
	       }
	       else{

	             $data['kode_grup']    		= $this->input->post('kode_grup');
	             $data['nama_grup']    		= $this->input->post('nama_grup');
	             $data['deskripsi_grup']   = $this->input->post('deskripsi_grup');
	             $data['struktural_id']		= $this->input->post('struktural_id');
	             $data['user_level']			= $this->input->post('user_level');


	              $insert = $this->PM->insertDb('user_grup', $data);
	                if($insert){

	                $ret = array("status" => true , "msg"=>"proses simpan data berhasil");
	                }
	                else {
	                $ret = array("status" => false , "msg"=>"proses simpan data gagal");
	                }
	            }

	        $this->jsonOut($ret); 
	}

	public function edit_grup_pengguna($id){
		if($id){
	    	$data   = $this->PM->get_by_id('user_grup',$id);
		    if($data){
		        $ret['status'] = true;
		        $ret['data'] = $data;
		    }
		    else{
		        $ret['status'] = false;
		        $ret['data'] =0;
		    }
	 	 }
	  	else{
			    $ret['status'] = false;
			    $ret['data'] =0;
		  	}

	  $this->jsonOut($ret);
	}

	//Update one item
	public function update_grup_pengguna()
	{
			$id = $this->input->post('id');
			$this->form_validation->set_rules($this->PM->grupPenggunaRules('edit')); 
	      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	      if ($this->form_validation->run() == FALSE ) {
	       $ret['status'] = false;
	           foreach ($_POST as $key => $value) {
	               $ret['msg'][$key] = form_error($key);
	           }
	       }
	       else{

	            	$data['kode_grup']    		= $this->input->post('kode_grup');
	             	$data['nama_grup']    		= $this->input->post('nama_grup');
	             	$data['deskripsi_grup'] 	= $this->input->post('deskripsi_grup');
	             	$data['struktural_id']		= $this->input->post('struktural_id');
	             	$data['user_level']			= $this->input->post('user_level');

	              $insert = $this->PM->update('user_grup', array('id'=>$id), $data);
	                if($insert){

	                		$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
	                }
	                else {
	                		$ret = array("status" => false , "msg"=>"proses simpan data gagal");
	                }
	            }

	        $this->jsonOut($ret); 
	}

	//Delete one item
	public function delete_grup_pengguna()
	{
		$data 	= $this->input->post('id');
    	$table 	= 'user_grup';

      $ret 		= $this->DataDelete($table,$data);
        
      $this->jsonOut($ret); 
	}
}

/* End of file Grup_pengguna.php */
/* Location: ./application/modules/pengaturan/controllers/Grup_pengguna.php */
