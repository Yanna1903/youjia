<?php
session_start();
ob_start();
include 'includes/youjia_connect.php';

// Lấy từ khóa tìm kiếm từ GET
$key = isset($_GET['query']) ? trim($_GET['query']) : '';
$key_safe = mysqli_real_escape_string($conn, $key);
$trang = isset($_GET['trang']) ? intval($_GET['trang']) : 1;
if ($trang < 1) $trang = 1;

$sql_count = "SELECT COUNT(*) AS tong FROM sanpham WHERE MaSP LIKE '%$key_safe%' OR TenSP LIKE '%$key_safe%'";
$tong = mysqli_fetch_assoc(mysqli_query($conn, $sql_count))['tong'];

// PHÂN TRANG
$spMoiTrang = 10;
$tongTrang = ceil($tong / $spMoiTrang);
$offset = ($trang - 1) * $spMoiTrang;

$sql = "SELECT MaSP, TenSP, AnhBia, GiaBan 
        FROM sanpham 
        WHERE MaSP LIKE '%$key_safe%' OR TenSP LIKE '%$key_safe%'
        ORDER BY MaSP DESC 
        LIMIT $spMoiTrang OFFSET $offset";
$result = mysqli_query($conn, $sql);
?>

<link rel="stylesheet" href="css/bootstrap.css">
<style>
    hr {
        border: 0;
        height: 5px !important;
        background-color: rgba(0, 95, 116, 0.44);
        margin-top: 20px;
        margin-bottom: 20px;
        width: 100% !important;
    }
</style>
<div>
    <h2 class="text-center"><b>KẾT QUẢ TÌM KIẾM</b></h2><hr>
    <!-- Sản phẩm -->
    <div class="container-color text-center">
        <div class="row">
            <?php 
            $i = 0;
            if ($tong > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    if ($i > 0 && $i % 5 == 0) echo '</div><div class="row">';
            ?>
            <div class="col-md-2 col-sm-4 col-xs-6" style="width: 230px;">
                <div class="thumbnail text-center">
                    <img src="images/<?= htmlspecialchars($row['AnhBia']) ?>" alt="Thumbnail" class="img-responsive img-rounded imgbook" style="width:180px; height:200px;" >
                    <div class="caption">
                        <h5 style="min-height: 30px;">
                            <a href="Chitietsanpham.php?id=<?= $row['MaSP']; ?>" style='color:rgb(40, 85, 96)';><?= htmlspecialchars($row['TenSP']); ?></a>
                        </h5>
                        <p style='color: rgb(255, 0, 98)'>
                            <strong><?= number_format($row['GiaBan'], 0, ',', '.'); ?> VNĐ</strong>
                        </p>
                        <p>
                            <a href="Chitietsanpham.php?id=<?= $row['MaSP']; ?>&url=<?= urlencode("https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) ?>" class="btn btn-success">
                                <span class="glyphicon glyphicon-shopping-cart"></span> Thêm vào giỏ
                            </a>
                        </p>
                    </div>
                </div>
            </div>
            <?php 
                    $i++;
                }
            } else {
                echo "<p class='text-center'>Không tìm thấy sản phẩm nào phù hợp với '<strong>" . htmlspecialchars($key) . "</strong>'.</p>";
            }
            ?>
        </div>
    </div>
</div>

<!-- PHÂN TRANG -->
<?php if ($tongTrang > 1): ?>
<nav class="text-center">
  <ul class="pagination">
    <!-- Trang trước -->
    <li class="<?= ($trang <= 1) ? 'disabled' : ''; ?>">
      <a href="?query=<?= urlencode($key) ?>&trang=<?= max(1, $trang - 1) ?>" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>

    <!-- Các trang giữa -->
    <?php for ($i = 1; $i <= $tongTrang; $i++): ?>
        <li class="<?= ($trang == $i) ? 'active' : ''; ?>">
            <a href="?query=<?= urlencode($key) ?>&trang=<?= $i ?>"><?= $i ?></a>
        </li>
    <?php endfor; ?>

    <!-- Trang sau -->
    <li class="<?= ($trang >= $tongTrang) ? 'disabled' : ''; ?>">
      <a href="?query=<?= urlencode($key) ?>&trang=<?= min($tongTrang, $trang + 1) ?>" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>
<?php endif; ?>

<?php
$content = ob_get_clean();
include "includes/youjia_layout.php";
?>
