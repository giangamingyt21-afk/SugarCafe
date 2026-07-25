<?php
/**
 * Sugar Cafe - Admin Logout Handler
 * Only destroys the SugarCafeAdmin session, NOT the SugarCafeUser session.
 * 
 * This is critical for tab-independent login:
 * - If you're logged in as a user in Tab 1 (SugarCafeUser session)
 * - And logged in as admin in Tab 2 (SugarCafeAdmin session)
 * - Logging out of admin in Tab 2 will NOT affect the user login in Tab 1
 */

// Set admin context so we get the admin session
$admin_context_override = true;

require_once __DIR__ . '/config/config.php';

// Ensure we're on the admin session
if (session_name() !== 'SugarCafeAdmin') {
    if (session_status() !== PHP_SESSION_NONE) {
        session_write_close();
    }
    session_name('SugarCafeAdmin');
    session_start();
}

// Clear all admin session variables
$_SESSION = array();

// Destroy the SugarCafeAdmin session cookie only
$adminCookieName = 'SugarCafeAdmin';
if (isset($_COOKIE[$adminCookieName])) {
    setcookie($adminCookieName, '', time() - 42000, '/');
}

// Clear admin remember me cookie if exists
if (isset($_COOKIE['remember_admin_token'])) {
    setcookie('remember_admin_token', '', time() - 42000, '/');
}

// Destroy the admin session
session_destroy();

// Redirect to admin login page with message
header('Location: ' . BASE_URL . '/admin-login.php?logged_out=true');
exit();
?>
