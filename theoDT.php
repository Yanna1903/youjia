<?php 
  ob_start();
  session_start();
?>
<?php
    include 'includes/youjia_connect.php';

    if (isset($_GET['id'])) {
        $MaDM = (int)$_GET["id"];

        // Lấy tên danh mục từ bảng danhmuc
        $sqlDM = "SELECT TenDM FROM danhmuc WHERE MaDM = $MaDM";
        $resultDM = mysqli_query($conn, $sqlDM); 
        $tenDM = mysqli_fetch_assoc($resultDM);

        // Lấy sản phẩm theo danh mục từ bảng sanpham
        $sql = "SELECT MaSP, TenSP, AnhBia, GiaBan FROM sanpham WHERE MaDM = $MaDM";
        $resultSP = mysqli_query($conn, $sql); 
    }
?>
<!-- Nội dung trang -->
<h2 class="text-center"><B>Danh mục sản phẩm <?php echo$tenDM['TenDM']; ?></B></h2>
<hr>
<div class="container">
    <div class="row">
      <?php 
      $i = 0;
      while ($row = mysqli_fetch_assoc($resultSP)) { 
        if ($i % 5 == 0 && $i != 0) {
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
            
            <p style='color:rgb(255, 0, 98)'>
                  <strong><?php echo number_format($row['GiaBan'], 0, ',', '.'); ?> VNĐ</strong>
            </p>
            
            <p>
              <a href="Chitietsanpham.php?id=<?php echo $row['MaSP']; ?>&url=<?php $currentUrl = "https://".$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; echo urlencode($currentUrl); ?>" class="btn btn-success" role="button">
              <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Thêm vào giỏ
              </a>
            </p>
          </div>
        </div>
      </div>
      <?php $i++;} ?>
    </div>
  </div>
<?php
    $content = ob_get_clean();
    include "includes/youjia_layout.php";
?>

<style>
  .btn-success{
    background-color: rgb(65, 151, 171);
    border: 1px rgb(49, 111, 125);
  }
  .btn-success:hover, .btn-success:focus {
      background-color: rgb(28, 98, 114) !important;
      border: 1px rgb(28, 98, 114);
  }
  h2{
    color: rgb(40, 85, 96) !important;
  }
  hr {
  border: none;
  border-top: 5px solid rgba(40, 85, 96, 0.32); 
  width: 50%; /* Chiều dài của thẻ hr, có thể điều chỉnh */
  margin: 20px auto; /* Căn giữa và tạo khoảng cách phía trên/dưới */
  display: block; /* Đảm bảo thẻ hr có kiểu hiển thị block */
}
</style>