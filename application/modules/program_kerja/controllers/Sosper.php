<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sosper extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ProgramKerja_model','PKM');

	}
	private function _theme($data){

		$data['libjs']  	= jsbyEnv('libProgramKerja');
		$data['libcss'] 	= '';
		$data['pjs']        = jsArray(array('bs4-datatables','moment','daterangepicker'));
  		$data['pcss']       = cssArray(array('datatables','daterangepicker'));
		$data['menu'] 		= 'admin/sideMenu';

		$this->theme->dashboard_theme($data);
	}

	// List all your items
	public function index()
	{
		$data['konten'] =  'programSosperKonten';
		$data['head_data_sosper'] = head_tbl_btn2('data_sosper',true);
		$this->_theme($data);
	}

	public function table_data_sosper(){
	  $table        = 'event_sosper';
      $col_order    = array($table.'.id'); 
      $col_search   = array($table.'.id',$table.'.nama',$table.'.kode',$table.'.aleg');
      $order        = array($table.'.id' => 'DESC');
      $query        = " * FROM event_sosper ";

      $filter       = array();
              //get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
      $list  = $this ->PKM->get_datatables($table,$col_order,$col_search,$order,$query,$filter);
      $data  = array();
      $no    = $_POST['start'];
      foreach ($list as $da) {
         $no++;
         $row   = array();
         $row[] = '<input type="checkbox" class="data-check" value="'.$da->id.'">';
         $row[] = $no; 
         $row[] = $da->kode; 
         $row[] = $da->nama;
         $row[] = $da->waktu;
         $row[] = $da->tempat;
         $row[] = $da->aleg;

         $row[] = actbtn2($da->id,'data_sosper'); 


         $data[] = $row;
     }

     $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this ->PKM->count_all_query($table,$filter),
        "recordsFiltered" => $this ->PKM->count_filtered($query,$filter,$filter),
        "data" => $data,
    );
        //output to json format
      $this->jsonOut($output);
	}

	// Add a new item
	public function add_data_sosper()
	{
		  $this->form_validation->set_rules($this->PKM->eventSosperRules('add')); 
	      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	      if ($this->form_validation->run() == FALSE ) {
	       $ret['status'] = false;
	           foreach ($_POST as $key => $value) {
	               $ret['msg'][$key] = form_error($key);
	           }
	       }
	       else{

	             $data['nama']   	 	= $this->input->post('nama');
	             $data['kode']    		= $this->input->post('kode');
	             $data['deskripsi']     = $this->input->post('deskripsi');

	             $data['waktu']			= date( 'Y-m-d H:i:s', strtotime( $this->input->post('waktu') ) ) ;
	             $data['aleg']			= $this->input->post('aleg');
	             $data['tempat']		= $this->input->post('tempat');


	              $insert = $this->PKM->insertDb('event_sosper', $data);
	                if($insert){

	                	$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
	                }
	                else {
	                	$ret = array("status" => false , "msg"=>"proses simpan data gagal");
	                }
	            }

	        $this->jsonOut($ret);

	}

	public function edit_data_sosper($id){
		 if($id){
	    	$data   = $this->PKM->get_by_id('event_sosper',$id);
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
	public function update_data_sosper()
	{
		$id = $this->input->post('id');
		  $this->form_validation->set_rules($this->PKM->eventSosperRules('edit')); 
	      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	      if ($this->form_validation->run() == FALSE ) {
	       $ret['status'] = false;
	           foreach ($_POST as $key => $value) {
	               $ret['msg'][$key] = form_error($key);
	           }
	       }
	       else{

	             $data['nama']   	 	= $this->input->post('nama');
	             $data['kode']    		= $this->input->post('kode');
	             $data['deskripsi']     = $this->input->post('deskripsi');
	             $data['waktu']			= date( 'Y-m-d H:i:s', strtotime( $this->input->post('waktu') ) ) ;
	             $data['aleg']			= $this->input->post('aleg');
	             $data['tempat']		= $this->input->post('tempat');


	             $insert = $this->PKM->update('event_sosper',array('id'=>$id), $data);
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
	public function delete_data_sosper()
	{
		$list_id 	= $this->input->post('id');
    	$table 		= 'event_sosper';

        if(is_array($list_id)){
            if(!empty($list_id)){
                $del = $this->PKM->bulk_delete($table,$list_id);
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
            $del = $this->PKM->delete_by_id($table,$list_id);
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
	
}

/* End of file Sosper_reses.php */
/* Location: ./application/modules/program_kerja/controllers/Sosper_reses.php */
