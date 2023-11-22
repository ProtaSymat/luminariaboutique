<?php
use Mathys\Controller\Database;
use Mathys\Controller\ShopController;
use Mathys\Controller\ThankyouController;

$ShopController = new ShopController();
$ThankyouController = new ThankyouController();
$code_commande = $_SESSION['code_commande'] ?? 'Non disponible';
?>
<body>
    <div class="my-5 d-flex justify-content-center align-items-center">
        <div class="col-md-4">
            <div class="border border-3 border-success"></div>
            <div class="card bg-white shadow p-5">
                <div class="mb-5 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="text-success" width="75" height="75"
                            fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                            <path
                                d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                        </svg>
                </div>
                <div class="text-center">
                    <h1 class="mb-5">Merci pour votre commande.</h1>
                    <h2>Votre numéro de commande est : <?php echo $code_commande; ?></h2>
                    <p>Récapitulatif de la commande :</p>
                    <?php
$commande = $ThankyouController->getCommandeByCode($code_commande);

$id_commande = $commande['id_commande'] ?? null;
if ($id_commande) {
    $commandeDetails = $ThankyouController->getCommandeDetailsById($id_commande);
    if ($commandeDetails) {
        foreach ($commandeDetails as $item) {
            $product = $ShopController->getProductById($item['id_produit']);
            echo "                <img src='{$item['image_produit']}' class='img-fluid rounded-3' alt='Product Image'>
            <p>Produit : {$product['name_produit']} - Quantité : {$item['quantite']} - Prix : {$item['prix']} €</p>";
        }
    } else {
        echo "<p>Aucun détail de commande trouvé pour la commande : ".$code_commande."</p>";
    }
} else {
    echo "<p>Aucune commande trouvée avec le numéro de commande : ".$code_commande."</p>";
}
                    ?>
                    <h5 class="mb-3">Informations Utilisateur :</h5>
                           <p><strong>Pseudo :</strong> <?php
                              if(is_array($_SESSION['user']) && isset($_SESSION['user']['pseudo'])) {
                              	echo $_SESSION['user']['pseudo'];
                              } else {
                              	echo "Information non disponible";
                              }
                              ?></p>
                           <p><strong>Email :</strong> <?php
                              if(is_array($_SESSION['user']) && isset($_SESSION['user']['mail'])) {
                              	echo $_SESSION['user']['mail'];
                              } else {
                              	echo "Information non disponible";
                              }
                              ?></p>
                           <p><strong>Téléphone :</strong> <?php
                              if(is_array($_SESSION['user']) && isset($_SESSION['user']['telephone'])) {
                              	echo $_SESSION['user']['telephone'];
                              } else {
                              	echo "Information non disponible";
                              }
                              ?></p>
                           <p><strong>Adresse :</strong> <?php
                              if(is_array($_SESSION['user']) && isset($_SESSION['user']['adresse'])) {
                              	echo $_SESSION['user']['adresse'];
                              } else {
                              	echo "Information non disponible";
                              }
                              ?></p>
                    <button class="btn btn-outline-success" onclick="window.location.href='./?page=accueil&layout=html'">Retour à l'accueil</button>
                </div>
            </div>
        </div>
    </div>