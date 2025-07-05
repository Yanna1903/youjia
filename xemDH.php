<?php
ob_start();
session_start();
include "includes/youjia_connect.php";
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Vui lòng đăng nhập để xem đơn hàng.'); window.location.href='dangnhap.php';</script>";
    exit;
}

$username = $_SESSION['username'];

$stmt = $conn->prepare("SELECT MaKH, TenKH FROM khachhang WHERE Username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($MaKH, $TenKH);
$stmt->fetch();
$stmt->close();

$sql = "SELECT MaDH, NgayDH, NgayGiao, TrangThai, TongTien FROM donhang WHERE MaKH = ? ORDER BY NgayDH DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $MaKH);
$stmt->execute();
$result = $stmt->get_result();
?>
<div class="order-container mt-5">
    <h2 class="text-center">ĐƠN HÀNG CỦA BẠN</h2>
    <hr>
    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead style='text-align: center'>
                <tr>
                    <th width='5%' style='text-align: center' >Mã đơn</th>
                    <th width='10%'>Ngày đặt</th>
                    <th width='10%'>Ngày giao (dự kiến)</th>
                    <th width='10%' style='text-align: center' >Trạng thái</th>
                    <th width='10%'style='text-align: center' >Tổng tiền VNĐ</th>
                    <th width='5%' style='text-align: center' >Chi tiết</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <?php
                    $MaDH = $row['MaDH'];
                    $TongTien= $row['TongTien'];
                    $tong_stmt = $conn->prepare("SELECT SUM(ThanhTien) AS TongTien FROM chitietdathang WHERE MaDH = ?");
                    $tong_stmt->bind_param("i", $MaDH);
                    $tong_stmt->execute();
                    $tong_result = $tong_stmt->get_result();
                    $tong_row = $tong_result->fetch_assoc();
                    $TongTien = $tong_row['TongTien'];
                    $tong_stmt->close();
                    ?>
                    <tr>
                        <td>#<?php echo $MaDH; ?></td>
                        <td><?php echo $row['NgayDH']; ?></td>
                        <td><?php echo $NgayGiao = date("Y-m-d", strtotime("+14 days"));?></td>
                        <td style='text-align: center'>
                            <?php
                            switch ($row['TrangThai']) {
                                case 1: echo "Đang xử lý"; break;
                                case 2: echo "Đã giao"; break;
                                case 3: echo "Đã huỷ"; break;
                            }
                            ?>
                        </td>
                        <td style='text-align: center'><B><?php echo number_format($TongTien, 0, ',', '.'); ?></B></td>
                        <td><a href="ChitietDonHang.php?MaDH=<?php echo $MaDH; ?>" class="btn btn-info">Xem chi tiết</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning text-center">Bạn chưa có đơn hàng nào.</div>
    <?php endif; ?>
</div>
    </div>
    </div>
<?php 
$content = ob_get_clean();
include "includes/youjia_layout.php"; ?>


<style>
/* === Đồng bộ tone với Header/Footer === */
.order-container {
  background: #ffffff;
  padding: 30px;
  border-radius: 12px;
  border: 1px solid #e0e0e0;
  box-shadow: 0 4px 12px rgb(65, 151, 171);
  max-width: 1000px;
  margin: 50px auto;
  color: #285560;  
}

.order-container h2 {
  color: #285560;        /* xanh đậm header/footer */
  margin-bottom: 25px;
  font-weight: 700;
}

/* Table header */
.table thead th {
  background-color:rgb(35, 120, 139);  /* xanh đậm */
  color: #fff;
  font-weight: 600;
  border: none;
}

/* Table body */
.table,
.table th,
.table td {
  border: 1px solid #ddd;
}

.table tbody td {
  vertical-align: middle;
}

/* Tổng tiền đỏ nổi bật */
.table tbody tr:last-child td:nth-child(4) {
  color: red;
  font-weight: bold;
}

/* Nút Xem chi tiết */
.btn-info {
    background-color: rgb(65, 151, 171);
    border: 1px rgb(49, 111, 125);
    width: 100%;
    height: 30px;
    font-size: 12px !important;
    padding: 5px 0 !important;
}

.btn-info:hover {
    background-color: rgb(28, 98, 114) !important;
    border: 1px rgb(28, 98, 114);}

/* Hover dòng bảng nhẹ */
.table tbody tr:hover {
  background-color: #f5f9fa;
}

/* Di động: giữ padding và font đẹp */
@media (max-width: 576px) {
  .order-container { padding: 20px; }
  .table thead th, .table td { font-size: 14px; padding: 8px; }
  .btn-info { padding: 6px 10px; font-size: 14px; }
}
hr {
  border: none;
  border-top: 5px solid rgba(40, 85, 96, 0.32); 
  width: 50%; /* Chiều dài của thẻ hr, có thể điều chỉnh */
  margin: 20px auto; /* Căn giữa và tạo khoảng cách phía trên/dưới */
  display: block; /* Đảm bảo thẻ hr có kiểu hiển thị block */
}
</style>
