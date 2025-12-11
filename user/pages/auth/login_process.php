<?php
session_start();
header('Content-Type: application/json');
include "../../../conf/conn.php";

$response = ['success' => false, 'message' => '', 'redirect' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate inputs
    if (empty($_POST['nib']) || empty($_POST['password'])) {
        $response['message'] = 'NIB dan Password tidak boleh kosong!';
        echo json_encode($response);
        exit;
    }

    $username = $conn->real_escape_string($_POST['nib']);
    $password = $_POST['password'];

    // Prepare statement for better security
    $stmt = $conn->prepare("SELECT * FROM tb_perusahaan WHERE nib = ? LIMIT 1");
    if (!$stmt) {
        $response['message'] = 'Terjadi kesalahan sistem (SQL prepare failed)';
        echo json_encode($response);
        exit;
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $response['message'] = 'NIB tidak terdaftar atau password salah!';
        echo json_encode($response);
        exit;
    }

    $row = $result->fetch_assoc();

    if (!password_verify($password, $row['password'])) {
        $response['message'] = 'NIB tidak terdaftar atau password salah!';
        echo json_encode($response);
        exit;
    }

    // Set session variables
    $_SESSION['id_perusahaan'] = $row['id_perusahaan'];
    $_SESSION['nib'] = $row['nib'];
    $_SESSION['nama_perusahaan'] = $row['nama_perusahaan'];
    $_SESSION['logged_in'] = true;

    // Check for warehouse data
    // $id_perusahaan = $row['id_perusahaan'];
    // $gudangStmt = $conn->prepare("SELECT * FROM tb_gudang WHERE id_perusahaan = ? LIMIT 1");
    // $gudangStmt->bind_param("i", $id_perusahaan);
    // $gudangStmt->execute();
    // $gudangResult = $gudangStmt->get_result();

    // if ($gudangResult->num_rows > 0) {
    $response['success'] = true;
    // } else {
    //     $response['success'] = true;
    $response['redirect'] = 'index.php?page=dashboard';
    //     $response['message'] = 'Data Anda belum lengkap. Silahkan lengkapi data terlebih dahulu.';
    // }

    echo json_encode($response);
    exit;
} else {
    $response['message'] = 'Metode request tidak valid';
    echo json_encode($response);
    exit;
}
