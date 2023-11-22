<?php

use Mathys\Controller\LoginController;

if (isset($_SESSION['user'])) {
    header("Location: ./?page=accueil&layout=html");
    exit();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

if (isset($_POST['pseudo']) && isset($_POST['password']) && !empty($_POST['pseudo']) && !empty($_POST['password'])) { 
    try {
        $loginController = new LoginController();
        $userData = $loginController->checkUser($_POST['pseudo'], $_POST['password']);
        if (isset($userData['password'])) {
            unset($userData['password']);
        }
        $_SESSION['user'] = $userData;
        header("Location: ./?page=accueil&layout=html");
        exit();
    } catch (\Exception $e) {
        $error_message = $e->getMessage();
        
    }
} else {
    $error_message = "Veuillez remplir tous les champs.";
}

if (isset($error_message)) {
    echo '<div class="alert alert-danger mx-5" role="alert">' . $error_message . '</div>';
}
}
