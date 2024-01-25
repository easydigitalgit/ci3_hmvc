  <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_program_kerja extends MY_Controller {
public function __construct()
{
	parent::__construct();
	$this->userType == 'admin' ? '' : $this->logout();
	$this->load->model('ProgramKerja_model','PM');
	$this->load->helper('formater');
	$this->load->library('SelectOption');
}

private function _theme($data){

		$data['libjs']  	= jsbyEnv('libProgramKerja');
		$data['libcss'] 	= '';
		$data['pjs']        = jsArray(array('bs4-datatables','moment','daterangepicker'));
  		$data['pcss']       = cssArray(array('datatables','daterangepicker'));
		
		$this->theme->dashboard_theme($data);
		
	}

	// List all your items
	public function index()
	{
		$data['konten'] 			=  'programKerjaKonten';
		$data['head_data_program'] 	= head_tbl_btn2('data_program',true);
		$this->_theme($data);
	}

	public function table_data_program(){
	  $table        = 'event';
      $col_order    = array('a.id'); 
      $col_search   = array('a.id','a.nama_event','a.kode_event','b.nama_jenis_event');
      $order        = array('a.id' => 'DESC');
      $query        = "  a.*, b.nama_jenis_event, c.kode_struktur, c.nama_struktur FROM `event` a LEFT JOIN jenis_event b ON a.id_jenis_event = b.id LEFT JOIN struktural c ON a.struktural_id = c.id ";


      if($this->userStrukturalID == 1){
      	$filter       = array();	
      }                                  
      else{
      	$filter = array('a.struktural_id'=> $this->userStrukturalID);
      	
      }
      $xfilter = array();

      
              //get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
      $list  = $this->PM->get_datatables($table,$col_order,$col_search,$order,$query,$filter);
      $data  = array();
      $no    = $_POST['start'];
      foreach ($list as $da) {
         $no++;
         $row   = array();
         $row[] = '<input type="checkbox" class="data-check" value="'.$da->id.'">';
         $row[] = $no; 
         $row[] = $da->nama_jenis_event;
         $row[] = $da->nama_struktur; 
         $row[] = '['.$da->kode_event.'] '.$da->nama_event;
         $row[] = date('d-m-Y h:i:s',strtotime($da->start_event)).' s/d '. date('d-m-Y h:i:s',strtotime($da->end_event));
         $row[] = $da->alamat_event;
         $row[] = $da->deskripsi_event;

         $row[] = actbtn2($da->id,'data_program'); 


         $data[] = $row;
     }

     $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->PM->count_all_query($table,$xfilter),
        "recordsFiltered" => $this->PM->count_filtered($query,$filter,$filter),
        "data" => $data,
    );
        //output to json format
      $this->jsonOut($output);
	}

	// Add a new item
	public function add_data_program()
	{
		  $this->form_validation->set_rules($this->PM->dataEventRules('add')); 
	      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	      if ($this->form_validation->run() == FALSE ) {
	       $ret['status'] = false;
	           foreach ($_POST as $key => $value) {
	               $ret['msg'][$key] = form_error($key);
	           }
	       }
	       else{
	       		 $data['id_jenis_event']	= $this->input->post('id_jenis_event');
	             $data['nama_event']   	 	= $this->input->post('nama_event');
	             $data['kode_event']    	= $this->input->post('kode_event');
	             $data['deskripsi_event']   = $this->input->post('deskripsi_event');
	             $data['start_event']		= date( 'Y-m-d H:i:s', strtotime( $this->input->post('start_event') ) ) ;
	             $data['end_event']			= date( 'Y-m-d H:i:s', strtotime( $this->input->post('end_event') ) ) ;
	             $data['alamat_event']		= $this->input->post('alamat_event');
	             $data['struktural_id']		= $this->input->post('struktural_id');
	             $data['created']			= date('Y-m-d H:i:s');
	             $data['createdby']			= $this->userID;

	              $insert = $this->PM->insertDb('event', $data);
	                if($insert){

	                	$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
	                }
	                else {
	                	$ret = array("status" => false , "msg"=>"proses simpan data gagal");
	                }
	            }

	        $this->jsonOut($ret);

	}

	public function edit_data_program($id){
		 if($id){
	    	$data   = $this->PM->get_by_id('event',$id);
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
	public function update_data_program()
	{
		$id = $this->input->post('id');
		  $this->form_validation->set_rules($this->PM->dataEventRules('edit')); 
	      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	      if ($this->form_validation->run() == FALSE ) {
	       $ret['status'] = false;
	           foreach ($_POST as $key => $value) {
	               $ret['msg'][$key] = form_error($key);
	           }
	       }
	       else{

	            $data['id_jenis_event']	= $this->input->post('id_jenis_event');
	             $data['nama_event']   	 	= $this->input->post('nama_event');
	             $data['kode_event']    	= $this->input->post('kode_event');
	             $data['deskripsi_event']   = $this->input->post('deskripsi_event');
	             $data['start_event']		= date( 'Y-m-d H:i:s', strtotime( $this->input->post('start_event') ) ) ;
	             $data['end_event']			= date( 'Y-m-d H:i:s', strtotime( $this->input->post('end_event') ) ) ;
	             $data['alamat_event']		= $this->input->post('alamat_event');
	             $data['struktural_id']		= $this->input->post('struktural_id');
	             $data['created']			= date('Y-m-d H:i:s');
	            


	             $insert = $this->PM->update('event',array('id'=>$id), $data);
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
	public function delete_data_program()
	{
		$list_id 	= $this->input->post('id');
    	$table 		= 'event';

        if(is_array($list_id)){
            if(!empty($list_id)){
                $del = $this->PM->bulk_delete($table,$list_id);
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
            $del = $this->PM->delete_by_id($table,$list_id);
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


	public function select_jenis_event(){
		echo $this->selectoption->selectJenisEvent();
	}

	public function select_struktural(){
		if ($this->userStrukturalID == 1) {
			echo $this->selectoption->selectStruktural();
		}
		else{
			 echo '<option value="'.$this->userStrukturalID.'" selected>'.StrukturalName( $this->userStrukturalID  ).'</option>';
		}
	}

}

/* End of file Data_program.php */
/* Location: ./application/modules/program_kerja/controllers/Data_program.php */