<?php
include '../layouts/init.php';

// Validasi ID untuk keamanan
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id <= 0) {
    header("Location: data_user.php"); // Redirect jika ID tidak valid
    exit;
}

$query = "SELECT * FROM tb_admin WHERE id_admin=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if (!$data) {
    die("Data admin tidak ditemukan.");
}

include '../layouts/header.php';
?>

<div id="content">
    <?php include '../layouts/topbar.php'; ?>

    <div class="container-fluid">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-user-edit mr-2"></i> Edit Pengguna
                    </h6>
                </div>
                <div class="card-body">
                    <form action="proses_edit_user.php" method="POST">
                        <input type="hidden" name="id_admin" value="<?= $data['id_admin'] ?>">

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">NIP / Username</label>
                                <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($data['username']) ?>" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">No HP</label>
                                <input type="text" name="no_hp" class="form-control" value="<?= htmlspecialchars($data['no_hp']) ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label class="font-weight-bold">Role Akses</label>
                                <select name="role" class="form-control custom-select" required>
                                    <option value="superadmin" <?= $data['role'] == 'superadmin' ? 'selected' : '' ?>>Superadmin</option>
                                    <option value="supervisor" <?= $data['role'] == 'supervisor' ? 'selected' : '' ?>>Supervisor</option>
                                    <option value="petugas" <?= $data['role'] == 'petugas' ? 'selected' : '' ?>>Petugas</option>
                                </select>
                            </div>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label class="font-weight-bold text-danger">Ubah Password</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                            <small id="passwordHelp" class="form-text text-muted mt-2">
                                Ketentuan: Minimal 6 karakter (Huruf Besar, Huruf Kecil, Angka, & Simbol).
                            </small>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-save mr-1"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    const passwordField = document.getElementById('password');
    const passwordHelp = document.getElementById('passwordHelp');
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/;

    passwordField.addEventListener('input', function() {
        const password = passwordField.value;

        if (password === "") {
            passwordField.classList.remove('is-invalid', 'is-valid');
            passwordHelp.textContent = "Kosongkan jika tidak ingin mengubah password.";
            passwordHelp.className = "form-text text-muted mt-2";
            return;
        }

        if (passwordRegex.test(password)) {
            passwordField.classList.remove('is-invalid');
            passwordField.classList.add('is-valid');
            passwordHelp.textContent = "Password sudah sesuai ketentuan.";
            passwordHelp.className = "form-text text-success font-weight-bold mt-2";
        } else {
            passwordField.classList.remove('is-valid');
            passwordField.classList.add('is-invalid');
            passwordHelp.textContent = "Belum sesuai ketentuan (Besar, Kecil, Angka, Simbol, Min 6 Karakter).";
            passwordHelp.className = "form-text text-danger font-weight-bold mt-2";
        }
    });
</script>

<?php include '../layouts/footer.php'; ?>