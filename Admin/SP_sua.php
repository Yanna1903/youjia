<?php
ob_start();
include '../includes/youjia_connect.php';

// Kiểm tra MaSP
if (!isset($_GET['MaSP'])) {
    die("Không tìm thấy Mã SP.");
}
$MaSP = $_GET['MaSP'];

// Lấy thông tin sản phẩm
$sql_sp = "SELECT * FROM SanPham WHERE MaSP = '$MaSP'";
$result_sp = mysqli_query($conn, $sql_sp);
if (!$result_sp || mysqli_num_rows($result_sp) == 0) {
    die("Không tìm thấy sản phẩm với Mã SP: $MaSP");
}
$sp = mysqli_fetch_assoc($result_sp);

// Cập nhật sản phẩm
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['capnhat'])) {
    $TenSP = $_POST['TenSP'];
    $MauSac = $_POST['MauSac'];
    $GiaBan = $_POST['GiaBan'];
    $SoLuong = $_POST['SoLuong'];
    $BaoHanh = $_POST['BaoHanh'];

    $sql_update = "UPDATE SanPham 
                   SET TenSP='$TenSP', MauSac='$MauSac', GiaBan='$GiaBan', SoLuong='$SoLuong', BaoHanh='$BaoHanh' 
                   WHERE MaSP='$MaSP'";
    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('Cập nhật sản phẩm thành công'); window.location.href='SP_sua.php?MaSP=$MaSP';</script>";
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
}

// Cập nhật ảnh bìa
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['capnhat_bia'])) {
    if ($_FILES['AnhBia']['name']) {
        $file_name = basename($_FILES["AnhBia"]["name"]);
        $target_dir = "../images/";
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES["AnhBia"]["tmp_name"], $target_file)) {
            $sql_update_bia = "UPDATE SanPham SET AnhBia='$file_name' WHERE MaSP='$MaSP'";
            mysqli_query($conn, $sql_update_bia);
            echo "<script>alert('Cập nhật ảnh bìa thành công'); window.location.href='SP_sua.php?MaSP=$MaSP';</script>";
        } else {
            echo "Lỗi upload ảnh bìa.";
        }
    }
}

// Thêm hình chi tiết
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['them_hinh'])) {
    if ($_FILES['AnhSP']['name']) {
        $file_name = basename($_FILES["AnhSP"]["name"]);
        $target_dir = "../images/";
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES["AnhSP"]["tmp_name"], $target_file)) {
            $sql_insert_img = "INSERT INTO HinhAnh (AnhSP, MaSP) VALUES ('$file_name', '$MaSP')";
            mysqli_query($conn, $sql_insert_img);
            echo "<script>alert('Thêm hình chi tiết thành công'); window.location.href='SP_sua.php?MaSP=$MaSP';</script>";
        } else {
            echo "Lỗi upload file.";
        }
    }
}

// Xóa hình chi tiết
if (isset($_GET['delete_img'])) {
    $id = $_GET['delete_img'];
    $sql_get_img = "SELECT AnhSP FROM HinhAnh WHERE MaHinh='$id'";
    $res_img = mysqli_query($conn, $sql_get_img);
    if ($row = mysqli_fetch_assoc($res_img)) {
        $file_path = "../images/".$row['AnhSP'];
        if (file_exists($file_path)) unlink($file_path);
    }
    mysqli_query($conn, "DELETE FROM HinhAnh WHERE MaHinh='$id'");
    echo "<script>alert('Đã xóa hình'); window.location.href='SP_sua.php?MaSP=$MaSP';</script>";
}

// Lấy danh sách hình chi tiết
$sql_img = "SELECT * FROM HinhAnh WHERE MaSP = '$MaSP'";
$result_img = mysqli_query($conn, $sql_img);
?>
<link rel="stylesheet" href="AD_css.css">

