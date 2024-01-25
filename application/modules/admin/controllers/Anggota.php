<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Anggota extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model', 'PM');
        $this->load->library('SelectOption');
        $this->load->helper('parser');
        $this->load->helper('easysender');
        $this->UID ? '' : $this->logOut();
    }

    private function _theme($data)
    {

        $data['libjs']          = jsbyEnv('libAnggota');
        $data['libcss']         = '';
        $data['pjs']            = jsArray(array('bs4-datatables', 'select2', 'moment2.24', 'daterangepicker', 'lightbox'));
        $data['pcss']           = cssArray(array('datatables', 'select2', 'daterangepicker'));
        //$data['menu'] 		= 'admin/sideMenu';

        $this->theme->dashboard_theme($data);
    }

    // List all your items
    public function index()
    {
        $data['konten'] = 'dataAnggota';
        $data['libcss'] = '';
        $data['headDataAnggota'] = $this->ULEVEL == 1 ?  head_tbl_btn2('anggota', false) : headBtnNoDelete('anggota');
        $this->_theme($data);
    }

    public function table_anggota()
    {
        $dfilter = $this->input->post('filter');

        $table        = 'anggota';
        $col_order    = array('a.id');
        $col_search   = array('a.nama', 'a.nik', 'a.no_wa', 'a.gender');
        $order        = array('a.id' => 'ASC');
        $query        = "   a.id, a.nik, a.nama, a.gender, a.pob, a.dob, a.alamat, a.no_wa, a.foto, a.scan_ktp, b.propinsi, b.kabupaten, b.kecamatan, b.nama as desa,  GROUP_CONCAT(v.nama_relawan SEPARATOR ',') as namarelawan FROM anggota a left JOIN ( 
    
            SELECT z.anggota_id, z.relawan_id_ri as relawan_id, z.createdby_ri as createdby, y.nama_relawan, x.caleg_akun_id, k.kordapil_akun_id  from data_pilihan_caleg z
            LEFT JOIN data_relawan y ON z.relawan_id_ri = y.id LEFT JOIN data_koord_relawan x ON y.koord_akun_id = x.akun_id LEFT JOIN konfigurasi k ON k.id_akun_caleg = x.caleg_akun_id
            
            UNION ALL 
            SELECT z.anggota_id, z.relawan_id_prop as relawan_id, z.createdby_prop as createdby, y.nama_relawan, x.caleg_akun_id, k.kordapil_akun_id   from data_pilihan_caleg z
            LEFT JOIN data_relawan y ON z.relawan_id_prop = y.id LEFT JOIN data_koord_relawan x ON y.koord_akun_id = x.akun_id LEFT JOIN konfigurasi k ON k.id_akun_caleg = x.caleg_akun_id
            
            UNION ALL 
            SELECT z.anggota_id, z.relawan_id_kota as relawan_id, z.createdby_kota as createdby, y.nama_relawan, x.caleg_akun_id, k.kordapil_akun_id   from data_pilihan_caleg z
            LEFT JOIN data_relawan y ON z.relawan_id_kota = y.id LEFT JOIN data_koord_relawan x ON y.koord_akun_id = x.akun_id LEFT JOIN konfigurasi k ON k.id_akun_caleg = x.caleg_akun_id
            ) v
            ON a.id = v.anggota_id
            LEFT JOIN desa b ON a.desa = b.kode  ";

        $uid = $this->UID;
        $ulevel = $this->ULEVEL;
        $groupBy      = array('a.id');
        $filter       = array();
        if (is_array($dfilter) && count($dfilter)) {
            if ($dfilter['filter_propinsi']) {
                $filter['a.propinsi'] = $dfilter['filter_propinsi'];
            }

            if ($dfilter['filter_kabupaten']) {
                $filter['a.kota'] = $dfilter['filter_kabupaten'];
            }
            if ($dfilter['filter_kecamatan']) {
                $filter['a.kec'] = $dfilter['filter_kecamatan'];
            }

            if ($dfilter['filter_kelurahan']) {
                $filter['a.desa'] = $dfilter['filter_kelurahan'];
            }
            if ($dfilter['filter_usia_anggota']) {
                $filterAge = array();
                switch ($dfilter['filter_usia_anggota']) {
                    case '1720':
                        $filterAge = array(' TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) >= ' => '17', ' TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) <= ' => '20');
                        break;
                    case '2130':
                        $filterAge = array(' TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) >= ' => '21', ' TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) <= ' => '30');
                        break;
                    case '3140':
                        $filterAge = array(' TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) >= ' => '31', ' TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) <= ' => '40');
                        break;
                    case '4150':
                        $filterAge = array(' TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) >= ' => '41', ' TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) <= ' => '50');
                        break;
                    case '5160':
                        $filterAge = array(' TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) >= ' => '51', ' TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) <= ' => '60');
                        break;
                    case '61':
                        $filterAge = array(' TIMESTAMPDIFF(YEAR, a.dob, CURDATE()) >= ' => '61');
                        break;
                    default:
                        // code...
                        break;
                }
                array_merge($filter, $filterAge);
            }
            if ($dfilter['filter_gender_anggota']) {
                $filter['a.gender'] = $dfilter['filter_gender_anggota'];
            }
        }
        if ($ulevel == 1) {
        } elseif ($ulevel == 2) {
            // level 2 adalah level admin, cari tingkat calegnya dan filter dengan createdby
            $filter['v.createdby'] =  $uid;

            /*  $qtingkat = $this->PM->getTingkatPemilihanByKoordRelawanID($uid);
            if ($qtingkat->num_rows()) {
                $row = $qtingkat->row();
                $tingkat = $row->tingkat_pemilihan_id;
                if ($tingkat == 1) {
                    $filter       = array('k.createdby_ri' => $uid);
                } else if ($tingkat == 2) {
                    $filter       = array('k.createdby_prop' => $uid);
                } else if ($tingkat == 3) {
                    $filter       = array('k.createdby_kota' => $uid);
                } else {
                    $filter = array('1' => '0');
                }
            } else {
                $filter = array('1' => '0');
            } */
        } else if ($ulevel == 3) {
            // level 3 adalah level caleg, cari tingkatnya dan filter dengan caleg_akun_id

            $filter['v.caleg_akun_id'] =  $uid;
            /* $qtingkat = $this->PM->getTingkatPemilihanByCalegID($uid);
            if ($qtingkat->num_rows()) {
                $row = $qtingkat->row();
                $tingkat = $row->tingkat_pemilihan_id;
                if ($tingkat == 1) {
                    $filter       = array('p.caleg_akun_id' => $uid);
                } else if ($tingkat == 2) {
                    $filter       = array('n.caleg_akun_id' => $uid);
                } else if ($tingkat == 3) {
                    $filter       = array('g.caleg_akun_id' => $uid);
                } else {
                    $filter = array('1' => '0');
                }
            } else {
                $filter = array('1' => '0');
            } */
        } else if ($ulevel == 4) {

            // level 4 adalah level kordapil, cari tingkatnya dan filter dengan kordapil akun id
            $filter['v.kordapil_akun_id'] =  $uid;
            /* $qtingkat = $this->PM->getTingkatPemilihanByKordapilID($uid);
            if ($qtingkat->num_rows()) {
                $row = $qtingkat->row();
                $tingkat = $row->tingkat_pemilihan_id;
                if ($tingkat == 1) {
                    $filter       = array('q.kordapil_akun_id' => $uid);
                } else if ($tingkat == 2) {
                    $filter       = array('o.kordapil_akun_id' => $uid);
                } else if ($tingkat == 3) {
                    $filter       = array('h.kordapil_akun_id' => $uid);
                } else {
                    $filter = array('1' => '0');
                }
            } else {
                $filter = array('1' => '0');
            } */
        } else {
            $filter = array('1' => '0');
        }


        //get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
        $list  = $this->PM->get_datatables($table, $col_order, $col_search, $order, $query, $filter,  $groupBy);
        log_message('user_info', 'anggota tables; ' . $this->db->last_query());
        $data  = array();
        $no    = $_POST['start'];
        foreach ($list as $da) {
            $no++;
            $row   = array();
            $row[] = '<input type="checkbox" class="data-check" value="' . $da->id . '">';
            $row[] = $no;
            $row[] = $da->nik;
            $row[] = $da->nama;
            $row[] = $da->gender . ' / ' . $da->pob . ', ' . date('d-m-Y', strtotime($da->dob));
            $row[] = $da->namarelawan;
            $row[] = $da->alamat . '<br> Kel.:' . $da->desa . '<br> Kec.:' . $da->kecamatan . '<br> Kab./Kota:' . $da->kabupaten . '<br> Prop.:' . $da->propinsi;
            $row[] = $da->no_wa;
            $imgFolder = base_url("AppDoc/anggota/");

            $ktp    = (file_exists($this->AppDoc . 'anggota/' . $da->scan_ktp) && $da->scan_ktp) ? $da->scan_ktp : 'no-image.png';
            $foto   = (file_exists($this->AppDoc . 'anggota/' . $da->foto) && $da->foto) ? $da->foto : 'no_foto.png';

            $row[] = lightbox($imgFolder . $ktp, '', 'Scan KTP');
            $row[] = lightbox($imgFolder . $foto, '', 'Foto');
            $row[] = $this->ULEVEL == 1 ? actionBtn3($da->id, 'anggota') : actEdit($da->id, 'anggota');


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->PM->countAllQueryFiltered($query, $filter),
            "recordsFiltered" => $this->PM->count_filtered($query, $filter),
            "data" => $data,
        );
        //output to json format
        $this->jsonOut($output);
    }


    // Add a new item
    public function add_anggota()
    {
        $this->form_validation->set_rules($this->PM->dataPendaftaranRules('add'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
            $ret['msg']['error'] = '<p> input data tidak lengkap atau ada kesalahan input </p>';
        } else {
            $nikAnggota = $this->input->post('nik');
            $relawanID = $this->input->post('relawan_id');
            $cekPilihanCaleg = $this->cekTingkatRelawan($nikAnggota, $relawanID);

            //Cek apakah relawan 
            if ($cekPilihanCaleg['status'] == true) {
                // kalo cek oke , lanjut isian
                $tingkatRelawan = $cekPilihanCaleg['tingkatRelawan'];
                if ($cekPilihanCaleg['nik']) {
                } else {
                    $data['nik']            =  $nikAnggota;
                }

                $data['nama']           = $this->input->post('nama');
                $data['pob']            = $this->input->post('pob');
                $data['dob']            = date('Y-m-d', strtotime($this->input->post('dob')));
                $data['gender']         = $this->input->post('gender');
                $data['alamat']         = $this->input->post('alamat');
                $data['propinsi']       = $this->input->post('propinsi');
                $data['kota']           = $this->input->post('kota');
                $data['kec']            = $this->input->post('kec');
                $data['desa']           = $this->input->post('desa');
                $data['no_wa']          = $this->input->post('no_wa');
                $data['last_update']    = date('Y-m-d H:i:s');
                $data['created']        = date('Y-m-d H:i:s');
                //$data['createdby']      = $this->session->userdata('uid');
                //$data['relawan_id']     = $this->input->post('relawan_id');
                $data['no_tps']         = $this->input->post('no_tps');
                $imageFolder = 'anggota';


                if (!empty($_FILES['scan_ktp']['name'])) {
                    $filename = $this->input->post('nik') . '_' . uniqid();
                    $uplod_foto = $this->_upload_images('scan_ktp', $filename, $imageFolder);
                    if ($uplod_foto['status']) {
                        $data['scan_ktp']           = $uplod_foto['filename'];
                        $ret['statusScanKtp']       = true;
                    } else {
                        $ret['msg']['scan_ktp']     = $uplod_foto['error'];
                        //$ret['status'] = false;
                        $uploadError['scan_ktp']    = $uplod_foto['error'];
                        $ret['statusScanKtp']       = false;
                    }
                } else {
                    if ($this->input->post('imgktp')) {
                    } else {
                        $ret['statusScanKtp']           = false;
                        $ret['msg']['scan_ktp']         = 'file KTP Tidak ditemukan';
                    }
                }


                if (!empty($_FILES['foto']['name'])) {
                    $filename = $this->input->post('nik') . '_' . uniqid();
                    $uplod_foto = $this->_upload_images('foto', $filename, $imageFolder);
                    if ($uplod_foto['status']) {
                        $data['foto']           = $uplod_foto['filename'];
                        $ret['statusFoto']      = true;
                    } else {
                        $ret['msg']['foto']     = $uplod_foto['error'];
                        $ret['statusFoto']      = false;
                        $uploadError['foto']    = $uplod_foto['error'];
                    }
                } else {
                    if ($this->input->post('imgfoto')) {
                        $ret['statusFoto']      = true;
                    } else {
                        $ret['statusFoto']  = false;
                        $ret['msg']['foto'] = 'foto tidak ditemukan';
                    }
                }


                $this->db->trans_start();

                if ($cekPilihanCaleg['nik']) {
                    // sebelom di update cek dulu apakah no hp nya udah dipake apa blom .

                    $cekNowa = $this->db->get_where('anggota', array('no_wa ' => $data['no_wa'], 'nik <>' => $nikAnggota));
                    if ($cekNowa->num_rows()) {
                        // no wa udah dipake di nik lain
                        $ret['status'] = false;
                        $ret['msg']['no_wa'] = '<p class="text-danger"> No Whatsapp sudah digunakan </p>';
                        $ret['msg']['error'] = '<p> input data tidak lengkap atau ada kesalahan input </p>';
                        $this->jsonOut($ret);
                        exit();
                    } else {
                        $insert = $this->PM->update('anggota', array('nik' => $nikAnggota), $data);
                        if ($insert) {
                            // update data anggota berhasil, lanjut update id relawan ke table data pilihan caleg
                            $CreatedBy     = $this->session->userdata('uid');
                            $RelawanID     = $this->input->post('relawan_id');
                            if ($tingkatRelawan == '1') {
                                $dp['relawan_id_ri'] = $RelawanID;
                                $dp['createdby_ri'] = $CreatedBy;
                            } else if ($tingkatRelawan == '2') {
                                $dp['relawan_id_prop'] = $RelawanID;
                                $dp['createdby_prop'] = $CreatedBy;
                            } else if ($tingkatRelawan == '3') {
                                $dp['relawan_id_kota'] = $RelawanID;
                                $dp['createdby_kota'] = $CreatedBy;
                            }
                            //$dp['anggota_id'] = $cekPilihanCaleg['id_anggota'];
                            $dp['last_update'] = date('Y-m-d H:i:s');

                            $dataPilihanCaleg = $this->PM->update('data_pilihan_caleg', array('anggota_id' => $cekPilihanCaleg['id_anggota']), $dp);
                            if ($dataPilihanCaleg) {
                                $ret['msg']['info']     = '
                                <p> ID    : #' . $cekPilihanCaleg['id_anggota'] . ' </p>
                                <p> Nama  : ' . $data['nama'] . ' </p>
                                <p> NIK   : ' . $nikAnggota . ' </p>
                                ';
                            }
                        } else {
                            // update data anggota gagal; 
                            $ret['status']        = false;
                            $ret['msg']['error']  = "E01 - Gangguan pada jaringan, silakan refresh dan coba kembali";
                        }
                    }
                } else {

                    $insert = $this->PM->save('anggota', $data);
                    //log_message('user_info', 'add anggota = ' . $this->db->last_query());
                    if ((int) $insert) {
                        $cek = $this->db->get_where('anggota', array('id' => $insert));
                        if ($cek->num_rows()) {
                            $row = $cek->row();
                            $dt['id']   = $row->id;
                            $dt['nama'] = $row->nama;
                            $dt['nik']  = $row->nik;

                            $ret['msg']['data']     = $dt;
                            $ret['msg']['info']     = '
                                                    <p> ID    : #' . $dt['id'] . ' </p>
                                                    <p> Nama  : ' . $dt['nama'] . ' </p>
                                                    <p> NIK   : ' . $dt['nik'] . ' </p>
                                                    ';

                            /*   if ($ret['statusScanKtp'] && $ret['statusFoto']) {
                            $ret['status']          = true;
                            $ret['msg']['success']  = "Data berhasil disimpan";
                        } else {
                            $ret['status']          = false;
                            $ret['msg']['error']    = "Data berhasil disimpan namun file gagal diupload, silakan lakukan proses update";
                        } */
                        } else {
                            $ret['status']        = false;
                            $ret['msg']['error']  = "E01 - Gangguan pada jaringan, silakan refresh dan coba kembali";
                        }



                        //$ret = array("status" => true , "msg"=>"proses simpan data berhasil");

                        $CreatedBy     = $this->session->userdata('uid');
                        $RelawanID     = $this->input->post('relawan_id');
                        if ($tingkatRelawan == '1') {
                            $dp['relawan_id_ri'] = $RelawanID;
                            $dp['createdby_ri'] = $CreatedBy;
                        } else if ($tingkatRelawan == '2') {
                            $dp['relawan_id_prop'] = $RelawanID;
                            $dp['createdby_prop'] = $CreatedBy;
                        } else if ($tingkatRelawan == '3') {
                            $dp['relawan_id_kota'] = $RelawanID;
                            $dp['createdby_kota'] = $CreatedBy;
                        }
                        $dp['anggota_id'] = $insert;
                        $dp['last_update'] = date('Y-m-d H:i:s');
                        $dataPilihanCaleg = $this->PM->save('data_pilihan_caleg', $dp);
                    } else {
                        $ret['status']        = false;
                        $ret['msg']['error']  = "proses simpan data gagal";
                    }
                }
            } else {
                // pengecekan gagal, output error
                $ret['status'] = false;
                $ret['msg']['error'] = '<p> NIK sudah digunakan </p>';
                if ($cekPilihanCaleg['relawan_id']) {
                    $qcaleg = $this->PM->getCalegIdByRelawanID($cekPilihanCaleg['relawan_id']);
                    if ($qcaleg->num_rows()) {
                        $caleg = $qcaleg->row();
                        $ret['calegName'] = $caleg->nama_caleg;
                        $ret['msg']['info']     = 'NIK sudah didaftarkan pada caleg: ' . $caleg->nama_caleg;
                    } else {
                        $ret['calegName'] = 'NamaCaleg tidak tersedia';
                    }
                } else {
                }
            }



            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                // Transaction failed
                $ret['status']        = false;
                $ret['msg']['error']  = "Proses simpan data gagal";
            } else {
                // Transaction succeeded

                $this->queueWApendaftaran($data, $relawanID);
                $ret['status']          = true;
                $ret['msg']['success']  = "Data berhasil disimpan";
            }
        }
        $this->jsonOut($ret);
    }

    public function edit_anggota($id)
    {
        $uid = $this->UID;
        $ulevel = $this->ULEVEL;
        if ($id) {
            if ($ulevel == 2) {
                $q = $this->PM->getAnggotaByIDOnKoordRelawan($id, $uid);
                if ($q['status']) {
                    $data = $q['data'];
                } else {
                    $data = false;
                }
            } else if ($ulevel == 3) {
                $data   = $this->PM->getAnggotaByID($id)->row();
            }
            //$data   = $this->PM->getAnggotaByID($id);
            if ($data) {
                $ret['status']   = true;
                $ret['data']     = $data;
            } else {
                $ret['status']   = false;
                $ret['data']     = '0';
            }
        } else {
            $ret['status']      = false;
            $ret['data']        = 0;
        }
        //log_message('user_info', 'edit_data_anggota : ' . $this->db->last_query());


        $this->jsonOut($ret);
    }

    public function get_anggota($nik)
    {
        $uid = $this->UID;
        $ulevel = $this->ULEVEL;
        if ($nik && strlen($nik) == 16) {
            $data = $this->PM->getAnggotaByNik($nik)->row();
            if ($data) {
                $ret['status']  = true;
                $ret['data']    = $data;
            } else {
                $ret['status'] = false;
            }
        } else {
            $ret['status'] = false;
        }
        $this->jsonOut($ret);
    }

    //Update one item
    public function update_anggota()
    {
        $id = $this->input->post('id');
        $this->form_validation->set_rules($this->PM->dataPendaftaranRules('edit'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {

            // cek apakah ada id yang akan di edit
            $data['nik']            = $this->input->post('nik');
            $data['nama']           = $this->input->post('nama');
            $data['pob']            = $this->input->post('pob');
            $data['dob']            = date('Y-m-d', strtotime($this->input->post('dob')));
            $data['gender']         = $this->input->post('gender');
            $data['alamat']         = $this->input->post('alamat');
            $data['propinsi']       = $this->input->post('propinsi');
            $data['kota']           = $this->input->post('kota');
            $data['kec']            = $this->input->post('kec');
            $data['desa']           = $this->input->post('desa');
            $data['no_wa']          = $this->input->post('no_wa');
            $data['last_update']    = date('Y-m-d H:i:s');
            //$data['created']        = date('Y-m-d H:i:s');
            //$data['relawan_id']     = $this->input->post('relawan_id');
            $data['no_tps']         = $this->input->post('no_tps');
            $imageFolder = 'anggota';

            if (!empty($_FILES['scan_ktp']['name'])) {
                $filename = $this->input->post('nik') . '_' . uniqid();
                $uplod_foto = $this->_upload_images('scan_ktp', $filename, $imageFolder);
                if ($uplod_foto['status']) {
                    $data['scan_ktp']           = $uplod_foto['filename'];
                    $ret['statusScanKtp']       = true;
                } else {
                    $ret['msg']['scan_ktp']     = $uplod_foto['error'];
                    //$ret['status'] = false;
                    $uploadError['scan_ktp']    = $uplod_foto['error'];
                    $ret['statusScanKtp']       = false;
                }
            } else {
                if ($this->input->post('imgktp')) {
                    $ret['statusScanKtp']       = true;
                } else {
                    $ret['statusScanKtp']           = false;
                    $ret['msg']['scan_ktp']         = 'file KTP Tidak ditemukan';
                }
            }


            if (!empty($_FILES['foto']['name'])) {
                $filename = $this->input->post('nik') . '_' . uniqid();
                $uplod_foto = $this->_upload_images('foto', $filename, $imageFolder);
                if ($uplod_foto['status']) {
                    $data['foto']           = $uplod_foto['filename'];
                    $ret['statusFoto']      = true;
                } else {
                    $ret['msg']['foto']     = $uplod_foto['error'];
                    $ret['statusFoto']      = false;
                    $uploadError['foto']    = $uplod_foto['error'];
                }
            } else {
                if ($this->input->post('imgfoto')) {
                    $ret['statusFoto']      = true;
                } else {
                    $ret['statusFoto']  = false;
                    $ret['msg']['foto'] = 'foto tidak ditemukan';
                }
            }


            if ($ret['statusScanKtp']) {
                //Cek apakah relawan ini tingkatPemilihan nya sama dengan  data yang akan diedit
                $cekEdit = $this->cekEditAnggota($id, $this->input->post('relawan_id'));
                if ($cekEdit['status']) {
                    $insert = $this->PM->update('anggota', array('id' => $id), $data);
                    if ($cekEdit['needUpdate'] == 'yes') {
                        /* $ret['tingkatID'] = 1;
                        $ret['tingkatRelawan'] = 'relawan_id_ri';
                        $ret['createdBY'] = 'createdby_ri'; */

                        $CreatedBy     = $this->session->userdata('uid');
                        $RelawanID     = $this->input->post('relawan_id');
                        $dp[$cekEdit['tingkatRelawan']] = $RelawanID;
                        $dp[$cekEdit['createdBY']] = $CreatedBy;
                        $dp['last_update'] = date('Y-m-d H:i:s');
                        $dataPilihanCaleg = $this->PM->update('data_pilihan_caleg', array('anggota_id' => $id), $dp);
                    } else {
                    }
                    if ($insert) {
                        $ret['status'] = true;
                        $ret['msg']['success'] = "Data berhasil diperbarui";
                        $ret['msg']['info'] = "";
                    }
                } else {
                    $ret['status']  = false;

                    $ret['msg']['error'] = "proses simpan data gagal";
                    $ret['msg']['info'] = $cekEdit['errorMsg'];
                }
            } else {
                $ret['status']  = false;
                $ret['msg']['error'] = "proses simpan data gagal";
                $ret['msg']['info'] = "Scan KTP tidak ditemukan";
                //$ret['msg']     = "Data berhasil disimpan";
            }
        }

        $this->jsonOut($ret);
    }

    //Delete one item
    public function delete_anggota()
    {
        $ret['status'] = false;
        $ret['msg'] = 'Fitur dalam proses perbaikan';

        /*  $list_id = $this->input->post('id');
        $table = 'anggota';

        if (is_array($list_id)) {
            if (!empty($list_id)) {
                $del = $this->PM->bulk_delete($table, $list_id);
                if ($del) {
                    $ret['status'] = true;
                    $ret['msg'] = 'Data berhasil dihapus';
                } else {
                    $ret['status'] = false;
                    $ret['msg'] = 'Proses hapus data gagal';
                }
            }
        } elseif ($list_id) {
            $del = $this->PM->delete_by_id($table, $list_id);
            if ($del) {
                $ret['status'] = true;
                $ret['msg'] = 'Data berhasil dihapus';
            } else {
                $ret['status'] = false;
                $ret['msg'] = 'Proses hapus data gagal';
            }
        } else {
            $ret['status'] = false;
            $ret['msg'] = 'Data belum dipilih';
        } */

        $this->jsonOut($ret);
    }

    private function cekTingkatRelawan($nik, $idRelawan)
    {
        $cekTingkatRelawan = $this->PM->getTingkatPemilihanByRelawanID($idRelawan);
        if ($cekTingkatRelawan->num_rows()) {
            $tingkat = $cekTingkatRelawan->row();
            $tingkatRelawan = $tingkat->tingkat_pemilihan_id;
            $q = $this->db->select(' * FROM anggota a LEFT JOIN data_pilihan_caleg b ON a.id = b.anggota_id  ', false)->where(array('a.nik' => $nik, 'b.id > ' => '0'))->get();
            if ($q->num_rows()) {
                // nik ada cek pilihan anggota


                $cek = $q->row();
                if ($tingkatRelawan == '1') {
                    if ($cek->relawan_id_ri) {
                        $ret['status'] = false;
                        $ret['relawan_id'] = $cek->relawan_id_ri;
                    } else {
                        $ret['status'] = true;
                        $ret['relawan_id'] = '';
                        $ret['tingkatRelawan'] = '1';
                        $ret['nik'] = true;
                        $ret['id_anggota'] = $cek->anggota_id;
                    }
                    log_message('user_info', 'tingkat relawan : ' . print_r($ret, true));
                } else if ($tingkatRelawan == '2') {
                    if ($cek->relawan_id_prop) {
                        $ret['status'] = false;
                        $ret['relawan_id'] = $cek->relawan_id_prop;
                    } else {
                        $ret['status'] = true;
                        $ret['relawan_id'] = '';
                        $ret['tingkatRelawan'] = '2';
                        $ret['nik'] = true;
                        $ret['id_anggota'] = $cek->anggota_id;
                    }
                } else if ($tingkatRelawan == '3') {
                    if ($cek->relawan_id_kota) {
                        $ret['status'] = false;
                        $ret['relawan_id'] = $cek->relawan_id_kota;
                    } else {
                        $ret['status'] = true;
                        $ret['relawan_id'] = '';
                        $ret['tingkatRelawan'] = '3';
                        $ret['nik'] = true;
                        $ret['id_anggota'] = $cek->anggota_id;
                    }
                } else {
                    $ret['status'] = false;
                    log_message('user_info', 'cekTingkatRelawan : tingkat Relawan diluar 1, 2, 3');
                }
                log_message('user_info', $this->db->last_query());
            } else {
                // nik tidak ada lanjut isian
                $ret['status'] = true;
                $ret['tingkatRelawan'] = $tingkatRelawan;
                $ret['nik'] = false;
                log_message('user_info', 'cekTingkatRelawan : nik tidak ditemukan, lanjut isian');
            }
        } else {
            //ID relawan tidak terdaftar
            $ret['status'] = false;
            log_message('user_info', 'cekTingkatRelawan : ID Relawan Tidak terdaftar batalkan');
        }
        return $ret;
    }


    private function cekEditAnggota($anggotaID, $relawanID)
    {
        //Relawan hanya boleh mengedit data anggota yang satu tingkat pemilihan dan satu admin entry dibawah satu caleg yang sama
        // cek data pilihan caleg anggotaID 

        $cekPilihanAnggota = $this->db->get_where('data_pilihan_caleg', array('anggota_id' => $anggotaID));
        if ($cekPilihanAnggota->num_rows()) {
            $cekAnggota = $cekPilihanAnggota->row();
            //anggota ada 
            $cekTingkatRelawan = $this->PM->getTingkatPemilihanByRelawanID($relawanID);
            if ($cekTingkatRelawan->num_rows()) {
                $cekCalegByRelawanID = $this->PM->getCalegIdByRelawanID($relawanID);
                if ($cekCalegByRelawanID->num_rows()) {
                    $cekCalegID = $cekCalegByRelawanID->row();
                    $calegID = $cekCalegID->caleg_akun_id;
                } else {
                    //relawan blom terdaftar return False aja
                    $calegID = false;
                }
                $cekRelawan = $cekTingkatRelawan->row();
                $tingkatPemilihan = $cekRelawan->tingkat_pemilihan_id;

                $calegAkunID = $cekRelawan->caleg_akun_id;
                if ($tingkatPemilihan == 1) {
                    // tingkat relawan == 1 , maka cek apakah di table pilihan caleg idrelawan nya dia juga?
                    $idrelawanTingkat1 = $cekAnggota->relawan_id_ri;
                    if ($idrelawanTingkat1 == $relawanID) {
                        //idRelawannya dia juga return true ga perlu ada update;
                        $ret['status'] = true;
                        $ret['needUpdate'] = 'no';
                    } else {
                        // idRelawannya bukan dia, cek apakah idRelawan di pilihan caleg itu caleg nya sama
                        $cekCalegAnggota = $this->PM->getCalegIdByRelawanID($idrelawanTingkat1);
                        if ($cekCalegAnggota->num_rows()) {
                            $calegAnggota = $cekCalegAnggota->row();
                            if ($calegAnggota->caleg_akun_id == $calegAkunID) {
                                // calegnya sama return true;
                                $ret['status'] = true;
                                $ret['needUpdate'] = 'yes';
                                $ret['tingkatID'] = 1;
                                $ret['tingkatRelawan'] = 'relawan_id_ri';
                                $ret['createdBY'] = 'createdby_ri';
                            } else {
                                // calegnya beda return false;
                                $ret['status'] = false;
                                $ret['errorMsg'] = 'ID caleg tidak sesuai, tidak dapat diupdate.  ';
                            }
                        } else {
                            //caleg anggota tidak ditemukan return false
                            $ret['status'] = false;
                            $ret['errorMsg'] = '[tingkat 1] caleg anggota tidak ditemukan';
                        }
                    }
                } else if ($tingkatPemilihan == 2) {
                    $idrelawanTingkat2 = $cekAnggota->relawan_id_prop;

                    if ($idrelawanTingkat2 == $relawanID) {
                        //idRelawannya dia juga return true ga perlu ada update;
                        $ret['status'] = true;
                        $ret['needUpdate'] = 'no';
                    } else {
                        // idRelawannya bukan dia, cek apakah idRelawan di pilihan caleg itu caleg nya sama
                        $cekCalegAnggota = $this->PM->getCalegIdByRelawanID($idrelawanTingkat2);
                        if ($cekCalegAnggota->num_rows()) {
                            $calegAnggota = $cekCalegAnggota->row();
                            if ($calegAnggota->caleg_akun_id == $calegAkunID) {
                                // calegnya sama return true;
                                $ret['status'] = true;
                                $ret['needUpdate'] = 'yes';
                                $ret['tingkatID'] = 2;
                                $ret['tingkatRelawan'] = 'relawan_id_prop';
                                $ret['createdBY'] = 'createdby_prop';
                            } else {
                                // calegnya beda return false;
                                $ret['status'] = false;
                                $ret['errorMsg'] = 'ID caleg tidak sesuai, tidak dapat diupdate.  ';
                            }
                        } else {
                            //caleg anggota tidak ditemukan return false
                            $ret['status'] = false;
                            $ret['errorMsg'] = '[tingkat 2] caleg anggota tidak ditemukan';
                        }
                    }
                } else if ($tingkatPemilihan == 3) {
                    $idrelawanTingkat3 = $cekAnggota->relawan_id_kota;
                    if ($idrelawanTingkat3 == $relawanID) {
                        //idRelawannya dia juga return true ga perlu ada update;
                        $ret['status'] = true;
                        $ret['needUpdate'] = 'no';
                    } else {
                        // idRelawannya bukan dia, cek apakah idRelawan di pilihan caleg itu caleg nya sama
                        $cekCalegAnggota = $this->PM->getCalegIdByRelawanID($idrelawanTingkat3);
                        if ($cekCalegAnggota->num_rows()) {
                            $calegAnggota = $cekCalegAnggota->row();
                            if ($calegAnggota->caleg_akun_id == $calegAkunID) {
                                // calegnya sama return true;
                                $ret['status'] = true;
                                $ret['needUpdate'] = 'yes';
                                $ret['tingkatID'] = 3;
                                $ret['tingkatRelawan'] = 'relawan_id_kota';
                                $ret['createdBY'] = 'createdby_kota';
                            } else {
                                // calegnya beda return false;
                                $ret['status'] = false;
                                $ret['errorMsg'] = 'ID caleg tidak sesuai, tidak dapat diupdate.  ';
                            }
                        } else {
                            //caleg anggota tidak ditemukan return false
                            $ret['status'] = false;
                            $ret['errorMsg'] = '[tingkat 3] caleg anggota tidak ditemukan';
                        }
                    }
                } else {
                    // tingkat pemilihan si relawan tidak ada yang cocok return false;
                    $ret['status'] = false;

                    $ret['errorMsg'] = ' tingkat pemilihan  relawan tidak Sesuai ';
                }
            } else {
                //relawanID tidak ditemukan return false;
                $ret['status'] = false;
                $ret['errorMsg'] = 'RelawanID tidak ditemukan';
            }
        } else {
            // ga ada anggotaID di tabel pilihan caleg ga bisa diupdate, return false
            $ret['status'] = false;
            $ret['errorMsg'] = ' anggotaID tidak ditemukan di tabel pilihan caleg ';
        }

        return $ret;
    }

    public function select_relawan()
    {
        $id = $this->session->userdata('uid');
        $uid    = $this->UID;
        $ulevel = $this->ULEVEL;

        if ($ulevel == '1') {
            echo $this->selectoption->selectAllRelawan();
        } else if ($ulevel == '2') {
            echo $this->selectoption->selectRelawanByKoordID($uid);
        } else if ($ulevel == '3') {
            echo $this->selectoption->selectRelawanByCalegID($uid);
        } else if ($ulevel == '4') {
            echo $this->selectoption->selectRelawanByKordapilID($uid);
        } else {
        }
    }


    public function queueWApendaftaran($data = array(), $relawanID)
    {
        /*  $q = $this->db->select(' a.nama as nama_anggota, a.no_wa as wa_anggota, e.nama as nama_caleg, d.wa_template, d.wa_center_id, f.no_wa FROM anggota a LEFT JOIN data_relawan b ON a.relawan_id = b.id LEFT JOIN data_koord_relawan c ON b.koord_akun_id = c.akun_id LEFT JOIN konfigurasi d ON c.caleg_akun_id = d.id_akun_caleg LEFT JOIN user_akun e ON e.id = d.id_akun_caleg LEFT JOIN wa_center f ON d.wa_center_id = f.id ', false)->where('a.nik', $data['nik'])->get(); */

        $q = $this->db->select(' a.id, c.wa_template, c.wa_center_id, d.no_wa FROM data_relawan a LEFT JOIN data_koord_relawan b ON a.koord_akun_id = b.akun_id LEFT JOIN konfigurasi c ON b.caleg_akun_id = c.id_akun_caleg LEFT JOIN wa_center d ON c.wa_center_id = d.id ', false)->where('a.id', $relawanID)->get();
        //$q = $this->db->get('konfigurasi');
        // log_message('user_info', 'queueWApendaftaran : ' . $this->db->last_query());
        if ($q->num_rows()) {
            foreach ($q->result() as $val) {
                //$namaCaleg  = $val->nama_caleg;
                $noWa       = $val->no_wa;
                $templateWa = $val->wa_template;
                $senderID   = $val->wa_center_id;
            }

            if ($senderID && $noWa) {
                $dt['body_text']        = $templateWa;
                $dt['to_number']        = $data['no_wa'];
                $dt['jenis_pesan']      = 1;
                $dt['sender_number']    = $noWa;
                $dt['wa_center_id']     = $senderID;
                $dt['media_pesan']      = '';
                $dt['jenis_cron']       = 'wadaftar';
                $dt['createdby']        =  $this->UID; //$data['createdby'];
                $q = $this->PM->save('queue_pesan', $dt);

                if ($q) {
                    $ret = true;
                } else {
                    $ret = false;
                }
            } else {
                $ret = true;
                log_message('user_info', 'queueWApendaftaran : relawan ' . $relawanID . ' tidak memiliki NO. WA');
            }
        } else {
            $ret  = false;
        }
        return $ret;
    }

    private function _upload_images($fieldName, $name, $folder, $ovr = true, $ext = 'jpg|JPG|jpeg|JPEG|png|PNG', $maxSize = 2500, $maxWidth = 4500, $maxHeight = 4500)
    {
        //$userId = $this->session->userdata('userId');
        //$noref = $this->input->post('noref');
        $config = array();
        $config['upload_path']          = $this->AppDoc . $folder . '/';
        $config['allowed_types']        = $ext;
        $config['max_size']             = $maxSize; //set max size allowed in Kilobyte
        $config['max_width']            = $maxWidth; // set max width image allowed
        $config['max_height']           = $maxHeight; // set max height allowed
        $config['file_name']            = $fieldName . '_' . $name;
        $config['file_ext_tolower']     = TRUE;

        $this->load->library('upload', $config, $fieldName); // Create custom object for foto upload
        $this->$fieldName->initialize($config);
        $this->$fieldName->overwrite = $ovr;

        //upload and validate
        if ($this->$fieldName->do_upload($fieldName)) {
            $res['filename'] = $this->$fieldName->data('file_name');
            $res['error']    = '';
            $res['status']   = true;
        } else {
            $res['error']    =  $this->$fieldName->display_errors('<p class="text-danger">', '</p>');
            $res['filename'] = '';
            $res['status']   = false;
        }
        return $res;
    }
}

/* End of file Daftar_awal.php */
/* Location: ./application/modules/pendaftaran/controllers/Daftar_awal.php */
