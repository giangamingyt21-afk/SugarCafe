<?php
/**
 * Sugar Cafe - Admin Login Page
 * Uses admin-specific session context so logging in as admin
 * does NOT affect the user session in other tabs.
 * 
 * This ensures that if you're logged in as a user in one tab,
 * and you open admin login in another tab, the two sessions
 * remain completely independent.
 */

// Set admin session context BEFORE including config (which starts session)
$admin_context_override = true;

require_once __DIR__ . '/config/config.php';

$pageTitle = "Admin Login - " . SITE_NAME;

// Ensure we're on the admin session
if (session_name() !== 'SugarCafeAdmin') {
    if (session_status() !== PHP_SESSION_NONE) {
        session_write_close();
    }
    session_name('SugarCafeAdmin');
    session_start();
}

// Redirect if already logged in as admin
if (isset($_SESSION['admin_id'])) {
    header('Location: ' . BASE_URL . '/admin/views/dashboard.php');
    exit;
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);
    
    if (empty($email) || empty($password)) {
        $error = 'Please enter both email and password.';
    } else {
        try {
            $db = Database::getInstance();
            $user = $db->fetch(
                "SELECT u.*, r.name as role_name, r.slug as role 
                 FROM users u 
                 LEFT JOIN roles r ON u.role_id = r.id 
                 WHERE u.email = ? AND u.status = 'active' AND u.deleted_at IS NULL",
                [$email]
            );
            
            if ($user && verifyPassword($password, $user['password'])) {
                // Only allow admin/super_admin/staff to login here
                if (!in_array($user['role'], ['admin', 'super_admin', 'staff'])) {
                    $error = 'This login page is for administrators only. Please use the customer login page.';
                } elseif (!$user['is_verified']) {
                    $error = 'Please verify your email address before logging in.';
                } else {
                    // Update last login
                    $db->update('users', ['last_login' => date('Y-m-d H:i:s')], 'id = ?', [$user['id']]);
                    
                    // Set ADMIN session variables (in the SugarCafeAdmin session)
                    $_SESSION['admin_id'] = $user['id'];
                    $_SESSION['admin_name'] = ($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '');
                    $_SESSION['admin_role'] = $user['role'];
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_email'] = $user['email'] ?? '';
                    
                    // Also set standard session variables for admin page compatibility
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['user'] = $user;
                    $_SESSION['user_name'] = ($user['first_name'] ?? '') . ' ' . ($user['last_name'] ?? '');
                    $_SESSION['user_email'] = $user['email'] ?? '';
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['user_role'] = $user['role'];
                    $_SESSION['role_name'] = $user['role_name'];
                    $_SESSION['logged_in'] = true;
                    
                    // Set remember me cookie if checked
                    if ($remember) {
                        $token = bin2hex(random_bytes(32));
                        $db->update('users', ['remember_token' => $token], 'id = ?', [$user['id']]);
                        setcookie('remember_admin_token', $token, time() + (86400 * 30), '/');
                    }
                    
                    redirect(BASE_URL . '/admin/views/dashboard.php', 'Welcome back, ' . $user['first_name'] . '!', 'success');
                }
            } else {
                $error = 'Invalid email or password';
            }
        } catch (Exception $e) {
            $error = 'An error occurred. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Sugar Cafe CSS -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/admin.css">
    
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            background: #F5F0E8;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .admin-login-container {
            display: flex;
            max-width: 900px;
            width: 100%;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(93,64,55,0.2);
            margin: 20px;
        }
        .admin-login-sidebar {
            background: linear-gradient(135deg, #5D4037 0%, #3E2723 100%);
            color: white;
            padding: 60px 40px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }
        .admin-login-sidebar::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            pointer-events: none;
        }
        .admin-login-sidebar .sidebar-icon {
            font-size: 3rem;
            margin-bottom: 16px;
            color: #E8967A;
        }
        .admin-login-sidebar h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            margin-bottom: 12px;
        }
        .admin-login-sidebar p {
            color: rgba(255,255,255,0.7);
            font-size: 0.95rem;
            line-height: 1.6;
        }
        .admin-login-sidebar .badge-admin {
            display: inline-block;
            background: rgba(232,150,122,0.2);
            color: #E8967A;
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            margin-top: 16px;
            border: 1px solid rgba(232,150,122,0.3);
        }
        .admin-login-form {
            background: white;
            padding: 50px 40px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .admin-login-form h3 {
            font-family: 'Playfair Display', serif;
            color: #5D4037;
            margin-bottom: 6px;
        }
        .admin-login-form .subtitle {
            color: #8D6E63;
            font-size: 0.9rem;
            margin-bottom: 24px;
        }
        .form-group {
            margin-bottom: 16px;
        }
        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #5D4037;
            margin-bottom: 6px;
        }
        .input-wrapper {
            position: relative;
        }
        .input-wrapper i.input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #BCAAA4;
            font-size: 0.9rem;
        }
        .input-wrapper input {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 1px solid #D7CCC8;
            border-radius: 10px;
            font-size: 0.95rem;
            font-family: 'Poppins', sans-serif;
            transition: all 0.2s;
            background: #FFF8F0;
            color: #3E2723;
            box-sizing: border-box;
        }
        .input-wrapper input:focus {
            border-color: #E8967A;
            outline: none;
            box-shadow: 0 0 0 3px rgba(232,150,122,0.15);
        }
        .toggle-password {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #8D6E63;
            cursor: pointer;
            font-size: 0.9rem;
        }
        .btn-admin-login {
            display: block;
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #5D4037, #3E2723);
            color: white;
            border: none;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Poppins', sans-serif;
        }
        .btn-admin-login:hover {
            box-shadow: 0 4px 15px rgba(93,64,55,0.4);
            transform: translateY(-2px);
        }
        .admin-alert {
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 0.9rem;
            margin-bottom: 16px;
        }
        .alert-danger { background: #FFF0F0; color: #C62828; border: 1px solid #FFCDD2; }
        .alert-success { background: #F0FFF4; color: #2E7D32; border: 1px solid #C8E6C9; }
        .back-to-store {
            text-align: center;
            margin-top: 16px;
        }
        .back-to-store a {
            color: #8D6E63;
            text-decoration: none;
            font-size: 0.85rem;
        }
        .back-to-store a:hover {
            color: #5D4037;
        }
        @media (max-width: 768px) {
            .admin-login-container {
                flex-direction: column;
            }
            .admin-login-sidebar {
                padding: 30px 20px;
            }
            .admin-login-form {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-login-container">
        <div class="admin-login-sidebar">
            <i class="fas fa-shield-alt sidebar-icon"></i>
            <h2>Admin Portal</h2>
            <p>Secure access to the Sugar Cafe administration panel. Manage orders, products, and more.</p>
            <span class="badge-admin"><i class="fas fa-lock"></i> Authorized Personnel Only</span>
        </div>
        <div class="admin-login-form">
            <h3>Welcome Back</h3>
            <p class="subtitle">Sign in to your admin account</p>
            
            <?php if ($error): ?>
            <div class="admin-alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
            <?php endif; ?>
            
            <?php if ($success): ?>
            <div class="admin-alert alert-success">
                <i class="fas fa-check-circle"></i> <?php echo $success; ?>
            </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>Email Address</label>
                    <div class="input-wrapper">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" name="email" placeholder="Enter admin email" required
                               value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="password" placeholder="Enter password" required>
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
                    <label style="font-size:0.85rem;color:#8D6E63;cursor:pointer;">
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                </div>
                <button type="submit" class="btn-admin-login">
                    <i class="fas fa-sign-in-alt"></i> Sign In as Admin
                </button>
            </form>
            
            <div class="back-to-store">
                <a href="<?php echo BASE_URL; ?>/user/views/index.php"><i class="fas fa-arrow-left"></i> Back to Store</a>
            </div>
        </div>
    </div>
    
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
