<?php
ob_start();
include '../includes/youjia_connect.php';

$MaSP = isset($_GET['MaSP']) ? mysqli_real_escape_string($conn, $_GET['MaSP']) : null;
if (!$MaSP) die("Không tìm thấy Mã SP.");

// Lấy thông tin sản phẩm
$sql_sp = "SELECT * FROM SanPham WHERE MaSP = '$MaSP'";
$result_sp = mysqli_query($conn, $sql_sp);
if (!$result_sp || mysqli_num_rows($result_sp) == 0) die("Không tìm thấy sản phẩm.");
$sp = mysqli_fetch_assoc($result_sp);

// Cập nhật ảnh bìa
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['capnhat_bia'])) {
    if ($_FILES['AnhBia']['name']) {
        $file_name = uniqid() . "_" . basename($_FILES["AnhBia"]["name"]);
        $target_dir = "../images/";
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["AnhBia"]["tmp_name"], $target_file)) {
            if (!empty($sp['AnhBia']) && file_exists($target_dir.$sp['AnhBia'])) unlink($target_dir.$sp['AnhBia']);
            mysqli_query($conn, "UPDATE SanPham SET AnhBia='$file_name' WHERE MaSP='$MaSP'");
            echo "<script>alert('Cập nhật ảnh bìa thành công'); window.location.href='HASP_sua.php?MaSP=$MaSP';</script>";
        }
    }
}

// Thêm hình chi tiết
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['them_hinh'])) {
    if ($_FILES['AnhSP']['name']) {
        $file_name = uniqid() . "_" . basename($_FILES["AnhSP"]["name"]);
        $target_dir = "../images/";
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["AnhSP"]["tmp_name"], $target_file)) {
            mysqli_query($conn, "INSERT INTO HinhAnh (AnhSP, MaSP) VALUES ('$file_name', '$MaSP')");
            echo "<script>alert('Đã thêm hình chi tiết'); window.location.href='HASP_sua.php?MaSP=$MaSP';</script>";
        }
    }
}

// XÓA HÌNH CHI TIẾT NGAY TRONG FILE
if (isset($_GET['del']) && $_GET['del']) {
    $AnhSP = mysqli_real_escape_string($conn, $_GET['del']);

    // Xóa file vật lý
    $path = "../images/" . $AnhSP;
    if (file_exists($path)) unlink($path);

    // Xóa record DB
    mysqli_query($conn, "DELETE FROM HinhAnh WHERE MaSP='$MaSP' AND AnhSP='$AnhSP'");

    echo "<script>alert('Đã xóa hình chi tiết'); window.location.href='HASP_sua.php?MaSP=$MaSP';</script>";
    exit;
}

// Lấy danh sách hình chi tiết
$result_img = mysqli_query($conn, "SELECT * FROM HinhAnh WHERE MaSP = '$MaSP'");
?>

<h2 class="text-center mb-4"><B> HÌNH ẢNH SẢN PHẨM <?= htmlspecialchars($sp['TenSP']) ?> (<?= htmlspecialchars($sp['MaSP']) ?>)</B></h2>
<hr>
<div class='container-images'>
    <div class="cover-image">
        <h3 class="text-center mb-3"><b>1. ẢNH BÌA</b></h3> 
        <form method="post" enctype="multipart/form-data" class="mt-3 text-center">
            <input type="file" name="AnhBia" class="form-control mb-2" style="width:250px;">
            <button type="submit" name="capnhat_bia" class="btn-th">Cập nhật ảnh bìa</button>
        </form>
        <?php if (!empty($sp['AnhBia'])): ?>
            <img src="../images/<?= htmlspecialchars($sp['AnhBia']) ?>" alt="Ảnh bìa">
        <?php else: ?>
            <p>Chưa có ảnh bìa.</p>
        <?php endif; ?>
    </div>
    <div class="gallery-images">
        <hr><h3 class="text-center mb-3"><b>2. HÌNH CHI TIẾT</b></h3>
        <form method="post" enctype="multipart/form-data" class="text-center mb-3" style="width:100%;">
            <input type="file" name="AnhSP" class="form-control mb-2" style="width:250px;">
            <button type="submit" name="them_hinh" class="btn-th">Thêm hình chi tiết</button>
        </form>

        <?php if(mysqli_num_rows($result_img) > 0): ?>
            <?php while($row_img = mysqli_fetch_assoc($result_img)): ?>
                <div>
                    <img src="../images/<?= htmlspecialchars($row_img['AnhSP']) ?>" alt="Hình SP">
                    <br>
                    <a href="?MaSP=<?= $MaSP ?>&del=<?= urlencode($row_img['AnhSP']) ?>"
                       onclick="return confirm('Bạn có chắc muốn xóa hình này?');">Xóa</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p style="width:100%;">Chưa có hình chi tiết.</p>
        <?php endif; ?>
    </div>
</div>
<link rel="stylesheet" href="AD_css.css"> 
<style>
    .container-images h3, .container-images form{
        text-align: left;
        padding-left: 50px;
    }
    .cover-image, .gallery-images {
        flex: 1;
    }
    .cover-image img, .gallery-images img {
        height: 400px;
        width:300px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        margin-top: 10px;
    }
    .gallery-images {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
    }
    .gallery-images div { text-align: center; }
    .gallery-images a {
        display: inline-block;
        padding: 5px 10px;
        font-size: 13px;
        background: #dc3545;
        color: #fff;
        border-radius: 4px;
        text-decoration: none;
        width:100%;
    }
    .gallery-images a:hover { background: #c82333; }
    .btn-th { width: 50%; border:0; }
</style>
<?php
$content = ob_get_clean();
include 'Layout_AD.php';
?>
