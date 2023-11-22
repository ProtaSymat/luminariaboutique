<?php
use Mathys\Controller\ShopController;
$shopController = new ShopController();
$featured = 0; 
if(isset($_POST['productId'])) { 
    $featured = isset($_POST['featured']) && $_POST['featured'] == 'on' ? 1 : 0;
    $shopController->setFeatured($_POST['productId'], $featured);
}
$featured = $product['featured'];
?>

<div class="col mb-5">
    <div class="card h-100 <?php echo ($featured == 1) ? 'bg-warning' : ''; ?>">
        <img class="card-img-top" src="<?php echo $productImg; ?>" alt="..." />
        <div class="card-body p-4">
            <div class="text-center">
                <h5 class="fw-bolder"><?php echo $productName; ?></h5>
                <p><?php echo $productShortDesc; ?></p>
                <span><?php echo $productPrice; ?> €</span>
            </div>
        </div>
        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
            <div class="text-center">
                <?php
                if(isset($_SESSION['user']) && is_array($_SESSION['user']) && isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'admin') {
                    echo "<form action='./?page=shop&layout=html' method='post'>";
                    echo "<input type='hidden' name='productId' value='{$productId}'>";
                    $checked = '';
                    if($featured == 1) {
                        $checked = 'checked';
                    }
                    echo "<div class='form-check form-switch'>";
                    echo "<input class='form-check-input' type='checkbox' name='featured' id='featured{$productId}' {$checked} onchange='this.form.submit()'>";
                    echo "<label class='form-check-label' for='featured{$productId}'>Mettre en avant</label>";
                    echo "</div>";
                    echo "</form>";
                }
                ?>
                <a class="btn btn-outline-dark mt-auto" href="./?page=productdetails&productId=<?php echo $productId; ?>&layout=html">Voir Détails <i class="fa-solid fa-magnifying-glass"></i></a>
            </div>
        </div>
    </div>
</div>