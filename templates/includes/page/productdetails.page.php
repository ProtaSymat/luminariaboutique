<?php
use Mathys\Controller\ShopController;


fromInc("productdetails");
$productId = filter_var($_GET['productId'], FILTER_SANITIZE_NUMBER_INT);
$shopController = new ShopController();
$product = $shopController->getProductById($productId);

if(!$product) {
    echo 'Pas de produit';
    exit;
}

?>
<section class="py-5">
  <div class="container px-4 px-lg-5 my-5">
    <div class="row gx-4 gx-lg-5 align-items-center">
      <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="<?php echo $product['image']; ?>" alt="..." /></div>
      <div class="col-md-6">
        <div class="small mb-1">Catégorie : <?php echo $product['taxonomy']; ?></div>
        <h1 class="display-5 fw-bolder"><?php echo $product['name_produit']; ?></h1>
        <div class="fs-5 mb-5">
          <span><?php echo $product['price']; ?> €</span>
        </div>
        <p class="lead"><?php echo $product['long_desc']; ?></p>
        <?php if(isset($_SESSION['user']) && $_SESSION['user']): ?>
    <form action="./?page=cart&layout=html" method="post">
        <div class="d-flex flex-row">
            <div class="me-3 d-flex flex-row">
                <a type="button" class="btn btn-outline-dark" onclick="decreaseQuantity()">-</a>
                <input class="form-control text-center" id="inputQuantity" type="number" name="quantity" value="1" style="max-width: 5rem" />
                <a type="button" class="btn btn-outline-dark" onclick="increaseQuantity()">+</a>
                <input type="hidden" name="add_to_cart" value="<?= $productId ?>">
            </div>
            <div class="d-flex flex-row">
                <button class="btn btn-outline-dark" type="submit">
                    <i class="bi-cart-fill me-1"></i>
                    Ajouter au panier
                </button>
            </div>
        </div>
    </form>
<?php endif; ?>
      </div>
    </div>
  </div>
</section>

<script>
function increaseQuantity() {
    let quantityInput = document.getElementById('inputQuantity');
    let quantity = parseInt(quantityInput.value);
    quantityInput.value = quantity + 1;
}

function decreaseQuantity() {
    let quantityInput = document.getElementById('inputQuantity');
    let quantity = parseInt(quantityInput.value);
    if (quantity > 1) {
        quantityInput.value = quantity - 1;
    }
}
</script>