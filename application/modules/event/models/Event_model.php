<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Event_model extends MY_Model {
public function __construct()
{
	parent::__construct();
	//Do your magic here
}


 public function dataJenisEvent($mode = 'add')
    {
        $id = $this->input->post('id');
        $kode = $mode == 'add' ? 'trim|required|is_unique[jenis_event.kode_jenis_event]' : 'trim|required|edit_unique[jenis_event.kode_jenis_event.' . $id . ']';

        $rules =  [
            [
                'field' => 'kode_jenis_event',
                'label' => 'Kode Jenis Event',
                'rules' => $kode,
                'errors' => array('required' => '%s wajib diisi', 'is_unique' => '%s sudah digunakan', 'edit_unique' => '%s sudah digunakan', 'numeric' => '%s Harus berupa Angka'),
            ],
            [
                'field' => 'nama_jenis_event',
                'label' => 'Nama Jenis Event',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi'),
            ]
           



        ];
        return $rules;
    }

    public function dataEventRules($mode = 'add')
    {
        $id = $this->input->post('id');
        $kode = $mode == 'add' ? 'trim|required|is_unique[jenis_event.kode_jenis_event]' : 'trim|required|edit_unique[jenis_event.kode_jenis_event.' . $id . ']';

        $rules =  [
            [
                'field' => 'jenis_event_id',
                'label' => 'Jenis Event',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib dipilih', 'is_unique' => '%s sudah digunakan', 'edit_unique' => '%s sudah digunakan', 'numeric' => '%s Harus berupa Angka'),
            ],
            [
                'field' => 'nama_event',
                'label' => 'Nama  Event',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi'),
            ],
            [
                'field' => 'tgl_event',
                'label' => 'Tanggal Event',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi'),
            ]
           
           



        ];
        return $rules;
    }

     public function whatsappTerjadwalRules($mode = 'add')
    {
        $id = $this->input->post('id');
        $kode = $mode == 'add' ? 'trim|required|is_unique[jenis_event.kode_jenis_event]' : 'trim|required|edit_unique[jenis_event.kode_jenis_event.' . $id . ']';

        $rules =  [
            [
                'field' => 'id_event',
                'label' => 'Nama Event',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib dipilih', 'is_unique' => '%s sudah digunakan', 'edit_unique' => '%s sudah digunakan', 'numeric' => '%s Harus berupa Angka'),
            ],
            [
                'field' => 'jadwal_kirim',
                'label' => 'Jadwal Kirim',
                'rules' => 'trim|required',
                'errors' => array('required' => '%s wajib diisi'),
            ]
           
           



        ];
        return $rules;
    }
	

	public function getJenisEventByID($id){
		$q = $this->db->get_where('jenis_event', array('id'=>$id));
		return $q;
	}
    public function getDataEventByID($id){
        $q = $this->db->get_where('data_event', array('id'=>$id));
        return $q;
    }


	public function jenisEventSelect2(){
        $term = $this->input->post('search');
        $tblquery = " * from jenis_event ";
        $coloumnSearch = array('nama_jenis_event','kode_jenis_event');
        $limit = 5;
        $filter = array();
        $q = $this->searchTermArr($tblquery,$coloumnSearch,$term,$limit,$filter);
        $data = array();
        if($q){
            foreach($q as $h){
                $row = array();
                $row['id'] = $h->id;
                $row['text'] = "[".$h->kode_jenis_event."] ".$h->nama_jenis_event;
                $data[] = $row;
            }
        
        }
        return $data;
}

public function waCron($namaLog){
    $q = $this->db->get_where('logcron', array('nama_log'=>$namaLog))->row();
    return $q;
}

public function deleteWhatsappTerjadwal($id){
    $query = "DELETE FROM pesan_terjadwal, penerima_pesan_terjadwal using pesan_terjadwal, penerima_pesan_terjadwal WHERE penerima_pesan_terjadwal.id_pesan_terjadwal = pesan_terjadwal.id AND pesan_terjadwal.id =  ".$id;

    $q = $this->db->query($query);
    return $this->db->affected_rows();
}
}

/* End of file Event_model.php */
/* Location: ./application/modules/event/models/Event_model.php */