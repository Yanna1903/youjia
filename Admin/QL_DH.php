<?php
    ob_start();
    include '../includes/youjia_connect.php';
    $sql = "SELECT * FROM donhang ORDER BY MaDH desc";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Lỗi truy vấn: " . mysqli_error($conn));
    }
?>
<!-- <link rel="stylesheet" href="css/bootstrap.css"> -->
<link rel="stylesheet" href="css/CSS.css">

<div class="thongtin">
    <h2 class="text-center mb-4"><b>DANH SÁCH ĐƠN HÀNG</b></h2>
    <hr>
    <?php if (mysqli_num_rows($result) > 0) { ?>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th class="text-center">Mã đơn hàng</th>
                <th class="text-center">Ngày đặt</th>
                <th class="text-center">Mã khách hàng</th>
                <th class="text-center">Địa chỉ</th>
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Ngày giao</th>
                <th class="text-center">Tổng tiền</th>
                <th class="text-center">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { 
                $trangThai = '';
                switch ($row['TrangThai']) {
                    case 1: $trangThai = 'Chờ xác nhận'; break;
                    case 2: $trangThai = 'Đã xác nhận'; break;
                    case 3: $trangThai = 'Đang giao'; break;
                    case 4: $trangThai = 'Đang giao'; break;
                    case 5: $trangThai = 'Đơn hàng đã hủy'; break;
                }
            ?>
            <tr style="background-color: white;">
            <td class="text-center"><?= htmlspecialchars($row['MaDH']) ?></td>
                <td class="text-center"><?= htmlspecialchars($row['NgayDH']) ?></td>
                <td class="text-center"><?= htmlspecialchars($row['MaKH']) ?></td>
                <td class="text-center"><?= htmlspecialchars($row['DiaChi']) ?></td>
                <td class="text-center"><?= $trangThai ?></td>
                <td class="text-center"><?= htmlspecialchars($row['NgayGiao']) ?></td>
                <td class="text-center"><?= htmlspecialchars($row['TongTien']) ?></td>
                <td class="text-center">
                    <a href="DH_chitiet.php?id=<?= $row['MaDH'] ?>" class="btn btn-th">Chi tiết</a>
                    <a href="DH_xoa.php?id=<?= $row['MaDH'] ?>" class="btn btn-th" onclick="return confirm('Bạn có chắc chắn muốn xóa đơn hàng này?');">Xóa</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php } else { ?>
        <p>Không có đơn hàng nào.</p>
    <?php } ?>

    <?php
        $conn->close();
        $content = ob_get_clean();
        include 'Layout_AD.php';
    ?>
</div>

