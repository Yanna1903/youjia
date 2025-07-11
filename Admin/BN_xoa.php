<?php
include '../includes/youjia_connect.php';

if (isset($_GET['id'])) {
    $mabn = $_GET['id'];

    // Lấy tên ảnh từ database để xóa file vật lý
    $sql = "SELECT Banner FROM banner WHERE MaBN = '$mabn'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        $imagePath = '../images/slider/' . $row['Banner'];

        if (file_exists($imagePath)) {
            unlink($imagePath); // ✅ XÓA FILE ẢNH
        }

        $delete = "DELETE FROM banner WHERE MaBN = '$mabn'";
        mysqli_query($conn, $delete);

        echo "<script>
                alert('✅ XÓA THÀNH CÔNG!');
                window.location.href = 'QL_Banner.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('⚠️Không tìm thấy banner cần xóa!');
                window.location.href = 'QL_Banner.php';
              </script>";
        exit;
    }
} else {
    echo "<script>
            alert('⚠️Không có mã banner để xóa!');
            window.location.href = 'QL_Banner.php';
          </script>";
    exit;
}
?>
