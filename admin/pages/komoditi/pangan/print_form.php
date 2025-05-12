<?php
include "../../../../conf/conn.php";
require_once("../../../vendor/dompdf/autoload.inc.php");
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$id = $_GET['id'];
$query = $conn -> query("SELECT * FROM tbl_psb_pangan
						INNER JOIN tbl_detail_client ON tbl_psb_pangan.id_detail=tbl_detail_client.id_detail
						LEFT JOIN tbl_perusahaan ON tbl_detail_client.id_perusahaan=tbl_perusahaan.id_perusahaan
						LEFT JOIN tbl_gudang ON tbl_detail_client.id_gudang=tbl_gudang.id_gudang
						WHERE id_psb='$id'");
$row = mysqli_fetch_array($query);
$tglpsb = date('d-m-Y', strtotime($row['tgl_psb']));
$pangan = str_replace(",", "<br>", $row['jenispangan']);

$html = "<style>
html{
	margin:0.5cm 1.5cm;
	font-size:11pt;
}
table tr td {
	vertical-align:top;
	text-align:justify;
}
</style>
<title>".$row['nama_perusahaan']."</title>";
$html .= '<center><h1 style="font-family: Arial, Helvetica, sans-serif;">KOP PERUSAHAAN</h1></center><br/>';
$html .= "<table border=0 width=100% style='font-family: Arial, Helvetica, sans-serif; margin-left:20px;'>
 <tr>
 <td>Nomor</td>
 <td>:</td>
 <td>".$row['id_psb']."</td>
 <td style='width:30%;'></td>
 <td style='width:35%; text-align:right'>".$row['alamat_perusahaan'].", ".$tglpsb."</td>
 </tr>
 <tr>
 <td>Lampiran</td>
 <td>:</td>
 <td>1</td>
 </tr>
 <tr>
 <td>Perihal</td>
 <td>:</td>
 <td colspan='3' style='text-transform:capitalize;'>permohonan pemeriksaan sarana ".$row['perihal_psb']."<br>dalam rangka pendaftaran pangan</td>
 </tr>
 </table><br>
 ";
 $html .= "<table border=0 width=100% style='font-family: Arial, Helvetica, sans-serif; margin-left:20px;'>
 <tr>
 <td>Yth. </td>
 <td>Kepala Balai Besar Pengawas Obat dan Makanan di Surabaya</td>
 </tr>
 <tr>
 <td></td>
 <td>Jl. Karangmenjangan No. 20</td>
 </tr>
 <tr>
 <td></td>
 <td>Surabaya</td>
 </tr>
 </table><br>
 ";
 $html .= "<table border=0 width=100% style='font-family: Arial, Helvetica, sans-serif; margin-left:20px;'>
 <tr>
 <td>Dengan Hormat,</td>
 </tr>
 </table><br>
 ";
 $html .= "<table border=0 width=100% style='font-family: Arial, Helvetica, sans-serif; margin-left:20px;'>
 <tr>
 <td>Bersama ini kami mengajukan permohonan pemeriksaan sarana ".$row['perihal_psb']." dalam rangka pendaftaran pangan dengan data-data sebagai berikut :</td>
 </tr>
 </table><br>
 ";
 $html .= "<table border=0 width=100% style='font-family: Arial, Helvetica, sans-serif; margin-left:20px;'>
 <tr>
 <td style='width:30%;'>Nama Pemohon</td>
 <td style='width:2px;'>:</td>
 <td>".$row['nama_detail']."</td>
 </tr>
 <tr>
 <td style='width:30%;'>Alamat Pemohon</td>
 <td style='width:2px;'>:</td>
 <td>".$row['alamat_detail']."</td>
 </tr>
 <tr>
 <td style='width:30%;'>Nama Perusahaan</td>
 <td style='width:2px;'>:</td>
 <td>".$row['nama_perusahaan']."</td>
 </tr>
 <tr>
 <td style='width:30%;'>Alamat Perusahaan</td>
 <td style='width:2px;'>:</td>
 <td>".$row['alamat_perusahaan']."</td>
 </tr>
 <tr>
 <td style='width:30%;'>Nomor Telepon</td>
 <td style='width:2px;'>:</td>
 <td>".$row['notelp_perusahaan']."</td>
 </tr>
 <tr>
 <td style='width:30%;'>Alamat Pabrik/Gudang</td>
 <td style='width:2px;'>:</td>
 <td>".$row['alamat_gudang']."</td>
 </tr>
 <tr>
 <td style='width:30%;'>Nomor Telepon</td>
 <td style='width:2px;'>:</td>
 <td>".$row['notelp_gudang']."</td>
 </tr>
  <tr>
 <td style='width:30%;'>Jenis Pangan/Kemasan</td>
 <td style='width:2px;'>:</td>
 <td>".$pangan."</td>
 </tr>
 <tr>
 <td style='width:30%;'>Contact Person</td>
 <td style='width:2px;'>:</td>
 <td>".$row['nama_cp']."<br>".$row['notelp_cp']."</td>
 </tr>
 </table><br>
 ";
 $html .= "<table border=0 width=100% style='font-family: Arial, Helvetica, sans-serif; margin-left:20px;'>
 <tr>
 <td>Permohonan ini disertai dengan lampiran-lampiran :</td>
 </tr>
 </table>
 ";

 $query_doc = $conn -> query("SELECT * FROM tbl_doc_psb_pangan INNER JOIN tbl_doc ON tbl_doc_psb_pangan.id_doc=tbl_doc.id_doc WHERE id_psb = '".$id."'");
 $html .= "<table>
 			<tr style='background-color:#bdc3c7; font-family: Arial, Helvetica, sans-serif;'>
 			<th style='width:80%; text-align:center; padding:5px 0;'>Jenis Dokumen</th>
 			<th style='text-align:center; padding:5px 0;'>Status</th>
 			</tr>
 			";
 while($row_doc=mysqli_fetch_array($query_doc)){
 	$html.="<tr style='background-color:#ecf0f1; font-family: Arial, Helvetica, sans-serif;'>
 			<td style='padding:5px 20px;'>".$row_doc['jenis_doc']." ".$row_doc['ket_doc']."</td>
 			<td style='padding:5px; text-align:center;'>".$row_doc['status'] = '1' ? 'Lengkap' : 'Belum Lengkap'."</td>
 			</tr>
 	";
 }
 $html .= "</table><br>";

$query_tgl = $conn -> query("SELECT * FROM tbl_tgl_psb WHERE id_psb = '".$id."'");
$row_tgl=mysqli_fetch_array($query_tgl);
$tanggal = date('d-m-Y', strtotime($row_tgl['tanggal_psb']));

 $html .= "<table border=0 width=100% style='font-family: Arial, Helvetica, sans-serif; margin-left:20px;'>
 <tr>
 <td>Perusahaan Kami siap diperiksa pada tanggal ".$tanggal."</td>
 </tr>
 </table><br>
 ";

 $html .= "<table border=0 width=100% style='font-family: Arial, Helvetica, sans-serif; margin-left:20px;'>
 <tr>
 <td>Demikian permohonan kami. Atas perhatiannya, kami mengucapkan terima kasih.</td>
 </tr>
 </table><br>
 ";

 $html .= "<table border=0 width=100% style='font-family: Arial, Helvetica, sans-serif; margin-left:20px;'>
 <tr>
 <td style='width:60%;'></td>
 <td style='text-align:center;'>Hormat Kami,</td>
 </tr>
 <tr>
 <td></td>
 <td style='text-align:center;'><br><br>TTD<br><br><br></td>
 </tr>
 <tr>
 <td></td>
 <td style='text-align:center;'>".$row['nama_detail']."</td>
 </tr>
 </table>
 ";

$html .= "</html>";
$dompdf->loadHtml($html, 'UTF-8');
// Setting ukuran dan orientasi kertas
$dompdf->setPaper('Legal', 'potrait');
// Rendering dari HTML Ke PDF
$dompdf->render();
// Melakukan output file Pdf
$dompdf->stream('Efektifitas Pelatihan - '.$row['id_psb'].'.pdf', array("Attachment" => false));
?>