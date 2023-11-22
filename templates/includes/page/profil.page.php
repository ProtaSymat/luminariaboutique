<?php
fromInc("update");

use Mathys\Controller\UpdateController;
use Mathys\Controller\ShopController;
$ShopController = new ShopController();


if (!isset($_SESSION['user'])) {
    header("Location: ./?page=accueil&layout=html");
    exit;
}
?>
<div class="container py-5">
    <div class="main-body">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <form action="./?page=profil&layout=html" method="post">
                            <div class="d-flex flex-column align-items-center text-center">
								<img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="Admin" class="rounded-circle p-1 bg-primary" width="110">
								<div class="mt-3">
									<h4>
										<?php
											if(is_array($_SESSION['user']) && isset($_SESSION['user']['pseudo'])) {
												echo $_SESSION['user']['pseudo'];
											} else {
												echo "Information non disponible";
											}
										?>
									</h4>
									<p class="text-secondary mb-1">Utilisateur</p>
									<p class="text-muted font-size-sm">Rôle : <?php
											if(is_array($_SESSION['user']) && isset($_SESSION['user']['role'])) {
												echo $_SESSION['user']['role'];
											} else {
												echo "Information non disponible";
											}
										?></p>
								</div>
							</div>
							<hr class="my-4">
<?php
if(is_array($_SESSION['user']) && isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'admin') {
   echo '<div class="mt-2">';
   echo '<a href="./?page=shop&layout=html" class="btn btn-primary">';
   echo 'Mettre en avant';
   echo '</a>';
   echo '</div>';
}
?>
						</div>
					</div>
				</div>
				<div class="col-lg-8">
					<div class="card mb-3">
						<div class="card-body">
						<h5 class="card-title py-3 ps-2">Informations utilisateurs</h5>
							<div class="row mb-3">
								<div class="col-sm-3">
									<h6 class="mb-0">Pseudo</h6>
								</div>
								<div class="col-sm-9 text-secondary">
									<input name="pseudo" type="text" class="form-control" value="<?php
											if(is_array($_SESSION['user']) && isset($_SESSION['user']['pseudo'])) {
												echo $_SESSION['user']['pseudo'];
											} else {
												echo "Information non disponible";
											}
										?>">
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-sm-3">
									<h6 class="mb-0">Email</h6>
								</div>
								<div class="col-sm-9 text-secondary">
									<input name="mail" type="text" class="form-control" value="<?php
											if(is_array($_SESSION['user']) && isset($_SESSION['user']['mail'])) {
												echo $_SESSION['user']['mail'];
											} else {
												echo "Information non disponible";
											}
										?>">
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-sm-3">
									<h6 class="mb-0">Téléphone</h6>
								</div>
								<div class="col-sm-9 text-secondary">
									<input name="telephone" type="text" class="form-control" value="<?php
											if(is_array($_SESSION['user']) && isset($_SESSION['user']['telephone'])) {
												echo $_SESSION['user']['telephone'];
											} else {
												echo "Information non disponible";
											}
										?>">
								</div>
							</div>
							<div class="row mb-3">
								<div class="col-sm-3">
									<h6 class="mb-0">Adresse</h6>
								</div>
								<div class="col-sm-9 text-secondary">
									<input name="adresse" type="text" class="form-control" value="<?php
											if(is_array($_SESSION['user']) && isset($_SESSION['user']['adresse'])) {
												echo $_SESSION['user']['adresse'];
											} else {
												echo "Information non disponible";
											}
										?>">
								</div>
							</div>
							<div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9 text-secondary">
                                    <input type="submit" class="btn btn-primary px-4" value="Enregistrer les modifications">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
				<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title py-3 ps-2">Historique des commandes</h5>
        <div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">Historique des commandes</h5>
        <?php
        $orders = $ShopController->getOrdersByUserId($_SESSION['user']['id']);
        if (!empty($orders)) {
            foreach ($orders as $order) {
                echo "<p>Commande ID: " . $order['id_commande'] . " - Date: " . $order['date_commande']. " - Code: " . $order['code_commande'] . "</p>";
                $orderDetails = $ShopController->getOrderDetailsByOrderId($order['id_commande']);
                if (!empty($orderDetails)) {
                    echo "<ul>";
                    foreach ($orderDetails as $detail) {
						echo "<li>Image du Produit: <img src='" . $detail['image_produit'] . "' alt='Image du Produit' width='100' height='100'></li>";
                        echo "<li>Produit ID: " . $detail['id_produit'] . " - Quantité: " . $detail['quantite'] . " - Prix: " . $detail['prix'] . "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>Aucun détail trouvé pour cette commande.</p>";
                }
            }
        } else {
            echo "<p>Aucune commande trouvé.</p>";
        }
        ?>
    </div>
</div>
    </div>
</div>
            </div>
        </div>
    </div>
</div>