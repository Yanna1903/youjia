<?php
include '../includes/youjia_connect.php';

if (isset($_GET['id'])) {
    $maNDM = (int)$_GET['id'];

    // Kiểm tra xem nhóm danh mục có đang được sử dụng không
    $check_sql = "SELECT COUNT(*) AS total FROM danhmuc WHERE MaNDM = ?";
    $stmt_check = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($stmt_check, "i", $maNDM);
    mysqli_stmt_execute($stmt_check);
    mysqli_stmt_bind_result($stmt_check, $total);
    mysqli_stmt_fetch($stmt_check);
    mysqli_stmt_close($stmt_check);

    if ($total > 0) {
        // Nếu đang được sử dụng
        echo "<script>
                alert('❌Không thể xóa. Nhóm danh mục này đang có $total danh mục sử dụng.');
                window.location.href = 'QL_NDM.php';
              </script>";
    } else {
        // Nếu không bị ràng buộc, thì xóa
        $delete_sql = "DELETE FROM nhomdanhmuc WHERE MaNDM = ?";
        $stmt_delete = mysqli_prepare($conn, $delete_sql);
        mysqli_stmt_bind_param($stmt_delete, "i", $maNDM);
        $result = mysqli_stmt_execute($stmt_delete);

        if ($result) {
            echo "<script>
                alert('✅ XÓA THÀNH CÔNG!');
                    window.location.href = 'QL_NDM.php';
                  </script>";
        } else {
            echo "<script>
                    alert('❌ Xóa thất bại! Vui lòng thử lại.');
                    window.location.href = 'QL_NDM.php';
                  </script>";
        }

        mysqli_stmt_close($stmt_delete);
    }
}

mysqli_close($conn);
?>
