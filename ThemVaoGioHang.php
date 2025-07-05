<?php
session_start();
include 'includes/youjia_connect.php';

if (
    isset($_POST['MaSP']) &&
    isset($_POST['MauSac']) &&
    isset($_POST['GiaBan']) &&
    isset($_POST['SoLuong']) &&
    !empty($_POST['MauSac'])
) {
    $id = $_POST['MaSP'];
    $MauSac = $_POST['MauSac'];
    $GiaBan = $_POST['GiaBan'];
    $SoLuong = $_POST['SoLuong'];

    // Lấy thông tin sản phẩm
    $sql = "SELECT * FROM sanpham WHERE MaSP = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Khởi tạo giỏ hàng nếu chưa có
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        // Tạo key riêng cho mỗi màu của sản phẩm
        $key = $id . '_' . $MauSac;

        // Nếu sản phẩm với màu này đã có thì tăng số lượng
        if (array_key_exists($key, $_SESSION['cart'])) {
            $_SESSION['cart'][$key]['SoLuong'] += $SoLuong;
        } else {
            // Thêm mới sản phẩm vào giỏ
            $_SESSION['cart'][$key] = array(
                'MaSP' => $row['MaSP'],
                'TenSP' => $row['TenSP'],
                'AnhBia' => $row['AnhBia'],
                'GiaBan' => $GiaBan,
                'SoLuong' => $SoLuong,
                'MauSac' => $MauSac
            );
        }

        header("Location: giohang.php");
        exit;
    } else {
        // Thay echo thành script alert
        echo "<script>alert('Không tìm thấy sản phẩm.');</script>";
    }
    } else {
        echo "<script>
        alert('Thiếu thông tin sản phẩm hoặc màu sắc.');
        window.history.back();
    </script>";
        }
    ?>
    
