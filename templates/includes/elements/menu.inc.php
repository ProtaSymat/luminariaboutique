
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="./?page=accueil&layout=html">Luminaria</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="./?page=accueil&layout=html">Accueil</a></li>
                <li class="nav-item"><a class="nav-link" href="./?page=about&layout=html">A propos</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Boutique</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="./?page=shop&layout=html">Tous les produits</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <li><a class="dropdown-item" href="./?page=shop&layout=html&featured=true">Mise en avant</a></li>
                        <li><a class="dropdown-item" href="./?page=shop&layout=html&lastproduct=true">Derniers ajouts</a></li>
                    </ul>
                </li>
            </ul>
            <?php 
    if (isset($_SESSION['user'])) {
        echo '<ul class="navbar-nav">
            <li class="nav-item"><a class="btn btn-outline-dark" href="./?page=cart&layout=html"><i class="fa fa-shopping-cart"></i></a></li>
            <li class="dropdown nav-item ms-3">
                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Profil
                </button>
                <ul class="dropdown-menu dropdown-menu-dark">
                    <li><a class="dropdown-item active" href="./?page=profil&layout=html">Profil</a></li>
                    <li><a class="dropdown-item" href="./?page=cart&layout=html">Mon panier</a></li>
                    <li><a class="dropdown-item" href="#">Mes commandes</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="./?page=logout&layout=html">Se déconnecter</a></li>
                </ul>
            </li>
        </ul>';
    } else {
        echo '<ul class="navbar-nav">
            <li class="nav-item"><a class="btn btn-outline-dark" href="./?page=login&layout=html">Connexion</a></li>
            <li class="nav-item"><a class="btn btn-secondary ms-3" href="./?page=register&layout=html">Inscription</a></li>
        </ul>';
    } ?>

        </div>
    </div>
</nav>
