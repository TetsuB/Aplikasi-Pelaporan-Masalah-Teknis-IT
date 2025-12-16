<!-- template/sidebar_teknisi.php -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<style>
  #sidebar {
    position: fixed;
    top: 0; left: 0; bottom: 0;
    width: 250px;
    background: #f8f9fa;
    border-right: 1px solid #dee2e6;
    z-index: 1040;
    transition: transform 0.3s ease;
    transform: translateX(0);
  }
  #sidebar.hidden { transform: translateX(-250px); }

  #sidebarToggle {
    position: fixed;
    top: 15px; left: 15px;
    width: 45px; height: 45px;
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 50%;
    box-shadow: 0 2px 10px rgba(0,0,0,0.15);
    z-index: 1050;
    display: none;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    color: #495057;
    cursor: pointer;
  }
  @media (max-width: 991.98px) {
    #sidebarToggle { display: flex; }
    #sidebar { transform: translateX(-250px); } /* otomatis sembunyi di HP */
  }

  #overlay {
    position: fixed; top:0; left:0; right:0; bottom:0;
    background: rgba(0,0,0,0.5); z-index: 1030;
    display: none;
  }
  @media (min-width: 992px) {
    #content { margin-left: 250px; }
  }
</style>

<!-- Tombol Panah -->
<button id="sidebarToggle" class="btn">
  <i class="bi bi-chevron-right"></i>
</button>

<!-- Overlay -->
<div id="overlay"></div>

<!-- Sidebar -->
<nav id="sidebar" class="bg-light">
  <div class="p-4 pt-5">
    <h5 class="text-primary fw-bold mb-4">IT Support</h5>
    <ul class="nav flex-column">
      <li class="nav-item mb-2">
        <a href="dashboard.php" class="nav-link rounded <?= basename($_SERVER['PHP_SELF'])=='dashboard.php' ? 'bg-dark text-white' : 'text-dark' ?>">
          Dashboard
        </a>
      </li>
      <li class="nav-item mb-2">
        <a href="daftar-laporan.php" class="nav-link rounded <?= basename($_SERVER['PHP_SELF'])=='daftar-laporan.php' ? 'bg-dark text-white' : 'text-dark' ?>">
          Daftar Laporan
        </a>
      </li>
      <li class="nav-item mb-2">
        <a href="riwayat.php" class="nav-link rounded <?= basename($_SERVER['PHP_SELF'])=='riwayat.php' ? 'bg-dark text-white' : 'text-dark' ?>">
          Riwayat Laporan
        </a>
      </li>
    </ul>
    <hr class="my-5">
    <a href="../logout.php" class="btn btn-outline-danger btn-sm w-100">Logout</a>
  </div>
</nav>

<script>
  const sidebar   = document.getElementById('sidebar');
  const toggleBtn = document.getElementById('sidebarToggle');
  const overlay   = document.getElementById('overlay');
  const icon      = toggleBtn.querySelector('i');

  function openSidebar() {
    sidebar.style.transform = 'translateX(0)';
    overlay.style.display = 'block';
    icon.className = 'bi bi-chevron-left';
  }
  function closeSidebar() {
    sidebar.style.transform = 'translateX(-250px)';
    overlay.style.display = 'none';
    icon.className = 'bi bi-chevron-right';
  }

  // Klik tombol panah
  toggleBtn.addEventListener('click', () => {
    if (sidebar.style.transform === 'translateX(0px)' || sidebar.style.transform === '') {
      closeSidebar();
    } else {
      openSidebar();
    }
  });

  // Tutup saat klik overlay
  overlay.addEventListener('click', closeSidebar);

  // Otomatis tutup saat klik menu (hanya di HP)
  document.querySelectorAll('#sidebar a').forEach(link => {
    link.addEventListener('click', () => {
      if (window.innerWidth < 992) {
        closeSidebar();
      }
    });
  });

  // Pastikan tombol panah tidak muncul di desktop
  window.addEventListener('resize', () => {
    if (window.innerWidth >= 992) {
      sidebar.style.transform = 'translateX(0)';
      overlay.style.display = 'none';
      toggleBtn.style.display = 'none';
    } else {
      toggleBtn.style.display = 'flex';
    }
  });
</script>