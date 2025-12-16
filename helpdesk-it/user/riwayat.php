<?php include '../config.php';
if(!isset($_SESSION['user']) || $_SESSION['role']!='karyawan') header('Location: ../login.php');
$id_user = $_SESSION['user'];

$search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : '';

$sql = "SELECT * FROM laporan WHERE id_user=$id_user AND status='Selesai'";
if($search) $sql .= " AND masalah LIKE '%$search%'";
if($kategori) $sql .= " AND kategori='$kategori'";
$sql .= " ORDER BY tgl_selesai DESC";

$data = mysqli_query($koneksi, $sql);
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
  <?php include '../template/sidebar.php'; ?>
  <div id="content" class="p-4">

  <main class="p-4">
    <h3 class="mb-4">Riwayat Laporan</h3>

    <div class="card shadow-sm">
      <div class="card-body">
        <form class="row g-3 mb-4">
          <div class="col-md-8">
            <input type="text" name="search" class="form-control form-control-lg rounded-pill" placeholder="Search..." value="<?= htmlspecialchars($search) ?>">
          </div>
          <div class="col-md-3">
            <select name="kategori" class="form-select form-select-lg rounded-pill">
              <option value="">All Categories</option>
              <option <?= $kategori=='Komputer'?'selected':'' ?>>Komputer</option>
              <option <?= $kategori=='Printer'?'selected':'' ?>>Printer</option>
              <option <?= $kategori=='Jaringan'?'selected':'' ?>>Jaringan</option>
              <option <?= $kategori=='Software'?'selected':'' ?>>Software</option>
              <option <?= $kategori=='Lainnya'?'selected':'' ?>>Lainnya</option>
            </select>
          </div>
          <div class="col-md-1">
            <button type="submit" class="btn btn-primary btn-lg rounded-pill">Go</button>
          </div>
        </form>

        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="table-light">
              <tr>
                <th>No.</th>
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
                <td><?= date('d/m/y', strtotime($r['tgl_selesai'])) ?></td>
                <td><a href="detail-riwayat.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-outline-dark">Lihat</a></td>
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