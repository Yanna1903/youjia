<?php
ob_start();
include '../includes/youjia_connect.php';

$maNDM = $_GET['id'] ?? null;
if (!$maNDM) {
    echo "<script>alert('Không tìm thấy mã nhóm danh mục'); window.location.href = 'QL_NDM.php';</script>";
    exit;
}

// Lấy dữ liệu cũ
$sql = "SELECT * FROM nhomdanhmuc WHERE MaNDM = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $maNDM);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    echo "<script>alert('Không tìm thấy dữ liệu!'); window.location.href = 'QL_NDM.php';</script>";
    exit;
}

// Xử lý cập nhật
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenNDM = trim($_POST['TenNDM']);

    if ($tenNDM === "") {
        echo "<script>alert('Tên nhóm danh mục không được để trống!');</script>";
    } else {
        $update_sql = "UPDATE nhomdanhmuc SET TenNDM = ? WHERE MaNDM = ?";
        $update_stmt = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($update_stmt, "si", $tenNDM, $maNDM);
        if (mysqli_stmt_execute($update_stmt)) {
            echo "<script>alert('✅ CẬP NHẬT THÀNH CÔNG!'); window.location.href = 'QL_NDM.php';</script>";
            exit;
        } else {
            echo "<script>alert('Cập nhật thất bại!');</script>";
        }
    }
}
?>

<h2 class="text-center"><b>CẬP NHẬT NHÓM DANH MỤC</b></h2><hr>
<div class="thongtin">
    <form method="POST" class="form-container" style="background:#f9f9f9; border-radius:12px; padding: 20px;">
        <div class="form-group">
            <label>Tên nhóm danh mục</label>
            <input type="text" name="TenNDM" class="form-control" value="<?= htmlspecialchars($row['TenNDM']) ?>" required>
        </div>
        <div class="button-group mt-3">
            <button type="submit" class="btn-luu"><b><i class="fas fa-save"></i>&ensp;LƯU THAY ĐỔI</b></button>
            <a href="QL_NDM.php" class="btn-th"><b><i class="fas fa-arrow-left"></i>&ensp;TRỞ VỀ</b></a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
include 'Layout_AD.php';
?>
<style>
    .btn-th, .btn-luu { width: 49%; }
</style>
