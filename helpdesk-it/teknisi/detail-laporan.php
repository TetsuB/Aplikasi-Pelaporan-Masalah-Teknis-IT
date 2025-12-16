<?php 
include '../config.php';
if($_SESSION['role']!='teknisi') header('Location: ../login.php');
$id = (int)$_GET['id'];
$r = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT l.*, u.nama as nama_pelapor FROM laporan l JOIN users u ON l.id_user=u.id WHERE l.id=$id"));

if($_POST){
  $status = $_POST['status'];
  $catatan = mysqli_real_escape_string($koneksi,$_POST['catatan_teknisi']);
  mysqli_query($koneksi,"UPDATE laporan SET status='$status', catatan_teknisi='$catatan' WHERE id=$id");
  echo "<script>alert('Berhasil disimpan!'); window.location='daftar-laporan.php';</script>";
}
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Detail Laporan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>

<div id="content" class="p-4">
  <h3 class="mb-4">Detail Laporan Masuk</h3>
  <div class="card shadow-sm"><div class="card-body">
    <form method="post">
      <div class="row g-3">
        <div class="col-md-6"><label>Tanggal:</label><input type="text" class="form-control" value="<?= date('d F Y - H:i',strtotime($r['tgl_buat'])) ?> WITA" readonly></div>
        <div class="col-md-6"><label>Nama Pelapor:</label><input type="text" class="form-control" value="<?= $r['nama_pelapor'] ?>" readonly></div>
        <div class="col-12"><label>Masalah:</label><input type="text" class="form-control" value="<?= htmlspecialchars($r['masalah']) ?>" readonly></div>
        <div class="col-md-6"><label>Kategori:</label><input type="text" class="form-control" value="<?= $r['kategori'] ?>" readonly></div>
        <div class="col-md-6"><label>Lokasi:</label><input type="text" class="form-control" value="<?= $r['lokasi']?:'-' ?>" readonly></div>
        <div class="col-md-6">
          <label>Status:</label>
          <select name="status" class="form-select" required>
            <option value="Menunggu" <?= $r['status']=='Menunggu'?'selected':'' ?>>Menunggu</option>
            <option value="Diproses" <?= $r['status']=='Diproses'?'selected':'' ?>>Diproses</option>
            <option value="Selesai" <?= $r['status']=='Selesai'?'selected':'' ?>>Selesai</option>
          </select>
        </div>
        <div class="col-12"><label>Deskripsi masalah:</label><textarea class="form-control" rows="4" readonly><?= htmlspecialchars($r['deskripsi']) ?></textarea></div>
        <div class="col-12"><label>Catatan Perbaikan:</label><textarea name="catatan_teknisi" class="form-control" rows="5" placeholder="Tulis solusi di sini..."><?= htmlspecialchars($r['catatan_teknisi']) ?></textarea></div>
        <div class="col-12 text-end"><button type="submit" class="btn btn-dark btn-lg px-5">Simpan</button></div>
      </div>
    </form>
  </div></div>
</div>
</body></html>