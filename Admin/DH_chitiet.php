<?php
    ob_start();
    include '../includes/youjia_connect.php';

// Lấy ID đơn hàng từ URL
$MaDH = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Xử lý cập nhật trạng thái đơn hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $TrangThai = intval($_POST['TrangThai']);
    $updateSql = "UPDATE donhang SET TrangThai = ? WHERE MaDH = ?";
    if ($stmt = $conn->prepare($updateSql)) {
        $stmt->bind_param("ii", $TrangThai, $MaDH);
        $stmt->execute();
        $stmt->close();
    }
}

// Lấy thông tin đơn hàng và khách hàng
$sql = "SELECT dh.MaDH, dh.NgayDH, dh.NgayGiao, dh.TrangThai,
               kh.TenKH, kh.SDT, kh.DiaChi
        FROM donhang dh
        JOIN khachhang kh ON dh.MaKH = kh.MaKH
        WHERE dh.MaDH = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $MaDH);
    $stmt->execute();
    $result = $stmt->get_result();
    $order = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "<p>Có lỗi khi truy vấn đơn hàng.</p>";
    exit;
}

if (!$order) {
    echo "<p>Đơn hàng không tồn tại.</p>";
    exit;
}

// Các trạng thái đơn hàng
$trangThaiArr = [
    1 => 'Chờ xác nhận',
    2 => 'Đã xác nhận',
    3 => 'Đang giao',
    4 => 'Đã giao',
    5 => 'Hoàn đơn hàng',
];
?>