<div class="thongtin">
    <h2 class="text-center mb-4"><b>CẬP NHẬT SẢN PHẨM</b></h2>
    <hr style="width: 100%">
    <form method="post" class="form-horizontal">
        <div class="form-group row justify-content-center">
            <label class="col-md-3 col-form-label text-md-right">Mã SP</label>
            <div class="col-md-7">
                <input type="text" class="form-control mx-auto" value="<?= htmlspecialchars($sp['MaSP']) ?>" readonly>
            </div>
        </div>
        <div class="form-group row justify-content-center">
            <label class="col-md-3 col-form-label text-md-right">Tên SP</label>
            <div class="col-md-7">
                <input type="text" name="TenSP" class="form-control mx-auto" value="<?= htmlspecialchars($sp['TenSP']) ?>">
            </div>
        </div>
        <div class="form-group row justify-content-center">
            <label class="col-md-3 col-form-label text-md-right">Màu sắc</label>
            <div class="col-md-7">
                <input type="text" name="MauSac" class="form-control mx-auto" value="<?= htmlspecialchars($sp['MauSac']) ?>">
            </div>
        </div>
        <div class="form-group row justify-content-center">
            <label class="col-md-3 col-form-label text-md-right">Giá bán</label>
            <div class="col-md-7">
                <input type="number" name="GiaBan" class="form-control mx-auto" value="<?= htmlspecialchars($sp['GiaBan']) ?>">
            </div>
        </div>
        <div class="form-group row justify-content-center">
            <label class="col-md-3 col-form-label text-md-right">Số lượng</label>
            <div class="col-md-7">
                <input type="number" name="SoLuong" class="form-control mx-auto" value="<?= htmlspecialchars($sp['SoLuong']) ?>">
            </div>
        </div>
        <div class="form-group row justify-content-center">
            <label class="col-md-3 col-form-label text-md-right">Bảo hành</label>
            <div class="col-md-7">
                <input type="number" name="BaoHanh" class="form-control mx-auto" value="<?= htmlspecialchars($sp['BaoHanh']) ?>">
            </div>
        </div>
        <div class="text-center mt-4">
            <button type="submit" name="capnhat" class="btn-th">
                <i class="fas fa-save"></i> Lưu thay đổi
            </button>
        </div>
    </form>
</div>

<hr>
<h2 class="text-center mb-3"><b>ẢNH BÌA SẢN PHẨM</b></h2>
<div class="text-center mb-3">
    <?php if (!empty($sp['AnhBia'])): ?>
        <img src="../images/<?= htmlspecialchars($sp['AnhBia']) ?>" style="height:180px;">
    <?php else: ?>
        <p>Chưa có ảnh bìa.</p>
    <?php endif; ?>
</div>
<form method="post" enctype="multipart/form-data" class="text-center mb-4">
    <input type="file" name="AnhBia" class="form-control" style="width:300px; display:inline-block;">
    <button type="submit" name="capnhat_bia" class="btn-th mt-2">Cập nhật ảnh bìa</button>
</form>

<hr>
<h2 class="text-center mb-3"><b>HÌNH ẢNH CHI TIẾT SẢN PHẨM</b></h2>
<form method="post" enctype="multipart/form-data" class="text-center mb-4">
    <input type="file" name="AnhSP" class="form-control" style="width:300px; display:inline-block;">
    <button type="submit" name="them_hinh" class="btn-th mt-2">Thêm hình chi tiết</button>
</form>
<div class="img-gallery text-center">
    <?php if(mysqli_num_rows($result_img) > 0): ?>
        <?php while($row_img = mysqli_fetch_assoc($result_img)): ?>
            <div style="display:inline-block; margin:10px;">
                <img src="../images/<?= htmlspecialchars($row_img['AnhSP']) ?>" alt="Hình SP" style="height:120px;">
                <br>
                <a href="SP_sua.php?MaSP=<?= $MaSP ?>&delete_img=<?= $row_img['MaHinh'] ?>" 
                   onclick="return confirm('Bạn có chắc muốn xóa hình này?');"
                   class="btn btn-danger btn-sm mt-2">Xóa</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>Chưa có hình ảnh nào cho sản phẩm này.</p>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include 'Layout_AD.php';
?>
