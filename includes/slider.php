<?php
include 'youjia_connect.php';

// Truy vấn lấy các banner từ cơ sở dữ liệu
$sql = "SELECT * FROM banner ORDER BY NgayGio DESC";
$result = mysqli_query($conn, $sql);

$banners = []; // Đảm bảo biến được khai báo

while ($row = mysqli_fetch_assoc($result)) {
    $banners[] = $row;
}
?>

<link rel="stylesheet" href="css/bootstrap.css">

<?php if (count($banners) > 0): ?>
<div id="bannerCarousel" class="carousel slide" data-ride="carousel">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <?php foreach ($banners as $i => $row): ?>
      <li data-target="#bannerCarousel" data-slide-to="<?= $i ?>" class="<?= ($i === 0) ? 'active' : '' ?>"></li>
    <?php endforeach; ?>
  </ol>

  <!-- Slides -->
  <div class="carousel-inner">
    <?php foreach ($banners as $index => $row): ?>
      <div class="item <?= ($index === 0) ? 'active' : '' ?>">
        <a href="<?= htmlspecialchars($row['Link']) ?>">
          <img src="images/<?= htmlspecialchars($row['Banner']) ?>" alt="<?= htmlspecialchars($row['TieuDe']) ?>" style="width:100%; height:400px; object-fit:cover;">
        </a>
        <?php if (!empty($row['TieuDe'])): ?>
          <div class="carousel-caption">
            <h3><?= htmlspecialchars($row['TieuDe']) ?></h3>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#bannerCarousel" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#bannerCarousel" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
</div>
<?php else: ?>
  <p class="text-center text-muted">Không có banner nào để hiển thị.</p>
<?php endif; ?>
