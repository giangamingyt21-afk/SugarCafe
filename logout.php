<?php
/**
 * Sugar Cafe by Georgia - Logout Redirect
 * Context-aware: redirects to the appropriate logout handler
 * based on which session the user is currently in.
 * 
 * If the request came from an admin page, redirect to admin-logout.php
 * If the request came from a user page, redirect to user/views/logout.php
 */

// Determine context before starting session
$requestUri = $_SERVER['REQUEST_URI'] ?? '';
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$referer = $_SERVER['HTTP_REFERER'] ?? '';

$isAdminContext = (
    strpos($requestUri, '/admin/') !== false ||
    strpos($scriptName, '/admin/') !== false ||
    strpos($referer, '/admin/') !== false ||
    strpos($referer, '/admin-') !== false
);

// Start the appropriate session to check
if ($isAdminContext) {
    session_name('SugarCafeAdmin');
} else {
    session_name('SugarCafeUser');
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Now include config (which won't restart session since it's already active)
require_once __DIR__ . '/config/config.php';

// Check the actual session name to determine redirect
$currentSessionName = session_name();

if ($currentSessionName === 'SugarCafeAdmin') {
    header('Location: ' . BASE_URL . '/admin-logout.php');
} else {
    header('Location: ' . BASE_URL . '/user/views/logout.php');
}
exit();
?>
