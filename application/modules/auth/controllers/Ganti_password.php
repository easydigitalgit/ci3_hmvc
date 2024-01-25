<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ganti_password extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
		$this->UID ? '' : redirect('auth/login/logout', 'refresh');
		$this->load->model('Auth_model', 'AM');
		$this->load->library('encryption');
	}

	private function _theme($data)
	{

		$data['libjs']  	= jsbyEnv('libChangePass');
		$data['libcss'] 	= '';
		$data['pjs']        = jsArray(array('bs4-datatables'));
		$data['pcss']       = cssArray(array('datatables'));
		//$data['menu'] 		= 'admin/sideMenu';

		$this->theme->dashboard_theme($data);
	}


	public function index($string = null)
	{

		$data['konten'] = 'gantiPasswordKonten';
		$this->_theme($data);
	}



	public function update_password()
	{

		$this->form_validation->set_rules('password', 'Password Lama', 'trim|required', array('required' => 'Password Lama wajib diisi'));
		$this->form_validation->set_rules('new_password', 'Password Baru', 'trim|required', array('required' => 'Password Baru wajib diisi'));
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');

		// $role= array("1"=>"admin", "2"=>"operator");	
		if ($this->form_validation->run() == FALSE) {
			$ret['status'] = false;
			foreach ($_POST as $key => $value) {
				$ret['msg'][$key] = form_error($key);
			}
		} else {
			$uid = $this->session->userdata('uid');
			if ($uid) {
				$email = $this->session->userdata('username');
				$old_password = $this->input->post('password');
				$new_password = $this->input->post('new_password');

				$pass = $this->AM->cekMemberLogin($email, $old_password);


				if ($pass['status'] === 1) {

					$data['password'] = $this->encryption->encrypt($new_password);
					$update = $this->AM->update('user_akun', array('id' => $uid), $data);
					if ($update) {
						$ret['status'] 	= true;
						$ret['msg'] 	= 'Password Berhasil Diperbarui';
					} else {
						$ret['status'] 	= false;
						$ret['msg'] 	= 'Terjadi Kesalahan Pada proses update';
					}
				} else {
					$ret['status'] 	= false;
					$ret['msg']['password'] 	= '<p class="text-danger"> Password salah </p>';
				}
			} else {
				$ret['status'] = false;
				$ret['msg'] = 'Please Login First';
			}
		}

		$this->jsonOut($ret);
	}
}

/* End of file Ganti_password.php */
/* Location: ./application/modules/auth/controllers/Ganti_password.php */
