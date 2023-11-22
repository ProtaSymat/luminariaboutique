<?php

if(isset($_SESSION['user'])){
    session_unset();
    session_destroy();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    header("Location: ./?page=accueil&layout=html");
    exit();
} else {
    header("Location: ./?page=login&layout=html");
    echo("Vous n'êtes pas connecté");
    exit();
}
