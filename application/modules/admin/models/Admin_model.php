
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_model extends MY_Model
{
    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    public function dataAkunRules($mode = 'add')
    {
        $id = $this->input->post('id');
        $email = $mode == 'add' ? 'trim|required|is_unique[user_akun.username]' : 'trim|required|edit_unique[user_akun.username.' . $id . ']';

        $rules =  [


            [
                'field' => 'nama',
                'label' => 'Nama',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi'),
            ],
            [
                'field' => 'password',
                'label' => 'Password',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi'),
            ],
            [
                'field' => 'status_aktif',
                'label' => 'Status Aktif',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib dipilih'),
            ],
            [
                'field' => 'level_user_id',
                'label' => 'Level',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib dipilih', 'edit_unique' => 'kode sudah digunakan'),
            ],
            [
                'field' => 'username',
                'label' => 'Username',
                'rules' =>  $email,
                'errors' => array('required' => '%s wajib diisi', 'is_unique' => '%s sudah digunakan', 'edit_unique' => '%s sudah digunakan'),

            ],

        ];
        return $rules;
    }

    public function addDataKonfigurasiRules()
    {
        $rules =  [


            [
                'field' => 'judul_tab',
                'label' => 'judul_tab',
                'rules' => 'trim',
                'errors' => array('required' => '%s wajib diisi'),
            ],


        ];
        return $rules;
    }
    public function dataPendaftaranRules($mode = 'add')
    {
        $id = $this->input->post('id');
        //$nik = $mode == 'add' ? 'trim|required|numeric|exact_length[16]|is_unique[anggota.nik]' : 'trim|required|numeric|exact_length[16]|edit_unique[anggota.nik.' . $id . ']';
        $nik = 'trim|required';
        //  $noWA = $mode == 'add' ? 'trim|required|numeric|is_unique[anggota.no_wa]' : 'trim|required|numeric|edit_unique[anggota.no_wa.' . $id . ']';
        $editID = $mode == 'edit' ? 'trim|required|numeric' : 'trim';
        $noWA = $mode == 'add' ? 'trim|required|numeric' : 'trim|required|numeric';


        $rules =  [
            [
                'field' => 'id',
                'label' => 'ID Anggota',
                'rules' => $editID,
                'errors' => array('required' => '%s wajib dipilih', 'numeric' => '%s tidak valid'),
            ],
            [
                'field' => 'relawan_id',
                'label' => 'ID Relawan',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib dipilih'),
            ],
            [
                'field' => 'nik',
                'label' => 'NIK',
                'rules' => $nik,
                'errors' => array('required' => '%s wajib diisi', 'is_unique' => '%s sudah digunakan', 'edit_unique' => '%s sudah digunakan', 'numeric' => '%s Harus berupa Angka', 'exact_length' => 'No. KTP harus 16 Digit'),
            ],
            [
                'field' => 'nama',
                'label' => 'Nama',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi'),
            ],
            [
                'field' => 'no_wa',
                'label' => 'No. Whatsapp',
                'rules' => $noWA,
                'errors' => array('required' => '%s wajib diisi', 'is_unique' => '%s sudah digunakan', 'edit_unique' => '%s sudah digunakan', 'numeric' => '%s Harus berupa Angka'),
            ]




        ];
        return $rules;
    }

    public function dataPendaftaranRelawanRules($mode = 'add')
    {
        $id = $this->input->post('id');
        $nik = $mode == 'add' ? 'trim|required|numeric|exact_length[16]|is_unique[data_relawan.nik]' : 'trim|required|numeric|exact_length[16]|edit_unique[data_relawan.nik.' . $id . ']';

        $rules =  [
            [
                'field' => 'nik',
                'label' => 'NIK',
                'rules' => $nik,
                'errors' => array('required' => '%s wajib diisi', 'is_unique' => '%s sudah digunakan', 'edit_unique' => '%s sudah digunakan', 'numeric' => '%s Harus berupa Angka'),
            ],

            [
                'field' => 'no_wa',
                'label' => 'No. Whatsapp',
                'rules' => 'trim|numeric|required',
                'errors' => array('required' => '%s wajib diisi', 'numeric' => '%s Harus berupa Angka'),
            ],




        ];
        return $rules;
    }
    public function dataPendaftaranKoordRelawanRules($mode = 'add')
    {
        $id = $this->input->post('id');
        $nik = $mode == 'add' ? 'trim|required|numeric|exact_length[16]|is_unique[data_koord_relawan.nik]' : 'trim|required|numeric|exact_length[16]|edit_unique[data_koord_relawan.nik.' . $id . ']';

        $rules =  [
            [
                'field' => 'nik',
                'label' => 'NIK',
                'rules' => $nik,
                'errors' => array('required' => '%s wajib diisi', 'is_unique' => '%s sudah digunakan', 'edit_unique' => '%s sudah digunakan', 'numeric' => '%s Harus berupa Angka'),
            ],

            [
                'field' => 'no_wa',
                'label' => 'No. Whatsapp',
                'rules' => 'trim|numeric|required',
                'errors' => array('required' => '%s wajib diisi', 'numeric' => '%s Harus berupa Angka'),
            ],




        ];
        return $rules;
    }

    public function dataKordapilRules($mode = 'add')
    {
        $id = $this->input->post('id');
        $nik = $mode == 'add' ? 'trim|required|numeric|exact_length[16]|is_unique[data_kordapil.nik]' : 'trim|required|numeric|exact_length[16]|edit_unique[data_kordapil.nik.' . $id . ']';

        $rules =  [
            [
                'field' => 'nik',
                'label' => 'NIK',
                'rules' => $nik,
                'errors' => array('required' => '%s wajib diisi', 'is_unique' => '%s sudah digunakan', 'edit_unique' => '%s sudah digunakan', 'numeric' => '%s Harus berupa Angka'),
            ],

            [
                'field' => 'no_wa',
                'label' => 'No. Whatsapp',
                'rules' => 'trim|numeric|required',
                'errors' => array('required' => '%s wajib diisi', 'numeric' => '%s Harus berupa Angka'),
            ],
            [
                'field' => 'dapil_id',
                'label' => 'DAPIL',
                'rules' => 'trim|numeric|required',
                'errors' => array('required' => '%s wajib diisi', 'numeric' => '%s Harus berupa Angka'),
            ],




        ];
        return $rules;
    }

    public function dataKonfigurasiRules($mode = 'add')
    {
        $id = $this->input->post('id');
        $nik = $mode == 'add' ? 'trim|required|numeric|exact_length[16]|is_unique[data_koord_relawan.nik]' : 'trim|required|numeric|exact_length[16]|edit_unique[data_koord_relawan.nik.' . $id . ']';

        $idAkunCaleg = (int) $id ? 'trim|required|numeric|edit_unique[konfigurasi.id_akun_caleg.' . $id . ']' : 'trim|required|numeric|is_unique[konfigurasi.id_akun_caleg]';

        $rules =  [
            [
                'field'     => 'kordapil_akun_id',
                'label'     => 'Koordinator Dapil',
                'rules'     => 'trim|required',
                'errors'    => array('required' => '%s wajib dipilih', 'is_unique' => 'ID Caleg sudah digunakan', 'edit_unique' => 'ID Caleg sudah digunakan'),
            ],
            [
                'field'     => 'id_akun_caleg',
                'label'     => 'Nama Caleg',
                'rules'     =>  $idAkunCaleg,
                'errors'    => array('required' => '%s wajib diisi', 'is_unique' => 'ID Caleg sudah digunakan', 'edit_unique' => 'ID Caleg sudah digunakan'),
            ],

            [
                'field'     => 'tingkat_pemilihan_id',
                'label'     => 'Tingkat Pemilihan',
                'rules'     => 'trim|numeric',
                'errors'    => array('required' => '%s wajib diisi', 'numeric' => '%s Harus berupa Angka'),
            ],

        ];
        return $rules;
    }

    public function dataDapilRules($mode)
    {
        $id = $this->input->post('id');
        $nik = $mode == 'add' ? 'trim|required|numeric|exact_length[16]|is_unique[data_koord_relawan.nik]' : 'trim|required|numeric|exact_length[16]|edit_unique[data_koord_relawan.nik.' . $id . ']';

        $rules =  [

            [
                'field' => 'nama_dapil',
                'label' => 'Nama Dapil',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi'),
            ],

            [
                'field' => 'tingkat_pemilihan_id',
                'label' => 'Tingkat Pemilihan',
                'rules' => 'trim|numeric',
                'errors' => array('required' => '%s wajib diisi', 'numeric' => '%s Harus berupa Angka'),
            ],




        ];
        return $rules;
    }


    public function transferAnggotaRules($mode = 'add')
    {
        $id = $this->input->post('id');


        $rules =  [

            [
                'field' => 'from_koord',
                'label' => 'Koord. Asal',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib dipilih'),
            ],

            [
                'field' => 'to_koord',
                'label' => 'Koord. Tujuan',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib dipilih', 'numeric' => '%s Harus berupa Angka'),
            ],
            [
                'field' => 'anggota_id',
                'label' => 'Daftar Sahabat',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib dipilih', 'numeric' => '%s Harus berupa Angka'),
            ],




        ];
        return $rules;
    }


    public function waTemplateRules()
    {

        $rules =  [


            [
                'field' => 'kode',
                'label' => 'Kode Template',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi',),
            ],
            [
                'field' => 'tema',
                'label' => 'tema',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi'),
            ],
            [
                'field' => 'teks_pesan',
                'label' => 'Isi Pesan',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi'),
            ],
            [
                'field' => 'status',
                'label' => 'Status Template',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib dipilih'),
            ]


        ];
        return $rules;
    }

    public function dataPendaftaranWaCenter($mode)
    {
        $id = $this->input->post('id');
        $noWA = $mode == 'add' ? 'trim|required|numeric|is_unique[wa_center.no_wa]' : 'trim|required|numeric|edit_unique[wa_center.no_wa.' . $id . ']';

        $rules =  [
            [
                'field' => 'no_wa',
                'label' => 'No. Whatsapp',
                'rules' => $noWA,
                'errors' => array('required' => '%s wajib diisi', 'is_unique' => '%s sudah digunakan', 'edit_unique' => '%s sudah digunakan', 'numeric' => '%s Harus berupa Angka'),
            ],

            [
                'field' => 'apikey',
                'label' => 'API Sender',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi', 'numeric' => '%s Harus berupa Angka'),
            ],



        ];
        return $rules;
    }

    /*public function getDataDapil($id){
        $q = $this->db->get_where('data_dapil', array('id'=>$id));
        return $q;
    }*/

    public function getDataCalegByID($id)
    {
        $q = $this->db->query(" SELECT a.id, a.id_akun_caleg, a.kordapil_akun_id, a.target_anggota, a.nama_caleg,a.id_partai,a.dapil_id, a.parent_caleg_id, a.nomor_urut, a.wa_center_id, a.wa_template, a.template_ultah, a.ultah_enable, a.small_logo, a.full_logo, c.nama_dapil, c.tingkat_pemilihan_id, c.jumlah_tps, c.jumlah_dpt, b.nama_partai, d.no_wa, e.nama_tingkat FROM konfigurasi a LEFT JOIN partai b on a.id_partai = b.id LEFT JOIN data_dapil c on a.dapil_id = c.id LEFT JOIN wa_center d ON a.wa_center_id = d.id LEFT JOIN tingkat_pemilihan e ON c.tingkat_pemilihan_id = e.id WHERE a.id = " . $id, false);
        return $q;
    }
    public function getKordapilByID($id)
    {
        $query = ' a.*, d.nama, b.nama_dapil, b.tingkat_pemilihan_id, c.nama_tingkat FROM data_kordapil a LEFT JOIN data_dapil b ON b.id = a.dapil_id LEFT JOIN tingkat_pemilihan c ON b.tingkat_pemilihan_id = c.id LEFT JOIN user_akun d ON a.kordapil_akun_id = d.id ';
        $q = $this->db->select($query, false)->where('a.id', $id)->get();
        return $q;
    }
    public function getDetailDapilByDapilID($id)
    {
        //$q = $this->db->get_where('detail_dapil', array('data_dapil_id'=>$id));
        $q = $this->db->select(' a.id, a.data_dapil_id, a.prop_kode, a.kab_kode, a.kec_kode, b.nama as prop_nama, c.nama as kab_nama, d.nama as kec_nama FROM detail_dapil a LEFT JOIN propinsi b ON a.prop_kode = b.kode LEFT JOIN kabupaten c ON a.kab_kode = c.kode LEFT JOIN kecamatan d ON a.kec_kode = d.kode ', false)->where('data_dapil_id', $id)->get();
        return $q;
    }

    public function getDataDapilByID($id)
    {
        $q = $this->db->get_where('data_dapil', array('id' => $id));
        return $q;
    }

    public function getProfilByAkunID($id)
    {
        $q = $this->db->get_where('profil_driver', array('akun_id' => $id))->row();
        return $q;
    }

    public function getDataWaSenderByID($id)
    {
        $q = $this->db->get_where('wa_center', array('id' => $id));
        return $q;
    }

    public function jumlahByJenisLayanan()
    {
        $q = $this->db->query("SELECT COUNT(*) AS jumlah, jenis_layanan FROM form_layanan GROUP BY jenis_layanan ")->result();
        $d = array();
        $jenisLayanan = array('1' => 'Jenazah', '2' => 'Pasien', '3' => 'Lainnya');
        if ($q) {

            foreach ($q as  $value) {
                $d['data'][$jenisLayanan[$value->jenis_layanan]][] = $value->jumlah;
            }
        }
        return $d;
    }

    public function jumlahDaftarAwalValid()
    {
        $q = $this->db->get_where('pendaftaran', array('status_verifikasi' => '1'));
        return $q->num_rows();
    }

    public function jumlahAnggotaByGender($ulevel, $uid)
    {
        if ($ulevel == '1') {
            // level superadmin
            $ret['pria']    = $this->db->get_where('anggota', array('gender' => 'pria'))->num_rows();
            $ret['wanita']  = $this->db->get_where('anggota', array('gender' => 'wanita'))->num_rows();
        } else if ($ulevel == '2') {
            //level koord relawan
            // cari dulu tingkat pemilihan si koordRelawan

            $cekTingkat = $this->getTingkatPemilihanByKoordRelawanID($uid);
            if ($cekTingkat->num_rows()) {
                $cek = $cekTingkat->row();
                $tingkatPemilihan = $cek->tingkat_pemilihan_id;
                if ($tingkatPemilihan == 1) {
                    $query = "   SUM(CASE WHEN b.gender = 'pria' THEN 1 ELSE 0 END) as male,
                    SUM(CASE WHEN b.gender = 'wanita' THEN 1 ELSE 0 END) as female,
                    COUNT(*) as total FROM data_pilihan_caleg a 
                    LEFT JOIN anggota b ON a.anggota_id = b.id
                    LEFT JOIN data_relawan c ON a.relawan_id_ri = c.id
                    LEFT JOIN data_koord_relawan d ON c.koord_akun_id = d.akun_id ";
                } else if ($tingkatPemilihan == 2) {
                    $query = "   SUM(CASE WHEN b.gender = 'pria' THEN 1 ELSE 0 END) as male,
                    SUM(CASE WHEN b.gender = 'wanita' THEN 1 ELSE 0 END) as female,
                    COUNT(*) as total FROM data_pilihan_caleg a 
                    LEFT JOIN anggota b ON a.anggota_id = b.id
                    LEFT JOIN data_relawan c ON a.relawan_id_prop = c.id
                    LEFT JOIN data_koord_relawan d ON c.koord_akun_id = d.akun_id ";
                } else if ($tingkatPemilihan == 3) {
                    $query = " SELCT  SUM(CASE WHEN b.gender = 'pria' THEN 1 ELSE 0 END) as male,
                    SUM(CASE WHEN b.gender = 'wanita' THEN 1 ELSE 0 END) as female,
                    COUNT(*) as total FROM data_pilihan_caleg a 
                    LEFT JOIN anggota b ON a.anggota_id = b.id
                    LEFT JOIN data_relawan c ON a.relawan_id_kota = c.id
                    LEFT JOIN data_koord_relawan d ON c.koord_akun_id = d.akun_id ";
                } else {
                    $query = " null from data_koord_relawan d";
                }
                $q = $this->db->select($query, false)->where('d.akun_id', $uid)->get();
                if ($q->num_rows()) {
                    $row = $q->row();
                    $ret['pria'] = $row->male;
                    $ret['wanita'] = $row->female;
                } else {
                    $ret['pria'] = '0';
                    $ret['wanita'] = '0';
                }
            } else {
                $ret['pria'] = '0';
                $ret['wanita'] = '0';
            }
            $query = '  a.*, c.caleg_akun_id FROM anggota a LEFT JOIN data_relawan b ON a.relawan_id = b.id LEFT JOIN data_koord_relawan c ON b.koord_akun_id = c.akun_id ';
            $ret['pria']    = $this->db->select($query, false)->where(array('a.gender' => 'pria', 'c.akun_id' => $uid))->get()->num_rows();
            $ret['wanita']  = $this->db->select($query, false)->where(array('a.gender' => 'wanita', 'c.akun_id' => $uid))->get()->num_rows();
        } else if ($ulevel == '3') {
            // level caleg

            $tingkatCaleg = $this->getTingkatPemilihanByCalegID($uid);
            if ($tingkatCaleg->num_rows()) {
                $tingkat = $tingkatCaleg->row();
                $tingkatPemilihan = $tingkat->tingkat_pemilihan_id;

                if ($tingkatPemilihan == 1) {
                    $query = "  SUM(CASE WHEN e.gender = 'pria' THEN 1 ELSE 0 END) as male, SUM(CASE WHEN e.gender = 'wanita' THEN 1 ELSE 0 END) as female, COUNT(*) as total FROM ( SELECT a.*,d.caleg_akun_id FROM anggota a LEFT JOIN data_pilihan_caleg b ON a.id = b.anggota_id LEFT JOIN data_relawan c ON b.relawan_id_ri = c.id LEFT JOIN data_koord_relawan d ON c.koord_akun_id = d.akun_id WHERE d.caleg_akun_id = " . $uid . " ) e ";
                } else if ($tingkatPemilihan == 2) {
                    $query = "    SUM(CASE WHEN e.gender = 'pria' THEN 1 ELSE 0 END) as male, SUM(CASE WHEN e.gender = 'wanita' THEN 1 ELSE 0 END) as female, COUNT(*) as total FROM ( SELECT a.*,d.caleg_akun_id FROM anggota a LEFT JOIN data_pilihan_caleg b ON a.id = b.anggota_id LEFT JOIN data_relawan c ON b.relawan_id_prop = c.id LEFT JOIN data_koord_relawan d ON c.koord_akun_id = d.akun_id WHERE d.caleg_akun_id = " . $uid . " ) e";
                } else if ($tingkatPemilihan == 3) {
                    $query = "    SUM(CASE WHEN e.gender = 'pria' THEN 1 ELSE 0 END) as male, SUM(CASE WHEN e.gender = 'wanita' THEN 1 ELSE 0 END) as female, COUNT(*) as total FROM ( SELECT a.*,d.caleg_akun_id FROM anggota a LEFT JOIN data_pilihan_caleg b ON a.id = b.anggota_id LEFT JOIN data_relawan c ON b.relawan_id_kota = c.id LEFT JOIN data_koord_relawan d ON c.koord_akun_id = d.akun_id WHERE d.caleg_akun_id = " . $uid . " ) e ";
                } else {
                    $query = " null from data_koord_relawan d";
                }
                $q = $this->db->select($query, false)->get();
                if ($q->num_rows()) {
                    $row = $q->row();
                    $ret['pria'] = $row->male;
                    $ret['wanita'] = $row->female;
                } else {
                    $ret['pria'] = '0';
                    $ret['wanita'] = '0';
                }
            }
        } else if ($ulevel == '4') {
            // level kordapil
            $tingkatPemilihanKordapil = $this->getTingkatPemilihanByKordapilID($uid);
            if ($tingkatPemilihanKordapil->num_rows()) {
                $tingkat = $tingkatPemilihanKordapil->row();
                $tingkatPemilihan = $tingkat->tingkat_pemilihan_id;

                if ($tingkatPemilihan == 1) {
                    $query = "   SUM(CASE WHEN b.gender = 'pria' THEN 1 ELSE 0 END) as male,
                    SUM(CASE WHEN b.gender = 'wanita' THEN 1 ELSE 0 END) as female,
                    COUNT(*) as total FROM data_pilihan_caleg a 
                    LEFT JOIN anggota b ON a.anggota_id = b.id
                    LEFT JOIN data_relawan c ON a.relawan_id_ri = c.id
                    LEFT JOIN data_koord_relawan d ON c.koord_akun_id = d.akun_id 
                    LEFT JOIN konfigurasi e ON d.caleg_akun_id = e.id_akun_caleg ";
                } else if ($tingkatPemilihan == 2) {
                    $query = "   SUM(CASE WHEN b.gender = 'pria' THEN 1 ELSE 0 END) as male,
                    SUM(CASE WHEN b.gender = 'wanita' THEN 1 ELSE 0 END) as female,
                    COUNT(*) as total FROM data_pilihan_caleg a 
                    LEFT JOIN anggota b ON a.anggota_id = b.id
                    LEFT JOIN data_relawan c ON a.relawan_id_prop = c.id
                    LEFT JOIN data_koord_relawan d ON c.koord_akun_id = d.akun_id 
                    LEFT JOIN konfigurasi e ON d.caleg_akun_id = e.id_akun_caleg ";
                } else if ($tingkatPemilihan == 3) {
                    $query = "   SUM(CASE WHEN b.gender = 'pria' THEN 1 ELSE 0 END) as male,
                    SUM(CASE WHEN b.gender = 'wanita' THEN 1 ELSE 0 END) as female,
                    COUNT(*) as total FROM data_pilihan_caleg a 
                    LEFT JOIN anggota b ON a.anggota_id = b.id
                    LEFT JOIN data_relawan c ON a.relawan_id_kota = c.id
                    LEFT JOIN data_koord_relawan d ON c.koord_akun_id = d.akun_id 
                    LEFT JOIN konfigurasi e ON d.caleg_akun_id = e.id_akun_caleg ";
                } else {
                    $query = " null from konfigurasi e";
                }
                $q = $this->db->select($query, false)->where('e.kordapil_akun_id', $uid)->get();
                if ($q->num_rows()) {
                    $row = $q->row();
                    $ret['pria'] = $row->male;
                    $ret['wanita'] = $row->female;
                } else {
                    $ret['pria'] = '0';
                    $ret['wanita'] = '0';
                }
            } else {
                $ret['pria'] = '0';
                $ret['wanita'] = '0';
            }

            //$query = '  a.*, c.caleg_akun_id, d.kordapil_akun_id FROM anggota a LEFT JOIN data_relawan b ON a.relawan_id = b.id LEFT JOIN data_koord_relawan c ON b.koord_akun_id = c.akun_id LEFT JOIN konfigurasi d ON d.id_akun_caleg = c.caleg_akun_id ';
            $ret['pria']    = $this->db->select($query, false)->where(array('a.gender' => 'pria', 'd.kordapil_akun_id' => $uid))->get()->num_rows();
            $ret['wanita']  = $this->db->select($query, false)->where(array('a.gender' => 'wanita', 'd.kordapil_akun_id' => $uid))->get()->num_rows();
        } else {
            $ret['pria'] = '0';
            $ret['wanita'] = '0';
        }



        return $ret;
    }

    public function getRelawanByID($id)
    {
        $q = $this->db->get_where('data_relawan', array('id' => $id));
        return $q;
    }

    public function getKoordRelawanByID($id)
    {
        $q = $this->db->get_where('data_koord_relawan', array('id' => $id));
        return $q;
    }

    public function getAnggotaByID($id)
    {
        $q = $this->db->get_where('anggota', array('id' => $id));
        return $q;
    }

    public function getAnggotaByNik($nik)
    {
        if ($nik) {
            $query = " g.*, GROUP_CONCAT(f.nama_caleg  SEPARATOR ' & ') as nama_caleg FROM (
                SELECT  a.anggota_id, a.relawan_id_ri as relawan_id, e.nama as nama_caleg FROM data_pilihan_caleg a LEFT JOIN data_relawan b ON a.relawan_id_ri = b.id LEFT JOIN data_koord_relawan c ON b.koord_akun_id = c.akun_id LEFT JOIN konfigurasi d ON c.caleg_akun_id = d.id_akun_caleg LEFT JOIN user_akun e ON c.caleg_akun_id = e.id
                UNION ALL
                SELECT  a.anggota_id, a.relawan_id_prop as relawan_id, e.nama as nama_caleg FROM data_pilihan_caleg a LEFT JOIN data_relawan b ON a.relawan_id_prop = b.id LEFT JOIN data_koord_relawan c ON b.koord_akun_id = c.akun_id LEFT JOIN konfigurasi d ON c.caleg_akun_id = d.id_akun_caleg LEFT JOIN user_akun e ON c.caleg_akun_id = e.id
                UNION ALL
                SELECT  a.anggota_id, a.relawan_id_kota as relawan_id, e.nama as nama_caleg FROM data_pilihan_caleg a LEFT JOIN data_relawan b ON a.relawan_id_kota = b.id LEFT JOIN data_koord_relawan c ON b.koord_akun_id = c.akun_id LEFT JOIN konfigurasi d ON c.caleg_akun_id = d.id_akun_caleg LEFT JOIN user_akun e ON c.caleg_akun_id = e.id
                ) f LEFT JOIN anggota g ON f.anggota_id = g.id   ";

            $q = $this->db->select($query, false)->where(array('g.nik' => $nik, 'f.nama_caleg IS NOT NULL'))->group_by('g.nik')->get();
        } else {
            $q = '';
        }

        return $q;
    }

    public function getAnggotaByIDOnKoordRelawan($idAnggota, $uid)
    {
        // Cek dulu tingkat pemilihan caleg dari koordRelawan ini (dpr ri, prop, kota)
        $cekTingkat =  $this->getCalegByKoordRelawanID($uid);
        if ($cekTingkat->num_rows()) {
            $tingkat = $cekTingkat->row();
            $tingkatPemilihan = $tingkat->tingkat_pemilihan_id;
            $q = $this->db->select("  a.id, a.nik, a.nama, a.pob, a.dob, a.gender, a.alamat, a.propinsi, a.kota, a.kec, a.desa, a.no_wa, a.no_tps, a.scan_ktp, a.foto, b.relawan_id_ri, b.relawan_id_prop, b.relawan_id_kota, b.createdby_ri , b.createdby_prop, b.createdby_kota FROM anggota a LEFT JOIN data_pilihan_caleg b ON a.id = b.anggota_id ", false)->where('a.id', $idAnggota)->get();
            if ($q->num_rows()) {
                foreach ($q->row() as $key => $value) {

                    if ($tingkatPemilihan == 1 && $key == 'relawan_id_ri') {

                        $ret['data']['relawan_id'] = $value;
                    } else if ($tingkatPemilihan == 2 && $key == 'relawan_id_prop') {

                        $ret['data']['relawan_id'] = $value;
                    } else if ($tingkatPemilihan == 3 && $key == 'relawan_id_kota') {

                        $ret['data']['relawan_id'] = $value;
                    } else {
                        $ret['data'][$key] = $value;
                    }
                }
                $ret['status'] = true;
            } else {
                $ret['status'] = false;
            }
        } else {
            $ret['status'] = false;
        }
        return $ret;
    }

    public function totalAnggotaRelawan($idRelawan)
    {
        //$q = $this->db->get_where('anggota', array('relawan_id' => $idRelawan));
        $q = $this->db->select('  b.id, b.nik, b.nama, b.gender, b.pob, b.dob, b.foto, b.scan_ktp, b.alamat, b.no_wa, b.relawan_id, b.koord_akun_id, b.caleg_akun_id, b.kordapil_akun_id, b.nama_desa, b.kecamatan, b.kabupaten, b.nama_propinsi FROM (
            SELECT a.id, a.nik, a.nama, a.gender, a.pob, a.dob, a.foto, a.scan_ktp, a.alamat, a.no_wa, a.desa, a.kec, a.kota, a.propinsi, a.relawan_id, a.koord_akun_id, a.caleg_akun_id, d.kordapil_akun_id, c.nama as nama_desa, c.kecamatan, c.kabupaten, c.propinsi as nama_propinsi FROM anggota_kota a LEFT JOIN desa c ON a.desa = c.kode LEFT JOIN konfigurasi d ON a.caleg_akun_id = d.id_akun_caleg
            UNION ALL
            SELECT a.id, a.nik, a.nama, a.gender, a.pob, a.dob, a.foto, a.scan_ktp, a.alamat, a.no_wa, a.desa, a.kec, a.kota, a.propinsi, a.relawan_id, a.koord_akun_id, a.caleg_akun_id, d.kordapil_akun_id, c.nama as nama_desa, c.kecamatan, c.kabupaten, c.propinsi as nama_propinsi FROM anggota_propinsi a LEFT JOIN desa c ON a.desa = c.kode LEFT JOIN konfigurasi d ON a.caleg_akun_id = d.id_akun_caleg
            UNION ALL
            SELECT a.id, a.nik, a.nama, a.gender, a.pob, a.dob, a.foto, a.scan_ktp, a.alamat, a.no_wa, a.desa, a.kec, a.kota, a.propinsi, a.relawan_id, a.koord_akun_id, a.caleg_akun_id, d.kordapil_akun_id, c.nama as nama_desa, c.kecamatan, c.kabupaten, c.propinsi as nama_propinsi FROM anggota_ri a LEFT JOIN desa c ON a.desa = c.kode LEFT JOIN konfigurasi d ON a.caleg_akun_id = d.id_akun_caleg
            ) b LEFT JOIN data_relawan e ON b.relawan_id = e.id ', false)->where('b.relawan_id', $idRelawan)->group_by('b.relawan_id')->get();
        return $q->num_rows();
    }

    public function adminEntryName($idRelawan)
    {
        $q = $this->db->select(" a.id, a.koord_akun_id, a.nama_relawan, b.nama as nama_admin FROM data_relawan a LEFT JOIN user_akun b ON a.koord_akun_id = b.id ", false)->where(array('a.id' => $idRelawan))->get();
        if ($q->num_rows()) {
            $v = $q->row();
            $name = $v->nama_admin;
        } else {
            $name = '';
        }
        log_message('user_info', 'adminEntryName = ' . $this->db->last_query());
        return $name;
    }



    public function koordRelawanSelect2($filter = array())
    {
        $tblquery = " a.id , a.nik, a.nama_relawan, a.no_wa,  c.nama AS nama_caleg FROM data_relawan a LEFT JOIN data_koord_relawan b ON a.koord_akun_id = b.akun_id LEFT JOIN user_akun c ON b.caleg_akun_id = c.id ";
        $term = $this->input->post('search');
        //$tblquery = " * from data_relawan ";
        $coloumnSearch = array('a.nama_relawan', 'a.nik');
        $limit = 5;
        //$filter = array();
        $q = $this->searchTermArr($tblquery, $coloumnSearch, $term, $limit, $filter);
        $data = array();
        if ($q) {
            foreach ($q as $h) {
                $row = array();
                $row['id'] = $h->id;
                $row['text'] = "[" . $h->nik . "] " . $h->nama_relawan;
                $data[] = $row;
            }
        }
        return $data;
    }

    public function rankingRelawan($where = null, $calegID = null)
    {

        /*$query = " a.koord_akun_id as admin_id, c.nama as nama_admin , b.relawan_id, a.nama_relawan, b.total, d.caleg_akun_id, e.kordapil_akun_id from data_relawan a LEFT JOIN (SELECT id, nik,relawan_id, COUNT(*) as total FROM anggota GROUP BY relawan_id ORDER BY total DESC) b on b.relawan_id = a.id LEFT JOIN user_akun c ON c.id = a.koord_akun_id LEFT JOIN data_koord_relawan d ON a.koord_akun_id = d.akun_id LEFT JOIN konfigurasi e ON d.caleg_akun_id = e.id_akun_caleg  ";*/
        $tingkatCaleg = $this->getTingkatPemilihanByCalegID($calegID);
        if ($tingkatCaleg->num_rows()) {
            $tingkat = $tingkatCaleg->row();
            $tingkatPemilihan = $tingkat->tingkat_pemilihan_id;
            //log_message('user_info', 'tingkatpemilihan : ' . $tingkatPemilihan);
            //log_message('user_info', 'tingkatpemilihanq : ' . $this->db->last_query());
            if ($tingkatPemilihan == 1) {
                $query =  " a.koord_akun_id as admin_id, c.nama as nama_admin, b.relawan_id_ri, a.nama_relawan, b.total, d.caleg_akun_id, e.kordapil_akun_id, f.tingkat_pemilihan_id from data_relawan a 
                LEFT JOIN (SELECT id, anggota_id, relawan_id_ri, COUNT(*) as total FROM data_pilihan_caleg GROUP BY relawan_id_ri ORDER BY total DESC) b on b.relawan_id_ri = a.id 
                LEFT JOIN user_akun c ON c.id = a.koord_akun_id 
                LEFT JOIN data_koord_relawan d ON a.koord_akun_id = d.akun_id 
                LEFT JOIN konfigurasi e ON d.caleg_akun_id = e.id_akun_caleg
                LEFT JOIN data_dapil f ON e.dapil_id = f.id ";
            } else if ($tingkatPemilihan == 2) {
                $query =  " a.koord_akun_id as admin_id, c.nama as nama_admin, b.relawan_id_prop, a.nama_relawan, b.total, d.caleg_akun_id, e.kordapil_akun_id, f.tingkat_pemilihan_id from data_relawan a 
                LEFT JOIN (SELECT id, anggota_id, relawan_id_prop, COUNT(*) as total FROM data_pilihan_caleg GROUP BY relawan_id_prop ORDER BY total DESC) b on b.relawan_id_prop = a.id 
                LEFT JOIN user_akun c ON c.id = a.koord_akun_id 
                LEFT JOIN data_koord_relawan d ON a.koord_akun_id = d.akun_id 
                LEFT JOIN konfigurasi e ON d.caleg_akun_id = e.id_akun_caleg
                LEFT JOIN data_dapil f ON e.dapil_id = f.id ";
            } else if ($tingkatPemilihan == 3) {
                $query =  " a.koord_akun_id as admin_id, c.nama as nama_admin, b.relawan_id_kota, a.nama_relawan, b.total, d.caleg_akun_id, e.kordapil_akun_id, f.tingkat_pemilihan_id from data_relawan a 
                LEFT JOIN (SELECT id, anggota_id, relawan_id_kota, COUNT(*) as total FROM data_pilihan_caleg GROUP BY relawan_id_kota ORDER BY total DESC) b on b.relawan_id_kota = a.id 
                LEFT JOIN user_akun c ON c.id = a.koord_akun_id 
                LEFT JOIN data_koord_relawan d ON a.koord_akun_id = d.akun_id 
                LEFT JOIN konfigurasi e ON d.caleg_akun_id = e.id_akun_caleg
                LEFT JOIN data_dapil f ON e.dapil_id = f.id ";
            } else {
                $query = "  null FROM data_relawan ";
            }

            $this->db->select($query, false);

            if ($where) {
                $this->db->where($where);
            }
            $this->db->order_by('b.total', 'desc')->limit(10);
            $this->db->group_by('relawan_id_ri');
            $q = $this->db->get();
        } else {
            $query = "  null FROM data_relawan WHERE 1=0 ";
            $this->db->select($query, false);
            $q = $this->db->get();
        }


        return $q;
    }
    public function rankingCaleg($kordapil_akun_id = '')
    {
        $this->db->select(" a.nama_caleg , COUNT(*) as total, d.kordapil_akun_id, a.caleg_akun_id FROM (
            SELECT b.*, c.nama as nama_caleg FROM anggota_ri b LEFT JOIN user_akun c ON b.caleg_akun_id = c.id
            UNION ALL
            SELECT b.*, c.nama as nama_caleg FROM anggota_propinsi b LEFT JOIN user_akun c ON b.caleg_akun_id = c.id
            UNION ALL
            SELECT b.*, c.nama as nama_caleg FROM anggota_kota b LEFT JOIN user_akun c ON b.caleg_akun_id = c.id
            ) a LEFT JOIN konfigurasi d ON a.caleg_akun_id = d.id_akun_caleg ", false);
        if ($kordapil_akun_id) {
            $this->db->where('d.kordapil_akun_id', $kordapil_akun_id);
        }
        $this->db->group_by('a.caleg_akun_id')->order_by('total', 'DESC')->limit('10');
        return $this->db->get();
        /* $query = " e.nama as nama_caleg, e.id, f.kordapil_akun_id, g.nama as nama_kordapil, COUNT(*) as jumlah FROM anggota a 
           LEFT JOIN data_relawan b ON a.relawan_id = b.id 
           LEFT JOIN data_koord_relawan c on b.koord_akun_id = c.akun_id left join user_akun e on c.caleg_akun_id = e.id 
           LEFT JOIN konfigurasi f ON f.id_akun_caleg = e.id
           LEFT JOIN user_akun g on f.kordapil_akun_id = g.id ";

        $this->db->select($query, false);
        if ($kordapil_akun_id) {
            // kalo ada kordapil id, cari dulu tingkat pemilihan dari kordapil nya.
            $tingkatPemilihanKordapil = $this->getTingkatPemilihanByKordapilID($kordapil_akun_id);
            if ($tingkatPemilihanKordapil->num_rows()) {
                $tingkat =  $tingkatPemilihanKordapil->row();
                if ($tingkat->tingkat_pemilihan_id == 1) {
                } else if ($tingkat->tingkat_pemilihan_id == 2) {
                } else if ($tingkat->tingkat_pemilihan_id == 3) {
                } else {
                    // tidak ada tingkat pemilihan;
                }
            }
            $this->db->where('f.kordapil_akun_id', $kordapil_akun_id);
        } else {
            // kordapil ID tidak ad, tampilkan smua caleg

        }
        $this->db->group_by('e.id')->order_by('jumlah', 'desc')->limit(10);
        return $this->db->get(); */
    }
}

/* End of file Admin_model.php */
/* Location: ./application/modules/admin/models/Admin_model.php */