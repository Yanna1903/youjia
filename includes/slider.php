<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Shop Quần Áo – Slider</title>

  <!-- Bootstrap CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />

  <style>
    #sliderShop img {
      height: 450px;
      object-fit: cover;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
  </style>
</head>
<body>
  <div class="container my-5">
    <div
      id="sliderShop"
      class="carousel slide"
      data-bs-ride="carousel"
      data-bs-interval="4000"
      data-bs-pause="false"
    >
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img
            src="images/slider/Banner_Youjia.png"
            class="d-block w-100"
            alt="Slider Bizweb"
          />
        </div>
        <div class="carousel-item">
          <img
            src="https://theme.hstatic.net/1000090364/1001154354/14/slider_1.jpg?v=675"
            class="d-block w-100"
            alt="Slider Haravan 1"
          />
        </div>
        <div class="carousel-item">
          <img
            src="https://theme.hstatic.net/1000058447/1001051940/14/slider_3.jpg?v=2101"
            class="d-block w-100"
            alt="Slider Haravan 2"
          />
        </div>
        <div class="carousel-item">
          <img
            src="https://theme.hstatic.net/1000406613/1000898030/14/slider_1.jpg?v=146"
            class="d-block w-100"
            alt="Slider Haravan 3"
          />
        </div>
        <div class="carousel-item">
          <img
            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTArr7SIEtTvYXL0GzlfgTPDikC5s1sBzeWdg&s"
            class="d-block w-100"
            alt="Slider Pinterest"
          />
        </div>
        <div class="carousel-item">
          <img
            src="https://png.pngtree.com/png-slide/20210517/ourmid/7-pngtree-green-contemporary-summer-break-google-slides-and-powerpoint-template-background_5295.jpg"
            class="d-block w-100"
            alt="Slider Summer"
          />
        </div>
      </div>

      <button
        class="carousel-control-prev"
        type="button"
        data-bs-target="#sliderShop"
        data-bs-slide="prev"
      >
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      </button>
      <button
        class="carousel-control-next"
        type="button"
        data-bs-target="#sliderShop"
        data-bs-slide="next"
      >
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
      </button>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
