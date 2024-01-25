<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jenjang_kelas extends MY_Controller {

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
	public function index( )
	{
		$data['konten'] = 'jenjangKelasKonten';
		$data['libcss'] = '';
		$data['head_jenjang_kelas']= head_tbl_btn2('jenjang_kelas',true);
		$this->_theme($data);

	}
	public function table_jenjang_kelas(){
	  $table        = 'jenjang_kelas';
      $col_order    = array('id'); 
      $col_search   = array('a.nama_jenjang_kelas');
      $order        = array('id' => 'ASC');
      $query        = "  a.*, b.kode as kode_unit,  b.nama as nama_unit FROM jenjang_kelas a LEFT JOIN unit_sekolah b ON a.unit_sekolah_id = b.id  ";

    
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
         $row[] = '['.$da->kode_unit.'] '.$da->nama_unit;
         $row[] = $da->nama_jenjang_kelas; 
        
        
         $row[] = actbtn2($da->id,'jenjang_kelas'); 


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
	public function add_jenjang_kelas()
	{
		  $this->form_validation->set_rules($this->PM->jenjangKelasRules('add')); 
	      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	      if ($this->form_validation->run() == FALSE ) {
	       $ret['status'] = false;
	           foreach ($_POST as $key => $value) {
	               $ret['msg'][$key] = form_error($key);
	           }
	       }
	       else{
	       		

				
	       		$data['unit_sekolah_id'] 	= $this->input->post('unit_sekolah_id');
	       		$data['nama_jenjang_kelas']	= $this->input->post('nama_jenjang_kelas');
	       		//$data['kode_jenjang_kelas']	= $this->input->post('kode_jenjang_kelas');
	       		
	       		$data['created']  			= date('Y-m-d H:i:s');
	              
	            $insert = $this->PM->insertDb('jenjang_kelas', $data);
	                if($insert){
	                		$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
	                }
	                else {
	                		$ret = array("status" => false , "msg"=>"proses simpan data gagal");
	                }
	            }

	        $this->jsonOut($ret); 
	}

	public function edit_jenjang_kelas($id){

	}

	//Update one item
	public function update_jenjang_kelas( $id  )
	{
		$id = $this->input->post('id');
		  $this->form_validation->set_rules($this->PM->jenjangKelasRules('edit')); 
	      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	      if ($this->form_validation->run() == FALSE ) {
	       $ret['status'] = false;
	           foreach ($_POST as $key => $value) {
	               $ret['msg'][$key] = form_error($key);
	           }
	       }
	       else{
	       		

				
	       		$data['unit_sekolah_id'] 	= $this->input->post('unit_sekolah_id');
	       		$data['nama_jenjang_kelas']	= $this->input->post('nama_jenjang_kelas');
	       		//$data['kode_jenjang_kelas']	= $this->input->post('kode_jenjang_kelas');
	       		
	       		$data['last_update']  			= date('Y-m-d H:i:s');
	              
	            $insert = $this->PM->update('jenjang_kelas', array('id'=>$id), $data);
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
	public function delete_jenjang_kelas( )
	{

	}
}

/* End of file Jenjang_kelas.php */
/* Location: ./application/modules/pengaturan/controllers/Jenjang_kelas.php */
