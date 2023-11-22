<?php
use Mathys\Controller\Database;
use Mathys\Controller\LoginController;
use Mathys\Controller\CartController;
use Mathys\Controller\ShopController;


$ShopController = new ShopController();
$cartController = new CartController();
$totalPrice = 0;

if (!empty($_SESSION["cart"])) {
    foreach ($_SESSION["cart"] as $productId => $quantity) {
        $product = $ShopController->getProductById($productId);
        $totalPrice += $product["price"] * $quantity;
    }
}

if (isset($_POST['submit_order'])) {
    $userId = $_SESSION["user"]["id"];
    $orderId = $ShopController->createOrder($userId);
    $_SESSION["code_commande"] = $ShopController->getOrderCodeById($orderId);
    foreach ($_SESSION["cart"] as $productId => $quantity) {
        $product = $ShopController->getProductById($productId);
$ShopController->createOrderDetails($orderId, $productId, $quantity, $product["price"], $product["image"]);
    }
    $cartController->clearCart();
    header("Location: ./?page=thankyou&layout=html&order_id=$orderId");
    exit();
}



if (!empty($_SESSION["cart"])) {
    foreach ($_SESSION["cart"] as $productId => $quantity) {
        $product = $ShopController->getProductById($productId);
        $totalPrice += $product["price"] * $quantity;
    }
}

if (isset($_POST['add_to_cart'])) {
    $productId = $_POST['add_to_cart'];
    $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;
    $cartController->addToCart($productId, $quantity);
    header("Location: ./?page=cart&layout=html");
    exit();
}

if (isset($_POST['remove_from_cart'])) {
    $productId = $_POST['remove_from_cart'];
    $cartController->removeFromCart($productId);
}

if (isset($_POST['clear_cart'])) {
    $cartController->clearCart();
}

if (isset($_POST['change_quantity']) && isset($_POST['productId'])) {
    $productId = $_POST['productId'];
    $action = $_POST['change_quantity'];
    $cartController->changeQuantity($productId, $action);

}

?>
<body>
   <section class="container my-md-5">
      <div class="row">
         <div class="col-12">
            <div class="card card-registration card-registration-2" style="border-radius: 15px;">
               <div class="card-body p-0">
                  <div class="row g-0">
                     <div class="col-lg-8">
                        <div class="p-5">
                        <div class="pt-5">
                              <h6 class="mb-2"><a href="./?page=shop&layout=html" class="text-body"><i class="fas fa-long-arrow-alt-left me-2"></i>Retourner à la boutique</a></h6>
                           </div>
                           <div class="my-5">
                           <?php
if (!empty($_SESSION["cart"])) {
    echo "<h6 class='my-3 text-muted'>Nombre d'items: ".count($_SESSION["cart"])."</h6>";
    foreach ($_SESSION["cart"] as $productId => $quantity) {
        $product = $ShopController->getProductById($productId);
        $totalPrice = $product["price"] * $quantity;
        ?>
        <div class='row mb-4 d-flex justify-content-between align-items-center'>
            <div class='col-md-2 col-lg-2 col-xl-2'>
                <img src='<?= $product["image"] ?>' class='img-fluid rounded-3' alt='Product Image'>
            </div>
            <div class='col-md-3 col-lg-3 col-xl-3'>
                <h6 class='text-black mb-0'><?= $product["name_produit"] ?></h6>
            </div>
            <div class='col-md-3 col-lg-3 col-xl-3 d-flex'>
                <form action='./?page=cart&layout=html' method='post'>
                    <input type='hidden' name='change_quantity' value='decrease'>
                    <input type='hidden' name='productId' value='<?= $productId ?>'>
                    <button type='submit' class='btn btn-link px-2'>
                        <i class='fas fa-minus'></i>
                    </button>
                </form>
                <input id='form1' min='0' name='quantity' value='<?= $quantity ?>' type='number' class='form-control form-control-sm'>
                <form action='./?page=cart&layout=html' method='post'>
                    <input type='hidden' name='change_quantity' value='increase'>
                    <input type='hidden' name='productId' value='<?= $productId ?>'>
                    <button type='submit' class='btn btn-link px-2'>
                        <i class='fas fa-plus'></i>
                    </button>
                </form>
            </div>
            <div class='col-md-3 col-lg-2 col-xl-2 offset-lg-1'>
                <h6 class='mb-0'><?= $product["price"] ?> €</h6>
            </div>
            <div class='col-md-1 col-lg-1 col-xl-1 text-end'>
                <form action='./?page=cart&layout=html' method='post'>
                    <input type='hidden' name='remove_from_cart' value='<?= $productId ?>'>
                    <button type='submit' class='btn text-muted'>
                        <i class='fas fa-times'></i>
                    </button>
                </form>
            </div>
        </div>
        <hr class='my-4'>
        <?php
    }

} else {
    echo "<h6 class='mb-0'>Votre panier est vide.</h6>";
}
?>
                        </div>
                     </div>
                     </div>
                     <div class="col-lg-4 bg-grey">
                        <div class="p-5">
                           <h3 class="fw-bold mb-5 mt-2 pt-1">Résumé</h3>
                           <hr class="my-4">
                           <form action="./?page=cart&layout=html" method="post">
                              <div class="d-flex justify-content-between mb-5">
                                 <h5 class="text-uppercase">Prix total</h5>
                                 <h5><?php echo $totalPrice; ?> €</h5>
                              </div>
                              <input type="hidden" name="clear_cart" value="true">
                              <button type="submit" class="btn btn-dark btn-block btn-lg" data-mdb-ripple-color="dark">Vider le panier</button>
                              
