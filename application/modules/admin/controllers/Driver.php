<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Driver extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
		$this->load->model('Admin_model','AM');
		$this->load->library('SelectOption');

	}

	private function _theme($data){
		
		$data['libjs']  	= jsbyEnv(array('libDriver'));
		$data['libcss'] 	= '';
		$data['pjs']        = jsArray(array('bs4-datatables','select2'));
  		$data['pcss']       = cssArray(array('datatables','select2','select2-bs4'));
		//$data['menu'] 		= 'admin/sideMenu';

		$this->theme->dashboard_theme($data);
	}




	// List all your items
	public function index($string=null)
	{


		$data['konten'] = 'driverKonten';
		
		$data['head_data_driver'] = head_tbl_btn2('data_driver',true);
		
		$this->_theme($data);
	}

public function table_data_driver(){
	  $table        = 'profil_driver';
      $col_order    = array('a.id'); 
      $col_search   = array('a.id','a.nama_lengkap','a.nik','b.tnkb');
      $order        = array('a.id' => 'ASC');
      $query        = " a.*, b.tnkb, b.merek FROM `profil_driver` a LEFT join armada b ON a.armada_id = b.id ";

      $filter       = array();
              //get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
      $list  = $this->AM->get_datatables($table,$col_order,$col_search,$order,$query,$filter);
      $data  = array();
      $no    = $_POST['start'];
      foreach ($list as $da) {
         $no++;
         $row   = array();
         $row[] = '<input type="checkbox" class="data-check" value="'.$da->id.'">';
         $row[] = $no; 
         $row[] = $da->foto ? '<img src="'.base_url('AppDoc/dokumen_driver/').$da->foto.'" alt="" width="90px">' : '' ;
         $row[] = $da->nik; 
         $row[] = $da->nama_lengkap . '<br> ['.$da->tnkb.'] '.$da->merek;
         $row[] = $da->pob.','.date('d-m-Y',strtotime($da->dob));
         $row[] = $da->alamat_ktp;
         $row[] = '<img src="'.base_url('AppDoc/dokumen_driver/').$da->scan_ktp.'" width="90px" alt="" class="mx-1 my-1"> <img src="'.base_url('AppDoc/dokumen_driver/').$da->scan_sim.'" width="90px" alt="" class="mx-1 my-1">';
         $row[] = actbtn2($da->id,'data_driver'); 


         $data[] = $row;
     }

     $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->AM->count_all_query($table,$filter),
        "recordsFiltered" => $this->AM->count_filtered($query,$filter,$filter),
        "data" => $data,
    );
        //output to json format
      $this->jsonOut($output);
     
	}
	// Add a new item
	public function add_data_driver()
	{
		  $this->form_validation->set_rules($this->AM->dataDriverRules('add')); 
	      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	      if ($this->form_validation->run() == FALSE ) {
	       $ret['status'] = false;
	           foreach ($_POST as $key => $value) {
	               $ret['msg'][$key] = form_error($key);
	           }
	       }
	       else{

	             $data['akun_id']    			= $this->input->post('akun_id');
	             $data['nama_lengkap']   	 	= $this->input->post('nama_lengkap');
	             $data['nik']      				= $this->input->post('nik');
	             $data['armada_id']				= $this->input->post('armada_id');
	             $data['pob']					= $this->input->post('pob');

	             $data['dob'] 					= date('Y-m-d', strtotime($this->input->post('dob'))) ;
	             $data['alamat_ktp']			= $this->input->post('alamat_ktp');
	             $data['prop_ktp']	 			= $this->input->post('prop_ktp');
	             $data['kota_ktp']				= $this->input->post('kota_ktp');
	             $data['kec_ktp']				= $this->input->post('kec_ktp');
	             $data['desa_ktp']				= $this->input->post('desa_ktp');
	             $data['alamat_tinggal']		= $this->input->post('alamat_tinggal');
	             $data['prop_tinggal']	 		= $this->input->post('prop_tinggal');
	             $data['kota_tinggal']			= $this->input->post('kota_tinggal');
	             $data['kec_tinggal']			= $this->input->post('kec_tinggal');
	             $data['desa_tinggal']			= $this->input->post('desa_tinggal');

	             $data['no_sim']				= $this->input->post('no_sim');
	             $data['masa_berlaku_sim'] 		= date('Y-m-d',strtotime($this->input->post('masa_berlaku_sim')));


	             $data['created']			= date('Y-m-d H:i:s');
	             $data['last_update']		= date('Y-m-d H:i:s');
	            
	                $imageFolder = 'dokumen_driver';
	        		if(!is_dir($this->AppDoc.$imageFolder)){

	                	mkdir($this->AppDoc.$imageFolder,0755);
	                }

	                 $ret = array("status" => true , "msg"=>"data belum disimpan");
	             if(!empty($_FILES['foto']['name']))
                    {
                        $filename = $this->input->post('akun_id').'_'.uniqid();
                        $uplod_foto = $this->_upload_images('foto',$filename,$imageFolder);
                        if ($uplod_foto['status']) {
                            $data['foto'] = $uplod_foto['filename'];
                            $ret['status']= true;
                        }
                        else{
                            $ret['msg']['foto'] = $uplod_foto['error'];
                            $ret['status'] = false;
                            $uploadError['foto'] = $uplod_foto['error'];  
                        }
                        
                        
                    }
                    if(!empty($_FILES['scan_ktp']['name']))
                    {
                        $filename = $this->input->post('akun_id').'_'.uniqid();
                        $uplod_foto = $this->_upload_images('scan_ktp',$filename,$imageFolder);
                        if ($uplod_foto['status']) {
                            $data['scan_ktp'] = $uplod_foto['filename'];
                            $ret['status']= true;
                        }
                        else{
                            $ret['msg']['scan_ktp'] = $uplod_foto['error'];
                            $ret['status'] = false;
                            $uploadError['scan_ktp'] = $uplod_foto['error'];  
                        }
                        
                        
                    }
                     if(!empty($_FILES['scan_sim']['name']))
                    {
                        $filename = $this->input->post('akun_id').'_'.uniqid();
                        $uplod_foto = $this->_upload_images('scan_sim',$filename,$imageFolder);
                        if ($uplod_foto['status']) {
                            $data['scan_sim'] = $uplod_foto['filename'];
                            $ret['status']= true;
                        }
                        else{
                            $ret['msg']['scan_sim'] = $uplod_foto['error'];
                            $ret['status'] = false;
                            $uploadError['scan_sim'] = $uplod_foto['error'];  
                        }
                        
                        
                    }


                  if($ret['status']){
                  	$insert = $this->AM->insertDb('profil_driver', $data);
                  	log_message('debug','query = '.$this->db->last_query());
	                if($insert){

	                $ret = array("status" => true , "msg"=>"proses simpan data berhasil");
	                }
	                else {
	                $ret = array("status" => false , "msg"=>"proses simpan data gagal");
	                }
                  }  
	              
	            }

	        $this->jsonOut($ret);  
	}

	public function edit_data_driver($id){
		if($id){
	    	$data   = $this->AM->get_by_id('profil_driver',$id);
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
	public function update_data_driver()
	{
		$id = $this->input->post('id');
		$this->form_validation->set_rules($this->AM->dataDriverRules('update')); 
	      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	      if ($this->form_validation->run() == FALSE ) {
	       $ret['status'] = false;
	           foreach ($_POST as $key => $value) {
	               $ret['msg'][$key] = form_error($key);
	           }
	       }
	       else{

	             $data['akun_id']    			= $this->input->post('akun_id');
	             $data['nama_lengkap']   	 	= $this->input->post('nama_lengkap');
	             $data['nik']      				= $this->input->post('nik');
	             $data['armada_id']				= $this->input->post('armada_id');
	             $data['pob']					= $this->input->post('pob');

	             $data['dob'] 					= date('Y-m-d', strtotime($this->input->post('dob'))) ;
	             $data['alamat_ktp']			= $this->input->post('alamat_ktp');
	             $data['prop_ktp']	 			= $this->input->post('prop_ktp');
	             $data['kota_ktp']				= $this->input->post('kota_ktp');
	             $data['kec_ktp']				= $this->input->post('kec_ktp');
	             $data['desa_ktp']				= $this->input->post('desa_ktp');
	             $data['alamat_tinggal']		= $this->input->post('alamat_tinggal');
	             $data['prop_tinggal']	 		= $this->input->post('prop_tinggal');
	             $data['kota_tinggal']			= $this->input->post('kota_tinggal');
	             $data['kec_tinggal']			= $this->input->post('kec_tinggal');
	             $data['desa_tinggal']			= $this->input->post('desa_tinggal');

	             $data['no_sim']				= $this->input->post('no_sim');
	             $data['masa_berlaku_sim'] 		= date('Y-m-d',strtotime($this->input->post('masa_berlaku_sim')));


	             
	             $data['last_update']		= date('Y-m-d H:i:s');
	            
	            
	                $imageFolder = 'dokumen_driver';
	        		if(!is_dir($this->AppDoc.$imageFolder)){

	                	mkdir($this->AppDoc.$imageFolder,0755);
	                }

	                 $ret = array("status" => true , "msg"=>"data belum disimpan");
	              if(!empty($_FILES['foto']['name']))
                    {
                        $filename = $this->input->post('akun_id').'_'.uniqid();
                        $uplod_foto = $this->_upload_images('foto',$filename,$imageFolder);
                        if ($uplod_foto['status']) {
                            $data['foto'] = $uplod_foto['filename'];
                            $ret['status']= true;
                        }
                        else{
                            $ret['msg']['foto'] = $uplod_foto['error'];
                            $ret['status'] = false;
                            $uploadError['foto'] = $uplod_foto['error'];  
                        }
                        
                        
                    }
                    if(!empty($_FILES['scan_ktp']['name']))
                    {
                        $filename = $this->input->post('akun_id').'_'.uniqid();
                        $uplod_foto = $this->_upload_images('scan_ktp',$filename,$imageFolder);
                        if ($uplod_foto['status']) {
                            $data['scan_ktp'] = $uplod_foto['filename'];
                            $ret['status']= true;
                        }
                        else{
                            $ret['msg']['scan_ktp'] = $uplod_foto['error'];
                            $ret['status'] = false;
                            $uploadError['scan_ktp'] = $uplod_foto['error'];  
                        }
                        
                        
                    }
                     if(!empty($_FILES['scan_sim']['name']))
                    {
                        $filename = $this->input->post('akun_id').'_'.uniqid();
                        $uplod_foto = $this->_upload_images('scan_sim',$filename,$imageFolder);
                        if ($uplod_foto['status']) {
                            $data['scan_sim'] = $uplod_foto['filename'];
                            $ret['status']= true;
                        }
                        else{
                            $ret['msg']['scan_sim'] = $uplod_foto['error'];
                            $ret['status'] = false;
                            $uploadError['scan_sim'] = $uplod_foto['error'];  
                        }
                        
                        
                    }


                  if($ret['status']){
                  
                  	$insert = $this->AM->update('profil_driver',array('id'=>$id), $data);
	                if($insert){

	                	$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
	                }
	                else {
	                	$ret = array("status" => false , "msg"=>"proses simpan data gagal");
	                }
                  }  
	              
	            }

	        $this->jsonOut($ret);
	}

	//Delete one item
	public function delete_data_driver( )
	{
		$list_id = $this->input->post('id');
    	$table = 'profil_driver';

        if(is_array($list_id)){
            if(!empty($list_id)){
                $del = $this->AM->bulk_delete($table,$list_id);
                if($del){
                    $ret['status'] = true;
                    $ret['msg'] = 'Data berhasil dihapus';
                }
                else{
                    $ret['status'] = false;
                    $ret['msg'] = 'Proses hapus data gagal';
                }  
            }    
        }
        elseif($list_id){
            $del = $this->AM->delete_by_id($table,$list_id);
            if($del){
                    $ret['status'] = true;
                    $ret['msg'] = 'Data berhasil dihapus';
                }
                else{
                    $ret['status'] = false;
                    $ret['msg'] = 'Proses hapus data gagal';
                }
        }
        else{
            $ret['status'] = false;
            $ret['msg'] = 'Data belum dipilih';
        }
        
       $this->jsonOut($ret); 
	}
	

public function select_driver_akun(){
	$q = $this->AM->akunDriverSelect2();
	//log_message('error',$this->db->last_query());
	$this->jsonOut($q);
}

public function select_armada(){
	echo $this->selectoption->selectArmada();
}

public function get_nama_driver($id){
	$ret = [];
	if ($id) {
		$q = $this->AM->getProfilByAkunID($id);
		if ($q) {
			foreach ($q as $key => $value) {
				$ret['data'][$key] = $value;
			}
		}
		else{
			$data   = $this->AM->get_by_id('user_akun',$id);
			if($data){
				$ret['data']['nama_lengkap'] = $data->nama;
			}
		}
		
	}
	$this->jsonOut ($ret);
}


	private function _upload_images($fieldName, $name,$folder,$ovr=true, $ext='jpg|JPG|jpeg|JPEG|png|PNG', $maxSize=2500, $maxWidth=2500, $maxHeight=2500){
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

/* End of file Driver.php */
/* Location: ./application/modules/admin/controllers/Driver.php */
