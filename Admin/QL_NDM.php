<?php
    ob_start();
    include '../includes/youjia_connect.php';

    $sql = "SELECT * FROM nhomdanhmuc";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Lỗi truy vấn: " . mysqli_error($conn));
    }
?>


<div class="thongtin" >
    <h2 class="text-center mb-4"><b>DANH SÁCH NHÓM DANH MỤC</b></h2>
    <hr>
    <h3><a href="NDM_them.php" style="font-style: italic; text-decoration: underline;color: #fb3d78; ">Thêm mới nhóm danh mục</a></h3>
    <?php
        if (mysqli_num_rows($result) > 0) {
    ?>
    <table class="table table-striped table-bordered">
        <thead>
            <tr >
                <th class="text-center" style="width:50px;height: 30px;">Mã nhóm danh mục</th>
                <th class="text-center" style="width:50px;height: 30px;">Tên nhóm danh mục</th>
                <th class="text-center" style="width:50px;height: 30px;">Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr style="background-color:white;">
                <td class="text-center"><?= $row['MaNDM'] ?></td>
                <td><?= htmlspecialchars($row['TenNDM']) ?></td>
                <td class="text-center">
                    <a href="NDM_sua.php?id=<?= $row['MaNDM'] ?>" class="btn-th"><i class="fas fa-edit"></i></a>                    
                    <a href="NDM_xoa.php?id=<?= $row['MaNDM'] ?>" class="btn btn-th"><i class="fas fa-trash-alt"></i></a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <?php
        } else { 
            echo '<p class="text-center">Không có chủ đề nào.</p>';
        }
        $conn->close();
        $content = ob_get_clean();
        include 'Layout_AD.php';
    ?>
    </div>
</div>