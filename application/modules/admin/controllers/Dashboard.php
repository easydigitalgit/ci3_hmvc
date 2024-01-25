<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model', 'AM');
		$this->load->library('encryption');
		$this->load->library('SelectOption');
		$this->load->library('parser');
		$this->load->helper('starsender');
		$this->UID  ? '' : $this->logOut();
	}
	private function _theme($data)
	{


		$data['libcss'] 		= '';
		$data['pjs']        	= jsArray(array('bs4-datatables', 'select2', 'leaflet', 'leaflet-popup-responsive', 'leaflet-marker-cluster', 'chartjs'));
		$data['pcss']       	= cssArray(array('datatables', 'select2', 'leaflet', 'leaflet-popup-responsive', 'leaflet-marker-cluster', 'leaflet-marker-clusterDefault', 'chartjs'));
		//$data['menu'] 		= 'admin/sideMenu';

		$this->theme->dashboard_theme($data);
	}
	// List all your items
	public function index()
	{
		$arrDash = array('1' => 'adminDashboard', '2' => 'relawanDashboard', '3' => 'calegDashboard', '4' => 'kordapilDashboard');
		$ulevel = $this->ULEVEL;

		if ($ulevel && isset($arrDash[$ulevel])) {
			if ($ulevel == '1') {
				$data['libjs']  		= jsbyEnv(array('libDashboard', 'libMap', 'libCountDown', 'libCalegRankChart',));
			} else if ($ulevel == '4') {
				$data['libjs']  		= jsbyEnv(array('libDashboard', 'libMap', 'libCalegRankChart', 'libCountDown'));
			} else {
				$data['libjs']  		= jsbyEnv(array('libDashboard', 'libMap', 'libRelawanRankChart', 'libCountDown'));
			}

			$data['konten'] = $arrDash[$ulevel];
			$data['libcss'] = '';

			$this->_theme($data);
		} else {
			$this->logOut();
		}
	}



	// Add a new item
	public function add()
	{
	}

	//Update one item
	public function update($id = NULL)
	{
	}

	//Delete one item
	public function delete($id = NULL)
	{
	}

	public function setmarker()
	{
		/*$query = " a.*, b.propinsi, b.kabupaten, b.kecamatan, b.nama as desa, b.latitude, b.longitude, b.lat_kecamatan, b.long_kecamatan, b.lat_kabupaten, b.long_kabupaten, b.lat_propinsi, b.long_propinsi from ( SELECT desa, COUNT(IF(gender='pria' ,1,NULL)) AS 'pria',COUNT(IF(gender='wanita' ,1,NULL)) AS 'wanita', count(*) as jumlah FROM anggota GROUP BY desa ORDER BY desa ) a LEFT JOIN desa b on a.desa = b.kode";
		
		$query2 = "  a.*, TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) AS age, b.propinsi, b.kabupaten, b.kecamatan, b.nama as desa, b.latitude, b.longitude, b.lat_kecamatan, b.long_kecamatan, b.lat_kabupaten, b.long_kabupaten, b.lat_propinsi, b.long_propinsi FROM anggota a LEFT JOIN desa b ON a.desa = b.kode ";

		$q = $this->db->select($query2, false)->get();*/
		$uid = $this->UID;
		$ulevel = $this->ULEVEL;



		if ($ulevel == '1') {
			$query =  "   a.id, a.nik, a.nama, a.gender, a.alamat, TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) AS age, b.propinsi, b.kabupaten, b.kecamatan, b.nama as desa, b.latitude, b.longitude, b.lat_kecamatan, b.long_kecamatan, b.lat_kabupaten, b.long_kabupaten, b.lat_propinsi, b.long_propinsi FROM anggota a 
			LEFT JOIN data_pilihan_caleg g ON a.id = g.anggota_id LEFT JOIN desa b ON a.desa = b.kode; ";
			$this->db->select($query, false);
		} else if ($ulevel == '2') {
			$query =  "  a.*, TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) AS age, b.propinsi, b.kabupaten, b.kecamatan, b.nama as desa, b.latitude, b.longitude, b.lat_kecamatan, b.long_kecamatan, b.lat_kabupaten, b.long_kabupaten, b.lat_propinsi, b.long_propinsi, e.nama as nama_caleg, c.nama_relawan, f.dapil_id FROM anggota a 
					LEFT JOIN data_pilihan_caleg g ON a.id = g.anggota_id
					LEFT JOIN data_relawan c ON g.relawan_id_ri = c.id 
					
					LEFT JOIN desa b ON a.desa = b.kode 
					LEFT JOIN data_koord_relawan d ON c.koord_akun_id = d.akun_id 
					LEFT JOIN user_akun e ON d.caleg_akun_id = e.id 
					LEFT JOIN konfigurasi f ON d.caleg_akun_id = f.id_akun_caleg ";

			$this->db->select($query, false);
			$this->db->where('d.akun_id', $uid);
		} else if ($ulevel == '3') {
			$tingkatCaleg = $this->AM->getTingkatPemilihanByCalegID($uid);
			if ($tingkatCaleg->num_rows()) {
				$tingkat = $tingkatCaleg->row();
				$tingkatPemilihan = $tingkat->tingkat_pemilihan_id;

				if ($tingkatPemilihan == 1) {
					$query =  "  a.*, TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) AS age, b.propinsi, b.kabupaten, b.kecamatan, b.nama as desa, b.latitude, b.longitude, b.lat_kecamatan, b.long_kecamatan, b.lat_kabupaten, b.long_kabupaten, b.lat_propinsi, b.long_propinsi, e.nama as nama_caleg, c.nama_relawan, f.dapil_id FROM anggota a 
					LEFT JOIN data_pilihan_caleg g ON a.id = g.anggota_id
					LEFT JOIN data_relawan c ON g.relawan_id_ri = c.id 
					
					LEFT JOIN desa b ON a.desa = b.kode 
					LEFT JOIN data_koord_relawan d ON c.koord_akun_id = d.akun_id 
					LEFT JOIN user_akun e ON d.caleg_akun_id = e.id 
					LEFT JOIN konfigurasi f ON d.caleg_akun_id = f.id_akun_caleg ";
				} else if ($tingkatPemilihan == 2) {
					$query =  "  a.*, TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) AS age, b.propinsi, b.kabupaten, b.kecamatan, b.nama as desa, b.latitude, b.longitude, b.lat_kecamatan, b.long_kecamatan, b.lat_kabupaten, b.long_kabupaten, b.lat_propinsi, b.long_propinsi, e.nama as nama_caleg, c.nama_relawan, f.dapil_id FROM anggota a 
					LEFT JOIN data_pilihan_caleg g ON a.id = g.anggota_id
					LEFT JOIN data_relawan c ON g.relawan_id_prop = c.id 
					
					LEFT JOIN desa b ON a.desa = b.kode 
					LEFT JOIN data_koord_relawan d ON c.koord_akun_id = d.akun_id 
					LEFT JOIN user_akun e ON d.caleg_akun_id = e.id 
					LEFT JOIN konfigurasi f ON d.caleg_akun_id = f.id_akun_caleg ";
				} else if ($tingkatPemilihan == 3) {
					$query =  "  a.*, TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) AS age, b.propinsi, b.kabupaten, b.kecamatan, b.nama as desa, b.latitude, b.longitude, b.lat_kecamatan, b.long_kecamatan, b.lat_kabupaten, b.long_kabupaten, b.lat_propinsi, b.long_propinsi, e.nama as nama_caleg, c.nama_relawan, f.dapil_id FROM anggota a 
					LEFT JOIN data_pilihan_caleg g ON a.id = g.anggota_id
					LEFT JOIN data_relawan c ON g.relawan_id_kota = c.id 
					
					LEFT JOIN desa b ON a.desa = b.kode 
					LEFT JOIN data_koord_relawan d ON c.koord_akun_id = d.akun_id 
					LEFT JOIN user_akun e ON d.caleg_akun_id = e.id 
					LEFT JOIN konfigurasi f ON d.caleg_akun_id = f.id_akun_caleg ";
				}
				$this->db->select($query, false);
				$this->db->where('d.caleg_akun_id', $uid);
				//$this->db->where('a.desa <>', '');
				$this->db->group_by('a.id');
			}
		} else if ($ulevel == '4') {
			$this->db->where('f.kordapil_akun_id', $uid);
		} else {
			$this->db->where('1', '0');
		}
		$q = $this->db->get();


		if ($q->num_rows()) {
			$data = $q->result_array();
			$ret['status'] = true;
			$ret['count'] = $q->num_rows();
			$no = 0;
			$dt = array();
			foreach ($data as $key => $value) {
				$d = array();
				$d[$key] = $value;
				$d['no'] = $no++;
				$dt[] = $d;
			}
			$ret['data'] = $data;
		} else {
			$ret['status'] = false;
		}
		//log_message('user_info', 'setMarker  ; ' . $this->db->last_query());
		$this->jsonOut($ret);
	}




	public function filtermap()
	{
		$uid = $this->UID;
		$ulevel = $this->ULEVEL;

		$calegID 	= 	$this->input->post('filter_caleg_id');
		$dapilID 	=	$this->input->post('filter_dapil_id');
		$propinsi 	=	$this->input->post('filter_propinsi');
		$kabupaten 	=	$this->input->post('filter_kabupaten');
		$kecamatan 	=	$this->input->post('filter_kecamatan');
		$kelurahan 	=	$this->input->post('filter_kelurahan');
		$relawanID  =	$this->input->post('filter_relawan_id');
		$usia 		=	$this->input->post('filter_usia_anggota');
		$gender 	= 	$this->input->post('filter_gender_anggota');

		$query = "  a.*, TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) AS age, b.propinsi, b.kabupaten, b.kecamatan, b.nama as desa, b.latitude, b.longitude, b.lat_kecamatan, b.long_kecamatan, b.lat_kabupaten, b.long_kabupaten, b.lat_propinsi, b.long_propinsi, e.nama as nama_caleg, c.nama_relawan, f.dapil_id FROM anggota a LEFT JOIN desa b ON a.desa = b.kode LEFT JOIN data_relawan c ON a.relawan_id = c.id LEFT JOIN data_koord_relawan d ON c.koord_akun_id = d.akun_id LEFT JOIN user_akun e ON d.caleg_akun_id = e.id LEFT JOIN konfigurasi f ON d.caleg_akun_id = f.id_akun_caleg ";

		$this->db->select($query, false);

		if ($ulevel == '3') {
			$this->db->where('d.caleg_akun_id', $uid);
		}

		if ($usia) {

			switch ($usia) {
				case '1720':
					$this->db->where(array(' TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) >= ' => '17', ' TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) <= ' => '20'));
					break;
				case '2130':
					$this->db->where(array(' TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) >= ' => '21', ' TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) <= ' => '30'));
					break;
				case '3140':
					$this->db->where(array(' TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) >= ' => '31', ' TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) <= ' => '40'));
					break;
				case '4150':
					$this->db->where(array(' TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) >= ' => '41', ' TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) <= ' => '50'));
					break;
				case '5160':
					$this->db->where(array(' TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) >= ' => '51', ' TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) <= ' => '60'));
					break;
				case '61':
					$this->db->where(array(' TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) >= ' => '61'));
					break;
				default:
					// code...
					break;
			}
		}

		if ($gender == 'pria' || $gender == 'wanita') {
			$this->db->where(array('a.gender' => $gender));
		}

		if ($dapilID) {
			$this->db->where(array('dapil_id' => $dapilID));
		}
		if ($relawanID) {
			$this->db->where(array('relawan_id' => $relawanID));
		}
		if ($calegID) {
			$this->db->where(array('d.caleg_akun_id' => $calegID));
		}

		if ($propinsi) {
			$this->db->where(array('a.propinsi' => $propinsi));
		}
		if ($kabupaten) {
			$this->db->where(array('a.kota' => $kabupaten));
		}
		if ($kecamatan) {
			$this->db->where(array('a.kec' => $kecamatan));
		}
		if ($kelurahan) {
			$this->db->where(array('a.desa' => $kelurahan));
		}

		$q = $this->db->get();

		if ($q->num_rows()) {
			$data = $q->result_array();
			$ret['status'] 	= true;
			$ret['data'] 	= $data;
		} else {
			$ret['status'] = false;
		}
		$this->jsonOut($ret);
	}

	public function select_filter_caleg()
	{
		$uid 	= $this->UID;
		$ulevel = $this->ULEVEL;
		$uname 	= $this->UNAME;
		if ($ulevel == '1') {
			echo $this->selectoption->selectCaleg();
		} else if ($ulevel == '3') {
			echo '<option value="' . $uid . '">[' . $uname . ']</option>';
		} else if ($ulevel == '4') {
			echo $this->selectoption->selectCalegByKordapil($uid);
		}
	}

	public function select_filter_dapil()
	{
		$uid 	= $this->UID;
		$ulevel = $this->ULEVEL;
		if ($ulevel == '1') {
			echo $this->selectoption->selectAllDapil();
		} else if ($ulevel == '3') {
			echo $this->selectoption->selectDapilByCaleg($uid);
		} else if ($ulevel == '4') {
			echo $this->selectoption->selectDapilByKordapil($uid);
		}
	}

	public function select_filter_relawan($calegID = null)
	{
		$uid = $this->UID;
		$ulevel = $this->ULEVEL;

		if ($ulevel == '1') {
			echo $this->selectoption->selectAllRelawan();
		} else if ($ulevel == '3') {
			echo $this->selectoption->selectRelawanByCalegID($uid);
		} else if ($ulevel == '4') {
			echo $this->selectoption->selectRelawanByKordapil($uid);
		}
	}


	public function select_filter_prop()
	{
		echo $this->selectoption->selectPropinsi();
	}

	public function select_filter_kabupaten($kodeProp = null)
	{
		echo $this->selectoption->selectKabupaten($kodeProp);
	}

	public function select_filter_kecamatan($kodeKab = null)
	{
		echo $this->selectoption->selectKecamatan($kodeKab);
	}

	public function select_filter_kelurahan($kodeKec = null)
	{
		echo $this->selectoption->selectDesa($kodeKec);
	}

	public function dashbox()
	{
		$ulevel = $this->ULEVEL;
		$uid = $this->UID;


		$gender = $this->AM->jumlahAnggotaByGender($ulevel, $uid);


		$dt['anggota_pria'] 	=  $gender['pria'];

		$dt['anggota_wanita'] 	=  $gender['wanita'];
		$dt['total_anggota'] 	= (int) $gender['pria'] + (int) $gender['wanita'];
		$dt['status'] 			= true;
		$this->jsonOut($dt);
	}

	public function chart_relawan_rank()
	{
		$ulevel = $this->ULEVEL;
		$uid = $this->UID;
		if ($ulevel == '1') {
			$q = $this->AM->rankingRelawan();
		} else if ($ulevel == '3') {
			$q = $this->AM->rankingRelawan(array('d.caleg_akun_id' => $uid), $uid);
		} else if ($ulevel == '4') {
			$q = $this->AM->rankingRelawan(array('e.kordapil_akun_id' => $uid), $uid);
		}

		//log_message('user_info', 'chart relawan rank: ' . $this->db->last_query());
		if ($q->num_rows()) {
			$d['status'] = true;
			$d['lastUpdate'] = date('d-m-Y H:i:s') . ' WIB';
			foreach ($q->result() as $value) {
				$d['labels'][] = $value->nama_relawan;
				$d['data']['jumlah'][] = $value->total ?  $value->total : '0';
			}
		} else {
			$d['status'] = false;
		}

		$this->jsonOut($d);
	}

	public function chart_caleg_rank()
	{
		$ulevel = $this->ULEVEL;
		$uid = $this->UID;

		if ($ulevel == 1) {
			$q = $this->AM->rankingCaleg();
		} else if ($ulevel == 4) {
			$q = $this->AM->rankingCaleg($uid);
		} else {
			$q = false;
		}

		if ($q->num_rows()) {
			$d['status'] = true;
			$d['lastUpdate'] = date('d-m-Y H:i:s') . ' WIB';
			foreach ($q->result() as $value) {
				$d['labels'][] = $value->nama_caleg;
				$d['data']['jumlah'][] = $value->total ?  $value->total : '0';
			}
		} else {
			$d['status'] = false;
		}
		$this->jsonOut($d);
	}

	public function table_caleg_rank()
	{

		$table        = 'data_relawan';
		$col_order    = array('e.nama');
		$col_search   = array('e.nama');
		$order        = array('calegCount' => 'DESC');
		$query        = "  e.nama as namacaleg, COUNT(*) as calegCount FROM anggota a left JOIN ( 
    
            SELECT z.anggota_id, z.relawan_id_ri as relawan_id, z.createdby_ri as createdby, y.nama_relawan, x.caleg_akun_id, k.kordapil_akun_id  from data_pilihan_caleg z
            LEFT JOIN data_relawan y ON z.relawan_id_ri = y.id LEFT JOIN data_koord_relawan x ON y.koord_akun_id = x.akun_id LEFT JOIN konfigurasi k ON k.id_akun_caleg = x.caleg_akun_id
            
            UNION ALL 
            SELECT z.anggota_id, z.relawan_id_prop as relawan_id, z.createdby_prop as createdby, y.nama_relawan, x.caleg_akun_id, k.kordapil_akun_id   from data_pilihan_caleg z
            LEFT JOIN data_relawan y ON z.relawan_id_prop = y.id LEFT JOIN data_koord_relawan x ON y.koord_akun_id = x.akun_id LEFT JOIN konfigurasi k ON k.id_akun_caleg = x.caleg_akun_id
            
            UNION ALL 
            SELECT z.anggota_id, z.relawan_id_kota as relawan_id, z.createdby_kota as createdby, y.nama_relawan, x.caleg_akun_id, k.kordapil_akun_id   from data_pilihan_caleg z
            LEFT JOIN data_relawan y ON z.relawan_id_kota = y.id LEFT JOIN data_koord_relawan x ON y.koord_akun_id = x.akun_id LEFT JOIN konfigurasi k ON k.id_akun_caleg = x.caleg_akun_id
            ) v
           
            ON a.id = v.anggota_id
            LEFT JOIN user_akun e ON e.id = v.caleg_akun_id
           
           
         ";
		$groupby = 'v.caleg_akun_id';
		$filter['v.caleg_akun_id >'] = '0';
		$ulevel = $this->ULEVEL;
		$uid = $this->UID;
		if ($ulevel == '1') {
		} else if ($ulevel == '4') {
			$filter = array('v.kordapil_akun_id' => $uid);
		} else {
			$filter = array('1' => '0');
		}


		//get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
		$list  = $this->AM->get_datatables($table, $col_order, $col_search, $order, $query, $filter, $groupby);
		$data  = array();
		$no    = $_POST['start'];
		foreach ($list as $da) {
			$no++;
			$row   = array();

			$row[] = $no;
			$row[] = $da->namacaleg;
			$row[] = $da->calegCount;

			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->AM->countAllQueryFiltered($query, $filter),
			"recordsFiltered" => $this->AM->count_filtered($query, $filter),
			"data" => $data,
		);
		//output to json format
		$this->jsonOut($output);
	}

	public function table_relawan_rank()
	{

		$uid = $this->UID;
		$ulevel = $this->ULEVEL;

		$table        = 'data_relawan';
		$col_order    = array('a.id');
		$col_search   = array('a.namakoord', 'a.nama_relawan');
		$order        = array('total' => 'DESC');
		$groupby = 'a.id';

		$query = "   a.namakoord,  a.nama_relawan, a.caleg_akun_id, a.id, COUNT(*) as total
		FROM (
			SELECT p.anggota_id, s.nama as namakoord, r.caleg_akun_id, q.nama_relawan, q.id  FROM data_pilihan_caleg p 
			LEFT JOIN data_relawan q ON p.relawan_id_ri = q.id 
			LEFT JOIN data_koord_relawan r ON q.koord_akun_id = r.akun_id LEFT JOIN user_akun s ON r.akun_id = s.id
			UNION ALL
			SELECT p.anggota_id, s.nama as namakoord, r.caleg_akun_id, q.nama_relawan, q.id FROM data_pilihan_caleg p 
			LEFT JOIN data_relawan q ON p.relawan_id_prop = q.id 
			LEFT JOIN data_koord_relawan r ON q.koord_akun_id = r.akun_id LEFT JOIN user_akun s ON r.akun_id = s.id
			UNION ALL
			SELECT p.anggota_id, s.nama as namakoord, r.caleg_akun_id, q.nama_relawan, q.id FROM data_pilihan_caleg p 
			LEFT JOIN data_relawan q ON p.relawan_id_kota = q.id
			LEFT JOIN data_koord_relawan r ON q.koord_akun_id = r.akun_id LEFT JOIN user_akun s ON r.akun_id = s.id
		) a
		
		
		 ";

		if ($ulevel == '1') {

			$filter       = array();
		} else if ($ulevel == '3') {



			/* $tingkatCaleg = $this->AM->getTingkatPemilihanByCalegID($uid);
			if ($tingkatCaleg->num_rows()) {
				$tingkat = $tingkatCaleg->row();
				$tingkatPemilihan = $tingkat->tingkat_pemilihan_id;

				if ($tingkatPemilihan == 1) {
					$query        = " c.nama as nama_admin, a.koord_akun_id as admin_id, c.nama as nama_admin , b.relawan_id_ri, a.nama_relawan, b.total, d.caleg_akun_id, e.kordapil_akun_id from data_relawan a 
					LEFT JOIN (SELECT id, relawan_id_ri, COUNT(*) as total FROM data_pilihan_caleg GROUP BY relawan_id_ri ORDER BY total DESC) b on b.relawan_id_ri = a.id 
					LEFT JOIN user_akun c ON c.id = a.koord_akun_id 
					LEFT JOIN data_koord_relawan d ON a.koord_akun_id = d.akun_id 
					LEFT JOIN konfigurasi e ON d.caleg_akun_id = e.id_akun_caleg   ";
				} else if ($tingkatPemilihan == 2) {
					$query        = " c.nama as nama_admin, a.koord_akun_id as admin_id, c.nama as nama_admin , b.relawan_id_prop, a.nama_relawan, b.total, d.caleg_akun_id, e.kordapil_akun_id from data_relawan a 
					LEFT JOIN (SELECT id, relawan_id_prop, COUNT(*) as total FROM data_pilihan_caleg GROUP BY relawan_id_prop ORDER BY total DESC) b on b.relawan_id_prop = a.id 
					LEFT JOIN user_akun c ON c.id = a.koord_akun_id 
					LEFT JOIN data_koord_relawan d ON a.koord_akun_id = d.akun_id 
					LEFT JOIN konfigurasi e ON d.caleg_akun_id = e.id_akun_caleg   ";
				} else if ($tingkatPemilihan == 3) {
					$query        = "  c.nama as nama_admin, a.koord_akun_id as admin_id, c.nama as nama_admin , b.relawan_id_kota, a.nama_relawan, b.total, d.caleg_akun_id, e.kordapil_akun_id from data_relawan a 
					LEFT JOIN (SELECT id, relawan_id_kota, COUNT(*) as total FROM data_pilihan_caleg GROUP BY relawan_id_kota ORDER BY total DESC) b on b.relawan_id_kota = a.id 
					LEFT JOIN user_akun c ON c.id = a.koord_akun_id 
					LEFT JOIN data_koord_relawan d ON a.koord_akun_id = d.akun_id 
					LEFT JOIN konfigurasi e ON d.caleg_akun_id = e.id_akun_caleg   ";
				}
			} */


			$filter       = array('a.caleg_akun_id' => $uid);
		} else if ($ulevel == '4') {
			/* $query = " c.nama as nama_admin, a.koord_akun_id as admin_id, a.id, a.nama_relawan, b.total
			FROM data_relawan a 
			LEFT JOIN (
				SELECT relawan_id,  total
				FROM (
					SELECT relawan_id_ri as relawan_id, COUNT(*) as total FROM data_pilihan_caleg GROUP BY relawan_id_ri
					UNION ALL
					SELECT relawan_id_prop as relawan_id, COUNT(*) as total FROM data_pilihan_caleg GROUP BY relawan_id_prop
					UNION ALL
					SELECT relawan_id_kota as relawan_id, COUNT(*) as total FROM data_pilihan_caleg GROUP BY relawan_id_kota
				) subquery
				
			) b ON a.id = b.relawan_id 
			LEFT JOIN user_akun c ON c.id = a.koord_akun_id
            LEFT JOIN data_koord_relawan d ON a.koord_akun_id = d.akun_id 
			LEFT JOIN konfigurasi e ON d.caleg_akun_id = e.id_akun_caleg "; */
			$filter = array('e.kordapil_akun_id' => $uid);
		} else {
			$filter       = array('1' => '0');
		}


		//get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
		$list  = $this->AM->get_datatables($table, $col_order, $col_search, $order, $query, $filter, $groupby);
		$data  = array();
		$no    = $_POST['start'];
		foreach ($list as $da) {
			$no++;
			$row   = array();

			$row[] = $no;
			$row[] = $da->namakoord;
			$row[] = $da->nama_relawan;
			$row[] = $da->total;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->AM->countAllQueryFiltered($query, $filter),
			"recordsFiltered" => $this->AM->count_filtered($query, $filter),
			"data" => $data,
		);
		//output to json format
		$this->jsonOut($output);
	}
}

/* End of file Dashboard.php */
/* Location: ./application/modules/admin/controllers/Dashboard.php */
