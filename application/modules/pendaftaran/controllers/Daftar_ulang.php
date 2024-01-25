<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_ulang extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		//Load Dependencies

	}

	private function _theme($data){
		
		//$data['libjs']  		= jsbyEnv('libAdmin');
		$data['libcss'] 		= '';
		$data['pjs']        	= jsArray(array('bs4-datatables','select2'));
  		$data['pcss']       	= cssArray(array('datatables','select2'));
		//$data['menu'] 		= 'admin/sideMenu';

		$this->theme->dashboard_theme($data);
	}

	// List all your items
	public function index( ){
		$data['konten'] = 'daftarUlangKonten';
		$data['libcss'] = '';
		
		$this->_theme($data);
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
}

/* End of file Daftar_ulang.php */
/* Location: ./application/modules/pendaftaran/controllers/Daftar_ulang.php */
