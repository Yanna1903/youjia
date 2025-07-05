<?php
include 'quanao/Includes/QA_connect.php';

$sql = "SELECT MaSach, TenSach, MoTa, AnhBia FROM Sach ORDER BY SoLuongBan LIMIT 6";
$result = mysqli_query($ltng_conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SÁCH BÁN NHIỀU </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        .imgsachbannhieu {
            width: 120px;
            height: 180px;
            margin-right: 15px;
            object-fit: cover;
        }
        .media-heading a {
            font-size: 18px;
            font-weight: bold;
            color:rgb(51, 112, 183);
            text-decoration: none;
        }
        .mota {
            font-size: 14px;
            color: #333;
            line-height: 1.5;
            max-height: 80px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
        }
        .media {
            display: flex;
            align-items: flex-start;
            min-height: 200px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center">SÁCH BÁN NHIỀU</h2>
        <hr>
        <div class="row">
            <?php $count = 0; ?>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <?php if ($count % 3 == 0) { ?>
                    <div class="row"> <!-- Bắt đầu một hàng mới sau mỗi 3 sách -->
                <?php } ?>
                <div class="col-lg-4 col-md-4 col-sm-6" style="padding:15px;">
                    <div class="media">
                        <div class="media-left">
                            <a href="ChiTietSach.php?id=<?php echo $row['MaSach']; ?>">
                                <img class="media-object imgsachbannhieu" src="Images/<?php echo $row['AnhBia']; ?>" alt="<?php echo htmlspecialchars($row['TenSach']); ?>">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">
                                <a href="ChiTietSach.php?id=<?php echo $row['MaSach']; ?>">
                                    <?php echo htmlspecialchars($row['TenSach']); ?>
                                </a>
                            </h4>
                            <p class="mota text-justify"> <?php echo nl2br(htmlspecialchars($row['MoTa'])); ?> </p>
                        </div>
                    </div>
                </div>
                <?php $count++; ?>
                <?php if ($count % 3 == 0) { ?>
                    </div> <!-- Kết thúc hàng sau 3 sách -->
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</body>
</html>