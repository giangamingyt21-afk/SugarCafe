<?php
/**
 * Sugar Cafe - Redirect to user/views/settings.php
 */
require_once __DIR__ . '/config/config.php';
header('Location: ' . BASE_URL . '/user/views/settings.php');
exit();
?>
