<?php
ob_start();
include '../includes/youjia_connect.php';

$MaSP = isset($_GET['MaSP']) ? mysqli_real_escape_string($conn, $_GET['MaSP']) : null;
if (!$MaSP) die("Không tìm thấy Mã SP.");

// Lấy thông tin sản phẩm
$sql_sp = "SELECT * FROM SanPham WHERE MaSP = '$MaSP'";
$result_sp = mysqli_query($conn, $sql_sp);
if (!$result_sp || mysqli_num_rows($result_sp) == 0) die("Không tìm thấy sản phẩm với Mã SP: $MaSP");
$sp = mysqli_fetch_assoc($result_sp);

// Lấy nhóm danh mục để đổ select
$result_ndm = mysqli_query($conn, "SELECT * FROM NhomDanhMuc");

// Lấy danh mục theo nhóm đã chọn
$MaNDM = $sp['MaNDM'];
$result_dm = mysqli_query($conn, "SELECT * FROM DanhMuc WHERE MaNDM='$MaNDM'");

// Cập nhật thông tin
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $TenSP   = mysqli_real_escape_string($conn, $_POST['TenSP']);
    $MoTa    = mysqli_real_escape_string($conn, $_POST['MoTa']);
    $MauSac  = mysqli_real_escape_string($conn, $_POST['MauSac']);
    $GiaBan  = (float)$_POST['GiaBan'];
    $SoLuong = (int)$_POST['SoLuong'];
    $BaoHanh = (int)$_POST['BaoHanh'];
    $MaNDM   = (int)$_POST['MaNDM'];
    $MaDM    = (int)$_POST['MaDM'];
    $TrangThai = isset($_POST['TrangThai']) ? 1 : 0;

    // XỬ LÝ ẢNH
    $AnhBia = $sp['AnhBia'];
    if (!empty($_FILES['AnhBia']['name'])) {
        $file_name = uniqid() . "_" . basename($_FILES["AnhBia"]["name"]);
        $target_dir = "../images/";
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES["AnhBia"]["tmp_name"], $target_file)) {
            if (!empty($AnhBia) && file_exists($target_dir.$AnhBia)) unlink($target_dir.$AnhBia);
            $AnhBia = $file_name;
        }
    }

    $sql_update = "UPDATE SanPham SET TenSP='$TenSP', MoTa='$MoTa', MauSac='$MauSac', GiaBan='$GiaBan', 
                   SoLuong='$SoLuong', BaoHanh='$BaoHanh', MaNDM='$MaNDM', MaDM='$MaDM', TrangThai='$TrangThai', AnhBia='$AnhBia'
                   WHERE MaSP='$MaSP'";
    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Cập nhật sản phẩm thành công'); window.location.href='QL_SP.php';</script>";
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}
?>

<h2 class="text-center mt-4"><b>CẬP NHẬT SẢN PHẨM</b></h2><hr>
<div class="thongtin">
    <form method="POST" enctype="multipart/form-data" class="form-container" style="background:#f9f9f9; border-radius:12px;">
        <div class="form-group"><label>Mã SP</label><input type="text" value="<?= htmlspecialchars($sp['MaSP']) ?>" readonly></div>
        <div class="form-group"><label>Tên SP</label><input type="text" name="TenSP" value="<?= htmlspecialchars($sp['TenSP']) ?>"></div>
        <div class="form-group"><label>Ảnh Bìa</label><input type="file" name="AnhBia"></div>
        <div class="form-group"><label>Giá Bán</label><input type="number" name="GiaBan" value="<?= htmlspecialchars($sp['GiaBan']) ?>"></div>
        <div class="form-group"><label>Mô Tả</label><textarea name="MoTa"><?= htmlspecialchars($sp['MoTa']) ?></textarea></div>

        <div class="form-group">
            <label>Nhóm Danh Mục</label>
            <select name="MaNDM" id="MaNDM" required>
                <option value="">-- Chọn nhóm danh mục --</option>
                <?php while($ndm = mysqli_fetch_assoc($result_ndm)): ?>
                    <option value="<?= $ndm['MaNDM'] ?>" <?= ($ndm['MaNDM']==$sp['MaNDM'])?'selected':'' ?>>
                        <?= htmlspecialchars($ndm['TenNDM']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label>Danh Mục</label>
            <select name="MaDM" id="MaDM" required>
                <option value="">-- Chọn danh mục --</option>
                <?php while($dm = mysqli_fetch_assoc($result_dm)): ?>
                    <option value="<?= $dm['MaDM'] ?>" <?= ($dm['MaDM']==$sp['MaDM'])?'selected':'' ?>>
                        <?= htmlspecialchars($dm['TenDM']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group"><label>Số Lượng</label><input type="number" name="SoLuong" value="<?= htmlspecialchars($sp['SoLuong']) ?>"></div>
        <div class="form-group"><label>Màu Sắc</label><input type="text" name="MauSac" value="<?= htmlspecialchars($sp['MauSac']) ?>"></div>
        <div class="form-group"><label>Bảo Hành (tháng)</label><input type="number" name="BaoHanh" value="<?= htmlspecialchars($sp['BaoHanh']) ?>"></div>

        <div class="form-group">
            <label>Trạng Thái</label>
            <div style="display:flex; align-items:center; gap:8px;">
                <input type="checkbox" name="TrangThai" <?= $sp['TrangThai'] ? 'checked' : '' ?>><span style="font-size:13px;">(Còn hàng)</span>
            </div>
        </div>

        <div class="button-group">
            <button type="submit" name="capnhat" class="btn-luu"><b><i class="fas fa-save"></i>&ensp;LƯU THAY ĐỔI</b></button>
            <a href="QL_SP.php" class="btn-th"><b><i class="fas fa-arrow-left"></i> &ensp;TRỞ VỀ</b></a>
        </div>
    </form>
</div>

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
$content = ob_get_clean();
include 'Layout_AD.php';
?>
<style>
    .btn-th, .btn-luu{
        width: 49%;
    }
</style>
