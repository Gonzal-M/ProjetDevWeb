<?php require_once("inc/header.inc.php"); ?>

<?php if(!empty($_SESSION["userID"])){
    $annonce = $pdo->query("SELECT * FROM annonce WHERE id_annonce = '$_GET[IDannonce]'")->fetch(PDO::FETCH_OBJ);
    $reservations = $pdo->query("SELECT * FROM reservation WHERE id_annonce = '$_GET[IDannonce]'");
    $reservexiste = $pdo->query("SELECT * FROM reservation WHERE id_annonce = '$_GET[IDannonce]'")->fetch(PDO::FETCH_OBJ);
    $hote = $pdo->query("SELECT * FROM compte WHERE id_compte = '$annonce->id_compte'")->fetch(PDO::FETCH_OBJ);
    $client = $pdo->query("SELECT * FROM compte WHERE id_compte = '$_SESSION[userID]'")->fetch(PDO::FETCH_OBJ); ?> 

    <br><h1>Réservation de <?php echo $annonce->titre; ?></h1>

    <?php if(empty($_POST["nbpersonnes"]) || empty($_POST["datedebut"]) || empty($_POST["datefin"])){ ?>
        <p><span style="color: red;">*</span>Champs obligatoires</p>
        <form method="POST" >
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="nbpersonnes">Nombre de locataires<span style="color: red;">*</span></label>
                    <input type="number" class="form-control" id="nbpersonnes" name="nbpersonnes" min="1" max="<?php echo $annonce->nb_places; ?>" placeholder="Nombre de locataires">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="datedebut">Date d'arrivée<span style="color: red;">*</span></label>
                    <input type="date" class="form-control" id="datedebut" name="datedebut" min="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="datefin">Date de départ<span style="color: red;">*</span></label>
                    <input type="date" class="form-control" id="datefin" name="datefin" min="<?php echo date('Y-m-d'); ?>">
                </div>
            </div>

            <div class="row">
                <?php if(!empty($reservexiste)){ ?>
                    <div class="form-group col"> 
                        <br><p style='color: red;'>*Attention, certaines dates sont indisponibles :</p>
                        <?php while($reservation = $reservations->fetch(PDO::FETCH_OBJ)){
                            echo "<p>Du ". $reservation->date_arrive . " au " . $reservation->date_depart . ".<p>";
                        } ?>
                    </div>
                <?php } ?>
            </div>
                
                <a href="reservation.php?IDannonce=<?php echo $annonce->id_annonce; ?>&confirm=true"><button type="submit" class="btn btn-primary">Réserver</button></a>
                <a class="btn btn-primary" href="index.php">Retour</a>
        </form><br>
    <?php }else{
        $peutreserver = false;
        //vérifie que les dates ont un ordre logique
        if($_POST['datedebut'] < $_POST['datefin']){
            //vérifie s'il y a déjà une réservation pendant la période demandée
            while($reservation = $reservations->fetch(PDO::FETCH_OBJ)){
                if( ( $_POST['datedebut'] >= $reservation->date_arrive && $_POST['datedebut'] <= $reservation->date_depart ) || ( $_POST['datefin'] >= $reservation->date_arrive && $_POST['datefin'] <= $reservation->date_depart ) ){
                    echo "<p style='color: red'>Ces dates ne sont pas disponibles.</p>";
                    echo "<a class='btn btn-primary' href='reservation.php?IDannonce=" . $annonce->id_annonce . "'>Retour</a><br>";
                    $peutreserver = false;
                    break;
                }
                $peutreserver = true;
            }
        }else{
            echo "<p style='color: red'>Ces dates ne sont pas dans un ordre chronologiques.</p>";
            echo "<a class='btn btn-primary' href='reservation.php?IDannonce=" . $annonce->id_annonce . "'>Retour</a><br>";
        }

        //si les dates de réservations sont libres... 
        if($peutreserver){
            $prenomclient = $client->prenom;
            $nomclient = $client->nom;
            $mailclient = $client->email; 
            $mailhote = $hote->email;
            $nombien = $annonce->titre;
            $nbpersonnes = $_POST['nbpersonnes'];
            $datedebut = $_POST['datedebut'];
            $datefin = $_POST['datefin'];

            $nbjours = (new DateTime("$datedebut"))->diff(new DateTime("$datefin"))->days;
            $prix = $annonce->prix * $nbpersonnes * $nbjours;

            $soldeclient = $client->solde - $prix;
            $soldehote = $hote->solde + $prix;

            if($prix <= $client->solde){ ?>
                <p>Prix de la location : <?php echo $prix; ?> €</p>
                <p>Solde après réservation : <?php echo $soldeclient; ?> €</p><br>
                <p>Merci de votre confiance. Vous allez recevoir un email de confirmation.</p>
                <a class="btn btn-primary" href="recherche.php">Retour</a><br>

                <?php //ajout de la réservation dans la BDD
                $requeteSQL = "INSERT INTO reservation (id_annonce, date_arrive, date_depart) VALUE ('$annonce->id_annonce', '$datedebut', '$datefin');";
                //modification du solde du client et de l'hôte
                $requeteSQL .= "UPDATE compte SET solde = '$soldeclient' WHERE id_compte = '$client->id_compte';";
                $requeteSQL .= "UPDATE compte SET solde = '$soldehote' WHERE id_compte = '$hote->id_compte';";
                //envoie requête
                $pdo->exec($requeteSQL);
                //envoie mail de confirmation au client et à l'hôte
                //require_once("inc/reservation.inc.php");
            }  
        }
    }
}else{
    echo "<p style='color:red;'>Veuillez vous connecter pour accéder à cette page.</p>";
}

require_once("inc/footer.inc.php"); ?>