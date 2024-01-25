<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Jenis_agenda extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Agenda_model', 'AM');
        $this->load->library('encryption');
        $this->load->library('SelectOption');
        $this->load->library('parser');


        $this->UID  ? '' : $this->logOut();
    }

    private function _theme($data)
    {

        $data['libjs']          = jsbyEnv(array('libDataTables', 'libStandardCrud', 'libJenisAgenda'));
        $data['libcss']         = '';
        $data['pjs']            = jsArray(array('bs4-datatables'));
        $data['pcss']           = cssArray(array('datatables'));
        //$data['menu'] 		= 'admin/sideMenu';

        $this->theme->dashboard_theme($data);
    }


    // List all your items
    public function index()
    {

        $ulevel = $this->ULEVEL;

        if ($ulevel == '1') {

            $data['konten'] = 'jenisAgendaKonten';
            $data['libcss'] = '';
            $data['headTableJenisAgenda'] = headBtnNoDelete('data_jenis_agenda');
            $this->_theme($data);
        } else {
            $this->logOut();
        }
    }

    public function table_data_jenis_agenda()
    {

        $table        = 'jenis_agenda';
        $col_order    = array('id');
        $col_search   = array('nama_jenis_agenda', 'kode_jenis_agenda');
        $order        = array('id' => 'ASC');
        $query        = "  * FROM jenis_agenda ";


        $filter       = array('');


        $list  = $this->AM->get_datatables($table, $col_order, $col_search, $order, $query, $filter);
        $data  = array();
        $no    = $_POST['start'];
        foreach ($list as $da) {
            $no++;
            $row   = array();
            $row[] = '<input type="checkbox" class="data-check" value="' . $da->id . '">';
            $row[] = $no;
            $row[] = $da->kode_jenis_agenda;
            $row[] = $da->nama_jenis_agenda;
            $row[] = $da->deskripsi_agenda;

            $row[] = actbtn2($da->id, 'data_jenis_agenda');


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->AM->count_all_query($table, $filter),
            "recordsFiltered" => $this->AM->count_filtered($query, $filter),
            "data" => $data,
        );
        //output to json format
        $this->jsonOut($output);
    }

    public function add_data_jenis_agenda()
    {
        $this->form_validation->set_rules($this->AM->dataJenisAgendaRules('add'));
        $this->form_validation->set_error_delimiters('<p class="text-danger">', '</p>');
        if ($this->form_validation->run() == FALSE) {
            $ret['status'] = false;
            foreach ($_POST as $key => $value) {
                $ret['msg'][$key] = form_error($key);
            }
        } else {

            $id = $this->input->post('id');

            $data['nama_jenis_agenda']    = $this->input->post('nama_jenis_agenda');
            $data['kode_jenis_agenda']    = $this->input->post('kode_jenis_agenda');
            $data['deskripsi_agenda']     = $this->input->post('deskripsi_agenda');

            $data['last_update']        = date('Y-m-d H:i:s');

            $insert   = $this->AM->insertDb('jenis_agenda', $data, $id);


            if ($insert) {
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

    public function edit_data_jenis_agenda($idAgenda)
    {
        $q = $this->AM->getDataJenisAgendaByID($idAgenda);
        if ($q->num_rows()) {
            $row = $q->row_array();

            $ret['status'] = true;
            $ret['data'] = $row;
        } else {
            $ret['status'] = false;
            $ret['data'] = '';
        }
        $this->jsonOut($ret);
    }



    public function delete_data_agenda()
    {
        $id = $this->input->post('id');
    }
}

/* End of file Jenis_agenda.php */
/* Location: ./application/modules/program_kerja/controllers/Jenis_agenda.php */
