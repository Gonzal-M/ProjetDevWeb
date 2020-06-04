<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Site AirBnB pour le projet de développement web">
    <meta name="author" content="GONZALEZ Marie & MAHENDRARASAN Mathursan">
    <!-- CSS Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link href="css/style.css" rel="stylesheet">
  </head>
  <?php $pdo = new PDO("mysql:host=localhost;dbname=db_airbnb","root","",array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));?>
  <body>

  <header>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="index.php">AirBnB</a>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="recherche.php">Rechercher une location</a>
          </li>

        <?php session_start();
        if($_SESSION["connecte"]=="true"){ ?> <!-- Si connecté -->
          <li class="nav-item active">
            <a class="nav-link" href="gestionbiens.php">Gestion des annonces</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="compte.php">Gestion du compte</a>
          </li>
        </ul>

        <ul class="navbar-nav mr-sm-2">
          <li class="form-inline my-2 my-lg-0">
            <a class="btn btn-outline-danger my-2 my-sm-0" href="#">Déconnexion</a>
          </li>
        <?php }


        else{ ?> <!-- Si déconnecté -->
        </ul> 
          <ul class="navbar-nav mr-sm-2">
          <li class="form-inline my-2 my-lg-0" style="padding-right : 10px;">
            <a class="btn btn-outline-info my-2 my-sm-0" href="connexion.php">Connexion</a>
          </li>
          <li class="form-inline my-2 my-lg-0">
            <a class="btn btn-outline-info my-2 my-sm-0" href="inscription.php">Inscription</a>
          </li>
        </ul>
        <?php } ?>

        </ul>
      </div>
    </nav>

  </header>

  <main role="main" class="container">