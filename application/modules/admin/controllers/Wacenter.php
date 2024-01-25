<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Wacenter extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Admin_model', 'AM');
        $this->load->library('encryption');
        $this->load->library('SelectOption');
        $this->load->library('parser');

        $this->load->helper('starsender');

        $this->UID  ? '' : $this->logOut();
    }

    private function _theme($data)
    {

        $data['libjs']          = jsbyEnv(array('libStandardCrud', 'libDataTables', 'libWacenter'));
        $data['libcss']         = '';
        $data['pjs']            = jsArray(array('bs4-datatables', 'select2', 'moment2.24', 'daterangepicker', 'lightbox', 'dual-listbox'));
        $data['pcss']           = cssArray(array('datatables', 'select2', 'daterangepicker', 'dual-listbox', 'dual-listbox-icon'));
        //$data['menu'] 		= 'admin/sideMenu';

        $this->theme->dashboard_theme($data);
    }


    public function index()
    {

        $ulevel = $this->ULEVEL;

        if ($ulevel == '1') {

            $data['konten']         = 'waCenterKonten';
            $data['libcss']         = '';
            $data['headWaCenter']   = headTableCaleg('data_wa_sender');
            $this->_theme($data);
        } else {
            $this->logOut();
        }
    }

    public function table_data_wa_sender()
    {

        $table        = 'wa_center';
        $col_order    = array('id');
        $col_search   = array('no_wa');
        $order        = array('id' => 'ASC');
        $query        = " * FROM wa_center  ";

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
            $row[] = $da->no_wa;
            $row[] = $da->apikey;
            $row[] = $da->deskripsi;
            $row[] = actbtnWaCenter($da->id, 'data_wa_sender');


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
        // Add a new item
    }

    public function add_data_wa_sender()
    {
        $id = $this->input->post('id');
        $mode = (int) $id > 0 ? 'edit' : 'add';
        $this->form_validation->set_rules($this->AM->dataPendaftaranWaCenter($mode));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {

            $data['no_wa']        = $this->input->post('no_wa');
            $data['apikey']       = $this->input->post('apikey');
            $data['deskripsi']    = $this->input->post('deskripsi');
            $data['last_update']  = date('Y-m-d H:i:s');


            $insert = $this->AM->insertDb('wa_center', $data, $id);
            if ($insert) {

                $ret['status']     = true;
                $ret['msg']     = "Data berhasil disimpan";


                //$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
            } else {
                $ret['status']  = false;
                $ret['msg']     =  "proses simpan data gagal";
            }
        }

        $this->jsonOut($ret);
    }

    public function edit_data_wa_sender($id)
    {
        if ($id) {
            $data   = $this->AM->getDataWaSenderByID($id);
            if ($data) {
                $ret['status']         = true;
                $ret['data']         = $data->row();
            } else {
                $ret['status']         = false;
                $ret['data']         = 0;
            }
        } else {
            $ret['status']             = false;
            $ret['data']             = 0;
        }

        $this->jsonOut($ret);
    }

    //Update one item
    public function update_data_wa_center()
    {
        $id = $this->input->post('id');
        $this->form_validation->set_rules($this->AM->dataPendaftaranWaCenter('edit'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {

            $data['no_wa']        = $this->input->post('no_wa');
            $data['apikey']       = $this->input->post('apikey');
            $data['deskripsi']    = $this->input->post('deskripsi');
            $data['last_update']  = date('Y-m-d H:i:s');


            $insert = $this->AM->update('wa_center', array('id' =>  $id), $data);
            if ($insert) {

                $ret['status'] = true;
                $ret['msg'] = "Data berhasil disimpan";


                //$ret = array("status" => true , "msg"=>"proses simpan data berhasil");
            } else {
                $ret['status']  = false;
                $ret['msg']     =  "proses simpan data gagal";
                //log_message('user_info','last query = '.$this->db->last_query());
            }
        }

        $this->jsonOut($ret);
    }

    //Delete one item
    public function delete_data_wa_center()
    {
        $data    = $this->input->post('id');
        $table   = 'wa_center';

        $ret     = $this->DataDelete($table, $data);

        $this->jsonOut($ret);
    }

    public function add_test_pesan()
    {
        //$testNumber = '082261631836';
        $testNumber = $this->input->post('test_number');
        $idCenter   = $this->input->post('id_center');

        $cek = $this->db->get_where('wa_center', array('id' => $idCenter));

        if ($cek->num_rows()) {
            $row    = $cek->row();
            $number = $row->no_wa;
            $key    = $row->apikey;

            $text = 'Ujicoba pengiriman pesan whatsapp pada tanggal: ' . date('Y-m-d') . ' Pukul:  ' . date('H:i:s');

            $sendText = sendtext($testNumber, $text, $key);
            $ret['status']  = true;
            $ret['msg']     = json_decode($sendText);
        } else {
            $ret['status']  = false;
            $ret['msg']     = 'Data tidak ditemukan';
        }

        $this->jsonOut($ret);
    }
}

/* End of file Wacenter.php */
/* Location: ./application/modules/admin/controllers/Wacenter.php */
