<p><span style="color: red;">*</span>Champs obligatoires</p><br>     
        
<form method="POST" enctype='multipart/form-data'>

    <div class="form-group">
        <label for="titre">Titre<span style="color: red;">*</span></label>
        <input type="texte" class="form-control" id="titre" name="titre" placeholder="Le titre de votre annonce" maxlength = "50">
    </div>

    <h7>Adresse :</h7>
    <div class="form-group">
        <label for="numerorue">Numéro de rue<span style="color: red;">*</span></label>
        <input type="number" class="form-control" id="numerorue" name="numerorue" min="1" max="99" placeholder="Numéro de rue">
    </div>

    <div class="form-group">
        <label for="nomrue">Nom de la rue<span style="color: red;">*</span></label>
        <input type="texte" class="form-control" id="nomrue" name="nomrue" maxlength="50" placeholder="Nom de la rue">
    </div>

    <div class="form-group">
        <label for="codepostal">Code Postal<span style="color: red;">*</span></label>
        <input type="number" class="form-control" id="codepostal" name="codepostal" min="1000" max="99999" placeholder="Code postal">
    </div>

    <div class="form-group">
        <label for="ville">Ville<span style="color: red;">*</span></label>
        <input type="texte" class="form-control" id="ville" name="ville" maxlength="50" placeholder="Nom de la ville">
    </div>

    <div class="form-group">
        <label for="description">Description<span style="color: red;">*</span></label>
        <textarea rows="10" class="form-control" id="description" name="description" placeholder="Description du bien que vous louez"></textarea>
    </div>

    <div class="form-group">
        <label for="nbplaces">Nombre de places<span style="color: red;">*</span></label>
        <input type="number" class="form-control" id="nbplaces" name="nbplaces" min="0" max="99" placeholder="Nombre de places disponibles">
    </div>

    <div class="form-group">
        <label for="prix">Prix<span style="color: red;">*</span></label>
        <input type="number" class="form-control" id="prix" name="prix" min="0" max="99999" placeholder="Le prix de location (par nuit, par personne)">
    </div>
    
    <div class="form-group">
        <label for="img">Photos</label>
        <p><span style="color: red;">*</span>Une au minimum</p>
        <input type="file" class="form-control-file" id="img" name="img[]" multiple>
    </div>

    <button type="submit" class="btn btn-primary">Ajouter une annonce</button>
    
</form>

<br><a href="gestionbiens.php" class="btn btn-primary">Retour</a><br><br><br>

<?php if(!empty($_POST["titre"]) && !empty($_POST["numerorue"]) && !empty($_POST["nomrue"]) && !empty($_POST["codepostal"]) && !empty($_POST["ville"]) && !empty($_POST["description"]) && !empty($_POST["titre"]) && !empty($_POST["nbplaces"]) && !empty($_POST["prix"]) && !empty($_FILES["img"])){

    $_POST["titre"] = htmlentities($_POST["titre"], ENT_QUOTES);
    $_POST["numerorue"] = htmlentities($_POST["numerorue"], ENT_QUOTES);
    $_POST["nomrue"] = htmlentities($_POST["nomrue"], ENT_QUOTES);
    $_POST["codepostal"] = htmlentities($_POST["codepostal"], ENT_QUOTES);
    $_POST["ville"] = htmlentities($_POST["ville"], ENT_QUOTES);
    $_POST["description"] = htmlentities($_POST["description"], ENT_QUOTES);
    $_POST["nbplaces"] = htmlentities($_POST["nbplaces"], ENT_QUOTES);
    $_POST["prix"] = htmlentities($_POST["prix"], ENT_QUOTES);
    // ^Vérifie que les données entrées ne contiennent pas de code

    $requeteSQL = "INSERT INTO annonce (id_compte, titre, descript, nb_places, numerorue, nomrue, ville, codepostal, prix) VALUE ";
    $requeteSQL .= "($_SESSION[userID], '$_POST[titre]', '$_POST[description]', '$_POST[nbplaces]', '$_POST[numerorue]', ";
    $requeteSQL .= "'$_POST[nomrue]', '$_POST[ville]', '$_POST[codepostal]', '$_POST[prix]')";

    $pdo->exec($requeteSQL);
    $annonce = $pdo->query("SELECT id_annonce FROM annonce WHERE id_compte='$_SESSION[userID]' ORDER BY id_annonce DESC LIMIT 1");
    $cherche_id_annonce = $annonce->fetch(PDO::FETCH_OBJ);
    $id_annonce = $cherche_id_annonce->id_annonce;

    
    $name = "";
    foreach ($_FILES["img"]["error"] as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $tmp_name = $_FILES["img"]["tmp_name"][$key];
            $name = basename($_FILES["img"]["name"][$key]);
            move_uploaded_file($tmp_name, "img/annonces/$name");
            $requeteSQL = "INSERT INTO photos (id_annonce, nomphoto) VALUE ('$id_annonce','$name')";
            $pdo->exec($requeteSQL);
        }
    }

    

    

    //header("Location:gestionbiens.php");

} 


    