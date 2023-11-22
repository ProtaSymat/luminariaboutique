<?php

namespace Mathys\Controller;

use Mathys\Controller\Database;

class ThankyouController {

    protected $db;
    
    public function __construct()
    {
        $this->db = new Database();
    }
    
    public function getCommandeById($id_commande) {
        $stmt = $this->db->prepare('SELECT * FROM commandes WHERE id_commande = ?');
        $stmt->execute([$id_commande]);
        return $stmt->fetch();
    }
    
    public function getCommandeDetailsById($id_commande) {
        $stmt = $this->db->prepare('SELECT * FROM commandedetails WHERE id_commande = ?');
        $stmt->execute([$id_commande]);
        return $stmt->fetchAll();
    }

    public function getCommandeByCode($code_commande) {
        $stmt = $this->db->prepare('SELECT * FROM commandes WHERE code_commande = ?');
        $stmt->execute([$code_commande]);
        return $stmt->fetch();
    }

    public function getCommandeDetailsByCode($code_commande) {
        $commande = $this->getCommandeByCode($code_commande);
        $id_commande = $commande['id_commande'] ?? null;
        return $this->getCommandeDetailsById($id_commande);
    }
}