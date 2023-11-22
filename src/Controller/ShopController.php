<?php

namespace Mathys\Controller;

class ShopController {

    protected $db;
    protected $connexion;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function prepare($sql) {
        return $this->connexion->prepare($sql);
    }

    public function getProducts()
    {
        $queryResult = $this->db->table('produits')
          ->get(['cols' => ['*']])
          ->do();

        $products = [];
        if ($queryResult) {
            $products = $queryResult->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        return $products;
    }
    public function searchProducts($searchTerm)
    {
        try {
            $queryResult = $this->db->table('produits')
              ->get(['cols' => ['*'], 'filters' => ['name_produit' => ['LIKE', '%' . $searchTerm . '%']]])
              ->do();
    
            $products = [];
            if ($queryResult) {
                $products = $queryResult->fetchAll(\PDO::FETCH_ASSOC);
            }
    
            return $products;
        } catch (\PDOException $e) {
            error_log('Erreur lors de la création de la commande: ' . $e->getMessage());
            return ['error' => 'Une erreur est survenue lors de la création de la commande. Veuillez réessayer.'];
        }
    }

    public function getProductById($productId) {
        $query = $this->db->prepare("SELECT * FROM produits WHERE id = ?");
        $query->execute([$productId]);
        return $query->fetch(\PDO::FETCH_ASSOC);
    }

    public function createOrder($userId) {
        $orderCode = uniqid();
        $query = $this->db->prepare("INSERT INTO commandes (id_utilisateur, code_commande) VALUES (?, ?)");
        $query->execute([$userId, $orderCode]);
        return $this->db->lastInsertId();
    }

    public function createOrderDetails($orderId, $productId, $quantity, $price, $image) {
        $query = "INSERT INTO commandedetails (id_commande, id_produit, quantite, prix, image_produit) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$orderId, $productId, $quantity, $price, $image]);
    }

    public function getOrderCodeById($orderId) {
        $query = "SELECT code_commande FROM commandes WHERE id_commande = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$orderId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['code_commande'];
    }

    public function getOrdersByUserId($userId) {
        $query = "SELECT * FROM commandes WHERE id_utilisateur = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOrderDetailsByOrderId($orderId) {
        $query = "SELECT * FROM commandedetails WHERE id_commande = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function setFeatured($productId, $featured) {
        $query = "UPDATE produits SET featured = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$featured, $productId]);
    }

    public function getFeaturedProducts() {
        $query = "SELECT * FROM produits WHERE featured = 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getLastProducts($limit = 3) {
        $query = "SELECT * FROM produits ORDER BY created_at DESC LIMIT ?";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();
        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
    
        return $rows;
    }

}

    