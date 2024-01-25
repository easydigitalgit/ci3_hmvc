<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Adminlogin extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
		$this->load->model('Auth_model','Amodel');
		$this->load->library('encryption');

	}

	public function index()
	{
		//$data['konten'] = 'peserta/loginKonten';
		$data['libjs']  = jsbyEnv('libLogin');
		$data['libcss'] = '';
		$data['title'] 	= 'Halaman Autentikasi Admin';

		$this->theme->login_theme($data);
	}

	public function do_login(){
		//$this->form_validation->set_rules('email', 'email', 'trim|valid_emails|required',array('required' => 'Email wajib diisi','valid_emails' => 'format penulisan email tidak valid'));
        $this->form_validation->set_rules('username', 'username', 'trim|required', array('required' => 'Username wajib diisi'));
        $this->form_validation->set_rules('password', 'password', 'trim|required', array('required' => 'Password wajib diisi'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

       // $role= array("1"=>"admin", "2"=>"operator");	
        if ($this->form_validation->run() == FALSE ) {
            $ret['status'] = false;
			$ret['msg']	=  validation_errors();
			$this->_error_msg($ret);

        } 
        else { 
        	$username 	= $this->input->post('username');
			$pass 		= $this->input->post('password');

			$loginCek = $this->Amodel->cekAdminLogin($username,$pass);
			if($loginCek['status']===1){
				//login oke
				$data = $loginCek['data'];
				$sess['utipe'] 		= 'admin';
				$sess['uid'] 		= $data->id;
				$sess['user_name']	= $data->username;
				$sess['level_id']	= $data->user_level;
				$sess['level_name']	= $data->user_level_name;
				$sess['grup'] 		= $data->grup_id;
				$sess['nama_grup']  = $data->nama_grup;
				$sess['struktural'] = $data->struktural_id;
				$this->session->set_userdata($sess);

				$ret['status'] 		= true;
				$ret['msg']			= 'login sukses';
				$ret['dashboard'] 	= base_url('admin/index');

			}
			elseif($loginCek['status']===2){
				$ret['status'] 		= false;
				$ret['msg']			= 'Akun Belum Diaktifkan';
				$ret['ecode']		= '002';
				
			}
			elseif($loginCek['status']===3){
				$ret['status'] 		= false;
				$ret['msg']			= 'Username Atau Password Salah';
				$ret['ecode']		= '003';
			}
			elseif($loginCek['status']===4){
				$ret['status'] 		= false;
				$ret['msg']			= 'Username Atau Password Salah';
				$ret['ecode']		= '004';
			}
			else{
				$ret['status'] 		= false;
				$ret['msg']			= 'Username Atau Password Salah';
				$ret['ecode']		= '005';	
			}


			echo json_encode($ret);
		}
	}
}

/* End of file Adminlogin.php */
/* Location: ./application/modules/auth/controllers/Adminlogin.php */
