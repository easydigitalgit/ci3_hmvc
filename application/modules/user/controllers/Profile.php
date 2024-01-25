<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
		
		$this->load->library('encryption');
		$this->load->model('UserModel','UM');



	}

	// List all your items
	public function index( $offset = 0 )
	{
		$data['konten'] = 'userProfile';
		$data['libjs']  = jsbyEnv('libProfile');
		$data['libcss'] = '';
		$data['pjs']	= jsArray(array('select2'));
		$data['pcss']	= cssArray(array('select2'));
		

		$this->theme->dashboard_theme($data);
	}

	// Add a new item
	public function add()
	{

	}

	//Update one item
	public function update_user_password()
	{

		$this->form_validation->set_rules($this->UM->userPasswordRules('edit')); 
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	      if ($this->form_validation->run() == FALSE ) {
	       $ret['status'] = false;
	           foreach ($_POST as $key => $value) {
	               $ret['msg'][$key] = form_error($key);
	           }
	       }
	       else{

	       		$oldPassword = $this->input->post('old_password');
	       		$utipe = $this->session->userdata('utipe');
	       		$uid = $this->session->userdata('uid');


	       		$table = $utipe == 'admin' ? 'user_akun' :  ($utipe == 'member'? 'anggota_akun' : '');
	       		

	       		$q = $table ?  $this->db->get_where($table,array('id'=>$uid))->row():'';
		       			if($q){
		       				$pass = $this->encryption->decrypt ( $q->password );
		       				if($pass == $oldPassword){
		       					$data['password'] = $this->encryption->encrypt($this->input->post('new_password'));
			       				//$insert = $this->AM->update('data_keluarga',array('id'=>$id), $data);
			       				$update = $this->UM->update($table, array('id'=>$uid), $data );
			       				if($update){
			       					$ret['status'] = true;
			       					$ret['msg'] = "Password berhasil diperbaharui";
			       				}
			       				else{
			       					$ret['status'] = false;
			       					$ret['msg'] = "error code 3: there's something error, please call admin";		
			       				}	
		       				}
		       				else{
		       						$ret['status'] = false;
			       					$ret['msg']['old_password'] = '<p class="text-danger">Password Lama Salah</p>';
		       				}
		       				
		       			}
		       			else{
		       				$ret['status'] = false;
		       				$ret['msg'] = "error code 1: there's something error, please call admin";
		       			}

	       		

	       }
	$this->jsonOut($ret);

	}

	//Delete one item
	public function delete( $id = NULL )
	{

	}
}

/* End of file User_profile.php */
/* Location: ./application/modules/user/controllers/User_profile.php */
