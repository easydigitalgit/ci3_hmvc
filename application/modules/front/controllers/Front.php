<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once (dirname(APPPATH) . '/vendor/autoload.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Front extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
		$this->load->helper('captcha');
		$this->load->library('SelectOption');
		$this->load->model('Front_model','FM');
		$this->load->helper('starsender');

	}
	private function _theme($data=null){
		
		$data['libjs']  		= jsbyEnv(array('libFront'));
		$data['libcss'] 		= '';
		$data['pjs']        	= jsArray(array('sweetalert2'));
  		$data['pcss']       	= cssArray(array('sweetalert2'));

		$this->theme->frontTheme($data);
	}
	
	public function index()
	{
		$this->session->unset_userdata('noreg');
		//homepage
		$data['captchaImg']= $this->captcha();
		$data['heroSection'] = 'frontKonten';
		$data['topNav']	= 'topNav';
		$this->_theme($data);

	}
	


	// Add a new item
	public function add_front_registrasi()
	{
		  $this->form_validation->set_rules($this->FM->dataPendaftaranRules('add'));
		  if (empty($_FILES['scan_akte']['name']))
			{
			    $this->form_validation->set_rules('scan_akte', 'File Akte', 'required');
			}
		  if($this->input->post('riwayat_sekolah') == 2){
				$this->form_validation->set_rules('unit_asal_id', 'Unit Sekolah', 'required');
			}
		  elseif($this->input->post('riwayat_sekolah') == 3){
		  		$this->form_validation->set_rules('asal_sekolah', 'Asal Sekolah', 'required');
		  		$this->form_validation->set_rules('propinsi_id', 'Propinsi Sekolah Asal', 'required');
		  		$this->form_validation->set_rules('kota_id', 'Kota Sekolah Asal', 'required');
		  }
		  elseif($this->input->post('riwayat_sekolah') == 4) {
		  		$this->form_validation->set_rules('asal_sekolah', 'Asal Sekolah', 'required');
		  		$this->form_validation->set_rules('negara_id', 'Negara Sekolah Asal', 'required');
		  }

		  if($this->input->post('sumber_informasi') == 7){
		  		$this->form_validation->set_rules('sumber_lain', 'Sumber Informasi', 'required');
		  }
	      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	      if ($this->form_validation->run() == FALSE ) {
	       $ret['status'] = false;
	           foreach ($_POST as $key => $value) {
	               $ret['msg'][$key] = form_error($key);
	           }
	       }
	       else{

	       		 $post_code  = $this->input->post('captcha');
        		 $captcha    = $this->session->userdata('captchaCode');
        
        		 if ($post_code == $captcha) {
        		 		$tingkat = array('1'=>'pg', '2'=>'tk', '3'=>'sd', '4'=>'smp', '5'=>'sma');

			             $data['tahun_ajaran_id']		= $this->input->post('tahun_ajaran_id');
			             $data['tingkat_id']    		= $this->input->post('tingkat_id');
			             $data['jenjang_kelas_id']   	= $this->input->post('jenjang_kelas_id');
			             $data['jenis_pendaftaran_id']  = $this->input->post('jenis_pendaftaran_id');
			             $data['program']				= $this->input->post('program');
			             $data['nama_lengkap']			= strtoupper( $this->input->post('nama_lengkap') );

			             $data['riwayat_sekolah'] 		= $this->input->post('riwayat_sekolah');
			             $data['propinsi_id']			= $this->input->post('propinsi_id');
			             $data['kota_id']				= $this->input->post('kota_id');
			             $data['negara_id']				= $this->input->post('negara_id');

			             $data['dob'] 					= $this->input->post('dob');
			             $data['gender']				= $this->input->post('gender');
			             $data['asal_sekolah']	 		= strtoupper( $this->input->post('asal_sekolah'));
			             $data['nama_ortu']				= strtoupper($this->input->post('nama_ortu'));
			             $data['no_wa']					= $this->input->post('no_wa');
			             $data['alamat_rumah']			= strtoupper( $this->input->post('alamat_rumah'));
			             $data['email']					= $this->input->post('email');
			             $data['sumber_informasi']		= $this->input->post('sumber_informasi');
			             $data['sumber_lain']			= $this->input->post('sumber_lain');
			             $data['unit_asal_id']			= $this->input->post('unit_asal_id');
			             $data['status_payment']		= 'unpaid';
			             $data['last_update']			= date('Y-m-d H:i:s');

			             $data['created']				= date('Y-m-d H:i:s');
	            
		                if($data['tingkat_id']){
		                	$imageFolder = $tingkat[$data['tingkat_id']];	
		                }
		                
		        		//$ret = array("status" => true , "msg"=>"data belum disimpan");
		        		$ret['statusScanAkte']    = true;
		        		$ret['statusScanPayment'] = true; 
	             
			             if(!empty($_FILES['scan_akte']['name']))
		                    {
		                        $filename = $this->input->post('tingkat_id').'_'.uniqid();
		                        $uplod_foto = $this->_upload_images('scan_akte',$filename,$imageFolder);
		                        if ($uplod_foto['status']) {
		                            $data['scan_akte'] = $uplod_foto['filename'];
		                            $ret['status']= true;
		                        }
		                        else{
		                            $ret['msg']['scan_akte'] = $uplod_foto['error'];
		                            $ret['status'] = false;
		                            $uploadError['scan_akte'] = $uplod_foto['error'];
		                            $ret['statusScanAkte']    = false;  
		                        }
		                        
		                        
		                    }
		                    else {
		                    	 $ret['statusScanAkte']    = false;
		                    	 $ret['msg']['statusScanAkte'] = "file tidak boleh kosong";
		                    }


		                     if(!empty($_FILES['scan_payment']['name']))
		                    {
		                        $filename = $this->input->post('tingkat_id').'_'.uniqid();
		                        $uplod_foto = $this->_upload_images('scan_payment',$filename,$imageFolder);
		                        if ($uplod_foto['status']) {
		                            $data['scan_payment'] = $uplod_foto['filename'];
		                            $ret['status']= true;
		                        }
		                        else{
		                            $ret['msg']['scan_payment'] = $uplod_foto['error'];
		                            $ret['status'] = false;
		                            $uploadError['scan_payment'] = $uplod_foto['error']; 
		                             $ret['statusScanPayment']    = false;  
		                        }
		                        
		                        
		                    }
		                    else{
		                    	$ret['statusScanAkte']    = false;
		                    	$ret['msg']['scan_payment'] = "file tidak boleh kosong";
		                    }


		                  if($ret['statusScanAkte'] && $ret['statusScanPayment']){
		                  	$insert = $this->FM->save('pendaftaran', $data);
			                if($insert){
			                	 $dt['noreg'] = $this->_generateNoreg($insert);
			                	 $insertNoreg = $this->FM->update('pendaftaran', array('id'=>$insert), $dt);

			                	 $ret['status'] = true;
			                	 $ret['msg'] 	= "Data berhasil disimpan";
			                	 	 
			                	 	 $sess['noreg'] 	= $dt['noreg'];
				                	 $sess['noWaPSB'] 	= $data['no_wa'];
				                	 $sess['emailPSB']	= $data['email'];
			                	 
			                	 $this->session->set_userdata($sess);
			                	//$ret = array("status" => true , "msg"=>"proses simpan data berhasil");

			                	$this-> _saveEmailtoQue($data['email'], $dt['noreg']);
			                	$this->sendWhatsapp($data['no_wa'], $dt['noreg']);
			                }
			                else {
			                	$ret = array("status" => false , "msg"=>"proses simpan data gagal");
			                }

		                  }
		                  else{
		                  	$ret['status'] = false;
		                  }  
	              
	            	}

	            	else{
	            		$ret['status'] 				= false;
	            		$ret['msg']['captcha'] 		= '<p class="text-danger"> Captcha Salah </p>';
	            		 //$ret = array("status" => false , "msg"=>"Captcha Salah");
	            	}
        		}


	       	     

	        $this->jsonOut($ret);  

	}

	public function thankyou(){
		$noreg = $this->session->userdata('noreg');
		if($noreg){
			$data['heroSection'] = 'thankyouKonten';
			$data['topNav']	= 'topNav';
			$this->_theme($data);
		}
		
	}

	public function captcha(){
		 $config = array(
          	'img_path'      => 'captcha_images/',
            'img_url'       => base_url().'captcha_images/',
            'font_path'     => FCPATH.'system/fonts/texb.ttf',
            'img_width'     => '150',
            'img_height'    => 50,
            'word_length'   => 4,
            'font_size'     => 20,
            'colors'        => array(
                    'background' => array(255, 255, 255),
                    'border' => array(255, 255, 255),
                    'text' => array(200, 30, 0),
                    'grid' => array(255, 40, 40)
            )
        );
        $captcha = create_captcha($config);
        
        // Unset previous captcha and store new captcha word
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode',$captcha['word']);
        
        // Send captcha image to view
        return $captcha['image'];
	}
	public function refresh_captcha(){
        // Captcha configuration
        $config = array(
          'img_path'      => 'captcha_images/',
            'img_url'       => base_url().'captcha_images/',
            'font_path'     => FCPATH.'system/fonts/texb.ttf',
            'img_width'     => '150',
            'img_height'    => 50,
            'word_length'   => 4,
            'font_size'     => 20,
            'colors'        => array(
                    'background' => array(255, 255, 255),
                    'border' => array(255, 255, 255),
                    'text' => array(200, 30, 0),
                    'grid' => array(255, 40, 40)
            )
        );
        $captcha = create_captcha($config);
        
        // Unset previous captcha and store new captcha word
        $this->session->unset_userdata('captchaCode');
        $this->session->set_userdata('captchaCode',$captcha['word']);
        
        // Display captcha image
        echo $captcha['image'];
    }

	//Update one item
	public function update( $id = NULL )
	{

	}

	//Delete one item
	public function delete( $id = NULL )
	{

	}


	public function select_jenjang_kelas($unitID=0){
		if ($unitID) {
			echo $this->selectoption->selectJenjangKelas($unitID);
		}
		
	}

	public function select_tahun_ajaran(){
		$table = 'tahun_ajaran';
		$val ='id';
		$text = 'nama_thn_ajaran';
		echo $this->selectoption->selectStd($table,$val,$text);
	}

	public function select_propinsi(){
		$this->selectPropinsi();
	}

	public function select_kota($propID){
		if ($propID) {
			$this->selectKabupaten($propID,0);
		}
		
	}
	public function select_country(){
		$table 	= 'country';
		$val 	= 'countrycode';
		$text 	= 'countryname';
		echo $this->selectoption->selectStd($table,$val,$text);
	}

	public function select_sumber_informasi(){
		$table = 'sumber_informasi';
		$val = 'id';
		$text = 'nama_sumber_informasi';
		echo $this->selectoption->selectStd($table,$val,$text);
	}


	public function _generateNoreg($id){
		//PSB22040101
		$noreg = "PSB".date('ymd').$id;
		return $noreg;
	}

	private function _upload_images($fieldName, $name,$folder,$ovr=true, $ext='jpg|JPG|jpeg|JPEG|png|PNG', $maxSize=2500, $maxWidth=4500, $maxHeight=4500){
    //$userId = $this->session->userdata('userId');
    //$noref = $this->input->post('noref');
        $config = array();
        $config['upload_path']          = $this->AppDoc.$folder.'/';
        $config['allowed_types']        = $ext;
        $config['max_size']             = $maxSize; //set max size allowed in Kilobyte
        $config['max_width']            = $maxWidth; // set max width image allowed
        $config['max_height']           = $maxHeight; // set max height allowed
        $config['file_name']            = $fieldName.'_'.$name;
        $config['file_ext_tolower']     = TRUE;
        
        $this->load->library('upload', $config, $fieldName); // Create custom object for foto upload
        $this->$fieldName->initialize($config);
        $this->$fieldName->overwrite = $ovr;
        
        //upload and validate
        if($this->$fieldName->do_upload($fieldName)){
            $res['filename'] = $this->$fieldName->data('file_name');
            $res['error']    = null;
            $res['status']   = true;
        } 
        else { 
            $res['error']    = $this->$fieldName->display_errors('<p class="text-danger">','</p>');
            $res['filename'] = null ; 
            $res['status']   = false;
        }
        return $res;
}

