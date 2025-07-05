<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width" />
    <title>ĐĂNG NHẬP ADMIN</title>
</head>
<style>
    body {
        background-color:rgb(255, 255, 255);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
    }

    h2 {
        color: rgb(255, 120, 160);
        font-size: 28px;
        margin-top: 60px;
        margin-bottom: 10px;
        font-weight: bold;
    }

    table {
        background-color:rgb(255, 234, 243);
        padding: 30px 40px;
        border-radius: 15px;
        box-shadow: 4px 4px rgba(232, 85, 134, 0.51);
        margin-top: 20px;
        border: 5px rgb(232, 85, 134);
    }

    td {
        font-size: 20px;
        color:rgb(255, 102, 148);
        padding: 10px 5px;
    }

    input[type="text"],
    input[type="password"] {
        width: 400px;
        height: 30px;
        padding: 8px;
        border: 1px solid rgb(254, 199, 208);
        border-radius: 10px;
        outline: none;
        background-color: #fff;
        transition: border-color 0.3s;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
        border-color: rgb(255, 160, 192);
        box-shadow: 0 0 5px rgba(255, 160, 192, 0.5);
    }

    input[type="submit"] {
        width: 100%;
        height: 40px;
        padding: 8px 16px;
        background-color: rgb(255, 107, 156);
        color: white;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
        align-items: center;
        text-align: center;
    }

    input[type="submit"]:hover {
        background-color: rgb(255, 88, 138);
    }

    h4 {
        color: red;
        margin-bottom: 5px;
    }

    tr {
        height: 40px;
    }
</style>
<body>
<br><br>
<?php 
    function GetMD5($str) {
        return strtolower(md5($str));
    }

    include '../includes/youjia_connect.php';
    session_start();
    $thongbao = "";

    if (!$conn) {
        die("<h4 style='text-align:center;'>Kết nối CSDL thất bại: " . mysqli_connect_error() . "</h4>");
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = trim($_POST['TenDN']);
        $password = trim($_POST['MatKhau']);
    
        if (empty($username) || empty($password)) {
            $thongbao = "Tên đăng nhập và mật khẩu không được để trống.";
        } else {
            // So sánh mật khẩu gốc mà không mã hóa
            $sql = "SELECT * FROM Admin WHERE TaiKhoan = '$username' AND MatKhau = '$password'";
            $result = mysqli_query($conn, $sql);
    
            if (!$result) {
                $thongbao = "Lỗi truy vấn: " . mysqli_error($conn);
            } elseif (mysqli_num_rows($result) == 0) {
                $thongbao = "Tên đăng nhập và mật khẩu không đúng.";
            } else {
                $_SESSION['admin'] = $username;
                echo "<script>
                        alert('Đăng nhập thành công!');
                        window.location.href = 'index.php';
                      </script>";
                exit();
            }
        }
    }
    
    $conn->close();
?>

<table align="center">
    <h2 style="text-align:center">ĐĂNG NHẬP</h2>
    <?php
        if ($thongbao != "") {
            echo "<h4 style='text-align:center;'>$thongbao</h4>";
        }
    ?>
    <form action="DangNhap_AD.php" method="POST">
        <tr>
            <td>Tài khoản:</td>
            <td><input type="text" name="TenDN" required /></td>
        </tr>
        <tr>
            <td>Mật khẩu:</td>
            <td><input type="password" name="MatKhau" required /></td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" value="Đăng nhập" /></td>
        </tr>
    </form>
</table>

</body>
</html>
