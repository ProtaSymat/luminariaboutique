<?php
namespace Mathys\Controller;

class LoginController
{
    protected $database;
    
    public function __construct() {
        $this->database = new Database('luminaria_boutique');
    }

    public function checkUser($pseudo, $password) {
        $this->database->table('utilisateurs');
        $user = $this->database->getUserByPseudo($pseudo);
        
        if(!$user || !password_verify($password, $user['password'])) {
            throw new \Exception("Identifiants incorrects.");
        }
    
        return $user;
    }

    public function verifyUser($pseudo, $mail) {
        $this->database->table('utilisateurs');
        $user = $this->database->getUserByPseudoAndMail($pseudo, $mail);
    
        return $user !== false && $user !== null;
    }
}