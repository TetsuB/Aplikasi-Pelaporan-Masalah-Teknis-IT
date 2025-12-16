<?php 
include '../config.php';
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: status-laporan.php');
    exit();
}

$id = (int)$_GET['id'];
$q = mysqli_query($koneksi, "SELECT * FROM laporan WHERE id = $id AND id_user = " . $_SESSION['user']);
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
  <title>Detail Laporan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; padding: 20px 15px; }
    .card { border-radius: 16px; box-shadow: 0 8px 25px rgba(0,0,0,0.1); }
    .label { font-weight: 600; color: #444; font-size: 0.95rem; }
    .value { background: #fff; padding: 16px 20px; border-radius: 12px; border: 1px solid #e2e6ea; }
    .status-badge { font-size: 1.1rem; padding: 0.7rem 1.8rem; border-radius: 50px; }
    .catatan-box { background: #d1e7dd; border-left: 6px solid #0f5132; padding: 1.5rem; border-radius: 12px; }
    @media (max-width: 576px) {
      body { padding: 10px; }
    }
  </style>
</head>
<body>

<div class="container">
  <div class="d-flex align-items-center mb-4">
    <h3 class="mb-0 text-dark">Detail Laporan</h3>
  </div>

  <div class="card">
    <div class="card-body p-4 p-lg-5">

      <!-- Tanggal & Status -->
      <div class="d-flex justify-content-between align-items-start flex-wrap gap-3 mb-4">
        <div>
          <div class="label">Tanggal Laporan</div>
          <div class="value fw-bold fs-4 text-primary">
            <?= date('j F Y - H:i', strtotime($r['tgl_buat'])) ?> WITA
          </div>
        </div>
        <div>
          <?php if($r['status'] == 'Selesai'): ?>
            <span class="badge bg-success status-badge">Selesai</span>
          <?php elseif($r['status'] == 'Diproses'): ?>
            <span class="badge bg-info status-badge">Diproses</span>
          <?php else: ?>
            <span class="badge bg-warning text-dark status-badge">Menunggu</span>
          <?php endif; ?>
        </div>
      </div>

      <hr class="my-4">

      <!-- Masalah -->
      <div class="mb-4">
        <div class="label">Masalah</div>
        <div class="value fs-4 fw-bold text-dark">
          <?= htmlspecialchars($r['masalah']) ?>
        </div>
      </div>

      <!-- Kategori & Lokasi -->
      <div class="row mb-4">
        <div class="col-md-6 mb-3">
          <div class="label">Kategori</div>
          <div class="value"><?= $r['kategori'] ?></div>
        </div>
        <div class="col-md-6 mb-3">
          <div class="label">Lokasi</div>
          <div class="value"><?= $r['lokasi'] ?: '<em class="text-muted">Tidak diisi</em>' ?></div>
        </div>
      </div>

      <!-- Deskripsi Masalah -->
      <div class="mb-4">
        <div class="label">Deskripsi Masalah</div>
        <div class="value" style="white-space: pre-line; min-height: 120px; background: #f1f3f5;">
          <?= nl2br(htmlspecialchars($r['deskripsi'])) ?>
        </div>
      </div>

      <!-- CATATAN TEKNISI – Muncul hanya jika sudah diisi -->
      <?php if (!empty($r['catatan_teknisi'])): ?>
      <div class="mb-4">
        <div class="d-flex align-items-center mb-3">
          <h5 class="text-success mb-0">Catatan Teknisi</h5>
        </div>
        <div class="catatan-box">
          <p class="mb-0 fw-medium" style="white-space: pre-line; font-size: 1.05rem;">
            <?= nl2br(htmlspecialchars($r['catatan_teknisi'])) ?>
          </p>
        </div>
      </div>
      <?php endif; ?>

      <!-- Tombol Tutup -->
      <div class="text-end mt-4">
        <a href="javascript:history.back()" class="btn btn-dark btn-lg px-5">Tutup</a>
      </div>

    </div>
  </div>
</div>

</body>
</html>