<?php
// Điểm vào chính của ứng dụng, xử lý routing đơn giản

// Parse URL để xác định controller và action
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'members/index';  // Mặc định load MemberController->index()
$url = filter_var($url, FILTER_SANITIZE_URL);
$urlParts = explode('/', $url);

// Xử lý controller name từ URL
$controllerName = (isset($urlParts[0]) && $urlParts[0] != '') ? ucfirst($urlParts[0]) . 'Controller' : 'MemberController';
$action = isset($urlParts[1]) ? $urlParts[1] : 'index';

// Đặc biệt cho 'members' -> 'MemberController' (khớp tên class)
if (strtolower($urlParts[0]) == 'members' || $urlParts[0] == '') {
    $controllerName = 'MemberController';
}

// Require controller tương ứng
$controllerFile = '../app/controllers/' . $controllerName . '.php';  // Path đúng từ public/ lên app/
if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName();
    if (method_exists($controller, $action)) {
        call_user_func_array([$controller, $action], array_slice($urlParts, 2));
    } else {
        die("Action không tồn tại: $action");
    }
} else {
    die("Controller không tồn tại: $controllerFile");  // Debug path để xem file có tồn tại không
}
