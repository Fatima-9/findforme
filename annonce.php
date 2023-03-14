<?php
// Initialize the session
session_start();

require_once "config.php";


$annonce = mysqli_query($link, "Select *,DATE_FORMAT(`date_publication`, '%Y/%m/%d à %Hh%i') as date, annonces.ville from annonces, utilisateur where id_annonce = " . $_GET['id'] . "");

$result = mysqli_fetch_assoc($annonce);

$imgs = explode(",", $result['images']);
$imgs = str_replace(' ', '', $imgs);


if (empty($_GET) || mysqli_num_rows($annonce) == 0) {
  header("location: annonces.php");
  exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
<link rel="icon" type="image/x-icon" href="images/favicon.ico">
  <meta charset="UTF-8">
  <title><?php echo $result['titre']; ?> - Find for me</title>
  <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/font.css">
  <link rel="stylesheet" href="css/all.min.css">
  <script src="scripts/jquery.min.js"></script>
  <script src="scripts/bootstrap.min.js"></script>

</head>

<body class="bg-light">

  <?php include('header.php'); ?>

  <br>

  <main role="main" class="container">
    <div class="row">
      <div class="my-3 bg-light rounded col-8">
        <div class="bg-white shadow-sm pb-3">
          <div id="lesimages" class="carousel slide" data-ride="carousel">

            <ol class="carousel-indicators m-0">
              <?php
              foreach ($imgs as $i => $img) {
                echo "<li data-target='#lesimages' data-slide-to='" . $i . "'></li>";
              }
              ?>
            </ol>

            <div class="carousel-inner">
              <?php
              echo "<div class='carousel-item active'>
              <img src='upload/" . $imgs[0] . "' class='d-block mx-auto' alt='TEST'>
              </div>";
              for ($i = 1; $i < count($imgs); $i++) {
                echo "<div class='carousel-item'>
                <img src='upload/" . $imgs[$i] . "' class='d-block mx-auto' alt='TEST'>
                </div>";
              }
              ?>
            </div>
            <div class="bgshadow"></div>
            <a class="carousel-control-prev" href="#lesimages" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon rounded-circle bg-secondary p-2" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#lesimages" role="button" data-slide="next">
              <span class="carousel-control-next-icon rounded-circle bg-secondary p-2" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
          <h5 class="px-4 pt-5 pb-3"><?php echo $result['titre']; ?></h5>
          <h5 class="px-4 pb-0 text-orange"><?php echo $result['prix']; ?> € </h5>
          <small class="px-4 mb-3"><?php echo $result['date']; ?></small>

        </div>
        <br>

        <br>
        <div class="bg-white p-3 shadow-sm">
          <div class="row">
            <div class="col-7">
              <h6 class="border-bottom border-gray pb-2 mb-0 font-weight-bold"><i class="fa fa-fw fa-info text-primary"></i> Description :</h6>
              <p class="p-3"><?php echo nl2br(htmlentities($result['description'], ENT_QUOTES, 'UTF-8')); ?></p>
            </div>
            <div class="col border-left">
              <h6 class="border-bottom border-gray pb-2 mb-0 font-weight-bold"><i class="fa fa-fw fa-map-marker text-primary"></i> Adresse :</h6>
              <p class="text-muted pt-3">Ville : <?php echo $result['ville']; ?></p>
              <p class="text-muted">Secteur : <?php echo $result['secteur']; ?></p>
              <p class="text-muted">Adresse : <?php echo $result['adresse']; ?></p>
            </div>

          </div>
        </div>
        <br>
      </div>
      <div class="my-3 bg-light rounded col-4">
        <div class="bg-white">
          <div class="panel widget">
            <div class="widget-header bg-info"></div>
            <div class="widget-body text-center">
              <img alt="Profile Picture" class="widget-img rounded-circle img-circle img-border-light" src="images/user.png">
              <h4 class="mar-no"><?php echo $result['nom']; ?></h4>
              <div class="row">
                <button class="btn btn-orange col mx-5 mt-2" id="voirnum"><i class="fa fa-phone pr-2"></i>Afficher le numéro</button>
              </div>
            </div>
          </div>
          
          
          <a href="favoris.php?id=<?php echo $result['id_annonce']; ?>"> <button class="btn btn-orange col mx-5 mt-2"><i class="fa fa-star pr-2"></i>Ajouter</button>
          
          <a href="favoris.php?id=<?php echo $result['id_annonce']; ?>"> <button class="btn btn-orange col mx-5 mt-2"><i class="fa-solid fa-message"></i>contacter</button>
          </a>
        </a>
        </div>
      </div>
    </div>
  </main>

  <script type="text/javascript">
    $('#voirnum').click(function() {
      var $this = $(this);
      $this.text('<?php echo $result['num']; ?>');
    });
  </script>
</body>

</html>