<style>
.order-container {
    max-width: 800px;
    margin: auto;
    padding: 20px;
    background: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
.order-container h2, .order-container h3 {
    text-align: center;
    color: #333;
}
.order-container ul { list-style: none; padding: 0; }
.order-container li { padding: 10px; border-bottom: 1px solid #ddd; }
.order-container .form-group { display: flex; align-items: center; margin-bottom: 15px; }
.order-container .form-group strong { width: 150px; }
.order-container select { flex: 1; padding: 5px; }
.order-container .button-group { text-align: center; margin-top: 20px; }
.btn-primary { background-color: #007bff; color: white; padding: 8px 16px; border: none; }
.btn-secondary { background-color:rgb(255, 255, 255); color: white; padding: 8px 16px; text-decoration: none; }
.table { width: 100%; border-collapse: collapse; margin-top: 20px; }
.table th, .table td { border: 1px solid #ddd; padding: 8px; }
.table th { background-color: #f2f2f2; }
.text-center { text-align: center; }
.text-right { text-align: right; }
</style>
<br>

<br>
<div class="order-container">
    <h2><b>CHI TIẾT ĐƠN HÀNG</b></h2>
    <hr>
    <form method="post">
        <h4><b>A. THÔNG TIN KHÁCH HÀNG</b></h4>
        <ul>
            <li><strong>&emsp;&emsp;Họ và tên:</strong> <?php echo htmlspecialchars($order['TenKH']); ?></li>
            <li><strong>&emsp;&emsp;Số điện thoại:</strong> <?php echo htmlspecialchars($order['SDT']); ?></li>
            <li><strong>&emsp;&emsp;Địa chỉ:</strong> <?php echo htmlspecialchars($order['DiaChi']); ?></li>
        </ul>
        <hr>
        <h4><b>B. THÔNG TIN ĐƠN HÀNG<b></h4>
        <ul>
            <li><strong>Mã đơn hàng:</strong> <?php echo $order['MaDH']; ?></li>
            <li><strong>Ngày đặt hàng:</strong> <?php echo $order['NgayDH']; ?></li>
            <li><strong>Ngày giao hàng:</strong> <?php echo $order['NgayGiao']; ?></li>

            <li class="form-group">
                <strong>Trạng thái đơn:</strong>
                <select name="TrangThai">
                    <?php foreach ($trangThaiArr as $key => $label) { ?>
                        <option value="<?php echo $key; ?>" <?php echo ($order['TrangThai'] == $key) ? 'selected' : ''; ?>>
                            <?php echo $label; ?>
                        </option>
                    <?php } ?>
                </select>
            </li>
        </ul>

        <div class="button-group">
            <button type="submit" class="btn-primary">Cập nhật</button>
            <a href="QL_DH.php" class="btn-secondary">Quay về</a>
        </div>
    </form>
</div>
<h4 class="text-center">CHI TIẾT SẢN PHẨM ĐƠN HÀNG</h3>
<table class="table">
    <tr>
        <th class="text-center">Mã SP</th>
        <th>Tên SP</th>
        <th class="text-center">Số lượng</th>
        <th class="text-center">Đơn giá</th>
    </tr>
    <?php
    // Lấy chi tiết đơn hàng và lấy đơn giá từ bảng sanpham
    $sql = "SELECT ct.MaSP, sp.TenSP, ct.SoLuong, sp.GiaBan
            FROM chitietdathang ct
            JOIN sanpham sp ON ct.MaSP = sp.MaSP
            WHERE ct.MaDH = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $MaDH);
        $stmt->execute();
        $result = $stmt->get_result();
        $tongTien = 0;
        while ($row = $result->fetch_assoc()) {
            $DonGia = $row['GiaBan'];
            $SoLuong = $row['SoLuong'];
            $tongTien += $SoLuong * $DonGia;
            echo '<tr>';
            echo '<td class="text-center">'. $row['MaSP'] .'</td>';
            echo '<td>'. htmlspecialchars($row['TenSP']) .'</td>';
            echo '<td class="text-center">'. $SoLuong .'</td>';
            echo '<td class="text-center">'. number_format($DonGia,0,',','.') .' VND</td>';
            echo '</tr>';
        }
        $stmt->close();
    }
    ?>
    <tr>
        <td colspan="3" class="text-right"><strong>Tổng tiền:</strong></td>
        <td class="text-center"><strong><?php echo number_format($tongTien,0,',','.'); ?> VND</strong></td>
    </tr>
</table>

<?php
$conn->close();
$content = ob_get_clean();
include 'Layout_AD.php';
?>

<style>
/* Tổng thể layout của đơn hàng */
.order-container {
    max-width: 900px;
    margin: 20px auto;
    padding: 20px;
    background-color: white;      /* nền hồng nhạt */
    border: 1px solid rgb(0, 94, 116);      /* viền hồng */
    border-radius: 4px;
    box-shadow: 0 0 10px rgba(244, 143, 177, 0.3);
    font-family: Arial, sans-serif;
}
hr {
        border: 0;
        height: 5px !important;
        background-color: rgba(0, 95, 116, 0.44);
        margin-top: 20px;
        margin-bottom: 20px;
        width: 100%;
    }
/* Tiêu đề chính */
.order-container h2 {
    text-align: center;
    color: rgb(0, 94, 116);                /* hồng đậm */
    font-size: 24px;
    margin-bottom: 20px;
}

/* Tiêu đề phần thông tin khách hàng */
.order-container h4 {
    color: rgb(0, 94, 116);
    font-size: 20px;
    margin-bottom: 10px;
}

/* Danh sách thông tin khách hàng */
.order-container ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.order-container li {
    font-size: 16px;
    margin-bottom: 10px;
    padding: 5px 0;
    border-bottom: 0px solid #f8bbd0;
}

.order-container li strong {
    color: rgb(0, 94, 116);                /* hồng hơi tối */
}

/* Các form group (select dropdowns) */
.order-container .form-group {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.order-container select {
    padding: 8px;
    font-size: 16px;
    width: 50%;
    border: 1px solid #f48fb1;
    border-radius: 4px;
    outline: none;
    transition: border-color 0.3s ease;
}

.order-container select:focus {
    border-color: #fb3d78;
}

/* Các nút bấm */
.order-container .button-group {
    display: flex;
    justify-content: center;
    gap: 15px;
}

.order-container .button-group button,
.order-container .button-group a {
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    border: none;
    text-decoration: none;
    transition: background-color 0.3s ease;
}

.order-container .btn-primary {
    background-color: #fb3d78;    /* nút chính hồng */
    color: #fff;
}

.order-container .btn-primary:hover {
    background-color: #fb3d78;
}

.order-container .btn-secondary {
    background-color: #f48fb1;    /* nút phụ hồng nhạt */
    color: #fff;
}

.order-container .btn-secondary:hover {
    background-color: #ec407a;
}

/* Bảng chi tiết đơn hàng */
table {
    width: 900px !important;
    border-collapse: collapse;
    text-align: center;
    margin: 0 auto;  /* Căn giữa bảng */
    color: #285560;
    background-color: white !important;
}

table th, table td {
    padding: 10px;
    text-align: center;
    border: 2px solid #f48fb1 !important;
    font-size: 16px;
    color: #fb3d78 !important;
    background-color: white !important;    /* header hồng rất nhạt */
}

table th {
    background-color:rgb(255, 227, 237) !important;    /* header hồng rất nhạt */
    color: #fb3d78;
}

table td {
    background-color: #fff0f6;
}

table tr:nth-child(even) td {
    background-color: #ffeef6;
}

table .total td {
    background-color: #fce4ec;
    font-weight: bold;
}

.table-striped tr:hover {
    background-color: #ffe4f1;
}

</style>