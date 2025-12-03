<?php
$controller = isset($_GET['c']) ? $_GET['c'] : 'minimarket';
$action     = isset($_GET['a']) ? $_GET['a'] : 'index';

$file = "controllers/" . ucfirst($controller) . "Controller.php";
if (file_exists($file)) {
    require_once $file;
    $class = ucfirst($controller) . "Controller";
    $ctrl = new $class();
    if (method_exists($ctrl, $action)) {
        $ctrl->$action();
    } else {
        echo "Aksi tidak ditemukan.";
    }
} else {
    echo "Controller tidak ditemukan.";
}
?>
