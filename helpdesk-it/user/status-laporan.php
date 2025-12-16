<?php 
include '../config.php';
if(!isset($_SESSION['user']) || $_SESSION['role']!='karyawan') header('Location: ../login.php');

$id_user = $_SESSION['user'];

// PROSES HAPUS LAPORAN
if(isset($_GET['hapus'])) {
    $id_hapus = (int)$_GET['hapus'];
    // Cek apakah laporan milik user ini dan belum selesai
    $cek = mysqli_query($koneksi, "SELECT id FROM laporan WHERE id=$id_hapus AND id_user=$id_user AND status!='Selesai'");
    if(mysqli_num_rows($cek)>0) {
        mysqli_query($koneksi, "DELETE FROM laporan WHERE id=$id_hapus");
        echo "<script>alert('Laporan berhasil dihapus!'); window.location='status-laporan.php';</script>";
    }
}

// Pagination + hanya yang belum selesai
$limit = 10;
$page  = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total = mysqli_fetch_assoc(mysqli_query($koneksi, 
    "SELECT COUNT(*) as jml FROM laporan WHERE id_user=$id_user AND status!='Selesai'"))['jml'];
$total_pages = ceil($total / $limit);

$data = mysqli_query($koneksi, 
    "SELECT * FROM laporan WHERE id_user=$id_user AND status!='Selesai' ORDER BY tgl_buat DESC LIMIT $limit OFFSET $offset");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Status Laporan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    body{background:#f8f9fa}
    #content{transition:margin-left .3s}
    @media(min-width:992px){#content{margin-left:250px}}
    .badge-status{padding:.5em 1em;border-radius:50px;font-size:.85em}
    .btn-hapus{color:#dc3545}
    .btn-hapus:hover{color:#c82333}
  </style>
</head>
<body>
  <?php include '../template/sidebar.php'; ?>
  <div id="content" class="p-4">

    <h3 class="mb-4">Status Laporan</h3>

    <div class="card shadow-sm">
      <div class="card-body">

        <?php if(mysqli_num_rows($data)==0): ?>
          <div class="text-center py-5">
            <h5 class="text-success">Tidak ada laporan yang sedang diproses</h5>
            <p class="text-muted">Semua laporan sudah selesai atau belum ada laporan baru.</p>
            <a href="riwayat.php" class="btn btn-primary">Lihat Riwayat</a>
          </div>
        <?php else: ?>
          <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th width="80">No.</th>
                  <th>Masalah</th>
                  <th>Status</th>
                  <th>Tanggal</th>
                  <th width="150">Detail</th>
                </tr>
              </thead>
              <tbody>
                <?php $no = $offset + 1; while($r = mysqli_fetch_assoc($data)): ?>
                <tr>
                  <td><?= $no++ ?></td>
                  <td><?= htmlspecialchars($r['masalah']) ?></td>
                  <td>
                    <?php if($r['status']=='Menunggu'): ?>
                      <span class="badge bg-warning text-dark badge-status">Menunggu</span>
                    <?php else: ?>
                      <span class="badge bg-info text-white badge-status">Diproses</span>
                    <?php endif; ?>
                  </td>
                  <td><?= date('d/m/y', strtotime($r['tgl_buat'])) ?></td>
                  <td>
                    <a href="detail-laporan.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-outline-primary">Lihat</a>
                    <a href="?hapus=<?= $r['id'] ?>" 
                       class="btn btn-sm btn-hapus" 
                       onclick="return confirm('Yakin ingin menghapus laporan ini?\nLaporan yang sudah dihapus tidak dapat dikembalikan.')">
                      <i class="bi bi-trash-fill"></i>
                    </a>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <?php if($total_pages > 1): ?>
          <nav class="mt-4">
            <ul class="pagination justify-content-center">
              <li class="page-item <?= $page<=1?'disabled':'' ?>"><a class="page-link" href="?page=<?= $page-1 ?>">&laquo;</a></li>
              <?php for($i=1;$i<=$total_pages;$i++): ?>
              <li class="page-item <?= $i==$page?'active':'' ?>"><a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a></li>
              <?php endfor; ?>
              <li class="page-item <?= $page>=$total_pages?'disabled':'' ?>"><a class="page-link" href="?page=<?= $page+1 ?>">&raquo;</a></li>
            </ul>
          </nav>
          <?php endif; ?>

        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>