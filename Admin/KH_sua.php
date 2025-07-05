<?php
ob_start();
include '../includes/youjia_connect.php';

if (isset($_GET['id'])) {
    $MaKH = $_GET['id'];
    $errors = [];

    $sql = "SELECT * FROM khachhang WHERE MaKH = '$MaKH'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $TenKH      = $row['TenKH'];        //1
        $Username   = $row['Username'];
        $MatKhau    = $row['MatKhau'] ;     //3
        $GioiTinh   = $row['GioiTinh'];
        $Email      = $row['Email'];        //5
        $DiaChi     = $row['DiaChi'];
        $SDT        = $row['SDT'];          //7
        $NgaySinh   = $row['NgaySinh'];
        $TrangThai  = $row['TrangThai'];    //9
    } 

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $TenKH      = $_POST['TenKH'] ?? '';    //1
        $Username   = $_POST['Username'] ?? '';
        $MatKhau    = $_POST['MatKhau'] ?? '';  //3
        $GioiTinh   = $_POST['GioiTinh'] ?? '';
        $Email      = $_POST['Email'] ?? '';    //5
        $DiaChi     = $_POST['DiaChi'] ?? '';
        $SDT        = $_POST['SDT'] ?? '';      //7
        $NgaySinh   = $_POST['NgaySinh'] ?? '';
        $TrangThai  = $_POST['TrangThai'] ?? '';//9

        if (empty($errors)) {
            $sql_update  =  "UPDATE khachhang 
                                SET TenKH       = '$TenKH',     
                                    Username    = '$Username', 
                                    MatKhau     = '$MatKhau' , 
                                    GioiTinh    = '$GioiTinh', 
                                    Email       = '$Email', 
                                    DiaChi      = '$DiaChi', 
                                    SDT         = '$SDT',
                                    NgaySinh    = '$NgaySinh',
                                    TrangThai   = '$TrangThai'
                                WHERE MaKH = '$MaKH'"; 
                                
            $result_update = mysqli_query($conn, $sql_update);

            if ($result_update) {
                echo "<script>
                        alert('Cập nhật thành công!');
                        window.location.href = 'QL_KH.php';
                      </script>";
            } else {
                echo "<script>
                        alert('Cập nhật thất bại!');
                    </script>";            
                }
            }
        }
    }
?>


<div class="container">
    <h2 class="text-center mt-4" style='color:rgb(212, 139, 3)'><b>SỬA THÔNG TIN KHÁCH HÀNG</b></h2>
    <hr />
    <form class="form-horizontal" method="POST" action="">
        <!-- tên -->
        <div class="form-group row">
            <label for="TenKH" class="control-label col-md-2">Họ Tên</label>
            <div class="col-md-10">
                <input type="text" name="TenKH" class="form-control" value="<?= htmlspecialchars($TenKH ?? '') ?>" />
                <span class="text-danger"><?= $errors['TenKH'] ?? '' ?></span>
            </div>
        </div>
        <!-- user  -->
        <div class="form-group row">
            <label for="Username" class="control-label col-md-2">Username</label>
            <div class="col-md-10">
                <input type="text" name="Username" class="form-control" value="<?= htmlspecialchars($Username ?? '') ?>" />
                <span class="text-danger"><?= $errors['Username'] ?? '' ?></span>
            </div>
        </div>
        <!-- mật khẩu  -->
        <div class="form-group row">
            <label for="MatKhau" class="control-label col-md-2">Mật khẩu</label>
            <div class="col-md-10">
                <input type="text" name="MatKhau" class="form-control" value="<?= htmlspecialchars($MatKhau ?? '') ?>" />
                <span class="text-danger"><?= $errors['MatKhau'] ?? '' ?></span>
            </div>
        </div>
        <!-- giới tính  -->
        <div class="form-group row">
            <label for="GioiTinh" class="control-label col-md-2">Giới tính</label>
            <div class="col-md-10">
                <select name="GioiTinh" class="form-control">
                    <option value="0" <?= ($GioiTinh == 0) ? 'selected' : '' ?>>Nam</option>
                    <option value="1" <?= ($GioiTinh == 1) ? 'selected' : '' ?>>Nữ</option>
                </select>
                <span class="text-danger"><?= $errors['GioiTinh'] ?? '' ?></span>
            </div>
        </div>

        <!-- Email  -->
        <div class="form-group row">
            <label for="Email" class="control-label col-md-2">Email</label>
            <div class="col-md-10">
                <input type="email" name="Email" class="form-control" value="<?= htmlspecialchars($Email ?? '') ?>" />
            </div>
        </div>
        <!-- Địa chỉ -->
        <div class="form-group row">
            <label for="DiaChi" class="control-label col-md-2">Địa Chỉ</label>
            <div class="col-md-10">
                <input type="text" name="DiaChi" class="form-control" value="<?= htmlspecialchars($DiaChi ?? '') ?>" />
            </div>
        </div>
        <!-- SDT -->
        <div class="form-group row">
            <label for="SDT" class="control-label col-md-2">Điện Thoại</label>
            <div class="col-md-10">
                <input type="text" name="SDT" class="form-control" value="<?= htmlspecialchars($SDT ?? '') ?>" />
            </div>
        </div>
        <!-- ngày sinh nhật -->
        <div class="form-group row">
            <label for="NgaySinh" class="control-label col-md-2">Ngày Sinh</label>
            <div class="col-md-10">
                <input type="date" name="NgaySinh" class="form-control" value="<?= htmlspecialchars($NgaySinh ?? '') ?>" />
            </div>
        </div>
        <!-- Trạng thái -->
        <div class="form-group row">
            <label for="TrangThai" class="control-label col-md-2">Trạng Thái</label>
            <div class="col-md-10">
                <select name="TrangThai" class="form-control">
                    <option value="0" <?= ($TrangThai == 0) ? 'selected' : '' ?>>Bị khóa/ không còn</option>
                    <option value="1" <?= ($TrangThai == 1) ? 'selected' : '' ?>>Tồn tại</option>
                </select>
                <span class="text-danger"><?= $errors['TrangThai'] ?? '' ?></span>
            </div>
        </div>        <!-- nút -->
        <div class="col-md-offset-2 col-md-10">
            <input type="submit" value="LƯU" class="btn-luu">
        </div>
    </form>

    <h4>
        <a href="QL_KH.php" style='color:rgb(251, 95, 147); font-style: italic; text-decoration: underline;'>Trở về</a>
    </h4>
</div>

<?php
$content = ob_get_clean();
include 'Layout_AD.php';
?>