<?php
session_start();
include "../../../conf/conn.php"; // Sesuaikan path

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $targetDir = "user/pages/upload/nib";
    $allowedTypes = ['pdf', 'jpg', 'png'];
    $maxSize = 10 * 1024 * 1024; // 5MB
    $companyId = $_SESSION['id_perusahaan'];

    
    // Validasi file
    if(isset($_FILES['upload_nib'])) {
        $file = $_FILES['upload_nib'];
        $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        
        if(in_array($fileExt, $allowedTypes)) {
            if($file['size'] <= $maxSize) {
                // Generate nama file unik
                $newFileName = uniqid('nib_') . '.' . $fileExt;
                $targetPath = $targetDir . $newFileName;
                
                if(move_uploaded_file($file['tmp_name'], $targetPath)) {
                    // Update database
                    $query = "UPDATE tb_perusahaan SET upload_nib = ? WHERE id_perusahaan = ?";
                    $stmt = $conn->prepare($query);
                    $stmt->bind_param("si", $newFileName, $companyId);
                    
                    if($stmt->execute()) {
                        echo "<script>alert('Dokumen NIB berhasil ditambahkan'); window.location.href='../../index.php?page=datagudang';</script>";
                    } else {
                        header("Location: profil.php?status=dberror");
                    }
                }
            } else {
                header("Location: profil.php?status=sizeerror");
            }
        } else {
            header("Location: profil.php?status=typeerror");
        }
    }
}
?>