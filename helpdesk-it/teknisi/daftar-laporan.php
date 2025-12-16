<?php include '../config.php'; 
if($_SESSION['role']!='teknisi') header('Location: ../login.php');
$data = mysqli_query($koneksi,"SELECT l.*, u.nama FROM laporan l JOIN users u ON l.id_user=u.id WHERE l.status!='Selesai' ORDER BY l.tgl_buat DESC");
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Daftar Laporan</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include '../template/sidebar_teknisi.php'; ?>
<div id="content" class="p-4">
    
<div id="content" class="p-4">
  <h3 class="mb-4">Daftar Laporan Masuk</h3>
  <div class="card shadow-sm"><div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover">
        <thead class="table-light"><tr><th>No</th><th>Masalah</th><th>Status</th><th>Kategori</th><th>Tanggal</th><th>Detail</th></tr></thead>
        <tbody>
          <?php $no=1; while($r=mysqli_fetch_assoc($data)): ?>
          <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($r['masalah']) ?></td>
            <td><span class="badge <?= $r['status']=='Menunggu'?'bg-warning':($r['status']=='Diproses'?'bg-info':'bg-success') ?>"><?= $r['status'] ?></span></td>
            <td><?= $r['kategori'] ?></td>
            <td><?= date('d/m/y',strtotime($r['tgl_buat'])) ?></td>
            <td><a href="detail-laporan.php?id=<?= $r['id'] ?>" class="btn btn-sm btn-outline-primary">Pilih</a></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div></div>
</div>
</body></html>