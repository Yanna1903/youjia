<?php
include '../includes/youjia_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tieude = $_POST['tieude'];
    $link = $_POST['link'];
    $file = $_FILES['banner'];

    if ($file['error'] === 0) {
        $filename = time() . '_' . basename($file['name']);
        move_uploaded_file($file['tmp_name'], '../images/' . $filename);
        $sql = "INSERT INTO banner (Banner, TieuDe, Link) VALUES ('$filename', '$tieude', '$link')";
        mysqli_query($conn, $sql);
        header("Location: AD_banner.php");
        exit;
    }
}
?>
<h3>Thêm Banner</h3>
<hr>
<form method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label>Tiêu đề</label>
        <input type="text" name="tieude" class="form-control">
    </div>
    <div class="form-group">
        <label>Link</label>
        <input type="text" name="link" class="form-control">
    </div>
    <div class="form-group">
        <label>Hình banner</label>
        <input type="file" name="banner" class="form-control" required>
    </div>
    <button type="submit" class="btn-luu">Thêm</button>
</form>
<?php
    $conn->close();
    $content = ob_get_clean();
    include 'Layout_AD.php';
?>

