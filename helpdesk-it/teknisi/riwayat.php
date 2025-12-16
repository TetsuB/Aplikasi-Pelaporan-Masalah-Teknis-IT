<?php 
include '../config.php'; 
if($_SESSION['role']!='teknisi') header('Location: ../login.php');

// Ambil input dari GET
$cari = isset($_GET['cari']) ? mysqli_real_escape_string($koneksi, $_GET['cari']) : '';
$kategori = isset($_GET['kategori']) ? mysqli_real_escape_string($koneksi, $_GET['kategori']) : '';

// Bangun kondisi WHERE
$where = "WHERE l.status='Selesai'";
if($cari) {
    $where .= " AND (l.masalah LIKE '%$cari%' OR l.kategori LIKE '%$cari%')";
}
if($kategori) {
    $where .= " AND l.kategori='$kategori'";
}

// Query dengan JOIN dan ORDER
$data = mysqli_query($koneksi, "SELECT l.*, u.nama FROM laporan l JOIN users u ON l.id_user=u.id $where ORDER BY l.tgl_selesai DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Riwayat Laporan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {padding-left:50px;background:#f8f9fa}
    @media(max-width:992px){body{padding-left:0}}
    #sidebar{position:fixed;top:0;left:0;height:100vh}
  </style>
</head>
<body>
  <?php include '../template/sidebar_teknisi.php'; ?>
  <div id="content" class="p-4">

  <main class="p-4">
    <h3 class="mb-4">Riwayat Laporan</h3>

    <div class="card shadow-sm">
      <div class="card-body">
        <form class="row g-3 mb-4">
          <div class="col-md-6">
            <input type="text" name="cari" class="form-control form-control-lg rounded-pill" placeholder="Search..." value="<?= htmlspecialchars($cari) ?>">
          </div>
          <div class="col-md-4">
            <select name="kategori" class="form-select form-select-lg rounded-pill">
              <option value="">All Categories</option>
              <option value="Komputer" <?= $kategori=='Komputer'?'selected':'' ?>>Komputer</option>
              <option value="Printer" <?= $kategori=='Printer'?'selected':'' ?>>Printer</option>
              <option value="Jaringan" <?= $kategori=='Jaringan'?'selected':'' ?>>Jaringan</option>
              <option value="Software" <?= $kategori=='Software'?'selected':'' ?>>Software</option>
            </select>
          </div>
          <div class="col-md-2">
            <button type="submit" class="btn btn-primary btn-lg rounded-pill">Go</button>
          </div>
        </form>

        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="table-light">
              <tr>
                <th>No</th>
                <th>Masalah</th>
                <th>Status</th>
                <th>Kategori</th>
                <th>Tanggal</th>
                <th>Detail</th>
              </tr>
            </thead>
            <tbody>
              <?php $no=1; while($r=mysqli_fetch_assoc($data)): ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($r['masalah']) ?></td>
                <td><span class="badge bg-success">Selesai</span></td>
                <td><?= $r['kategori'] ?></td>
                <td>
                <?php 
                  if (!empty($r['tgl_selesai'])) {
                      echo date('d/m/Y H:i', strtotime($r['tgl_selesai']));
                  } else {
                      echo '-';
                  }
                ?>
                </td>
                <td><a href="detail-riwayat.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-outline-primary">Lihat</a></td>
              </tr>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
</body>
</html>