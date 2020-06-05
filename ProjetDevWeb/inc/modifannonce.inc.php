<p><span style="color: red;">*</span>Champs obligatoires</p><br>     

<?php $result = $pdo->query("SELECT * FROM annonces WHERE id_annonce = '$_GET[IDannonce]'"); 
$annonce = $result->fetch(PDO::FETCH_OBJ);?>

<form method="POST" enctype='multipart/form-data'>

    <div class="form-group">
        <label for="titre">Titre<span style="color: red;">*</span></label>
        <input type="texte" class="form-control" id="titre" name="titre" value="<?php $annonce->titre; ?>" maxlength = "50">
    </div>

    <h7>Adresse :</h7>
    <div class="form-group">
        <label for="numerorue">Numéro de rue<span style="color: red;">*</span></label>
        <input type="number" class="form-control" id="numerorue" name="numerorue" min="1" max="99" value="<?php $annonce->numerorue; ?>">
    </div>

    <div class="form-group">
        <label for="nomrue">Nom de la rue<span style="color: red;">*</span></label>
        <input type="texte" class="form-control" id="nomrue" name="nomrue" maxlength="50" value="<?php $annonce->nomrue; ?>">
    </div>

    <div class="form-group">
        <label for="codepostal">Code Postal<span style="color: red;">*</span></label>
        <input type="number" class="form-control" id="codepostal" name="codepostal" min="1000" max="99999" value="<?php $annonce->codepostal; ?>">
    </div>

    <div class="form-group">
        <label for="ville">Ville<span style="color: red;">*</span></label>
        <input type="texte" class="form-control" id="ville" name="ville" maxlength="50" value="<?php $annonce->ville; ?>">
    </div>

    <div class="form-group">
        <label for="description">Description<span style="color: red;">*</span></label>
        <textarea rows="10" class="form-control" id="description" name="description" value="<?php $annonce->descript; ?>"></textarea>
    </div>

    <div class="form-group">
        <label for="nbplaces">Nombre de places<span style="color: red;">*</span></label>
        <input type="number" class="form-control" id="nbplaces" name="nbplaces" min="0" max="99" value="<?php $annonce->nb_places; ?>">
    </div>

    <div class="form-group">
        <label for="prix">Prix<span style="color: red;">*</span></label>
        <input type="number" class="form-control" id="prix" name="prix" min="0" max="99999" value="<?php $annonce->prix; ?>">
    </div>
    
    <p>Supprimer des photos</p>
    <div class="card-group">

    <?php $photos = $pdo->query("SELECT * FROM photos WHERE id_annonce='$annonce->id_annonce'");
    while ($pdo->query("SELECT COUNT(*) FROM photos") > 1){
        while($photo = $photos->fetch(PDO::FETCH_OBJ)){ ?> 

            <div class="card">
                <a class="btn btn-outline-info my-2 my-sm-0 btn-sm" href="gestionbiens.php?gerer=modifier&IDannonce=<?php echo $annonce->id_annonce; ?>&delphoto=<?php echo $photo->id_photo; ?>">
                    <img src="img/annonces/<?php echo $photo->nomphoto; ?>" class="card-img-top" alt="Photo de l'annonce">
                </a>
            </div>

        <?php }
    } ?>
    </div>
    <?php if($pdo->query("SELECT COUNT(*) FROM photos" == 1){
        echo "<p><span style='color: red;'>*</span>Vous n'avez pas assez de photos pour en supprimer</p>"
    } ?>
    

    <div class="form-group">
        <label for="img">Ajouter des photos</label>
        <input type="file" class="form-control-file" id="img" name="img[]" multiple>
    </div>

    <button type="submit" class="btn btn-primary">Modifier une annonce</button>
    
</form>

<br><a href="gestionbiens.php" class="btn btn-primary">Retour</a><br><br><br>

<?php 
if(isset($_GET["delphoto"])){
    $photo = $pdo->query("SELECT nomphoto FROM photos WHERE id_photo = '$_GET[delphoto]'");
    $photo = $photo->fetch(PDO::FETCH_OBJ);
    unlink("img/annonces/$photo->nomphoto");
    $pdo->exec("DELETE FROM photos WHERE id_photo = '$_GET[delphoto]'");
}

if(!empty($_POST["titre"]) && !empty($_POST["numerorue"]) && !empty($_POST["nomrue"]) && !empty($_POST["codepostal"]) && !empty($_POST["ville"]) && !empty($_POST["description"]) && !empty($_POST["titre"]) && !empty($_POST["nbplaces"]) && !empty($_POST["prix"])){

    $_POST["titre"] = htmlentities($_POST["titre"], ENT_QUOTES);
    $_POST["numerorue"] = htmlentities($_POST["numerorue"], ENT_QUOTES);
    $_POST["nomrue"] = htmlentities($_POST["nomrue"], ENT_QUOTES);
    $_POST["codepostal"] = htmlentities($_POST["codepostal"], ENT_QUOTES);
    $_POST["ville"] = htmlentities($_POST["ville"], ENT_QUOTES);
    $_POST["description"] = htmlentities($_POST["description"], ENT_QUOTES);
    $_POST["nbplaces"] = htmlentities($_POST["nbplaces"], ENT_QUOTES);
    $_POST["prix"] = htmlentities($_POST["prix"], ENT_QUOTES);
    // ^Vérifie que les données entrées ne contiennent pas de code

    $requeteSQL = "UPDATE annonce SET titre='$_POST[titre]', descript='$_POST[description]', ";
    $requeteSQL .= "nb_places='$_POST[nbplaces]', numerorue='$_POST[numerorue]', nomrue='$_POST[nomrue]', ";
    $requeteSQL .= "ville='$_POST[ville]', codepostal='$_POST[codepostal]', prix='$_POST[prix]' ";
    $requeteSQL .= "WHERE id_annonce='$_GET[IDannonce]'";

    $pdo->exec($requeteSQL);
    if(isset($_FILES["img"])){
        $name = "";
        foreach ($_FILES["img"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["img"]["tmp_name"][$key];
                $name = basename($_FILES["img"]["name"][$key]);
                move_uploaded_file($tmp_name, "img/annonces/$name");
                $requeteSQL = "INSERT INTO photos (id_annonce, nomphoto) VALUE ('$_GET[IDannonce]','$name')";
                $pdo->exec($requeteSQL);
            }
        }
    }

    header("Location:gestionbiens.php");

} 