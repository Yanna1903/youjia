<?php 
session_start();
ob_start();
include 'includes/youjia_connect.php';

$trang = isset($_GET['trang']) ? (int)$_GET['trang'] : 1;
$limit = 10;
$offset = ($trang - 1) * $limit;

$search = isset($_GET['query']) ? trim($_GET['query']) : '';
$sanpham = [];
$tongSP = 0;

if ($search != '') {
    $stmt = $conn->prepare("SELECT COUNT(*) AS TongSP FROM sanpham WHERE TenSP LIKE ?");
    $likeSearch = '%' . $search . '%';
    $stmt->bind_param("s", $likeSearch);
    $stmt->execute();
    $tongSP = $stmt->get_result()->fetch_assoc()['TongSP'];
    $stmt->close();

    $stmt = $conn->prepare("SELECT MaSP, TenSP, AnhBia, GiaBan 
                            FROM sanpham 
                            WHERE TenSP LIKE ? 
                            ORDER BY MaSP DESC 
                            LIMIT ? OFFSET ?");
    $stmt->bind_param("sii", $likeSearch, $limit, $offset);
    $stmt->execute();
    $sanpham = $stmt->get_result();
    $stmt->close();
} else {
    $tongSP = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(MaSP) AS TongSP FROM sanpham"))['TongSP'];

    $sql = "SELECT MaSP, TenSP, AnhBia, GiaBan 
            FROM sanpham 
            ORDER BY MaSP DESC 
            LIMIT $limit OFFSET $offset";
    $sanpham = mysqli_query($conn, $sql);
}

$tongTrang = ceil($tongSP / $limit);
?>

<link rel="stylesheet" href="css/bootstrap.css">

<!-- FORM TÌM KIẾM -->
<div class="col-md-12">
  <form class="search-form" action="index.php" method="GET">
    <div class="input-group">
      <input type="text" name="query" class="form-control input-lg" placeholder="Tìm sản phẩm..." value="<?= htmlspecialchars($search) ?>" required>
      <span class="input-group-btn">
        <button class="btn btn-lg btn-info" type="submit"><span class="glyphicon glyphicon-search"></span></button>
      </span>
    </div>
  </form>
</div>

<!-- FORM DANH SÁCH -->
<div>
    <hr>
    <div class="container-color text-center">
        <div class="row">
            <?php 
            $i = 0;
            while ($row = mysqli_fetch_assoc($sanpham)) { 
                if ($i > 0 && $i % 5 == 0) echo '</div><div class="row">'; 
            ?>
            <div class="col-md-2 col-sm-4 col-xs-6" style="width: 230px;">
                <div class="thumbnail text-center" style="border: solid 1px rgba(0, 165, 202, 0.37);">
                    <img src="images/<?= htmlspecialchars($row['AnhBia']) ?>" alt="Thumbnail" class="img-responsive img-rounded imgbook" style="width:180px; height:200px;" >
                    <div class="caption">
                        <h5 style="min-height: 30px;">
                            <a href="Chitietsanpham.php?id=<?= $row['MaSP'] ?>" style='color:rgb(40, 85, 96)';><?= htmlspecialchars($row['TenSP']) ?></a>
                        </h5>
                        <p style='color: rgb(255, 0, 98)'>
                            <strong><?= number_format($row['GiaBan'], 0, ',', '.') ?> VNĐ</strong>
                        </p>
                        <p>
                            <a href="Chitietsanpham.php?id=<?= $row['MaSP'] ?>&url=<?= urlencode("https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) ?>" class="btn btn-success">
                                <span class="glyphicon glyphicon-shopping-cart"></span> Thêm vào giỏ
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <?php $i++; } ?>
        </div>
    </div>
</div>

<!-- PHÂN TRANG -->
<nav class="text-center">
  <ul class="pagination">
    <!-- Trang trước -->
    <li class="<?= ($trang <= 1) ? 'disabled' : ''; ?>">
      <a href="?query=<?= urlencode($search) ?>&trang=<?= max(1, $trang - 1) ?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>

    <!-- Số trang -->
    <?php for ($i = 1; $i <= $tongTrang; $i++) : ?>
      <li class="<?= ($trang == $i) ? 'active' : ''; ?>">
        <a href="?query=<?= urlencode($search) ?>&trang=<?= $i ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>

    <!-- Trang sau -->
    <li class="<?= ($trang >= $tongTrang) ? 'disabled' : ''; ?>">
      <a href="?query=<?= urlencode($search) ?>&trang=<?= min($tongTrang, $trang + 1) ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>

<?php
$content = ob_get_clean();
include "includes/youjia_layout.php";
?>

<style>
  hr {
    border: 0;
    height: 5px !important;
    background-color: rgba(0, 95, 116, 0.53);
    margin-top: 20px;
    margin-bottom: 20px;
    width: 100%;
  }
</style>
