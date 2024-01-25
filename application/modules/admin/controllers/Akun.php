<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Akun extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Admin_model', 'AM');
		$this->load->library('encryption');
		$this->load->library('token');
		$this->load->helper('actionbtn');
	}

	private function _theme($data)
	{

		$data['libjs']  	= jsbyEnv(array('libAkun'));
		$data['libcss'] 	= '';
		$data['pjs']        = jsArray(array('bs4-datatables', 'select2', 'chartjs'));
		$data['pcss']       = cssArray(array('datatables', 'select2', 'chartjs'));
		//$data['menu'] 		= 'admin/sideMenu';

		$this->theme->dashboard_theme($data);
	}




	// List all your items
	public function index()
	{


		$data['konten'] = 'akunKonten';

		$data['head_data_akun'] = head_tbl_btn2('data_akun', true);

		$this->_theme($data);
	}


	public function table_data_akun()
	{
		$table        = 'user_akun';
		$col_order    = array($table . '.id');
		$col_search   = array($table . '.nama', $table . '.level_user_id', $table . '.status_aktif');
		$order        = array($table . '.id' => 'ASC');
		$query        = " * FROM user_akun ";

		$filter       = array();

		//get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
		$list  = $this->AM->get_datatables($table, $col_order, $col_search, $order, $query, $filter);
		$data  = array();
		$no    = $_POST['start'];
		foreach ($list as $da) {
			$no++;
			$row   = array();
			$row[] = '<input type="checkbox" class="data-check" value="' . $da->id . '">';
			$row[] = $no;
			$row[] = $da->nama;
			$row[] = $da->username;
			$row[] = $da->level_user_id;
			$row[] = $da->status_aktif;
			$row[] = actbtn2($da->id, 'data_akun');


			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->AM->count_all_query($table, $filter),
			"recordsFiltered" => $this->AM->count_filtered($query, $filter, $filter),
			"data" => $data,
		);
		//output to json format
		$this->jsonOut($output);
	}
	// Add a new item
	public function add_data_akun()
	{
		$this->form_validation->set_rules($this->AM->dataAkunRules('add'));
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		if ($this->form_validation->run() == FALSE) {
			$ret['status'] = false;
			foreach ($_POST as $key => $value) {
				$ret['msg'][$key] = form_error($key);
			}
		} else {

			$data['nama']    		= $this->input->post('nama');
			$data['username']   	= $this->input->post('username');
			$data['level_user_id']			= $this->input->post('level_user_id');
			$data['status_aktif'] 		= $this->input->post('status_aktif');
			//$data['uniqid']		= $this->token->randomString(10);
			$data['password'] 		= $this->encryption->encrypt($this->input->post('password'));
			$data['created']		= date('Y-m-d H:i:s');
			//  $data['last_update']		= $this->input->post('no_mesin');

			$insert = $this->AM->insertDb('user_akun', $data);
			if ($insert) {

				$ret = array("status" => true, "msg" => "proses simpan data berhasil");
			} else {
				$ret = array("status" => false, "msg" => "proses simpan data gagal");
			}
		}

		$this->jsonOut($ret);
	}

	public function edit_data_akun($id)
	{
		if ($id) {
			$data   = $this->AM->get_by_id('user_akun', $id);
			if ($data) {
				$ret['status'] = true;
				foreach ($data as $key => $value) {
					if ($key == 'password') {
						$ret['data']['password'] = $this->encryption->decrypt($value);
					} else {
						$ret['data'][$key] = $value;
					}
				}
			} else {
				$ret['status'] = false;
				$ret['data'] = 0;
			}
		} else {
			$ret['status'] = false;
			$ret['data'] = 0;
		}

		$this->jsonOut($ret);
	}

	//Update one item
	public function update_data_akun()
	{
		$id = $this->input->post('id');
		$this->form_validation->set_rules($this->AM->dataakunRules('update'));
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		if ($this->form_validation->run() == FALSE) {
			$ret['status'] = false;
			foreach ($_POST as $key => $value) {
				$ret['msg'][$key] = form_error($key);
			}
		} else {

			$data['nama']    		= $this->input->post('nama');
			$data['username']   	= $this->input->post('username');
			$data['level_user_id'] = $this->input->post('level_user_id');
			$data['status_aktif'] 		= $this->input->post('status_aktif');
			//$data['uniqid']		= $this->token->randomString(10);
			$data['password'] 		= $this->encryption->encrypt($this->input->post('password'));



			$insert = $this->AM->update('user_akun', array('id' => $id), $data);
			if ($insert) {

				$ret = array("status" => true, "msg" => "proses simpan data berhasil");
			} else {
				$ret = array("status" => false, "msg" => "proses simpan data gagal");
			}
		}

		$this->jsonOut($ret);
	}

	//Delete one item
	public function delete_data_akun()
	{
		$list_id = $this->input->post('id');
		$table = 'user_akun';

		if (is_array($list_id)) {
			if (!empty($list_id)) {
				$del = $this->AM->bulk_delete($table, $list_id);
				if ($del) {
					$ret['status'] = true;
					$ret['msg'] = 'Data berhasil dihapus';
				} else {
					$ret['status'] = false;
					$ret['msg'] = 'Proses hapus data gagal';
				}
			}
		} elseif ($list_id) {
			$del = $this->AM->delete_by_id($table, $list_id);
			if ($del) {
				$ret['status'] = true;
				$ret['msg'] = 'Data berhasil dihapus';
			} else {
				$ret['status'] = false;
				$ret['msg'] = 'Proses hapus data gagal';
			}
		} else {
			$ret['status'] = false;
			$ret['msg'] = 'Data belum dipilih';
		}

		$this->jsonOut($ret);
	}




	private function _upload_images($fieldName, $name, $folder, $ovr = true, $ext = 'jpg|JPG|jpeg|JPEG|png|PNG', $maxSize = 2500, $maxWidth = 2500, $maxHeight = 2500)
	{
		//$userId = $this->session->userdata('userId');
		//$noref = $this->input->post('noref');
		$config = array();
		$config['upload_path']          = $this->AppDoc . $folder . '/';
		$config['allowed_types']        = $ext;
		$config['max_size']             = $maxSize; //set max size allowed in Kilobyte
		$config['max_width']            = $maxWidth; // set max width image allowed
		$config['max_height']           = $maxHeight; // set max height allowed
		$config['file_name']            = $fieldName . '_' . $name;
		$config['file_ext_tolower']     = TRUE;

		$this->load->library('upload', $config, $fieldName); // Create custom object for foto upload
		$this->$fieldName->initialize($config);
		$this->$fieldName->overwrite = $ovr;

		//upload and validate
		if ($this->$fieldName->do_upload($fieldName)) {
			$res['filename'] = $this->$fieldName->data('file_name');
			$res['error']    = '';
			$res['status']   = true;
		} else {
			$res['error']    =  $this->$fieldName->display_errors('<p class="text-danger">', '</p>');
			$res['filename'] = '';
			$res['status']   = false;
		}
		return $res;
	}
}

/* End of file Akun.php */
/* Location: ./application/modules/admin/controllers/Akun.php */
