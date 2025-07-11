<?php
include '../includes/youjia_connect.php';

if (!isset($_GET['id'])) {
    echo "<script>alert('⚠️ Thiếu mã banner cần sửa!'); window.location.href = 'QL_Banner.php';</script>";
    exit;
}

$mabn = $_GET['id'];

// Lấy thông tin banner cần sửa
$sql = "SELECT * FROM banner WHERE MaBN = '$mabn'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<script>alert('⚠️ Không tìm thấy banner!'); window.location.href = 'QL_Banner.php';</script>";
    exit;
}

// Xử lý khi submit form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tieude = $_POST['tieude'];
    $link = $_POST['link'];
    $tenHienTai = $row['Banner'];

    // Nếu người dùng upload ảnh mới
    if ($_FILES['banner']['error'] === 0) {
        $file = $_FILES['banner'];
        $tenMoi = time() . '_' . basename($file['name']);
        move_uploaded_file($file['tmp_name'], '../images/slider/' . $tenMoi);

        // Xóa ảnh cũ
        $duongDanCu = '../images/slider/' . $tenHienTai;
        if (file_exists($duongDanCu)) {
            unlink($duongDanCu);
        }
    } else {
        $tenMoi = $tenHienTai; // Không đổi ảnh
    }

    // Cập nhật dữ liệu
    $update = "UPDATE banner SET TieuDe='$tieude', Link='$link', Banner='$tenMoi' WHERE MaBN='$mabn'";
    mysqli_query($conn, $update);

    echo "<script>alert('✅ CẬP NHẬT THÀNH CÔNG!'); window.location.href='QL_Banner.php';</script>";
    exit;
}
?>

<h3>Sửa Banner</h3>
<form method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label>Tiêu đề</label>
        <input type="text" name="tieude" class="form-control" value="<?= htmlspecialchars($row['TieuDe']) ?>" required>
    </div>
    <div class="form-group">
        <label>Link</label>
        <input type="text" name="link" class="form-control" value="<?= htmlspecialchars($row['Link']) ?>">
    </div>
    <div class="form-group">
        <label>Hình hiện tại</label><br>
        <img src="../images/slider/<?= htmlspecialchars($row['Banner']) ?>" width="200">
    </div>
    <div class="form-group">
        <label>Hình mới <p>(nếu muốn đổi)</p></label> 
        <input type="file" name="banner" class="form-control">
    </div>
    <div class="button-group">
        <button type="submit" class="btn-luu"><b><i class="fas fa-save"></i> &ensp;LƯU THAY ĐỔI</b></button>
        <a href="QL_BN.php" class="btn-th"><b><i class="fas fa-arrow-left"></i> &ensp;TRỞ VỀ</b></a>
    </div>
</form>

<?php
$conn->close();
$content = ob_get_clean();
include 'Layout_AD.php';
?>
<style>
    .btn-luu, .btn-th {
        width:49%;
    }
</style>