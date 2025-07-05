<?php
ob_start();
include '../includes/youjia_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    $TenNDM = $_POST['TenNDM'] ?? '';

    // Kiểm tra lỗi cơ bản
    if (empty($TenNDM)) {
        $errors['TenNDM'] = "Tên nhóm danh mục không được để trống.";
    }

    if (empty($errors)) {
        $sql = "INSERT INTO NhomDanhMuc (TenNDM)
                VALUES (?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 's', $TenNDM);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            echo "<script>
                    alert('Thêm thương hiệu thành công!');
                    window.location.href = 'QL_NDM.php';
                  </script>";
        } else {
            echo "<div class='alert alert-danger'>Thêm mới thất bại!</div>";
        }
    }
}
?>

<div class="container">
    <br>
    <h2 class="text-center mt-4"><b>THÊM NHÓM DANH MỤC MỚI </b></h2>
    <hr>
    <form method="POST">
        <div class="form-group row">
            <label class="control-label col-md-2">Tên nhóm DM</label>
            <div class="col-md-10">
                <input type="text" name="TenNDM" class="form-control" value="<?= htmlspecialchars($TenNDM ?? '') ?>" />
                <span class="text-danger"><?= $errors['TenNDM'] ?? '' ?></span>
            </div>
        </div>

        
        <div class="form-group row text-center">
            <div class="col-md-offset-2 col-md-10">
                <input type="submit" value="LƯU" class="btn btn-luu">
            </div>
        </div>
    </form>

    <h2>
        <a href="QL_NDM.php" style='color: rgb(237, 79, 134); font-style: italic;'>Trở về</a>
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
        width: 100%;
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
