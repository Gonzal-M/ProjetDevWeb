<?php require_once("inc/header.inc.php"); ?>

<!--
    Page de biens
    Permet à l'utilisateur de gérer les biens qu'il a mis en location
    Nécessite une connexion

    Une annonce doit contenir :
    - un titre
    - une description
    - une ou plusieurs photos
    - un nombre de places
    - une adresse
    - un prix par nuitée par personne
-->

<div class="starter-template">  

    <br><h1>Gestion des biens mis en location</h1><br>

    <?php $annonces = $pdo->query("SELECT * FROM annonce WHERE id_compte='$_SESSION[userID]'");
    if(empty($_GET)){
        while ($annonce = $annonces->fetch(PDO::FETCH_OBJ)) { ?>

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
                            <p class="card-text"><?php echo $annonce->descript; ?></p>
                            <a class="btn btn-outline-info my-2 my-sm-0 btn-sm" href="gestionbiens.php?gerer=modifier&IDannonce=<?php echo $annonce->id_annonce; ?>" style="margin-left : 50px;">Modifier</a>
                            <a class="btn btn-outline-danger my-2 my-sm-0 btn-sm" href="gestionbiens.php?gerer=supprimer&IDannonce=<?php echo $annonce->id_annonce; ?>">Supprimer</a>
                        </div>
                    </div>
                </div>
            </div>

        <?php } ?>

        <a href="gestionbiens.php?gerer=ajouter">Ajouter une annonce</a><br>

    <?php }

    else if($_GET["gerer"]=="ajouter"){ ?>
        
        <h3>Ajouter une annonce</h3>
        <?php require_once("inc/ajoutannonce.inc.php");

    }
    
    
    else if($_GET["gerer"]=="modifier"){
        
    }

    

    else if($_GET["gerer"]=="supprimer"){
        $pdo->exec("DELETE FROM photos WHERE id_annonce = '$_GET[IDannonce]'");
        $pdo->exec("DELETE FROM reservation WHERE id_annonce = '$_GET[IDannonce]'");
        $pdo->exec("DELETE FROM annonce WHERE id_annonce = '$_GET[IDannonce]'");
    } ?>

</div>

<?php require_once("inc/footer.inc.php"); ?>