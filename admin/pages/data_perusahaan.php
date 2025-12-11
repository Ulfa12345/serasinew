<?php
// 1. Panggil Logic & Security
include '../layouts/init.php';

// 2. Panggil Header HTML (Head, CSS) - *Asumsi Anda sudah punya file header.php*
include '../layouts/header.php';
?>
<div id="content">

    <?php include '../layouts/topbar.php'; ?>
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Data Perusahaan</h1>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Perusahaan Terdaftar</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <?php
                    // 1. KONEKSI SUDAH TERSEDIA (Dari init.php)
                    // Jadi langsung pakai variabel $conn saja.
                    //die(var_dump($conn));
                    $query = "SELECT * FROM tb_perusahaan ORDER BY id_perusahaan DESC";
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
                                <th>NIB</th>
                                <th>Nama Perusahaan</th>
                                <th>Alamat</th>
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
                                    <td><?= htmlspecialchars($row['nib']); ?></td>
                                    <td><?= htmlspecialchars($row['nama_perusahaan']); ?></td>
                                    <td><?= htmlspecialchars($row['alamat_perusahaan']); ?></td>
                                    <td>
                                        <a href="detail_perusahaan.php?id=<?= $row['id_perusahaan'] ?>" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> Detail
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

<?php include '../layouts/footer.php'; ?>
<?php
// Kita simpan script khusus halaman ini ke dalam variabel PHP
// Nanti variabel $script_js ini akan dipanggil oleh Footer.php
$script_js = <<<HTML
    <link href="../../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    
    <script src="../../assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#tampilPerusahaan").DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json"
                }
            });
        });
    </script>
HTML;
?>