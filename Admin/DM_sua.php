<?php
ob_start();
include '../includes/youjia_connect.php';

// Lấy danh mục cần sửa
if (isset($_GET['id'])) {
    $MaDM = intval($_GET['id']);

    $sql = "SELECT * FROM DanhMuc WHERE MaDM = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $MaDM);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && $dm = mysqli_fetch_assoc($result)) {
        $TenDM = $dm['TenDM'];
        $MaNDM = $dm['MaNDM'] ?? '';
    } else {
        echo "<div class='alert alert-danger'>Không tìm thấy danh mục!</div>";
        exit;
    }
}

// Lấy danh sách nhóm danh mục
$sql_ndm = "SELECT MaNDM, TenNDM FROM NhomDanhMuc";
$result_ndm = mysqli_query($conn, $sql_ndm);

// Xử lý POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $MaDM = $_POST['MaDM'] ?? '';
    $TenDM = $_POST['TenDM'] ?? '';
    $MaNDM = $_POST['MaNDM'] ?? '';

    if (empty($MaDM)) {
        $errors['MaDM'] = "Mã danh mục không hợp lệ.";
    }
    if (empty($TenDM)) {
        $errors['TenDM'] = "Tên danh mục không được để trống.";
    }
    if (empty($MaNDM)) {
        $errors['MaNDM'] = "Mã nhóm danh mục không được để trống.";
    }

    if (empty($errors)) {
        $sql = "UPDATE DanhMuc SET TenDM = ?, MaNDM = ? WHERE MaDM=?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $TenDM, $MaNDM, $MaDM);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "<script>
                    alert('Cập nhật thành công!');
                    window.location.href = 'QL_DM.php';
                  </script>";
            exit;
        } else {
            echo "<div class='alert alert-danger'>Cập nhật thất bại!</div>";
        }
    }
}
?>

<h2 class="text-center mt-4"><b>CẬP NHẬT DANH MỤC</b></h2>
<hr style="width:50%;">

<div class="thongtin">
    <form method="POST" class="form-container">
        <input type="hidden" name="MaDM" value="<?= htmlspecialchars($MaDM ?? '') ?>">

        <div class="form-group">
            <label for="TenDM" class="form-label">Tên DM</label>
            <input type="text" name="TenDM" id="TenDM" class="form-control" value="<?= htmlspecialchars($TenDM ?? '') ?>">
            <span class="text-danger"><?= $errors['TenDM'] ?? '' ?></span>
        </div>

        <div class="form-group">
            <label for="MaNDM" class="form-label">Nhóm DM</label>
            <select name="MaNDM" id="MaNDM" class="form-control">
                <option value="">-- Chọn nhóm danh mục --</option>
                <?php while($row = mysqli_fetch_assoc($result_ndm)): ?>
                    <option value="<?= $row['MaNDM'] ?>"
                        <?= ($row['MaNDM'] == $MaNDM) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['TenNDM']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <span class="text-danger"><?= $errors['MaNDM'] ?? '' ?></span>
        </div>

        <div class="button-group">
            <button type="submit" class="btn-luu"><b><i class="fas fa-save"></i> &ensp;LƯU THAY ĐỔI</b></button>
            <a href="QL_DM.php" class="btn-th"><b>TRỞ VỀ</b></a>
        </div>
    </form>
</div>
<?php
$content = ob_get_clean();
include 'Layout_AD.php';
?>
<style>
    .btn-th, .btn-luu{
        width: 49%;
    }
</style>