<?php
ob_start();
include '../includes/youjia_connect.php';

$sql = "SELECT * FROM nhomdanhmuc ORDER BY MaNDM ";
$result = mysqli_query($conn, $sql);
if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($conn));
}
?>
<div class="thongtin">
    <h2 class="text-center mb-4"><b>DANH SÁCH NHÓM DANH MỤC</b></h2>
    <hr>
    <h3><a href="NDM_them.php" style="font-style: italic; text-decoration: underline; color: rgb(255, 119, 23)">Thêm mới nhóm danh mục</a></h3>

    <?php if (mysqli_num_rows($result) > 0): ?>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th class="text-center" style="width:40%; height:30px;">Mã nhóm danh mục</th>
                <th class="text-center" style="width:40%; height:30px;">Tên nhóm danh mục</th>
                <th class="text-center" style="width:20%; height:30px;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr style="background-color:white;">
                <td class="text-center"><?php echo $row['MaNDM']; ?></td>
                <td><?php echo htmlspecialchars($row['TenNDM']); ?></td>
                <td class="text-center">
                    <a href="NDM_sua.php?id=<?php echo $row['MaNDM']; ?>" class="btn-th"><i class="fas fa-edit"></i></a>
                    <a href="NDM_xoa.php?id=<?php echo $row['MaNDM']; ?>" class="btn-th" onclick="return confirm('❓Xác nhận xóa nhóm danh mục này?');"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p class="text-center">Không có nhóm danh mục nào.</p>
    <?php endif; ?>

    <?php
    $conn->close();
    $content = ob_get_clean();
    include 'Layout_AD.php';
    ?>
</div>