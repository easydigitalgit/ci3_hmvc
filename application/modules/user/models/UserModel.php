<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UserModel extends MY_Model
{
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}


	public function userPasswordRules($mode = 'edit')
	{

		//$id = $this->input->post('id');

		$rules =  [
			[
				'field'	=> 'old_password',
				'label'	=> 'Password Lama',
				'rules' => 'trim|required',
				'errors' => array('required' => '%s wajib diisi'),

			],

			[
				'field'	=> 'new_password',
				'label'	=> 'Password Baru',
				'rules' => 'trim|required',
				'errors' => array('required' => '%s wajib diisi'),
			]
		];

		return $rules;
	}

	public function dataAkunRules($mode = 'add')
	{
		$id = $this->input->post('id');
		$email = $mode == 'add' ? 'trim|required|is_unique[user_akun.username]' : 'trim|required|edit_unique[user_akun.username.' . $id . ']';

		$rules =  [


			[
				'field' => 'nama',
				'label' => 'Nama',
				'rules' => 'trim|required',
				'errors' => array('required' => '%s wajib diisi'),
			],
			[
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'trim|required',
				'errors' => array('required' => '%s wajib diisi'),
			],
			[
				'field' => 'status_aktif',
				'label' => 'Status Aktif',
				'rules' => 'trim|required',
				'errors' => array('required' => '%s wajib dipilih'),
			],
			
			[
				'field' => 'username',
				'label' => 'Username',
				'rules' =>  $email,
				'errors' => array('required' => '%s wajib diisi', 'is_unique' => '%s sudah digunakan', 'edit_unique' => '%s sudah digunakan'),

			],

		];
		return $rules;
	}

	public function getUserAkunByID($id){
		$q = $this->db->query(' SELECT a.* FROM user_akun a  WHERE a.id = '.$id);
		return $q;
	}
}

/* End of file UserModel.php */
/* Location: ./application/modules/user/models/UserModel.php */