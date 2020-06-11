<?php require_once("inc/header.inc.php"); ?>

<!-- Page du profil -->
<!-- affiche les infos et les biens mis en location d'un utilisateur -->
<!-- Nécessite une connexion -->

<?php 
if(!empty($_GET["IDcompte"])){

    $user = $pdo->query("SELECT * FROM compte WHERE id_compte='$_GET[IDcompte]'");
    $user = $user->fetch(PDO::FETCH_OBJ); ?>

    <h1>Profil de <?php echo $user->email; ?></h1>

    

<?php }else{

    echo "<p style='color: red;>Aucun profil sélectionné.</p>";
}

echo '<a class="btn btn-primary" href="index.php">Retour</a>';

require_once("inc/footer.inc.php"); ?>