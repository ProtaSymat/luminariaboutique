<?php
use Mathys\Controller\UpdateController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $updateController = new UpdateController();

    $pseudo = $_POST['pseudo'];
    $mail = $_POST['mail'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];
        
    $updateController->updateProfile($_SESSION['user']['id'], $pseudo, $mail, $telephone, $adresse);

    header("Location: ./?page=profil&layout=html");
    exit();
}