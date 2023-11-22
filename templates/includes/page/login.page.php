<?php
fromInc('login');


use Mathys\Controller\Database;
use Mathys\Controller\LoginController;

?>

<section class="h-100 gradient-form" style="background-color: #eee;">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-xl-10">
                <div class="card rounded-3 text-black">
                    <div class="row g-0">
                        <div class="col-lg-6">
                            <div class="card-body p-md-5 mx-md-4">
                                <?php if (!empty($error_message)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo htmlspecialchars($error_message); ?>
                                    </div>
                                <?php endif; ?>

                                <div class="text-center">
                                    <img src="http://localhost/luminariaboutiquenws/images/luminaria-logo.png"
                                        style="width: 185px;" alt="logo">
                                    <h4 class="mt-1 mb-5 pb-1">Rejoins l'équipe de Luminaria</h4>
                                </div>

                                <form action="./?page=login&layout=html" method="post">
                                    <p>Connexion à votre compte</p>

                                    <div class="form-outline mb-4">
    <label class="form-label" for="pseudo">Pseudo</label>
    <input type="text" id="pseudo" name="pseudo" class="form-control" placeholder="Pseudo" required>
</div>

                                    <div class="form-outline mb-4">
                                    <label class="form-label" for="password">Mot de passe</label>
                                        <input type="password" id="password" name="password" class="form-control" required>
                                    </div>

                                    <div class="text-center pt-1 mb-5 pb-1">
                                        <button class="btn btn-primary btn-block  mb-3" type="submit">Connexion</button>
                                        <a class="text-muted" href="./?page=verify&layout=html">Mot de passe oublié ?</a>
                                    </div>

                                    <div class="d-flex align-items-center justify-content-center pb-4">
                                        <p class="mb-0 me-2">Pas de compte ?</p>
                                        <a type="button" class="btn btn-outline-danger" href="./?page=register&layout=html">Créer un compte</a>
                                    </div>

                                </form>

                            </div>
                        </div>
                        <div class="col-lg-6 d-flex align-items-center">
                            <div class="text-dark px-3 py-4 p-md-5 mx-md-4">
                                <h4 class="mb-4">Deviens l'homme lumière de demain</h4>
                                <p class="small mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud
                                    exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
