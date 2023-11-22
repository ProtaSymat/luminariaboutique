<?php
include_once './templates/includes/elements/html_header.inc.php';
fromInc("menu");
?>
<body>
        <div class="d-flex align-items-center justify-content-center vh-50">
            <div class="text-center">
                <h1 class="display-1 fw-bold">404</h1>
                <p class="fs-3"> <span class="text-danger">Oups!</span> Y'a pas de page ici !</p>
                <p class="lead">
                    Cette page n'existe pas...
                  </p>
                <a href="./?page=accueil&layout=html" class="btn btn-primary">Retourner à l'accueil</a>
            </div>
        </div>