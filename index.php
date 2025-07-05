<?php 
    session_start();
    ob_start();
    include 'includes/youjia_connect.php';
    // include 'includes/header.php';
    $trang = 1;
    if (isset($_GET['trang'])) {
        $trang = $_GET['trang'];
    }

    $SLtrang = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(MaSP) AS TongSP FROM sanpham"))['TongSP'] / 12;

    $sql = "SELECT MaSP, TenSP, AnhBia, GiaBan 
            FROM sanpham 
            ORDER BY MaSP DESC 
            LIMIT 10 OFFSET " . (($trang - 1) * 10);
    $result = mysqli_query($conn, $sql);
?>
<link rel="stylesheet" href="css/bootstrap.css">
<div>
    <h2 class="text-center"><b>DANH SÁCH SẢN PHẨM</b></h2>
    <hr>
    <div class="container-color text-center">
        <div class="row">
            <?php 
            $i = 0;
            while ($row = mysqli_fetch_assoc($result)) { 
                if ($i > 0 && $i % 5 == 0) {
                    echo '</div><div class="row">'; 
                }
            ?>
            <div class="col-md-2 col-sm-4 col-xs-6" style="width: 230px;">
                <div class="thumbnail text-center">
                    <img src="images/<?php echo htmlspecialchars($row['AnhBia']); ?>" alt="Thumbnail Image" class="img-responsive img-rounded imgbook" style="width:180px; height:200px;" >
                    <div class="caption">
                        <h5 style="min-height: 30px;">
                            <a href="Chitietsanpham.php?id=<?php echo $row['MaSP']; ?>" style='color:rgb(40, 85, 96)';><?php echo htmlspecialchars($row['TenSP']); ?></a>
                        </h5>
                        <p style='color: rgb(255, 0, 98)'>
                            <strong><?php echo number_format($row['GiaBan'], 0, ',', '.'); ?> VNĐ</strong>
                        </p>
                        <p>
                            <a href="Chitietsanpham.php?id=<?php echo $row['MaSP']; ?>&url=<?php echo urlencode("https://".$_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']); ?>" class="btn btn-success" role="button">
                                <span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"></span> Thêm vào giỏ
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <?php $i++;} ?>
        </div>
    </div>
</div>
<nav class="text-center">
  <ul class="pagination">
    <!-- Trang trước -->
    <li class="<?php echo ($trang <= 1) ? 'disabled' : ''; ?>"> 
      <a href="?trang=<?php echo $trang - 1; ?>" aria-label="Previous"> 
        <span aria-hidden="true">&laquo;</span> 
      </a> 
    </li>

    <!-- các trang giữa -->
    <?php for ($i = 1; $i <= ceil($SLtrang); $i++) : ?>
        <li class="<?php if ($trang == $i) echo 'active'; ?>">
          <a href="?trang=<?php echo $i; ?>">
            <?php echo $i; ?>
          </a>
        </li>
    <?php endfor; ?>

    <!-- Trang sau -->
    <li class="<?php echo ($trang >= ceil($SLtrang)) ? 'disabled' : ''; ?>"> 
      <a href="?trang=<?php echo $trang + 1; ?>" aria-label="Next"> 
        <span aria-hidden="true">&raquo;</span> 
      </a> 
    </li>
  </ul>
</nav>

<?php
$content = ob_get_clean();
include "includes/youjia_layout.php";
?>
