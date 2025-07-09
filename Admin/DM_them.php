<?php
ob_start();
include '../includes/youjia_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    $MaDM = $_POST['MaDM'] ?? ''; // Thêm phần này cho Phái
    $TenDM = $_POST['TenDM'] ?? '';
    // Kiểm tra lỗi cơ bản
    if (empty($TenDM)) {
        $errors['TenDM'] = "Tên danh mục không được để trống.";
    }
   
    if (empty($errors)) {
        // Tiến hành thêm vào database
        $sql = "INSERT INTO danhmuc (TenDM) VALUES (?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $TenDM,);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "<script>
                    alert('Thêm danh mục thành công!');
                    window.location.href = 'QL_DM.php';
                  </script>";
        } else {
            echo "<div class='alert alert-danger'>Thêm mới thất bại!</div>";
        }
    }
}
?>
<h2><B> THÊM DANH MỤC MỚI <B></H2><HR>
<div class="thongtin">
    <form method="POST" class="form-container" style="background:#f9f9f9; border-radius:12px;">
        <div class="form-group">
            <label class="form-label">Tên DM</label>
            <input type="text" name="TenDM" class="form-control" value="<?= htmlspecialchars($TenDM ?? '') ?>" />
            <span class="text-danger"><?= $errors['TenDM'] ?? '' ?></span>
        </div>

        <div class="form-group">
            <label for="MaNDM" class="form-label">Nhóm DM</label>
            <select name="MaNDM" id="MaNDM" class="form-control" required>
                <option value="">-- Chọn nhóm danh mục --</option>
                <?php
                $sql_ndm = "SELECT * FROM nhomdanhmuc";
                $result_ndm = mysqli_query($conn, $sql_ndm);
                while ($row_ndm = mysqli_fetch_assoc($result_ndm)) {
                    echo '<option value="' . $row_ndm['MaNDM'] . '">' . htmlspecialchars($row_ndm['TenNDM']) . '</option>';
                }
                ?>
            </select>
            <span class="text-danger"><?= $errors['MaNDM'] ?? '' ?></span>
        </div>

        <div class="button-group">
            <button type="submit" class="btn-luu"><b><i class="fas fa-save"></i> &ensp;LƯU</b></button>
            <a href="QL_DM.php" class="btn-th"><b><i class="fas fa-arrow-left"></i> &ensp;TRỞ VỀ</b></a>
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