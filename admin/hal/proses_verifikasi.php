<?php
session_start();
header('Content-Type: application/json');

include "../../conf/conn.php";

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'msg' => 'Database Error!', 'error' => $conn->connect_error]);
    exit;
}

 // Mengambil data dari AJAX
$id = $_POST['id']; // id dokumen
$status = $_POST['status']; // 1 = Disetujui, 0 = Ditolak
$note = $_POST['note']; // catatan

$stmt = $conn->prepare("UPDATE tb_dokumen SET status = ?, catatan = ?, tanggal_pengajuan = NOW() WHERE id_dok = ?");
$stmt->bind_param("isi", $status, $note, $id);

if ($stmt->execute()) {
    // Dapat nomor WhatsApp perusahaan terkait dokumen
    $query = mysqli_query($conn,"SELECT d.id_perusahaan, p.no_wa_pic, p.nama_perusahaan
                                   FROM tb_dokumen d
                                   JOIN tb_perusahaan p ON d.id_perusahaan = p.id_perusahaan
                                   WHERE d.id_dok = $id");

    $data = mysqli_fetch_assoc($query);
    $notelp = $data['no_wa_pic']; // nomor WhatsApp yang akan diberitahu
    $nama_perusahaan = $data['nama_perusahaan'];

    // Pesan WhatsApp yang akan dikirim
    $waMessage = "Proses dokumen nomor di $nama_perusahaan telah selesai.";

    // Kirim pesan WhatsApp
    $token = "0Twh4hBkcwrMHifcVUuLRzkrcWgvMX87pkncHgiF1kth1VIQ4RcSB5TPVwg8BFXb";
    $secret_key = ".XOrMxRzX";

    $apiUrl = 'https://jogja.wablas.com/api/send-message';
    $postData = [
        'phone' => $notelp,
        'message' => $waMessage,
    ];

    $curl = curl_init($apiUrl);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($postData));

    curl_setopt($curl, CURLOPT_HTTPHEADER, [
        'Content-Type: application/x-www-form-urlencoded',
        'Authorization: ' . $token . $secret_key,
    ]);
    // Uncomment jika terjadi masalah sertifikat
    //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

    $result = curl_exec($curl);
    if (curl_errno($curl)) {
        echo json_encode(['success' => true, 'msg' => 'Verifikasi disimpan, tapi pesan WhatsApp gagal!', 'error' => curl_error($curl)]);
    } else {
        echo json_encode(['success' => true, 'msg' => 'Verifikasi disimpan dan WhatsApp terkirim!']);
    }
    curl_close($curl);
} else {
    echo json_encode(['success' => false, 'msg' => 'Gagal menyimpan!', 'error' => $stmt->error]);
}

$stmt->close();
$conn->close();

?>
