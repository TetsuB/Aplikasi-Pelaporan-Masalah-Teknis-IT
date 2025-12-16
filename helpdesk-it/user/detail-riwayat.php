<?php
include '../config.php';

// Cek login & role
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'karyawan') {
    header('Location: ../login.php');
    exit();
}

// Validasi ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: status-laporan.php');
    exit();
}

$id = (int)$_GET['id'];

// Ambil laporan milik user sendiri
$q = mysqli_query(
    $koneksi,
    "SELECT * FROM laporan 
     WHERE id = $id 
     AND id_user = " . $_SESSION['user']
);

if (mysqli_num_rows($q) == 0) {
    header('Location: status-laporan.php');
    exit();
}

$r = mysqli_fetch_assoc($q);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Detail Riwayat Laporan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background:#f8f9fa; padding:20px; }
    .card { border-radius:16px; box-shadow:0 8px 25px rgba(0,0,0,.1); }
    .label { font-weight:600; color:#444; }
    .value { background:#fff; padding:15px 20px; border-radius:12px; border:1px solid #e2e6ea; }
    .status-badge { font-size:1.1rem; padding:.6rem 1.5rem; border-radius:50px; }
    .catatan { background:#d1e7dd; border-left:6px solid #0f5132; padding:1.2rem; border-radius:12px; }
  </style>
</head>
<body>

<div class="container">
  <h3 class="mb-4">Detail Riwayat Laporan</h3>

  <div class="card">
    <div class="card-body p-4">

      <!-- Tanggal & Status -->
      <div class="d-flex justify-content-between mb-4">
        <div>
          <div class="label">Tanggal Laporan</div>
          <div class="value fw-bold text-primary">
            <?= date('d F Y - H:i', strtotime($r['tgl_buat'])) ?> WITA
          </div>
        </div>
        <div>
          <?php if ($r['status']=='Selesai'): ?>
            <span class="badge bg-success status-badge">Selesai</span>
          <?php elseif ($r['status']=='Diproses'): ?>
            <span class="badge bg-info status-badge">Diproses</span>
          <?php else: ?>
            <span class="badge bg-warning text-dark status-badge">Menunggu</span>
          <?php endif; ?>
        </div>
      </div>

      <!-- Masalah -->
      <div class="mb-4">
        <div class="label">Masalah</div>
        <div class="value fw-bold fs-5"><?= htmlspecialchars($r['masalah']) ?></div>
      </div>

      <!-- Kategori & Lokasi -->
      <div class="row mb-4">
        <div class="col-md-6">
          <div class="label">Kategori</div>
          <div class="value"><?= $r['kategori'] ?></div>
        </div>
        <div class="col-md-6">
          <div class="label">Lokasi</div>
          <div class="value"><?= $r['lokasi'] ?: '-' ?></div>
        </div>
      </div>

      <!-- Deskripsi -->
      <div class="mb-4">
        <div class="label">Deskripsi Masalah</div>
        <div class="value" style="white-space:pre-line;">
          <?= nl2br(htmlspecialchars($r['deskripsi'])) ?>
        </div>
      </div>

      <!-- Catatan Teknisi -->
      <?php if ($r['catatan_teknisi']): ?>
      <div class="mb-4">
        <h5 class="text-success">Catatan Teknisi</h5>
        <div class="catatan">
          <?= nl2br(htmlspecialchars($r['catatan_teknisi'])) ?>
        </div>
      </div>
      <?php endif; ?>

      <div class="text-end">
        <a href="riwayat.php" class="btn btn-dark px-4">Kembali</a>
      </div>

    </div>
  </div>
</div>

</body>
</html>
