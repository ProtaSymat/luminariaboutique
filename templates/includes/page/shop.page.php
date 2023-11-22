<?php

use Mathys\Controller\ShopController;

$shopController = new ShopController();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['searchTerm']) && $_POST["searchTerm"] !== '') {
    $products = $shopController->searchProducts($_POST['searchTerm']);
} else {
    if (isset($_GET['featured']) && $_GET['featured'] === 'true') {
        $products = $shopController->getFeaturedProducts();
    } elseif (isset($_GET['lastproduct']) && $_GET['lastproduct'] === 'true') {
        $products = $shopController->getLastProducts();
    } else {
        $products = $shopController->getProducts();
    }
}
?>
<body>
            <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Boutique</h1>
                    <p class="lead fw-normal text-white-50 mb-0">Découvrez notre gamme variée de produits d'éclairage chez Luminaria. Que vous recherchiez une lampe d'ambiance délicate pour une soirée romantique, une lampe de studio moderne pour votre bureau, ou des lumières LED colorées pour une fête, vous trouverez tout cela et plus encore dans notre boutique. Chaque lumière que nous vendons est conçue pour non seulement éclairer votre espace, mais aussi pour y ajouter du style et de la personnalité.</p>
                    <form method="POST">
    <div class="input-group mt-3">
        <input type="text" name="searchTerm" class="form-control" placeholder="Search..." aria-label="Search" aria-describedby="searchIcon">
        <div class="input-group-append">
            <span class="input-group-text h-100" id="searchIcon"><button type="submit" style="border:none;background-color:transparent;"><i class="fas fa-search"></i></button></span>
        </div>
    </div>
</form>
            </div>
                </div>
            </div>
        </header>
        <section class="py-5">
            <div class="container px-4 px-lg-5 mt-5">
                <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
                <?php if (!empty($products)): ?>
    <?php foreach ($products as $product) :
        $productId = $product['id'];
        $productImg = $product['image'];
        $productName = $product['name_produit'];
        $productPrice = $product['price'];
        $productShortDesc = $product['short_desc'];
    ?>
    <?php include './templates/includes/elements/cardelement.inc.php'; ?>
    <?php endforeach; ?>
<?php else: ?>
    <p class="text-center"><i class="fa fa-exclamation-triangle"></i> Aucun produit trouvé.</p>
<?php endif; ?>
</div>

                </div>
            </div>
        </section>