<?php
include "../../../conf/conn.php";

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $stmt = $conn->prepare("SELECT * FROM password_resets WHERE token = ?");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Token tidak valid.");
    }

    $row = $result->fetch_assoc();
    if (strtotime($row['expires_at']) < time()) {
        die("Token sudah kadaluarsa.");
    }
} else {
    die("Token tidak disertakan.");
}
?>

<form action="update_password.php" method="POST">
    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
    <label>Password Baru</label>
    <input type="password" name="password" required>
    <button type="submit">Reset Password</button>
</form>