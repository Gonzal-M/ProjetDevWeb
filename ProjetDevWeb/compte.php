<?php require_once("inc/header.inc.php"); ?>

<!-- Page de compte -->

<!-- Recuperation des donnees depuis la base de donne plus precisemment la table "compte" -->
<?php

$user = $pdo->query("SELECT * FROM compte WHERE id_compte='$_SESSION[userID]'");
($user = $user->fetch(PDO::FETCH_OBJ));

?>
<!-- Permet à l'utilisateur de gérer les infos de son compte -->
<div class="starter-template">  

    <br><h1>Modifier votre compte</h1>
   
    <form method="POST" enctype='multipart/form-data'>

        <div class="form-group">
            <label for="prenom"><?php echo $user->prenom; ?><span style="color: yellow;">*</span></label>
            <input type="texte" class="form-control" id="prenom" name="prenom" maxlength = "20" placeholder="Prénom" onkeyup="lettersOnly(this)">
        </div>

        <div class="form-group">
            <label for="nom"><?php echo $user->nom; ?><span style="color: yellow;">*</span></label>
            <input type="texte" class="form-control" id="nom" name="nom" maxlength = "20" placeholder="Nom de famille" onkeyup="lettersOnly(this)">
        </div>

        <div class="form-group">
            <label for="email"><?php echo $user->email; ?><span style="color: yellow;">*</span></label>
            <input type="email" class="form-control" id="email" name="email" maxlength = "50" placeholder="Adresse email (1-50 caractères)">
        </div>

        <div class="form-group">
            <label for="mdp1"><?php echo $user->mdp; ?><span style="color: yellow;">*</span></label>
            <input type="password" class="form-control" id="mdp1" name="mdp1" maxlength = "50" placeholder="Mot de passe (1-50 caractères)">
        </div>

        <div class="form-group">
            <label for="mdp2"><?php echo $user->mdp; ?><span style="color: yellow;">*</span></label>
            <input type="password" class="form-control" id="mdp2" name="mdp2" maxlength = "50" placeholder="Confirmer le mot de passe">
        </div>

        <div class="form-group">
            <label for="img"><?php echo $user->nomphoto; ?></label>
            <input type="file" class="form-control-file" id="img" name="img[]">
        </div>

        <br><button type="submit" class="btn btn-primary" name="submit">Valider</button>
        <a class="btn btn-primary" href="index.php">Retour</a>

    </form><br>
</div>






<!-- Nécessite une connexion -->



<?php require_once("inc/footer.inc.php"); ?>