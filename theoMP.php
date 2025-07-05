<?php // Khai báo đầu trang
    ob_start();
    include 'includes/youjia_connect.php';
?>
<?php

    if (isset($_GET['id'])) {
        $MaDM = (int) $_GET["id"]; // Mã danh mục

        // LẤY TÊN DANH MỤC
        $sqlDM = "SELECT TenDM FROM DanhMuc WHERE MaDM = $MaDM";
        $resultDM = mysqli_query($conn, $sqlDM); 
        if (!$resultDM) {
            die("Lỗi truy vấn tên danh mục: " . mysqli_error($conn));
        }
        $tenDM = mysqli_fetch_assoc($resultDM);

        // LẤY DANH SÁCH SẢN PHẨM THEO DANH MỤC
        $sql = "SELECT MaSP, TenSP, AnhBia, GiaBan FROM SanPham WHERE MaDM = 2";
        $resultSP = mysqli_query($conn, $sql);
        if (!$resultSP) {
            die("Lỗi truy vấn sản phẩm: " . mysqli_error($conn));
        }

        // URL hiện tại để gửi khi click "Thêm vào giỏ"
        $currentUrl = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
?>
<!-- Nội dung trang -->
<h2 class="text-center"><b>Danh sách <?php echo htmlspecialchars($tenDM['TenDM']); ?></b></h2>
<hr>
<div class="container">
  <div class="row">
    <?php 
    $i = 0;
    while ($row = mysqli_fetch_assoc($resultSP)) { 
      if ($i % 4 == 0 && $i != 0) {
          echo '</div><div class="row">';
      }
    ?>
    <div class="col-md-2 col-sm-4 col-xs-6" style="width: 230px;">
      <div class="thumbnail text-center">
        <img src="images/<?php echo htmlspecialchars($row['AnhBia']); ?>" alt="Thumbnail Image" class="img-responsive img-rounded imgbook" style="width:180px; height:200px;">
        <div class="caption">
          <h6 style="min-height: 30px;">
            <a href="Chitietsanpham.php?id=<?php echo $row['MaSP']; ?>"><?php echo htmlspecialchars($row['TenSP']); ?></a>
          </h6>
          
          <p style='color:rgb(255, 0, 98)'><strong><?php echo number_format($row['GiaBan'], 0, ',', '.'); ?> VNĐ</strong></p>
          
          <p>
            <a href="Chitietsanpham.php?id=<?php echo $row['MaSP']; ?>&url=<?php echo urlencode($currentUrl); ?>" class="btn btn-success" role="button">
              <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Thêm vào giỏ
            </a>
          </p>
        </div>
      </div>
    </div>
    <?php $i++; } ?>
  </div>
</div>

<?php
    $content = ob_get_clean();
    include "includes/youjia_layout.php";
?>
