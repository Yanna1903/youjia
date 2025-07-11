<?php
include 'youjia_connect.php';

// Lấy URL tuyệt đối gốc
$baseURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http")
    . "://" . $_SERVER['HTTP_HOST']
    . dirname($_SERVER['PHP_SELF']) . "/";

$sql = "SELECT * FROM banner ORDER BY NgayGio DESC";
$result = mysqli_query($conn, $sql);

$banners = [];
while ($row = mysqli_fetch_assoc($result)) {
    $banners[] = $row;
}
?>

<!-- CSS & JS Bootstrap -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<?php if (count($banners) > 0): ?>
<div id="bannerCarousel" class="carousel slide" data-ride="carousel" data-interval="4000">
  <!-- Dấu chấm -->
  <ol class="carousel-indicators">
    <?php foreach ($banners as $i => $row): ?>
      <li data-target="#bannerCarousel" data-slide-to="<?= $i ?>" class="<?= ($i === 0) ? 'active' : '' ?>"></li>
    <?php endforeach; ?>
  </ol>

  <!-- Slide ảnh -->
  <div class="carousel-inner">
    <?php foreach ($banners as $i => $row): 
        $imgURL = $baseURL . "/YOUJIA/images/slider/" . $row['Banner']; ?>
      <div class="carousel-item <?= ($i === 0) ? 'active' : '' ?>">
        <?php if (!empty($row['Link'])): ?>
          <a href="<?= htmlspecialchars($row['Link']) ?>" target="_blank">
            <img src="<?= $imgURL ?>" class="d-block w-100" style="height: 400px; object-fit: cover;">
          </a>
        <?php else: ?>
          <img src="<?= $imgURL ?>" class="d-block w-100" style="height: 400px; object-fit: cover;">
        <?php endif; ?>

        <?php if (!empty($row['TieuDe'])): ?>
          <div class="carousel-caption d-none d-md-block">
            <h3 style="background: rgba(0,0,0,0.6); padding: 10px 20px; border-radius: 10px;">
              <?= htmlspecialchars($row['TieuDe']) ?>
            </h3>
          </div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Nút chuyển -->
  <a class="carousel-control-prev" href="#bannerCarousel" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#bannerCarousel" role="button" data-slide="next">
    <span class="carousel-control-next-icon"></span>
  </a>
</div>
<?php else: ?>
  <p class="text-center text-muted">Không có banner nào để hiển thị.</p>
<?php endif; ?>
