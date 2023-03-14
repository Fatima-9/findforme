<?php
session_start();


require_once "config.php";
?>
<!DOCTYPE html>
<html>
<head>

<link rel="icon" type="image/x-icon" href="images/favicon.ico">
	<title>Find for me </title>
 <meta charset="utf-8">
 <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
 <link rel="stylesheet" href="css/style.css">
 <link rel="stylesheet" href="css/font.css">
 <link rel="stylesheet" href="css/all.min.css">
 <script src="scripts/jquery.min.js"></script>
 <script src="scripts/bootstrap.min.js"></script>
 
</head>
<body>
	<?php include 'header.php' ?>
	<section class="loca-header mt-5 pt-5">
    <div class="container">
      <div class="row align-items-center text-center text-md-left">
        <div class="col-md-6 col-lg-5 mb-5 mb-md-0">
          <h1><marquee>Trouvez ce que vous chercher facilement.</marquee></h1>
          <p>Que cherchez vous ?<br>
          Vêtements , Vente immo , Voitures , Ameublements , Electroménager , Décoration , Informatique , Livres ...</p>
          <a class="btn btn-orange mt-4" href="aj_annonce.php"><i class="fa fa-edit"></i> Déposer votre annonce gratuitement</a>
          <a class="btn btn-outline-primary mt-4" href="annonces.php"><i class="fa fa-plus"></i> Découvrir les annonces</a>
        </div>
        <div class="col-md-6 col-lg-7 col-xl-6 offset-xl-1">
          <img class="img-fluid" src="images/colocation.png" alt="">
        </div>
      </div>
    </div>
  </section>

</body>

</html>

