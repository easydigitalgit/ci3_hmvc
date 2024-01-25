<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Front_model extends MY_Model {
public function __construct()
{
	parent::__construct();
	//Do your magic here
}



 public function dataPendaftaranRules($mode='add'){
    $id = $this->input->post('id');
   
   	 $rules =  [
     				[
                        'field'	=> 'tingkat_id',
                        'label'	=> 'Tingkat',
                        'rules' => 'trim|required',
                        'errors'=> array('required'=>'%s wajib diisi')

                    ],
                    [
                        'field' => 'tahun_ajaran_id',
                        'label' => 'Tahun Ajaran',
                        'rules' => 'trim|required',
                        'errors'=> array('required'=>'%s wajib diisi')

                    ],
                   
                    [
                        'field'	=> 'jenjang_kelas_id',
                        'label'	=> 'Jenjang Kelas',
                        'rules' => 'trim|required',
                        'errors'=> array('required'=>'%s wajib diisi') 
                    ],
                    [
                        'field'	=> 'jenis_pendaftaran_id',
                        'label'	=> 'Jenis Pendaftaran',
                        'rules' => 'trim|required',
                        'errors'=> array('required'=>'%s wajib diisi')

                    ],
                    [
                        'field' => 'riwayat_sekolah',
                        'label' => 'Riwayat Sekolah',
                        'rules' => 'trim|required',
                        'errors'=> array('required'=>'%s wajib diisi')

                    ],
                    [
                        'field'	=> 'nama_lengkap',
                        'label'	=> 'Nama Lengkap',
                        'rules' => 'trim|required',
                        'errors'=> array('required'=>'%s wajib diisi')

                    ],
                      [
                        'field'	=> 'dob',
                        'label'	=> 'Tanggal Lahir',
                        'rules' =>  'trim|required',
                        'errors'=>  array('required'=>'%s wajib diisi')

                    ],
                     [
                        'field' => 'nama_ortu',
                        'label' => 'Nama Orangtua',
                        'rules' =>  'trim|required',
                        'errors'=>  array('required'=>'%s wajib diisi')

                    ],
                    [
                        'field' => 'no_wa',
                        'label' => 'Nomor Whatsapp',
                        'rules' =>  'trim|required',
                        'errors'=>  array('required'=>'%s wajib diisi')

                    ],
                     [
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' =>  'trim|required|valid_email',
                        'errors'=>  array('required'=>'%s wajib diisi')

                    ],
                    [
                        'field' => 'alamat_rumah',
                        'label' => 'Alamat Rumah',
                        'rules' =>  'trim|required',
                        'errors'=>  array('required'=>'%s wajib diisi')

                    ],
                     [
                        'field' => 'sumber_informasi',
                        'label' => 'Sumber Informasi',
                        'rules' => 'trim|required',
                        'errors'=>  array('required'=>'%s wajib diisi')

                    ],
                   
                    
                    [
                        'field' => 'captcha',
                        'label' => 'Captcha',
                        'rules' => 'trim|required',
                        'errors'=>  array('required'=>'%s wajib diisi')

                    ],
                   
            ];
       return $rules;
   }
	

}

/* End of file Fron_model.php */
/* Location: ./application/modules/front/models/Fron_model.php */