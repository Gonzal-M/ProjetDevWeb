<?php require_once("inc/header.inc.php"); ?>

<!--
    Page de compte
    Permet à l'utilisateur de gérer les biens qu'il a mis en location
    Nécessite une connexion

    Possibilité de poster une ou plusieurs annonces
    Possibilité de modifier et supprimer une annonce
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
    
    while ($annonce = $annonces->fetch(PDO::FETCH_OBJ)) { ?>

        <div class="card mb-3" style="max-width: 540px;">
        <div class="row no-gutters">
            <div class="col-md-4">
            <img src="img/annonces/<?php echo $annonce->titre; ?>" class="card-img" alt="...">
            </div>
            <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title"><?php echo $annonce->titre; ?></h5>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
            </div>
            </div>
        </div>
        </div>



        <p>
            - <?php echo $annonce->titre; ?>
            <a class="btn btn-outline-info my-2 my-sm-0 btn-sm" href="gestionbiens.php?gerer=modifier&IDannonce=<?php echo $annonce->id_annonce; ?>" style="margin-left : 50px;">Modifier</a>
            <a class="btn btn-outline-danger my-2 my-sm-0 btn-sm" href="gestionbiens.php?gerer=supprimer&IDannonce=<?php echo $annonce->id_annonce; ?>">Supprimer</a>
        </p><br>

    <?php } ?>

    <a href="gestionbiens.php?gerer=ajouter">Ajouter une annonce</a>

</div>
<?php require_once("inc/footer.inc.php"); ?>