<?php require_once("inc/header.inc.php"); ?>

<!-- Récupération des données depuis la base de données, plus précisemment la table "compte" -->
<?php

$user = $pdo->query("SELECT * FROM compte WHERE id_compte='$_SESSION[userID]'");
$user = $user->fetch(PDO::FETCH_OBJ);

?>

<!-- Permet à l'utilisateur de gérer les infos de son compte -->

<div class="starter-template">  

    <br><h1>Modifier votre compte</h1>
   
    <form method="POST" enctype='multipart/form-data'>

        <div class="form-group">
            <label for="prenom">Prénom<span style="color: red;">*</span></label>
            <input type="texte" class="form-control" id="prenom" name="prenom" maxlength = "20" value="<?php echo $user->prenom; ?>" onkeyup="lettersOnly(this)">
        </div>

        <div class="form-group">
            <label for="nom">Nom<span style="color: red;">*</span></label>
            <input type="texte" class="form-control" id="nom" name="nom" maxlength = "20" value="<?php echo $user->nom; ?>" onkeyup="lettersOnly(this)">
        </div>

        <div class="form-group">
            <label for="email">Email<span style="color: red;">*</span></label>
            <input type="email" class="form-control" id="email" name="email" maxlength = "50" value="<?php echo $user->email; ?>">
        </div>

        <div class="form-group">
            <label for="mdp1">Mot de passe<span style="color: red;">*</span></label>
            <input type="password" class="form-control" id="mdp1" name="mdp1" maxlength = "50" value="<?php echo $user->mdp; ?>">
        </div>

        <div class="form-group">
            <label for="mdp2">Confirmer le mot de passe<span style="color: yelredlow;">*</span></label>
            <input type="password" class="form-control" id="mdp2" name="mdp2" maxlength = "50" value="<?php echo $user->mdp; ?>">
        </div>

        <div class="form-group">
            <img src="img/profile/<?php echo $user->nomphoto; ?>" alt="Votre photo de profil" style="height: 100px; width: 100px;">
            <label for="img">Photo de profil</label>
            <input type="file" class="form-control-file" id="img" name="img[]">
        </div>

        <br><button type="submit" class="btn btn-primary">Valider</button>
        <a class="btn btn-primary" href="index.php">Retour</a>

    </form><br>
</div>

<?php if(!empty($_POST["prenom"]) && !empty($_POST["nom"]) && !empty($_POST["email"]) && !empty($_POST["mdp1"]) && !empty($_POST["mdp2"])){

    $_POST["prenom"] = htmlentities($_POST["prenom"], ENT_QUOTES);
    $_POST["nom"] = htmlentities($_POST["nom"], ENT_QUOTES);
    $_POST["email"] = htmlentities($_POST["email"], ENT_QUOTES);
    $_POST["mdp1"] = htmlentities($_POST["mdp1"], ENT_QUOTES);
    $_POST["mdp2"] = htmlentities($_POST["mdp2"], ENT_QUOTES);
    // ^Vérifie que les données entrées ne contiennent pas de code

    $name = $user->nomphoto;
    // ^Récupère la photo de profile actuelle au cas où l'utilisateur ne souhaite pas la changer
    if (isset($_FILES)) {
        foreach ($_FILES["img"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["img"]["tmp_name"][$key];
                $name = basename($_FILES["img"]["name"][$key]);
                move_uploaded_file($tmp_name, "img/profile/$name");
            }
        }
    }
    // ^Vérifie que le fichier est bon, enregistre son nom dans $name et l'enregistre dans le dossier img/profile/
    
    if($_POST["mdp1"]==$_POST["mdp2"]){
        // ^Vérifie que les mots de passe sont identiques

        $pdo->exec("UPDATE compte SET prenom ='$_POST[prenom]', nom = '$_POST[nom]', email = '$_POST[email]', mdp = '$_POST[mdp2]', nomphoto = '$name' WHERE id_compte='$_SESSION[userID]'");
        //^Enregistre les données modifiées dans la base de données

        
        header("Location:index.php");
        // ^Retourne à la page d'accueil
    }    

    else{
        echo("<p style='color: red;'>Les mots de passe sont différents</p>");
    }
}

require_once("inc/footer.inc.php"); ?>