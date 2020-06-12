<?php require_once("inc/header.inc.php"); ?>

<!--
    Page détaillant un bien à louer 
    Possibilité de réserver si connecté mais la page peut être consultée sans connexion

    Localiser le logement sur une carte
-->

<?php $annonce = $pdo->query("SELECT * FROM annonce WHERE id_annonce = '$_GET[IDannonce]'")->fetch(PDO::FETCH_OBJ); 
$user = $pdo->query("SELECT * FROM compte WHERE id_compte = '$annonce->id_compte'")->fetch(PDO::FETCH_OBJ);
$photos = $pdo->query("SELECT * FROM photos WHERE id_annonce='$annonce->id_annonce'");
$premphoto = $photos->fetch(PDO::FETCH_OBJ);?>

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
                <div class="card-footer bg-transparent" style="margin-top:320px; height: 100px;">
                    <!-- affichage des miniatures -->
                    <?php $nbphotos=0;
                    while($photo = $photos->fetch(PDO::FETCH_OBJ)){ 
                        $nbphotos+=1;?>
                        <a href="detail.php?IDannonce=<?php echo $annonce->id_annonce; ?>&img=<?php echo $photo->id_photo; ?>">
                            <img src="img/annonces/<?php echo $photo->nomphoto; ?>" alt="Photo n°<?php echo $photo->id_photo; ?> de l'annonce" style="height: 50px; width: 50px; border: 1px, solid, grey;">
                        </a>
                    <?php } 
                    echo $nbphotos;?>
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