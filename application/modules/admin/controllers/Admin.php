<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies
		$this->load->model('Admin_model', 'AM');
		$this->load->library('encryption');
		$this->load->library('SelectOption');
		$this->load->library('parser');
		$this->load->helper('starsender');
		$this->UID  ? '' : $this->logOut();
	}

	private function _theme($data)
	{

		$data['libjs']  		= jsbyEnv('libAdmin');
		$data['libcss'] 		= '';
		$data['pjs']        	= jsArray(array('bs4-datatables', 'select2', 'chartjs'));
		$data['pcss']       	= cssArray(array('datatables', 'select2', 'chartjs'));
		//$data['menu'] 		= 'admin/sideMenu';

		$this->theme->dashboard_theme($data);
	}

	public function dekrip()
	{
		//$p = $this->input->post('pass'); 
		$p = '5273207f8f90238ddeae55510290454dc31e54ab02a1b803947587232a8636f716cb68c8539d3c169e9ac63df7b6fecce268ba641b0d4189a88b1bdeccf3bc69vUliDF4jEWRrMW1NqpbMNi/CYJ0HLsrNsh/Bj+brBkebyXYkUtOAImmq7NeFXLcz'; //PKSDeliJuara2024
		$ret = $this->encryption->decrypt($p);
		$this->jsonOut($ret);
	}

	public function upgrade($var = '')
	{
		// INSERT INTO data_pilihan_caleg (anggota_id, relawan_id_kota) SELECT id, relawan_id FROM anggota;
	}

	public function migrasi()
	{
		/*  
		LOCK TABLES anggota WRITE, user_akun WRITE, konfigurasi WRITE, data_relawan WRITE, data_kordapil WRITE, data_koord_relawan WRITE
		
		 UPDATE `anggota` SET `relawan_id` = '175' WHERE `anggota`.`id` > 11165 AND anggota.relawan_id = 81; 
		 UPDATE `anggota` SET `relawan_id` = '176' WHERE `anggota`.`id` > 11165 AND anggota.relawan_id = 82;
		 UPDATE `anggota` SET `relawan_id` = '177' WHERE `anggota`.`id` > 11165 AND anggota.relawan_id = 83;
		 UPDATE `anggota` SET `relawan_id` = '178' WHERE `anggota`.`id` > 11165 AND anggota.relawan_id = 84; 
		 UPDATE `anggota` SET `relawan_id` = '179' WHERE `anggota`.`id` > 11165 AND anggota.relawan_id = 85;
		 UPDATE `anggota` SET `relawan_id` = '180' WHERE `anggota`.`id` > 11165 AND anggota.relawan_id = 86;
		 UPDATE `anggota` SET `relawan_id` = '181' WHERE `anggota`.`id` > 11165 AND anggota.relawan_id = 87;
		 UPDATE `anggota` SET `relawan_id` = '182' WHERE `anggota`.`id` > 11165 AND anggota.relawan_id = 88;
		 UPDATE `anggota` SET `relawan_id` = '183' WHERE `anggota`.`id` > 11165 AND anggota.relawan_id = 89;
		 UPDATE `anggota` SET `relawan_id` = '184' WHERE `anggota`.`id` > 11165 AND anggota.relawan_id = 90;
		 UPDATE `anggota` SET `relawan_id` = '185' WHERE `anggota`.`id` > 11165 AND anggota.relawan_id = 91;
		 UPDATE `anggota` SET `relawan_id` = '186' WHERE `anggota`.`id` > 11165 AND anggota.relawan_id = 92;
		 UPDATE `anggota` SET `relawan_id` = '187' WHERE `anggota`.`id` > 11165 AND anggota.relawan_id = 93;
		 UPDATE `anggota` SET `relawan_id` = '188' WHERE `anggota`.`id` > 11165 AND anggota.relawan_id = 94; 
		 UPDATE `anggota` SET `relawan_id` = '189' WHERE `anggota`.`id` > 11165 AND anggota.relawan_id = 95;
		 UPDATE `anggota` SET `relawan_id` = '190' WHERE `anggota`.`id` > 11165 AND anggota.relawan_id = 96;  

		 SELECT * FROM anggota WHERE nik IN (SELECT nik FROM anggota GROUP BY nik HAVING COUNT(nik) > 1) ORDER BY nik; 

		 DELETE FROM anggota WHERE nik IN (SELECT nik FROM anggota GROUP BY nik HAVING COUNT(nik) > 1) AND id > 11165 ORDER BY nik, id DESC;
		 */
		//pindahkan yang duplikat
		$q = " SELECT * FROM anggota WHERE nik IN (SELECT nik FROM anggota GROUP BY nik HAVING COUNT(nik) > 1) ORDER BY nik, id DESC";
		$sid = array();
		$tid = array();
		$s = 0;
		$t = 0;

		$query = $this->db->query($q);
		if ($query->num_rows()) {
			foreach ($query->result() as  $value) {
				if ($value->id > 11165) {
					$sid[$s] = $value->id;
					$s++;
				} else {
					$tid[$t] = $value->id;
					$t++;
				}
			}
		} else {
			echo 'query failed';
		}

		if (count($sid) == count($tid)) {
			for ($i = 0; $i < count($sid); $i++) {
				$tempSql = " WITH SourceValues AS (
					SELECT relawan_id, createdby
					FROM anggota
					WHERE id =  " . $sid[$i] . "
				)
				UPDATE data_pilihan_caleg d
				JOIN SourceValues sv ON d.anggota_id = " . $tid[$i] . "
				SET d.relawan_id_ri = sv.relawan_id, d.createdby_ri = sv.createdby; ";

				$update = $this->db->query($tempSql);

				echo '<pre>';
				if ($update) {
					echo " \\$sid " . $sid[$i] . " -- ok";
				} else {
					echo " \\$sid " . $sid[$i] . " -- fail";
				}

				echo '</pre>';
			}
		} else {
			echo 'failed array';
		}


		//hapus data duplikat id >11165
		/*  
		CREATE TEMPORARY TABLE TempNiks AS
		SELECT nik
		FROM anggota
		GROUP BY nik
		HAVING COUNT(nik) > 1;

		DELETE FROM anggota
		WHERE nik IN (SELECT nik FROM TempNiks) AND id > 11165;

		DROP TEMPORARY TABLE IF EXISTS TempNiks;
 		*/

		// pindahkan sisanya ke data pilihan caleg
		/* 
		INSERT INTO data_pilihan_caleg (anggota_id, relawan_id_ri, createdby_ri) SELECT id, relawan_id, createdby FROM anggota WHERE id > 11165; 
		 */
	}



	// List all your items
	public function index($string = null)
	{

		$ulevel = $this->ULEVEL;
		if ($ulevel == 1) {
			$data['konten'] = 'appKonfigKonten';

			$this->_theme($data);
		} else {
			show_404('', true);
		}
	}

	public function get_konfig_apps()
	{
		$q = $this->db->get('konfig_app');
		if ($q->num_rows()) {
			$ret['status']  = true;
			$ret['data'] = $q->row();
		} else {
			$ret['status'] = false;
			$ret['data'] = null;
		}
		$this->jsonOut($ret);
	}

	public function dashboard_box()
	{

		$ret['status'] = true;
		$ret['data'] = $this->AM->dashboardBox();
		$this->jsonOut($ret);
	}


	public function select_wa_template()
	{
		echo $this->selectoption->selectWATemplate();
	}

	public function tes_cron()
	{
		log_message('debug', 'CRON CALLed ON  ' . date('d-m-Y h:i:s'));
	}
	public function add_konfigurasi_apps()
	{
		$id =  $this->input->post('id');
		$tableName = 'konfig_app';
		$this->form_validation->set_rules($this->AM->addDataKonfigurasiRules('add'));
		$this->form_validation->set_error_delimiters('<p class= "text-danger" >', '</p>');
		if ($this->form_validation->run() == FALSE) {
			$ret['status'] = false;
			foreach ($_POST as $key => $value) {
				$ret['msg'][$key] = form_error($key);
			}
		} else {
			$data['judul_tab'] = $this->input->post('judul_tab');
			$data['login_logo'] = $this->input->post('login_logo');
			$data['default_small_menu_logo'] = $this->input->post('default_small_menu_logo');
			$data['default_long_menu_logo'] = $this->input->post('default_long_menu_logo');
			$data['default_admin_photo'] = $this->input->post('default_admin_photo');

			$insert = $this->AM->insertDb($tableName, $data, $id);
			if ($insert) {
				$ret = array('status' => true, 'msg' => 'proses simpan data berhasil');
			} else {
				$ret = array('status' => false, 'msg' => 'proses simpan data gagal');
			}
		}
		$this->jsonOut($ret);
	}

	public function upload_foto()
	{
		$idFile 	= $this->input->post('idFile');
		$uid 		= $this->UID;

		$fileFolder = $this->tempUpload;

		//$box = 	'<div> <a href="' . $imgPath . '"  data-toggle="lightbox"   data-caption="' . $cap . '"  class="my-lightbox-toggle">
		//	 			<img src="' . $thumb . '" class="img-responsive img-fluid" width="100px"> </a> </div>';

		if (!empty($_FILES['fileFoto']['name'])) {
			$filename =  $idFile;
			$upload_file = $this->_upload_images('fileFoto', $filename, $fileFolder);
			if ($upload_file['status']) {
				$ret['status'] = true;
				$ret['data']['fileName'] = $upload_file['filename'];
				$ret['data']['fileUrl'] = base_url() . 'tempUpload/' . $upload_file['filename'];
				/* $ret['data']['url'] = '<div class="col-md-12 foto_' . $idFile . '"> <a href="' . base_url() . 'AppDoc/temp_file/' . $upload_file['filename'] . '"   data-toggle="lightbox" class="my-lightbox-toggle" > <i class="bx bx-images"></i> Foto</a> 
	                	<input type="hidden" name="foto_' . $idFile . '" id="foto_' . $idFile . '" data-tipe="foto-file" value="' . $upload_file['filename'] . '">
	                	</div>'; */
				$ret['msg']['success'] = 'file berhasil diupload';
			} else {
				$ret['status'] = false;
				$ret['msg']['error'] = $upload_file['error'];
			}
		} else {
			$ret['status'] = false;
			$ret['msg']['error'] = 'file not found';
		}


		$this->jsonOut($ret);
	}

	private function _upload_images($fieldName, $name, $folder, $ovr = true, $ext = 'jpg|JPG|jpeg|JPEG|png|PNG', $maxSize = 4096, $maxWidth = 4500, $maxHeight = 4500)
	{
		//$userId = $this->session->userdata('userId');
		//$noref = $this->input->post('noref');
		$config = array();
		$config['upload_path']          =  $folder;
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

/* End of file Admin.php */
/* Location: ./application/modules/admin/controllers/Admin.php */
