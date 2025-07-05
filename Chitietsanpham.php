<?php
include 'includes/youjia_connect.php';
session_start();
ob_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM sanpham WHERE MaSP = '$id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $MauSac = !empty($row['MauSac']) ? explode(',', $row['MauSac']) : [];
    } else {
        echo "<p style='color:red;'>Không tìm thấy sản phẩm!</p>";
        exit;
    }
} else {
    echo "<p style='color:red;'>Thiếu mã sản phẩm!</p>";
    exit;
}
?>

<link rel="stylesheet" href="css/bootstrap.css">
<div>
<div class="row">
    <h2 style="color: #285560; text-align: center;"><b>THÔNG TIN SẢN PHẨM</b></h2>
    <hr style='align-item: center'>
    <br>

    <div class="col-md-6 text-center">
        <?php
        $images = [];
        $sql_img = "SELECT AnhSP FROM hinhanh WHERE MaSP = '$id'";
        $result_img = mysqli_query($conn, $sql_img);
        if ($result_img && mysqli_num_rows($result_img) > 0) {
            while ($img_row = mysqli_fetch_assoc($result_img)) {
                $images[] = $img_row['AnhSP'];
            }
        }
        ?>

        <?php if (!empty($images)): ?>
        <div id="carousel1" class="carousel slide" data-ride="carousel" style="max-width: 500px; margin: auto;">
            <ol class="carousel-indicators">
                <?php foreach ($images as $index => $img): ?>
                    <li data-target="#carousel1" data-slide-to="<?= $index ?>" class="<?= ($index === 0) ? 'active' : '' ?>"></li>
                <?php endforeach; ?>
            </ol>

            <div class="carousel-inner">
                <?php foreach ($images as $index => $img): ?>
                    <div class="item <?= ($index === 0) ? 'active' : '' ?>">
                        <img class="img-responsive" src="Images/<?= htmlspecialchars($img) ?>" alt="Ảnh <?= $index + 1 ?>" style="width:100%; height:500px; object-fit:cover;">
                        <div class="carousel-caption"></div>
                    </div>
                <?php endforeach; ?>
            </div>

            <a class="left carousel-control" href="#carousel1" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#carousel1" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
        </div>
        <?php else: ?>
            <img src="Images/<?= htmlspecialchars($row['AnhBia']) ?>" alt="Ảnh mặc định" style="width: 500px; height: 500px; object-fit: cover;">
        <?php endif; ?>
    </div>

    <div class="col-md-5" style="color: #285560;">
        <h2><b><?= htmlspecialchars($row['TenSP']) ?></b></h2>
        <hr>

        <h4><b>Mô tả:</b></h4>
        <?php
            $items = explode("\n", trim($row['MoTa']));
            echo "<ul style='text-align:left; padding-left: 50px; list-style-type: none;'>";
            foreach ($items as $item) {
                $item = trim($item);
                if ($item !== '') {
                    echo "<li style='border-bottom: 0.1px solid #ccc; padding: 2px 0; background: url(\"images/MuiTen.png\") no-repeat left center; background-size: 15px 15px; padding-left: 25px;'>" . htmlspecialchars($item) . "</li>";
                }
            }
            echo "</ul>";
        ?>
        <hr>

        <h4><b>Bảo hành:</b> <?= htmlspecialchars($row['BaoHanh']) ?> ngày</h4>
        <hr>

        <h4><b>Giá bán:</b> <?= number_format($row['GiaBan'], 0, ',', '.') ?> VNĐ</h4>
        <hr>

        <!-- Dropdown màu -->
        <div>
            <label for="selectMau"><h4><b>Màu sắc:</b></h4></label>
            <select name="MauSacDropdown" id="selectMau" class="form-control" required style="width: 50%; display: inline-block;">
                <option value="">--- CHỌN MÀU SẮC ---</option>
                <?php foreach ($MauSac as $mau): ?>
                    <option value="<?= htmlspecialchars($mau) ?>"><?= htmlspecialchars($mau) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <hr>

        <!-- Form Thêm vào giỏ -->
        <form method="post" action="ThemVaoGioHang.php">
            <input type="hidden" name="MaSP" value="<?= $row['MaSP'] ?>">
            <input type="hidden" name="SoLuong" value="1">
            <input type="hidden" name="GiaBan" value="<?= $row['GiaBan'] ?>">
            <input type="hidden" name="MauSac" id="inputMauSac">

            <button type="submit" class="btn btn-success">Thêm vào giỏ hàng</button>
        </form>
    </div>
</div>
<br><br><br><br>
</div>

<?php
$content = ob_get_clean();
include 'includes/youjia_layout.php';
?>

<!-- Script để lấy màu từ dropdown -->
<script>
    document.getElementById("selectMau").addEventListener("change", function () {
        document.getElementById("inputMauSac").value = this.value;
    });
</script>

<style>
p, option, li {
    line-height: 1.5;
}

hr {
    border: 0;
    height: 1px;
    width: 100%;
    margin: 10px 0;
}

img {
    width: 500px;
    height: 600px;
}
.btn-success {
    WIDTH: 100%;
}
</style>
