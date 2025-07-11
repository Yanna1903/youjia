<?php
session_start();
ob_start();
include "includes/youjia_connect.php";
include "includes/header.php";

if (!isset($_SESSION['username'])) {
    echo "<script>
            alert('Vui lòng đăng nhập để xem chi tiết đơn hàng.');
            window.location.href='dangnhap.php';
          </script>";
    exit;
}

if (!isset($_GET['MaDH'])) {
    echo "<div class='alert alert-danger text-center'>Không tìm thấy mã đơn hàng.</div>";
    include "includes/footer.php";
    exit;
}

$MaDH = intval($_GET['MaDH']);
$username = $_SESSION['username'];

$stmt = $conn->prepare("
    SELECT d.MaDH, d.NgayDH, d.NgayGiao, d.TrangThai, k.TenKH, k.SDT, k.DiaChi, k.MaKH
    FROM donhang d
    JOIN khachhang k ON d.MaKH = k.MaKH
    WHERE d.MaDH = ? AND k.Username = ?
");
$stmt->bind_param("is", $MaDH, $username);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    echo "<div class='alert alert-danger text-center'>Bạn không có quyền xem đơn hàng này.</div>";
    include "includes/footer.php";
    exit;
}
$order = $result->fetch_assoc();
$stmt->close();

$sql = "
    SELECT ct.SoLuong, ct.DonGia, ct.ThanhTien, ct.MauSac, sp.TenSP
    FROM chitietdathang ct
    JOIN sanpham sp ON ct.MaSP = sp.MaSP
    WHERE ct.MaDH = ?
";
$stmt_ct = $conn->prepare($sql);
$stmt_ct->bind_param("i", $MaDH);
$stmt_ct->execute();
$res_ct = $stmt_ct->get_result();
$total = 0;
$details = [];
while ($row = $res_ct->fetch_assoc()) {
    $total += $row['ThanhTien'];
    $details[] = $row;
}
$stmt_ct->close();
?>
    <link rel="stylesheet" href="css/bootstrap.css">

<style>
/* === ORDER DETAIL PAGE === */
.order-container {
  background: #fff;
  padding: 0 50px;
  border-radius: 12px;
  border: 1px solid rgba(49, 111, 125, 0.44);
  box-shadow: 4px 8px  rgba(44, 152, 176, 0.66);
  width: 60%;
  margin: 40px auto;
  font-family: 'Segoe UI', Tahoma, Verdana, sans-serif;
  height: auto;
}

.order-container h2 {
  text-align: center;
  color: rgb(49,111,125);
  font-size: 30px;
  margin-bottom: 20px;
}

.order-container hr {
  border: none;
  height: 5px;
  background: rgba(49,111,125,0.3);
  margin: 20px 0;
}

.oc-dates {
  text-align: center;
  margin-bottom: 10px !important;
}
.oc-dates p {
  font-size: 16px;
  color: rgb(49,111,125);
  margin: 8px 0;
  font-style: italic;
}

.order-container h5.section-title {
  font-size: 16px;
  color: rgb(49,111,125);
  margin: 10px 0;
}
.oc-customer {
  display: flex;
  gap: 30px;
  flex-wrap: wrap;
}
.oc-customer .col-half {
  flex: 1;
}
.oc-customer p {
  font-size: 14px;
  color: rgb(49,111,125);
  margin: 6px 0;
}

.order-container h5.subheader {
  font-size: 16px;
  color: rgb(49,111,125);
  margin: 20px 0 10px;
}
.order-table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}
.order-table th,
.order-table td {
  border: 2px solid rgba(49,111,125,0.3);
  padding: 12px 8px;
  text-align: center;
}
.order-table thead th {
  background: rgba(225, 250, 255, 0.73);
  color: rgb(49,111,125);
  font-weight: 600;
}
.order-table tbody tr:nth-child(even) {
  background: rgb(255, 255, 255);
}
.order-table .total-row td {
  font-size: 14px;
  font-weight: bold;
  color: blue;
}
hr{
  width: 100%;
}
.btn-back {
  display: block;
  width: 100%;
  height: 35px;
  margin: 10px 3px;
  color: #fff;
  text-align: center;
  padding: 5px 8px;
  text-decoration: none;
  border-radius: 6px;
  transition: background 0.3s;
  background-color: rgb(65, 151, 171);
  border: 1px rgb(49, 111, 125);
  font-size: 18px !important;
  font-size: 16px !important;
}
.btn-back:hover {
  background-color: rgb(28, 98, 114) !important;
  border: 1px rgb(28, 98, 114);
  color: #fff;
}

@media (max-width: 600px) {
  .oc-customer {
    flex-direction: column;
  }
  .order-container {
    padding: 16px;
    margin: 20px;
  }
  .order-container h2 {
    font-size: 22px;
  }
  .oc-dates p,
  .oc-customer p {
    font-size: 14px;
  }
  .order-table th,
  .order-table td {
    font-size: 14px;
    padding: 8px;
  }
}
</style>

<div class="order-container">
  <h2>CHI TIẾT ĐƠN HÀNG #<?= htmlspecialchars($order['MaDH']) ?></h2>
  <hr>

  <div class="oc-dates">
    <p>Ngày đặt hàng: <strong><?= date('d/m/Y H:i', strtotime($order['NgayDH'])) ?></strong></p>
    <p>Dự kiến giao hàng vào: <strong><?= $order['NgayGiao'] ? date('d/m/Y', strtotime($order['NgayGiao'])) : 'Chưa cập nhật' ?></strong></p>
    <p>Trạng thái: <strong>
      <?php        
        switch ($order['TrangThai']) {
          case 1: echo 'Chờ xác nhận'; break;
          case 2: echo 'Đã xác nhận'; break;
          case 3: echo 'Đang giao'; break;
          case 4: echo 'Đang giao'; break;
        }
      ?>
    </strong></p>
  </div>

  <hr>

  <h5 class="section-title"><b>A. THÔNG TIN KHÁCH HÀNG</b></h5>
  <div class="oc-customer">
    <div class="col-half">
      <p>Mã khách hàng: <?= htmlspecialchars($order['MaKH']) ?></p>      
      <p>Tên khách hàng: <?= htmlspecialchars($order['TenKH']) ?></p>
    </div>
    <div class="col-half">
      <p>Số điện thoại: <?= htmlspecialchars($order['SDT']) ?></p>
      <p>Địa chỉ: <?= htmlspecialchars($order['DiaChi']) ?></p>
    </div>
  </div>

  <hr>

  <h5 class="section-title"><b>B. CHI TIẾT SẢN PHẨM</b></h5>
  <table class="order-table">
    <thead>
      <tr>
        <th>Sản phẩm</th>
        <th>Số lượng</th>
        <th>Màu sắc</th>
        <th>Đơn giá</th>
        <th>Thành tiền</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($details as $d): ?>
        <tr>
          <td><?= htmlspecialchars($d['TenSP']) ?></td>
          <td><?= $d['SoLuong'] ?></td>
          <td><?= htmlspecialchars($d['MauSac']) ?></td>
          <td><?= number_format($d['DonGia'],0,',','.') ?> VNĐ</td>
          <td><?= number_format($d['ThanhTien'],0,',','.') ?> VNĐ</td>
        </tr>
      <?php endforeach; ?>
      <tr class="total-row">
        <td colspan="4">TỔNG CỘNG</td>
        <td><?= number_format($total,0,',','.') ?> VNĐ</td>
      </tr>
    </tbody>
  </table>

  <a href="xemDH.php" class="btn-back">&larr; Quay lại</a>
</div>

<?php 
$conn->close(); 
include "includes/footer.php"; 
?>
