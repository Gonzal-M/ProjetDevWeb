<?php
    //email client
    $sujetclient = "Confirmation de votre réservation chez Airbnb";

    $messageclient = "Bonjour " . $prenomclient . $nomclient . ", voici la confirmation de votre réservation.\n\n";
    $messageclient .= "Vous avez réservé " . $nombien . " du " . $datedebut " au " . $datefin . " pour " . $nbpersonnes . " personnes.\n\n";
    $messageclient .= "Prix de la location : " . $prix . "\n";
    $messageclient .= "Votre solde actualisé : ". $soldeclient . "\n\n";
    $messageclient .= "Vous pouvez contacter votre hôte avec l'adresse email suivante :\n";
    $messageclient .= $mailhote . "\n\n";
    $messageclient .= "AirBnB vous remercie de votre confiance."

    $headerclient = "From:" . $mailhote;

    mail($mailclient, $sujetclient, $messageclient, $headerclient);
    

    //email hôte
    $sujethote = "Confirmation de la réservation du bien" . $nombien;

    $messagehote = "L'utilisateur " . $prenomclient . $nomclient . " a réservé votre bien " . $nombien . ".\n";
    $messagehote .= "Le bien a été réservé du " . $datedebut " au " . $datefin . " pour " . $nbpersonnes . " personnes.\n\n";
    $messagehote .= "Prix de la location : " . $prix . "\n";
    $messagehote .= "Votre solde actualisé : ". $soldehote . "\n\n";
    $messagehote .= "Vous pouvez contacter votre client avec l'adresse email suivante :\n";
    $messagehote .= $mailclient . "\n\n";
    $messagehote .= "AirBnB vous remercie de votre confiance."

    $headerhote = "From:" . $mailclient;

    mail($mailhote, $sujethote, $messagehote, $headerhote);
    
?>