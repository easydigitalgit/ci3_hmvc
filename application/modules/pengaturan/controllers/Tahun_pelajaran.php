<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tahun_pelajaran extends MY_Controller {

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
	public function index()
	{
		$data['konten'] = 'tahunPelajaranKonten';
		$data['libcss'] = '';
		$data['head_tahun_pelajaran']= head_tbl_btn2('tahun_pelajaran',true);
		$this->_theme($data);
	}

	public function table_tahun_pelajaran(){
	  $table        = 'tahun_ajaran';
      $col_order    = array('id'); 
      $col_search   = array('nama_thn_ajaran','kode_thn_ajaran');
      $order        = array('id' => 'ASC');
      $query        = " * FROM tahun_ajaran ";

    
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
         $row[] = $da->nama_thn_ajaran; 
         $row[] = date('d-m-Y',strtotime($da->thn_ajaran_mulai));
         $row[] = date('d-m-Y',strtotime($da->thn_ajaran_akhir));
         $row[] = $da->thn_ajaran_aktif;
        
         $row[] = actbtn2($da->id,'tahun_pelajaran'); 


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
	public function add_tahun_pelajaran()
	{
		  $this->form_validation->set_rules($this->PM->tahunAjaranRules('add')); 
	      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	      if ($this->form_validation->run() == FALSE ) {
	       $ret['status'] = false;
	           foreach ($_POST as $key => $value) {
	               $ret['msg'][$key] = form_error($key);
	           }
	       }
	       else{
	       		

				
	       		$data['kode_thn_ajaran'] 	= $this->input->post('kode_thn_ajaran');
	       		$data['nama_thn_ajaran']	= $this->input->post('nama_thn_ajaran');
	       		$data['thn_ajaran_aktif']	= $this->input->post('thn_ajaran_aktif');
	       		$data['thn_ajaran_mulai'] 	= $this->input->post('thn_ajaran_mulai');
	       		$data['thn_ajaran_akhir'] 	= $this->input->post('thn_ajaran_akhir');
	       		$data['created']  			= date('Y-m-d H:i:s');
	              
	            $insert = $this->PM->insertDb('tahun_ajaran', $data);
	                if($insert){
	                		$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
	                }
	                else {
	                		$ret = array("status" => false , "msg"=>"proses simpan data gagal");
	                }
	            }

	        $this->jsonOut($ret); 
	}

	public function edit_tahun_pelajaran($id){
		if($id){
	    	$data   = $this->PM->get_by_id('tahun_ajaran',$id);
	    		

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
	//Update one item
	public function update_tahun_pelajaran()
	{
		$id = $this->input->post('id');
		$this->form_validation->set_rules($this->PM->tahunAjaranRules('edit')); 
	    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	      if ($this->form_validation->run() == FALSE ) {
	       $ret['status'] = false;
	           foreach ($_POST as $key => $value) {
	               $ret['msg'][$key] = form_error($key);
	           }
	       }
	       else{
	       			
	       		$data['kode_thn_ajaran'] 	= $this->input->post('kode_thn_ajaran');
	       		$data['nama_thn_ajaran']	= $this->input->post('nama_thn_ajaran');
	       		$data['thn_ajaran_aktif']	= $this->input->post('thn_ajaran_aktif');
	       		$data['thn_ajaran_mulai'] 	= $this->input->post('thn_ajaran_mulai');
	       		$data['thn_ajaran_akhir'] 	= $this->input->post('thn_ajaran_akhir');
	       		$data['last_update']  		= date('Y-m-d H:i:s');

	                $insert = $this->PM->update('tahun_ajaran', array('id'=>$id), $data);
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
	public function delete_tahun_pelajaran( )
	{
		$data 	= $this->input->post('id');
    	$table 	= 'tahun_ajaran';

      	$ret 	= $this->DataDelete($table,$data);
        
      	$this->jsonOut($ret); 
	}
}

/* End of file Tahun_pelajaran.php */
/* Location: ./application/modules/pengaturan/controllers/Tahun_pelajaran.php */
