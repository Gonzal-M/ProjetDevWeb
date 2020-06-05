<?php
    
    $to = "airbnbynov@gmail.com"; 
    $from = $_POST['email']; 
     
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp2'];
    $solde = $_POST['solde'];
     
     
    $subject = "Copie de l'inscription de l'utilisateur " . $prenom;
    $subject2 = "Copie de votre inscription chez Airbnb";
        
    $emailmessage = "Bonjour " . $prenom . ", voici la confirmation de votre inscription.\n\n";
    $emailmessage .= "Prénom: ".  $prenom ."\n";
    $emailmessage .= "Nom: ". $nom ."\n";
    $emailmessage .= "Email: ". $email ."\n";
    $emailmessage .= "Mot de passe: ". $mdp ."\n";
    $emailmessage .= "Solde: ". $solde ."\n";
    $headers = "From:" . $from;
    $headers2 = "From:" . $to;
       
    mail($to, $subject, $emailmessage, $headers);
    mail($from, $subject2, $emailmessage, $headers2);
    
    
}
    ?>