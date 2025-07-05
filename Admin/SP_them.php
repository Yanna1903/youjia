<?php
ob_start();
include '../includes/youjia_connect.php';

$errors = [];
$MaSP = $_POST['MaSP'] ?? '';
$TenSP = $_POST['TenSP'] ?? '';
$GiaBan = $_POST['GiaBan'] ?? '';
$MoTa = $_POST['MoTa'] ?? '';
$MaDM = $_POST['MaDM'] ?? '';
$MaNDM = $_POST['MaTH'] ?? ''; // Khớp tên form
$SoLuong = $_POST['SoLuong'] ?? '';
// $Size = $_POST['Size'] ?? '';
$MauSac = $_POST['MauSac'] ?? '';
$TrangThai = isset($_POST['TrangThai']) ? 1 : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Kiểm tra lỗi nhập liệu
    if (empty($MaSP)) $errors['MaSP'] = "Tên sản phẩm không được để trống.";
    if (empty($TenSP)) $errors['TenSP'] = "Tên sản phẩm không được để trống.";
    if (empty($GiaBan)) $errors['GiaBan'] = "Giá bán không được để trống.";
    if (empty($MaDM)) $errors['MaDM'] = "Danh mục không được để trống.";
    if (empty($MaNDM)) $errors['MaTH'] = "Nhóm danh mục không được để trống.";
    if (empty($SoLuong)) $errors['SoLuong'] = "Số lượng không được để trống.";

    // Nếu không có lỗi
    if (empty($errors)) {
        $AnhBia = $_FILES['AnhBia'] ?? null;
        $target_dir = "../images/";
        $target_file = $target_dir . basename($AnhBia["name"]);
        $uploadOk = 1;

        // Kiểm tra định dạng ảnh
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            $errors['AnhBia'] = "Chỉ chấp nhận JPG, JPEG, PNG, GIF.";
            $uploadOk = 0;
        }

        if ($uploadOk && move_uploaded_file($AnhBia["tmp_name"], $target_file)) {
            $sql = "INSERT INTO sanpham (MaSP, TenSP, AnhBia, GiaBan, MoTa, MaDM, MaNDM, SoLuong, MauSac, TrangThai)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, 'sssdsssiii',$MaSP, $TenSP, $target_file, $GiaBan, $MoTa, $MaDM, $MaNDM, $SoLuong, $MauSac, $TrangThai);

            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                echo "<script>alert('Thêm sản phẩm thành công!'); window.location.href = 'QL_SP.php';</script>";
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

<div class="container">
    <br>
    <h2 class="text-center mt-4"><b>THÊM SẢN PHẨM MỚI</b></h2>
    <hr>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group row">
            <label class="control-label col-md-2">Mã Sản Phẩm</label>
            <div class="col-md-10">
                <input type="text" name="MaSP" class="form-control" value="<?= htmlspecialchars($MaSP) ?>" />
                <span class="text-danger"><?= $errors['MaSP'] ?? '' ?></span>
            </div>
        </div>
        <div class="form-group row">
            <label class="control-label col-md-2">Tên Sản Phẩm</label>
            <div class="col-md-10">
                <input type="text" name="TenSP" class="form-control" value="<?= htmlspecialchars($TenSP) ?>" />
                <span class="text-danger"><?= $errors['TenSP'] ?? '' ?></span>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-2">Ảnh Bìa</label>
            <div class="col-md-10">
                <input type="file" name="AnhBia" class="form-control" />
                <span class="text-danger"><?= $errors['AnhBia'] ?? '' ?></span>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-2">Giá Bán</label>
            <div class="col-md-10">
                <input type="number" name="GiaBan" class="form-control" value="<?= htmlspecialchars($GiaBan) ?>" />
                <span class="text-danger"><?= $errors['GiaBan'] ?? '' ?></span>
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-2">Mô Tả</label>
            <div class="col-md-10">
                <textarea name="MoTa" class="form-control"><?= htmlspecialchars($MoTa) ?></textarea>
            </div>
        </div>

        <!-- Dropdown chọn Nhóm Danh Mục -->
        <div class="form-group row">
            <label class="control-label col-md-2" for="MaNDM">Nhóm Danh Mục:</label>
            <div class="col-md-10"> 
                <select name="MaNDM" id="MaNDM" class="form-control" required>
                    <option value="">-- Chọn nhóm danh mục --</option>
                    <?php
                    $sql_ndm = "SELECT * FROM nhomdanhmuc";
                    $result_ndm = mysqli_query($conn, $sql_ndm);
                    while ($row_ndm = mysqli_fetch_assoc($result_ndm)) {
                        echo '<option value="' . $row_ndm['MaNDM'] . '">' . $row_ndm['TenNDM'] . '</option>';
                    }
                    ?>
                </select>
            </div> 
        </div>

        <!-- Dropdown chọn Danh Mục (sẽ thay đổi theo Nhóm Danh Mục) -->
        <div class="form-group row">
            <label class="control-label col-md-2" for="MaDM">Danh Mục:</label>
            <div class="col-md-10"> 
                <select name="MaDM" id="MaDM" class="form-control" required>
                    <option value="">-- Chọn danh mục --</option>
                    <!-- Danh mục sẽ được load bằng JavaScript dựa trên nhóm danh mục -->
                </select>
            </div> 
        </div>

        <!-- Script load danh mục theo nhóm danh mục -->
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


        <div class="form-group row">
            <label class="control-label col-md-2">Số Lượng</label>
            <div class="col-md-10">
                <input type="number" name="SoLuong" class="form-control" value="<?= htmlspecialchars($SoLuong) ?>" />
                <span class="text-danger"><?= $errors['SoLuong'] ?? '' ?></span>
            </div>
        </div>

        <!-- <div class="form-group row">
            <label class="control-label col-md-2">Size</label>
            <div class="col-md-10">
                <input type="text" name="Size" class="form-control" value="<?= htmlspecialchars($Size) ?>" />
            </div>
        </div> -->

        <div class="form-group row">
            <label class="control-label col-md-2">Màu Sắc</label>
            <div class="col-md-10">
                <input type="text" name="MauSac" class="form-control" value="<?= htmlspecialchars($MauSac) ?>" />
            </div>
        </div>

        <div class="form-group row">
            <label class="control-label col-md-2">Trạng Thái</label>
            <div class="col-md-10">
                <input type="checkbox" name="TrangThai" <?= $TrangThai ? 'checked' : '' ?> />
                <span style="font-size: 13px;">(Còn hàng)</span>
            </div>
        </div>

        <div class="form-group row text-center">
            <div class="col-md-offset-2 col-md-10">
                <input type="submit" value="LƯU" class="btn btn-luu">
            </div>
        </div>
    </form>

    <h2>
        <a href="QL_SP.php" style='color: rgb(237, 79, 134); font-style: italic;'>Trở về</a>
    </h2>
</div>

<?php
$content = ob_get_clean();
include 'Layout_AD.php';
?>

<style>
    body {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        text-decoration: none;
        list-style: none;
    }

    label {
        align: left !important;
    }
    hr {
        border: 0;
        height: 5px !important;
        background-color: rgba(0, 95, 116, 0.44);
        margin-top: 20px;
        margin-bottom: 20px;
        width: 80%;
    }

    table {
        border-collapse: collapse;
        width: auto;
        margin: 20px auto;
        background-color: rgb(255, 212, 231);
        padding: 50px 100px;
        border-radius: 15px;
        box-shadow: 4px 4px rgba(0, 95, 116, 0.44);
        border: 2px solid rgb(0, 95, 116);
        line-height: 1.8;
    }

    h2 {
        font-size: 30px !important;
        color: rgb(0, 94, 116) !important;
    }

    label {
        color: rgb(0, 94, 116) !important;
        font-size: 18px !important;
        line-height: 1.8;
    }

    .btn-luu {
        color: #fff;
        padding: 6px 10px;
        font-size: 12px;
        font-weight: bold;
        border: 2px solid transparent;
        cursor: pointer;
        text-transform: uppercase;
        background-color:rgb(0, 123, 150) !important;
        margin: 0px;
        width:100%;
    }

    .btn-luu:hover {
        background-color:rgb(0, 94, 116) !important;
        color: #fff !important;
    }

    /* Style chung cho input, select */
    input[type="text"],
    input[type="number"],
    select,
    textarea {
        width: 100% !important;
        height: 40px;
        padding: 8px;
        border: 1px solid rgba(0, 95, 116, 0.4) !important;
        border-radius: 10px;
        outline: none;
        background-color: #fff;
        transition: border-color 0.3s, box-shadow 0.3s;
        font-size: 16px;
        line-height: 1.5;
    }

    input[type="text"]:focus,
    input[type="number"]:focus,
    select:focus,
    textarea:focus {
        border-color: rgb(0, 94, 116) !important;
        box-shadow: 0 0 5px rgba(0, 94, 116, 0.5) !important;
        outline: none;
    }

    input[type="submit"] {
        width: 100%;
        height: 40px;
        padding: 8px 8px;
        background-color: rgb(0, 94, 116);
        color: white;
        font-weight: bold;
        font-size: 20px;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
        text-align: center;
    }

    input[type="submit"]:hover {
        background-color:rgb(0, 94, 116);
    }
</style>
