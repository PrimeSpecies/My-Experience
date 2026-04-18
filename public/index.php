<?php
// 1. Session Setup
$sessionPath = __DIR__ . '/../sessions';
if (!is_dir($sessionPath)) {
    mkdir($sessionPath, 0777, true);
}
session_save_path($sessionPath);
session_start();

// 2. Error Reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 3. Autoload
require_once '../autoload.php';

$action = $_GET['action'] ?? 'home';
$controller = new AuthController();

// --- ROUTER LOGIC ---

if ($action === 'home') {
    include __DIR__ . '/../views/home/landing.php';
    exit();

} elseif ($action === 'register') {
    $controller->register();

} elseif ($action === 'login') {
    $controller->login();

} elseif ($action === 'forgot-password') {
    // Phase 1: Show "Send Code" confirmation
    $controller->forgotPassword(); 
    exit();

} elseif ($action === 'verify-reset-otp') {
    // Phase 2: The OTP "Gate"
    $controller->verifyResetOTP(); 
    exit();

} elseif ($action === 'reset-password') {
    // Phase 3: Update password (if OTP was verified)
    $controller->resetPassword(); 
    exit();

} elseif ($action === 'verify-email') {
    $controller->verifyEmail();
    exit();

} elseif ($action === 'verify-otp') {
    include __DIR__ . '/../views/auth/verifyOTP.php';
    exit();

} elseif ($action === 'toggle-user') {
    // Check if the person clicking this is actually an admin
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
        $controller = new AuthController();
        $controller->toggleUserStatus(); 
    } else {
        header("Location: index.php?action=login");
    }
    exit();

} elseif ($action === 'save-to-catalog') {
    $controller = new \App\Controllers\DocumentController();
    $controller->bookmark();
    exit();
}elseif ($action === 'upload-doc'){
   if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Unauthorized']);
            exit;
        }

        // 2. Call the Controller
        $controller = new \App\Controllers\DocumentController();
        $controller->upload();
        exit();

}elseif ($action === 'check-otp') {
    $controller->checkOTP(); 
    exit();

}
elseif ($action === 'view-doc') {
    if (!isset($_SESSION['user_id'])) { 
        header("Location: index.php?action=login");
        exit(); 
    }

    $docId = $_GET['id'] ?? null;
    $docModel = new Document();
    $file = $docModel->findById($docId);

    // If the file exists in DB and the path is valid on your XAMPP server
    if ($file && file_exists($file['file_path'])) {
        header("Content-Type: application/pdf");
        // 'inline' opens it in the browser tab instead of forcing a download
        header("Content-Disposition: inline; filename=\"" . addslashes($file['title']) . ".pdf\"");
        readfile($file['file_path']);
    } else {
        http_response_code(404);
        echo "<h1>404 - File Not Found</h1>";
        echo "<p>The research paper could not be located on the server.</p>";
    }
    exit();
}
 elseif ($action === 'dashboard') {
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php?action=login");
        exit();
    }
    
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
        $userService = new UserService();
        $users = $userService->getAllUsers();
        include __DIR__ . '/../views/admin/dashboard.php';
    } else {
        // --- SPRINT 2 DATA INJECTION ---
        // 1. Initialize Models
        $documentModel = new Document();
        $catalogModel = new Catalog();

        // 2. Fetch data
        $userId = $_SESSION['user_id'];
        
        // Gets 10 latest public files from the 'documents' table
        $publicFiles = $documentModel->getLatestPublic(); 
        
        // Gets all files linked to this user in the 'catalog' table
        $userFiles = $catalogModel->findAllFilesByUserId($userId);

        // 3. Include the UI (which loops through $publicFiles and $userFiles)
        include __DIR__ . '/../views/user/dashboard.php';
    }
    exit();
} elseif ($action === 'logout') {
    $controller->logout();
    exit();

} else {
    echo "<h1>404 - Page Not Found</h1>";
    echo "<a href='index.php?action=home'>Return Home</a>";
}