<?php
ob_start();
include '../includes/youjia_connect.php';

$errors = [];
$TenDM = '';
$MaNDM = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $TenDM = $_POST['TenDM'] ?? '';
    $MaNDM = $_POST['MaNDM'] ?? '';

    // Kiểm tra dữ liệu nhập
    if (empty($TenDM)) {
        $errors['TenDM'] = "Tên danh mục không được để trống.";
    }

    if (empty($MaNDM)) {
        $errors['MaNDM'] = "Bạn phải chọn nhóm danh mục.";
    }

    // Nếu không có lỗi, thực hiện thêm
    if (empty($errors)) {
        $sql = "INSERT INTO danhmuc (TenDM, MaNDM) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'si', $TenDM, $MaNDM);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "<script>
                    alert('✅ THÊM THÀNH CÔNG!');
                    window.location.href = 'QL_DM.php';
                  </script>";
            exit;
        } else {
            echo "<div class='alert alert-danger'>❌ Thêm thất bại: " . mysqli_error($conn) . "</div>";
        }
    }
}
?>

<h2><b>THÊM DANH MỤC MỚI</b></h2>
<hr>
<div class="thongtin">
    <form method="POST" class="form-container" style="background:#f9f9f9; border-radius:12px; padding: 20px;">
        <div class="form-group">
            <label class="form-label">Tên danh mục</label>
            <input type="text" name="TenDM" class="form-control" value="<?= htmlspecialchars($TenDM) ?>" />
            <span class="text-danger"><?= $errors['TenDM'] ?? '' ?></span>
        </div>

        <div class="form-group">
            <label for="MaNDM" class="form-label">Nhóm danh mục</label>
            <select name="MaNDM" id="MaNDM" class="form-control" required>
                <option value="">-- Chọn nhóm danh mục --</option>
                <?php
                $sql_ndm = "SELECT * FROM nhomdanhmuc";
                $result_ndm = mysqli_query($conn, $sql_ndm);
                while ($row_ndm = mysqli_fetch_assoc($result_ndm)) {
                    $selected = ($row_ndm['MaNDM'] == $MaNDM) ? 'selected' : '';
                    echo '<option value="' . $row_ndm['MaNDM'] . '" ' . $selected . '>' . htmlspecialchars($row_ndm['TenNDM']) . '</option>';
                }
                ?>
            </select>
            <span class="text-danger"><?= $errors['MaNDM'] ?? '' ?></span>
        </div>

        <div class="button-group mt-3">
            <button type="submit" class="btn-luu"><b><i class="fas fa-save"></i> &ensp;LƯU THAY ĐỔI</b></button>
            <a href="QL_DM.php" class="btn-th"><b><i class="fas fa-arrow-left"></i> &ensp;TRỞ VỀ</b></a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
include 'Layout_AD.php';
?>

<style>
    .btn-th, .btn-luu {
        width: 49%;
    }
</style>
