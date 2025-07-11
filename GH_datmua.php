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

// Lấy thông tin khách hàng
$stmtKH = $conn->prepare("SELECT MaKH, TenKH, SDT, DiaChi FROM khachhang WHERE username = ?");
$stmtKH->bind_param("s", $username);
$stmtKH->execute();
$resultKH = $stmtKH->get_result();
$rowKH = $resultKH->fetch_assoc();
$MaKH = $rowKH['MaKH'];
$TenKH = $rowKH['TenKH'];
$stmtKH->close();

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($cart)) {
    $SDT = $_POST['sdt'];
    $DiaChi = $_POST['diachi'];
    $TrangThai = 1;

    $TongTien = 0;
    foreach ($cart as $item) {
        $TongTien += $item['SoLuong'] * $item['GiaBan'];
    }

    $NgayGiao = date("Y-m-d", strtotime("+14 days"));

    // Lưu đơn hàng với SDT và Địa chỉ mới
    $sqlDH = "INSERT INTO donhang (MaKH, NgayDH, SDT, DiaChi, TrangThai, NgayGiao, TongTien)
              VALUES (?, NOW(), ?, ?, ?, ?, ?)";
    $stmtDH = $conn->prepare($sqlDH);
    $stmtDH->bind_param("isssid", $MaKH, $SDT, $DiaChi, $TrangThai, $NgayGiao, $TongTien);
    $stmtDH->execute();
    $MaDH = $stmtDH->insert_id;
    $stmtDH->close();

    // Lưu chi tiết đơn hàng
    $sqlCT = "INSERT INTO chitietdathang (MaDH, MaSP, SoLuong, DonGia, ThanhTien, MauSac)
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmtCT = $conn->prepare($sqlCT);
    foreach ($cart as $item) {
        $MaSP = $item['MaSP'];
        $SoLuong = $item['SoLuong'];
        $DonGia = $item['GiaBan'];
        $ThanhTien = $SoLuong * $DonGia;
        $MauSac = $item['MauSac'] ?? null;

        $stmtCT->bind_param("isidds", $MaDH, $MaSP, $SoLuong, $DonGia, $ThanhTien, $MauSac);
        $stmtCT->execute();
    }
    $stmtCT->close();

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
        table {
            width: 900px !important;
            border-collapse: collapse;
            text-align: center;
            margin: 0 auto;
            color: #285560 !important;
            background-color: white !important;
        }
        hr {
            border: none;
            border-top: 5px solid rgba(40, 85, 96, 0.32); 
            margin: 20px auto;
        }
        h2 { color: #285560; text-align: center; }
        h4, label { color: #285560; }
        table th, table td {
            padding: 10px;
            border: 1px solid rgba(40, 85, 96, 0.43);
        }
        table th {
            font-weight: bold;
            background-color: rgb(225, 249, 255);
        }
        .btn-a {
            background-color: rgb(68, 143, 160);
            color: white;
            padding: 8px;
            width: 100%;
        }
        .btn-a:hover {
            background-color: rgb(28, 98, 114);
        }
        input {
            background-color: white;
            border: 1px solid rgba(35, 136, 158, 0.57);
            width: 80% !important;
            padding: 6px 10px;
        }
        .order-ahihi {
            background: #ffffff;
            padding: 20px;
            border-radius: 12px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 4px 12px rgba(38, 98, 112, 0.59);
            max-width: 1000px;
            margin: 20px auto 50px;
        }
    </style>
</head>
<body>
    <div class='order-ahihi mt-5'>
        <h2><b>XÁC NHẬN ĐẶT HÀNG</b></h2>
        <hr>
        <?php if (empty($cart)): ?>
            <p>Giỏ hàng của bạn đang trống.</p>
        <?php else: ?>
        <form method="post">
            <h4>&emsp;A. THÔNG TIN KHÁCH HÀNG</h4>
            <p>&emsp;&emsp;&emsp; <b>Tên khách hàng:</b> &emsp;<?= htmlspecialchars($TenKH) ?></p>
            <p>
              &emsp;&emsp;&emsp; <b>Số điện thoại:</b> &emsp;
              <input type="text" name="sdt" value="<?= htmlspecialchars($rowKH['SDT']) ?>" required>
            </p>
            <p>
              &emsp;&emsp;&emsp; <b>Địa chỉ giao hàng:</b> &emsp;
              <input type="text" name="diachi" value="<?= htmlspecialchars($rowKH['DiaChi']) ?>" required>
            </p>
            <hr>
            <h4>&emsp;B. THÔNG TIN ĐƠN HÀNG</h4>
            <table>
                <tr>
                    <th>Tên sản phẩm</th>
                    <th>Màu</th>
                    <th>Đơn giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
                <?php
                $tongTien = 0;
                foreach ($cart as $item):
                    $thanhTien = $item['SoLuong'] * $item['GiaBan'];
                    $tongTien += $thanhTien;
                ?>
                <tr>
                    <td><?= htmlspecialchars($item['TenSP']) ?></td>
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
            <br>
            <button type="submit" class="btn btn-a">ĐẶT MUA</button>
        </form>
        <?php endif; ?>
    </div>
<?php
$content = ob_get_clean();
include "includes/youjia_layout.php"; 
?>
</body>
</html>
