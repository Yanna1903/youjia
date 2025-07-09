<?php
    ob_start();
    include '../includes/youjia_connect.php';
    // Xử lý phân trang
    $size = 10;
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($page - 1) * $size;
    $sql = "SELECT MaKH, TenKH, GioiTinh, Username, MatKhau, Email, SDT, DiaChi, NgaySinh, TrangThai 
            FROM khachhang 
            LIMIT $offset, $size";
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("Lỗi truy vấn: " . mysqli_error($conn));
    }
?>
<div class="thongtin"  >
    <h2 class="text-center mb-4"><b>DANH SÁCH KHÁCH HÀNG</b></h2>
    <hr>
    <h3><a href="KH_them.php" style="font-style: italic; text-decoration: underline;color: rgb(255, 119, 23); ">Thêm khách hàng mới</a></h3>
    <?php if (mysqli_num_rows($result) > 0) { ?>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th class="text-center">Mã KH</th>
                <th class="text-center">Họ tên </th>
                <th class="text-center">Username</th>
                <th class="text-center">Mật khẩu</th>
                <th class="text-center">Giới tính</th>
                <th class="text-center">Email</th>
                <th class="text-center">Số điện thoại</th>
                <th class="text-center">Địa chỉ</th>
                <th class="text-center">Ngày sinh</th>
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr style="background-color:white;">
                <td class="text-center"><?= htmlspecialchars($row['MaKH']) ?></td>
                <td><?= htmlspecialchars($row['TenKH']) ?></td>
                <td><?= htmlspecialchars($row['Username']) ?></td>
                <td class="text-center"><?= str_repeat('*', strlen($row['MatKhau'])) ?></td>
                <td class="text-center"><?= $row['GioiTinh'] == 0 ? 'Nam' : 'Nữ' ?></td>
                <td><?= htmlspecialchars($row['Email']) ?></td>
                <td class="text-center"><?= htmlspecialchars($row['SDT']) ?></td>
                <td><?= htmlspecialchars($row['DiaChi']) ?></td>
                <td class="text-center"><?= date('d/m/Y', strtotime($row['NgaySinh'])) ?></td>
                <td><?= $row['TrangThai'] == 0 ? 'Bị khóa/ không còn' : 'Tồn tại' ?></td>
                <td class="text-center">
                    <a href="KH_sua.php?id=<?= $row['MaKH'] ?>" class="btn-th" title="Sửa"><i class="fas fa-edit"></i></a>
                    <a href="KH_xoa.php?id=<?= $row['MaKH'] ?>" class="btn-th" onclick="return confirm('Bạn có chắc muốn xóa khách hàng này?');" title="Xóa"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php } ?>
    <?php
        // Phân trang
        $sql_total = "SELECT COUNT(*) AS total FROM khachhang";
        $result_total = mysqli_query($conn, $sql_total);
        $row_total = mysqli_fetch_assoc($result_total);
        $total_products = $row_total['total'];
        $total_pages = ceil($total_products / $size);

        if ($total_pages > 1) {
            echo "<nav class='text-center'>";
            echo "<ul class='pagination'>";

            if ($page > 1) {
                echo "<li class='page-item'><a class='page-link' href='?page=" . ($page - 1) . "'>&laquo;</a></li>";
            }

            for ($i = 1; $i <= $total_pages; $i++) {
                if ($i == $page) {
                    echo "<li class='page-item active'><span class='page-link'>$i</span></li>";
                } else {
                    echo "<li class='page-item'><a class='page-link' href='?page=$i'>$i</a></li>";
                }
            }
            if ($page < $total_pages) {
                echo "<li class='page-item'><a class='page-link' href='?page=" . ($page + 1) . "'>&raquo;</a></li>";
            }
            echo "</ul>";
            echo "</nav>";
        }
        mysqli_close($conn);
    ?>
</div>
<?php
    $content = ob_get_clean();
    include 'Layout_AD.php';
?>