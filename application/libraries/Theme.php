<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Theme
{

	public $CI;
	private function appKonfig()
	{
		$CI = &get_instance();
		$CI->load->model('my_model');
		$konfig = $CI->my_model->getAppKonfig();
		if ($konfig->num_rows()) {
			foreach ($konfig->result() as $val) {
				$data['fullLogo'] 	= $val->default_long_menu_logo;
				$data['smallLogo'] 	= $val->default_small_menu_logo;
				$data['judulTab'] 	= $val->judul_tab;
				$data['login_logo'] = $val->login_logo;
			}
		} else {
			$data['fullLogo'] 	= '';
			$data['smallLogo'] 	= '';
			$data['judulTab'] 	= '';
			$data['login_logo'] = '';
		}

		return $data;
	}

	public function dashboard_theme($data)
	{
		$CI = &get_instance();
		$path = base_url() . 'AppDoc/konfig/';

		$konfig = $this->appKonfig();

		$arrLevel = array('1' => 'admin_menu', '2' => 'relawan_menu', '3' => 'caleg_menu', '4' => 'kordapil_menu');
		$ulevel = $CI->session->userdata('ulevel');
		if ($ulevel && isset($arrLevel[$ulevel])) {
			$logo = $this->getLogoCaleg();
			$menu = 'menu/' . $arrLevel[$ulevel];
			$fLogo = $path . 'default_full_logo.png';
			$sLogo = $path . 'default_small_logo.png';
			$data['menu'] = $menu;
			$data['judulTab'] = $konfig['judulTab'];


			$data['full_logo'] 	= isset($logo['full_logo']) ? $path . $logo['full_logo'] : $path . 'default_full_logo.png';
			$data['small_logo'] = isset($logo['small_logo']) ? $path . $logo['small_logo'] : $path . 'default_small_logo.png';

			/*$data['full_logo'] 	= $fLogo; 
				$data['small_logo'] = $sLogo; */


			$CI->load->view('PanelDashboard', $data);
		}
		//$menu = 'menu/admin_menu';		
		else {
		}
	}


	public function getLogoCaleg()
	{
		$CI = &get_instance();
		$ulevel 	= $CI->session->userdata('ulevel');
		$uid 		= $CI->session->userdata('uid');

		if ($ulevel == '1') {
			$ret['small_logo'] = 'default_full_logo.png';
			$ret['full_logo']  = 'default_small_logo.png';
		} else if ($ulevel == '2') {
			$q = $CI->db->select('  a.id , a.akun_id , b.small_logo, b.full_logo FROM data_koord_relawan a LEFT JOIN konfigurasi b ON a.caleg_akun_id = b.id_akun_caleg ', false)->where('a.akun_id', $uid)->get();
			if ($q->num_rows()) {
				$row = $q->row();
				$ret['small_logo'] = $row->small_logo;
				$ret['full_logo'] = $row->full_logo;
			} else {
				$ret = array();
			}
		} else if ($ulevel == '3') {
			$q = $CI->db->get_where('konfigurasi', array('id_akun_caleg' => $uid));
			if ($q->num_rows()) {
				$row = $q->row();
				$ret['small_logo'] = $row->small_logo;
				$ret['full_logo'] = $row->full_logo;
			} else {
				$ret = array();
			}
		} else if ($ulevel == '4') {
			$ret['small_logo'] = 'default_full_logo.png';
			$ret['full_logo']  = 'default_small_logo.png';
		}


		return $ret;
	}

	public function frontTheme($data)
	{
		$CI = &get_instance();


		$CI->load->view('FrontPanel', $data);
	}


	public function mainapp_theme($data = Null)
	{
		$CI = &get_instance();
		//$data['menu']   = 'admin/admin_menu';
		$data['title1'] = 'Main Panel';
		$data['title2'] = 'Sistersi';
		$CI->load->view('mainapp_panel', $data);
		//$CI->output->cache(60);
	}


	public function login_theme($data = Null)
	{

		$CI = &get_instance();
		$konfig = $this->appKonfig();
		$data['login_logo'] = $konfig['login_logo'];
		$data['ptitle'] = $konfig['judulTab'];
		$CI->load->view('PanelLogin', $data);
		//$CI->load->view('loginLTE', $data);

		//$CI->output->cache(60);
	}
}
