<?php 
use Mathys\Controller\Database;
use Mathys\Controller\LoginController;

if (isset($_SESSION['user'])) {
    header("Location: ./?page=accueil&layout=html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['pseudo']) && isset($_POST['mail'])) {
        $loginController = new LoginController();

        $exists = $loginController->verifyUser($_POST['pseudo'], $_POST['mail']);
        if ($exists) {
            header("Location: ./?page=reset&layout=html");
            exit();
        } else {
            echo "<span class='text-danger'>L'utilisateur n'existe pas.</span>";
        }
    } else {
        echo "<span class='text-danger'>Veuillez remplir tous les champs.</span>";
    }
}