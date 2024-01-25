<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function index()
	{
		
		$data['konten'] =  'user/konten';
		$data['libjs']  = '';//jsbyEnv('libLogin');
		$data['libcss'] = '';
		$data['menu'] = 'user/sideMenu';

		$this->theme->dashboard_theme($data);
	}

}

/* End of file Dashboard.php */
/* Location: ./application/modules/user/controllers/Dashboard.php */