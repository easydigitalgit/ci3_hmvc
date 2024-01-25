<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_account extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
        $this->userType == 'admin' ? '' : $this->logout();
		$this->load->model('UserAccount_model','UAM');

	}



	// List all your items
	public function index( $offset = 0 )
	{

	}

	// Add a new item
	public function data_akun_pengguna(){

    $data['konten'] =  'dataAkunPengguna';
        $data['libjs']  = '';//jsbyEnv('libLogin');
        $data['libcss'] = '';
        $data['head_data_akun_pengguna'] = head_tbl_btn2('data_akun_pengguna',true);
        
        $this->_adminTheme($data);


    }
    public function table_data_akun_pengguna(){
      $table        = 'user';
      $col_order    = array('a.id'); 
      $col_search   = array('a.id','a.username','b.kode_grup');
      $order        = array('a.id' => 'DESC');
      $query        = " a.id, a.username, a.email, b.kode_grup, c.nama as level, a.aktif FROM user a LEFT JOIN user_grup b ON a.grup_id = b.id LEFT JOIN user_level c ON a.level = c.id ";

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
         $row[] = $da->username; 
         $row[] = $da->email;
         $row[] = $da->kode_grup;
         $row[] = $da->level; 
         $row[] = $da->aktif;

                     //add html for action
         $row[] = actbtn2($da->id,'data_akun_pengguna'); 

                     // detail tambahan

         $data[] = $row;
     }

     $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->AM->count_all_query($table,$filter),
        "recordsFiltered" => $this->AM->count_filtered($query,$filter,$filter),
        "data" => $data,
    );
        //output to json format
     header('Content-Type: application/json');
     echo json_encode($output);
 }


 public function add_data_user(){
    $this->form_validation->set_rules($this->AM->userAccountRules('add')); 
    $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
    if ($this->form_validation->run() == FALSE ) {
        $ret['status'] = false;
        foreach ($_POST as $key => $value) {
            $ret['msg'][$key] = form_error($key);
        }

    } 
    else{

      $data['username']           = $this->input->post('username');
      $data['email']              = $this->input->post('email');
      $data['grup_id']            = $this->input->post('grup_id');
      $data['aktif']              = $this->input->post('aktif');


      $insert = $this->AM->insertDb('user',$data);
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
	public function update( $id = NULL )
	{

	}

	//Delete one item
	public function delete( $id = NULL )
	{

	}
}

/* End of file User_account.php */
/* Location: ./application/modules/pengaturan/controllers/User_account.php */