public function _saveEmailtoQue($to, $noReg){
	$dt['noreg'] = $noReg;
	$data['body'] = $this->load->view('thankyouMailTemplate', $dt, true);
	$data['to_address'] = $to;
	$data['status'] = 1;

	$q = $this->FM->save('mail_que', $data);
}

public function send_mail_que(){
	$q = $this->db->get_where('mail_que', array('status'=>1));
	$subject = 'Pendaftaran Siswa Baru Yayasan Pendidikan Shafiyyatul Amaliyyah';
	if( $q->num_rows()){
		foreach( $q->result() as $val ){
			$to = $val->to_address;
			$body = $val->body;

			$send = $this->sendmail($to, $body, $subject);
		}
	}

	//var_dump($send);
}

 public function sendmail($to, $body, $subject)
    {
       /* $to                 = $this->request->getPost('to');
        $subject            = $this->request->getPost('subject');
        $message            = $this->request->getPost('message');*/
 
        $mail = new PHPMailer(true);
 
        try {
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host       = 'mail.ypsa.id';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'psb@ypsa.id'; // ubah dengan alamat email Anda
            $mail->Password   = 'psbYPSA116075'; // ubah dengan password email Anda
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;
 
            $mail->setFrom('psb@ypsa.id', 'PSB YPSA'); // ubah dengan alamat email Anda
            $mail->addAddress($to);
            $mail->addReplyTo('psb@ypsa.id', 'PSB YPSA'); // ubah dengan alamat email Anda
 
            // Isi Email
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
 
            $mail->send();
 
         // Pesan Berhasil Kirim Email/Pesan Error
 			$ret['status'] = true;
 			$ret['msg'] = '';
           
            return $ret;
        } catch (Exception $e) {
        	$ret['status'] = false;
 			$ret['msg'] = $mail->ErrorInfo;
           
            return $ret;
        }
    }

    public function sendWhatsapp($to, $noReg){
    	$body = "Terimakasih telah melakukan pendaftaran pada applikasi Penerimaan Siswa Baru Yayasan Pendidikan Shafiyyatul Amaliyyah (YPSA) pada tautan https://psb.ypsa.id , 
    		Nomor pendaftaran anda adalah : ".$noReg." 
    		Petugas kami akan menghubungi Bapak/Ibu melalui Nomor Whatsapp / email sesuai data pendaftaran untuk melakukan verifikasi.  Untuk informasi lebih lengkap tentang proses penerimaan siswa baru YPSA, silakan menghubungi kami melalui no telepon (061) 8212775 atau  menghubungi via Whatsapp: 628116518989 ";

    	sendtext($to,$body);
    }



}

/* End of file Front.php */
/* Location: ./application/modules/front/controllers/Front.php */
