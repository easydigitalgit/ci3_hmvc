<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seleksi_psb extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pendaftaran_model','PM');
		$this->load->library('SelectOption');
	}

	private function _theme($data){
		
		$data['libjs']  		= jsbyEnv('libSeleksiPsb');
		$data['libcss'] 		= '';
		$data['pjs']        	= jsArray(array('bs4-datatables','select2','moment2.24','daterangepicker'));
  		$data['pcss']       	= cssArray(array('datatables','select2','daterangepicker'));
		

		$this->theme->dashboard_theme($data);
	}

	// List all your items
	public function index( ){
		$data['konten'] = 'seleksiPsbKonten';
		$data['libcss'] = '';
	    $data['headSeleksiPsb'] = headBtnSeleksi('seleksi_psb');
		$this->_theme($data);
	}

	public function table_seleksi_psb(){
		$genderArr = array('F'=>'Perempuan', 'M'=>'Laki-laki');
	  
	  $table        = 'jadwal_seleksi_psb';
      $col_order    = array('a.id'); 
      $col_search   = array('b.noreg', 'b.nama_lengkap', 'c.nama_status_seleksi','d.kode', 'a.tanggal_tes');
      $order        = array('id' => 'ASC');
      $query        = "  a.*, b.noreg, b.nama_lengkap, b.dob, b.gender, c.nama_status_seleksi, d.kode as kode_unit, e.nama_jenjang_kelas FROM jadwal_seleksi_psb a LEFT JOIN pendaftaran b on a.pendaftaran_id = b.id LEFT JOIN status_seleksi_psb c on a.status_tes = c.id LEFT JOIN unit_sekolah d on b.tingkat_id = d.id LEFT JOIN jenjang_kelas e on b.jenjang_kelas_id = e.id ";

    
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
         $row[] = $da->noreg; 
      
         $row[] = '['.$da->kode_unit.'] '.$da->nama_jenjang_kelas;
         $row[] = $da->nama_lengkap . '<br>'. isset( $genderArr[$da->gender]) ? $genderArr[$da->gender] : '' . '<br>'. $da->dob ;
         $row[] = $da->tanggal_tes;
         $row[] = badgeLabelStatusTes($da->nama_status_seleksi, $da->status_tes);     
         $row[] = badgeLabelNilaiTes('Lihat Nilai', $da->status_tes, $da->pendaftaran_id) ;
         $row[] = actionBtn3($da->id,'seleksi_psb'); 


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


	public function hasil_tes(){
		// cari daftar tugas pengawas

		$qtugas = $this->db->select(" a.*, b.nama FROM penguji_seleksi_psb a LEFT JOIN kategori_tes b on a.kategori_tes_id = b.id ", false)->where('a.user_akun_id',$this->UID)->get();
		$res = array();
		if($qtugas->num_rows()){
			
			foreach ($qtugas->result() as  $val) {
				$dt = array();
				$dt['id_kategori'] 		= $val->kategori_tes_id;
				$dt['nama_kategori'] 	= $val->nama;

				$res[] = $dt;
			}


		}


		$data['konten'] = 'hasilTesKonten';
		$data['libcss'] = '';
	    $data['headTableNilai'] = headTableNilai('hasil_tes', $res);
		
		
		$this->_theme($data);
	}

	public function table_peserta_tes(){
	 $genderArr = array('F'=>'Perempuan', 'M'=>'Laki-laki');
	  
	  $table        = 'jadwal_seleksi_psb a';
      $col_order    = array('a.id'); 
      $col_search   = array('b.noreg', 'b.nama_lengkap', 'c.nama_status_seleksi','d.kode', 'a.tanggal_tes');
      $order        = array('id' => 'ASC');
      $query        = "  a.*, b.noreg, b.nama_lengkap, b.dob, b.gender, c.nama_status_seleksi, d.kode as kode_unit, e.nama_jenjang_kelas FROM jadwal_seleksi_psb a LEFT JOIN pendaftaran b on a.pendaftaran_id = b.id LEFT JOIN status_seleksi_psb c on a.status_tes = c.id LEFT JOIN unit_sekolah d on b.tingkat_id = d.id LEFT JOIN jenjang_kelas e on b.jenjang_kelas_id = e.id ";

    
      $filter       = array('a.status_tes'=>2);
 
              //get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
      $list  = $this->PM->get_datatables($table,$col_order,$col_search,$order,$query,$filter);
      $data  = array();
      $no    = $_POST['start'];
      foreach ($list as $da) {
         $no++;
         $row   = array();
         $row[] = '<input type="checkbox" class="data-check" value="'.$da->id.'">';
        
         $row[] = $da->noreg; 
      	 $row[] = $da->nama_lengkap . '<br>'. $genderArr[$da->gender]. '<br>'. $da->dob ;
         $row[] = '['.$da->kode_unit.'] '.$da->nama_jenjang_kelas;
        
         $row[] = $da->tanggal_tes;
         $row[] = badgeLabelStatusTes($da->nama_status_seleksi, $da->status_tes);
     
        
 
         
        // $row[] = addNilaiTesBtn($da->id,'nilai_tes'); 

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

	public function get_form_nilai(){
		$idKategoriTes = $this->input->post('id_kategori');
		$idJadwalTes = $this->input->post('id_jadwal');

		if (is_array($idJadwalTes) && count($idJadwalTes)) {
			$data = array();
			foreach($idJadwalTes as $id ){
				$dt = array();

				$dt = $this->PM->getDaftarSubtes($id , $idKategoriTes);
				$data[] = $dt;
			}
		}
		$ret['status'] = true;
		$ret['data'] = $dt;
		
		$this->jsonOut($ret);

	}

	// Add a new item
	public function add_hasil_tes()
	{
		$idTes = $this->input->post('idtes');
		$ret['status'] = true;
		if(is_array($idTes) && count($idTes)){
			foreach ($idTes as $key => $value) {
				// code...
			}
		}

		$this->jsonOut($ret);
	}

	public function edit_seleksi_psb(){

	}

	                                                                              

	

	//Delete one item
	public function delete_seleksi_psb( $id  )
	{

	}

	public function add_absensi_tes(){
		  $this->form_validation->set_rules($this->PM->absensiTesRules('add')); 
	      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	      if ($this->form_validation->run() == FALSE ) {
		       $ret['status'] = false;
		           foreach ($_POST as $key => $value) {
		               $ret['msg'][$key] = form_error($key);
		           }
	       }
	       else{ 
	       		//$id = $this->input->post('id');

	       		$id	 						= $this->input->post('pendaftaran_id');
	       		$data['tanggal_tes']		= date('Y-m-d H:i:s', strtotime( $this->input->post('tanggal_tes') ) );
	       		$data['catatan']			= $this->input->post('catatan');

	       		$insert = $this->PM->update('jadwal_seleksi_psb', array('pendaftaran_id'=>$id), $data);
	                if($insert){
	                		$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
	                }
	                else {
	                		$ret = array("status" => false , "msg"=>"proses simpan data gagal");
	                }
	            }

	       
	       $this->jsonOut($ret); 
	}

	public function update_absensi_tes(){
		  $this->form_validation->set_rules($this->PM->absensiTesRules('add')); 
	      $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
	      if ($this->form_validation->run() == FALSE ) {
		       $ret['status'] = false;
		           foreach ($_POST as $key => $value) {
		               $ret['msg'][$key] = form_error($key);
		           }
	       }
	       else{ 
	       		//$id = $this->input->post('id');

	       		$id	 						= $this->input->post('pendaftaran_id');
	       		$data['tanggal_tes']		= date('Y-m-d H:i:s', strtotime( $this->input->post('tanggal_tes') ) );
	       		$data['catatan']			= $this->input->post('catatan');

	       		$insert = $this->PM->update('jadwal_seleksi_psb', array('pendaftaran_id'=>$id), $data);
	                if($insert){
	                		$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
	                }
	                else {
	                		$ret = array("status" => false , "msg"=>"proses simpan data gagal");
	                }
	            }

	       
	       $this->jsonOut($ret); 
	}

	public function set_hadir(){
		$id 		= $this->input->post('id');
		$table 		= 'jadwal_seleksi_psb';
		$q = $this->PM->bulkSetTesStatus($table, $id, 2);
		if ($q) {
			$ret['status'] 	= true;
			$ret['row'] 	= $q;
		}
		else{
			$ret['status'] 	= false;
			$ret['row'] 	= '';
		}
		$this->jsonOut($ret);

		 

	}

	/*public function DataDelete($table,$data){
		
		 if(is_array($data)){
            if(!empty($data)){
                $del = $this->MY_Model->bulk_delete($table,$data);
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
        elseif($data){
            $del = $this->MY_Model->delete_by_id($table,$data);
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

        return $ret;
	}*/


	public function form_nilai_tes(){
		$pendaftaranID = $this->input->post('pendaftaran_id');
		$dataPendaftar = $this->db->get_where('pendaftaran', array('id'=>$pendaftaranID));
		log_message('error','query daftar = '. $this->db->last_query());
			if ($dataPendaftar->num_rows()) {
				$val 		= $dataPendaftar->row();
				$thnAjaran 	= $val->tahun_ajaran_id;
				$unit 		= $val->tingkat_id;
				$kelas 		= $val->jenjang_kelas_id;
				$program 	= $val->program;

				$whereArr = array('a.tahun_ajaran_id'=>$thnAjaran, 'a.unit_sekolah_id'=>$unit, 'a.jenjang_kelas_id'=>$kelas, 'a.program_id'=>$program );
				
				$query = " a.kode_paket_tes, b.id as tes_id, b.kode as kode_tes, b.nama as nama_tes, c.nilai, c.keterangan FROM paket_tes a LEFT JOIN jenis_tes_seleksi b on a.jenis_tes_seleksi_id = b.id LEFT JOIN nilai_tes c ON b.id = c.id_jenis_tes_seleksi ";
				
				$q = $this->db->select($query, false)->where($whereArr)->get();
				log_message('error','query paket = '. $this->db->last_query());
				if($q->num_rows()){
					$ret['status'] = true;
					$data = array();
					foreach($q->result() as $val){
						$dt = array();
						$dt['kode_paket']   = $val->kode_paket_tes;
						$dt['tes_id'] 		= $val->tes_id;
						$dt['kode_tes']		= $val->kode_tes;
						$dt['nama_tes']		= $val->nama_tes;
						$dt['nilai']		= $val->nilai;
						$dt['keterangan']	= $val->keterangan;

						$data[] = $dt;
					}
					$ret['data'] = $data;
				}
				else{
					$ret['status'] = false;
					$ret['data'] = 0;
				}

			}
			else{
				    $ret['status'] = false;
					$ret['data'] = 0;
			}

			$this->jsonOut($ret);

	}

	public function add_nilai_tes(){
		$ArrNilai = $this->input->post('nilai');
		$pendaftaranID = $this->input->post('pendaftaran_id');
		$data = array();
		if (is_array($ArrNilai) AND count($ArrNilai)) {
			$this->PM->deleteNilaiTes($pendaftaranID);
			foreach ($ArrNilai as $key => $value) {
				$dt = array();
				$dt['id_jenis_tes_seleksi'] = $key;
				$dt['nilai'] 				= $value;
				$dt['keterangan'] 			= '';
				$dt['last_update'] 			= date('Y-m-d H:i:s');
				$dt['pendaftaran_id']		= $pendaftaranID;
				$insert = $this->PM->save('nilai_tes', $dt);
				$data[] = $dt;
			}
		}


		return $this->jsonOut( array('status'=>true, 'data'=>$data) );
	}

	public function select_jenjang_kelas($unitID){
		if ($unitID) {
			echo $this->selectoption->selectJenjangKelas($unitID);
		}
		
	}

	public function select2_noreg(){
		$term 			= $this->input->post('search');
        $tblquery 		= " * from pendaftaran ";
        $coloumnSearch 	= array('nama_lengkap','noreg');
        $limit 			= 5;
        $filter 		= array();
        $q 				= $this->PM->searchTermArr($tblquery,$coloumnSearch,$term,$limit,$filter);
        $data 			= array();
        if($q){
            foreach($q as $h){
                $row = array();
                $row['id'] = $h->id;
                $row['text'] = "[".$h->noreg."] ".$h->nama_lengkap;
                $data[] = $row;
            }
        
        }
        $this->jsonOut($data);
	}

	public function get_data_seleksi(){
		$id = $this->input->post('pendaftaran_id');
		$q = $this->db->get_where('jadwal_seleksi_psb',array('pendaftaran_id'=>$id));

		if($q->num_rows()){
			$ret['status'] = true;
			$ret['data'] = $q->row();
		}
		else{
			$ret['status'] = false;
			$ret['data'] = 0;
		}

		$this->jsonOut($ret);
	}

	
}

/* End of file Jadwal_usm.php */
/* Location: ./application/modules/pendaftaran/controllers/Jadwal_usm.php */
