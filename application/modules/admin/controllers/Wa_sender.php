<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wa_sender extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model','AM');
		$this->load->helper('starsender');

	}


	private function _theme($data){
		
		$data['libjs']  	= jsbyEnv(array('libWaSender'));
		$data['libcss'] 	= '';
		$data['pjs']        = jsArray(array('bs4-datatables','select2','chartjs'));
  		$data['pcss']       = cssArray(array('datatables','select2','chartjs'));
		//$data['menu'] 		= 'admin/sideMenu';

		$this->theme->dashboard_theme($data);
	}


	// List all your items
	public function testmsg( $nama='' )
	{
		$KEY = 'e06ff4b72915a8d440502e7890c8d688b801341c';
		$text 		= 'Terima kasih kepada bapak/ibu '.$nama.' yang telah menggunakan layanan Ambulan Hidayatullah, Dukung kami agar terus bermanfaat untuk semua. ['.date('Y/m/d H:i:s').']';
		$number 	= '082261631836';
		$response 	= sendtext($number,$text,$KEY);
		log_message('debug','response = '.$response);
		$this->jsonOut($response);
	}

	public function send_message(){
		$q = $this->db->get_where('wa_sender',array('status'=>'notsent'));
		if($q->num_rows()){
			$val  		= $q->row();
			$text 		= $val->body;
			$number 	= $val->no_hp;
			$id 		= $val->id;
			$response 	= sendtext($number,$text,null);

			$sendStatus = $response['status'] == true ? 'sent' : 'failed';

			$data['respon'] 	= $response;
			$data['status'] 	= $sendStatus;

			$update = $this->db->update('wa_sender', array('id'=>$id),$data);
			if($update){
				$ret['msg'] = 'message Sent';
			}
			else{
				$ret['msg'] = 'Terjadi sebuah kesalahan';
			}
		}
		else{
			$ret['msg'] = 'no data';
		}
		$this->jsonOut($ret);
	}

	public function direct_msg()
	{
		$number = $this->input->post('no_hp');
		$text = $this->input->post('pesan');
		$response 	= sendtext($number,$text,$apikey=null);
		$this->jsonOut($response);
	}

	public function index(){

		$data['konten'] = 'waTemplateKonten';
		$data['head_wa_template'] = head_tbl_btn2('wa_template',true);
		
		$this->_theme($data);
	}

	public function table_wa_template(){
	  $table        = 'wa_template';
      $col_order    = array($table.'.id'); 
      $col_search   = array($table.'.id',$table.'.kode',$table.'.tema');
      $order        = array($table.'.id' => 'ASC');
      $query        = " * FROM wa_template ";

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
         $row[] = $da->kode; 
         $row[] = $da->tema;
         $row[] = $da->teks_pesan;
         $row[] = $da->status == 1 ? badgeLabel('Aktif','badge-info') : badgeLabel('Non-Aktif','badge-secondary') ;
       
         $row[] = actbtn2($da->id,'wa_template'); 


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
	public function add_wa_template()
	{
		 $this->form_validation->set_rules($this->AM->waTemplateRules('add')); 
	      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	      if ($this->form_validation->run() == FALSE ) {
	       $ret['status'] = false;
	           foreach ($_POST as $key => $value) {
	               $ret['msg'][$key] = form_error($key);
	           }
	       }
	       else{

	             $data['kode']    		= $this->input->post('kode');
	             $data['tema']   	 	= $this->input->post('tema');
	             $data['teks_pesan']    = $this->input->post('teks_pesan');
	             $data['created']		= date('Y-m-d H:i:s');
	             $data['last_update']	= date('Y-m-d H:i:s');
	             
	           //  $data['last_update']		= $this->input->post('no_mesin');
	            
	             


                 
                  	$insert = $this->AM->save('wa_template', $data);
	                if($insert){

	                	$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
	                }
	                else {
	                	$ret = array("status" => false , "msg"=>"proses simpan data gagal");
	                }
                   
	              
	            }

	        $this->jsonOut($ret);  
	}

	public function edit_wa_template($id){
		if($id){
	    	$data   = $this->AM->get_by_id('wa_template',$id);
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
	public function update_wa_template()
	{
			$id = $this->input->post('id');
		  $this->form_validation->set_rules($this->AM->waTemplateRules('add')); 
	      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	      if ($this->form_validation->run() == FALSE ) {
	       $ret['status'] = false;
	           foreach ($_POST as $key => $value) {
	               $ret['msg'][$key] = form_error($key);
	           }
	       }
	       else{

	             $data['kode']    		= $this->input->post('kode');
	             $data['tema']   	 	= $this->input->post('tema');
	             $data['teks_pesan']    = $this->input->post('teks_pesan');
	             $data['created']		= date('Y-m-d H:i:s');
	             $data['last_update']	= date('Y-m-d H:i:s');
	             
	           //  $data['last_update']		= $this->input->post('no_mesin');
	            
	             


                 
                  	$insert = $this->AM->update('wa_template',array('id'=>$id), $data);
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
	public function delete_wa_template()
	{
		$list_id = $this->input->post('id');
    	$table = 'wa_template';

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
}

/* End of file Wa_sender.php */
/* Location: ./application/modules/admin/controllers/Wa_sender.php */
