<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Relawan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model', 'PM');
        $this->load->library('SelectOption');
        //Load Dependencies

    }

    private function _theme($data)
    {

        $data['libjs']          = jsbyEnv('libRelawan');
        $data['libcss']         = '';
        $data['pjs']            = jsArray(array('bs4-datatables', 'select2', 'moment2.24', 'daterangepicker', 'lightbox', 'dual-listbox'));
        $data['pcss']           = cssArray(array('datatables', 'select2', 'select2-bs5', 'daterangepicker', 'dual-listbox', 'dual-listbox-icon'));
        //$data['menu'] 		= 'admin/sideMenu';

        $this->theme->dashboard_theme($data);
    }

    // List all your items
    public function index()
    {
        $data['konten'] = 'dataRelawan';
        $data['libcss'] = '';
        $data['headDataRelawan'] = headTableRelawan('relawan');
        $this->_theme($data);
    }

    public function table_relawan()
    {
        $genderArr = array('M' => 'Laki-laki', 'F' => 'Perempuan');

        $table        = 'data_relawan';
        $col_order    = array('a.id');
        $col_search   = array('f.nama', 'a.nama_relawan', 'a.nik', 'b.nama', 'c.nama', 'd.nama', 'e.nama');
        $order        = array('a.id' => 'ASC');
        $query        = "  a.id, a.nik, a.nama_relawan, a.pob, a.dob, a.gender, a.alamat, a.no_wa, a.scan_ktp, a.foto, b.nama as propinsi, c.nama as kota, d.nama as kec, e.nama as desa, h.kordapil_akun_id from data_relawan a LEFT JOIN propinsi b on a.propinsi = b.kode LEFT JOIN kabupaten c on a.kota = c.kode LEFT JOIN kecamatan d on a.kec = d.kode LEFT JOIN desa e ON a.desa = e.kode LEFT JOIN user_akun f ON a.koord_akun_id = f.id LEFT JOIN data_koord_relawan g ON g.akun_id = a.koord_akun_id LEFT JOIN konfigurasi h ON g.caleg_akun_id = h.id_akun_caleg  ";

        $uid    = $this->UID;
        $ulevel = $this->ULEVEL;
        if ($ulevel == '1') {
            $filter  = array();
        } else if ($ulevel == '3') {
            $filter  = array('g.caleg_akun_id' => $uid);
        } else if ($ulevel == '4') {
            $filter = array('h.kordapil_akun_id' => $uid);
        } else {
            $filter  = array('1' => '0');
        }



        //get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
        $list  = $this->PM->get_datatables($table, $col_order, $col_search, $order, $query, $filter);
        $data  = array();
        $no    = $_POST['start'];
        foreach ($list as $da) {
            $no++;
            $row   = array();
            $row[] = '<input type="checkbox" class="data-check" value="' . $da->id . '">';
            $row[] = $no;
            $row[] = $da->nik;
            $row[] = $da->nama_relawan;
            $row[] = $da->pob . ', ' . date('d-m-Y', strtotime($da->dob)) . ' / ' . $da->gender;

            $row[] = $da->alamat . '<br>' . $da->desa . '<br>' . $da->kec . '<br>' . $da->kota . '<br>' . $da->propinsi;
            $row[] = $da->no_wa;

            $imgFolder = base_url("AppDoc/relawan/");

            $ktp    = (file_exists($this->AppDoc . 'relawan/' . $da->scan_ktp) && $da->scan_ktp) ? $da->scan_ktp : 'no-image.png';
            $foto   = (file_exists($this->AppDoc . 'relawan/' . $da->foto) && $da->foto) ? $da->foto : 'no_foto.png';


            $row[] = lightbox($imgFolder . $ktp, '', 'Scan KTP') . lightbox($imgFolder . $foto, '', 'Foto');


            $row[] = actionBtnRelawan($da->id, 'relawan');


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
    public function add_relawan()
    {
        $this->form_validation->set_rules($this->PM->dataPendaftaranRelawanRules('add'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {

            $data['koord_akun_id']        = $this->input->post('koord_akun_id');
            $data['nik']            = $this->input->post('nik');
            $data['nama_relawan']           = $this->input->post('nama_relawan');
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
            $data['createdby']      = $this->session->userdata('uid');


            $imageFolder = 'relawan';


            if (!empty($_FILES['scan_ktp']['name'])) {
                $filename = $this->input->post('nik') . '_' . uniqid();
                $uplod_foto = $this->_upload_images('scan_ktp', $filename, $imageFolder);
                if ($uplod_foto['status']) {
                    $data['scan_ktp'] = $uplod_foto['filename'];
                    $ret['statusScanKtp']    = true;
                } else {
                    $ret['msg']['scan_ktp'] = $uplod_foto['error'];
                    $ret['status'] = false;
                    $uploadError['scan_ktp'] = $uplod_foto['error'];
                    $ret['statusScanKtp']    = false;
                }
            } else {
                $ret['statusScanKtp']       = false;
                $ret['msg']['scan_ktp']     = 'file KTP Tidak ditemukan';
            }


            if (!empty($_FILES['foto']['name'])) {
                $filename = $this->input->post('nik') . '_' . uniqid();
                $uplod_foto = $this->_upload_images('foto', $filename, $imageFolder);
                if ($uplod_foto['status']) {
                    $data['foto'] = $uplod_foto['filename'];
                    $ret['status'] = true;
                } else {
                    $ret['msg']['foto'] = $uplod_foto['error'];
                    $ret['status'] = false;
                    $uploadError['foto'] = $uplod_foto['error'];
                    $ret['statusfoto']    = false;
                }
            } else {
                $ret['status'] = true;
            }

            if ($ret['statusScanKtp']) {
                $insert = $this->PM->save('data_relawan', $data);
                if ($insert) {

                    $ret['status'] = true;
                    $ret['msg'] = "Data berhasil disimpan";


                    //$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
                } else {
                    $ret['status']  = false;
                    $ret['msg']     =  "proses simpan data gagal";
                }
            } else {
                $ret['status']  = false;
                //$ret['msg']     = "Data berhasil disimpan";
            }
        }


        $this->jsonOut($ret);
    }

    public function edit_relawan($id)
    {
        if ($id) {
            $data   = $this->PM->getRelawanByID($id);
            if ($data) {
                $ret['status']     = true;
                $ret['data']     = $data->row();
            } else {
                $ret['status']     = false;
                $ret['data']     = 0;
            }
        } else {
            $ret['status']     = false;
            $ret['data']     = 0;
        }

        $this->jsonOut($ret);
    }

    //Update one item
    public function update_relawan()
    {
        $id = $this->input->post('id');
        $this->form_validation->set_rules($this->PM->dataPendaftaranRelawanRules('edit'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {

            $data['koord_akun_id']  = $this->input->post('koord_akun_id');
            $data['nik']            = $this->input->post('nik');
            $data['nama_relawan']   = $this->input->post('nama_relawan');
            $data['pob']            = $this->input->post('pob');
            $data['dob']            = date('Y-m-d', strtotime($this->input->post('dob')));
            $data['gender']         = $this->input->post('gender');
            $data['alamat']         = $this->input->post('alamat');
            $data['propinsi']       = $this->input->post('propinsi');
            $data['kota']           = $this->input->post('kota');
            $data['kec']            = $this->input->post('kec');
            $data['desa']           = $this->input->post('desa');
            $data['no_wa']          = $this->input->post('no_wa');
            // $data['last_update']    = date('Y-m-d H:i:s');
            // $data['created']        = date('Y-m-d H:i:s');



            $imageFolder = 'relawan';



            if (!empty($_FILES['scan_ktp']['name'])) {
                $filename = $this->input->post('nik') . '_' . uniqid();
                $uplod_foto = $this->_upload_images('scan_ktp', $filename, $imageFolder);
                if ($uplod_foto['status']) {
                    $data['scan_ktp'] = $uplod_foto['filename'];
                    $ret['statusScanKtp']    = true;
                } else {
                    $ret['msg']['scan_ktp'] = $uplod_foto['error'];
                    $ret['status'] = false;
                    $uploadError['scan_ktp'] = $uplod_foto['error'];
                    $ret['statusScanKtp']    = false;
                }
            } else {
                $ret['statusScanKtp']       = true;
                $ret['msg']['scan_ktp']     = 'file KTP Tidak ditemukan';
            }


            if (!empty($_FILES['foto']['name'])) {
                $filename = $this->input->post('nik') . '_' . uniqid();
                $uplod_foto = $this->_upload_images('foto', $filename, $imageFolder);
                if ($uplod_foto['status']) {
                    $data['foto'] = $uplod_foto['filename'];
                    $ret['status'] = true;
                } else {
                    $ret['msg']['foto'] = $uplod_foto['error'];
                    $ret['status'] = false;
                    $uploadError['foto'] = $uplod_foto['error'];
                    $ret['statusfoto']    = false;
                }
            } else {
                $ret['status'] = true;
            }


            if ($ret['statusScanKtp']) {

                $insert = $this->PM->update('data_relawan', array('id' =>  $id), $data);
                if ($insert) {

                    $ret['status'] = true;
                    $ret['msg'] = "Data berhasil disimpan";


                    //$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
                } else {
                    $ret['status']  = false;
                    $ret['msg']     =  "proses simpan data gagal";
                }
            } else {
                $ret['status']  = false;
                $ret['msg'] = 'ktp fail';
                //$ret['msg']     = "Data berhasil disimpan";
            }
        }




        $this->jsonOut($ret);
    }

    //Delete one item


    public function delete_relawan()
    {
        /*  $ret['status'] = false;
        $ret['msg'] = 'Fitur dalam proses perbaikan'; */
        $list_id = $this->input->post('id');
        $cekAnggotaRelawan = $this->_cekAnggotaRelawan($list_id);
        if ($cekAnggotaRelawan) {
            // relawan yang dipilih masih memiliki anggota, pindahkan/hapus anggota sebelum data relawan dihapus
            $ret['status'] = false;
            $ret['msg'] = 'relawan yang dipilih masih memiliki ' . $cekAnggotaRelawan . ' anggota, pindahkan/hapus anggota sebelum data relawan dihapus';
        } else {
            $table = 'data_relawan';

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
            }
        }
        $this->jsonOut($ret);
    }

    private function _cekAnggotaRelawan($idRelawan)
    {
        if ($idRelawan) {
            $this->db->select("  * FROM (
            SELECT anggota_id, relawan_id_ri as relawan_id  FROM data_pilihan_caleg
            UNION ALL
            SELECT anggota_id, relawan_id_prop as relawan_id FROM data_pilihan_caleg
            UNION ALL
            SELECT anggota_id, relawan_id_kota as relawan_id FROM data_pilihan_caleg
            ) a ", false);
            if (is_array($idRelawan) && count($idRelawan)) {
                $this->db->where_in('a.relawan_id', $idRelawan);
            } else {
                $this->db->where('a.relawan_id', $idRelawan);
            }
            $query =  $this->db->get();
            // log_message('user_info', "cekAnggotaRelawan : " . $this->db->last_query());
            return $query->num_rows() ? $query->num_rows() : 0;
        } else {
            return false;
        }
    }

    public function table_detail_relawan()
    {
        $fdata = $this->input->post('dfilter');
        // log_message('user_info','filter Data = '.print_r( $fdata['id_relawan'], true) ) ;
        $genderArr = array('M' => 'Laki-laki', 'F' => 'Perempuan');

        $table        = 'data_relawan';
        $col_order    = array('b.id');
        $col_search   = array('b.nama', 'b.nik', 'b.nama_desa', 'b.kecamatan', 'b.kabupaten', 'b.nama_propinsi');
        $order        = array('b.id' => 'ASC');
        $query        = " b.id, b.nik, b.nama, b.gender, b.pob, b.dob, b.foto, b.scan_ktp, b.alamat, b.no_wa, b.relawan_id, b.koord_akun_id, b.caleg_akun_id, b.kordapil_akun_id, b.nama_desa, b.kecamatan, b.kabupaten, b.nama_propinsi FROM (
            SELECT a.id, a.nik, a.nama, a.gender, a.pob, a.dob, a.foto, a.scan_ktp, a.alamat, a.no_wa, a.desa, a.kec, a.kota, a.propinsi, a.relawan_id, a.koord_akun_id, a.caleg_akun_id, d.kordapil_akun_id, c.nama as nama_desa, c.kecamatan, c.kabupaten, c.propinsi as nama_propinsi FROM anggota_kota a LEFT JOIN desa c ON a.desa = c.kode LEFT JOIN konfigurasi d ON a.caleg_akun_id = d.id_akun_caleg
            UNION ALL
            SELECT a.id, a.nik, a.nama, a.gender, a.pob, a.dob, a.foto, a.scan_ktp, a.alamat, a.no_wa, a.desa, a.kec, a.kota, a.propinsi, a.relawan_id, a.koord_akun_id, a.caleg_akun_id, d.kordapil_akun_id, c.nama as nama_desa, c.kecamatan, c.kabupaten, c.propinsi as nama_propinsi FROM anggota_propinsi a LEFT JOIN desa c ON a.desa = c.kode LEFT JOIN konfigurasi d ON a.caleg_akun_id = d.id_akun_caleg
            UNION ALL
            SELECT a.id, a.nik, a.nama, a.gender, a.pob, a.dob, a.foto, a.scan_ktp, a.alamat, a.no_wa, a.desa, a.kec, a.kota, a.propinsi, a.relawan_id, a.koord_akun_id, a.caleg_akun_id, d.kordapil_akun_id, c.nama as nama_desa, c.kecamatan, c.kabupaten, c.propinsi as nama_propinsi FROM anggota_ri a LEFT JOIN desa c ON a.desa = c.kode LEFT JOIN konfigurasi d ON a.caleg_akun_id = d.id_akun_caleg
            ) b LEFT JOIN data_relawan e ON b.relawan_id = e.id    ";


        $filter       = array('b.relawan_id' => $fdata['id_relawan']);
        // $group_by = 'b.relawan_id';
        //get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
        $list  = $this->PM->get_datatables($table, $col_order, $col_search, $order, $query, $filter);
        $data  = array();
        $no    = $_POST['start'];
        foreach ($list as $da) {
            $no++;
            $row   = array();
            $row[] = '<input type="checkbox" class="data-check" value="' . $da->id . '">';
            $row[] = $no;
            $row[] = $da->nik . ' / ' . $da->nama;;

            $row[] = $da->pob . ', ' . date('d-m-Y', strtotime($da->dob)) . ' / ' . $da->gender;

            $row[] = $da->alamat . '<br>' . $da->nama_desa . '<br>' . $da->kecamatan . '<br>' . $da->kabupaten . '<br>' . $da->nama_propinsi;
            $row[] = $da->no_wa;

            $imgFolder = base_url("AppDoc/anggota/");

            $ktp    = file_exists($this->AppDoc . 'anggota/' . $da->scan_ktp) ? $da->scan_ktp : 'no-image.png';
            $foto   = file_exists($this->AppDoc . 'anggota/' . $da->foto) ? $da->foto : 'no_foto.png';

            $row[] = lightbox($imgFolder . $ktp, '', 'Scan KTP') . lightbox($imgFolder . $foto, '', 'Foto');



            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->PM->countAllQueryFiltered($query, $filter),
            "recordsFiltered" => $this->PM->count_filtered($query, $filter),
            "totalAnggota" => $this->PM->count_filtered($query, $filter), //$this->PM->totalAnggotaRelawan($fdata['id_relawan']),
            "adminEntry" => $this->PM->adminEntryName($fdata['id_relawan']),
            "data" => $data,
        );
        //output to json format
        $this->jsonOut($output);
    }



    public function select_akun_relawan()
    {
        $uid    = $this->UID;
        $ulevel = $this->ULEVEL;

        if ($ulevel == '1') {
            echo $this->selectoption->selectKoordRelawanID();
        } else if ($ulevel == '3') {
            echo $this->selectoption->selectKoordRelawanByCaleg($uid);
        } else if ($ulevel == '4') {
            echo $this->selectoption->selectKoordRelawanByKordapil($uid);
        } else {
        }
    }

    public function select_koord_relawan()
    {
        $uid = $this->UID;
        $ulevel = $this->ULEVEL;
        if ($ulevel == 1) {
            $q = $this->PM->koordRelawanSelect2();
        } else if ($ulevel == 3) {
            // select koord by caleg id
            $q = $this->PM->koordRelawanSelect2(array('c.id' => $uid));
        } else {
            $q = null;
        }

        $this->jsonOut($q);
    }

    public function selectanggota()
    {
        $id = $this->input->post('filter');
        // $q = $this->db->get_where('anggota', array('relawan_id' => $id));
        $q = $this->PM->getAnggotaByRelawanID($id);

        if ($q->num_rows()) {

            $dt = array();
            foreach ($q->result() as $val) {
                $d = array();
                $d['nama'] = '[' . $val->nik . '] ' . $val->nama;
                $d['id'] = $val->id;
                $dt[] = $d;
            }
            $data['status'] = true;
            $data['data'] = $dt;
        } else {
            $data['status'] = false;
            $data['data'] = '';
        }

        $this->jsonOut($data);
    }

    public function dotransfer()
    {
        //$ret['status']  = false;
        //$ret['data']    = 'Untuk sementara proses ini di nonaktifkan';
        //pindah anggota antar relawan dalam satu koordinator
        $this->form_validation->set_rules($this->PM->transferAnggotaRules('add'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {
            $toKoord    = $this->input->post('to_koord');
            $fromKoord  = $this->input->post('from_koord');
            $anggota    = $this->input->post('anggota_id');

            // cek apakah relawan sumber dan relawan tujuan masih dalam satu koordinator
            $cekRelawanKoord =  $this->_cekRelawanKoord($toKoord, $fromKoord);
            if ($cekRelawanKoord['status']) {


                $anggotaID = json_decode($anggota, true);
                if ($anggotaID) {
                    $id = array();
                    foreach ($anggotaID as $val) {
                        $id[] = $val['id'];
                    }
                    //log_message('user_info','id = '.print_r($id,true) );
                    $tingkatPemilihan = $cekRelawanKoord['tingkat'];
                    // log_message('user_info', 'tingkatPemilihan ; ' . $tingkatPemilihan);


                    $this->db->where_in('id', $id);
                    if ($tingkatPemilihan == '1') {
                        $this->db->update('data_pilihan_caleg', array('relawan_id_ri' => $toKoord));
                    } else if ($tingkatPemilihan == '2') {
                        $this->db->update('data_pilihan_caleg', array('relawan_id_prop' => $toKoord));
                    } else if ($tingkatPemilihan == '3') {
                        $this->db->update('data_pilihan_caleg', array('relawan_id_kota' => $toKoord));
                    }
                    // $q = $this->db->where_in('id', $id)->update('anggota', array('relawan_id' => $toKoord));

                    $ret['status']  = true;
                    $ret['data']    = $this->db->affected_rows();
                } else {
                    $ret['status']  = false;
                    $ret['data']    = 'kesalahan pada proses';
                }
            } else {
                $ret['status']  = false;
                $ret['data']    = 'Hanya dapat memindahkan anggota dalam satu koord/Admin Entry';
            }
        }

        $this->jsonOut($ret);
    }

    private function _cekRelawanKoord($toKoord, $fromKoord)
    {
        $toQuery = $this->db->get_where('data_relawan', array('id' => $toKoord))->row();
        $fromQuery = $this->db->get_where('data_relawan', array('id' => $fromKoord))->row();
        if ($toQuery->koord_akun_id === $fromQuery->koord_akun_id) {
            $tingkatPemilihan = $this->PM->getTingkatPemilihanByKoordRelawanID($toQuery->koord_akun_id)->row();
            $tingkat = $tingkatPemilihan->tingkat_pemilihan_id;
            $res['status'] = true;
            $res['tingkat'] = $tingkat;
        } else {
            $res['status'] = false;
        }

        return $res;
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
