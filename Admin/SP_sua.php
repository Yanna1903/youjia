<?php
ob_start();
include '../includes/youjia_connect.php';

$MaSP = isset($_GET['MaSP']) ? mysqli_real_escape_string($conn, $_GET['MaSP']) : null;
if (!$MaSP) die("⚠️ Không tìm thấy Mã SP.");

// Lấy thông tin sản phẩm
$sql_sp = "SELECT * FROM SanPham WHERE MaSP = '$MaSP'";
$result_sp = mysqli_query($conn, $sql_sp);
if (!$result_sp || mysqli_num_rows($result_sp) == 0) die("⚠️ Không tìm thấy sản phẩm với Mã SP: $MaSP");
$sp = mysqli_fetch_assoc($result_sp);

// Lấy nhóm danh mục
$result_ndm = mysqli_query($conn, "SELECT * FROM NhomDanhMuc");

// Lấy danh mục theo nhóm hiện tại
$MaNDM = $sp['MaNDM'];
$result_dm = mysqli_query($conn, "SELECT * FROM DanhMuc WHERE MaNDM='$MaNDM'");

// Cập nhật
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

    // Xử lý ảnh bìa
    $AnhBia = $sp['AnhBia'];
    if (!empty($_FILES['AnhBia']['name'])) {
        $file_name = uniqid() . "_" . basename($_FILES["AnhBia"]["name"]);
        $target_dir = "../images/AnhBia/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES["AnhBia"]["tmp_name"], $target_file)) {
            if (!empty($AnhBia) && file_exists($target_dir . $AnhBia)) {
                unlink($target_dir . $AnhBia); // Xóa ảnh cũ
            }
            $AnhBia = $file_name;
        }
    }

    $sql_update = "UPDATE SanPham SET TenSP='$TenSP', MoTa='$MoTa', MauSac='$MauSac', GiaBan='$GiaBan', 
                   SoLuong='$SoLuong', BaoHanh='$BaoHanh', MaNDM='$MaNDM', MaDM='$MaDM', TrangThai='$TrangThai', AnhBia='$AnhBia'
                   WHERE MaSP='$MaSP'";
    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('✅ CẬP NHẬT THÀNH CÔNG!'); window.location.href='QL_SP.php';</script>";
        exit;
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}
?>

<h2 class="text-center mt-4"><b>CẬP NHẬT SẢN PHẨM</b></h2><hr>
<div class="thongtin">
    <form method="POST" enctype="multipart/form-data" class="form-container" style="background:#f9f9f9; border-radius:12px; padding: 20px;">
        <div class="form-group"><label>Mã SP</label><input type="text" value="<?= htmlspecialchars($sp['MaSP']) ?>" readonly class="form-control"></div>

        <div class="form-group"><label>Tên SP</label><input type="text" name="TenSP" value="<?= htmlspecialchars($sp['TenSP']) ?>" class="form-control"></div>

        <div class="form-group">
            <label>Ảnh Bìa</label><br>
            <?php if (!empty($sp['AnhBia']) && file_exists("../images/AnhBia/" . $sp['AnhBia'])): ?>
                <img src="../images/AnhBia/<?= $sp['AnhBia'] ?>" id="previewImg" style="max-height: 150px; display:block; margin-bottom:10px;">
            <?php else: ?>
                <img src="#" id="previewImg" style="max-height: 150px; display:none; margin-bottom:10px;">
            <?php endif; ?>
            <input type="file" name="AnhBia" id="AnhBiaInput" accept="image/*" class="form-control">
        </div>

        <div class="form-group"><label>Giá Bán</label><input type="number" name="GiaBan" value="<?= htmlspecialchars($sp['GiaBan']) ?>" class="form-control"></div>

        <div class="form-group"><label>Mô Tả</label><textarea name="MoTa" class="form-control"><?= htmlspecialchars($sp['MoTa']) ?></textarea></div>

        <div class="form-group">
            <label>Nhóm Danh Mục</label>
            <select name="MaNDM" id="MaNDM" class="form-control" required>
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
            <select name="MaDM" id="MaDM" class="form-control" required>
                <option value="">-- Chọn danh mục --</option>
                <?php while($dm = mysqli_fetch_assoc($result_dm)): ?>
                    <option value="<?= $dm['MaDM'] ?>" <?= ($dm['MaDM']==$sp['MaDM'])?'selected':'' ?>>
                        <?= htmlspecialchars($dm['TenDM']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group"><label>Số Lượng</label><input type="number" name="SoLuong" value="<?= htmlspecialchars($sp['SoLuong']) ?>" class="form-control"></div>
        <div class="form-group"><label>Màu Sắc</label><input type="text" name="MauSac" value="<?= htmlspecialchars($sp['MauSac']) ?>" class="form-control"></div>
        <div class="form-group"><label>Bảo Hành (tháng)</label><input type="number" name="BaoHanh" value="<?= htmlspecialchars($sp['BaoHanh']) ?>" class="form-control"></div>

        <div class="form-group">
            <label>Trạng Thái</label><br>
            <div style="display:flex; align-items:center; gap:8px;">
                <input type="checkbox" name="TrangThai" <?= $sp['TrangThai'] ? 'checked' : '' ?>>
                <span style="font-size:16px;">(Còn hàng)</span>
            </div>
        </div>
        <div class="button-group">
            <button type="submit" name="capnhat" class="btn-luu"><b><i class="fas fa-save"></i>&ensp;LƯU THAY ĐỔI</b></button>
            <a href="QL_SP.php" class="btn-th"><b><i class="fas fa-arrow-left"></i> &ensp;TRỞ VỀ</b></a>
        </div>
        
    </form>
</div>

<!-- SCRIPT: Load danh mục theo nhóm + Preview ảnh -->
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

document.getElementById('AnhBiaInput').addEventListener('change', function (e) {
    const file = e.target.files[0];
    const img = document.getElementById('previewImg');
    if (file) {
        const reader = new FileReader();
        reader.onload = function (event) {
            img.src = event.target.result;
            img.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
});
</script>

<?php
$content = ob_get_clean();
include 'Layout_AD.php';
?>

<style>
    .btn-th, .btn-luu {
        width: 49%;
    }
</style>
