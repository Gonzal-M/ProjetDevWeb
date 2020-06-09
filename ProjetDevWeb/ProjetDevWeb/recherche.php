<?php require_once("inc/header.inc.php"); ?>

<div class="starter-template">  

    <br><h1>Rechercher une location</h1>

    <form method="POST" enctype='multipart/form-data'>
        
        
        <div class="form-group">
            <label for="ville">Ville</label>
            <input type="texte" class="form-control" id="ville" name="ville" maxlength = "50" placeholder="Ville de la location" onkeyup="lettersOnly(this)">
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="nbplaces">Nombre de places</label>
                <input type="number" class="form-control" id="nbplaces" name="nbplaces" min="1" max="99" placeholder="Nombre de places dans la location">
            </div>

            <div class="form-group col">
                <label for="prixmin">Prix minimum</label>
                <input type="number" class="form-control" id="prixmin" name="prixmin" min="1" max="99999" placeholder="Prix minimum de la location">
            </div>
            <div class="form-group col">
                <label for="prixmax">Prix maximum</label>
                <input type="number" class="form-control" id="prixmax" name="prixmax" min="1" max="99999" placeholder="Prix maximum de la location">
            </div>
        </div>

        <div class="row">
            <div class="form-group col">
                <label for="datearr">Date d'arrivée</label>
                <input type="date" class="form-control" id="datearr" name="datearr">
            </div>

            <div class="form-group col">
                <label for="datedep">Date de départ</label>
                <input type="date" class="form-control" id="datedep" name="datedep">
            </div>
        </div>

        <br><button type="submit" class="btn btn-primary">Valider</button>
        <a class="btn btn-primary" href="index.php">Retour</a>

    </form><br>
</div>

<?php $requeteSQL = "SELECT * FROM annonce a";

if(empty($_POST)){
    //si l'utilisateur ne précise pas la recherche, afficher toutes les annonces
    $annonces = $pdo->query($requeteSQL);
    
}
else{

    //si l'utilisateur recherche des dates précises, la table "reservation" est ajoutée à la recherche
    if(!empty($_POST["datearr"])){
        $requeteSQL .= ", reservation r WHERE r.date_arrive = '$_POST[datearr]'";
    }
    if(!empty($_POST["datedep"])){
        if(!empty($_POST["datearr"])){
            $requeteSQL .= " AND ";
        }
        else{
            $requeteSQL .= ", reservation r WHERE ";
        }
        $requeteSQL .= "r.date_depart = '$_POST[datedep]'";
    }


    if(empty($_POST["datearr"]) && empty($_POST["datedep"])){
        $requeteSQL .= " WHERE ";
    }
    else{
        $requeteSQL .= ", ";
    }


    if(!empty($_POST["ville"])){
        $requeteSQL .= "a.ville = '$_POST[ville]'";
    }
    if(!empty($_POST["nbplaces"])){
        if(!empty($_POST["ville"])){
            $requeteSQL .= " AND ";
        }
        $requeteSQL .= "a.nb_places = '$_POST[nbplaces]'";
    }
    if(!empty($_POST["prixmin"])){
        if(!empty($_POST["ville"]) || !empty($_POST["nbplaces"])){
            $requeteSQL .= " AND ";
        }
        $requeteSQL .= "a.prix >= '$_POST[prixmin]'";
    }
    if(!empty($_POST["prixmax"])){
        if(!empty($_POST["ville"]) || !empty($_POST["nbplaces"]) || !empty($_POST["prixmin"])){
            $requeteSQL .= " AND ";
        }
        $requeteSQL .= "a.prix <= '$_POST[prixmax]'";
    }
    
    $annonces = $pdo->query($requeteSQL);
}


$nbresults = 0;
//affichage des résultats
while($annonce = $annonces->fetch(PDO::FETCH_OBJ)){ ?>
    <div class="card mb-3" style="max-width: 540px;">
        <div class="row no-gutters">
            <div class="col-md-4">
            <?php $photo = $pdo->query("SELECT * FROM photos WHERE id_annonce='$annonce->id_annonce' ORDER BY id_photo LIMIT 1");
            $photo = $photo->fetch(PDO::FETCH_OBJ); ?>
            <img src="img/annonces/<?php echo $photo->nomphoto; ?>" class="card-img" alt="Première photo de l'annonce n°<?php echo $annonce->id_annonce; ?>">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $annonce->titre; ?></h5>
                    <p class="card-text">Ville : <?php echo $annonce->ville; ?></p>
                    <p class="card-text"><?php echo substr($annonce->descript, 0, 50) . "..."; ?></p>
                    <a class="btn btn-outline-info my-2 my-sm-0 btn-sm" href="recherche.php?IDannonce=<?php echo $annonce->id_annonce; ?>">Détails</a>
                </div>
            </div>
        </div>
    </div>
    <?php $nbresults+=1;
}

if($nbresults == 0){
    echo "<p style='color: red;'> Aucune annonce ne correspond à votre recherche.</p>";
}

require_once("inc/footer.inc.php"); ?>