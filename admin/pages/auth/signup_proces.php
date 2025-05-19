<?php
include "../../../conf/conn.php";

if ($_POST) {
    // Ambil data dari form
    $email = $_POST['email'] ?? '';
    $nib = $_POST['nib'] ?? '';
    $pwd = $_POST['password'] ?? '';
    $nama = $_POST['nama'] ?? '';
    $notelp = $_POST['no_wa'] ?? '';

    // Validasi dasar
    if (empty($email) || empty($nib) || empty($pwd) || empty($nama) || empty($notelp)) {
        echo '<script>alert("Semua field wajib diisi!"); window.history.back();</script>';
        exit;
    }

    // SQL untuk insert user
    $sql = "INSERT INTO tb_client(nib, nama_pic, password, email, no_wa_pic, role) 
            VALUES (?, ?, ?, ?, ?, 'user')";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssss", $nib, $nama, $pwd, $email, $notelp);

        if ($stmt->execute()) {
            // Kirim WhatsApp jika insert berhasil
            $token = '0Twh4hBkcwrMHifcVUuLRzkrcWgvMX87pkncHgiF1kth1VIQ4RcSB5TPVwg8BFXb';
            $to = $notelp;
            $message = "Halo $nama, akun Anda telah berhasil didaftarkan di sistem SERASI. NIB: $nib, Email: $email.";

            $data = [
                'phone' => $to,
                'message' => $message,
                'secret' => false,
                'priority' => false,
                'isGroup' => false,
            ];

            $url = 'https://jogja.wablas.com/api/v2/send-message';
            $curl = curl_init();

            curl_setopt($curl, CURLOPT_HTTPHEADER, [
                "Authorization: $token",
                "Content-Type: application/json"
            ]);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {
                echo "<script>alert('Pendaftaran berhasil, tapi WhatsApp gagal terkirim: $err'); window.location.href='../../login.php';</script>";
            } else {
                echo "<script>alert('Pendaftaran berhasil dan pesan WA terkirim!'); window.location.href='../../login.php';</script>";
            }
        } else {
            echo "Error saat menyimpan ke database: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Gagal mempersiapkan statement SQL.";
    }

    $conn->close();
}
?>
