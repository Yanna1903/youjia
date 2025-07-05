<?php
    include '../includes/quanao_connect.php';

    if (isset($_GET['id'])) {
        $MaDH = intval($_GET['id']); 

        // Xóa chi tiết đơn hàng
        $sqlChiTiet = "DELETE FROM chitietdathang WHERE MaDH = ?";
        $stmtChiTiet = $conn->prepare($sqlChiTiet);
        $stmtChiTiet->bind_param("i", $MaDH);

        if (!$stmtChiTiet->execute()) {
            echo "<script>alert('Lỗi khi xóa chi tiết đơn hàng!'); window.history.back();</script>";
            exit();
        }
        $stmtChiTiet->close(); 

        // Xóa đơn hàng
        $sqlDonHang = "DELETE FROM DonHang WHERE MaDH = ?";
        $stmtDonHang = $conn->prepare($sqlDonHang); // Dùng đúng biến kết nối
        $stmtDonHang->bind_param("i", $MaDH);

        if ($stmtDonHang->execute()) {
            echo "<script>alert('Xóa đơn hàng thành công!'); window.location.href = 'QL_DH.php';</script>";
        } else {
            echo "<script>alert('Lỗi khi xóa đơn hàng!'); window.history.back();</script>";
        }
        $stmtDonHang->close(); 
    } else {
        echo "<script>alert('Không tìm thấy đơn hàng!'); window.history.back();</script>";
    }

    $conn->close(); 
?>
