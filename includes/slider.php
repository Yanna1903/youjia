<?php
include 'includes/youjia_connect.php';
$sql = "SELECT * FROM banner ORDER BY NgayGio DESC";
$result = mysqli_query($conn, $sql);
$banners = [];
while ($row = mysqli_fetch_assoc($result)) {
    $banners[] = $row;
}
?>

<div id="bannerCarousel" class="carousel slide" data-ride="carousel" style="margin-top: 20px;">
  <!-- Indicators -->
  <ol class="carousel-indicators">
    <?php foreach ($banners as $i => $row): ?>
      <li data-target="#bannerCarousel" data-slide-to="<?= $i ?>" class="<?= ($i === 0) ? 'active' : '' ?>"></li>
    <?php endforeach; ?>
  </ol>

  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
    <?php foreach ($banners as $i => $row): ?>
      <div class="item <?= ($i === 0) ? 'active' : '' ?>">
        <a href="<?= htmlspecialchars($row['Link']) ?>" target="_blank">
        <img src="/YOUJIA/images/slider/<?= htmlspecialchars($row['Banner']) ?>" alt="Banner" style="width:100%; height:450px; object-fit:cover; border-radius:8px;">
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#bannerCarousel" role="button" data-slide="prev"></a>
  <a class="right carousel-control" href="#bannerCarousel" role="button" data-slide="next"> </a>
</div>
<style>
#bannerCarousel {
  margin-bottom: 10px;
  width: 1150px;     /* nhỏ lại */
  margin-left: auto;
  margin-right: auto;  /* canh giữa */
}
#bannerCarousel .carousel-inner img {
  height: 200px !important;
  width: 100%;
  object-fit: cover;
  border-radius: 8px;
}
#bannerCarousel .carousel-caption h3 {
  font-size: 28px;
  background: rgba(0,0,0,0.5);
  padding: 10px 20px;
  border-radius: 8px;
}
@media (max-width: 768px) {
  #bannerCarousel {
    width: 95%;
  }
  #bannerCarousel .carousel-inner img {
    height: 250px;
  }
  #bannerCarousel .carousel-caption h3 {
    font-size: 18px;
  }
}

</style>
