<?php
fromInc("verify");
?>
<body>
<section class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
    <h2>Réinitialisation du mot de passe</h2>
<div class="card d-flex justify-content-center">
    <form action="./?page=verify&layout=html" method="post" class="p-md-5 mx-md-4">
        <div>
            <label for="pseudo">Nom d'utilisateur :</label>
            <input type="text" id="pseudo" name="pseudo" required>
        </div>
        <div class="mt-3">
            <label for="mail">Adresse mail :</label>
            <input type="email" id="mail" name="mail" required>
        </div>
        <div>
            <input type="submit" value="Vérifier">
        </div>
    </form>
</div>
    </div>
</section>