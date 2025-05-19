<?php
include "../../../conf/conn.php";
require '../../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_POST) {
    $email = $_POST['email'];
    $nib = $_POST['nib'];
    $plainPassword = $_POST['password']; // disimpan sementara sebelum di-hash
    $pwd = password_hash($plainPassword, PASSWORD_DEFAULT);
    $nama = $_POST['nama'];
    $notelp = $_POST['no_wa'];
    $role = 'user';

    // Validasi
    if (empty($email) || empty($nib) || empty($plainPassword) || empty($nama) || empty($notelp)) {
        echo '<script>alert("Semua field wajib diisi!"); window.history.back();</script>';
        exit;
    }

    $sql = "INSERT INTO tb_client (nib, nama_pic, password, email, no_wa_pic, role) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssssss", $nib, $nama, $pwd, $email, $notelp, $role);

        if ($stmt->execute()) {
            // ✅ Kirim WhatsApp
            $token = "uZ9nuNtYJYgzWuMCyUTahxdd2HBU0i02JcNIAI5zsaQpVTxzECs9mGz";
            $secret_key = "2etnoEu6";
            $auth = "$token.$secret_key";

            $waMessage = "Halo $nama, akun Anda berhasil didaftarkan ke sistem SERASI.\nNIB: $nib\nSilakan login dan segera ganti password Anda.";

            $data = [
                "data" => [
                    [
                        "phone" => $notelp,
                        "message" => $waMessage,
                        "secret" => false,
                        "priority" => false,
                        "isGroup" => false
                    ]
                ]
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://texas.wablas.com/api/v2/send-message");
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
                               <b>Password:</b> $plainPassword<br><br>
                               Silakan login dan segera ganti password Anda.<br><br>Terima kasih.";

                $mail->send();
                echo "Email berhasil dikirim.";
            } catch (Exception $e) {
                echo "Email gagal: {$mail->ErrorInfo}";
            }

            // Redirect (bisa aktifkan jika perlu)
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
