<?php
    include 'includes/youjia_connect.php';
    // session_start(); 
?>

<nav class="navbar navbar-inverse">
  <div class="container">
    <!-- Tên brand -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar1" aria-expanded="false">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">YOUJIA - NỘI ĐỊA TRUNG</a>
    </div>

    <!-- Các chức năng chính -->
    <div class="collapse navbar-collapse" id="navbar1">
      <ul class="nav navbar-nav">
        <li><a href="index.php">TRANG CHỦ</a></li>
        <li><a href="gioithieu.php">GIỚI THIỆU</a></li>

        <!-- Dropdown ĐIỆN TỬ -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            ĐIỆN TỬ 
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <?php
              $sql_dt = "SELECT MaDM, TenDM FROM DanhMuc WHERE MaNDM = 1 ORDER BY TenDM";
              $res_dt = mysqli_query($conn, $sql_dt);
              while ($dt = mysqli_fetch_assoc($res_dt)) {
                echo '<li><a href="theoDT.php?id='.$dt['MaDM'].'">'.$dt['TenDM'].'</a></li>';
              }
            ?>
          </ul>
        </li>

        <!-- Dropdown MỸ PHẨM -->
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            MỸ PHẨM
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <?php
              $sql_mp = "SELECT MaDM, TenDM FROM DanhMuc WHERE MaNDM = 2 ORDER BY TenDM";
              $res_mp = mysqli_query($conn, $sql_mp);
              while ($mp = mysqli_fetch_assoc($res_mp)) {
                echo '<li><a href="theoMP.php?id='.$mp['MaDM'].'">'.$mp['TenDM'].'</a></li>';
              }
            ?>
          </ul>
        </li>
      </ul>

      <!-- Người dùng (đã đăng nhập thì hiển thị username) & Giỏ hàng -->
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a href="giohang.php">
            <span class="glyphicon glyphicon-shopping-cart"></span>
            Giỏ hàng (<?= 
              isset($_SESSION['cart']) 
              ? array_sum(array_column($_SESSION['cart'], 'quantity')) 
              : 0
            ?>)
          </a>
        </li>

        <?php if (isset($_SESSION['username'])): ?>
          <li class="dropdown">
            <a href="#"
               class="dropdown-toggle"
               data-toggle="dropdown"
               role="button"
               aria-haspopup="true"
               aria-expanded="false">
              <span class="glyphicon glyphicon-user"></span>
              <?= htmlspecialchars($_SESSION['username']) ?>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="xemhoso.php"><span class="glyphicon glyphicon-info-sign"></span> Hồ sơ</a></li>
              <li><a href="xemDH.php"><span class="glyphicon glyphicon-list-alt"></span> Đơn hàng</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="dangxuat.php"><span class="glyphicon glyphicon-log-out"></span> Đăng xuất</a></li>
            </ul>
          </li>
        <?php else: ?>
          <!-- Nếu chưa đăng nhập, hiển thị form đăng nhập hoặc đăng ký -->
          <li><a href="DKDN.php"><span class="glyphicon glyphicon-log-in"></span> Đăng nhập</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Cuối trang: load jQuery trước, rồi Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- <style>
  .navbar-inverse {
    background-color: #285560 !important;
    border-color: #012a34 !important;
    margin-bottom: 0;
    border-radius: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .navbar-inverse .navbar-brand {
    color: #d1f5ff !important;
    font-size: 20px;
    font-weight: bold;
  }

  .navbar-inverse .navbar-brand:hover,
  .navbar-inverse .navbar-brand:focus {
    color: #ffffff !important;
    background-color: transparent !important;
  }

  .navbar-inverse .navbar-nav > li > a {
    color: #ffffff !important;
    padding: 15px 18px;
    transition: background-color 0.3s, color 0.3s;
    position: relative;
  }

  .navbar-inverse .navbar-nav > li > a:hover,
  .navbar-inverse .navbar-nav > li > a:focus {
    background-color: rgb(28, 62, 70) !important;
    color: #ffffff !important;
  }

  .navbar-inverse .navbar-toggle .icon-bar {
    background-color: #ffffff;
  }

  .navbar-inverse .navbar-nav .dropdown-menu {
    min-width: 180px;
    border-radius: 4px;
    background-color: #ffffff;
    border: 1px solid #012a34;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
    padding: 5px 0;
    transition: opacity 0.2s ease;
    opacity: 0;
    visibility: hidden;
  }

  .navbar-inverse .navbar-nav > .dropdown:hover > .dropdown-menu {
    opacity: 1;
    visibility: visible;
    display: block;
  }

  .navbar-inverse .navbar-nav .dropdown-menu > li > a {
    display: block;
    padding: 10px 20px;
    color: #285560;
    font-size: 14px;
    font-weight: 500;
    transition: background-color 0.2s, color 0.2s;
  }

  .navbar-inverse .navbar-nav .dropdown-menu > li > a:hover,
  .navbar-inverse .navbar-nav .dropdown-menu > li > a:focus {
    background-color: #e8f7fa;
    color: #012a34;
  }
</style> -->
