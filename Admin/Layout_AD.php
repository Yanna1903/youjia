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
    <link rel="stylesheet" href="AD_css.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.4.0/css/all.min.css">
    <style>
        /* Bổ sung đoạn này vào cuối CSS */
        i.fas, i.far, i.fab {
            font-family: 'Font Awesome 6 Free' !important;
            font-weight: 900;
        }
        .fab {
            font-family: 'Font Awesome 6 Brands' !important;
        }
        </style>
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