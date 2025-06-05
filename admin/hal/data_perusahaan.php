<div class="container-fluid">
    <!-- Form Tambah Gudang Section -->
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="table-responsive">
                <?php

                // Query dengan JOIN ke tabel perusahaan dan filter session
                $query = "SELECT p.*
                        FROM tb_perusahaan p
                        ORDER BY p.id_perusahaan DESC";

                // Menggunakan prepared statement
                $stmt = $conn->prepare($query);
                //$stmt->bind_param("i", $id_perusahaan);
                $stmt->execute();
                $result = $stmt->get_result();

                // Tampilkan error jika query gagal
                if (!$result) {
                    die("Error menampilkan data: " . $conn->error);
                }
                ?>

                <!-- Tampilan HTML -->
                <table class="table table-bordered" id="tampilPerusahaan">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIB</th>
                            <th>Nama Perusahaan</th>
                            <th>Alamat Perusahaan</th>
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
                                    <a href="index.php?pageadmin=detail_perusahaan&id=<?= $row['id_perusahaan'] ?>" class="btn btn-primary">
                                        <i class="fas fa-list"></i> Lihat Detail
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

<link rel="stylesheet" href="vendor/datatables/dataTables.bootstrap4.min.css">
<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function() {
        $('#tampilPerusahaan').DataTable({
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                paginate: {
                    previous: "Sebelumnya",
                    next: "Berikutnya"
                }
            },
            responsive: true,
            info: true,
            ordering: true,
            paging: true,
        });
    });
</script>