 <?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends MY_Model
{

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}
	public $userTable = 'user_akun';
	public $memberTable = 'anggota_akun';

	public function cekAdminLogin($username, $pass)
	{
		if ($username && $pass) {
			$cek = $this->db->get_where($this->userTable, array('username' => $username));
			if ($cek->num_rows()) {
				//username ada
				$res = $cek->row();
				$user 		= $res->username;
				$password 	= $res->password;
				$status 	= $res->status_aktif;

				$level 		= $res->level_user_id;
				if ($pass === $this->encryption->decrypt($password)) {
					
					if ($status == 1) {
						//login oke, akun aktif
						$ret['status'] = 1;
						$ret['data'] = $res;
					} else {
						//login oke, akun non aktif
						$ret['status'] = 2;
						$ret['data'] = '';
					}
				} else {
					//password invalid
					$ret['status'] = 3;
					$ret['data'] = '';
				}
			} else {
				//username tidak ditemukan
				//username notfound
				$ret['status'] = 4;
				$ret['data'] = '';
			}
		}
		return $ret;
	}




	public function cekMemberLogin($username, $pass)
	{

		if ($username && $pass) {
			$cek = $this->db->select(" * FROM user_akun", false)->where(array('username' => $username))->get();
			//log_message('error',$this->db->last_query());
			//$cek = $this->db->get_where($this->usertable, array('username'=>$username));
			if ($cek->num_rows()) {
				$result = $cek->row();
				$username	= $result->username;
				$password 	= $result->password;
				$aktif 		= $result->status_aktif;

				//$grup_id 	= $result->grup_id;
				$level 	= $result->level_user_id;


				if ($pass === $this->encryption->decrypt($password)) {
					if ($aktif == 1) {
						//login oke, akun aktif
						$ret['status'] = 1;
						$ret['data'] = $result;
					} else {
						//login oke, akun non aktif
						$ret['status'] = 2;
						$ret['data'] = '';
					}
				} else {
					//password invalid
					$ret['status'] = 3;
					$ret['data'] = '';
				}
			} else {
				//username notfound
				$ret['status'] = 4;
				$ret['data'] = '';
			}
		} else {
			//username & pass cannot be null
			$ret['status'] = 5;
			$ret['data'] = '';
		}

		return $ret;
	}


	public function memberAccountRules($mode = 'add')
	{
		$id = $this->input->post('id');
		$nik = $mode == 'add' ? 'trim|required|numeric|exact_length[16]|is_unique[' . $this->memberTable . '.nik]' : 'trim|required|edit_unique[' . $this->memberTable . '.nik.' . $id . ']';
		$email = $mode == 'add' ? 'trim|required|valid_email|is_unique[' . $this->memberTable . '.email]' : 'trim|required|valid_email|edit_unique[' . $this->memberTable . '.email.' . $id . ']';

		$rules =  [
			[
				'field'	=> 'acc_nama',
				'label'	=> 'Nama Lengkap',
				'rules' => 'trim|required|alpha_numeric_spaces',
				'errors' => array('required' => '%s wajib diisi', 'alpha_numeric_spaces' => 'hanya boleh diisi dengan alphabet')

			],

			[
				'field'	=> 'acc_nik',
				'label'	=> 'No. KTP',
				'rules' => $nik,
				'errors' => array('required' => '%s wajib diisi', 'is_unique' => '%s sudah digunakan', 'edit_unique' => '%s sudah digunakan', 'numeric' => 'hanya boleh diisi angka, tanpa spasi', 'exact_length' => 'No. KTP Harus 16 Digit')
			],
			[
				'field'	=> 'acc_email',
				'label'	=> 'Email',
				'rules' => $email,
				'errors' => array('required' => '%s wajib diisi', 'is_unique' => '%s sudah digunakan', 'edit_unique' => '%s sudah digunakan', 'valid_email' => 'format email tidak valid')
			],
			[
				'field'	=> 'acc_struktural_id',
				'label'	=> 'DPC',
				'rules' => 'trim|required|numeric',
				'errors' => array('required' => '%s wajib dipilih', 'numeric' => 'Pilihan %s tidak tersedia')
			],
			[
				'field'	=> 'acc_password',
				'label'	=> 'Password',
				'rules' => 'trim|required',
				'errors' => array('required' => '%s wajib diisi')
			]


		];
		return $rules;
	}
}

/* End of file AuthModel.php */
/* Location: ./application/modules/auth/models/AuthModel.php */