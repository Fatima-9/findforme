<?php
session_start();


require_once "config.php";

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["type"] != "admin"){
  header("location: login.php");
  exit;
}




$nbannonces = mysqli_fetch_assoc(mysqli_query($link, "select count(*) as nb from annonces "));
$nbusr = mysqli_fetch_assoc(mysqli_query($link, "select count(*) as nb from utilisateur"));
$latest = mysqli_query($link, "select annonces.*,utilisateur.nom from annonces,utilisateur where annonces.id_user = utilisateur.id order by id_annonce DESC LIMIT 5");

?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" type="image/x-icon" href="images/favicon.ico">
  <meta charset="UTF-8">
  <title>Dashboard - Find to me</title>
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
    <div class="nav-scroller bg-white shadow-sm">
      <nav class="nav nav-underline">
        <a class="nav-link active" href="dashboard.php"><i class="fa fa-fw fa-home"></i> Dashboard</a>
        <a class="nav-link" href="mes_annonces.php"><i class="fa fa-fw fa-bullhorn"></i> Annonces</a>
        <a class="nav-link" href="users.php"><i class="fa fa-fw fa-users"></i> Utilisateurs</a>
        <a class="nav-link" href="profile.php"><i class="fa fa-fw fa-user"></i> Mon profile</a>
        <a class="nav-link text-danger font-weight-bold" href="logout.php"><i class="fa fa-fw fa-sign-out-alt"></i> Se deconnecter</a>
      </nav>
    </div>
    <div class="my-3 p-3 bg-white rounded shadow-sm">
      <h6 class="border-bottom border-gray pb-2 mb-0"><i class="fa fa-fw fa-home"></i> Dashboard :</h6>
      <div class="page-header">
        <div class="row mt-4">
          <div class="col-lg-6 col-xl-4"><h5><i class="fas fa-chart-bar"></i> Les statistiques : </h5></div>
        </div>
        <div class="row mt-2">

          
          <div class="col-lg-6 col-xl-4">
            <div class="card m-b-30 shadow-sm" style="background-color: #e0efff;">
              <div class="card-body pb-2">
                <div class="row">
                  <div class="col-10 text-left">
                    <h5 class="card-title font-14 text-muted">totale des annonces</h5>
                    <h4 class="mb-0 font-30"><?php echo $nbannonces['nb']; ?></h4>
                  </div>
                  <div class="col-2 px-0">
                    <span class="badge-primary px-3 py-2 rounded"><i class="fas fa-bullhorn"></i></span>
                  </div>
                </div>
              </div>
              <div class="card-footer">
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-xl-4">
            <div class="card m-b-30 shadow-sm" style="background-color: #e9fdf2;">
              <div class="card-body pb-2">
                <div class="row">
                  <div class="col-9 text-left">
                    <h5 class="card-title font-14 text-muted">Total d'utilisateurs</h5>
                    <h4 class="mb-0 font-30"><?php echo $nbusr['nb']; ?></h4>
                  </div>
                  <div class="col-3">
                    <span class="badge-success px-3 py-2 rounded"><i class="fas fa-users"></i></span>
                  </div>
                </div>
              </div>
              <div class="card-footer">
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-4">
          <div class="col-lg-6 col-xl-4"><h5><i class="fas fa-clock"></i> Les 5 derniers annonces : </h5></div>
        </div>
        <div class="row mt-2">
          <div class="col-lg-8">
            <table class="table">
              <thead class="thead-light">
                <tr>
    
                  <th scope="col">Titre de l'annonce</th>
                  <th scope="col">Publié par</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = mysqli_fetch_array($latest)) { ?>
                  <tr class='clickable-row' data-href='annonce.php?id=<?php echo $row['id_annonce']; ?>'>
                    
                    <td class="text-orange"><?php echo $row['titre']; ?></a></td>
                    <td><?php echo $row['nom']; ?></td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script type="text/javascript">
    jQuery(document).ready(function($) {
      $(".clickable-row").click(function() {
        window.location = $(this).data("href");
      });
    });
  </script>
</body>
</html>