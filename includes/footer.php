<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<!-- footer  -->
<?php
include 'youjia_connect.php';
$sql = "SELECT * FROM thongtin LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

?>
<style>  

  .footer-container {
    background-color: #285560;
    /* border-radius: 12px; */
    padding: -50px;
    border-top: 2px solid  #e8f6f8;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    box-shadow: 0 -2px 10px rgba(66, 153, 175, 0.56);
  }
  
  .footer-inner {
    display: flex;
    justify-content: space-between;
    max-width: 1200px;
    margin: auto;
    padding: 0 40px; 
    gap: 20px;
    flex-wrap: wrap;
  }
  
  .footer-column {
    flex: 1;
    min-width: 250px;
  }
  
  .footer-column h5 {
    color:rgb(255, 255, 255);
    font-size: 14px;
    
    margin-bottom: 10px;
    text-transform: uppercase;
  }
  
  .footer-column p, .footer-column a {
    color:rgb(211, 246, 255);
    font-size: 14px;
    line-height: 1.8;
    text-decoration: none;
  }
  
  .footer-column a:hover {
    color: white;
    text-decoration: underline;

  }
  
  
  @media (max-width: 768px) {
    .footer-container {
      flex-direction: column;
      align-items: center;
      text-align: center;
    }
  
    .footer-column {
      margin-bottom: 20px;
    }
  }

</style>  
<footer class="footer-container">
  <div class="footer-inner">
    <div class="footer-column">
      <h5><b>GIỚI THIỆU</b></h5>
      <p>
        <?= $row['MoTa'] ?>            
        <br>
        <b>Giờ hoạt động: </b>
        <?= $row['GioHoatDong']?>
      </p>
    </div>

    <div class="footer-column">
      <h5><b>THÔNG TIN LIÊN HỆ</b></h5>
      <p>
        <b>Hotline: </b> 
        <?= $row['Hotline']?>
        <br>
        <b>Email: </b>
        <?= $row['Email']?>
        <br>
        <b>Địa chỉ chi nhánh: </b>
        <?= $row['DiaChi_CN']?>
      </p>
    </div>
    <div class="footer-column">
          <h5><b>CHÍNH SÁCH & ĐIỀU KHOẢN</b></h5>
          <p>
            <a href="#">Chính sách đổi trả</a> <br>
            <a href="#">Hướng dẫn mua hàng</a> <br>
            <a href="#">Chính sách đổi trả</a> <br>
            <a href="#">Hướng dẫn mua hàng</a> <br>
          </p>
    </div>
  </div>
</footer>
