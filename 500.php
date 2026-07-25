<?php
/**
 * Sugar Cafe - 500 Error Page Redirect
 */
require_once __DIR__ . '/config/config.php';
header('Location: ' . BASE_URL . '/user/views/index.php');
exit();
?>
