<?php
session_start();
include "includes/youjia_connect.php";     
include "includes/header.php";     
?>
    <link rel="stylesheet" href="css/bootstrap.css">

<br> <br>
<h2 class="text-center"><b>GIỎ HÀNG</b></h2>
<hr>
<div>
<?php if (!empty($_SESSION['cart'])) { ?>
    <form action="GH_capnhat.php" method="post">
        <table class="table table-bordered table-striped">
            <thead>
                <tr class="text-center">
                    <th width='5%'>STT</th>
                    <th width='15%'>Tên sản phẩm</th>
                    <th width='15%'>Hình ảnh</th>
                    <!-- <th width='10%'>Size</th> -->
                    <th width='10%'>Màu sắc</th>
                    <th width='15%'>Đơn giá (VNĐ)</th>
                    <th width='10%'>Số lượng</th>
                    <th width='10%'>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;
                $s = 0;

                foreach ($_SESSION['cart'] as $id => $sp) {
                    $s += $sp['GiaBan'] * $sp['SoLuong'];
                    echo "<tr>";
                    echo "<td class='text-center'>" . ++$i . "</td>";
                    echo "<td>" . htmlspecialchars($sp['TenSP']) . "</td>";
                    echo "<td class='text-center'><img src='images/" . htmlspecialchars($sp['AnhBia']) . "' class='img-responsive' style='max-width: 100px;'></td>";
                    // Kiểm tra nếu không có Size hoặc MauSac thì hiển thị "-".
                    // echo "<td class='text-center'>" . htmlspecialchars($sp['Size'] ?? '-') . "</td>";
                    echo "<td class='text-center'>" . htmlspecialchars($sp['MauSac'] ?? '-') . "</td>";
                    echo "<td class='text-center'>" . number_format($sp['GiaBan'], 0, ',', '.') . "</td>";
                    echo "<td class='text-center'>
                            <input type='number' name='SoLuong[$id]' value='{$sp['SoLuong']}' class='form-control' style='width: 60px; text-align: center;'>
                          </td>";
                    echo "<td class='text-center'><a href='GH_xoasp.php?id=" . $sp['MaSP'] . "' class='btn btn-success'>Xóa</a></td>";
                    echo "</tr>";
                }
                ?>
                <tr>
                    <td colspan="8" class="text-right">
                        <strong>Tổng số tiền: <?php echo number_format($s, 0, ',', '.'); ?> VNĐ</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="8" class="text-center">
                        <!-- <input type="submit" value="Cập nhật" class="btn btn-primary"> -->
                        <input type="button" value="Mua tiếp" class="btn btn-a" onclick="window.location='index.php'">
                        <input type="button" value="Hủy giỏ hàng" class="btn btn-a" onClick="window.location='GH_huy.php'">
                        <input type="button" value="Đặt mua" class="btn btn-a" onClick="window.location='GH_datmua.php'">
                        <input type="button" value="Cập nhật" class="btn btn-a" onClick="window.location='GH_capnhat.php'">
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <br> <br><br> <br>
<?php } else { ?>
    <h2 class="text-center"> ----------------------- Giỏ hàng trống ----------------------- <h2>
    <br>
    <div class="text-center">
        <a href='index.php' class="btn btn-a"> Quay về</a>
        <br> <br>
    </div>
</div>

<?php } 
include 'includes/footer.php';
?>

<style>
   /* Bảng giỏ hàng */
   table {
    width: 1000px !important;
    border-collapse: collapse;
    text-align: center;
    margin: 0 auto;  /* Căn giữa bảng */
    color: #285560;
    background-color: white !important;
}
hr {
  border: none;
  border-top: 5px solid rgba(40, 85, 96, 0.32); 
  width: 50%; /* Chiều dài của thẻ hr, có thể điều chỉnh */
  margin: 20px auto; /* Căn giữa và tạo khoảng cách phía trên/dưới */
  display: block; /* Đảm bảo thẻ hr có kiểu hiển thị block */
}


h2 {
    color: #285560;

}
table th, table td {
    padding: 10px;
    text-align: center;
    border: 1px solid rgba(40, 85, 96, 0.43) !important;
    background-color: white !important;
}

table th {
    font-weight: bold;
    background-color:rgb(225, 249, 255) !important;

}

.btn-success{
    background-color: rgb(68, 143, 160) !important;
    border: 1px rgb(49, 111, 125);
    padding: 8px 4px 4px 4px !important;
}
.btn-success:hover, .btn-success:focus {
    background-color: rgb(28, 98, 114) !important;
    border: 1px rgb(28, 98, 114);
}
.btn-a{
    background-color: rgb(68, 143, 160) !important;
    border: 1px rgb(49, 111, 125);
    padding: 6px 4px 4px 4px !important;
    width: 150px;
    height: 40px;
    color: #fff;
}
.btn-a:hover, .btn-a:focus {
    background-color: rgb(28, 98, 114) !important;
    border: 1px rgb(28, 98, 114);
    color: #fff;
}
</style>