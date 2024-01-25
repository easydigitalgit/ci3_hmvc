<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends MX_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->tempUpload 		= dirname(APPPATH) . '/AppDoc/tempUpload/';
		$this->media 			= dirname(APPPATH) . '/AppDoc/media/';
		$this->Folderkonfig 	= dirname(APPPATH) . '/AppDoc/konfig/';
		$this->AppDoc 			= dirname(APPPATH) . '/AppDoc/';
		$this->reportDoc 		= dirname(APPPATH) . '/reportDoc/';
		$this->AssetsImage		= dirname(APPPATH) . '/vendor/assets/images/';

		/*
				$sess['ulevel'] 		= $data->level_user_id;
				$sess['uid'] 			= $data->id;
				$sess['username'] 		= $data->username;
				$sess['nama']			= $data->nama;
        */

		$this->USER			= $this->session->userdata('username');
		$this->UNAME		= $this->session->userdata('nama');
		$this->UID			= $this->session->userdata('uid');
		$this->ULEVEL 		= $this->session->userdata('ulevel');

		$this->form_validation->CI = &$this;
	}
	public function index()
	{
		header('location:' . site_url('auth/login'));
	}


	public function ajax_request()
	{
		if (!$this->input->is_ajax_request()) {
			$this->session->sess_destroy();
			exit('Direct access not permitted');
		}
	}


	public function rute_user()
	{
		if ($this->si_admin()) {
			header('location:' . site_url('admin/dashboard'));
		} else if ($this->si_operator()) {
			header('location:' . site_url('admin/dashboard'));
		} else {
			header('location:' . site_url('peserta'));
		}
	}



	public function selectPropinsi($mode = 0)
	{
		$this->load->model('MY_Model');
		$q = $this->MY_Model->getPropinsi();
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->kode . '">' . $val->nama . '</option>';
			}
		}
		return $this->echo_return($ret, $mode);
		//echo $ret;
	}

	public function selectKabupaten($propID = null, $mode = 0)
	{
		$this->load->model('MY_Model');
		$q = $this->MY_Model->getKabupaten($propID);
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->kode . '">' . $val->nama . '</option>';
			}
		}
		return $this->echo_return($ret, $mode);
	}

	public function selectKecamatan($kabID = null, $mode = 0)
	{
		$this->load->model('MY_Model');
		$q = $this->MY_Model->getKecamatan($kabID);
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->kode . '">' . $val->nama . '</option>';
			}
		}
		return $this->echo_return($ret, $mode);
	}

	public function selectDesa($kecID = null, $mode = 0)
	{
		$this->load->model('MY_Model');
		$q = $this->MY_Model->getDesa($kecID);
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->kode . '">' . $val->nama . '</option>';
			}
		}
		return $this->echo_return($ret, $mode);
	}

	public function selectPekerjaan($mode = 0)
	{
		$this->load->model('MY_Model');
		$q = $this->MY_Model->getListPekerjaan();
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->id . '">' . $val->nama_pekerjaan . '</option>';
			}
		}
		return $this->echo_return($ret, $mode);
	}

	public function selectHubunganKeluarga($mode = 0)
	{
		$this->load->model('MY_Model');
		$q = $this->MY_Model->getHubunganKeluarga();
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->id . '">' . $val->nama_hubungan . '</option>';
			}
		}
		return $this->echo_return($ret, $mode);
	}

	public function selectJenjangPendidikan($mode = 0)
	{
		$this->load->model('MY_Model');
		$q = $this->MY_Model->getJenjangPendidikan();
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->id . '">[' . $val->kode_jenjang . ']' . $val->nama_jenjang . '</option>';
			}
		}
		return $this->echo_return($ret, $mode);
	}

	public function getListJenisKontak($mode = 0)
	{
		$this->load->model('MY_Model');
		$q = $this->MY_Model->getJeniskontak();
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->id . '">' . $val->jenis_kontak . '</option>';
			}
		}
		return $this->echo_return($ret, $mode);
	}
	public function dd_biodata()
	{
		$this->load->model('MY_Model');
		$q = $this->MY_Model->ddBiodataSelect2();
		$this->jsonOut($q);
	}

	public function getListJenisKeanggotaan($mode = 0)
	{
		$this->load->model('MY_Model');
		$q = $this->MY_Model->getListKeanggotaan();
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->id . '">' . $val->kode_jenis_keanggotaan . '</option>';
			}
		}
		return $this->echo_return($ret, $mode);
	}

	public function selectStruktural($mode = 0)
	{
		$this->load->model('MY_Model');
		$q = $this->MY_Model->getListStruktural();
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->id . '">' . $val->nama_struktur . '</option>';
			}
		}
		return $this->echo_return($ret, $mode);
	}

	public function selectGrupId($mode = 0)
	{
		$this->load->model('MY_Model');
		$q = $this->MY_Model->getListUserGrup();
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->id . '">' . $val->kode_grup . '</option>';
			}
		}
		return $this->echo_return($ret, $mode);
	}

	public function selectUserLevel($mode = 0)
	{
		$this->load->model('MY_Model');
		$q = $this->MY_Model->getListUserLevel();
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->id . '">' . $val->user_level_name . '</option>';
			}
		}
		return $this->echo_return($ret, $mode);
	}


	function echo_return($data, $mode)
	{
		if ($mode == 0) {
			echo $data;
		} else {
			return $data;
		}
	}

	public function DataDelete($table, $data, $unlink = '')
	{
		$this->load->model('MY_Model');
		if (is_array($data)) {
			if (!empty($data)) {
				$del = $this->MY_Model->bulk_delete($table, $data, $unlink);
				if ($del) {
					$ret['status'] = true;
					$ret['msg'] = 'Data berhasil dihapus';
				} else {
					$ret['status'] = false;
					$ret['msg'] = 'Proses hapus data gagal';
				}
			}
		} elseif ($data) {
			$del = $this->MY_Model->delete_by_id($table, $data, $unlink);
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

		return $ret;
	}


	public function DataSoftDelete($table, $data)
	{
		$this->load->model('MY_Model');
		if (is_array($data)) {
			if (!empty($data)) {
				$del = $this->MY_Model->bulkSoftDeleteById($table, $data);
				if ($del) {
					$ret['status'] = true;
					$ret['msg'] = 'Data berhasil dihapus';
				} else {
					$ret['status'] = false;
					$ret['msg'] = 'Proses hapus data gagal';
				}
			}
		} elseif ($data) {
			$del = $this->MY_Model->softDeleteById($table, $data);
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

		return $ret;
	}



	public function jsonOut($output)
	{
		header('Content-Type: application/json');
		echo json_encode($output);
	}
	public function logOut()
	{
		$this->session->sess_destroy();
		header('location:' . site_url('auth/Login/index'));
	}
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */