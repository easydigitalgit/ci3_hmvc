<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SelectOption
{
	protected $ci;

	public function __construct()
	{
		$this->CI = &get_instance();
		$this->CI->load->model('my_model');
		$this->my_model = &$this->CI->my_model;
	}



	public function selectWATemplate()
	{
		$q = $this->my_model->get_all('wa_template');
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->id . '">[' . $val->kode . ']' . $val->tema . '</option>';
			}
		}
		return $ret;
	}

	public function selectJenisJabatan()
	{

		$q = $this->my_model->getJenisJabatan();
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->id . '">' . $val->kode_jabatan . '</option>';
			}
		}
		return $ret;
	}

	public function selectPropinsi()
	{

		$q = $this->my_model->getPropinsi();
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->kode . '">' . $val->nama . '</option>';
			}
		}
		return $ret;
		//echo $ret;
	}

	public function selectKabupaten($propID = null)
	{

		$q = $this->my_model->getKabupaten($propID);
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->kode . '">' . $val->nama . '</option>';
			}
		}
		return $ret;
	}

	public function selectKecamatan($kabID = null)
	{

		$q = $this->my_model->getKecamatan($kabID);
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->kode . '">' . $val->nama . '</option>';
			}
		}
		return $ret;
	}

	public function selectDesa($kecID = null)
	{

		$q = $this->my_model->getDesa($kecID);
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->kode . '">' . $val->nama . '</option>';
			}
		}
		return $ret;
	}

	public function selectPekerjaan()
	{

		$q = $this->my_model->getListPekerjaan();
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->id . '">' . $val->nama_pekerjaan . '</option>';
			}
		}
		return $ret;
	}

	public function selectHubunganKeluarga()
	{

		$q = $this->my_model->getHubunganKeluarga();
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->id . '">' . $val->nama_hubungan . '</option>';
			}
		}
		return $ret;
	}

	public function selectJenjangPendidikan()
	{

		$q = $this->my_model->getJenjangPendidikan();
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->id . '">[' . $val->kode_jenjang . ']' . $val->nama_jenjang . '</option>';
			}
		}
		return $ret;
	}



	public function getListJenisKeanggotaan()
	{

		$q = $this->my_model->getListKeanggotaan();
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->id . '">' . $val->kode_jenis_keanggotaan . '</option>';
			}
		}
		return $ret;
	}

	public function selectStruktural()
	{

		$q = $this->my_model->getListStruktural();
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->id . '">' . $val->nama_struktur . '</option>';
			}
		}
		return $ret;
	}

	public function selectGrupId()
	{

		$q = $this->my_model->getListUserGrup();
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->id . '">' . $val->kode_grup . '</option>';
			}
		}
		return $ret;
	}

	public function selectUserLevel()
	{

		$q = $this->my_model->getListUserLevel();
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $val) {
				$ret .= '<option value="' . $val->id . '">' . $val->user_level_name . '</option>';
			}
		}
		return $ret;
	}

	public function selectUserLevelByULEVEL($ulevel)
	{
		/* // <option value="1">ADMIN</option>
		// <option value="2">KOORD. RELAWAN</option>
		// <option value="3">CALEG</option>
		// <option value="4">KORDAPIL</option> */

		$ret = '<option value="">--pilih--</option>';
		if ($ulevel == '1') {
			$ret = '
						<option value="1">ADMIN</option>
                        <option value="4">KORDAPIL</option>
					';
		} else if ($ulevel == '3') {
			$ret = '
                    <option value="2">Admin Entry</option>
                        
					';
		} else if ($ulevel == '4') {
			$ret = '
					<option value="3">CALEG</option>
                        
					';
		}


		return $ret;
	}

	public function selectJenjangKelas($unit_id)
	{
		$table = 'jenjang_kelas';
		$whereArray = array('unit_sekolah_id' => $unit_id);

		$q = $this->my_model->getWhereArray($table, $whereArray);
		$ret = '<option value="">--pilih--</option>';
		if ($q->num_rows()) {

			foreach ($q->result() as $v) {
				$ret .= '<option value="' . $v->id . '">' . $v->nama_jenjang_kelas . '</option>';
			}
		}
		return $ret;
	}

	public function selectStd($table, $val, $text)
	{
		$q = $this->my_model->get_all($table);
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $v) {
				$ret .= '<option value="' . $v->$val . '">' . $v->$text . '</option>';
			}
		}
		return $ret;
	}

	public function selectAllKoordDapil()
	{
		$q = $this->my_model->getWhereArray('user_akun', array('level_user_id' => '4'));
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q->result() as $v) {
				$ret .= '<option value="' . $v->id . '">[' . $v->username . '] ' . $v->nama . '</option>';
			}
		}
		return $ret;
	}
	public function selectKoordRelawanID()
	{
		$q = $this->my_model->getWhereArray('user_akun', array('level_user_id' => '2'));
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q->result() as $v) {
				$ret .= '<option value="' . $v->id . '">[' . $v->username . '] ' . $v->nama . '</option>';
			}
		}
		return $ret;
	}

	public function selectKoordRelawanByCaleg($uid)
	{
		$q = $this->my_model->getKoordRelawanByCalegID($uid);
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q->result() as $v) {
				$ret .= '<option value="' . $v->akun_id . '">[' . $v->nama_koord . '] </option>';
			}
		}
		return $ret;
	}

	public function selectKoordRelawanByKordapil($uid)
	{
		$q = $this->my_model->getKoordRelawanByKordapilID($uid);
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q->result() as $v) {
				$ret .= '<option value="' . $v->akun_id . '">[' . $v->nama_koord . '] </option>';
			}
		}
		return $ret;
	}

	public function selectRelawanByKoordID($koordID)
	{
		$q = $this->my_model->getWhereArray('data_relawan', array('koord_akun_id' => $koordID));
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q->result() as $v) {
				$ret .= '<option value="' . $v->id . '">[' . $v->nik . '] ' . $v->nama_relawan . '</option>';
			}
		}
		return $ret;
	}

	public function selectRelawanByCalegID($calegID)
	{
		$q = $this->my_model->getRelawanByCalegID($calegID);
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q->result() as $v) {
				$ret .= '<option value="' . $v->id . '">[' . $v->nama_caleg . '] ' . $v->nama_relawan . '</option>';
			}
		}
		return $ret;
	}

	public function selectRelawanByKordapilID($kordapilID)
	{
		$q = $this->my_model->getRelawanByKordapil($kordapilID);
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q->result() as $v) {
				$ret .= '<option value="' . $v->id . '">[' . $v->nama_caleg . '] ' . $v->nama_relawan . '</option>';
			}
		}
		return $ret;
	}

	public function selectJenisEvent()
	{
		$table = 'data_event';
		$q = $this->my_model->get_all($table);
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $v) {
				$ret .= '<option value="' . $v->id . '">[' . $v->kode_jenis_event . '] ' . $v->nama_jenis_event . '</option>';
			}
		}
		return $ret;
	}

	public function selectJenisAgenda()
	{
		$table = 'jenis_agenda';
		$q = $this->my_model->get_all($table);
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q as $v) {
				$ret .= '<option value="' . $v->id . '">[' . $v->kode_jenis_agenda . '] ' . $v->nama_jenis_agenda . '</option>';
			}
		}
		return $ret;
	}

	/*public function selectRelawanByCalegID($calegID){
		$ret = '<option value="">--pilih--</option>';
		if( $calegID ){
			$q = $this->my_model->getRelawanByCalegID($calegID);
			
			if($q->num_rows()){
				
				foreach ($q->result() as $v) {
					$ret .= '<option value="'.$v->id.'">['.$v->nama_caleg.'] '.$v->nama_relawan.'</option>';
				}
			}
		
		}else{

		}
		return $ret;
	}*/

	public function selectRelawanByKordapil($kordapilID)
	{
		$ret = '<option value="">--pilih--</option>';
		if ($kordapilID) {
			$q = $this->my_model->getRelawanByKordapil($kordapilID);

			if ($q->num_rows()) {

				foreach ($q->result() as $v) {
					$ret .= '<option value="' . $v->id . '">[' . $v->nama_caleg . '] ' . $v->nama_relawan . '</option>';
				}
			}
		}
		return $ret;
	}

	public function selectAllRelawan()
	{
		$ret = '<option value="">--pilih--</option>';
		$q = $this->my_model->getAllRelawan();

		if ($q->num_rows()) {

			foreach ($q->result() as $v) {
				$ret .= '<option value="' . $v->id . '">[' . $v->nama_caleg . '] ' . $v->nama_relawan . '</option>';
			}
			return $ret;
		}
	}
	public function selectAllDapil()
	{

		$q = $this->my_model->getAllDapil();
		$ret = '<option value="">--pilih--</option>';
		if ($q->num_rows()) {

			foreach ($q->result() as $v) {
				$ret .= '<option value="' . $v->id . '">[' . $v->nama_tingkat . '] ' . $v->nama_dapil . '</option>';
			}
		}
		return $ret;
	}

	public function selectDapilByCaleg($calegAkunID)
	{
		$q = $this->my_model->getDapilByCaleg($calegAkunID);
		$ret = '<option value="">--pilih--</option>';
		if ($q->num_rows()) {

			foreach ($q->result() as $v) {
				$ret .= '<option value="' . $v->id . '">[' . $v->nama_tingkat . '] ' . $v->nama_dapil . '</option>';
			}
		}
		return $ret;
	}

	public function selectDapilByKordapil($kordapilAkunID)
	{
		$q = $this->my_model->getDapilByKordapil($kordapilAkunID);
		$ret = '<option value="">--pilih--</option>';
		if ($q->num_rows()) {

			foreach ($q->result() as $v) {
				$ret .= '<option value="' . $v->dapil_id . '">[' . $v->nama_tingkat . '] ' . $v->nama_dapil . '</option>';
			}
		}
		return $ret;
	}

	public function selectDataDapil($idTingkat)
	{

		$q = $this->my_model->getDataDapilByTingkat($idTingkat);
		$ret = '<option value="">--pilih--</option>';
		if ($q->num_rows()) {

			foreach ($q->result() as $v) {
				$ret .= '<option value="' . $v->id . '">[' . $v->nama_tingkat . '] ' . $v->nama_dapil . '</option>';
			}
		}
		return $ret;
	}

	public function selectCaleg()
	{
		$q = $this->my_model->getWhereArray('user_akun', array('level_user_id' => '3'));
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q->result() as $v) {
				$ret .= '<option value="' . $v->id . '">[' . $v->nama . '] </option>';
			}
		}
		return $ret;
	}
	public function selectCalegByKordapil($kordapilAkunID)
	{

		$q = $this->my_model->getCalegByKordapil($kordapilAkunID);
		$ret = '<option value="">--pilih--</option>';
		if ($q) {

			foreach ($q->result() as $v) {
				$ret .= '<option value="' . $v->id_akun_caleg . '">[' . $v->nama . '] </option>';
			}
		}
		return $ret;
	}

	public function selectCalegAkun()
	{
		$q = $this->my_model->getCalegAkunData();
		$ret = '<option value="">--pilih--</option>';

		if ($q->num_rows()) {

			foreach ($q->result() as $v) {
				$ret .= '<option value="' . $v->id . '">[' . $v->nama . '] </option>';
			}
		}
		return $ret;
	}

	public function selectCountry($table)
	{
	}

	public function selectWhere($table, $where, $val, $text)
	{
	}
}

/* End of file selectOption.php */
/* Location: ./application/libraries/selectOption.php */
