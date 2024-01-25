<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sub_tes extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
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
		$data['konten'] = 'subTesKonten';
		$data['headSubTes'] = head_tbl_btn2('sub_tes', true);
		$this->_theme($data);
	}

	public function table_sub_tes()
	{
		$table        = 'sub_tes';
		$col_order    = array('id');
		$col_search   = array('a.nama_sub_tes', 'b.kode_jenis_tes');
		$order        = array('a.jenis_tes_id' => 'ASC');
		$query        = "   a.*, b.kode_jenis_tes FROM sub_tes a LEFT JOIN jenis_tes_seleksi b ON a.jenis_tes_id = b.id";


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
			$row[] = $da->kode_jenis_tes;
			$row[] = $da->nama_sub_tes;

			$row[] = $da->keterangan_sub_tes;


			$row[] = actbtn2($da->id, 'sub_tes');


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
	public function add_sub_tes()
	{
		$this->form_validation->set_rules($this->PM->subTesRules('add'));
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		if ($this->form_validation->run() == FALSE) {
			$ret['status'] = false;
			foreach ($_POST as $key => $value) {
				$ret['msg'][$key] = form_error($key);
			}
		} else {


			$data['jenis_tes_id']		= $this->input->post('jenis_tes_id');
			$data['nama_sub_tes'] 		= $this->input->post('nama_sub_tes');
			$data['keterangan_sub_tes']	= $this->input->post('keterangan_sub_tes');

			$data['last_update']  		= date('Y-m-d H:i:s');

			$insert = $this->PM->insertDb('sub_tes', $data);
			if ($insert) {
				$ret = array("status" => true, "msg" => "proses simpan data berhasil");
			} else {
				$ret = array("status" => false, "msg" => "proses simpan data gagal");
			}
		}

		$this->jsonOut($ret);
	}

	public function edit_sub_tes($id)
	{
		if ($id) {
			$data   = $this->PM->get_by_id('sub_tes', $id);


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
	public function update_sub_tes($id = NULL)
	{

		$this->form_validation->set_rules($this->PM->subTesRules('edit'));
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		if ($this->form_validation->run() == FALSE) {
			$ret['status'] = false;
			foreach ($_POST as $key => $value) {
				$ret['msg'][$key] = form_error($key);
			}
		} else {


			$data['jenis_tes_id']		= $this->input->post('jenis_tes_id');
			$data['nama_sub_tes'] 		= $this->input->post('nama_sub_tes');
			$data['keterangan_sub_tes']	= $this->input->post('keterangan_sub_tes');

			$data['last_update']  		= date('Y-m-d H:i:s');

			$insert = $this->PM->update('sub_tes', array('id' => $id), $data);
			if ($insert) {
				$ret = array("status" => true, "msg" => "proses simpan data berhasil");
			} else {
				$ret = array("status" => false, "msg" => "proses simpan data gagal");
			}
		}

		$this->jsonOut($ret);
	}

	//Delete one item
	public function delete_sub_tes($id = NULL)
	{
		$table 	= 'sub_tes';
		$data 	= $this->input->post('id');

		$ret 	= $this->DataDelete($table, $data);

		$this->jsonOut($ret);
	}

	public function select_jenis_tes()
	{
		echo $this->selectoption->selectStd('jenis_tes_seleksi', 'id', 'nama_jenis_tes');
	}
}

/* End of file Sub_tes.php */
/* Location: ./application/modules/pengaturan/controllers/Sub_tes.php */
