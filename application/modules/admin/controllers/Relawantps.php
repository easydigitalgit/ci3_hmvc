<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Relawantps extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model', 'PM');
        $this->load->library('SelectOption');
        $this->load->library('PhpExcel');
        $this->UID ? '' : $this->logOut();
    }

    private function _theme($data)
    {

        $data['libjs']          = jsbyEnv('libRelawanTPS');
        $data['libcss']         = '';
        $data['pjs']            = jsArray(array('bs4-datatables', 'select2', 'moment2.24', 'daterangepicker', 'lightbox', 'dual-listbox'));
        $data['pcss']           = cssArray(array('datatables', 'select2', 'select2-bs5', 'daterangepicker', 'dual-listbox', 'dual-listbox-icon'));
        //$data['menu'] 		= 'admin/sideMenu';

        $this->theme->dashboard_theme($data);
    }

    // List all your items
    public function index($offset = 0)
    {
        $data['konten'] = 'dataRelawanTPS';
        $data['libcss'] = '';
        $data['headDataRelawan'] = headTableRelawan('relawan');
        $this->_theme($data);
    }

    public function table_data_relawan_tps()
    {
        $genderArr = array('M' => 'Laki-laki', 'F' => 'Perempuan');
        $xfilter = $this->input->post('dfilter');
        $table        = 'anggota';
        $col_order    = array('a.id');
        $col_search   = array('a.nama', 'a.nik', 'a.no_wa', 'a.gender');
        $order        = array('a.id' => 'ASC');
        $query        = " a.id, a.nik, a.nama, a.gender, a.pob, a.dob, a.alamat, a.no_wa, a.foto, a.scan_ktp, a.no_tps, b.propinsi, b.kabupaten, b.kecamatan, b.nama as desa,  GROUP_CONCAT(c.nama SEPARATOR ',') as nama_caleg FROM anggota a left JOIN ( 
    
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
            LEFT JOIN desa b ON a.desa = b.kode
            LEFT JOIN user_akun c ON v.caleg_akun_id = c.id ";
        $groupby = 'a.id';
        $uid = $this->UID;
        $ulevel = $this->ULEVEL;
        $filter = array();
        if ($ulevel == 1) {
            //$filter       = array();
        } elseif ($ulevel == 2) {
            // level 2 adalah level admin, cari tingkat calegnya dan filter dengan createdby

            $filter['v.createdby'] = $uid;
        } else if ($ulevel == 3) {
            // level 3 adalah level caleg, cari tingkatnya dan filter dengan caleg_akun_id

            $filter['v.caleg_akun_id'] =  $uid;
        } else if ($ulevel == 4) {

            // level 4 adalah level kordapil, cari tingkatnya dan filter dengan kordapil akun id
            $filter['v.kordapil_akun_id'] = $uid;
        } else {
            $filter = array('1' => '0');
        }

        if (is_array($xfilter) && count($xfilter)) {
            if ($xfilter['filter_propinsi']) {
                $filter['a.propinsi'] = $xfilter['filter_propinsi'];
            }

            if ($xfilter['filter_kabupaten']) {
                $filter['a.kota'] = $xfilter['filter_kabupaten'];
            }
            if ($xfilter['filter_kecamatan']) {
                $filter['a.kec'] = $xfilter['filter_kecamatan'];
            }

            if ($xfilter['filter_kelurahan']) {
                $filter['a.desa'] = $xfilter['filter_kelurahan'];
            }
            /*  if ($xfilter['filter_usia_anggota']) {
                $filterAge = array();
                switch ($xfilter['filter_usia_anggota']) {
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
            } */
            if ($xfilter['filter_gender_anggota']) {
                $filter['a.gender'] = $xfilter['filter_gender_anggota'];
            }
            if ($xfilter['filter_terdaftar'] == 0) {
                $filter['a.no_tps'] = '0';
            }
            if ($xfilter['filter_terdaftar'] == '1') {

                $filter['a.no_tps>='] = '1';
            }
        }


        //get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
        $list  = $this->PM->get_datatables($table, $col_order, $col_search, $order, $query, $filter,  $groupby);
        $data  = array();
        $no    = $_POST['start'];
        foreach ($list as $da) {
            $no++;
            $row   = array();
            $row[] = '<input type="checkbox" class="data-check" value="' . $da->id . '">';
            $row[] = $no;
            $row[] = $da->nik;
            $row[] = $da->nama;

            $row[] = $da->gender;
            $row[] = $da->no_tps; // tps
            $row[] = $da->kecamatan . ', ' . $da->desa; //alamat tps
            $row[] = $da->no_wa;

            $row[] = $da->nama_caleg; //caleg
            $row[] = $da->no_tps ? '<span class="badge bg-success "> Terdaftar </span>' : '<span class="badge bg-danger ">Belum Terdaftar</span>'; //status
            $row[] = actEdit($da->id, 'anggota');


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
        $list_id = $this->input->post('id');
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

        $this->jsonOut($ret);
    }
    public function verify()
    {
    }

    public function table_detail_relawan()
    {
        $fdata = $this->input->post('dfilter');
        log_message('user_info', 'filter Data = ' . print_r($fdata['id_relawan'], true));
        $genderArr = array('M' => 'Laki-laki', 'F' => 'Perempuan');

        $table        = 'data_relawan';
        $col_order    = array('a.id');
        $col_search   = array('f.nama', 'a.nik', 'b.nama', 'c.nama', 'd.nama', 'e.nama');
        $order        = array('a.id' => 'ASC');
        $query        = " a.id, a.nik, a.nama, a.pob, a.dob, a.gender, a.alamat, a.no_wa, a.scan_ktp, a.foto, a.relawan_id , b.nama as propinsi, c.nama as kota, d.nama as kec, e.nama as desa, f.nama as nama_relawan from anggota a LEFT JOIN propinsi b on a.propinsi = b.kode LEFT JOIN kabupaten c on a.kota = c.kode LEFT JOIN kecamatan d on a.kec = d.kode LEFT JOIN desa e ON a.desa = e.kode LEFT JOIN user_akun f ON a.relawan_id = f.id ";


        $filter       = array('a.relawan_id' => $fdata['id_relawan']);

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

            $row[] = $da->alamat . '<br>' . $da->desa . '<br>' . $da->kec . '<br>' . $da->kota . '<br>' . $da->propinsi;
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
            "totalAnggota" => $this->PM->totalAnggotaRelawan($fdata['id_relawan']),
            "adminEntry" => $this->PM->adminEntryName($fdata['id_relawan']),
            "data" => $data,
        );
        //output to json format
        $this->jsonOut($output);
    }


    public function edit_anggota($id)
    {
        $data   = $this->PM->getAnggotaByID($id)->row();


        if ($data) {
            $ret['status']   = true;
            $ret['data']     = $data;
        } else {
            $ret['status']   = false;
            $ret['data']     = '0';
        }
        $this->jsonOut($ret);
    }

    public function update_anggota()
    {
        $id = $this->input->post('id');
        $data['no_tps'] = $this->input->post('no_tps');
        $insert = $this->PM->update('anggota', array('id' =>  $id), $data);
        if ($insert) {

            $ret['status'] = true;
            $ret['msg'] = "Data berhasil disimpan";
        } else {
            $ret['status']  = false;
            $ret['msg']     =  "proses simpan data gagal";
        }
        $this->jsonOut($ret);
    }



    public function select_akun_relawan()
    {
        echo $this->selectoption->selectKoordRelawanID();
    }

    public function select_koord_relawan()
    {
        $q = $this->PM->koordRelawanSelect2();
        $this->jsonOut($q);
    }

    public function selectanggota()
    {
        $id = $this->input->post('filter');
        $q = $this->db->get_where('anggota', array('relawan_id' => $id));

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

            $anggotaID = json_decode($anggota, true);
            if ($anggotaID) {
                $id = array();
                foreach ($anggotaID as $val) {
                    $id[] = $val['id'];
                }
                //log_message('user_info','id = '.print_r($id,true) );
                $q = $this->db->where_in('id', $id)->update('anggota', array('relawan_id' => $toKoord));

                $ret['status']  = true;
                $ret['data']    = $this->db->affected_rows();
            } else {
                $ret['status']  = false;
                $ret['data']    = 'kesalahan pada proses';
            }
        }

        $this->jsonOut($ret);
    }

    public function  export_excel()
    {

        $xfilter['filter_propinsi'] = $this->input->post('filter_propinsi');
        $xfilter['filter_kabupaten'] = $this->input->post('filter_kabupaten');
        $xfilter['filter_kecamatan'] = $this->input->post('filter_kecamatan');
        $xfilter['filter_kelurahan'] = $this->input->post('filter_kelurahan');
        $xfilter['filter_terdaftar'] = $this->input->post('filter_terdaftar');
        $xfilter['filter_gender_anggota'] = $this->input->post('filter_gender_anggota');

        $query = " a.id, a.nik, a.nama, a.gender, a.pob, a.dob, a.alamat, a.no_wa, a.foto, a.scan_ktp, a.no_tps, b.propinsi, b.kabupaten, b.kecamatan, b.nama as desa,  GROUP_CONCAT(c.nama SEPARATOR ',') as nama_caleg FROM anggota a left JOIN ( 
    
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
            LEFT JOIN desa b ON a.desa = b.kode
            LEFT JOIN user_akun c ON v.caleg_akun_id = c.id ";

        $uid = $this->UID;
        $ulevel = $this->ULEVEL;
        $filter = array();
        if ($ulevel == 1) {
            //$filter       = array();
        } elseif ($ulevel == 2) {
            // level 2 adalah level admin, cari tingkat calegnya dan filter dengan createdby

            $filter['v.createdby'] = $uid;
        } else if ($ulevel == 3) {
            // level 3 adalah level caleg, cari tingkatnya dan filter dengan caleg_akun_id

            $filter['v.caleg_akun_id'] =  $uid;
        } else if ($ulevel == 4) {
            // level 4 adalah level kordapil, cari tingkatnya dan filter dengan kordapil akun id
            $filter['v.kordapil_akun_id'] = $uid;
        } else {
            $filter = array('1' => '0');
        }

        if ($xfilter['filter_propinsi']) {
            $filter['a.propinsi'] = $xfilter['filter_propinsi'];
        }

        if ($xfilter['filter_kabupaten']) {
            $filter['a.kota'] = $xfilter['filter_kabupaten'];
        }
        if ($xfilter['filter_kecamatan']) {
            $filter['a.kec'] = $xfilter['filter_kecamatan'];
        }

        if ($xfilter['filter_kelurahan']) {
            $filter['a.desa'] = $xfilter['filter_kelurahan'];
        }
        /* if ($xfilter['filter_usia_anggota']) {
                $filterAge = array();
                switch ($xfilter['filter_usia_anggota']) {
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
            } */
        if ($xfilter['filter_gender_anggota']) {
            $filter['a.gender'] = $xfilter['filter_gender_anggota'];
        }
        if ($xfilter['filter_terdaftar'] == '1' || $xfilter['filter_terdaftar'] == '0') {
            $filter['a.no_tps'] = $xfilter['filter_terdaftar'];
        }

        $q = $this->db->select($query, false)->where($filter)->group_by('a.id')->get();
        if ($q->num_rows()) {
            $docProperty = array('filename' => 'Data_relawan_tps.xlsx');
            //a.id, a.nik, a.nama, a.gender, a.pob, a.dob, a.alamat, a.no_wa, a.foto, a.scan_ktp, a.no_tps, b.propinsi, b.kabupaten, b.kecamatan, b.nama as desa,  GROUP_CONCAT(c.nama SEPARATOR ',') as nama_caleg
            $headerData  = array('id', 'nik', 'nama', 'gender', 'pob', 'dob', 'alamat', 'no_wa', 'foto', 'scan_ktp', 'no_tps', 'propinsi', 'kabupaten', 'kecamatan', 'desa', 'nama_caleg');
            $bodyKey = array('id', 'nik', 'nama', 'gender', 'pob', 'dob', 'alamat', 'no_wa', 'foto', 'scan_ktp', 'no_tps', 'propinsi', 'kabupaten', 'kecamatan', 'desa', 'nama_caleg');
            $bodyData = $q->result_array();
            $output = 'file';

            $excel = $this->phpexcel->standardExport($docProperty, $headerData, $bodyKey, $bodyData, $output);
            if (is_file($this->media . $excel)) {
                $ret['status'] = true;
                $ret['filepath'] = '<a href ="' . base_url() . 'AppDoc/media/' . $excel . '"> ' . $excel . '</a>';
            } else {
                $ret['status'] = false;
                $ret['msg'] = 'Proses export file gagal';
            }
        } else {
            $ret['status'] = false;
            $ret['msg'] = 'Data tidak ditemukan';
        }
        $this->jsonOut($ret);
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

/* End of file Relawantps.php */
/* Location: ./application/modules/admin/controllers/Relawantps.php */
