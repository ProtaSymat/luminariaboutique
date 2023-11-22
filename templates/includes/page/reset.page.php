<?php
fromInc("reset");
?>
<body>
<section class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
    <h2>Entrez votre nouveau mot de passe</h2>
<div class="card d-flex justify-content-center">
    <form action="./?page=reset&layout=html" method="post" class="p-md-5 mx-md-4">
        <div class="mb-3">
            <label for="pseudo">Nom d'utilisateur :</label>
            <input type="text" id="pseudo" name="pseudo" required>
        </div>
        <div class="mb-3">
            <label for="new-password">Nouveau mot de passe :</label>
            <input type="password" id="new-password" name="new-password" required>
        </div>
        <div class="mb-3">
            <label for="confirm-password">Confirmer le nouveau mot de passe :</label>
            <input type="password" id="confirm-password" name="confirm-password" required>
        </div>
        <div>
            <input type="submit" value="Réinitialiser le mot de passe">
        </div>
    </form>
</div>
</div>
</section>
    