<?php
ob_start();
session_start();
include("includes/youjia_connect.php");

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    header("Location: DKDN.php");
    exit();
}

$username = $_SESSION['username'];

// Lấy thông tin khách hàng ngay khi trang load (cả GET và POST)
$stmtKH = $conn->prepare("SELECT MaKH, TenKH, SDT, DiaChi FROM khachhang WHERE username = ?");
$stmtKH->bind_param("s", $username);
$stmtKH->execute();
$resultKH = $stmtKH->get_result();
$rowKH = $resultKH->fetch_assoc();
$MaKH = $rowKH['MaKH'];
$TenKH = $rowKH['TenKH'];
$SDT = $rowKH['SDT'];
$DiaChi = $rowKH['DiaChi']; 
$stmtKH->close();

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($cart)) {
    $DiaChi = $_POST['diachi'];
    $TrangThai = "1";

    // Tính tổng tiền đơn hàng từ giỏ hàng
    $TongTien = 0;
    foreach ($cart as $item) {
        $TongTien += $item['SoLuong'] * $item['GiaBan'];
    }

    $NgayGiao = date("Y-m-d", strtotime("+14 days"));
    // Tạo đơn hàng và lưu tổng tiền
    $sqlDH = "INSERT INTO donhang (MaKH, NgayDH, DiaChi, TrangThai, NgayGiao, TongTien) VALUES (?, NOW(), ?, 1, ?,?)";
    $stmtDH = $conn->prepare($sqlDH);
    if (!$stmtDH) {
        die("Lỗi đơn hàng: " . $conn->error);
    }
    $stmtDH->bind_param("issd", $MaKH,$DiaChi,$NgayGiao,$TongTien);

    $stmtDH->execute();
    $MaDH = $stmtDH->insert_id;
    $stmtDH->close();

    // Lưu chi tiết đơn hàng
    $sqlCT = "INSERT INTO chitietdathang (MaDH, MaSP, SoLuong, DonGia, ThanhTien, MauSac) VALUES (?, ?, ?, ?, ?, ?)";
    $stmtCT = $conn->prepare($sqlCT);
    if (!$stmtCT) {
        die("Lỗi chi tiết đơn hàng: " . $conn->error);
    }

    foreach ($cart as $item) {
        $MaSP = $item['MaSP'];
        $SoLuong = $item['SoLuong'];
        $DonGia = $item['GiaBan'];
        $ThanhTien = $SoLuong * $DonGia;
        $MauSac = isset($item['MauSac']) ? $item['MauSac'] : null;

        $stmtCT->bind_param("isidds", $MaDH, $MaSP, $SoLuong, $DonGia, $ThanhTien, $MauSac);
        $stmtCT->execute();
    }
    $stmtCT->close();

    // Xoá giỏ hàng
    unset($_SESSION['cart']);

    echo "<script>alert('Đặt hàng thành công!'); window.location='xemDH.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Đặt hàng</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <style>
   /* Bảng giỏ hàng */
   table {
    width: 900px !important;
    border-collapse: collapse;
    text-align: center;
    margin: 0 auto;  /* Căn giữa bảng */
    color: #285560 !important;
    background-color: white !important;
}

hr {
  border: none;
  border-top: 5px solid rgba(40, 85, 96, 0.32); 
  width: 100%; /* Chiều dài của thẻ hr, có thể điều chỉnh */
  height: 5px !important;
  margin: 20px auto; /* Căn giữa và tạo khoảng cách phía trên/dưới */
  display: block; /* Đảm bảo thẻ hr có kiểu hiển thị block */
}

h2 {
    color: #285560 !important;
    text-align: center;
}
H4, label {
  color: #285560 !important;
}
table th, table td {
    padding: 10px;
    text-align: center;
    border: 1px solid rgba(40, 85, 96, 0.43) !important;
    background-color: white !important;
}

table th {
    font-weight: bold;
    background-color:rgb(225, 249, 255) !important;

}

.btn-success{
    background-color: rgb(68, 143, 160) !important;
    border: 1px rgb(49, 111, 125);
    padding: 8px 4px 4px 4px !important;
}
.btn-success:hover, .btn-success:focus {
    background-color: rgb(28, 98, 114) !important;
    border: 1px rgb(28, 98, 114);

}
.btn-a{
    background-color: rgb(68, 143, 160) !important;
    border: 1px rgb(49, 111, 125);
    padding: 6px 4px 4px 4px !important;
    width: 100%;
    height: 40px;
    color: #fff;
}
.btn-a:hover, .btn-a:focus {
    background-color: rgb(28, 98, 114) !important;
    border: 0.1px solid rgb(28, 98, 114);
    color: #fff !important;
}

input {
  background-color: white;   
  /* background-position: 10px 10px;    */
  /* background-repeat: no-repeat;   */
  border: 1px solid  rgba(35, 136, 158, 0.57)!important;
  width: 80% !important;
  outline : none;
  padding: 0 10px;
}

input:hover , input:focus {
  background-color: white;   
  background-position: 10px 10px;   
  background-repeat: no-repeat;  
  border: 1px solid  rgb(0, 95, 116)!important;
  width: 80% !important;
}

.order-ahihi {
  background: #ffffff;
  padding: 20px;
  border-radius: 12px;
  border: 1px solid #e0e0e0;
  box-shadow: 0 4px 12px rgba(38, 98, 112, 0.59);
  max-width: 1000px;
  margin: 20px auto;
  color: #285560;  
  margin-bottom: 50px;
}
</style>
</head>
<body>
  <div class='order-ahihi mt-5'> 
    <h2><b>XÁC NHẬN ĐẶT HÀNG </b></h2>
    <hr>
    <?php if (empty($cart)): ?>
        <p>Giỏ hàng của bạn đang trống.</p>
    <?php else: ?>

      <form method="post">
        <h4>&emsp;A. THÔNG TIN ĐƠN HÀNG</h4>
        <p>&emsp;&emsp;&emsp; <b>Tên khách hàng: </b> &emsp;<?= htmlspecialchars($TenKH) ?></p>
        <p>
          &emsp;&emsp;&emsp; <b>Số điện thoại: </b>&emsp;
          <input type="text" name="sdt" value="<?= htmlspecialchars($SDT) ?>" style="width: 400px;" readonly>
        </p>
        <p>
          &emsp;&emsp;&emsp; <b>Địa chỉ: </b>&emsp;&emsp;&emsp;&emsp;
          <input type="text" name="diachi" value="<?= htmlspecialchars($DiaChi) ?>" style="width: 400px;" readonly>
        </p>
        <HR>
          <h4>&emsp;B. THÔNG TIN ĐƠN HÀNG</h4>
          <table border="1" cellpadding="8" cellspacing="0">
              <tr>
                  <th width=15%>Tên sản phẩm</th>
                  <!-- <th>Size</th> -->
                  <th width=10%>Màu</th>
                  <th width=10%>Đơn giá</th>
                  <th width=5%>Số lượng</th>
                  <th width=5%>Thành tiền</th>
              </tr>
              <?php
              $tongTien = 0;
              foreach ($cart as $item):
                  $thanhTien = $item['SoLuong'] * $item['GiaBan'];
                  $tongTien += $thanhTien;
              ?>
              <tr>
                  <td><?= htmlspecialchars($item['TenSP']) ?></td>
                  <!-- <td><?= htmlspecialchars($item['Size'] ?? '-') ?></td> -->
                  <td><?= htmlspecialchars($item['MauSac'] ?? '-') ?></td>
                  <td><?= number_format($item['GiaBan'], 0, ',', '.') ?>₫</td>
                  <td><?= $item['SoLuong'] ?></td>
                  <td><?= number_format($thanhTien, 0, ',', '.') ?>₫</td>
              </tr>
              <?php endforeach; ?>
              <tr style='color: red; font-size:16px;'>
                  <td colspan="4" align="right"><strong>Tổng tiền:</strong></td>
                  <td><strong><?= number_format($tongTien, 0, ',', '.') ?>₫</strong></td>
              </tr>
          </table>
          <BR>
          <button type="submit" class="btn btn-a">ĐẶT MUA</button>
        </form>
    <?php endif;?>
  </div>
<?php
$content = ob_get_clean();
include "includes/youjia_layout.php"; 
?>
</body>
</html>
