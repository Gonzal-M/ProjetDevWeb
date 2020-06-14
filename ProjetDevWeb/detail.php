<?php require_once("inc/header.inc.php"); 

//page de détail d'une annonce

$annonce = $pdo->query("SELECT * FROM annonce WHERE id_annonce = '$_GET[IDannonce]'")->fetch(PDO::FETCH_OBJ); 
$user = $pdo->query("SELECT * FROM compte WHERE id_compte = '$annonce->id_compte'")->fetch(PDO::FETCH_OBJ);
$premphoto = $pdo->query("SELECT * FROM photos WHERE id_annonce='$annonce->id_annonce'")->fetch(PDO::FETCH_OBJ); ?>

    <h1><?php echo $annonce->titre; ?> par <a href="profil.php?IDcompte=<?php echo $compte->id_compte; ?>&afficherannonces=false"><?php echo $user->prenom . " " . $user->nom; ?></a></h1><br>

    <div class="row">
        <!-- infos -->
        <div class="card col-md-5" style="border: 0px">
            <img src="img/annonces/<?php echo $premphoto->nomphoto; ?>" class="card-img" alt="Première photo de l'annonce" style="filter: blur(10px);">
            <div class="card-img-overlay">
                <p class="card-text" style="height: 300px;"><span style="font-weight: bold;">Description : </span><br><?php echo $annonce->descript; ?></p>
                <div class="card-footer bg-transparent">
                    <p class="card-text"><span style="font-weight: bold;">Prix par nuit par personne : </span><?php echo $annonce->prix; ?> €</p>
                    <p class="card-text"><span style="font-weight: bold;">Nombre de places : </span><?php echo $annonce->nb_places; ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-1"></div>

        <!-- images -->
        <div class="card col-md-5 border-light">
            <?php if(!isset($_GET["img"])){

                //prend la première photo
                $nomphoto = $premphoto->nomphoto;

            }else{
                
                //photo sélectionnée
                $photoselect = $pdo->query("SELECT * FROM photos WHERE id_annonce='$annonce->id_annonce' AND id_photo='$_GET[img]'")->fetch(PDO::FETCH_OBJ);
                $nomphoto = $photoselect->nomphoto;

            }?>
                
            <img src="img/annonces/<?php echo $nomphoto; ?>" class="card-img" alt="Première photo de l'annonce">
            <div class="card-img-overlay">
                <div class="card-footer bg-transparent" style="margin-top:320px;">
                    <!-- affichage des miniatures -->
                    <?php $photos2 = $pdo->query("SELECT * FROM photos WHERE id_annonce='$annonce->id_annonce'");
                    while($photo = $photos2->fetch(PDO::FETCH_OBJ)){ ?>
                        <a href="detail.php?IDannonce=<?php echo $annonce->id_annonce; ?>&img=<?php echo $photo->id_photo; ?>">
                            <img src="img/annonces/<?php echo $photo->nomphoto; ?>" alt="Photo n°<?php echo $photo->id_photo; ?> de l'annonce" style="height: 50px; width: 50px; border: 1px, solid, grey;">
                        </a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <br><br>
    <h3>Emplacement</h3>
    <br><br>

    <div class="row">
        <!-- api carte -->
        <div class="col-md-8">
            <p style="color: grey;">Affichage de la carte...</p>
        </div>

        <!-- adresse -->
        <div class="col-md-4">
            <p style="font-weight: bold;">Adresse :</p>
            <p><?php echo $annonce->numerorue . ", " . $annonce->nomrue; ?></p>
            <p><?php echo $annonce->codepostal . ", " . $annonce->ville; ?></p>
        </div>
    </div>

    <br>
    <a class="btn btn-primary" href="reservation.php?IDannonce=<?php echo $annonce->id_annonce; ?>" style="margin-bottom: 10px;">Réserver</a>

<?php require_once("inc/footer.inc.php"); ?>