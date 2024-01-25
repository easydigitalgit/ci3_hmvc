<?php

use SendGrid\Mail\GroupId;

defined('BASEPATH') or exit('No direct script access allowed');

class Laporan extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Load Dependencies
        $this->load->model('Laporan_model', 'LM');
        $this->load->library('SelectOption');
        $this->load->library('PhpExcel');
        $this->load->helper('actionbtn');
    }

    private function _theme($data)
    {

        $data['libjs']          = jsbyEnv(array('libLaporan'));
        $data['libcss']         = '';
        $data['pjs']            = jsArray(array('bs4-datatables', 'select2'));
        $data['pcss']           = cssArray(array('datatables', 'select2', 'select2-bs4'));
        //$data['menu'] 		= 'admin/sideMenu';

        $this->theme->dashboard_theme($data);
    }

    // List all your items
    public function index()
    {

        $data['konten']                             = 'laporanKonten';
        $data['excelReportKelurahan']         = headExportExcel('excel_laporan_kelurahan');
        $data['excelreportSahabatBJP']        = headExportExcel('excel_laporan_sahabat_bjp');

        $this->_theme($data);
    }

    public function table_laporan_kelurahan()
    {

        $table         = 'anggota';
        $col_order    = array('b.nama_desa');
        $col_search   = array('b.nama', 'b.kabupaten', 'b.kecamatan', 'b.propinsi');
        $order        = array('jumlah' => 'DESC');
        $query        = " b.desa, b.kec, b.kota, b.propinsi, b.nama_desa, b.kabupaten, b.kecamatan, b.nama_propinsi, COUNT(IF(b.gender='pria' ,1,NULL)) AS 'pria',COUNT(IF(b.gender='wanita' ,1,NULL)) AS 'wanita', count(*) as jumlah FROM (
            SELECT a.id, a.nik, a.nama, a.gender, a.desa, a.kec, a.kota, a.propinsi, a.relawan_id, a.koord_akun_id, a.caleg_akun_id, d.kordapil_akun_id, c.nama as nama_desa, c.kecamatan, c.kabupaten, c.propinsi as nama_propinsi FROM anggota_kota a LEFT JOIN desa c ON a.desa = c.kode LEFT JOIN konfigurasi d ON a.caleg_akun_id = d.id_akun_caleg
            UNION ALL
            SELECT a.id, a.nik, a.nama, a.gender, a.desa, a.kec, a.kota, a.propinsi, a.relawan_id, a.koord_akun_id, a.caleg_akun_id, d.kordapil_akun_id, c.nama as nama_desa, c.kecamatan, c.kabupaten, c.propinsi as nama_propinsi FROM anggota_propinsi a LEFT JOIN desa c ON a.desa = c.kode LEFT JOIN konfigurasi d ON a.caleg_akun_id = d.id_akun_caleg
            UNION ALL
            SELECT a.id, a.nik, a.nama, a.gender, a.desa, a.kec, a.kota, a.propinsi, a.relawan_id, a.koord_akun_id, a.caleg_akun_id, d.kordapil_akun_id, c.nama as nama_desa, c.kecamatan, c.kabupaten, c.propinsi as nama_propinsi FROM anggota_ri a LEFT JOIN desa c ON a.desa = c.kode LEFT JOIN konfigurasi d ON a.caleg_akun_id = d.id_akun_caleg
            ) b   ";
        $uid    = $this->UID;
        $ulevel = $this->ULEVEL;
        $xfilter = $this->input->post('dfilter');
        $filter       = array();
        if ($ulevel == 1) {
            //$filter       = array();
        } elseif ($ulevel == 2) {
            // level 2 adalah level admin, cari tingkat calegnya dan filter dengan createdby
            $filter = array('1' => '0');
        } else if ($ulevel == 3) {
            // level 3 adalah level caleg, cari tingkatnya dan filter dengan caleg_akun_id
            $filter['b.caleg_akun_id'] =  $uid;
        } else if ($ulevel == 4) {
            // level 4 adalah level kordapil, cari tingkatnya dan filter dengan kordapil akun id
            $filter['b.kordapil_akun_id'] = $uid;
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

            if ($xfilter['filter_gender_anggota']) {
                $filter['a.gender'] = $xfilter['filter_gender_anggota'];
            }
            if ($xfilter['filter_terdaftar'] == '1' || $xfilter['filter_terdaftar'] == '0') {
                $filter['a.no_tps'] = $xfilter['filter_terdaftar'];
            }
        }

        $group_by = 'b.desa';
        //get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
        $list  = $this->LM->get_datatables($table, $col_order, $col_search, $order, $query, $filter, $group_by);
        $data  = array();
        $no    = $_POST['start'];
        foreach ($list as $da) {
            $no++;
            $row   = array();
            $row[] = '<input type="checkbox" class="data-check" value="">';
            $row[] = $no;
            $row[] = $da->nama_desa;
            $row[] = $da->pria;
            $row[] = $da->wanita;
            $row[] = $da->jumlah;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->LM->countAllQueryFiltered($query, $filter),
            "recordsFiltered" => $this->LM->count_filtered($query, $filter),
            "data" => $data,
        );
        //output to json format
        $this->jsonOut($output);
    }

    public function table_laporan_relawan()
    {

        $table         = 'anggota';
        $col_order    = array('b.relawan_id');
        $col_search   = array('e.nama_relawan');
        $order        = array('jumlah' => 'DESC');
        $query        = " e.nama_relawan,  e.foto, COUNT(IF(b.gender='pria' ,1,NULL)) AS 'pria',COUNT(IF(b.gender='wanita' ,1,NULL)) AS 'wanita', count(*) as jumlah FROM (
            SELECT a.id, a.nik, a.nama, a.gender, a.desa, a.kec, a.kota, a.propinsi, a.relawan_id, a.koord_akun_id, a.caleg_akun_id, d.kordapil_akun_id, c.nama as nama_desa, c.kecamatan, c.kabupaten, c.propinsi as nama_propinsi FROM anggota_kota a LEFT JOIN desa c ON a.desa = c.kode LEFT JOIN konfigurasi d ON a.caleg_akun_id = d.id_akun_caleg
            UNION ALL
            SELECT a.id, a.nik, a.nama, a.gender, a.desa, a.kec, a.kota, a.propinsi, a.relawan_id, a.koord_akun_id, a.caleg_akun_id, d.kordapil_akun_id, c.nama as nama_desa, c.kecamatan, c.kabupaten, c.propinsi as nama_propinsi FROM anggota_propinsi a LEFT JOIN desa c ON a.desa = c.kode LEFT JOIN konfigurasi d ON a.caleg_akun_id = d.id_akun_caleg
            UNION ALL
            SELECT a.id, a.nik, a.nama, a.gender, a.desa, a.kec, a.kota, a.propinsi, a.relawan_id, a.koord_akun_id, a.caleg_akun_id, d.kordapil_akun_id, c.nama as nama_desa, c.kecamatan, c.kabupaten, c.propinsi as nama_propinsi FROM anggota_ri a LEFT JOIN desa c ON a.desa = c.kode LEFT JOIN konfigurasi d ON a.caleg_akun_id = d.id_akun_caleg
            ) b LEFT JOIN data_relawan e ON b.relawan_id = e.id ";
        $uid    = $this->UID;
        $ulevel = $this->ULEVEL;
        $filter       = array();
        $group_by = 'b.relawan_id';
        if ($ulevel = '1') {
        } else if ($ulevel == '3') {
            $filter       = array('b.caleg_akun_id' => $uid);
        } else if ($ulevel == '4') {
            $filter       = array('b.kordapil_akun_id' => $uid);
        } else {
            $filter       = array('1' => '0');
        }


        //get_datatables($table,$col_order,$col_search,$order,$query,$filter=Null,$group_by = null)
        $list  = $this->LM->get_datatables($table, $col_order, $col_search, $order, $query, $filter, $group_by);
        $data  = array();
        $no    = $_POST['start'];
        $imgFolder = base_url("AppDoc/relawan/");
        foreach ($list as $da) {
            $no++;
            $row   = array();
            $row[] = '<input type="checkbox" class="data-check" value="">';
            $row[] = $no;
            $foto = $da->foto ? $da->foto : 'no_foto.png';
            $row[] = lightbox($imgFolder . $foto, '', 'Foto');


            $row[] = $da->nama_relawan;
            $row[] = $da->pria;
            $row[] = $da->wanita;
            $row[] = $da->jumlah;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->LM->countAllQueryFiltered($query, $filter),
            "recordsFiltered" => $this->LM->count_filtered($query, $filter),
            "data" => $data,
        );
        //output to json format
        $this->jsonOut($output);
    }



    public function excel_laporan_sahabat_bjp()
    {
        $uid    = $this->UID;
        $ulevel = $this->ULEVEL;

        if ($ulevel == '1') {
            $filter       = array();
        } else if ($ulevel == '3') {
            $filter       = array('d.caleg_akun_id' => $uid);
        } else if ($ulevel == '4') {
            $filter       = array('e.kordapil_akun_id' => $uid);
        } else {
            $filter       = array('1' => '0');
        }
        $header    = array('No.', 'Nama Koord. Relawan', 'Jumlah Pria', 'Jumlah Wanita', 'Total');
        //$data 			= $this->db->get('struktural')->result_array();
        $data = $this->db->query(" SET @counter:=0 ", false);
        //$data = $this->db->query(" SELECT @counter := @counter+1 AS rownum,  a.*,c.nama_relawan, c.foto, b.propinsi, b.kabupaten, b.kecamatan, b.nama as desa, b.latitude, b.longitude, b.lat_kecamatan, b.long_kecamatan, b.lat_kabupaten, b.long_kabupaten, b.lat_propinsi, b.long_propinsi from ( SELECT relawan_id, desa, COUNT(IF(gender='pria' ,1,NULL)) AS 'pria',COUNT(IF(gender='wanita' ,1,NULL)) AS 'wanita', count(*) as jumlah FROM anggota GROUP BY relawan_id ORDER BY relawan_id ) a LEFT JOIN desa b on a.desa = b.kode LEFT JOIN data_relawan c on a.relawan_id = c.id ", false)->result_array();
        $data = $this->db->select("  @counter := @counter+1 AS rownum,  a.relawan_id, a.desa, a.pria, a.wanita, a.jumlah, c.nama_relawan, c.foto, d.caleg_akun_id, e.kordapil_akun_id, b.propinsi, b.kabupaten, b.kecamatan, b.nama as desa, b.latitude, b.longitude, b.lat_kecamatan, b.long_kecamatan, b.lat_kabupaten, b.long_kabupaten, b.lat_propinsi, b.long_propinsi from ( SELECT relawan_id, desa, COUNT(IF(gender='pria' ,1,NULL)) AS 'pria',COUNT(IF(gender='wanita' ,1,NULL)) AS 'wanita', count(*) as jumlah FROM anggota GROUP BY relawan_id ORDER BY relawan_id ) a LEFT JOIN desa b on a.desa = b.kode LEFT JOIN data_relawan c on a.relawan_id = c.id LEFT JOIN data_koord_relawan d ON c.koord_akun_id = d.akun_id LEFT JOIN konfigurasi e ON d.caleg_akun_id = e.id_akun_caleg ", false)
            ->where($filter)->get()->result_array();

        $bodyKey         = array('rownum', 'nama_relawan', 'pria', 'wanita', 'jumlah');
        $docProperty     = array('filename' => 'Sebaran_anggota_by_koordinator.xlsx');
        //standardExport($docProperty,$headerData,$bodyKey,$bodyData)
        $this->phpexcel->standardExport($docProperty, $header, $bodyKey, $data);
    }

    public function excel_grup_by_relawan()
    {

        $bodyData     = $this->db->query(" SET @counter:=0 ", false);
        $bodyData     = $this->db->query(" SELECT @counter := @counter+1 AS rownum,  a.*,c.nama_relawan, c.foto, b.propinsi, b.kabupaten, b.kecamatan, b.nama as desa, b.latitude, b.longitude, b.lat_kecamatan, b.long_kecamatan, b.lat_kabupaten, b.long_kabupaten, b.lat_propinsi, b.long_propinsi from ( SELECT relawan_id, desa, COUNT(IF(gender='pria' ,1,NULL)) AS 'pria',COUNT(IF(gender='wanita' ,1,NULL)) AS 'wanita', count(*) as jumlah FROM anggota GROUP BY relawan_id ORDER BY relawan_id ) a LEFT JOIN desa b on a.desa = b.kode LEFT JOIN data_relawan c on a.relawan_id = c.id ", false)->result_array();

        $spreadsheet = $this->phpexcel->excel();
        $filename = 'Laporan_anggota_grup_by_relawan';
        //$spreadsheet = new Spreadsheet();
        // Set document properties
        $spreadsheet->getProperties()->setCreator('Ecaleg')
            ->setLastModifiedBy('Ecaleg')
            ->setTitle('Ecaleg-document ')
            ->setSubject('Ecaleg-document')
            ->setDescription('Ecaleg Document Generated By System.')
            ->setKeywords('Document Ecaleg ')
            ->setCategory('Ecaleg Document');
        $header             = array('No.', 'Nama Relawan', 'Jumlah Pria', 'Jumlah Wanita', 'Total');
        $spreadsheet->setActiveSheetIndex(0);
        $spreadsheet->getActiveSheet()
            ->fromArray($headerData, NULL, 'A1');

        $baris = 2;
        $kolom = 1;


        // $bodyData[0]['id']
        $bodyKey         = array('rownum', 'nama_relawan', 'pria', 'wanita', 'jumlah');
        for ($q = 0; $q < count($bodyData); $q++) {
            for ($i = 0; $i < count($bodyKey); $i++) {

                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($kolom, $baris, $bodyData[$q][$bodyKey[$i]]);
                $kolom++;
            }
            $baris++;
            $kolom = 1;
        }


        //$spreadsheet->setActiveSheetIndex(0); // set active sheet to first sheet, so when we open this file it will show first sheet
        $spreadsheet->getActiveSheet()->setTitle('Sheet1');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        //$spreadsheet->setActiveSheetIndex(0);
        for ($i = 'A'; $i <= $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(true);
        }


        $bodyData1         = $this->db->query(" SET @counter:=0 ", false);
        $bodyData1         = $this->db->query(" SELECT  @counter := @counter+1 AS rownum, dd.* FROM (
    									SELECT a.*, b.nama_relawan, c.nama as nama_desa, d.nama as nama_kecamatan, e.nama as nama_kota, f.nama as nama_propinsi FROM anggota a LEFT JOIN data_relawan b ON a.relawan_id = b.id LEFT JOIN desa c ON a.desa = c.kode LEFT JOIN kecamatan d ON a.kec = d.kode LEFT JOIN kabupaten e ON a.kota = e.kode LEFT JOIN propinsi f ON a.propinsi = f.kode  ORDER BY b.id ASC) dd  ", false)->result_array();
        $sheet2Head = array('NO.', 'NAMA', 'NIK', 'ALAMAT', 'DESA', 'KECAMATAN', 'KOTA', 'NO. WA', 'NAMA RELAWAN');
        $sheet2Key = array('rownum', 'nama', 'nik', 'alamat', 'nama_desa', 'nama_kecamatan', 'nama_kota', 'no_wa', 'nama_relawan');

        $spreadsheet->createSheet();

        $spreadsheet->setActiveSheetIndex(1);
        $spreadsheet->getActiveSheet()
            ->fromArray($sheet2Head, NULL, 'A1');

        $baris = 2;
        $kolom = 1;


        // $bodyData[0]['id']

        for ($q = 0; $q < count($bodyData); $q++) {
            for ($i = 0; $i < count($bodyKey); $i++) {

                $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow($kolom, $baris, $bodyData1[$q][$sheet2Key[$i]]);
                $kolom++;
            }
            $baris++;
            $kolom = 1;
        }
        $spreadsheet->getActiveSheet()->setTitle('Sheet2');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        //$spreadsheet->setActiveSheetIndex(0);
        for ($i = 'A'; $i <= $spreadsheet->getActiveSheet()->getHighestColumn(); $i++) {
            $spreadsheet->getActiveSheet()->getColumnDimension($i)->setAutoSize(true);
        }

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        ob_end_clean();
        $writer->save('php://output');
        exit;
    }

    public function sebaran_anggota_kelurahan()
    {
        $query = "  a.*, b.propinsi, b.kabupaten, b.kecamatan, b.nama, b.latitude, b.longitude, b.lat_kecamatan, b.long_kecamatan, b.lat_kabupaten, b.long_kabupaten, b.lat_propinsi, b.long_propinsi from ( SELECT desa, gender, count(*) as jumlah FROM data_relawan GROUP BY desa , gender ORDER BY desa ) a LEFT JOIN desa b on a.desa = b.kode ";
        $q = $this->db->select($query, false)->get();
    }
}



/* End of file Laporan.php */
/* Location: ./application/modules/laporan/controllers/Laporan.php */
