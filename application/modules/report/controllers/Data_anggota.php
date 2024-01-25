<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Data_anggota extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
		$this->load->model('Report_model','RM');

	}

	private function _theme($data){

		$data['libjs']  	= jsbyEnv('libReport');
		$data['libcss'] 	= '';
		$data['pjs']        = jsArray(array('bs4-datatables'));
  		$data['pcss']       = cssArray(array('datatables'));
		$data['menu'] 		= 'admin/sideMenu';

		$this->theme->dashboard_theme($data);
	}
	public function index()
	{
		$data['konten'] 					= 'ReportDataAnggotaKonten';
		$data['head_data_report_anggota'] 	= head_tbl_btn2('data_report_anggota',true);
		$this->_theme($data);
	}


	public function table_data_report_anggota(){
	  $table        = 'biodata_anggota';
      $col_order    = array('b.id'); 
      $col_search   = array('a.nama_lengkap','a.gender','s.nama_struktur');
      $order        = array('b.id' => 'ASC');
      $query        = " b.id as akunid, b.nama_lengkap as akunnama, b.nik as akunnik, b.nama_struktur as akunstruktur, a.nama_lengkap, a.gelar_depan, a.gelar_belakang, a.gender, a.marital, a.dob, a.pob, r.id as riwayat_struktural_id, r.struktural_id, s.nama_struktur, c.username, k_max.k_id, j.nama_jenis_keanggotaan FROM biodata_anggota a 
          LEFT JOIN ( SELECT MAX(id) max_rid , anggota_akun_id FROM riwayat_struktural GROUP BY anggota_akun_id ) r_max ON (r_max.anggota_akun_id = a.anggota_akun_id)
			LEFT JOIN riwayat_struktural r ON r.id = r_max.max_rid 
			LEFT JOIN struktural s ON r.struktural_id = s.id 
			LEFT JOIN ( SELECT aa.*,ss.nama_struktur FROM anggota_akun aa left JOIN struktural ss ON aa.struktural_id = ss.id) b ON b.id = a.anggota_akun_id 
			LEFT JOIN user_akun c ON a.verifiedby = c.id

			LEFT JOIN (SELECT MAX(rk.id) k_id, rk.anggota_akun_id, rk.jenis_keanggotaan_id FROM riwayat_keanggotaan rk  GROUP BY rk.anggota_akun_id) k_max ON (k_max.anggota_akun_id = a.anggota_akun_id)
			LEFT JOIN riwayat_keanggotaan rk ON rk.id = k_max.k_id
			LEFT JOIN jenis_keanggotaan j on rk.jenis_keanggotaan_id = j.id ";

      $filter       = array();
              //get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
      $list  = $this->RM->get_datatables($table,$col_order,$col_search,$order,$query,$filter);
      $data  = array();
      $no    = $_POST['start'];
      foreach ($list as $da) {
         $no++;
         $row   = array();
        
         $row[] = $no; 
         $row[] = $da->nama_lengkap; 
       	 $row[] = $da->gender;	
         $row[] = $da->pob.' / '.date('d-m-Y',strtotime($da->dob)) ;
         $row[] = $da->nama_jenis_keanggotaan;
         $row[] = $da->nama_struktur;
 
        


         $data[] = $row;
     }

     $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $this->RM->count_all_query($table,$filter),
        "recordsFiltered" => $this->RM->count_filtered($query,$filter,$filter),
        "data" => $data,
    );
        //output to json format
      $this->jsonOut($output);
	}
	// Add a new item
	public function add()
	{

	}

	//Update one item
	public function update( $id = NULL )
	{

	}

	//Delete one item
	public function delete( $id = NULL )
	{

	}

	public function export_excel (){

	}

	public function import_excel(){
		
	}
}

/* End of file Data_kader.php */
/* Location: ./application/modules/report/controllers/Data_kader.php */
