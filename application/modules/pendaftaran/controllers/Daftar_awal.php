<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Daftar_awal extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pendaftaran_model', 'PM');
		$this->load->library('SelectOption');
		//Load Dependencies

	}

	private function _theme($data)
	{

		$data['libjs']  		= jsbyEnv('libDaftarAwal');
		$data['libcss'] 		= '';
		$data['pjs']        	= jsArray(array('bs4-datatables', 'select2', 'moment2.24', 'daterangepicker', 'lightbox'));
		$data['pcss']       	= cssArray(array('datatables', 'select2', 'daterangepicker'));
		//$data['menu'] 		= 'admin/sideMenu';

		$this->theme->dashboard_theme($data);
	}

	// List all your items
	public function index()
	{
		$data['konten'] = 'daftarAwalKonten';
		$data['libcss'] = '';
		$data['head_daftar_awal'] = head_tbl_btn2('daftar_awal', false);
		$this->_theme($data);
	}

	public function table_daftar_awal()
	{
		$genderArr = array('M' => 'Laki-laki', 'F' => 'Perempuan');
		$jenisPendaftar = array('1' => 'Siswa Baru', '2' => 'Siswa Pindah');
		$table        = 'pendaftaran';
		$col_order    = array('a.id');
		$col_search   = array('a.noreg', 'b.nama_thn_ajaran', 'c.kode', 'd.nama_jenjang_kelas', 'e.kode', 'e.nama');
		$order        = array('id' => 'ASC');
		$query        = " a.*, b.nama_thn_ajaran, c.kode as kode_unit, d.nama_jenjang_kelas, e.nama as jenis_pendaftar, f.nama as nama_verify FROM pendaftaran a LEFT join tahun_ajaran b ON a.tahun_ajaran_id = b.id LEFT JOIN unit_sekolah c on a.tingkat_id = c.id LEFT JOIN jenjang_kelas d on a.jenjang_kelas_id = d.id LEFT JOIN jenis_pendaftaran e on a.jenis_pendaftaran_id = e.id LEFT JOIN user_akun f ON a.verifiedby = f.id ";


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
			$row[] = $da->noreg;
			$row[] = $da->nama_thn_ajaran;
			$row[] = $da->jenis_pendaftar;
			$row[] = '[' . $da->kode_unit . '] ' . $da->nama_jenjang_kelas;
			$row[] = $da->nama_lengkap . '<br>' . $genderArr[$da->gender] . '<br>' . $da->dob;
			$row[] = $da->nama_ortu . '<br>' . $da->alamat_rumah . '<br> No.WA:' . $da->no_wa . ' <br>' . $da->email;
			$imgFolder = base_url("AppDoc/") . strtolower($da->kode_unit) . '/';
			$row[] = lightbox($imgFolder . $da->scan_akte, '', 'Scan Akte')  . lightbox($imgFolder . $da->scan_payment, '', 'Scan Payment');
			$row[] = badgeStatusPayment($da->status_payment);

			$row[] = badgeStatusDaftarAwal($da->status_verifikasi);
			$row[] = actionBtn3($da->id, 'daftar_awal');


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
	public function add_daftar_awal()
	{
		$this->form_validation->set_rules($this->PM->dataPendaftaranRules('add'));
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		if ($this->form_validation->run() == FALSE) {
			$ret['status'] = false;
			foreach ($_POST as $key => $value) {
				$ret['msg'][$key] = form_error($key);
			}
		} else {

			$tingkat = array('1' => 'pg', '2' => 'tk', '3' => 'sd', '4' => 'smp', '5' => 'sma');

			$data['tahun_ajaran_id']			= $this->input->post('tahun_ajaran_id');
			$data['tingkat_id']    			= $this->input->post('tingkat_id');
			$data['jenjang_kelas_id']   		= $this->input->post('jenjang_kelas_id');
			$data['jenis_pendaftaran_id']  	= $this->input->post('jenis_pendaftaran_id');
			$data['program']					= $this->input->post('program');
			$data['nama_lengkap']				= $this->input->post('nama_lengkap');

			$data['dob'] 						= $this->input->post('dob');
			$data['gender']					= $this->input->post('gender');
			$data['asal_sekolah']	 			= $this->input->post('asal_sekolah');
			$data['nama_ortu']					= $this->input->post('nama_ortu');
			$data['no_wa']						= $this->input->post('no_wa');
			$data['alamat_rumah']				= $this->input->post('alamat_rumah');
			$data['email']						= $this->input->post('email');
			$data['status_payment']			= $this->input->post('status_payment');
			$data['status_verifikasi']			= $this->input->post('status_verifikasi');

			$data['verifiedby'] = $this->input->post('status_verifikasi') ? $this->UID	: '0';

			$data['last_update']				= date('Y-m-d H:i:s');

			$data['created']					= date('Y-m-d H:i:s');

			if ($data['tingkat_id']) {
				$imageFolder = $tingkat[$data['tingkat_id']];
			}



			$ret['statusScanAkte']    = true;
			$ret['statusScanPayment'] = true;

			if (!empty($_FILES['scan_akte']['name'])) {
				$filename = $this->input->post('tingkat_id') . '_' . uniqid();
				$uplod_foto = $this->_upload_images('scan_akte', $filename, $imageFolder);
				if ($uplod_foto['status']) {
					$data['scan_akte'] = $uplod_foto['filename'];
					$ret['status'] = true;
				} else {
					$ret['msg']['scan_akte'] = $uplod_foto['error'];
					$ret['status'] = false;
					$uploadError['scan_akte'] = $uplod_foto['error'];
					$ret['statusScanAkte']    = false;
				}
			} else {
				$ret['status'] = true;
			}


			if (!empty($_FILES['scan_payment']['name'])) {
				$filename = $this->input->post('tingkat_id') . '_' . uniqid();
				$uplod_foto = $this->_upload_images('scan_payment', $filename, $imageFolder);
				if ($uplod_foto['status']) {
					$data['scan_payment'] = $uplod_foto['filename'];
					$ret['status'] = true;
				} else {
					$ret['msg']['scan_payment'] = $uplod_foto['error'];
					$ret['status'] = false;
					$uploadError['scan_payment'] = $uplod_foto['error'];
					$ret['statusScanPayment']    = false;
				}
			} else {
				$ret['status'] = true;
			}

			if ($ret['statusScanAkte'] && $ret['statusScanPayment']) {
				$insert = $this->PM->save('pendaftaran', $data);
				if ($insert) {
					$dt['noreg'] = $this->_generateNoreg($insert);
					$insertNoreg = $this->PM->update('pendaftaran', array('id' => $insert), $dt);
					$d = array();
					$d['tanggal_tes'] 		= date('Y-m-d H:i:s', strtotime($this->input->post('tanggal_tes')));
					$d['pendaftaran_id'] 	= $id;
					$d['status_tes'] 		= '1';
					$d['created']			= date('Y-m-d H:i:s');

					$insertJadwal = $this->PM->insertOnDuplicate('jadwal_seleksi_psb', $d);
					$ret['status'] = true;
					$ret['msg'] = "Data berhasil disimpan";
					$ret['noreg'] = $dt['noreg'];

					//$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
				} else {
					$ret = array("status" => false, "msg" => "proses simpan data gagal");
				}
			} else {
				$ret['status'] = false;
			}
		}


		$this->jsonOut($ret);
	}

	public function edit_daftar_awal($id)
	{
		if ($id) {
			$data   = $this->PM->getDaftarAwalByID($id);


			if ($data) {
				$ret['status'] 	= true;
				$ret['data'] 	= $data->row();
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
	public function update_daftar_awal($id = NULL)
	{
		$id = $this->input->post('id');
		$this->form_validation->set_rules($this->PM->dataPendaftaranRules('add'));
		$this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
		if ($this->form_validation->run() == FALSE) {
			$ret['status'] = false;
			foreach ($_POST as $key => $value) {
				$ret['msg'][$key] = form_error($key);
			}
		} else {

			$tingkat = array('1' => 'pg', '2' => 'tk', '3' => 'sd', '4' => 'smp', '5' => 'sma');

			$data['tahun_ajaran_id']			= $this->input->post('tahun_ajaran_id');
			$data['tingkat_id']    			= $this->input->post('tingkat_id');
			$data['jenjang_kelas_id']   		= $this->input->post('jenjang_kelas_id');
			$data['jenis_pendaftaran_id']  	= $this->input->post('jenis_pendaftaran_id');
			$data['program']					= $this->input->post('program');
			$data['nama_lengkap']				= $this->input->post('nama_lengkap');

			$data['dob'] 						= $this->input->post('dob');
			$data['gender']					= $this->input->post('gender');
			$data['asal_sekolah']	 			= $this->input->post('asal_sekolah');
			$data['nama_ortu']					= $this->input->post('nama_ortu');
			$data['no_wa']						= $this->input->post('no_wa');
			$data['alamat_rumah']				= $this->input->post('alamat_rumah');
			$data['email']						= $this->input->post('email');
			$data['status_payment']			= $this->input->post('status_payment');
			$data['status_verifikasi']			= $this->input->post('status_verifikasi');
			$data['verifiedby'] = $this->input->post('status_verifikasi') ? $this->UID	: '0';

			$data['last_update']				= date('Y-m-d H:i:s');



			if ($data['tingkat_id']) {
				$imageFolder = $tingkat[$data['tingkat_id']];
			}



			if (!empty($_FILES['scan_akte']['name'])) {
				$filename = $this->input->post('tingkat_id') . '_' . uniqid();
				$uplod_foto = $this->_upload_images('scan_akte', $filename, $imageFolder);
				if ($uplod_foto['status']) {
					$data['scan_akte'] = $uplod_foto['filename'];
					$ret['status'] = true;
				} else {
					$ret['msg']['scan_akte'] = $uplod_foto['error'];
					$ret['status'] = false;
					$uploadError['scan_akte'] = $uplod_foto['error'];
				}
			} else {
				$ret['status'] = true;
			}


			if (!empty($_FILES['scan_payment']['name'])) {
				$filename = $this->input->post('tingkat_id') . '_' . uniqid();
				$uplod_foto = $this->_upload_images('scan_payment', $filename, $imageFolder);
				if ($uplod_foto['status']) {
					$data['scan_payment'] = $uplod_foto['filename'];
					$ret['status'] = true;
				} else {
					$ret['msg']['scan_payment'] = $uplod_foto['error'];
					$ret['status'] = false;
					$uploadError['scan_payment'] = $uplod_foto['error'];
				}
			} else {
				$ret['status'] = true;
			}


			if ($ret['status']) {
				$insert = $this->PM->update('pendaftaran', array('id' => $id), $data);
				if ($insert) {
					//$dt['noreg'] = $this->_generateNoreg($insert);
					//$insertNoreg = $this->PM->update('pendaftaran', array('id'=>$insert), $dt);
					$d = array();
					$d['tanggal_tes'] 		= date('Y-m-d H:i:s', strtotime($this->input->post('tanggal_tes')));
					$d['pendaftaran_id'] 	= $id;
					$d['status_tes'] 		= '1';
					$d['created']			= date('Y-m-d H:i:s');

					$insertJadwal = $this->PM->insertOnDuplicate('jadwal_seleksi_psb', $d);

					$ret['status'] 			= true;
					$ret['msg'] 				= "Data berhasil disimpan";

					//$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
				} else {
					$ret = array("status" => false, "msg" => "proses simpan data gagal");
				}
			}
		}




		$this->jsonOut($ret);
	}

	//Delete one item
	public function delete_daftar_awal()
	{
		$data 	= $this->input->post('id');
		$table 	= 'pendaftaran';

		$ret 	= $this->DataDelete($table, $data);

		$this->jsonOut($ret);
	}


	public function verify()
	{
	}

	public function select_jenjang_kelas($unitID)
	{
		if ($unitID) {
			echo $this->selectoption->selectJenjangKelas($unitID);
		}
	}


	public function _generateNoreg($id)
	{
		//PSB22040101
		$noreg = "PSB" . date('ymd') . $id;
		return $noreg;
	}

	private function _upload_images($fieldName, $name, $folder, $ovr = true, $ext = 'jpg|JPG|jpeg|JPEG|png|PNG', $maxSize = 2500, $maxWidth = 4500, $maxHeight = 4500)
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

/* End of file Daftar_awal.php */
/* Location: ./application/modules/pendaftaran/controllers/Daftar_awal.php */
