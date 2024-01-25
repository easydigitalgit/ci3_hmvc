<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reses extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ProgramKerja_model','PKM');

	}

	// List all your items
	public function index( $offset = 0 )
	{

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

/* End of file Reses.php */
/* Location: ./application/modules/program_kerja/controllers/Reses.php */
