<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_pengguna extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->userType == 'admin' ? '' : $this->logout();
		$this->load->model('Pengaturan_model','PM');
		$this->load->library('Token');
		$this->load->library('encryption');
	}

	private function _theme($data){
		
		
		//$data['menu'] 		= 'admin/sideMenu';
		
		return $this->theme->dashboard_theme($data);
	}
	// List all your items
	public function index()
	{
		$data['konten'] 	=  'dataAkunPengguna';
		$data['libcss'] 	=	'';
		$data['libjs'] 		= 	jsbyEnv('libPengaturan');
		$data['pjs'] 		=	jsArray(array('bs4-datatables','daterangepicker','select2'));
		$data['pcss'] 		=	cssArray(array('datatables','select2'));
		$data['head_akun_pengguna']= head_tbl_btn2('akun_pengguna',true);


		//$data['head_data_bidang_kerja'] = head_tbl_btn2('data_bidang_kerja',true);
		
		$this->_theme($data);
	}
	
	public function table_akun_pengguna(){
		$table        = 'user_akun';
      $col_order    = array('a.id'); 
      $col_search   = array('a.username','b.kode_grup','c.aktif_name');
      $order        = array('a.id' => 'DESC');
      $query        = " a.* , b.kode_grup, c.aktif_name, c.aktif_badge_color FROM user_akun a JOIN user_grup b on a.grup_id = b.id JOIN aktif_status c ON a.aktif = c.id";

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
         $row[] = $da->username;
         $row[] = $da->kode_grup;
         $row[] = $da->aktif_name; 
               
         
         $row[] = actbtn2($da->id,'akun_pengguna'); 


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
	public function add_akun_pengguna()
	{
			$this->form_validation->set_rules($this->PM->akunPenggunaRules('add')); 
	      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	      if ($this->form_validation->run() == FALSE ) {
	       $ret['status'] = false;
	           foreach ($_POST as $key => $value) {
	               $ret['msg'][$key] = form_error($key);
	           }
	       }
	       else{
	       		$pass = $this->input->post('password');
	       		
	       		//$encryptedPass = $pass ?  $this->token->encrypt($pass) : $this->token->encrypt('12345');
	       		 $encryptedPass      = $this->encryption->encrypt($pass);


	             $data['username']  	= $this->input->post('username');
	             $data['password']  	= $encryptedPass;
	             $data['grup_id']   	= $this->input->post('grup_id');
	             $data['aktif']		= $this->input->post('aktif');
	             $data['level']		= 5;
	              
	              $insert = $this->PM->insertDb('user_akun', $data);
	                if($insert){
	                		$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
	                }
	                else {
	                		$ret = array("status" => false , "msg"=>"proses simpan data gagal");
	                }
	            }

	        $this->jsonOut($ret); 
	}

	public function edit_akun_pengguna($id){
		if($id){
	    	$data   = $this->PM->get_by_id('user_akun',$id);
	    		if(isset($data)){
	    			$dt['id'] 			= $data->id;
	    			$dt['username'] 	= $data->username;
	    			$dt['password'] 	= $this->encryption->decrypt($data->password);
	    			$dt['grup_id']  	= $data->grup_id;
	    			$dt['aktif'] 		= $data->aktif;
 	    		}
 	    		else{
 	    			$dt = array();
 	    		}

		    if($data){
		        $ret['status'] = true;
		        $ret['data'] = $dt;
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
	public function update_akun_pengguna()
	{
			$id = $this->input->post('id');
			$this->form_validation->set_rules($this->PM->akunPenggunaRules('edit')); 
	      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	      if ($this->form_validation->run() == FALSE ) {
	       $ret['status'] = false;
	           foreach ($_POST as $key => $value) {
	               $ret['msg'][$key] = form_error($key);
	           }
	       }
	       else{
	       		$pass = $this->input->post('password');
	       		
	       		$encryptedPass      = $this->encryption->encrypt($pass);

	             $data['username']  	= $this->input->post('username');
	             $data['password']  	= $encryptedPass;
	             $data['grup_id']   	= $this->input->post('grup_id');
	             $data['aktif']		= $this->input->post('aktif');
	             $data['level']		= 5;

	              $insert = $this->PM->update('user_akun', array('id'=>$id), $data);
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
	public function delete_akun_pengguna()
	{
		$data 	= $this->input->post('id');
    	$table 	= 'user_akun';

      $ret 		= $this->DataDelete($table,$data);
        
      $this->jsonOut($ret); 
	}
}

/* End of file Data_pengguna.php */
/* Location: ./application/modules/pengaturan/controllers/Data_pengguna.php */
