<?php
// Initialize the session
session_start();
require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
  header("location: login.php");
  exit;
}

$id = $_SESSION["id"];

$msg = "";
$msgpw = "";

if (isset($_POST['editinfo'])) {
  $nom = $_POST['nom'];
  $email = $_POST['email'];
  $ville = $_POST['ville'];
  $tel = $_POST['tel'];
  $datnaiss = $_POST['datnaiss'];

  $sql = "Update utilisateur set nom ='$nom', email = '$email', ville = '$ville', tel = '$tel',  datnaiss = '$datnaiss' where id = $id";
  if (mysqli_query($link, $sql)) {
    $msg = "<div class='alert alert-success' role='alert'>Informations modifié avec succès</div>";
  } else {
    $msg = "<div class='alert alert-danger' role='alert'>Erreur : Veuillez réessayer ultérieurement !</div>";
  }
}
if (isset($_POST['editpw'])) {
  $new = $_POST['new'];
  $neww = $_POST['neww'];

  $sql = "SELECT mdp FROM utilisateur where id ='$id'";
  $resultpw = $link->query($sql);
  $pwrow = $resultpw->fetch_assoc();
  if ($new == $neww) {
    $sql = "Update utilisateur set mdp = '" . password_hash($new, PASSWORD_DEFAULT) . "' where id = '$id'";
    if (mysqli_query($link, $sql)) {
      $msgpw = "<div class='alert alert-success' role='alert'>Mot de passe modifié avec succès</div>";
    } else {
      $msgpw = "<div class='alert alert-danger' role='alert'>Erreur : Veuillez réessayer ultérieurement !</div>";
    }
  } else {
    $msgpw = "<div class='alert alert-danger' role='alert'>Erreur : Le mot de passe et la confirmation ne correspondent pas !</div>";
  }
}

$sql = "SELECT * FROM utilisateur where id ='$id'";
$result = $link->query($sql);
$row = $result->fetch_assoc();

$annresult = mysqli_query($link, "SELECT * from annonces where id_user='" . htmlspecialchars($_SESSION["id"]) . "'");
$nbrannonces = mysqli_num_rows($annresult);

?>

<!DOCTYPE html>
<html lang="en">

<head>
<link rel="icon" type="image/x-icon" href="images/favicon.ico">
  <meta charset="UTF-8">
  <title>Mon profile - Find for me</title>
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
        <?php if ($_SESSION['type'] == 'admin') {
          echo '<a class="nav-link" href="dashboard.php"><i class="fa fa-fw fa-home"></i> Dashboard</a>
              <a class="nav-link" href="mes_annonces.php"><i class="fa fa-fw fa-bullhorn"></i> Annonces</a>
              <a class="nav-link" href="users.php"><i class="fa fa-fw fa-users"></i> Utilisateurs</a>';
        } else {
          echo '<a class="nav-link" href="mes_annonces.php"><i class="fa fa-fw fa-bullhorn"></i> Mes annonces
              <span class="badge badge-pill bg-light align-text-bottom">' . $nbrannonces . '</span>';
        }
        ?>
        <a class="nav-link" href="mes_favoris.php"><i class="fa fa-fw fa-star"></i> Mes favoris</a>
        <a class="nav-link active" href="profile.php"><i class="fa fa-fw fa-user"></i> Mon profile</a>
   

        <a class="nav-link text-danger font-weight-bold" href="logout.php"><i class="fa fa-fw fa-sign-out-alt"></i> Se deconnecter</a>
      </nav>
    </div>
    <div class="my-3 p-3 bg-white rounded shadow-sm">
      <h6 class="border-bottom border-gray pb-2 mb-0"><i class="fa fa-fw fa-user"></i> Mon profile :</h6>
      <br><br>
      <div class="row">
        <div class="col-6 px-md-5">
          <div class="p-3 border bg-light">

            <h6 class="border-bottom border-gray pb-2 mb-0"><i class="fa fa-fw fa-arrow-circle-right"></i> Modifier mes informations personnels :</h6><br>
            <?php echo $msg; ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">



              <div class="form-group row">
                <label for="nom" class="col-sm-3 col-form-label">Nom</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="nom" id="nom" value="<?php echo $row['nom']; ?>" required>
                </div>
              </div>

              <div class="form-group row">
                <label for="email" class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-9">
                  <input type="email" class="form-control" name="email" id="email" value="<?php echo $row['email']; ?>" required>
                </div>
              </div>

              <div class="form-group row">
              <label for="ville" class="col-sm-3 col-form-label">ville</label>
              <div class="col-sm-9">
              <input type="ville" class="form-control" name="ville" id="ville" value="<?php echo $row['ville']; ?>" required>
                </div>
              </div>

              <div class="form-group row">
                <label for="tel" class="col-sm-3 col-form-label">Tél</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" name="tel" id="tel" value="<?php echo $row['tel']; ?>" required>
                </div>
              </div>



              <div class="form-group row">
                <label for="datnaiss" class="col-sm-4 col-form-label">Date naissance</label>
                <div class="col-sm-8">
                  <input type="date" class="form-control" name="datnaiss" id="datnaiss" value="<?php echo $row['datnaiss']; ?>" required>
                </div>
              </div>
              <div class="form-group">
                <input type="submit" name="editinfo" class="btn btn-primary" value="Modifier les informations">
              </div>
            </form>
          </div>
        </div>
        <div class="col-6 px-md-5">
          <div class="p-3 border bg-light">
            <h6 class="border-bottom border-gray pb-2 mb-0"><i class="fa fa-fw fa-arrow-circle-right"></i> Modifier mon mot de passe :</h6><br>
            <?php echo $msgpw; ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

              <div class="form-group">
                <input type="Password" class="form-control" name="new" placeholder="Nouveau mot de passe *" value="" required>
              </div>
              <div class="form-group">
                <input type="Password" class="form-control" name="neww" placeholder="Confirmer le nouveau mot de passe *" value="" required>
              </div>
              <div class="form-group">
                <input type="submit" name="editpw" class="btn btn-primary" value="Modifier le mot de passe">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>



  </main>

  <script type="text/javascript">
    let dropdown = $('#locality-dropdown');
    dropdown.empty();
    dropdown.prop('selectedIndex', 0);
    const url = 'scripts/maroc.json';
    $.getJSON(url, function(data) {
      $.each(data, function(key, entry) {
        dropdown.append($('<option></option>').attr('value', entry).text(entry));
      })
    });

    setTimeout(function() {
      $('#locality-dropdown').val("<?php echo $row['ville']; ?>");
    }, 100);


    var number = document.getElementById('tel');
    number.onkeydown = function(e) {
      if (!((e.keyCode > 95 && e.keyCode < 106) ||
          (e.keyCode > 47 && e.keyCode < 58) ||
          e.keyCode == 8)) {
        return false;
      }
    }
  </script>

</body>

</html>