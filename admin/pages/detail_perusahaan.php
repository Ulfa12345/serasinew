<?php
include '../layouts/init.php';
include '../layouts/header.php';
?>
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
<div id="content">
    <?php include '../layouts/topbar.php'; ?>
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

                        <!-- Tombol Edit
                    <button class="btn btn-warning" data-toggle="modal" data-target="#editPerusahaanModal">
                        <i class="fas fa-edit"></i> Edit Data Perusahaan
                    </button> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3>Dokumen</h3>
            </div>
            <div class="card-body bg-soft-success">
                <div class="row g-3">

                    <div class="col-md-6 mb-4">
                        <div class="p-3 bg-white rounded border border-success h-100">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <div class="bg-light p-3 rounded text-danger">
                                        <i class="fas fa-file-pdf fa-2x"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold text-dark mb-1">Dokumen NIB</h6>
                                    <p class="text-muted small mb-2">Nomor Induk Berusaha</p>
                                    <a href="../../uploads/<?= $data['upload_nib'] ?>" target="_blank" class="btn btn-sm btn-outline-success w-100">
                                        <i class="fas fa-eye me-1"></i> Lihat Dokumen
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-4">
                        <div class="p-3 bg-white rounded border border-success h-100">
                            <div class="d-flex align-items-start">
                                <div class="me-3">
                                    <div class="bg-light p-3 rounded text-danger">
                                        <i class="fas fa-file-pdf fa-2x"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold text-dark mb-1">Ijin PBF</h6>
                                    <p class="text-muted small mb-2">Izin Pedagang Besar Farmasi</p>
                                    <a href="../../uploads/<?= $data['upload_ijin_pbf'] ?>" target="_blank" class="btn btn-sm btn-outline-success w-100">
                                        <i class="fas fa-eye me-1"></i> Lihat Dokumen
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 bg-white rounded border border-success h-100">
                            <div class="d-flex align-items-start mb-2">
                                <div class="me-3">
                                    <div class="bg-light p-3 rounded text-danger">
                                        <i class="fas fa-file-pdf fa-2x"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold text-dark mb-1">Dokumen SIPA</h6>
                                    <p class="text-muted small mb-0">Surat Izin Praktik Apoteker</p>
                                </div>
                            </div>
                            <hr class="my-2 text-muted">
                            <div class="small text-muted mb-2">
                                <div class="d-flex justify-content-between">
                                    <span>Nomor:</span>
                                    <span class="fw-bold text-dark"><?= $data['no_sipa'] ?></span>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <span>Berlaku s/d:</span>
                                    <span class="fw-bold text-dark"><?= date('d M Y', strtotime($data['tgl_berlaku_sipa'])) ?></span>
                                </div>
                            </div>
                            <a href="../../uploads/<?= $data['upload_sipa'] ?>" target="_blank" class="btn btn-sm btn-outline-success w-100 mt-1">
                                <i class="fas fa-eye me-1"></i> Lihat Dokumen
                            </a>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 bg-white rounded border border-success h-100">
                            <div class="d-flex align-items-start mb-2">
                                <div class="me-3">
                                    <div class="bg-light p-3 rounded text-danger">
                                        <i class="fas fa-file-pdf fa-2x"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="fw-bold text-dark mb-1">Sertifikat CDOB</h6>
                                    <p class="text-muted small mb-0">Cara Distribusi Obat yang Baik</p>
                                </div>
                            </div>
                            <hr class="my-2 text-muted">
                            <div class="small text-muted mb-2">
                                <div class="d-flex justify-content-between">
                                    <span>Nomor:</span>
                                    <span class="fw-bold text-dark"><?= $data['nomor_cdob'] ?></span>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <span>Berlaku s/d:</span>
                                    <span class="fw-bold text-dark"><?= date('d M Y', strtotime($data['tgl_berlaku_cdob'])) ?></span>
                                </div>
                            </div>
                            <a href="../../uploads/<?= $data['upload_cdob'] ?>" target="_blank" class="btn btn-sm btn-outline-success w-100 mt-1">
                                <i class="fas fa-eye me-1"></i> Lihat Dokumen
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Form Tambah Gudang Section -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h3>Data Gudang</h3>
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
                                <th>File SIPA APJ</th>
                                <th>No SIPA APJ Gudang</th>
                                <th>Tanggal Berlaku</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1;
                            while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($row['nama_gudang']); ?></td>
                                    <td><?= htmlspecialchars($row['alamat_gudang']); ?></td>
                                    <td>
                                        <?php if (!empty($row['file_sipa_apj_gudang'])) : ?>
                                            <a href="../../uploads/sipa_apj_gudang/<?= htmlspecialchars($row['file_sipa_apj_gudang']); ?>"
                                                target="_blank" class="btn btn-sm btn-info">
                                                Lihat File
                                            </a>
                                        <?php else : ?>
                                            <span class="text-muted">- Tidak ada file -</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($row['no_sipa_apj_gudang']); ?></td>
                                    <td><?= htmlspecialchars($row['tgl_sipa_apj_gudang']); ?></td>

                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<?php include '../layouts/footer.php'; ?>