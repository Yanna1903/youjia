<?php
// ** Cấu hình cơ sở dữ liệu cho WordPress ** //
define('DB_NAME', 'if0_38850882_csdl_youjia');
define('DB_USER', 'if0_38850882');
define('DB_PASSWORD', 'aFU7BTvAMePuZx');
define('DB_HOST', 'sql311.infinityfree.com');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');

// ** Khóa xác thực (bảo mật) ** //
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');

// Tiền tố bảng trong cơ sở dữ liệu
$table_prefix  = 'wp_';

// Bật chế độ sửa lỗi (chỉ nên bật khi dev)
define('WP_DEBUG', false);

// Đường dẫn tuyệt đối đến thư mục WordPress
if ( !defined('ABSPATH') )
    define('ABSPATH', dirname(__FILE__) . '/');

// Gọi tệp wp-settings.php
require_once(ABSPATH . 'wp-settings.php');
?>
