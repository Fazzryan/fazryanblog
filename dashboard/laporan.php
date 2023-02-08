<?php
include "../koneksi.php";
require_once "../fpdf/fpdf.php";
define('FPDF_FONTPATH', 'font/');

$penulis = $_GET["penulis"];
$idUser = $_GET["id_user"];

class PDF extends FPDF
{
    // Membuat Page header
    function Header()
    {
        // Menambahkan Logo
        $this->Image('../asset/img/logoteks.png', 10, 6, 25);
        // Menambahkan judul header
        $this->SetFont('Helvetica', 'B', 13);
        $this->Cell(30);
        $this->Cell(140, 0, 'LAPORAN DATA POSTINGAN - FAZZBLOG', 0, 1, 'C');

        $this->SetFont('Helvetica', '', 7);
        $this->Cell(30);
        $this->Cell(140, 13, 'Copyright 2023 Dibuat Oleh Dinda Fazryan', 0, 1, 'C');
    }
    // Membuat page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Helvetica', 'I', 8);
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$pdf = new PDF('P', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();

//tampilkan judul laporan
$pdf->Cell(0, 20);
$pdf->Ln();
$pdf->SetFont('Helvetica', '', '12');
$pdf->cell(0, 10, 'Postingan ' . $penulis . '');
$pdf->Ln();
//Membuat kolom judul tabel
$pdf->SetFont('Helvetica', 'B', '11');
$pdf->SetFillColor(224, 235, 255);
$pdf->SetTextColor(68, 71, 106);
$pdf->SetDrawColor(42, 53, 79);
$pdf->Cell(8, 7, 'No', 1, '0', 'C', true);
$pdf->Cell(150, 7, 'Judul Postingan', 1, '0', 'C', true);
$pdf->Cell(30, 7, 'Kategori', 1, '0', 'C', true);
$pdf->Ln();

//Membuat kolom isi tabel
$pdf->SetFont('Helvetica', '', '11');
$i = 0;

$tampil = mysqli_query($koneksi, "SELECT * FROM postingan_dindafazryan
LEFT JOIN kategori_dindafazryan
ON postingan_dindafazryan.id_kategori = kategori_dindafazryan.id
WHERE id_user = $idUser");
while ($data = mysqli_fetch_array($tampil)) {
    $i++;
    $pdf->Cell(8, 7, $i, 1, '0', 'C');
    $pdf->Cell(150, 7, $data['judul'], 1, '0', 'L');
    $pdf->Cell(30, 7, $data['nama_kategori'], 1, '0', 'L');
    $pdf->Ln();
}
// Menampilkan output file PDF
$pdf->Output('i', 'Laporan Data Postingan.pdf', 'false');
