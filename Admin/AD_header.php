<?php 
ob_start(); 
// session_start(); 
?>
<link rel="stylesheet" href="AD_css.css"> 

<body>

<?php
  function isActive($filename) {
    return basename($_SERVER['PHP_SELF']) === $filename ? 'active' : '';
  }
?>
<div class="sidebar">
  <h1><B>YOUJIA</B></h1>
  <a href="QL_TT.php" class="<?= isActive('QL_TT.php') ?>">THÔNG TIN DOANH NGHIỆP</a>
  <a href="QL_Banner.php" class="<?= isActive('QL_Banner.php') ?>">QUẢN LÝ BANNER</a>
  <a href="QL_NDM.php" class="<?= isActive('QL_NDM.php') ?>">QUẢN LÝ NHÓM DANH MỤC</a>
  <a href="QL_DM.php" class="<?= isActive('QL_DM.php') ?>">QUẢN LÝ DANH MỤC</a>
  <a href="QL_SP.php" class="<?= isActive('QL_SP.php') ?>">QUẢN LÝ SẢN PHẨM</a>
  <a href="QL_HASP.php" class="<?= isActive('QL_HASP.php') ?>">QUẢN LÝ HÌNH ẢNH SẢN PHẨM</a>
  <a href="QL_KH.php" class="<?= isActive('QL_KH.php') ?>">QUẢN LÝ KHÁCH HÀNG</a>
  <a href="QL_DH.php" class="<?= isActive('QL_DH.php') ?>">QUẢN LÝ ĐƠN HÀNG</a>

  <div class="bottom">
    <?php if (isset($_SESSION['admin'])): ?>
      <div>Xin chào, <strong><?= htmlspecialchars($_SESSION['admin']) ?></strong></div>
      <a href="DangXuat_AD.php">
        <i class="fas fa-sign-out-alt"></i> Đăng xuất
      </a>
    <?php endif; ?>
  </div>
</div>

