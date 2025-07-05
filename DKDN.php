<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập/ Đăng ký</title>
    <link rel="stylesheet" href="css/DNDN.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<?php
    ob_start();
    session_start();
    include 'includes/youjia_connect.php';

    $note = "";
    $thongbao = "";

    // Đăng ký
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['register'])) {
            $hoten = trim($_POST['Username']);
            $gioitinh = $_POST['GioiTinh'];
            $password = trim($_POST['MatKhau']);
            $repassword = trim($_POST['MatKhauNL']);
            $email = trim($_POST['Email']);
            $phone = trim($_POST['SDT']);
            $birthday = $_POST['NgaySinh'];
            $address = trim($_POST['DiaChi']);

            if (empty($hoten) || empty($password) || empty($repassword) || empty($email) || empty($phone)) {
                $note = "Vui lòng điền đầy đủ thông tin.";
            } elseif ($password !== $repassword) {
                $note = "Mật khẩu không khớp.";
            } else {
                $sqlCheckEmail = "SELECT * FROM KhachHang WHERE Email = '$email'";
                $checkEmail = mysqli_query($conn, $sqlCheckEmail);

                if (!$checkEmail) {
                    $note = "Lỗi truy vấn email: " . mysqli_error($conn);
                } elseif (mysqli_num_rows($checkEmail) > 0) {
                    $note = "Email đã tồn tại.";
                } else {
                    $sqlInsert = "INSERT INTO KhachHang (TenKH, GioiTinh, Email, SDT, DiaChi, NgaySinh, MatKhau, TrangThai)
                                  VALUES ('$hoten', '$gioitinh', '$email', '$phone', '$address', '$birthday', '$password', 1)";
                    $resultInsert = mysqli_query($conn, $sqlInsert);

                    if ($resultInsert) {
                        echo "<script>alert('Đăng ký thành công! Chuyển đến trang đăng nhập.');
                        window.location.href='DKDN.php';</script>";
                        exit();
                    } else {
                        $note = "Lỗi khi đăng ký: " . mysqli_error($conn);
                    }
                }
            }
        } 
        
        // Đăng nhập
        elseif (isset($_POST['login'])) {
            $username = isset($_POST['Username']) ? trim($_POST['Username']) : ''; // kiểm tra nếu có tồn tại
            $password = isset($_POST['MatKhau']) ? trim($_POST['MatKhau']) : '';

            if (empty($username) || empty($password)) {
                $thongbao = "Tên đăng nhập và mật khẩu không được để trống.";
            } else {
                $sql = "SELECT * FROM khachhang WHERE TRIM(Username) = '$username' AND MatKhau = '$password'";
                $result = mysqli_query($conn, $sql);

                if (!$result) {
                    die("Lỗi truy vấn: " . mysqli_error($conn));
                }

                if (mysqli_num_rows($result) == 0) {
                    $thongbao = "Tên đăng nhập hoặc mật khẩu không đúng.";
                } else {
                    $user_data = mysqli_fetch_assoc($result);
                    $_SESSION['username'] = $user_data['Username']; // Đảm bảo gán tên đăng nhập vào session
                    echo "<script>alert('Đăng nhập thành công. Về trang chủ.');
                        window.location.href='index.php';</script>";
                    exit();
                }
            }
        }
    }
?>

<div class="container">
    <!-- đăng nhập -->
    <div class="form-box login">
        <form action="" method="POST">
            <h1>Đăng nhập</h1>
            <hr class="custom-hr">
            <div class="input-box">
                <input type="text" placeholder="Username" name="Username" required>
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" name="MatKhau" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="forgot-link">
                <a href="quenMK.php">Quên mật khẩu?</a>
            </div>
            <button type="submit" name="login" class="btn">Đăng nhập</button>
            <p style="color:red; text-align:center; font-weight:bold;">
                <?php echo $thongbao ?>
            </p>
            <p>Đăng nhập bằng:</p>
            <div class="social-icons">
                <a href="https://www.google.com"><i class='bx bxl-google'></i></a>
                <a href="https://www.facebook.com/"><i class='bx bxl-facebook'></i></a>
                <a href="https://www.github.com"><i class='bx bxl-github'></i></a>
                <a href="https://www.linkedin.com/"><i class='bx bxl-linkedin'></i></a>
            </div>
        </form>
    </div>

    <div class="form-box register">  
    <form action="" method="POST">
        <h2 style="text-align: center">ĐĂNG KÝ THÀNH VIÊN</h2>
        <hr>

        <!-- Họ tên -->
        <div class="input-box">
            <input type="text" placeholder="Họ tên" name="Username" required>
            <i class='bx bxs-user'></i>
        </div>

        <!-- Giới tính -->
        <div class="input-box">
            <input type="text" placeholder="Giới tính" name="GioiTinh" required>
            <i class='bx bxs-user'></i>
        </div>

        <!-- Mật khẩu -->
        <div class="input-box">
            <input type="password" placeholder="Mật khẩu" name="MatKhau" required>
            <i class='bx bxs-lock-alt'></i>
        </div>

        <!-- Nhập lại mật khẩu -->
        <div class="input-box">
            <input type="password" placeholder="Nhập lại mật khẩu" name="MatKhauNL" required>
            <i class='bx bxs-lock-alt'></i>
        </div>

        <!-- Email -->
        <div class="input-box">
            <input type="email" placeholder="Email" name="Email" required>
            <i class='bx bxs-envelope'></i>
        </div>

        <!-- Số điện thoại -->
        <div class="input-box">
            <input type="text" placeholder="Số điện thoại" name="SDT" required>
            <i class='bx bxs-phone'></i>
        </div>

        <!-- Ngày sinh -->
        <div class="input-box">
            <input type="date" name="NgaySinh" required>
        </div>

        <!-- Địa chỉ -->
        <div class="input-box">
            <input type="text" placeholder="Địa chỉ" name="DiaChi" required>
            <i class='bx bxs-location-plus'></i>
        </div>

        <!-- Submit -->
        <div class="input-box">
            <button type="submit" name="register" class="btn">Đăng ký</button>
        </div>
    </form>
</div>


    <div class="toggle-box">
        <div class="toggle-panel toggle-left">
            <h1>Xin chào, chào mừng bạn!</h1>
            <p>Bạn chưa có tài khoản?</p>
            <button class="btn register-btn">Đăng ký</button>
        </div>

        <div class="toggle-panel toggle-right">
            <h1>Chào mừng trở lại!</h1>
            <p>Bạn đã có tài khoản?</p>
            <button class="btn login-btn">Đăng nhập</button>
        </div>
    </div>
</div>

<script src="js/DKDN.js"></script>
</body>
</html>
