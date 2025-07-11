<?php 
ob_start(); 
session_start();
include 'includes/youjia_connect.php';

$sql = "SELECT * FROM thongtin LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Giới thiệu - YOUJIA</title>
  <link rel="stylesheet" href="css/bootstrap.css">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
    }

    .about-page {
      max-width: 1140px;
      margin: 60px auto;
      padding: 50px 100px !important;
      background: #fff;
      box-shadow: 0 4px 20px rgba(70, 151, 172, 0.52);
      border-radius: 10px;
    }

    .about-page p {
      font-size: 14px;
      line-height: 1.5;
      color: #285560;
      padding-left: 30px;
    }

    .about-page .mission-box p {
      width: 350px;
      height: 120px;
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: rgba(40, 85, 96, 0.86);
      border-radius: 10px;
      padding: 30px;
      border: 2px solid rgb(87, 145, 167); 
      color: white;
      font-size: 18px;
      gap: 10px;
    }


    .about-page blockquote {
      border-left: 10px solid rgba(40, 85, 96, 0.7);
      border-bottom: 10px solid rgba(40, 85, 96, 0.7);
      border-right: 1px solid rgba(40, 85, 96, 0.7);
      border-top: 1px solid rgba(48, 67, 72, 0.7);
      background-color:rgba(202, 244, 255, 0.38);
      padding: 20px;
      align-items: center;
      border-radius: 10px;
      font-size: 22px;
      color: #285560;
      line-height: 2;
      width: 95%;
      height: 100px;
      /* display: flex; */
      justify-content: center;
      align-items: center;
    }

    .about-page ul.list-inline li {
      padding: 5px 15px;
      border-right: 1px solid #ccc;
    }

    .about-page ul.list-inline li:last-child {
      border-right: none;
    }

    .about-page .btn-primary {
      background-color: #285560;
      border-color: #1f3e45;
      /* font-size: 28px; */
      padding: 10px 25px;
      border-radius: 6px;
      color: white;
      font-size: 16px;
    }

    .about-page a {
      color: #285560;
    }

    .about-page a:hover {
      text-decoration: underline;
    }

    .img-rounded {
      border-radius: 10px;
    }

    .social-icons a {
      margin-right: 15px;
      transition: transform 0.2s ease;
    }

    .social-icons a:hover {
      transform: scale(1.2);
    }

    @media (max-width: 768px) {
      .about-page {
        padding: 20px;
      }

      .about-page .row > div {
        margin-bottom: 30px;
      }
    }
    .team-section {
      text-align: center;
      padding: 0 10px;
      background-color: rgb(30, 85, 97);
    }

    .team-members {
      display: flex;
      justify-content: center;
      gap: 40px;
      flex-wrap: wrap;
      color: white;
    }

    .member-card {
      background-color:rgb(224, 249, 255);
      border-radius: 10px;
      padding: 20px;
      width: 320px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .member-card img {
      width: 100%;
      border-radius: 12px;
      margin-bottom: 15px;

    }

    .member-card h3 {
      margin: 0;
      font-size: 20px;
      color: rgb(30, 85, 97);
    }

    .member-card p {
      color: rgb(30, 85, 97);
      margin-top: 8px;
      font-size: 14px;
    }

    h4 {
      color: rgb(30, 85, 97);
      /* font-size: 25px !important; */
    }

    h3 {
      color: rgb(30, 85, 97);
      font-size: 25px !important;
    }
    p {
      font-size: 14px !important;
      padding:0 ;
    }
    hr {
      margin: 0 auto; 
      width: 100%;
      height: 5px !important;
    }
    .about-page img.img-responsive {
      max-width: 500px;
      height: auto;
      display: block;
      margin: 0;
    }
    
    .flip-wrapper {
      display: flex;
      justify-content: center;
      gap: 40px;
      flex-wrap: wrap;
      padding: 0;
      width: 100%;
    }

    .flip-card {
      background-color: transparent;
      width: 280px;
      height: 150px;
      perspective: 1000px;
    }

    .flip-inner {
      position: relative;
      width: 100%;
      height: 100%;
      text-align: center;
      transition: transform 0.8s;
      transform-style: preserve-3d;
    }

    .flip-card:hover .flip-inner {
      transform: rotateY(180deg);
    }

    .flip-front, .flip-back {
      position: absolute;
      width: 100%;
      height: 100%;
      padding: 20px;
      backface-visibility: hidden;
      border-radius: 5px;
      display: flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 4px 4px 0px rgba(44, 111, 125, 0.42);
    }

    .flip-front {
      background-color: #2c5b65;
      color: white;
    }

    .flip-back {
      background-color: white;
      color: #2c5b65;
      transform: rotateY(180deg);
      border: 1px solid rgba(57, 123, 137, 0.42);
    }

    </style>
</head>
<body>


<div class="container about-page">

  <!-- GIỚI THIỆU -->
  <h2 class="text-center main-title"><strong>TỔNG QUAN VỀ YOUJIA</strong></h2>
  <hr>
  <div class="row">
    <div class="col-md-6">
      <img src="images/logo.jpg" alt="YOUJIA Banner" class="img-responsive img-rounded">
    </div>
    <div class="col-md-6">
      <p style="padding-left: 30px;">
        <?= $row['MoTa']?>
        <br>
        <b>Mã số thuế:</b> 
        <?= $row['MST']?>
        <br>

        <b>Đại diện pháp luật:</b> 
        <?= $row['DaiDien_PL']?>
        <br>

        <b>Địa chỉ chi nhánh: </b>
        <?= $row['DiaChi_CN']?>
      </p>
    </div>
  </div>
  <hr>
  <!-- <br>   -->
  
  <!-- MỤC TIÊU/TẦM NHÌN, SỨ MỆNH, GIÁ TRỊ CỐT LÕI -->
  <h3 class="text-center main-title"><b> MỤC TIÊU - SỨ MỆNH - GIÁ TRỊ CỐT LÕI </b></h3>
  <br>
  <div class="flip-wrapper">
    <div class="flip-card">
      <div class="flip-inner">
        <div class="flip-front">
          <h3>SỨ MỆNH</h3>
        </div>
        <div class="flip-back">
          <p style='padding:0; font-size: 16px;'><?= $row['SuMenh'] ?></p>
        </div>
      </div>
    </div>

    <div class="flip-card">
      <div class="flip-inner">
        <div class="flip-front">
          <h3>TẦM NHÌN</h3>
        </div>
        <div class="flip-back">
          <p style='padding:0; font-size: 16px;'><?= $row['TamNhin'] ?></p>
        </div>
      </div>
    </div>

    <div class="flip-card">
      <div class="flip-inner">
        <div class="flip-front">
          <h3>GIÁ TRỊ CỐT LÕI</h3>
        </div>
        <div class="flip-back">
          <p style='padding:0; font-size: 16px;'><?= $row['GiaTriCotLoi'] ?></p>
        </div>
      </div>
    </div>
  </div>
  <br>
  <hr>

  <!-- SLOGAN -->
  <div class="row text-center">
    <br>
    <div class="col-md-12">
      <blockquote>
        <?= $row['Slogan'] ?>
        <footer style='text-align: right; padding-right:20px;'>Youjia Team</footer>
      </blockquote>
    </div>
  </div>
  <hr>
  <!-- SÁNG LẬP -->
  <!-- <div class='team-section'>
    <section class="team-section" style='color: rgb(44, 91, 101);'>
      <br>
      <h2 style='text-align: center; font-size:40px; color:white'><b>ĐỘI NGŨ DAILYWEAR</b></h2>
      <br>
      <div class="team-members">
        <div class="member-card">
          <img src="images/giau.jpg" alt="Ngọc Giàu">
          <br><br><hr style='height: 3px !important;'><br>
          <h3><b>NGỌC GIÀU</b></h3>
          <p style ='color:rgb(30, 85, 97);'><b>- Đồng sáng lập -</b></p>
          <p style='font-size: 16px;'>Thiết kế & Hình ảnh</p>
        </div>

        <div class="member-card" style='color: rgb(30, 85, 97);'>
          <img src="images/van.jpg" alt="Thùy Vân">
          <br><br><hr style='height: 3px !important;'><br>
          <h3><b>THÙY VÂN</b></h3>
          <p style ='color:rgb(30, 85, 97);'><b>- Đồng sáng lập -</b></p>
          <p style='font-size: 16px;'>Truyền thông & Nội dung</p>
        </div>

        <div class="member-card">
          <img src="images/minhanh.jpg" alt="Minh Anh">
          <br><br><hr style='height: 3px !important;'><br>
          <h3><b>MINH ANH</b></h3>
          <p style ='color:rgb(30, 85, 97);'><b>- Đồng sáng lập -</b></p>
          <p style='font-size: 16px;'>Quản lý sản phẩm</p>
        </div>
        <br>
      </div>
    </section> -->
    <!-- <br><br><br><br>
  </div>
  <hr>
  <br> -->

  <!-- TT LIÊN HỆ -->
  <div class="container" style='padding: 0 20px; line-height: 1.8; color: rgb(30, 85, 97); box-sizing border-box'>
    <div class="row contact-info">
      <div class="col-md-6 mb-4">
        <h4 style='color:rgb(44, 91, 101); font-size:20px'><b>THÔNG TIN LIÊN HỆ</b></h4>
        <ul class="list-unstyled" style='font-size: 18px;'>
          <li><strong>Địa chỉ:</strong><?= $row['DiaChi_CN'] ?></li>
          
          <!-- CHƯA CÓ -->
          <li><b>Hotline:</b> <?= $row['Hotline'] ?></li>
          <li><b>Email:</b> <a href="mailto:<?= $row['Email'] ?>"><?= $row['Email'] ?></a></li>
          <li><strong>Giờ hoạt động:</strong> <?= $row['GioHoatDong'] ?></li>
        </ul>
      </div>
      <div class="col-md-6 mb-4">
        <h4 style='color:rgb(44, 91, 101); font-size:20px'><b>CHÍNH SÁCH KHÁCH HÀNG</b></h4>
        <ul class="list-unstyled" style='font-size: 18px;color: red'>
          <li style='color: red'><a href="#">Chính sách đổi/trả</a></li>
          <li style='color: red'><a href="#">Chính sách bảo mật</a></li>
          <li style='color: red'><a href="#">Hướng dẫn mua hàng</a></li>
          <li style='color: red'><a href="#">Điều khoản sử dụng</a></li>        
        </ul>
      </div>
    </div>
  </div>
  <hr><br>
  <!-- NÚT TRANG CHỦ -->
  <div class="text-center">
    <a href="index.php" class="btn btn-success">
      <span class="glyphicon glyphicon-home"></span> Trở về Trang chủ
    </a>
  </div>
</div>

<style>  
  .btn-success{
    background-color: rgb(65, 151, 171);
    border: 1px rgb(49, 111, 125);
    color: white !important;
  }
  .btn-success:hover, .btn-success:focus {
      background-color: rgb(28, 98, 114) !important;
      border: 1px rgb(28, 98, 114);
      color: white !important;
  }

</style>
<?php
$content = ob_get_clean();
include "includes/youjia_layout.php";
?>
