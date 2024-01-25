<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Paket_tes extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pengaturan_model', 'PM');
		$this->load->library('SelectOption');
	}
	private function _theme($data)
	{

		$data['libjs']  		= jsbyEnv('libPengaturan');
		$data['libcss'] 		= '';
		$data['pjs']        	= jsArray(array('bs4-datatables', 'select2'));
		$data['pcss']       	= cssArray(array('datatables', 'select2'));
		//$data['menu'] 		= 'admin/sideMenu';

		$this->theme->dashboard_theme($data);
	}

	// List all your items
	public function index()
	{
		$data['konten'] = 'paketTesKonten';
		$data['libcss'] = '';
		$data['headPaketTes'] = head_tbl_btn2('paket_tes', true);
		$this->_theme($data);
	}

	public function table_paket_tes()
	{
		$table        = 'paket_tes';
		$col_order    = array('id');
		$col_search   = array('a.kode_paket_tes');
		$order        = array('id' => 'ASC');
		$query        = "   a.*, b.kode as kodeunit,  b.nama as namaunit , c.nama_jenjang_kelas, d.nama as namaprogram, e.nama_jenis_tes as namates FROM paket_tes a LEFT JOIN unit_sekolah b on a.unit_sekolah_id = b.id LEFT JOIN jenjang_kelas c ON a.jenjang_kelas_id = c.id LEFT JOIN jenis_program d on a.program_id = d.id LEFT JOIN jenis_tes_seleksi e on a.jenis_tes_seleksi_id = e.id ";


		$filter       = array();

		//get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
		$list  = $this->PM->get_datatables($table, $col_order, $col_search, $order, $query, $filter);
		$data  = array();
		$no    = $_POST['start'];
		foreach ($list as $da) {
			$no++;
			$row   = array();
			$row[] = '<input type="checkbox" class="data-check" value="' . $da->id . '">';
			$row[] = $no;
			$row[] = $da->kode_paket_tes;
			$row[] = '[' . $da->kodeunit . '] ' . $da->nama_jenjang_kelas;

			$row[] = $da->namaprogram;
			$row[] = $da->namates;


			$row[] = actbtn2($da->id, 'paket_tes');


			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->PM->count_all_query($table, $filter),
			"recordsFiltered" => $this->PM->count_filtered($query, $filter, $filter),
			"data" => $data,
		);
		//output to json format
		$this->jsonOut($output);
	}
	// Add a new item
	public function add_paket_tes()
	{
		$this->form_validation->set_rules($this->PM->paketTesRules('add'));
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		if ($this->form_validation->run() == FALSE) {
			$ret['status'] = false;
			foreach ($_POST as $key => $value) {
				$ret['msg'][$key] = form_error($key);
			}
		} else {


			$data['program_id']			= $this->input->post('program_id');
			$data['unit_sekolah_id'] 	= $this->input->post('unit_sekolah_id');
			$data['jenjang_kelas_id']	= $this->input->post('jenjang_kelas_id');
			$data['kode_paket_tes']		= $this->input->post('kode_paket_tes');
			$data['jenis_tes_seleksi_id']		= $this->input->post('jenis_tes_seleksi_id');
			//$data['kode_jenjang_kelas']	= $this->input->post('kode_jenjang_kelas');

			//$data['last_update']  			= date('Y-m-d H:i:s');

			$insert = $this->PM->insertDb('paket_tes', $data);
			if ($insert) {
				$ret = array("status" => true, "msg" => "proses simpan data berhasil");
			} else {
				$ret = array("status" => false, "msg" => "proses simpan data gagal");
			}
		}

		$this->jsonOut($ret);
	}

	public function edit_paket_tes($id)
	{
		if ($id) {
			$data   = $this->PM->get_by_id('paket_tes', $id);


			if ($data) {
				$ret['status'] 	= true;
				$ret['data'] 	= $data;
			} else {
				$ret['status'] 	= false;
				$ret['data'] 	= 0;
			}
		} else {
			$ret['status'] 	= false;
			$ret['data'] 	= 0;
		}

		$this->jsonOut($ret);
	}

	//Update one item
	public function update_paket_tes()
	{
		$this->form_validation->set_rules($this->PM->paketTesRules('edit'));
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		if ($this->form_validation->run() == FALSE) {
			$ret['status'] = false;
			foreach ($_POST as $key => $value) {
				$ret['msg'][$key] = form_error($key);
			}
		} else {
			$id = $this->input->post('id');

			$data['program_id']				= $this->input->post('program_id');
			$data['unit_sekolah_id'] 		= $this->input->post('unit_sekolah_id');
			$data['jenjang_kelas_id']		= $this->input->post('jenjang_kelas_id');
			$data['kode_paket_tes']			= $this->input->post('kode_paket_tes');
			$data['jenis_tes_seleksi_id']	= $this->input->post('jenis_tes_seleksi_id');


			//$data['last_update']  			= date('Y-m-d H:i:s');

			$insert = $this->PM->update('paket_tes', array('id' => $id), $data);
			if ($insert) {
				$ret = array("status" => true, "msg" => "proses simpan data berhasil");
			} else {
				$ret = array("status" => false, "msg" => "proses simpan data gagal");
			}
		}

		$this->jsonOut($ret);
	}

	//Delete one item
	public function delete_paket_tes()
	{
		$data 	= $this->input->post('id');
		$table 	= 'paket_tes';

		$ret 	= $this->DataDelete($table, $data);

		$this->jsonOut($ret);
	}

	public function select_jenjang_kelas($unitID)
	{
		if ($unitID) {
			echo $this->selectoption->selectJenjangKelas($unitID);
		}
	}

	public function select_jenis_tes()
	{
		echo $this->selectoption->selectStd('jenis_tes_seleksi', 'id', 'nama_jenis_tes');
	}
}

/* End of file Paket_tes.php */
/* Location: ./application/modules/pengaturan/controllers/Paket_tes.php */
