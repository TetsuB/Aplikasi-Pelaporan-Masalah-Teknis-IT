<?php include '../config.php'; 
if(!isset($_SESSION['user']) || $_SESSION['role']!='teknisi') {
    header('Location: ../login.php');
    exit();
}
$id_user = $_SESSION['user'];
$total = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) as j FROM laporan"))['j'];
$menunggu = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) as j FROM laporan WHERE status='Menunggu'"))['j'];
$diproses = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) as j FROM laporan WHERE status='Diproses'"))['j'];
$selesai = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT COUNT(*) as j FROM laporan WHERE status='Selesai'"))['j'];
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard Teknisi</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head>
<body>
<?php include '../template/sidebar_teknisi.php'; ?>
<div id="content" class="p-4">
    
<div id="content" class="p-4">
  <h3 class="mb-4">Dashboard Teknisi</h3>
  <div class="row g-4">
    <div class="col-md-3"><div class="card text-center p-4 shadow-sm"><h2 class="text-primary"><?= $total ?></h2><p>Total Laporan</p></div></div>
    <div class="col-md-3"><div class="card text-center p-4 shadow-sm"><h2 class="text-warning"><?= $menunggu ?></h2><p>Menunggu</p></div></div>
    <div class="col-md-3"><div class="card text-center p-4 shadow-sm"><h2 class="text-info"><?= $diproses ?></h2><p>Diproses</p></div></div>
    <div class="col-md-3"><div class="card text-center p-4 shadow-sm"><h2 class="text-success"><?= $selesai ?></h2><p>Selesai</p></div></div>
  </div>
</div>
</body></html>