<?php
$connPath = __DIR__ . '/../../conf/conn.php';

if (isset($_GET['id'])) {
    $id_perusahaan = $_GET['id'];

    $sql = "SELECT * FROM tb_perusahaan WHERE id_perusahaan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_perusahaan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
    } else {
        echo "Data perusahaan tidak ditemukan.";
        exit;
    }
} else {
    echo "ID perusahaan tidak disertakan di URL.";
    exit;
}
?>

<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">PROFIL PERUSAHAAN</h1>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <!-- Kolom 1 -->
                <div class="col-sm-6">
                    <!-- NIB -->
                    <div class="form-group row mb-3">
                        <label for="nib" class="col-sm-4 col-form-label">NIB</label>
                        <div class="col-sm-8">
                            <input type="text" name="nib" class="form-control-plaintext form-control-user"
                                id="nib" value="<?= htmlspecialchars($data['nib']); ?>" disabled>
                        </div>
                    </div>

                    <!-- Nama Perusahaan -->
                    <div class="form-group row mb-3">
                        <label for="nama_perusahaan" class="col-sm-4 col-form-label">Nama Perusahaan</label>
                        <div class="col-sm-8">
                            <input type="text" name="nama_perusahaan" class="form-control-plaintext form-control-user"
                                id="nama_perusahaan" value="<?= htmlspecialchars($data['nama_perusahaan']); ?>" disabled>
                        </div>
                    </div>

                    <!-- Alamat -->
                    <div class="form-group row mb-3">
                        <label for="alamat_perusahaan" class="col-sm-4 col-form-label">Alamat Perusahaan</label>
                        <div class="col-sm-8">
                            <input type="text" name="alamat_perusahaan" class="form-control-plaintext form-control-user"
                                id="alamat_perusahaan" value="<?= htmlspecialchars($data['alamat_perusahaan']); ?>" disabled>
                        </div>
                    </div>

                    <!-- Dokumen NIB -->
                    <div class="form-group row mb-3">
                        <label class="col-sm-4 col-form-label">Dokumen NIB</label>
                        <div class="col-sm-8">
                            <?php if (!empty($data['upload_nib'])): ?>
                                <?php
                                $file_ext = pathinfo($data['upload_nib'], PATHINFO_EXTENSION);
                                $server_path = $_SERVER['DOCUMENT_ROOT'] . '/serasi/user/upload/nib/' . basename($data['upload_nib']);
                                $web_path = '/serasi/user/upload/nib/' . basename($data['upload_nib']);
                                ?>
                                <?php if (file_exists($server_path)): ?>
                                    <?php if (in_array($file_ext, ['jpg', 'jpeg', 'png'])): ?>
                                        <img src="<?= $web_path ?>" class="img-fluid rounded mb-2 preview-doc" alt="Preview NIB" style="max-height: 200px">
                                    <?php elseif ($file_ext === 'pdf'): ?>
                                        <iframe src="<?= $web_path ?>#toolbar=0&navpanes=0" style="width:100%; height:200px;" frameborder="0"></iframe>
                                    <?php endif; ?>
                                    <div class="mt-2">
                                        <a href="<?= $web_path ?>" target="_blank" class="btn btn-sm btn-primary">
                                            <i class="fas fa-expand"></i> Fullscreen
                                        </a>
                                        <a href="<?= $web_path ?>" download class="btn btn-sm btn-success">
                                            <i class="fas fa-download"></i> Download
                                        </a>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-danger py-1">
                                        <i class="fas fa-times-circle"></i> File tidak ditemukan di server
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <div class="text-muted">
                                    <i class="fas fa-exclamation-circle"></i> Belum ada dokumen terupload
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Kolom 2 -->
                <div class="col-sm-6">
                    <!-- PIC -->
                    <div class="form-group row mb-3">
                        <label for="nama_pic" class="col-sm-4 col-form-label">Penanggung Jawab</label>
                        <div class="col-sm-8">
                            <input type="text" name="nama_pic" class="form-control-plaintext form-control-user"
                                id="nama_pic" value="<?= htmlspecialchars($data['nama_pic']); ?>" disabled>
                        </div>
                    </div>

                    <!-- No WA -->
                    <div class="form-group row mb-3">
                        <label for="no_wa_pic" class="col-sm-4 col-form-label">No. Telepon/HP</label>
                        <div class="col-sm-8">
                            <input type="tel" name="no_wa_pic" class="form-control-plaintext form-control-user"
                                id="no_wa_pic" value="<?= htmlspecialchars($data['no_wa_pic']); ?>" disabled>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group row mb-3">
                        <label for="email" class="col-sm-4 col-form-label">Email</label>
                        <div class="col-sm-8">
                            <input type="email" name="email" class="form-control-plaintext form-control-user"
                                id="email" value="<?= htmlspecialchars($data['email']); ?>" disabled>
                        </div>
                    </div>

                    <!-- Tombol Edit -->
                    <button class="btn btn-warning" data-toggle="modal" data-target="#editPerusahaanModal">
                        <i class="fas fa-edit"></i> Edit Data Perusahaan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Tambah Gudang Section -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahGudangModal">
                + Tambah Gudang
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <?php
                $query = "SELECT g.*, p.nama_perusahaan 
                        FROM tb_gudang g
                        INNER JOIN tb_perusahaan p 
                        ON g.id_perusahaan = p.id_perusahaan 
                        WHERE g.id_perusahaan = ?
                        ORDER BY g.id_gudang DESC";

                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $id_perusahaan);
                $stmt->execute();
                $result = $stmt->get_result();

                if (!$result) {
                    die("Error menampilkan data: " . $koneksi->error);
                }
                ?>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Gudang</th>
                            <th>Alamat</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                        while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= htmlspecialchars($row['nama_gudang']); ?></td>
                                <td><?= htmlspecialchars($row['alamat_gudang']); ?></td>
                                <td><?= htmlspecialchars($row['keterangan']); ?></td>
                                <td>
                                    <button class="btn btn-warning btn-edit"
                                        data-id="<?= $row['id_gudang'] ?>"
                                        data-nama="<?= htmlspecialchars($row['nama_gudang']) ?>"
                                        data-alamat="<?= htmlspecialchars($row['alamat_gudang']) ?>"
                                        data-keterangan="<?= htmlspecialchars($row['keterangan']) ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>