<?php
header('Content-Type: application/json');
include "../../../conf/conn.php";
require '../../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$response = ['success' => false]; // default


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $nib = $_POST['nib'] ?? '';
    $nama_perush = $_POST['nama_perush'] ?? '';
    $alamat_perush = $_POST['alamat_perush'] ?? '';
    $pwd = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);
    $nama = $_POST['nama'] ?? '';
    $notelp = $_POST['no_wa'] ?? '';

    // Validasi field kosong
    if (empty($email) || empty($nib) || empty($pwd) || empty($nama) || empty($notelp) || empty($nama_perush) || empty($alamat_perush)) {
        $response['message'] = 'Semua field wajib diisi!';
        echo json_encode($response);
        exit;
    }

    // Cek apakah NIB sudah terdaftar
    $check = $conn->prepare("SELECT nib FROM tb_perusahaan WHERE nib = ?");
    $check->bind_param("s", $nib);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        $response['message'] = 'NIB sudah terdaftar!';
        echo json_encode($response);
        exit;
    }

    // Simpan ke database
    $sql = "INSERT INTO tb_perusahaan (nib, nama_perusahaan, alamat_perusahaan, email, nama_pic, no_wa_pic, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssssss", $nib, $nama_perush, $alamat_perush, $email, $nama, $notelp, $pwd);

        if ($stmt->execute()) {
            // Kirim WhatsApp
            // $token = '0Twh4hBkcwrMHifcVUuLRzkrcWgvMX87pkncHgiF1kth1VIQ4RcSB5TPVwg8BFXb';
            // $secret_key = '.XOrMxRzX';
            // $auth = "0Twh4hBkcwrMHifcVUuLRzkrcWgvMX87pkncHgiF1kth1VIQ4RcSB5TPVwg8BFXb.XOrMxRzX";

            $waMessage = "Halo $nama, akun Anda telah didaftarkan ke sistem SERASI. Selanjutnya silahkan login dan lengkapi dokumen data dukungnya";

            if (substr($notelp, 0, 1) === '0') {
                $notelp = substr($notelp, 1);
            }

            // Tambahkan kode negara (62 untuk Indonesia)
            $notelp = '62' . $notelp;

            // $curl = curl_init();
            $token = "0Twh4hBkcwrMHifcVUuLRzkrcWgvMX87pkncHgiF1kth1VIQ4RcSB5TPVwg8BFXb";
            $secret_key = ".XOrMxRzX";
            $apiUrl = 'https://jogja.wablas.com/api/send-message';
            $data = [
                'phone' => $notelp,
                'message' => $waMessage,
                // "secret" => false,
                // "priority" => true,
                // "isGroup" => false,
            ];


            $curl = curl_init($apiUrl);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                'Content-Type: application/x-www-form-urlencoded',
                'Authorization: ' . $token . $secret_key
            ]);
            // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec($curl);
            curl_close($curl);
            //die(var_dump($result,  $notelp))
            // echo "<pre>";
            // print_r($result);



            // Kirim Email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'faulfa162@gmail.com';
                $mail->Password = 'jial pzop murw pgow'; // App password Gmail
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('faulfa162@gmail.com', 'Admin SERASI');
                $mail->addAddress($email, $nama);

                $mail->isHTML(true);
                $mail->Subject = 'Informasi Akun SERASI';
                $mail->Body = "Halo <b>$nama</b>,<br><br>Akun Anda berhasil didaftarkan.<br>
                               <b>NIB:</b> $nib<br>
                               Silakan login dan segera upload dokumen untuk pengajuan konsultasi denah perusahaan Anda.<br><br>Terima kasih.";

                $mail->send();
            } catch (Exception $e) {
                $response['message'] = 'Email gagal dikirim: ' . $mail->ErrorInfo;
                // tetap dianggap sukses jika hanya email gagal
            }

            $response['success'] = true;
        } else {
            $response['message'] = 'Gagal menyimpan data: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $response['message'] = 'Gagal mempersiapkan pernyataan SQL.';
    }

    $conn->close();
} else {
    $response['message'] = 'Metode tidak diperbolehkan.';
}

echo json_encode($response);
