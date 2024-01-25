<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$this->load->model('Auth_model','Amodel');
		$this->load->library('encryption');
		$this->load->library('token');
		$this->load->helper('mailapi');
		$this->load->helper('parser');
	}
	public function index()
	{
		
			//$data['konten'] = 'peserta/loginKonten';
			$data['libjs']  = jsbyEnv('libLogin');
			//$data['pcss'] =  cssArray(array('select2'));
			//$data['pjs'] = jsArray(array('select2'));
			$data['title'] = 'Halaman Autentikasi Pengguna';
			$this->theme->login_theme($data);
		
		
	}

	public function tespass($pass=null){
		if($pass){
			$epas = $this->encryption->encrypt($pass);
			echo $epas ;
		}
	}
	public function dekrip(){
		$d = '7caf14302517e71e7092bbd40c9cff57ad14f95442eb4a8f357465b29a4746539837b156f2c1f22d3e6b4034c0c5b503a18c16cb696ecdd2b5445149f4bd4f6632k86bSIQPz/unrdRhGGVHgtvhWLoo9gtfkI+i+vjOE=';
		echo $this->encryption->decrypt($d);
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
			$this->jsonOut($ret);

        } 
        else { 
        	$username 	= $this->input->post('username');
			$pass 		= $this->input->post('password');

			$loginCek = $this->Amodel->cekAdminLogin($username,$pass);
			if($loginCek['status']===1){
				//login oke
				$data = $loginCek['data'];
				$sess['ulevel'] 		= $data->level_user_id;
				$sess['uid'] 			= $data->id;
				$sess['username'] 		= $data->username;
				$sess['nama']			= $data->nama;
				
				$sess['defaultPage']	= 'admin/dashboard';
				$this->session->set_userdata($sess);

				$ret['status'] 		= true;
				$ret['msg']			= 'login sukses';
				$ret['dashboard'] 	= base_url().$sess['defaultPage'];

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



			if($ret['status']){
				$cookie = array(
						'name'	=>	'sid',
						'value'	=>	$this->session->userdata('uniqid'),
						'expire'=>	0, 
						'secure'=>	true	);
				$this->input->set_cookie($cookie);
			}

			echo json_encode($ret);
		}
	}

public function create_acc(){
	$this->form_validation->set_rules($this->Amodel->memberAccountRules('add')); 
	      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	      if ($this->form_validation->run() == FALSE ) {
	       $ret['status'] = false;
	           foreach ($_POST as $key => $value) {
	               $ret['msg'][$key] = form_error($key);
	           }
	       }
	       else
	       {
	       		$data['uniqid']			= $this->token->randomString(10);
	       		$data['nama_lengkap'] 	= $this->input->post('acc_nama');
	       		$data['nik']			= $this->input->post('acc_nik');
	       		$data['email']			= $this->input->post('acc_email');
	       		$data['password'] 		= $this->encryption->encrypt( $this->input->post('acc_password') );
	       		$data['struktural_id'] 	= $this->input->post('acc_struktural_id');
	       		$data['created_date']   = date('Y-m-d H:i:s');

	       		$insertID = $this->Amodel->save('anggota_akun',$data);

	       		if ($insertID) {
	       			 $nikParse = nikParser($data['nik']);
                            $dtBiodata['anggota_akun_id'] 	= $insertID;
                            $dtBiodata['nama_lengkap'] 		= $dataset['nama_lengkap'];
                            $dtBiodata['nik']				= $dataset['nik'];
                            
                            if($nikParse['status']){
                            	$dtBiodata['gender'] 	= $nikParse['gender_1'];
                            	$dtBiodata['prop_ktp'] 	= $nikParse['propinsi'];
                            	$dtBiodata['kota_ktp'] 	= $nikParse['kota_1'];
                            	$dtBiodata['kec_ktp'] 	= $nikParse['kecamatan_1'];
                            	$dtBiodata['dob'] 		= $nikParse['tanggal_lahir_3'];

                            }
                             $insertBiodata = $this->Amodel->save('biodata',$dtBiodata);

                            $dtStruktur['anggota_akun_id'] 	= $insertID;
                            $dtStruktur['struktural_id'] 	= $data['struktural_id'];
                            $dtStruktur['tmt'] 				= date('Y-m-d');
                            $dtStruktur['no_sk']			='0';
                            $insertStruktur = $this->Amodel->save('riwayat_struktural',$dtStruktur);
                           

                            $dtAnggota['anggota_akun_id'] 		= $insertID;
                            $dtAnggota['jenis_keanggotaan_id'] 	= 1;
                            $dtAnggota['tmt'] 					= date('Y-m-d');
                            $dtAnggota['no_sk'] 				= '0';
                            $insertAnggota = $this->Amodel->save('riwayat_keanggotaan',$dtAnggota);

	       			$ret['status'] 	= true;
	       			$ret['msg']		= 'Registrasi Akun berhasil, silakan cek email anda untuk proses aktivasi, Hubungi Admin jika tidak menerima email dalam 1x24 jam';
	       			$data['link'] 	= '<a href="'.base_url('auth/login/activate/').$this->token->encrypt($this->input->post('acc_email')).'" "activate">AKTIVASI AKUN</a>';
	       			$data['link2'] 	= base_url('auth/login/activate/').$this->token->encrypt($this->input->post('acc_email'));
	       			$subject 		= "Konfirmasi Pendaftaran Akun Monev PKS";
	       			$toAddress 		= $this->input->post('acc_email');
	       			$body 			= $this->load->view('auth/accountActivation', $data, true);

	       			$sendMail 		= mailApi($subject,$body,$toAddress);
	       		}
	       		else{
	       			$ret['status'] = false;
	       			$ret['msg'] = 'Registrasi akun gagal, silakan ulangi atau hubungi helpdesk jika dibutuhkan';
	       		}

	       }

	       echo json_encode($ret);
}

public function activate($encrypted){
	$email = $this->token->decrypt($encrypted);
	$cek = $this->db->get_where('anggota_akun',array('email'=> $email));
	if($cek->num_rows()){
		$d['aktif']='2';
		//$update = $this->db->update('anggota_akun', $d ,array('email'=>$email));

		// $update = $this->Amodel->update('anggota_akun',array('email'=>$email), $d);
		

		if($this->Amodel->update('anggota_akun',array('email'=>$email), $d)){
			log_message('debug','last query = '.$this->db->last_query());
			$data['msgAktivasi'] = '<p class="alert alert-success">
			Proses Aktivasi berhasil, silakan login dengan akun anda </p>' ;
		}
		else{
			$data['msgAktivasi'] = '<p class="alert alert-danger"> Proses Aktivasi Gagal, silakan ulangi proses aktivasi atau hubungi admin untuk bantuan</p>';
		}
	}
	else{
		$data['msgAktivasi'] = '<p class="alert alert-danger"> akun tidak ditemukan </p>';
	}

	
	$data['libjs']  = jsbyEnv('libLogin');
	$data['title'] = 'Halaman Autentikasi Anggota';
	$this->theme->login_theme($data);
}

public function logout(){
	$this->session->sess_destroy();
	header('location:'.site_url('auth/Login/index'));
}


}

/* End of file Login.php */
/* Location: ./application/modules/auth/controllers/Login.php */