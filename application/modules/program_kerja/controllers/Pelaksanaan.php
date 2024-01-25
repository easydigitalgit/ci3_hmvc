<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelaksanaan extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Agenda_model', 'AM');
		$this->load->library('encryption');
		$this->load->library('SelectOption');
		$this->load->library('parser');


		$this->UID  ? '' : $this->logOut();
	}

	private function _theme($data)
	{

		$data['libjs']          = jsbyEnv(array('libDataTables', 'libStandardCrud', 'libPelaksanaanAgenda', 'libMapAgenda'));
		$data['libcss']         = '';
		$data['pjs']            = jsArray(array('bs4-datatables', 'select2', 'moment2.24', 'daterangepicker', 'lightbox', 'dual-listbox', 'leaflet', 'leaflet-popup-responsive', 'leaflet-marker-cluster'));
		$data['pcss']           = cssArray(array('datatables', 'select2', 'select2-bs5', 'daterangepicker', 'dual-listbox', 'dual-listbox-icon', 'leaflet', 'leaflet-popup-responsive', 'leaflet-marker-cluster', 'leaflet-marker-clusterDefault',));
		//$data['menu'] 		= 'admin/sideMenu';

		$this->theme->dashboard_theme($data);
	}


	// List all your items
	public function index()
	{
		$ulevel = $this->ULEVEL;



		$data['konten'] = 'agendaKonten';
		$data['libcss'] = '';
		$data['headTableAgenda'] = headTableCaleg('data_agenda');
		$this->_theme($data);
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
}

/* End of file Pelaksanaan.php */
/* Location: ./application/modules/program_kerja/controllers/Pelaksanaan.php */
