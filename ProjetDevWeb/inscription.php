<?php require_once("inc/header.inc.php"); ?>
<?php require_once("inc/inscription.inc.php"); ?>


<div class="starter-template">  

    <br><h1>Créer un compte</h1>
    <p><span style="color: red;">*</span>Champs obligatoires</p>

    <form method="POST" enctype='multipart/form-data'>

        <div class="form-group">
            <label for="prenom">Prénom<span style="color: red;">*</span></label>
            <input type="texte" class="form-control" id="prenom" name="prenom" maxlength = "20" placeholder="Prénom">
        </div>

        <div class="form-group">
            <label for="nom">Nom<span style="color: red;">*</span></label>
            <input type="texte" class="form-control" id="nom" name="nom" maxlength = "20" placeholder="Nom de famille">
        </div>

        <div class="form-group">
            <label for="email">Email<span style="color: red;">*</span></label>
            <input type="email" class="form-control" id="email" name="email" maxlength = "50" placeholder="Adresse email (1-50 caractères)">
        </div>

        <div class="form-group">
            <label for="mdp1">Mot de passe<span style="color: red;">*</span></label>
            <input type="password" class="form-control" id="mdp1" name="mdp1" maxlength = "50" placeholder="Mot de passe (1-50 caractères)">
        </div>

        <div class="form-group">
            <label for="mdp2">Confirmer le mot de passe<span style="color: red;">*</span></label>
            <input type="password" class="form-control" id="mdp2" name="mdp2" maxlength = "50" placeholder="Confirmer le mot de passe">
        </div>

        <div class="form-group">
            <label for="img">Photo de profil</label>
            <input type="file" class="form-control-file" id="img" name="img[]">
        </div>

        <div class="form-group">
            <label for="solde">Solde<span style="color: red;">*</span></label>
            <input type="number" class="form-control" id="solde" name="solde" min="0" max="99999" placeholder="L'argent que vous souhaitez utiliser (en euros, jusqu'à 99.999€)">
        </div>

        <br><button type="submit" class="btn btn-primary" name="submit">Valider</button>
        <a class="btn btn-primary" href="index.php">Retour</a>

    </form><br>
</div>
<?php if(!empty($_POST["prenom"]) && !empty($_POST["nom"]) && !empty($_POST["email"]) && !empty($_POST["mdp1"]) && !empty($_POST["mdp2"]) && !empty($_POST["solde"])){
    // ^Vérifie que tous les champs obligatoires sont remplis 

    $_POST["prenom"] = htmlentities($_POST["prenom"], ENT_QUOTES);
    $_POST["nom"] = htmlentities($_POST["nom"], ENT_QUOTES);
    $_POST["email"] = htmlentities($_POST["email"], ENT_QUOTES);
    $_POST["mdp1"] = htmlentities($_POST["mdp1"], ENT_QUOTES);
    $_POST["mdp2"] = htmlentities($_POST["mdp2"], ENT_QUOTES);
    $_POST["solde"] = htmlentities($_POST["solde"], ENT_QUOTES);
    // ^Vérifie que les données entrées ne contiennent pas de code

    $name = "";
    if (isset($_FILES)) {
        foreach ($_FILES["img"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["img"]["tmp_name"][$key];
                $name = basename($_FILES["img"]["name"][$key]);
                move_uploaded_file($tmp_name, "img/profile/$name");
            }
        }
    }
    // ^Vérifie que le fichier est bon, enregistre son nom dans $name et l'enregistre dans le dossier img/
        
    
    else{
        $name="profilepicture.jpg";
    }
    // ^Si la photo n'a pas été ajoutée, la photo par défaut est choisie
    
    if($_POST["mdp1"]==$_POST["mdp2"]){
        // ^Vérifie que les mots de passe sont identiques

        $requeteSQL = "INSERT INTO compte (prenom, nom, email, mdp, nomphoto, solde) ";
        $requeteSQL .= "VALUE ('$_POST[prenom]', '$_POST[nom]', '$_POST[email]', '$_POST[mdp1]', '$_POST[nomphoto]', '$_POST[solde]')";

        $pdo->exec($requeteSQL);
        //^Enregistre les données dans la base de données

        $result = $pdo->query("SELECT id_compte FROM compte WHERE email='$_POST[email]'"); 
        $userID = $result->fetch(PDO::FETCH_OBJ);
        $_SESSION["userID"]=$userID->id_compte;
        // ^Connecte l'utilisateur

        header("Location:index.php");
        // ^Retourne à la page d'accueil
    }    

    else{
        echo("<p style='color: red;'>Les mots de passe sont différents</p>");
    }
} else if(!empty($_POST)){
    echo("<p style='color: red;'>Vous n'avez pas rempli tous les champs</p>");
}

require_once("inc/footer.inc.php"); ?>