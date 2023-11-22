<?php
require 'vendor/autoload.php';

use Mathys\Controller\Database;

if (isset($_SESSION['user'])) {
    header("Location: ./?page=accueil&layout=html");
    exit();
}
    
if ($_SERVER["REQUEST_METHOD"] == "POST") {

if (isset($_POST['pseudo'], $_POST['new-password'], $_POST['confirm-password'])) {
    $pseudo = $_POST['pseudo'];
    $newPassword = $_POST['new-password'];
    $confirmPassword = $_POST['confirm-password'];

    if ($newPassword != $confirmPassword) {
        echo "Les mots de passe ne correspondent pas.";
        exit;
    }

    $db = new Database('luminaria_boutique');

    $success = $db->resetPassword($pseudo, $newPassword);

    if ($success) {
        echo "Votre mot de passe a été réinitialisé avec succès.";
        echo "<a class='btn btn-primary' href='./?page=login&layout=html'>Revenir à la page de login</a>";
    } else {
        echo "Une erreur s'est produite lors de la réinitialisation de votre mot de passe. Veuillez réessayer.";
    }
} else {
    echo "Veuillez remplir tous les champs.";
}
}
?>