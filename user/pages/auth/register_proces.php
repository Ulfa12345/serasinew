<?php
include "../../../conf/conn.php";
require '../../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_POST) {
    $email = $_POST['email'];
    $nib = $_POST['nib'];
    $nama_perush = $_POST['nama_perush'];
    $alamat_perush = $_POST['alamat_perush'];
    $pwd = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama = $_POST['nama'];        // Nama PIC
    $notelp = $_POST['no_wa'];     // No. WA PIC

    // Validasi field kosong
    if (empty($email) || empty($nib) || empty($pwd) || empty($nama) || empty($notelp) || empty($nama_perush) || empty($alamat_perush)) {
        echo '<script>alert("Semua field wajib diisi!"); window.history.back();</script>';
        exit;
    }

    // Cek apakah NIB sudah terdaftar
    $check = $conn->prepare("SELECT nib FROM tb_perusahaan WHERE nib = ?");
    $check->bind_param("s", $nib);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo '<script>alert("NIB sudah terdaftar!"); window.history.back();</script>';
        exit;
    }

    // Simpan ke database
    $sql = "INSERT INTO tb_perusahaan (nib, nama_perusahaan, alamat_perusahaan, email, nama_pic, no_wa_pic, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssssss", $nib, $nama_perush, $alamat_perush, $email, $nama, $notelp, $pwd);

        if ($stmt->execute()) {
            // ✅ Kirim WhatsApp
            $token = "0Twh4hBkcwrMHifcVUuLRzkrcWgvMX87pkncHgiF1kth1VIQ4RcSB5TPVwg8BFXb";
            $secret_key = ".XOrMxRzX";
            $auth = "$token.$secret_key";

            $waMessage = "Halo $nama, akun Anda berhasil didaftarkan ke sistem SERASI.";

            $data = [[
                "phone" => $notelp,
                "message" => $waMessage,
                "secret" => false,
                "priority" => false,
                "isGroup" => false
            ]];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://jogja.wablas.com/api/send-message");
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: $auth",
                "Content-Type: application/json"
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $err = curl_error($ch);
            curl_close($ch);

            echo "<pre>";
            echo "HTTP Code: $httpCode\n";
            echo "cURL Error: $err\n";
            echo "API Response:\n$response\n</pre>";

            // ✅ Kirim Email
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
                echo "Email berhasil dikirim.";
            } catch (Exception $e) {
                echo "Email gagal: {$mail->ErrorInfo}";
            }

            // Redirect jika perlu
            // echo "<script>alert('Pendaftaran berhasil!'); window.location.href='../../login.php';</script>";
        } else {
            echo "Gagal menyimpan data: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Gagal mempersiapkan pernyataan SQL.";
    }

    $conn->close();
}
?>
