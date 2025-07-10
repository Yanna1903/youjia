<?php
    // Kết nối cơ sở dữ liệu
    ob_start();
    include '../includes/youjia_connect.php';

    // Cải thiện truy vấn SQL bằng cách chỉ chọn các cột cần thiết
    $sql = "SELECT dm.MaDM, dm.TenDM, ndm.TenNDM 
            FROM danhmuc dm
            LEFT JOIN nhomdanhmuc ndm ON dm.MaNDM = ndm.MaNDM";

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Lỗi truy vấn: " . mysqli_error($conn));
    }
?>

<div class="thongtin">
    <h2 class="text-center mb-4"><b>DANH SÁCH DANH MỤC</b></h2>
    <hr>
    <h3><a href="DM_them.php" style="font-style: italic; text-decoration: underline;color:rgb(255, 119, 23)">Thêm danh mục mới</a></h3>

    <?php if (mysqli_num_rows($result) > 0) { ?>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th class="text-center" style="width: 20%;height: 30px;">Mã Danh mục</th>
                <th class="text-center" style="width: 30%;height: 30px;">Tên Danh mục</th>
                <th class="text-center" style="width: 30%;height: 30px;">Nhóm Danh mục</th>
                <th class="text-center" style="width: 20%;height: 30px;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr style="background-color:white;">
                <td class="text-center"><?= htmlspecialchars($row['MaDM']) ?></td>
                <td><?= htmlspecialchars($row['TenDM']) ?></td>
                <td class="text-center">
                    <?= htmlspecialchars($row['TenNDM']) ?> <!-- Hiển thị giá trị chuỗi của Phái -->
                </td>
                <td class="text-center">
                    <a href="DM_sua.php?id=<?= htmlspecialchars($row['MaDM']) ?>" class="btn-th"><i class="fas fa-edit"></i></a>
                    <a href="DM_xoa.php?id=<?= htmlspecialchars($row['MaDM']) ?>" class="btn-th"><i class="fas fa-trash-can"></i></a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php } else {
        echo '<p class="text-center">Không có danh mục nào.</p>';
    }

    $conn->close();

    $content = ob_get_clean();
    include 'Layout_AD.php';
    ?>
</div>
