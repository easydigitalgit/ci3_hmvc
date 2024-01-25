<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dapil extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model', 'AM');
        $this->load->library('encryption');
        $this->load->library('SelectOption');
        $this->load->library('parser');
       

        $this->UID  ? '' : $this->logOut();
    }

    private function _theme($data)
    {

        $data['libjs']          = jsbyEnv('libDapil');
        $data['libcss']         = '';
        $data['pjs']            = jsArray(array('bs4-datatables', 'select2', 'moment2.24', 'daterangepicker', 'lightbox', 'dual-listbox'));
        $data['pcss']           = cssArray(array('datatables', 'select2', 'select2-bs5', 'daterangepicker', 'dual-listbox', 'dual-listbox-icon'));
        //$data['menu'] 		= 'admin/sideMenu';

        $this->theme->dashboard_theme($data);
    }

    // List all your items
    public function index()
    {

        $ulevel = $this->ULEVEL;

        if ($ulevel == '1') {

            $data['konten'] = 'dapilKonten';
            $data['libcss'] = '';
            $data['headDataDapil'] = headTableCaleg('data_dapil');
            $this->_theme($data);
        } else {
            $this->logOut();
        }
    }

    public function table_data_dapil()
    {

        $table        = 'data_dapil';
        $col_order    = array('a.id');
        $col_search   = array('a.nama_dapil', 'b.nama_tingkat');
        $order        = array('a.id' => 'ASC');
        $query        = " a.*, b.nama_tingkat from data_dapil a LEFT JOIN tingkat_pemilihan b on a.tingkat_pemilihan_id = b.id ";


        $filter       = array();

        //get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
        $list  = $this->AM->get_datatables($table, $col_order, $col_search, $order, $query, $filter);
        $data  = array();
        $no    = $_POST['start'];
        foreach ($list as $da) {
            $no++;
            $row   = array();
            $row[] = '<input type="checkbox" class="data-check" value="' . $da->id . '">';
            $row[] = $no;
            $row[] = $da->nama_tingkat;
            $row[] = $da->nama_dapil;
            $row[] = $da->jumlah_dpt . '/' . $da->jumlah_tps;
            $row[] = $da->keterangan;

            $row[] = actionBtnRelawan($da->id, 'data_dapil');


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->AM->count_all_query($table, $filter),
            "recordsFiltered" => $this->AM->count_filtered($query, $filter, $filter),
            "data" => $data,
        );
        //output to json format
        $this->jsonOut($output);
    }

    // Add a new item
    public function add_data_dapil()
    {
        $this->form_validation->set_rules($this->AM->dataDapilRules('add'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {

            $id = $this->input->post('id');
            $data['nama_dapil']             = $this->input->post('nama_dapil');
            $data['tingkat_pemilihan_id']   = $this->input->post('tingkat_pemilihan_id');
            $data['jumlah_dpt']             = $this->input->post('jumlah_dpt');
            $data['jumlah_tps']             = $this->input->post('jumlah_tps');
            $data['keterangan']             = $this->input->post('keterangan');

            $data['last_update']            = date('Y-m-d H:i:s');

            $kabdapil = $this->input->post('kab_dapil');
            $kecdapil = $this->input->post('kec_dapil');

            // tingkat pemilihan = 1. DPRRI 2. DPR prop 3.DPR KOTA
            $tblDetailDapil     = 'detail_dapil';
            $insert             = $this->AM->insertDb('data_dapil', $data, $id);


            if ($insert) {
                if ($id) {
                    //proses update dapil , hapus detail yang lama, simpan yang baru
                    $this->db->delete($tblDetailDapil, array('data_dapil_id' => $id));
                }
                $dprop['prop_kode']         = $this->input->post('prop_dapil');
                $dprop['data_dapil_id']     = $id ? $id : $insert;

                $insertProp = $this->AM->insertDb($tblDetailDapil, $dprop);



                if (is_array($kabdapil) && count($kabdapil)) {
                    $kab = array();

                    foreach ($kabdapil as $val) {
                        $d['kab_kode']          = $val;

                        $d['prop_kode']         = explode('.', $val)[0];
                        $d['data_dapil_id']     = $id ? $id : $insert;


                        $kab[] = $d;
                    }

                    /*if($id){
                                    $deleteKab = $this->AM->bulkDeleteKey( $tblDetailDapil, 'data_dapil_id', $id); 
                               }*/


                    $insertKab = $this->db->insert_batch($tblDetailDapil, $kab);
                }

                if (is_array($kecdapil) && count($kecdapil) > 0) {
                    $kec = array();
                    //log_message('debug','$kecdapil = '.print_r($kecdapil,true));
                    // log_message('debug', '$kecdapil = '. print_r( json_decode($kecdapil[0],true), true) );
                    $KecDapil = json_decode($kecdapil[0], true);
                    if ($KecDapil) {
                        foreach ($KecDapil as $value) {

                            $dt['kec_kode']         = $value['kode'];

                            $dt['prop_kode']        = explode('.', $value['kode'])[0];
                            $dt['kab_kode']         = implode(".", explode('.', $value['kode'], -1));

                            $dt['data_dapil_id']    = $id ? $id : $insert;


                            $kec[] = $dt;
                        }

                        /*if($id){

                                            $deleteKab = $this->AM->bulkDeleteKey($tblDetailDapil, 'caleg_id', $id);
                                    }*/

                        $insertKec = $this->db->insert_batch($tblDetailDapil, $kec);
                    }
                }

                $ret['status'] = true;
                $ret['msg'] = "Data berhasil disimpan";


                //$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
            } else {
                $ret['status']  = false;
                $ret['msg']     =  "proses simpan data gagal";
            }
        }


        $this->jsonOut($ret);
    }

    public function edit_data_dapil($id)
    {
        if ($id) {
            $data        = $this->AM->getDataDapilByID($id);

            //$detailDapil        = $this->AM->getDetailDapilByDapilID($id);
            $detailDapil = $this->detailDapil($id);

            if ($data) {

                $ret['status']      = true;
                $ret['data']        = $data->row();
                $ret['detail']      = $detailDapil;
            } else {
                $ret['status']   = false;
                $ret['data']     = 0;
            }
        } else {
            $ret['status']      = false;
            $ret['data']        = 0;
        }

        $this->jsonOut($ret);
    }

    public function detailDapil($dapilID)
    {
        // $q = $this->AM->getDetailDapilByDapilID($dapilID);
        $query = " a.id, a.data_dapil_id, a.prop_kode, a.kab_kode, a.kec_kode, b.nama as prop_nama, c.nama as kab_nama, d.nama as kec_nama FROM detail_dapil a LEFT JOIN propinsi b ON a.prop_kode = b.kode LEFT JOIN kabupaten c ON a.kab_kode = c.kode LEFT JOIN kecamatan d ON a.kec_kode = d.kode ";

        $qprop  = $this->db->select($query, false)->where('data_dapil_id', $dapilID)->group_by('a.prop_kode')->get();
        $qkab   = $this->db->select($query, false)->where(array('data_dapil_id' => $dapilID))->where(" a.kab_kode IS NOT NULL ", NULL, false)->group_by('a.kab_kode')->get();
        $qkec   = $this->db->select($query, false)->where('data_dapil_id', $dapilID)->where(" a.kec_kode IS NOT NULL ", NULL, false)->get();
        $ret = false;
        if ($qprop->num_rows()) {
            $row = $qprop->row();
            $ret['data']['prop']['kode'] = $row->prop_kode;
            $ret['data']['prop']['nama'] = $row->prop_nama;
        }

        if ($qkab->num_rows()) {
            foreach ($qkab->result() as  $val) {
                $ret['data']['kab']['kode'][] = $val->kab_kode;
                $ret['data']['kab']['nama'][] = $val->kab_nama;
            }
        }

        if ($qkec->num_rows()) {
            $dt = array();
            $d  = array();
            $dg = array();
            $count = 0;
            $totalRows = $qkec->num_rows();
            $groupName = '';

            foreach ($qkec->result() as $val) {
                $count++;
                if ($groupName == '') {
                    //start first loop 
                    $groupName = $val->kab_nama;
                    $dg['groupName'] = $val->kab_nama;
                    $d['nama'] = $val->kec_nama;
                    $d['kode'] = $val->kec_kode;
                    $d['selected'] = true;
                    $dg['groupData'][] = $d;
                } else {
                    //next loop
                    if ($groupName == $val->kab_nama) {

                        $d['nama'] = $val->kec_nama;
                        $d['kode'] = $val->kec_kode;
                        $d['selected'] = true;
                        $dg['groupData'][] = $d;
                    } else {
                        //$dg['groupData'][] = $d;
                        $dt[] = $dg;
                        $dg = array();
                        $d = array();

                        $groupName = $val->kab_nama;
                        $dg['groupName'] = $val->kab_nama;
                        $d['nama'] = $val->kec_nama;
                        $d['kode'] = $val->kec_kode;
                        $d['selected'] = true;
                        $dg['groupData'][] = $d;
                    }
                }

                if ($count == $totalRows) {
                    $dt[] = $dg;
                }
            }
            $ret['data']['kec'] = $dt;
        }
        return $ret;
    }


    public function selectKecDapil()
    {
        $kab = $this->input->post('kab_dapil');

        if (is_array($kab)) {
            $q = $this->db->where_in('kab_kode', $kab)->get('kecamatan');
            if ($q->num_rows()) {
                $ret['status'] = true;
                $dt = array();
                $d = array();
                $dg = array();
                $count = 0;
                $totalRows = $q->num_rows();
                $groupName = '';
                foreach ($q->result() as $val) {
                    $count++;
                    if ($groupName == '') {
                        //start first loop 
                        $groupName = $val->kabupaten;
                        $dg['groupName'] = $val->kabupaten;
                        $d['nama'] = $val->nama;
                        $d['kode'] = $val->kode;
                        $dg['groupData'][] = $d;
                    } else {
                        //next loop
                        if ($groupName == $val->kabupaten) {

                            $d['nama'] = $val->nama;
                            $d['kode'] = $val->kode;
                            $dg['groupData'][] = $d;
                        } else {
                            //$dg['groupData'][] = $d;
                            $dt[] = $dg;
                            $dg = array();
                            $d = array();

                            $groupName = $val->kabupaten;
                            $dg['groupName'] = $val->kabupaten;
                            $d['nama'] = $val->nama;
                            $d['kode'] = $val->kode;
                            $dg['groupData'][] = $d;
                        }
                    }

                    if ($count == $totalRows) {
                        $dt[] = $dg;
                    }
                }
                $ret['data'] = $dt;
                $ret['count'] = $count;
            } else {
                $ret = '';
            }
        } else {
            $ret = '';
        }
        $this->jsonOut($ret);
    }

    public function reload_dapil($CalegID)
    {
        $propDapil = $this->db->get_where('prop_dapil', array('caleg_id' => $CalegID))->row();

        $kabDapil = $this->db->select(" a.*, b.nama FROM kab_dapil a LEFT JOIN kabupaten b on a.kab_kode = b.kode ", false)->where('a.caleg_id', $CalegID)->get();
        $kab = array();
        foreach ($kabDapil->result() as $val) {
            $kd['id']   = $val->kab_kode;
            $kd['text'] = $val->nama;
            $kab[] = $kd;
        }



        $kecDapil = $this->db->select(" a.*, b.nama, b.kab_kode, b.kabupaten FROM kec_dapil a LEFT JOIN kecamatan b ON a.kec_kode = b.kode ", false)->where('a.caleg_id', $CalegID)->get();


        $dt = array();
        $d = array();
        $dg = array();
        $count = 0;
        $totalRows = $kecDapil->num_rows();
        $groupName = '';

        foreach ($kecDapil->result() as $val) {
            $count++;
            if ($groupName == '') {
                //start first loop 
                $groupName = $val->kabupaten;
                $dg['groupName'] = $val->kabupaten;
                $d['nama'] = $val->nama;
                $d['kode'] = $val->kec_kode;
                $d['selected'] = true;
                $dg['groupData'][] = $d;
            } else {
                //next loop
                if ($groupName == $val->kabupaten) {

                    $d['nama'] = $val->nama;
                    $d['kode'] = $val->kec_kode;
                    $d['selected'] = true;
                    $dg['groupData'][] = $d;
                } else {
                    //$dg['groupData'][] = $d;
                    $dt[] = $dg;
                    $dg = array();
                    $d = array();

                    $groupName = $val->kabupaten;
                    $dg['groupName'] = $val->kabupaten;
                    $d['nama'] = $val->nama;
                    $d['kode'] = $val->kec_kode;
                    $d['selected'] = true;
                    $dg['groupData'][] = $d;
                }
            }

            if ($count == $totalRows) {
                $dt[] = $dg;
            }
        }
        // $ret['data'] = $dt;
        //$ret['count'] = $count;



        $ret['status'] = true;
        $ret['propDapil'] = $propDapil->prop_dapil;
        $ret['kabDapil'] = $kab;
        $ret['kecDapil'] = $dt;

        $this->jsonOut($ret);
    }
}

/* End of file Dapil.php */
/* Location: ./application/modules/admin/controllers/Dapil.php */
