<?php
require_once './configs/bootstrap.php';
require './vendor/autoload.php';
require_once './src/toolkit.php';
ob_start();

if (isset($_GET["page"])) {
    fromPage($_GET['page']);
}

if(isset($_GET['page']) && $_GET['page'] === 'admin') {
    $user = unserialize(serialize($_SESSION['user']));
    if(session_status() == PHP_SESSION_ACTIVE && isset($_SESSION['user']) && $user->getRole() === 'admin'){
        include './templates/includes/page/admin.page.php';
}else {
        include './templates/includes/page/404.page.php';
        exit();
    }
}

$pageContent = [
    "html" => ob_get_clean(),
];

if (isset($_GET["layout"])) {
    include "./templates/layouts/" . $_GET["layout"] . ".layout.php";
} else {
    include './templates/includes/page/404.page.php';
}


?>
