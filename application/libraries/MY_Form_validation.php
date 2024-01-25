<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Form_validation extends CI_Form_validation
{
	public $CI;

	public function __construct()
	{
		parent::__construct();
		$this->set_db();
		$this->setDelimiters();

		//$this->set_error_delimiters('<span class="text-danger">',  '</span>');

	}
	public function set_db($dbname = 'default')
	{
		$db_data = $this->CI->load->database($dbname, TRUE);
		return $this->CI->db = $db_data;
	}

	public function setDelimiters($open = '<span class="text-danger">', $close = '</span>')
	{

		return $this->set_error_delimiters($open, $close);
	}

	public function upd_unique($str, $field)
	{
		$CI = &get_instance();

		sscanf($field, '%[^.].%[^.].%[^.].%[^.]', $table, $nfield, $val, $id);
		$CI->form_validation->set_message('upd_unique', '%s sudah digunakan.');
		$q	= $this->CI->db->get_where($table, array($nfield => $val, 'id != ' => $id));
		return ($q->num_rows() > 0)  ? FALSE : TRUE;
	}
	public function edit_unique($str, $field)
	{
		// to use 
		// $this->form_validation->set_rules('email','Email','required|valid_email|edit_unique[users.Email.'.$id.']');


		$CI = &get_instance();
		sscanf($field, '%[^.].%[^.].%[^.]', $table, $field, $id);
		/*return isset($this->CI->db)
            ? ($this->CI->db->limit(1)->get_where($table, array($field => $str, 'id !=' => $id))->num_rows() === 0)
            : FALSE;*/
		$q = $this->CI->db->limit(1)->get_where($table, array($field => $str, 'id !=' => $id))->num_rows();
		log_message('debug', "validation edit_unique: " . $this->CI->db->last_query());
		return ($q > 0)  ? FALSE : TRUE;
	}

	public function unik_tandem($str, $field)
	{
		$CI = &get_instance();
		sscanf($field, '%[^.].%[^.].%[^.]', $nik, $tingkat, $id);
		// need: NIK, Tingkat Pilihan,
		if ($tingkat == '1') {
			$where = array('b.relawan_id_ri !=' => 'NULL');
		} else if ($tingkat == '2') {
			$where = array('b.relawan_id_prop !=' => 'NULL');
		} else if ($tingkat == '3') {
			$where = array('b.relawan_id_kota !=' => 'NULL');
		} else {
			$where = array('1' => '1');
		}

		$q = $this->CI->db->select(' a.nik, a.nama, b.relawan_id_ri, b.relawan_id_prop, b.relawan_id_kota FROM anggota a LEFT JOIN data_pilihan_caleg b ON a.id = b.anggota_id ', false)->where($where)->get()->num_rows();

		log_message('debug', "validation unik_tandem: " . $this->CI->db->last_query());
		return ($q > 0)  ? FALSE : TRUE;
	}

	public function edit_unique2($str, $field)
	{
		// to use
		// 'rules' => 'trim|required|max_length[50]|edit_unique[mytable.mycolumn.columnID.'.$id.']'

		sscanf($field, '%[^.].%[^.].%[^.].%[^.]', $table, $field, $columnIdName, $id);
		return isset($this->CI->db)
			? ($this->CI->db->limit(1)->get_where($table, array($field => $str, $columnIdName . '!=' => $id))->num_rows() === 0)      : FALSE;
	}

	public function is_datetime($date, $format)
	{
		$CI = &get_instance();
		//log_message('debug', 'date var = ' .$date);
		$dt = new DateTime($date);

		$CI->form_validation->set_message('is_datetime', 'format %s tidak sesuai');
		return $dt->format($format) == $date ? TRUE : FALSE;
	}

	public function date_matches($str, $field)
	{
		$CI = &get_instance();
		return isset($this->_field_data[$field], $this->_field_data[$field]['postdata'])
			? (strtotime($str) === strtotime($this->_field_data[$field]['postdata']))
			: FALSE;
	}

	public function date_greater_than($str, $field)
	{
		$CI = &get_instance();
		return isset($this->_field_data[$field], $this->_field_data[$field]['postdata'])
			? (strtotime($str) > strtotime($this->_field_data[$field]['postdata']))
			: FALSE;
	}

	public function date_less_than($str, $field)
	{
		$CI = &get_instance();
		return isset($this->_field_data[$field], $this->_field_data[$field]['postdata'])
			? (strtotime($str) < strtotime($this->_field_data[$field]['postdata']))
			: FALSE;
	}

	public function date_greater_equal($str, $field)
	{
		$CI = &get_instance();
		return isset($this->_field_data[$field], $this->_field_data[$field]['postdata'])
			? (strtotime($str) >= strtotime($this->_field_data[$field]['postdata']))
			: FALSE;
	}

	public function date_less_equal($str, $field)
	{
		$CI = &get_instance();
		return isset($this->_field_data[$field], $this->_field_data[$field]['postdata'])
			? (strtotime($str) <= strtotime($this->_field_data[$field]['postdata']))
			: FALSE;
	}

	public function between_numeric($str, $min, $max)
	{
		$CI = &get_instance();


		$CI->form_validation->set_message('between_numeric', 'nilai %s diluar batas');
		return is_numeric($str) ? ($str >= $min && $str <= $max) : FALSE;
	}

	/**
	 * Alpha-numeric, underscores, dashes, slash, backslash
	 *
	 * @param	string
	 * @return	bool
	 */
	public function alpha_slash($str)
	{
		return (bool) preg_match('#^[a-z0-9_\-. \\\ () \/]+$#i', $str);
	}

	/**
	 * Alpha-numeric with underscores and dashes
	 *
	 * @param	string
	 * @return	bool
	 */
	public function alpha_dashtik($str)
	{
		return (bool) preg_match('/^[a-z0-9_-. ]+$/i', $str);
	}

	public function alphanumericnospace($str)
	{
		return (bool) preg_match('/^[a-zA-Z0-9]+$/i', $str);
	}
	/* 
	
	public function cek_update_unik($table, $field, $value, $id){
		//$this->db = $this->load->database($db, TRUE);
		$q	= $this->db->get_where($table, array($field => $value, 'id != '=>$id));
		$ret = $q->num_rows()  ? FALSE:TRUE;

		return $ret;
	}
	*/

	/*
	function unique($str, $field)
	{
	
		$CI =& get_instance();
		list($table, $column) = explode('.', $field, 2);

		$CI->form_validation->set_message('unique', 'The %s that you requested is unavailable.');

		$query = $CI->db->query("SELECT COUNT(*) AS dupe FROM $table WHERE $column = '$str'");
		$row = $query->row();
		return ($row->dupe > 0) ? FALSE : TRUE;
	}	

	$this->form_validation->set_rules('username','User Name','required|min_length[5]|unique[users.username]');
	$this->form_validation->set_rules('emailaddress','Email Address','required|valid_email|unique[users.email]');
	*/
}

/* End of file MY_Form_validation.php */
/* Location: ./application/libraries/MY_Form_validation.php */
