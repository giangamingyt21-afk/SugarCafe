<?php
/**
 * Sugar Cafe - Refer a Friend Redirect
 * Redirects to user dashboard with referral info
 */
require_once __DIR__ . '/config/config.php';
header('Location: ' . BASE_URL . '/user/views/user-dashboard.php?tab=referral');
exit();
?>
