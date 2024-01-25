<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require(dirname(APPPATH).'/excel/autoload.php');
        use PhpOffice\PhpSpreadsheet\Helper\Sample;
        use PhpOffice\PhpSpreadsheet\IOFactory;
        use PhpOffice\PhpSpreadsheet\Spreadsheet;
        use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Akun_anggota extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->userType == 'admin' ? '' : $this->logout();
		$this->load->model('Pengaturan_model','PM');
		$this->load->model('auth/Auth_model','AM');
		$this->load->library('Token');
		$this->load->library('encryption');
		$this->load->helper('sse');
		$this->load->helper('parser');
	}

	private function _theme($data){
		
		
		//$data['menu'] 		= 'admin/sideMenu';
		
		return $this->theme->dashboard_theme($data);
	}
	// List all your items
	public function index()
	{
		$data['konten'] 	=  'dataAkunAnggota';
		$data['libcss'] 	=	'';
		$data['libjs'] 		= 	jsbyEnv('libPengaturan');
		$data['pjs'] 		=	jsArray(array('bs4-datatables','daterangepicker','select2'));
		$data['pcss'] 		=	cssArray(array('datatables','select2'));
		$data['head_akun_anggota']= head_tbl_btn2('akun_anggota',true);


		//$data['head_data_bidang_kerja'] = head_tbl_btn2('data_bidang_kerja',true);
		
		$this->_theme($data);
	}
	
	public function table_akun_anggota(){
		$table      = 'anggota_akun';
      $col_order    = array('a.id'); 
      $col_search   = array('a.email','s.nama_struktur','a.aktif');
      $order        = array('a.id' => 'ASC');
      $query        = " a.*, r_max.max_rid, s.nama_struktur FROM anggota_akun a LEFT JOIN (SELECT MAX(id) max_rid, anggota_akun_id 
                        FROM riwayat_struktural GROUP by anggota_akun_id) r_max
                        ON r_max.anggota_akun_id = a.id
                        LEFT JOIN riwayat_struktural r ON r.id = r_max.max_rid
                        LEFT JOIN struktural s on r.struktural_id = s.id";

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
         $row[] = $da->nama_lengkap;
         $row[] = $da->email;
         $row[] = $da->nama_struktur;
         $row[] = $da->aktif;
               
         
         $row[] = actbtn2($da->id,'akun_anggota'); 


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
	public function add_akun_anggota()
	{
		  $this->form_validation->set_rules($this->PM->memberAccountRules('add')); 
	      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	      if ($this->form_validation->run() == FALSE ) {
	       $ret['status'] = false;
	           foreach ($_POST as $key => $value) {
	               $ret['msg'][$key] = form_error($key);
	           }
	       }
	       else{
	       		

				$data['uniqid']			= $this->token->randomString(10);
	       		$data['nama_lengkap'] 	= $this->input->post('nama_lengkap');
	       		$data['nik']			= $this->input->post('nik');
	       		$data['email']			= $this->input->post('email');
	       		$data['password'] 		= $this->encryption->encrypt( $this->input->post('password') );
	       		$data['struktural_id'] 	= $this->input->post('struktural_id');
	       		$data['created_date']  	= date('Y-m-d H:i:s');
	              
	              $insert = $this->PM->insertDb('anggota_akun', $data);
	                if($insert){
	                		$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
	                }
	                else {
	                		$ret = array("status" => false , "msg"=>"proses simpan data gagal");
	                }
	            }

	        $this->jsonOut($ret); 
	}

	public function edit_akun_anggota($id){
		if($id){
	    	$data   = $this->PM->get_by_id('anggota_akun',$id);
	    		if(isset($data)){
	    			$dt['id'] 				= $data->id;
	    			$dt['nama_lengkap'] 	= $data->nama_lengkap;
	    			$dt['nik'] 				= $data->nik;
	    			$dt['email']  			= $data->email;
	    			$dt['password'] 		= $this->encryption->decrypt($data->password);
	    			$dt['struktural_id'] 	= $data->struktural_id;
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
	public function update_akun_anggota()
	{
			$id = $this->input->post('id');
			$this->form_validation->set_rules($this->PM->memberAccountRules('edit')); 
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

	           	//$data['uniqid']			= $this->token->randomString(10);
	       		$data['nama_lengkap'] 	= $this->input->post('nama_lengkap');
	       		$data['nik']			= $this->input->post('nik');
	       		$data['email']			= $this->input->post('email');
	       		$data['password'] 		= $this->encryption->encrypt( $this->input->post('password') );
	       		//$data['struktural_id'] 	= $this->input->post('struktural_id');
	       		//$data['created_date']  = date('Y-m-d H:i:s');

	                $insert = $this->PM->update('anggota_akun', array('id'=>$id), $data);
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
	public function delete_akun_anggota()
	{
		$data 	= $this->input->post('id');
    	$table 	= 'anggota_akun';

      $ret 		= $this->DataDelete($table,$data);
        
      $this->jsonOut($ret); 
	}


	public function upload_excel(){

	}

	public function import_excel(){
		// HEAD [nik, nama_lengkap, email, password, kk, struktur, aktif ]
	  
     	
        if(!empty($_FILES['berkas']['name']))
            {
                        
                $uploadExcel = $this-> _upload_document('berkas','akun_anggota');
                if ($uploadExcel['status']) {
                    $ret['fileName'] = $uploadExcel['filename'];
                    $ret['status']= true;
                }
                else{
                    $ret['msg']['berkas'] = $uploadExcel['error'];
                    $ret['status'] = false;
                    //$uploadError['foto'] = $uplod_foto['error'];  
                }
                
                
            }
        else{
           $ret['status'] = false;
           $ret['msg']['berkas'] = 'file tidak ditemukan'; 
        }

     	echo json_encode($ret);
           
   
	}


public function proses_file_data($dataLabel,$namaFile){
	
     
     $userID = $this->session->userdata('uid');
    $inputFileName = $this->tempUpload.$namaFile;
    try {

    		

            $objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
            $objReader->setReadDataOnly(true);
            //FileName and Sheet Name
            $objPHPExcel = $objReader->load($inputFileName);
            $worksheet = $objPHPExcel->getSheetByName('Sheet1');
       } catch(Exception $e) {
           
         die( //$this->sent_event($data,'xerror','ending') 
               sse_event($data,'xerror','ending') );
        
       }

                   //City Table
            $dataset = array();
            $databatch = array();
            
            
            $highestRow = $worksheet->getHighestRow(); // e.g. 12
            $highestColumn = $worksheet->getHighestColumn(); // e.g M' 
            $highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn); // e.g. 7
            //Ignoring first row (As it contains column name)
            //ID	NIP	NAMA	USIA	JENIS KELAMIN 	LAMA BEKERJA	PENDIDIKAN TERAKHIR	JABATAN	UNIT KERJA	GAJI	STATUS PERNIKAHAN	JUMLAH ANAK	AKTIF
            //$field = array("","id","nip","nama","usia","gender","lama_kerja","pendidikan","jabatan","unit_kerja","gaji", "marital","anak","aktif");
            //$colist = $this->Amodel->table_fields($jenisData[$dataLabel]);
            //log_message('debug','$colist val = '.print_r($colist));
            // HEAD [nik, nama_lengkap, email, password, kk, struktur, aktif ]
            $colist = array('nik','nama_lengkap','email','password','no_kk','struktural_id','aktif','referral');
           					

            for ($row = 2; $row <= $highestRow; ++$row) {
                //A row selected
                $dataset = array();
                for ($col = 1; $col <= $highestColumnIndex; ++$col) {
                	$randPass = substr(uniqid($col,true), 3, 8);
                    // values till $cityList['1'] till $cityList['last_column_no'] 
                    //$dataset[$col] = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                    $valuenya = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                    
                    $kolom = $colist[$col-1];
                     if($kolom == 'password' ){
						if($valuenya){ 
							$dataset[$kolom] = $this->encryption->encrypt( $valuenya );
						}
						else{ 
							$dataset[$kolom] = $this->encryption->encrypt($randPass);			
						}

			         }
			         
                    else
                    {
                     $dataset[$kolom] = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
                    } 
                    
                    $dataset['uniqid'] =  $this->token->randomString(10);
                    } 
                    //array_push ($databatch, $dataset);
                    //$valid = $this->validate_dataset('peserta',$dataset);
                    $valid = $this->_validate_dataset('memberAccountRules',$dataset) ;
                    if($valid['status']){
                        $sse = "row#".$row." valid";
                        
                        $insert = $this->PM->save('anggota_akun',$dataset);
                        if ($insert){
                            $sse = "row#".$row." Data Akun inserted";
                            $id = $this->db->insert_id();

			        		if(!is_dir( $this->kaderDoc.$dataset['uniqid'])){

			                	mkdir($this->kaderDoc.$dataset['uniqid'],0755);
			                }
                           
                            
                            //$this->sent_event($sse,'msg',null);
                            sse_event($sse,'msg',null);

                            $nikParse = nikParser($dataset['nik']);
                            $dtBiodata['anggota_akun_id'] 	= $id;
                            $dtBiodata['nama_lengkap'] 		= $dataset['nama_lengkap'];
                            //$dtBiodata['nik']				= $dataset['nik'];
                            
                            if($nikParse['status'] == true){
                            	$dtBiodata['gender'] 	= $nikParse['gender_1'];
                            	$dtBiodata['prop_ktp'] 	= $nikParse['propinsi'];
                            	$dtBiodata['kota_ktp'] 	= $nikParse['kota_1'];
                            	$dtBiodata['kec_ktp'] 	= $nikParse['kecamatan_1'];
                            	$dtBiodata['dob'] 		= $nikParse['tanggal_lahir_3'];

                            }
                             $insertBiodata = $this->PM->save('biodata_anggota',$dtBiodata);

                            $dtStruktur['anggota_akun_id'] 	= $id;
                            $dtStruktur['struktural_id'] 	= $dataset['struktural_id'];
                            $dtStruktur['tmt'] 				= date('Y-m-d');
                            $dtStruktur['no_sk']			='0';
                            $insertStruktur = $this->PM->save('riwayat_struktural',$dtStruktur);
                            if($insertStruktur){
                            	$sse =  "row#".$row." Struktural inserted";
                            }
                            else{
                            	$sse =  "row#".$row." Struktural Error";
                            }
                            sse_event($sse,'msg',null);

                            $dtAnggota['anggota_akun_id'] = $id;
                            $dtAnggota['jenis_keanggotaan_id'] = 1;
                            $dtAnggota['tmt'] = date('Y-m-d');
                            $dtAnggota['no_sk'] = '0';
                            $insertAnggota = $this->PM->save('riwayat_keanggotaan',$dtAnggota);
                             if($insertAnggota){
                            	$sse =  "row#".$row." Keanggotaan inserted";
                            }
                            else{
                            	$sse =  "row#".$row." Keanggotaan Error";
                            }
                            sse_event($sse,'msg',null);
                        }
                    }
                    else{
                        $sse = "row#".$row." not-valid <br>".$valid['messages'];
                            
                        //$this->sent_event($sse,'msg',null);
                        sse_event($sse,'msg',null);
                    }
                    unset($dataset);
                    
                    sleep(1);
            //next row, from top
            }
            //$this->sent_event($data,'eventx','ending');
            sse_event($data,'eventx','ending');
            unset($dataLabel);
            unset($namaFile);
            unset($data);
            exit();
    }

    private function _validate_dataset($rulesData, $dataset){
        $this->form_validation->reset_validation();
        //$this->form_validation->set_db('sdm');
        $this->form_validation->set_data($dataset);        
        $this->form_validation->set_rules($this->PM->$rulesData('add'));
        $this->form_validation->set_error_delimiters(' -> ', ' <br>');
    
            if($this->form_validation->run() == FALSE){
                        // validasi gagal
                        //echo validation_errors();
                        foreach ($_POST as $key => $value) {
                        //$ret['messages'][$key] = form_error($key);
                            }
                        $ret['messages'] =  validation_errors();	
                        $ret['status'] = false; 
                    //var_dump($dataset); exit();
                    }
            else {
                        // validasi ok
                        $ret['status'] = TRUE;
                        $ret['messages']='';
                }	
                     return $ret;
    }


private function _upload_document($fieldName, $name,$ovr=true, $ext='xlsx|xls', $maxSize=2000){
    $userId = $this->session->userdata('uid');
    //$noref = $this->input->post('noref');
        $config = array();
        $config['upload_path']          = $this->tempUpload ;
        $config['allowed_types']        = $ext;
        $config['max_size']             = $maxSize; //set max size allowed in Kilobyte
        //$config['max_width']            = $maxWidth; // set max width image allowed
        //$config['max_height']           = $maxHeight; // set max height allowed
        $config['file_name']            = $fieldName.'_'.$name.$userId;
        $config['file_ext_tolower']     = TRUE;
        
        $this->load->library('upload', $config, $fieldName); // Create custom object for foto upload
        $this->$fieldName->initialize($config);
        $this->$fieldName->overwrite = $ovr;
        
        //upload and validate
        if($this->$fieldName->do_upload($fieldName)){
            $res['filename'] = $this->$fieldName->data('file_name');
            $res['error']    = '';
            $res['status']   = true;
        } 
        else { 
            $res['error']    =  $this->$fieldName->display_errors('<p class="text-danger">','</p>');
            $res['filename'] = '' ; 
            $res['status']   = false;
        }
        return $res;
}
}

/* End of file Akun_anggota.php */
/* Location: ./application/modules/pengaturan/controllers/Akun_anggota.php */
