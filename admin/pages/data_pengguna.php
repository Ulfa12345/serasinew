<?php
include '../layouts/init.php';
include '../layouts/header.php';
?>

<div id="content">
    <?php include '../layouts/topbar.php'; ?>
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Data Pengguna</h6>
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambahUser">
                        <i class="fas fa-plus"></i> Tambah Pengguna
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <?php
                    // 1. KONEKSI SUDAH TERSEDIA (Dari init.php)
                    // Jadi langsung pakai variabel $conn saja.
                    //die(var_dump($conn));
                    $query = "SELECT * FROM tb_admin ORDER BY id_admin DESC";
                    $stmt = $conn->prepare($query);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if (!$result) {
                        die("Error: " . $conn->error);
                    }
                    ?>

                    <table class="table table-bordered" id="tampilPerusahaan" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = $result->fetch_assoc()) :
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($row['username']); ?></td>
                                    <td><?= htmlspecialchars($row['nama']); ?></td>
                                    <td><?= htmlspecialchars($row['role']); ?></td>
                                    <td>
                                        <a href="edit_pengguna.php?id=<?= $row['id_admin'] ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <a href="hapus_pengguna.php?id=<?= $row['id_admin'] ?>"
                                            onclick="return confirm('Hapus pengguna ini?')"
                                            class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>

                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Tambah Pengguna -->
<div class="modal fade" id="modalTambahUser" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="proses_tambah_user.php" method="POST">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-group">
                        <label>NIP / Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Nama Pengguna</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>No HP</label>
                        <input type="text" name="no_hp" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                        <span id="passwordHelp" class="badge badge-warning">
                            Minimal 6 karakter, huruf besar, huruf kecil, angka, dan karakter khusus.
                        </span>
                    </div>

                    <div class="form-group">
                        <label>Role / Hak Akses</label>
                        <select name="role" class="form-control" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="superadmin">Superadmin</option>
                            <option value="supervisor">Supervisor</option>
                            <option value="petugas">Petugas</option>
                        </select>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>

            </div>
        </form>
    </div>
</div>

<script>
 const passwordField = document.getElementById('password');
    const passwordHelp = document.getElementById('passwordHelp');

    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{6,}$/;

    passwordField.addEventListener('input', function() {
      const password = passwordField.value;

      if (passwordRegex.test(password)) {
        passwordField.classList.remove('is-invalid');
        passwordField.classList.add('is-valid');
        passwordHelp.textContent = "Password sudah sesuai ketentuan.";
        passwordHelp.style.color = "green";
      } else {
        passwordField.classList.remove('is-valid');
        passwordField.classList.add('is-invalid');
        passwordHelp.textContent = "Minimal 6 karakter, harus ada huruf besar, huruf kecil, angka, dan karakter khusus.";
        passwordHelp.style.color = "red";
      }
    });
</script>
<?php include '../layouts/footer.php'; ?>