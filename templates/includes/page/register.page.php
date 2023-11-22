<?php
fromInc('login');

use Mathys\Controller\Database;
use Mathys\Controller\LoginController;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pseudo = $_POST["pseudo"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $mail = $_POST["mail"];
    $role = "user";

    $db = new Database('luminaria_boutique');
    $db->table('utilisateurs');

    $success = $db->addUser($pseudo, $password, $mail, $role);

    if ($success) {
        header("Location: ./?page=login&layout=html&success=1");
        exit();
    } else {
        header("Location: ./?page=register&layout=html&error=1");
        exit();
    }
}
?>
<section class="h-100 gradient-form" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="card-body p-md-5 mx-md-4">
                                <div class="text-center">
                                <img src="http://localhost/luminariaboutiquenws/images/luminaria-logo.png"
                                        style="width: 185px;" alt="logo">                                    <h4 class="mt-1 mb-5 pb-1">Rejoins l'équipe de Luminaria</h4>
                                </div>

                                <form action="./?page=register&layout=html" method="post">
                                    <p>Inscription</p>

                                    <div class="form-outline mb-4">
                                        <input type="text" id="pseudo" name="pseudo" class="form-control" placeholder="Pseudo" required>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="password" id="password" name="password" class="form-control" placeholder="Mot de passe" required>
                                    </div>

                                    <div class="form-outline mb-4">
                                        <input type="email" id="mail" name="mail" class="form-control" placeholder="Adresse email" required>
                                    </div>

                                    <div class="text-center pt-1 mb-5 pb-1">
                                        <button class="btn btn-primary btn-block gradient-custom-2 mb-3" type="submit">S'inscrire</button>
                                        <a class="text-muted" href="./?page=login.php">Déjà membre ? Connectez-vous</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                            <div class="text-dark px-3 py-4 p-md-5 mx-md-4">
                                <h4 class="mb-4">Deviens l'homme lumière de demain</h4>
                                <p class="small mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
