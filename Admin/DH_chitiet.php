<?php
ob_start();
include '../includes/youjia_connect.php';

$MaDH = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Cập nhật trạng thái
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $TrangThai = intval($_POST['TrangThai']);
    $updateSql = "UPDATE donhang SET TrangThai = ? WHERE MaDH = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("ii", $TrangThai, $MaDH);
    $stmt->execute();
    $stmt->close();
    echo "<script>alert('✅ CẬP NHẬT THÀNH CÔNG!');</script>";
}

// Lấy thông tin đơn hàng và khách
$sql = "SELECT dh.MaDH, dh.NgayDH, dh.NgayGiao, dh.TrangThai, kh.TenKH, kh.SDT, kh.DiaChi
        FROM donhang dh JOIN khachhang kh ON dh.MaKH = kh.MaKH WHERE dh.MaDH = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $MaDH);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$order) {
    echo "<p class='text-center text-danger'>Đơn hàng không tồn tại.</p>";
    exit;
}

$trangThaiArr = [
    1 => 'Chờ xác nhận',
    2 => 'Đã xác nhận',
    3 => 'Đang giao',
    4 => 'Đã giao',
    5 => 'Hoàn đơn hàng',
];
?>
<div class="bill-container">
    <h2>HÓA ĐƠN BÁN HÀNG</h2>

    <div class="bill-info container">
    <div class="row mb-2">
        <div class="col-md-6"><b>Khách hàng:</b> <?= htmlspecialchars($order['TenKH']) ?></div>
        <div class="col-md-6"><b>Mã ĐH:</b> <?= $order['MaDH'] ?></div>
    </div>
    <div class="row mb-2">
        <div class="col-md-6"><b>SĐT:</b> <?= htmlspecialchars($order['SDT']) ?></div>
        <div class="col-md-6"><b>Ngày đặt:</b> <?= $order['NgayDH'] ?></div>
    </div>
    <div class="row mb-2">
        <div class="col-md-6"><b>Địa chỉ:</b> <?= htmlspecialchars($order['DiaChi']) ?></div>
        <div class="col-md-6"><b>Ngày giao (dự kiến):</b> <?= $order['NgayGiao'] ?? 'Chưa giao' ?></div>
    </div>
</div>

    <table class="bill-table">
        <thead>
            <tr>
                <th>Mã SP</th>
                <th>Tên sản phẩm</th>
                <th>SL</th>
                <th>Đơn giá</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $tongTien = 0;
            $sql = "SELECT ct.MaSP, sp.TenSP, ct.SoLuong, sp.GiaBan
                    FROM chitietdathang ct JOIN sanpham sp ON ct.MaSP = sp.MaSP WHERE ct.MaDH = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $MaDH);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()):
                $thanhtien = $row['GiaBan'] * $row['SoLuong'];
                $tongTien += $thanhtien;
            ?>
            <tr>
                <td><?= $row['MaSP'] ?></td>
                <td><?= htmlspecialchars($row['TenSP']) ?></td>
                <td><?= $row['SoLuong'] ?></td>
                <td><?= number_format($row['GiaBan'], 0, ',', '.') ?></td>
                <td><?= number_format($thanhtien, 0, ',', '.') ?></td>
            </tr>
            <?php endwhile; ?>
            <tr class='bill-total'>
                <td colspan="4" style="text-align: right;"><strong>Tổng tiền</strong></td>
                <td><strong><?= number_format($tongTien, 0, ',', '.') ?> đ</strong></td>
            </tr>
        </tbody>
    </table>

    <form method="post" class="status-box">
        <label><b>Trạng thái:</b></label>
        <select name="TrangThai">
            <?php foreach ($trangThaiArr as $key => $value): ?>
                <option value="<?= $key ?>" <?= $order['TrangThai'] == $key ? 'selected' : '' ?>>
                    <?= $value ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>
        <div class="button-group">
            <button type="submit" class="btn-luu"><b><i class="fas fa-save"></i> &ensp;LƯU THAY ĐỔI</b></button>
            <a href="QL_DH.php" class="btn-th"><b><i class="fas fa-arrow-left"></i> &ensp;TRỞ VỀ</b></a>
        </div>
    </form>
</div>

<?php
$conn->close();
$content = ob_get_clean();
include 'Layout_AD.php';
?>
<STYLE>
    .btn-luu, .btn-th{
        width: 49%;
    }
</style>