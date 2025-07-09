<?php
    ob_start();
    session_start();
    if (!isset($content)) {
        $content = "";
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <title>YOUJIA - ADMIN</title>
    <link rel="stylesheet" href="css/AD_css.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php
        if (!isset($_SESSION['admin'])) {
            header("Location: DangNhap_AD.php");
            exit();
        }
    ?>
    <?php
        include 'AD_header.php';
    ?>

    <div class="content">
        <?= $content ?>
    </div>
    <BR>
</body>
</html>
