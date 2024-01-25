<?php defined('BASEPATH') or exit('No direct script access allowed');

class MY_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->upload_doc = dirname(APPPATH) . '/upload_doc/';
		$this->upload_userImage = dirname(APPPATH) . '/upload_img/user_img/';
		$this->jsonDoc = dirname(APPPATH) . '/jsonDoc/';
	}

	private function _get_datatables_query($filter = null, $group_by = null)
	{


		$this->db->select($this->tablequery, FALSE);



		$i = 0;
		if ($this->column_search) {
			# code...

			foreach ($this->column_search as $item) // loop column 
			{
				if (isset($_POST['search']['value'])) // if datatable send POST for search
				{

					if ($i === 0) // first loop
					{
						$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
						$this->db->like($item, $_POST['search']['value']);
					} else {
						$this->db->or_like($item, $_POST['search']['value']);
					}

					if (count($this->column_search) - 1 == $i) //last loop
						$this->db->group_end(); //close bracket
				}
				$i++;
			}
		}

		if ($filter) {
			$this->db->where($filter);
		}
		if (isset($this->group_by)) {
			$this->db->group_by($this->group_by);
		}

		if (isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			if (is_array($order)) {
				$this->db->order_by(key($order), $order[key($order)]);
			} else {
				$this->db->order_by($order, false);
			}
		}
	}


	public function get_datatables($table, $col_order, $col_search, $order, $query, $filter = Null, $group_by = null)
	{
		//$this->db = $this->load->database($db, TRUE);
		$this->column_order = $col_order;
		$this->column_search = $col_search;
		$this->tablequery = $query;
		$this->order = $order;
		$this->group_by = $group_by;
		$this->_get_datatables_query($filter, $group_by);
		if (isset($_POST["length"]) && $_POST["length"] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	public function count_filtered($query, $filter = null)
	{
		//$this->db = $this->load->database($db, TRUE);
		$this->tablequery = $query;
		$this->_get_datatables_query($filter);
		$query = $this->db->get();

		return $query->num_rows();
	}

	public function count_all($table)
	{
		//$this->db = $this->load->database($db, TRUE);

		$this->db->from($table);

		return $this->db->count_all_results();
	}
	public function countAllQueryFiltered($query, $filter)
	{
		$this->db->select($query, false);
		$this->db->where($filter)->get();
		//log_message('debug','countAllQueryFiltered = '.$this->db->last_query());
		return $this->db->count_all_results();
	}

	public function count_all_query($table, $filter)
	{
		$this->db->from($table);
		$this->db->where($filter);
		return $this->db->count_all_results();
	}


	public function save($table, $data)
	{
		//$this->db = $this->load->database($db, TRUE); 
		$this->db->insert($table, $data);

		return $this->db->insert_id();
	}

	public function insertOnDuplicate($table, $data)
	{
		//And you arrary should be like
		//$data = array('name' => $name, 'phone' => $phone, 'age' => $age);
		// harus ada key unique / primary key sebagai referensi duplikat
		if (empty($table) || empty($data)) return false;
		$duplicate_data = array();

		foreach ($data as $key => $value) {
			$duplicate_data[] = sprintf("%s='%s'", $key, addslashes($value));
		}

		$sql = sprintf("%s ON DUPLICATE KEY UPDATE %s", $this->db->insert_string($table, $data), implode(',', $duplicate_data));

		$this->db->query($sql);
		return $this->db->insert_id();
	}

	public function insertDb($table, $data, $id = null)
	{

		if ($id) {
			$insert = $this->update($table, array('id' => $id), $data);
			return $this->db->affected_rows();
		} else {
			$insert = $this->db->insert($table, $data);
			return $this->db->insert_id();
		}
	}

	public function insertUpdate($table, $data, $key = null)
	{
		//$key in array eg: ('id' => 1)
		if ($key) {
			$insert = $this->update($table, $key, $data);
		} else {
			$insert = $this->db->insert($table, $data);
		}

		return $insert;
	}

	public function insertBatchDb($table, $data, $id = null)
	{
		if ($id) {
			$insert = $this->update($table, array('id' => $id), $data);
			return $this->db->affected_rows();
		} else {
			$insert = $this->db->insert_batch($table, $data);
			return $insert;
		}
	}

	public function save2($table, $data)
	{
		$this->db->insert($table, $data);
		return ($this->db->affected_rows() != 1) ? false : true;
	}

	public function save_arr($table, $fieldName, $data)
	{
		$this->db->set($fieldName, implode(",", $data));
		$this->db->insert($table);
	}

	public function save_batch($table, $data)
	{
		return $this->db->insert_batch($table, $data);
	}

	public function saveBatchIgnore($table, $data)
	{
		$this->db->trans_start();
		foreach ($data as $item) {
			$insert_query = $this->db->insert_string($table, $item);
			$insert_query = str_replace('INSERT INTO', 'REPLACE INTO', $insert_query);
			$this->db->query($insert_query);
		}
		$ret = $this->db->affected_rows();
		$this->db->trans_complete();
		return $ret;
	}

	public function get_by_id($table, $id)
	{
		//$this->db = $this->load->database($db, TRUE);
		$q = $this->db->get_where($table, array('id' => $id));

		return $q->row();
	}

	public function getByID($table, $id)
	{
		$q = $this->db->get_where($table, array('id' => $id));
		return $q->row();
	}

	public function getWhereArray($table, $whereArray)
	{
		$q = $this->db->get_where($table, $whereArray);
		return $q;
	}

	public function getRowData($table, $id)
	{
		$data = $this->db->get_where($table, array('id' => $id))->row();
		if ($data) {
			$ret = array('status' => true, 'data' => $data);
		} else {
			$ret = array('status' => false, 'data' => null);
		}

		return $ret;
	}

	public function get_all($table)
	{
		//$this->db = $this->load->database($db, TRUE);
		$q = $this->db->from($table)->order_by('id', 'ASC')->get();

		return $q->result();
	}

	public function delete_by_id($table, $id)
	{
		//$this->db = $this->load->database($db, TRUE);
		$this->db->delete($table, array('id' => $id));

		return $this->db->affected_rows();
	}
	function deleteIdByIdPeserta($table, $id, $idpeserta)
	{
		$this->db->delete($table, array('id' => $id, 'idpeserta' => $idpeserta));

		return $this->db->affected_rows();
	}

	public function bulk_delete($table, $arr_id, $unlink = '')
	{

		$this->db->where_in('id', $arr_id)->delete($table);
		return $this->db->affected_rows();
	}

	public function bulkDeleteKey($table, $key, $arr_id, $unlink = '')
	{

		$this->db->where_in($key, $arr_id)->delete($table);
		return $this->db->affected_rows();
	}

	public function softDeleteById($table, $id)
	{
		$this->db->update($table, array('trash' => 1), array('id' => $id));
		return $this->db->affected_rows();
	}

	public function bulkSoftDeleteById($table, $id)
	{

		$this->db->where_in('id', $id);
		$this->db->update($table, array('trash' => 1));
		return $this->db->affected_rows();
	}

	public function bulkSetTesStatus($table, $id, $val)
	{
		$this->db->where_in('id', $id);
		$this->db->update($table, array('status_tes' => 2));
		return $this->db->affected_rows();
	}

	public function update($table, $where, $data)
	{
		//$this->db = $this->load->database($db, TRUE);
		$this->db->update($table, $data, $where);

		return $this->db->affected_rows();
	}

	public function setVerifiedStatus($table, $id, $value)
	{
		$this->db->update($table, array('verifiedby' => $value), array('id' => $id));
		return $this->db->affected_rows();
	}


	public function get_all_tablequery($query)
	{
		//$this->db = $this->load->database($db, TRUE);
		$this->db->select($query, FALSE);
		if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		$query = $this->db->get();
		return $query->result();
	}

	public function cek_update_unik($table, $field, $value, $id)
	{
		//$this->db = $this->load->database($db, TRUE);
		$q	= $this->db->get_where($table, array($field => $value, 'id != ' => $id));
		$ret = $q->num_rows()  ? FALSE : TRUE;

		return $ret;
	}

	public function toggle_data($table, $field, $id)
	{
		$q = $this->db->set($field, '(id = ' . $id . ')', false)->update($table);
		return $q;
	}

	public function search_term($table, $field, $term, $limit = 5)
	{
		if (!empty($term)) {
			$q = $this->db->select('*')->like($field, $term)->get($table);
			return $q->result();
		}
	}

	public function searchTermArr($tblquery, $columnSearch, $term, $limit, $filter)
	{
		$this->db->select($tblquery, FALSE);

		$i = 0;
		if ($filter) {
			$this->db->where($filter);
		}
		foreach ($columnSearch as $item) // loop column 
		{
			if ($term) // if datatable send POST for search
			{

				if ($i === 0) // first loop
				{
					$this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
					$this->db->like($item, $term);
				} else {
					$this->db->or_like($item, $term);
				}

				if (count($columnSearch) - 1 == $i) //last loop
					$this->db->group_end(); //close bracket
			}
			$i++;
		}

		$this->db->limit($limit);
		$query = $this->db->get();
		return $query->result();
	}

	public function table_fields($table)
	{
		return $this->db->list_fields($table);
	}
	public function getUnitSekolah()
	{
		//$this->db = $this->load->database('ypsan', TRUE);
		$q = $this->db->query("CALL getUnitSekolah()");
		return $q->result();
	}
	public function getPropinsi()
	{
		//$this->db = $this->load->database('ypsan', TRUE);
		//$q = $this->db->query("CALL getPropinsi()");
		$q = $this->db->get('propinsi');
		return $q->result();
	}

	public function getKabupaten($propID = 0)
	{
		//$this->db = $this->load->database('ypsan', TRUE);
		//$q = $this->db->query("CALL getKabupaten('".$propID."')");
		//$q = $this->db->get_where('kabupaten',array('propinsi_id'=>$propID));
		$q = $this->db->query("SELECT * FROM `kabupaten` WHERE LEFT(kode,2) = '" . $propID . "'");
		return $q->result();
	}

	public function getKecamatan($kabID = 0)
	{
		//$this->db = $this->load->database('ypsan', TRUE);
		//$q = $this->db->query("CALL getKecamatan('".$kabID."')");
		//$q = $this->db->get_where('kecamatan',array('kabupaten_id'=>$kabID));
		$q = $this->db->query("SELECT * FROM `kecamatan` WHERE LEFT(kode,5) = '" . $kabID . "'");
		return $q->result();
	}

	public function getDesa($kecID = 0)
	{
		//$this->db = $this->load->database('ypsan', TRUE);
		//$q = $this->db->query("CALL getDesa('".$kecID."')");
		//$q = $this->db->get_where('desa',array('kecamatan_id'=>$kecID));
		$q = $this->db->query("SELECT * FROM `desa` WHERE LEFT(kode,8) ='" . $kecID . "'");
		return $q->result();
	}

	public function getKonfigurasi()
	{
		return $this->db->get('konfigurasi');
	}

	public function getAppKonfig()
	{
		return  $this->db->get('konfig_app', 1);
	}

	public function getCalegAkunData()
	{
		$q = $this->db->query(" SELECT * FROM user_akun WHERE level_user_id = 3  ");
		return $q;
	}

	public function getDataDapilByTingkat($tingkatID)
	{
		$q = $this->db->query(' SELECT a.*, b.nama_tingkat FROM data_dapil a LEFT JOIN tingkat_pemilihan b ON a.tingkat_pemilihan_id = b.id where a.tingkat_pemilihan_id = ' . $tingkatID, false);
		return $q;
	}

	public function getAllDapil()
	{
		$q = $this->db->query(' SELECT a.*, b.nama_tingkat FROM data_dapil a LEFT JOIN tingkat_pemilihan b ON a.tingkat_pemilihan_id = b.id ', false);
		return $q;
	}
	public function getDapilByCaleg($calegAkunID = 0)
	{
		if ($calegAkunID) {
			$q = $this->db->select(' a.id_akun_caleg, c.nama_dapil, d.nama_tingkat FROM konfigurasi a LEFT JOIN data_kordapil b ON a.kordapil_akun_id = b.kordapil_akun_id LEFT JOIN data_dapil c ON b.kordapil_akun_id = c.id LEFT JOIN tingkat_pemilihan d ON c.tingkat_pemilihan_id = d.id ', false)->where('a.id_akun_caleg', $calegAkunID)->get();
			return $q;
		}
	}
	public function getDapilByKordapil($kordapilAkunID = 0)
	{
		if ($kordapilAkunID) {
			$q = $this->db->select(' a.kordapil_akun_id, a.dapil_id, b.nama_dapil, c.nama_tingkat FROM data_kordapil a LEFT JOIN data_dapil b ON a.dapil_id = b.id LEFT JOIN tingkat_pemilihan c ON b.tingkat_pemilihan_id = c.id ', false)->where('a.kordapil_akun_id', $kordapilAkunID)->get();
			return $q;
		}
	}
	public function getCalegByKordapil($kordapilAkunID = 0)
	{
		if ($kordapilAkunID) {
			$q = $this->db->select(' e.nama, a.id_akun_caleg, c.nama_dapil, d.nama_tingkat FROM konfigurasi a LEFT JOIN data_kordapil b ON a.kordapil_akun_id = b.kordapil_akun_id LEFT JOIN data_dapil c ON b.kordapil_akun_id = c.id LEFT JOIN tingkat_pemilihan d ON c.tingkat_pemilihan_id = d.id LEFT JOIN user_akun e ON a.id_akun_caleg = e.id ', false)->where('a.kordapil_akun_id', $kordapilAkunID)->get();
			return $q;
		}
	}

	public function getCalegIdByRelawanID($relawanID)
	{
		if ($relawanID) {
			$query = " a.nama_relawan, b.akun_id, b.caleg_akun_id, f.nama as nama_caleg, c.dapil_id, d.tingkat_pemilihan_id, e.nama_tingkat from data_relawan a LEFT JOIN data_koord_relawan b ON a.koord_akun_id = b.akun_id LEFT JOIN konfigurasi c ON b.caleg_akun_id = c.id_akun_caleg LEFT JOIN data_dapil d ON c.dapil_id = d.id LEFT JOIN tingkat_pemilihan e ON d.tingkat_pemilihan_id = e.id LEFT JOIN user_akun f ON b.caleg_akun_id = f.id ";
			$q = $this->db->select($query, false)->where('a.id', $relawanID)->get();

			return $q;
		}
	}

	public function getCalegByKoordRelawanID($koordAkunID)
	{
		if ($koordAkunID) {
			$query = " a.akun_id, a.caleg_akun_id, b.dapil_id, c.tingkat_pemilihan_id FROM data_koord_relawan a LEFT JOIN konfigurasi b ON a.caleg_akun_id = b.id_akun_caleg LEFT JOIN data_dapil c ON b.dapil_id = c.id ";
			$q = $this->db->select($query, false)->where('a.akun_id', $koordAkunID)->get();
			return $q;
		}
	}



	public function getRelawanByCalegID($calegID)
	{
		$q = $this->db->select("  a.id , a.nama_relawan, a.no_wa,  c.nama AS nama_caleg FROM data_relawan a LEFT JOIN data_koord_relawan b ON a.koord_akun_id = b.akun_id LEFT JOIN user_akun c ON b.caleg_akun_id = c.id ", false)->where('c.id', $calegID)->get();
		return $q;
	}
	public function getRelawanByKordapil($kordapilAkunID)
	{
		$q = $this->db->select(" a.id , a.nama_relawan, a.no_wa, c.nama AS nama_caleg, d.kordapil_akun_id FROM data_relawan a LEFT JOIN data_koord_relawan b ON a.koord_akun_id = b.akun_id LEFT JOIN user_akun c ON b.caleg_akun_id = c.id LEFT JOIN konfigurasi d ON d.id_akun_caleg = b.caleg_akun_id  ", false)->where('d.kordapil_akun_id', $kordapilAkunID)->group_by('a.id ')->order_by('b.caleg_akun_id', 'asc')->get();
		return $q;
	}
	public function getRelawanByAdminID($adminID)
	{
		$q = $this->db->select(" a.* , d.nama as nama_admin, c.nama AS nama_caleg FROM data_relawan a LEFT JOIN data_koord_relawan b ON a.koord_akun_id = b.akun_id LEFT JOIN user_akun c ON b.caleg_akun_id = c.id LEFT JOIN user_akun d ON a.koord_akun_id = d.id ", false)->where('a.koord_akun_id', $adminID)->group_by('a.id ')->get();
		return $q;
	}

	public function getAllRelawan()
	{
		$q = $this->db->select("  a.* , d.nama as nama_admin, c.nama AS nama_caleg FROM data_relawan a LEFT JOIN data_koord_relawan b ON a.koord_akun_id = b.akun_id LEFT JOIN user_akun c ON b.caleg_akun_id = c.id LEFT JOIN user_akun d ON a.koord_akun_id = d.id ", false)->group_by('a.id ')->get();
		return $q;
	}

	public function getKoordRelawanByCalegID($calegID)
	{
		$q = $this->db->select(" a.*, b.nama as nama_caleg, c.nama as nama_koord FROM data_koord_relawan a LEFT JOIN user_akun b ON a.caleg_akun_id = b.id LEFT JOIN user_akun c ON a.akun_id = c.id ", false)->where('a.caleg_akun_id', $calegID)->get();
		return $q;
	}

	public function getKoordRelawanByKordapilID($kordapilID)
	{
		$q = $this->db->select("  a.*, b.nama as nama_caleg, c.nama as nama_koord, d.kordapil_akun_id FROM data_koord_relawan a LEFT JOIN user_akun b ON a.caleg_akun_id = b.id LEFT JOIN user_akun c ON a.akun_id = c.id LEFT JOIN konfigurasi d ON d.id_akun_caleg = a.caleg_akun_id ", false)->where('d.kordapil_akun_id', $kordapilID)->get();
		return $q;
	}

	public function getAnggotaByCalegID($calegID)
	{

		$q = $this->db->select('  a.* FROM (
			SELECT * FROM `anggota_kota`
			UNION ALL
			SELECT * FROM anggota_ri
			UNION ALL
			SELECT * FROM anggota_propinsi
			) a ', false)->where(array('a.caleg_akun_id' => $calegID))->get();
		return $q;
	}
	public function getAnggotaByKordapilID($kordapilID)
	{

		$q = $this->db->select('  a.* FROM (
			SELECT * FROM `anggota_kota`
			UNION ALL
			SELECT * FROM anggota_ri
			UNION ALL
			SELECT * FROM anggota_propinsi
			) a ', false)->where(array('a.kordapil_akun_id' => $kordapilID))->get();
		return $q;
		# code...
	}

	public function getAnggotaByRelawanID($relawanID)
	{
		$q = $this->db->select('  a.* FROM (
			SELECT * FROM `anggota_kota`
			UNION ALL
			SELECT * FROM anggota_ri
			UNION ALL
			SELECT * FROM anggota_propinsi
			) a ', false)->where(array('a.relawan_id' => $relawanID))->get();
		return $q;
	}



	public function getTingkatPemilihanByRelawanID($relawanID = 0)
	{
		$q = $this->db->select('  a.id, a.nama_relawan, a.koord_akun_id, b.caleg_akun_id, c.kordapil_akun_id, d.tingkat_pemilihan_id  FROM data_relawan a LEFT JOIN data_koord_relawan b ON a.koord_akun_id = b.akun_id LEFT JOIN konfigurasi c ON b.caleg_akun_id = c.id_akun_caleg LEFT JOIN data_dapil d ON c.dapil_id = d.id ', false)->where('a.id', $relawanID)->get();
		return $q;
	}

	public function getTingkatPemilihanByKoordRelawanID($koordID = 0)
	{
		$q = $this->db->select('  a.id, a.nama_relawan, a.koord_akun_id, b.caleg_akun_id, c.kordapil_akun_id, d.tingkat_pemilihan_id  FROM data_relawan a LEFT JOIN data_koord_relawan b ON a.koord_akun_id = b.akun_id LEFT JOIN konfigurasi c ON b.caleg_akun_id = c.id_akun_caleg LEFT JOIN data_dapil d ON c.dapil_id = d.id ', false)->where('a.koord_akun_id', $koordID)->get();
		return $q;
	}

	public function getTingkatPemilihanByCalegID($calegAkunID = 0)
	{
		$q = $this->db->select('  a.id, a.nama_relawan, a.koord_akun_id, b.caleg_akun_id, c.kordapil_akun_id, d.tingkat_pemilihan_id  FROM data_relawan a LEFT JOIN data_koord_relawan b ON a.koord_akun_id = b.akun_id LEFT JOIN konfigurasi c ON b.caleg_akun_id = c.id_akun_caleg LEFT JOIN data_dapil d ON c.dapil_id = d.id ', false)->where('b.caleg_akun_id', $calegAkunID)->get();
		return $q;
	}

	public function getTingkatPemilihanByKordapilID($kordapilAkunID = 0)
	{
		$q = $this->db->select('  a.id, a.nama_relawan, a.koord_akun_id, b.caleg_akun_id, c.kordapil_akun_id, d.tingkat_pemilihan_id  FROM data_relawan a LEFT JOIN data_koord_relawan b ON a.koord_akun_id = b.akun_id LEFT JOIN konfigurasi c ON b.caleg_akun_id = c.id_akun_caleg LEFT JOIN data_dapil d ON c.dapil_id = d.id ', false)->where('c.kordapil_akun_id', $kordapilAkunID)->get();
		return $q;
	}




	public function updatePassword_rules()
	{
		$rules = [
			[
				'field' => 'oldpass',
				'label' => 'Password Lama',
				'rules' => 'trim|required',
				'errors' => array('required' => '%s wajib diisi'),
			],
			[
				'field' => 'newpass',
				'label' => 'Password Baru',
				'rules' => 'trim|required',
				'errors' => array('required' => '%s wajib diisi'),
			],
			[
				'field' => 'rnewpass',
				'label' => 'Konfirmasi Password',
				'rules' => 'trim|required|matches[newpass]',
				'errors' => array('required' => '%s wajib diisi', 'matches' => 'konfirmasi Password tidak sesuai'),
			],

		];
		return $rules;
	}
	public function akunDriverSelect2()
	{
		$term = $this->input->post('search');
		$tblquery = " * from user_akun ";
		$coloumnSearch = array('nama', 'email');
		$limit = 5;
		$filter = array('level >' => '2');
		$q = $this->searchTermArr($tblquery, $coloumnSearch, $term, $limit, $filter);
		$data = array();
		if ($q) {
			foreach ($q as $h) {
				$row = array();
				$row['id'] = $h->id;
				$row['text'] = "[" . $h->nama . "] " . $h->email;
				$data[] = $row;
			}
		}
		return $data;
	}
}

/* End of file MY_Model.php */
/* Location: ./application/core/MY_Model.php */