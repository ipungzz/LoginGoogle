<?php 
  $dataUser = dataUser();
  $jml_pengeluaran = mysqli_fetch_assoc(mysqli_query($conn, "SELECT sum(jumlah_pengeluaran) as jml_pengeluaran FROM pengeluaran"));
  $jml_pengeluaran = $jml_pengeluaran['jml_pengeluaran'];

  $jml_uang_kas = mysqli_fetch_assoc(mysqli_query($conn, "SELECT sum(minggu_ke_1 + minggu_ke_2 + minggu_ke_3 + minggu_ke_4) as jml_uang_kas FROM uang_kas"));
  $jml_uang_kas = $jml_uang_kas['jml_uang_kas'];
  $asetting = mysqli_query($conn, "SELECT * FROM `setting`");
  $setting = mysqli_fetch_assoc($asetting)
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index" class="brand-link">
    <img src="assets/img/img_properties/man.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light"><?= $setting['nama_web']?></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item has-treeview menu-open">
          <a href="profile" class="nav-link"><i class="nav-icon fas fa-fw fa-user"></i> <p><?= $dataUser['username']; ?></p></a>
        </li>
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <div class="bg-success nav-link text-white">
            <i class="nav-icon fas fa-money-bill-wave"></i>
            <p>
              Sisa Uang: <?= number_format($jml_uang_kas - $jml_pengeluaran); ?>
            </p>
          </div>
        </li>
        <li class="nav-item has-treeview menu-open">
          <a href="index" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <?php if ($dataUser['id_jabatan'] == '1'): ?>
          <li class="nav-item">
            <a href="jabatan" class="nav-link">
              <i class="nav-icon fas fa-cog"></i>
              <p>
                Jabatan
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="send" class="nav-link">
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576 6.636 10.07Zm6.787-8.201L1.591 6.602l4.339 2.76 7.494-7.493Z"/>
              </svg>
              <p>Sender</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="user" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                User
              </p>
            </a>
          </li>
        <?php endif ?>
        <li class="nav-item">
            <a href="dispen" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Dispen
              </p>
            </a>
          </li>
        <li class="nav-item">
          <a href="siswa" class="nav-link">
            <i class="fas fa-user-tie nav-icon"></i>
            <p>Siswa</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="uang_kas" class="nav-link">
            <i class="fas fa-dollar-sign nav-icon"></i>
            <p>Uang Kas</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="pengeluaran" class="nav-link">
            <i class="fas fa-sign-out-alt nav-icon"></i>
            <p>Pengeluaran</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="laporan" class="nav-link">
            <i class="fas fa-file nav-icon"></i>
            <p>Laporan</p>
          </a>
        </li>
        <div class="dropdown-divider"></div>
        <li class="nav-item">
          <a href="riwayat" class="nav-link">
            <i class="fas fa-stopwatch nav-icon"></i>
            <p>Riwayat Uang Kas</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="riwayat_pengeluaran" class="nav-link">
            <i class="fas fa-stopwatch nav-icon"></i>
            <p>Riwayat Pengeluaran</p>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>