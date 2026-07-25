<?php
/**
 * Sugar Cafe - Redirect to user/views/user-profile.php
 * This file is kept for backward compatibility
 */
require_once __DIR__ . '/config/config.php';
header('Location: ' . BASE_URL . '/user/views/user-profile.php');
exit();
?>
