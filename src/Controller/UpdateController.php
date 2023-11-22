<?php
namespace Mathys\Controller;

use Mathys\Controller\Database;

class UpdateController 
{
    protected $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function updateProfile($id, $pseudo, $mail, $telephone, $adresse) {
        $updateSuccessful = $this->db->updateUser($id, $pseudo, $mail, $telephone, $adresse);
    
        if (!$updateSuccessful) {
            die("Échec de la mise à jour");
        }
    
        $_SESSION['user']['pseudo'] = $pseudo;
        $_SESSION['user']['mail'] = $mail;
        $_SESSION['user']['telephone'] = $telephone;
        $_SESSION['user']['adresse'] = $adresse;
    }
}