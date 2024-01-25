<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
 
class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }



    //Page header
    public function Header() {
        // menentukan logo berdasrkan lokasi logo
        //$image_file = K_PATH_IMAGES.'../tcpdf_logo.jpg';
		// membuat sebuah gambar dengan file gambar dari $image_file, koortdinat x=10, y=10, ukuran Width gambar 15, align T(top), dpi = 300
        //$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // membuat tulisan dengan font helvetica, tebal, ukuran 10
        $this->SetFont('helvetica', 'B', 10);
        //Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
        // menentukan judul yang akan tampil. width=0, height=15, text=<< TCPDF CODEDB.CO >>, align=C(center)
        $this->Cell(0, 15, 'YAYASAN PENDIDIKAN SHAFIYYATUL AMALIYYAH', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 15, 'INTERNATIONAL ISLAMIC FULL DAY SCHOOL', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 15, 'PG-TK – SD – SMP – SMA ', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 15, 'Terakreditasi A (Amat Baik)', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 15, 'Jalan Setia Budi No. 191 Medan 20122 Telp. (061) 8211347, 8213207  Faks. (061) 8219570 ', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 15, 'Email: info@shafiyyatul.com – Website: www.shafiyyatul.com', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $style = array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => '10,20,5,10', 'phase' => 10, 'color' => array(0, 0, 0));
        $this->Line(5, 10, 80, 30, $style);

    }
 
    // Page footer
    public function Footer() {
        // Membuat posisi footer pada 15 mm dari bawah
        $this->SetY(-15);
        // menentukan tulisan miring dan ukuran font 8
        $this->SetFont('helvetica', 'I', 8);
        // menampilkan nomor halaman
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }

 }
		// membuat format dokumen pdf baru berdasrkan konfigurasi file di folder tcpdf/config/tcpdf_config.php
		$pdf = new Pdf("P", "mm", "A4", true, 'UTF-8', false);
		 
		// set margins
		$pdf->SetMargins(10, 25, 10); // kiri, atas, kanan
		$pdf->SetHeaderMargin(5); // mengatur jarak antara header dan top margin
		$pdf->SetFooterMargin(10); //  mengatur jarak minimum antara footer dan bottom margin

	

/*class MyPdf extends TCPDF
{
    //Page header
    public function Header() {
        // menentukan logo berdasrkan lokasi logo
        //$image_file = K_PATH_IMAGES.'../tcpdf_logo.jpg';
        // membuat sebuah gambar dengan file gambar dari $image_file, koortdinat x=10, y=10, ukuran Width gambar 15, align T(top), dpi = 300
        //$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // membuat tulisan dengan font helvetica, tebal, ukuran 10
        $this->SetFont('helvetica', 'B', 10);
        //Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=0, $link='', $stretch=0, $ignore_min_height=false, $calign='T', $valign='M')
        // menentukan judul yang akan tampil. width=0, height=15, text=<< TCPDF CODEDB.CO >>, align=C(center)
        $this->Cell(0, 9, 'YAYASAN PENDIDIKAN SHAFIYYATUL AMALIYYAH', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 9, 'INTERNATIONAL ISLAMIC FULL DAY SCHOOL', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 9, 'PG-TK – SD – SMP – SMA ', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        
        $this->SetFont('helvetica', '', 8);
        $this->Cell(0, 9, 'Terakreditasi A (Amat Baik)', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 9, 'Jalan Setia Budi No. 191 Medan 20122 Telp. (061) 8211347, 8213207  Faks. (061) 8219570 ', 0, 1, 'C', 0, '', 0, false, 'M', 'M');
        $this->Cell(0, 9, 'Email: info@shafiyyatul.com – Website: www.shafiyyatul.com', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $style = array('width' => 0.1, 'cap' => 'butt', 'join' => 'miter', 'dash' => '0', 'phase' => 0, 'color' => array(0, 0, 0));
        
        //$this->Line($p1x, $p1y, $p2x, $p2y, $style);
        $this->Line(5,32,140,32,$style);
    }
 
    // Page footer
    public function Footer() {
        // Membuat posisi footer pada 15 mm dari bawah
        $this->SetY(-10);
        // menentukan tulisan miring dan ukuran font 8
        $this->SetFont('helvetica', 'I', 8);
        // menampilkan nomor halaman
        //$this->Cell(0, 0, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }

 }*/

 
/* End of file Pdf.php */
/* Location: ./application/libraries/Pdf.php */
?>