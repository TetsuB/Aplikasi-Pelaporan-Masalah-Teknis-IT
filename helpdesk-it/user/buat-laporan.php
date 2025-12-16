<?php
include '../config.php';
if (!isset($_SESSION['user']) || $_SESSION['role'] !== 'karyawan') {
    header('Location: ../login.php');
    exit();
}

if ($_POST) {
    $kategori   = $_POST['kategori'];
    $masalah    = mysqli_real_escape_string($koneksi, $_POST['masalah']);
    $deskripsi  = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $lokasi     = mysqli_real_escape_string($koneksi, $_POST['lokasi']);
    $id_user    = $_SESSION['user'];

    // Generate No Tiket Otomatis
    $tgl = date('Ymd');
    $last = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT no_tiket FROM laporan ORDER BY id DESC LIMIT 1"));
    $urut = $last ? (intval(substr($last['no_tiket'], -4)) + 1) : 1;
    $no_tiket = "TKT-" . $tgl . str_pad($urut, 4, '0', STR_PAD_LEFT);

    $sql = "INSERT INTO laporan (no_tiket, id_user, kategori, masalah, deskripsi, lokasi) 
            VALUES ('$no_tiket', $id_user, '$kategori', '$masalah', '$deskripsi', '$lokasi')";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Laporan berhasil dikirim!'); window.location='status-laporan.php';</script>";
    } else {
        $error = "Gagal mengirim laporan.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Buat Laporan - IT Support</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; padding: 20px 15px; }
    .card-form { border-radius: 16px; box-shadow: 0 8px 30px rgba(0,0,0,0.1); }
    .form-control, .form-select { border-radius: 12px; padding: 12px 16px; }
    .label { font-weight: 600; color: #444; }
    @media (max-width: 576px) { body { padding: 10px; } }
  </style>
</head>
<body>

<?php include '../template/sidebar.php'; ?>
<div id="content" class="p-4">

<div class="container">
  <div class="d-flex align-items-center mb-4">
    <h3 class="mb-0">Buat Laporan</h3>
  </div>

  <div class="card card-form">
    <div class="card-body p-4 p-lg-5">

      <form method="post">
        <div class="row g-4">

          <!-- Tanggal (Auto-filled) -->
          <div class="col-12">
            <label class="label">Tanggal:</label>
            <input type="text" class="form-control bg-light" value="<?= date('d F Y - H:i') ?> WITA" readonly>
          </div>

          <!-- Masalah -->
          <div class="col-12">
            <label class="label">Masalah:</label>
            <input type="text" name="masalah" class="form-control" placeholder="Contoh: Printer tidak bisa print warna" required>
          </div>

          <!-- Kategori & Deskripsi (2 kolom) -->
          <div class="col-md-6">
            <label class="label">Kategori:</label>
            <select name="kategori" class="form-select" required>
              <option value="">Pilih Kategori</option>
              <option>Komputer</option>
              <option>Printer</option>
              <option>Jaringan</option>
              <option>Software</option>
            </select>
          </div>
          <div class="col-md-6">
            <label class="label">Lokasi:</label>
            <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Kantor 1 - Lantai 2">
          </div>

          <!-- Deskripsi Masalah -->
          <div class="col-12">
            <label class="label">Deskripsi masalah:</label>
            <textarea name="deskripsi" rows="6" class="form-control" placeholder="Jelaskan secara detail masalah yang terjadi..." required></textarea>
          </div>

          <!-- Tombol Simpan -->
          <div class="col-12 text-end mt-4">
            <button type="submit" class="btn btn-dark btn-lg px-5 rounded-pill">Simpan</button>
          </div>

        </div>
      </form>
    </div>
  </div>
</div>

</body>
</html>