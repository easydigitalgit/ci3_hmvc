<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenis_tes extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pengaturan_model','PM');

	}
	private function _theme($data){
		
		$data['libjs']  		= jsbyEnv('libPengaturan');
		$data['libcss'] 		= '';
		$data['pjs']        	= jsArray(array('bs4-datatables','select2'));
  		$data['pcss']       	= cssArray(array('datatables','select2'));
		//$data['menu'] 		= 'admin/sideMenu';

		$this->theme->dashboard_theme($data);
	}

	// List all your items
	public function index( $offset = 0 )
	{
		$data['konten'] = 'jenisTesKonten';
		$data['headJenisTes']= head_tbl_btn2('jenis_tes',true);
		$this->_theme($data);
	}

	public function table_jenis_tes(){
	  $table        = 'jenis_tes_seleksi ';
      $col_order    = array('id'); 
      $col_search   = array('a.kode_jenis_tes', 'a.nama_jenis_tes', 'b.nama_kategori_tes');
      $order        = array('id' => 'ASC');
      $query        = "    a.*, b.nama_kategori_tes FROM jenis_tes_seleksi a LEFT JOIN kategori_tes b ON a.kategori_tes_id = b.id ";

    
      $filter       = array();
 
              //get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
      $list  = $this->PM->get_datatables($table,$col_order,$col_search,$order,$query,$filter);
      $data  = array();
      $no    = $_POST['start'];
      foreach ($list as $da) {
         $no++;
         $row   = array();
         $row[] = '<input type="checkbox" class="data-check" value="'.$da->id.'">';
         $row[] = $no; 
         $row[] = $da->nama_kategori_tes;
         $row[] = $da->kode_jenis_tes;
         $row[] = $da->nama_jenis_tes;
       
         $row[] = $da->keterangan_jenis_tes;
         
        
         $row[] = actbtn2($da->id,'jenis_tes'); 


         $data[] = $row;
     }

     $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->PM->count_all_query($table,$filter),
        "recordsFiltered" => $this->PM->count_filtered($query,$filter,$filter),
        "data" => $data,
    );
        //output to json format
      $this->jsonOut($output);
	}

	// Add a new item
	public function add_jenis_tes()
	{
		 $this->form_validation->set_rules($this->PM->jenisTesRules('add')); 
	      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	      if ($this->form_validation->run() == FALSE ) {
	       $ret['status'] = false;
	           foreach ($_POST as $key => $value) {
	               $ret['msg'][$key] = form_error($key);
	           }
	       }
	       else{
	       		

				$data['kategori_tes_id']		= $this->input->post('kategori_tes_id');
	       		$data['kode_jenis_tes'] 		= $this->input->post('kode_jenis_tes');
	       		$data['nama_jenis_tes']			= $this->input->post('nama_jenis_tes');
	       		$data['keterangan_jenis_tes']	= $this->input->post('keterangan_jenis_tes');
	       		
	       		
	       		$data['last_update']  			= date('Y-m-d H:i:s');
	              
	            $insert = $this->PM->insertDb('jenis_tes_seleksi ', $data);
	                if($insert){
	                		$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
	                }
	                else {
	                		$ret = array("status" => false , "msg"=>"proses simpan data gagal");
	                }
	            }

	        $this->jsonOut($ret); 
	}

	//Update one item
	public function update_jenis_tes()
	{
			$this->form_validation->set_rules($this->PM->jenisTesRules('edit')); 
	      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	      if ($this->form_validation->run() == FALSE ) {
	       $ret['status'] = false;
	           foreach ($_POST as $key => $value) {
	               $ret['msg'][$key] = form_error($key);
	           }
	       }
	       else{
	       		
	       		$id = $this->input->post('id');
				$data['kategori_tes_id']		= $this->input->post('kategori_tes_id');
	       		$data['kode_jenis_tes'] 		= $this->input->post('kode_jenis_tes');
	       		$data['nama_jenis_tes']			= $this->input->post('nama_jenis_tes');
	       		$data['keterangan_jenis_tes']	= $this->input->post('keterangan_jenis_tes');
	       		
	       		
	       		$data['last_update']  			= date('Y-m-d H:i:s');
	       		
	       		
	       		//$data['last_update']  			= date('Y-m-d H:i:s');
	              
	            $insert = $this->PM->update('jenis_tes_seleksi', array('id'=>$id), $data);
	                if($insert){
	                		$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
	                }
	                else {
	                		$ret = array("status" => false , "msg"=>"proses simpan data gagal");
	                }
	            }

	        $this->jsonOut($ret); 

	}

	public function edit_jenis_tes($id){
		if($id){
	    	$data   = $this->PM->get_by_id('jenis_tes_seleksi',$id);
	    		

		    if($data){
		        $ret['status'] 	= true;
		        $ret['data'] 	= $data;
		    }
		    else{
		        $ret['status'] 	= false;
		        $ret['data'] 	= 0;
		    }
	 	 }
	  	else{
			    $ret['status'] 	= false;
			    $ret['data'] 	= 0;
		  	}

	  $this->jsonOut($ret);
	}

	//Delete one item
	public function delete_jenis_tes( )
	{
		$table 	= 'jenis_tes_seleksi';
		$data 	= $this->input->post('id');

      	$ret 	= $this->DataDelete($table,$data);
        
      	$this->jsonOut($ret); 
	}
}

/* End of file Jenis_tes.php */
/* Location: ./application/modules/pengaturan/controllers/Jenis_tes.php */