<form action="./?page=cart&layout=html" method="post">
   <input type="hidden" name="submit_order" value="true">
   <button type="submit" class="btn btn-primary btn-block btn-lg" data-mdb-ripple-color="dark">Commander</button>
</form>
                           </form>

                        </div>
                        <hr class="my-4">
                        <div class="p-5">
                           <h5 class="mb-3">Informations Utilisateur :</h5>
                           <p><strong>Pseudo :</strong> <?php if (
                               is_array($_SESSION["user"]) &&
                               isset($_SESSION["user"]["pseudo"])
                           ) {
                               echo $_SESSION["user"]["pseudo"];
                           } else {
                               echo "Information non disponible";
                           } ?></p>
                           <p><strong>Email :</strong> <?php if (
                               is_array($_SESSION["user"]) &&
                               isset($_SESSION["user"]["mail"])
                           ) {
                               echo $_SESSION["user"]["mail"];
                           } else {
                               echo "Information non disponible";
                           } ?></p>
                           <p><strong>Téléphone :</strong> <?php if (
                               is_array($_SESSION["user"]) &&
                               isset($_SESSION["user"]["telephone"])
                           ) {
                               echo $_SESSION["user"]["telephone"];
                           } else {
                               echo "Information non disponible";
                           } ?></p>
                           <p><strong>Adresse :</strong> <?php if (
                               is_array($_SESSION["user"]) &&
                               isset($_SESSION["user"]["adresse"])
                           ) {
                               echo $_SESSION["user"]["adresse"];
                           } else {
                               echo "Information non disponible";
                           } ?></p>
                              <a class="btn btn-primary" href="./?page=profil&layout=html">Changer ses infos</a>

                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <section class="container my-5">
      <h2 class="fw-bold mt-3 text-black">Conditions de Vente et Confidentialité</h2>
      <p class="text-justify">
         Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi consequat, eros vitae condimentum laoreet, nunc magna posuere ex, in facilisis turpis massa eu elit. Nullam vitae placerat massa. Vestibulum ultrices diam sed purus porttitor, vitae ullamcorper tellus lacinia.
      </p>
      <p class="text-justify">
         Morbi pellentesque augue at porttitor iaculis. Cras scelerisque tincidunt lorem, ac hendrerit turpis auctor quis. Morbi semper consectetur facilisis. Etiam blandit consequat auctor. Donec sit amet feugiat mauris, quis vehicula nunc.
      </p>
      <p class="text-justify">
         Vestibulum et ligula lectus. In libero sapien, lacinia eget scelerisque in, elementum et odio. Quisque accumsan, lorem ac fringilla consectetur, nisl erat vehicula ligula, id tincidunt nunc nisl non lectus. Sed ac interdum purus, at pulvinar sem. Morbi vehicula bibendum quam, at tincidunt purus porttitor ac. 
      </p>
   </section>