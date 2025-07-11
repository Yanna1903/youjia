<?php
include '../includes/youjia_connect.php';

if (isset($_GET['id'])) {
    $maDM = intval($_GET['id']);

    // Kiểm tra xem có sản phẩm nào đang dùng MaDM không
    $sqlCheck = "SELECT COUNT(*) AS total FROM sanpham WHERE MaDM = $maDM";
    $resultCheck = mysqli_query($conn, $sqlCheck);
    $rowCheck = mysqli_fetch_assoc($resultCheck);

    if ($rowCheck['total'] > 0) {
        echo "<script>
                alert('⚠️ Không thể xóa. Có {$rowCheck['total']} sản phẩm đang sử dụng danh mục này!');
                window.location.href = 'QL_DM.php';
              </script>";
        exit;
    }

    // Xóa danh mục
    $sqlDelete = "DELETE FROM danhmuc WHERE MaDM = $maDM";
    $resultDelete = mysqli_query($conn, $sqlDelete);

    if ($resultDelete) {
        echo "<script>
                alert('✅ XÓA THÀNH CÔNG!');
                window.location.href = 'QL_DM.php';
              </script>";
    } else {
        echo "<script>
                alert('❌ Xóa thất bại: " . mysqli_error($conn) . "');
                window.location.href = 'QL_DM.php';
              </script>";
    }
}

mysqli_close($conn);
?>
