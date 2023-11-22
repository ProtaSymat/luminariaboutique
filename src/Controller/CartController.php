<?php 
namespace Mathys\Controller;

class CartController 
{
    public function __construct() {
        if(!isset($_SESSION['cart'])){
            $_SESSION['cart'] = [];
        }
    }
    public function addToCart($productId, $quantity) {
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }
    }

    public function removeFromCart($productId) {
        if (isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }
    }

    public function clearCart() {
        unset($_SESSION['cart']);
    }
   
    public function changeQuantity($productId, $action) {
        if (!isset($_SESSION['cart'][$productId])) {
            return;
        }

        if ($action == 'increase') {
            $_SESSION['cart'][$productId] += 1;
        } elseif ($action == 'decrease' && $_SESSION['cart'][$productId] > 1) {
            $_SESSION['cart'][$productId] -= 1;
        }
    }
}