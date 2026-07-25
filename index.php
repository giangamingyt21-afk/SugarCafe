<?php
/**
 * Sugar Cafe by Georgia - Root Router
 * Redirects to the user-facing homepage
 */
require_once __DIR__ . '/config/config.php';
header('Location: ' . BASE_URL . '/user/views/index.php');
exit();
?>
