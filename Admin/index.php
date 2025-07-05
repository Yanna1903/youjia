<?php
    ob_start();
?>

<h2 class="text-center">TRANG CHỦ ADMIN</h2>

<?php
    $content = ob_get_clean();
    include 'Layout_AD.php';
?>