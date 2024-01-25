<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pendaftaran_model extends MY_Model {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
	}

	public function getDaftarAwalByID($id){
		$query = $this->db->select(" a.*, b.nama_thn_ajaran, c.kode as kode_unit, d.kode_jenjang_kelas, e.nama as jenis_pendaftar, f.tanggal_tes FROM pendaftaran a LEFT join tahun_ajaran b ON a.tahun_ajaran_id = b.id LEFT JOIN unit_sekolah c on a.tingkat_id = c.id LEFT JOIN jenjang_kelas d on a.jenjang_kelas_id = d.id LEFT JOIN jenis_pendaftaran e on a.jenis_pendaftaran_id = e.id LEFT JOIN jadwal_seleksi_psb f ON a.id = f.pendaftaran_id ", false)
			->where('a.id',$id)
			->get();

            if($query->num_rows()){
                foreach($query->result() as $val){
                    $data['alamat_rumah'] = $val->alamat_rumah;
                    $data['asal_sekolah'] = $val->asal_sekolah;
                    $data['dob']          = date('d-m-Y',strtotime($val->dob));
                    $data['email']        = $val->email;
                    $data['gender']       = $val->gender;
                    $data['id']           = $val->id;
                    $data['jenis_pendaftar']        = $val->jenis_pendaftar;
                    $data['jenis_pendaftaran_id']   = $val->jenis_pendaftaran_id;
                    $data['jenjang_kelas_id']       = $val->jenjang_kelas_id;
                    $data['kode_jenjang_kelas']     = $val->kode_jenjang_kelas;
                    $data['kode_unit']              = $val->kode_unit;
                    $data['kota_id']                = $val->kota_id;
                    $data['nama_lengkap']           = $val->nama_lengkap;
                    $data['nama_ortu']              = $val->nama_ortu   ;
                    $data['nama_thn_ajaran']        = $val->nama_thn_ajaran;
                    $data['negara_id']              = $val->negara_id;
                    $data['no_wa']                  = $val->no_wa;
                    $data['noreg']                  = $val->noreg ;
                    $data['noted']                  = $val->noted; 
                    $data['program']                = $val->program;
                    $data['propinsi_id']            = $val->propinsi_id;
                    $data['riwayat_sekolah']        = $val->riwayat_sekolah;
                    $data['scan_akte']              = $val->scan_akte;                
                    $data['scan_payment']           = $val->scan_payment;
                    $data['status_payment']         = $val->status_payment;
                    $data['status_verifikasi']      = $val->status_verifikasi;
                    $data['sumber_informasi']       = $val->sumber_informasi;
                    $data['sumber_lain']            = $val->sumber_lain;
                    $data['tahun_ajaran_id']        = $val->tahun_ajaran_id;
                    $data['tanggal_tes']            = $val->tanggal_tes;
                    $data['tingkat_id']             = $val->tingkat_id;
                    $data['trash']                  = $val->trash;
                    $data['unit_asal_id']           = $val->unit_asal_id;
                    $data['verifiedby']             = $val->verifiedby;
                   
                   
                }
            }
            else{
                $data[] = 'no-result';
            }

			return $query;
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
                        'rules' => 'trim|required',
                        'errors'=>  array('required'=>'%s wajib diisi')

                    ],
                   
                   
            ];
       return $rules;
   }

   public function absensiTesRules($mode='add'){
        $rules =  [
                    [
                        'field' => 'pendaftaran_id',
                        'label' => 'No. Pendaftaran',
                        'rules' => 'trim|required',
                        'errors'=> array('required'=>'%s wajib diisi')

                    ],
                    [

                        'field' => 'tanggal_tes',
                        'label' => 'Tanggal Tes',
                        'rules' => 'trim|required',
                        'errors'=> array('required'=>'%s wajib diisi')
                    ],
                    [

                        'field' => 'catatan',
                        'label' => 'Catatan',
                        'rules' => 'trim|required',
                        'errors'=> array('required'=>'%s wajib diisi')
                    ],


                ];

        return $rules;

   }

   public function deleteNilaiTes($pendaftarID){
         $this->db->where('pendaftaran_id',$pendaftarID)->delete('nilai_tes');
        return $this->db->affected_rows();
   }

   public function getDaftarSubtes($idJadwalTes , $idKategoriTes){
    $query = " SELECT * from sub_tes s where s.jenis_tes_id = ( select d.id FROM jadwal_seleksi_psb a LEFT JOIN pendaftaran b ON a.pendaftaran_id = b.id LEFT JOIN paket_tes c on (b.jenjang_kelas_id = c.jenjang_kelas_id AND b.tahun_ajaran_id = c.tahun_ajaran_id) LEFT JOIN jenis_tes_seleksi d on c.jenis_tes_seleksi_id = d.id WHERE (a.id = " .$idJadwalTes. " AND d.kategori_tes_id = " .$idKategoriTes. ") )";

        $q = $this->db->query($query);
        return $q->result();
   }

}

/* End of file Pendaftaran_model.php */
/* Location: ./application/modules/pendaftaran/models/Pendaftaran_model.php */