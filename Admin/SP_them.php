<?php
ob_start();
include '../includes/youjia_connect.php';

$errors = [];
$MaSP = $_POST['MaSP'] ?? '';
$TenSP = $_POST['TenSP'] ?? '';
$GiaBan = $_POST['GiaBan'] ?? '';
$MoTa = $_POST['MoTa'] ?? '';
$MaDM = $_POST['MaDM'] ?? '';
$MaNDM = $_POST['MaNDM'] ?? '';
$SoLuong = $_POST['SoLuong'] ?? '';
$MauSac = $_POST['MauSac'] ?? '';
$TrangThai = isset($_POST['TrangThai']) ? 1 : 0;

// Lấy danh sách nhóm danh mục
$sql_ndm = "SELECT * FROM nhomdanhmuc";
$result_ndm = mysqli_query($conn, $sql_ndm);

// Lấy danh sách danh mục nếu có nhóm danh mục được chọn
$result_dm = [];
if (!empty($MaNDM)) {
    $sql_dm = "SELECT * FROM danhmuc WHERE MaNDM = '$MaNDM'";
    $result_dm = mysqli_query($conn, $sql_dm);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($MaSP)) $errors['MaSP'] = "Mã sản phẩm không được để trống.";
    if (empty($TenSP)) $errors['TenSP'] = "Tên sản phẩm không được để trống.";
    if (empty($GiaBan)) $errors['GiaBan'] = "Giá bán không được để trống.";
    if (empty($MaNDM)) $errors['MaNDM'] = "Nhóm danh mục không được để trống.";
    if (empty($MaDM)) $errors['MaDM'] = "Danh mục không được để trống.";
    if (empty($SoLuong)) $errors['SoLuong'] = "Số lượng không được để trống.";

    if (empty($errors)) {
        $AnhBia = $_FILES['AnhBia'] ?? null;
        $file_name = uniqid() . "_" . basename($AnhBia["name"]);
        $target_dir = "../images/AnhBia/";
        $target_file = $target_dir . $file_name;
        $uploadOk = 1;

        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            $errors['AnhBia'] = "Chỉ chấp nhận JPG, JPEG, PNG, GIF.";
            $uploadOk = 0;
        }

        if ($uploadOk && move_uploaded_file($AnhBia["tmp_name"], $target_file)) {
            $sql = "INSERT INTO sanpham (MaSP, TenSP, AnhBia, GiaBan, MoTa, MaDM, MaNDM, SoLuong, MauSac, TrangThai)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'sssdsssisi', 
                $MaSP, $TenSP, $file_name, $GiaBan, $MoTa, $MaDM, $MaNDM, $SoLuong, $MauSac, $TrangThai
            );
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                echo "<script>alert('✅ THÊM THÀNH CÔNG!'); window.location.href='QL_SP.php';</script>";
                exit;
            } else {
                echo "<div class='alert alert-danger'>Lỗi thêm sản phẩm: " . mysqli_error($conn) . "</div>";
            }
        } else {
            $errors['AnhBia'] = "Tải ảnh thất bại.";
        }
    }
}
?>


<h2 class="h2-them"><b>THÊM SẢN PHẨM MỚI</b></h2><hr style="width:50%;">

<form method="POST" enctype="multipart/form-data" class="form-container">
    <div class="form-group">
        <label>Mã SP</label>
        <input type="text" name="MaSP" value="<?= htmlspecialchars($MaSP) ?>">
        <span class="text-danger"><?= $errors['MaSP'] ?? '' ?></span>
    </div>

    <div class="form-group">
        <label>Tên SP</label>
        <input type="text" name="TenSP" value="<?= htmlspecialchars($TenSP) ?>">
        <span class="text-danger"><?= $errors['TenSP'] ?? '' ?></span>
    </div>

    <div class="form-group">
        <label>Ảnh Bìa</label>
        <input type="file" name="AnhBia">
        <span class="text-danger"><?= $errors['AnhBia'] ?? '' ?></span>
    </div>

    <div class="form-group">
        <label>Giá Bán</label>
        <input type="number" name="GiaBan" value="<?= htmlspecialchars($GiaBan) ?>">
        <span class="text-danger"><?= $errors['GiaBan'] ?? '' ?></span>
    </div>

    <div class="form-group">
        <label>Mô Tả</label>
        <textarea name="MoTa"><?= htmlspecialchars($MoTa) ?></textarea>
    </div>

    <div class="form-group">
        <label>Nhóm Danh Mục</label>
        <select name="MaNDM" id="MaNDM" required>
            <option value="">-- Chọn nhóm danh mục --</option>
            <?php
            $sql_ndm = "SELECT * FROM nhomdanhmuc";
            $result_ndm = mysqli_query($conn, $sql_ndm);
            while ($row_ndm = mysqli_fetch_assoc($result_ndm)) {
                echo '<option value="' . $row_ndm['MaNDM'] . '"'
                    . ($row_ndm['MaNDM'] == $MaNDM ? ' selected' : '') . '>'
                    . htmlspecialchars($row_ndm['TenNDM']) . '</option>';
            }
            ?>
        </select>
        <span class="text-danger"><?= $errors['MaNDM'] ?? '' ?></span>
    </div>

    <div class="form-group">
        <label>Danh Mục</label>
        <select name="MaDM" id="MaDM" class="form-control" required>
            <option value="">-- Chọn danh mục --</option>
            <?php while($dm = mysqli_fetch_assoc($result_dm)): ?>
                <option value="<?= $dm['MaDM'] ?>" <?= ($dm['MaDM']==$sp['MaDM'])?'selected':'' ?>>
                    <?= htmlspecialchars($dm['TenDM']) ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Số Lượng</label>
        <input type="number" name="SoLuong" value="<?= htmlspecialchars($SoLuong) ?>">
        <span class="text-danger"><?= $errors['SoLuong'] ?? '' ?></span>
    </div>

    <div class="form-group">
        <label>Màu Sắc</label>
        <input type="text" name="MauSac" value="<?= htmlspecialchars($MauSac) ?>">
    </div>

    <div class="form-group">
        <label>Trạng Thái</label>
        <div style="display:flex; align-items:center; gap:8px;">
            <input type="checkbox" name="TrangThai" <?= $TrangThai ? 'checked' : '' ?>>
            <span style="font-size:16px;">(Còn hàng)</span>
        </div>
    </div>

    <div class="button-group" style="margin-top: 20px;">
        <button type="submit" class="btn-luu"><b><i class="fas fa-save"></i> &ensp;LƯU</b></button>
        <a href="QL_SP.php" class="btn-th"><b><i class="fas fa-arrow-left"></i> &ensp;TRỞ VỀ</b></a>
    </div>
</form>

<script>
document.getElementById('MaNDM').addEventListener('change', function() {
    var maNDM = this.value;
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'lay_danhmuc.php?MaNDM=' + maNDM, true);
    xhr.onload = function () {
        if (this.status == 200) {
            document.getElementById('MaDM').innerHTML = this.responseText;
        }
    };
    xhr.send();
});
</script>
<?php
$conn->close();
    $content = ob_get_clean();
    include 'Layout_AD.php';
?>
<link rel="stylesheet" href="AD_css.css">
<style>
    .btn-th, .btn-luu{
        width: 49%;
    }
</style>