<?php
session_start();
require_once "config.php";

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["type"] != "admin"){
  header("location: login.php");
  exit;
}

$msg = "";


$id = $_GET['id'];
$rslt = mysqli_fetch_assoc(mysqli_query($link, "SELECT * from utilisateur where id = '$id'"));


if(isset($_POST['edit'])){

  $nom = $_POST['nom'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $ville=$_POST['ville'];
  $tel = $_POST['tel'];
  $datnaiss = $_POST['datnaiss'];
  $genre = $_POST['genre'];
  $role = $_POST['role'];

  $sql = "UPDATE `utilisateur` SET `nom` = '$nom', `email` = '$email', `genre` = '$genre', `ville` = '$ville', `tel` = '$tel', `datnaiss` = '$datnaiss', `type` = '$role' WHERE `utilisateur`.`id` = '$id'";

  if(mysqli_query($link, $sql)){
    $msg = "<div class='alert alert-success' role='alert'>Informations modifié avec succès</div>";
    $rslt = mysqli_fetch_assoc(mysqli_query($link, "SELECT * from utilisateur where id = '$id'"));

  }else{
    $msg = "<div class='alert alert-danger' role='alert'>Erreur : Veuillez réessayer ultérieurement !</div>";
  }


  mysqli_close($link);

}


if(!isset($_GET['id'])){
  header("location: users.php");
  exit;
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Ajouter un utilisateur - Find for me</title>
  <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/font.css">
  <link rel="stylesheet" href="css/all.min.css">
  <script src="scripts/jquery.min.js"></script>
  <script src="scripts/bootstrap.min.js"></script>




</head>
<link rel="icon" type="image/x-icon" href="images/favicon.ico">
<body class="bg-light">

  <?php include('header.php'); ?>

  <br>


  <main role="main" class="container">
    <div class="nav-scroller bg-white shadow-sm">
      <div class="nav-scroller bg-white shadow-sm">
        <nav class="nav nav-underline">
          <a class="nav-link" href="dashboard.php"><i class="fa fa-fw fa-home"></i> Dashboard</a>
          <a class="nav-link" href="mes_annonces.php"><i class="fa fa-fw fa-bullhorn"></i> Annonces</a>
          <a class="nav-link active" href="users.php"><i class="fa fa-fw fa-users"></i> Utilisateurs</a>
          <a class="nav-link" href="profile.php"><i class="fa fa-fw fa-user"></i> Mon profile</a>
          <a class="nav-link text-danger font-weight-bold" href="logout.php"><i class="fa fa-fw fa-sign-out-alt"></i> Se deconnecter</a>
        </nav>
      </div>
    </div>
    <div class="my-3 p-3 bg-white rounded shadow-sm">
      <h6 class="border-bottom border-gray pb-2 mb-0"><i class="fa fa-fw fa-user"></i> Ajouter un utilisateur :</h6>
      <br><br>
      <?php echo $msg; ?>
      <form action="edit_user.php?id=<?php echo $_GET['id']; ?>" method="post">
        <div class="row p-3 border bg-light m-3">
          <div class="col-6 px-md-5">

            <div class="form-group row">
              <label for="cin" class="col-sm-3 col-form-label">ID</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="cin" id="cin" value="<?php echo $rslt['id']; ?>" disabled required>
              </div>
            </div>

            <div class="form-group row">
              <label for="nom" class="col-sm-3 col-form-label">Nom</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" name="nom" id="nom" value="<?php echo $rslt['nom']; ?>" required>
              </div>
            </div>

            <div class="form-group row">
              <label for="email" class="col-sm-3 col-form-label">Email</label>
              <div class="col-sm-9">
                <input type="email" class="form-control" name="email" id="email" value="<?php echo $rslt['email']; ?>" required>
              </div>
            </div>

            

            <div class="form-group row">
              <label for="tel" class="col-sm-3 col-form-label">Tél</label>
              <div class="col-sm-9">
                <input type="text" maxlength="10" class="form-control" name="tel" id="tel" value="<?php echo $rslt['tel']; ?>" required>
              </div>
            </div>

            <div class="form-group row">
              <label for="role" class="col-sm-3 col-form-label">Genre</label>
              <div class="col-sm-9">
                <select class="form-control" name="genre" id="genre">
                  <option value="Homme">Homme</option>
                  <option value="Femme">Femme</option>
                </select>
              </div>
            </div>

          </div>  
          <div class="col-6 px-md-5 ">
            <div class="form-group row">
              <label for="ville" class="col-sm-3 col-form-label">Ville</label>
              <div class="col-sm-9">
                <select class="custom-select" id="locality-dropdown" name='ville'>
                </select>
              </div>
            </div>

            
          
            <div class="form-group row">
              <label for="datnaiss" class="col-sm-4 col-form-label">Date naissance</label>
              <div class="col-sm-8">
                <input type="date" class="form-control" name="datnaiss" id="datnaiss" value="<?php echo $rslt['datnaiss']; ?>" required>
              </div>
            </div>

            <div class="form-group row">
              <label for="role" class="col-sm-3 col-form-label">Role</label>
              <div class="col-sm-9">
                <select class="form-control" name="role" id="role">
                  <option value="user">user</option>
                  <option value="admin">admin</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <div class="row justify-content-md-center">
          <div class="form-group">
            <input type="submit" name="edit" class="btn btn-primary px-5" value="Modifier">
          </div>
        </div>
      </form>
    </div>
  </main>


  <script type="text/javascript">
    let dropdown = $('#locality-dropdown');
    dropdown.empty();
    dropdown.prop('selectedIndex', 0);
    const url = 'scripts/maroc.json';
    $.getJSON(url, function (data) {
      $.each(data, function (key, entry) {
        dropdown.append($('<option></option>').attr('value', entry).text(entry));
      })
    });

    setTimeout(function(){
     $('#locality-dropdown').val("<?php echo $rslt['ville'];?>");
     $('#role').val("<?php echo $rslt['type'];?>");
     $('#genre').val("<?php echo $rslt['genre'];?>");
   }, 100); 
    

    var number = document.getElementById('tel');
    number.onkeydown = function(e) {
      if(!((e.keyCode > 95 && e.keyCode < 106)
        || (e.keyCode > 47 && e.keyCode < 58) 
        || e.keyCode == 8)) {
        return false;
    }
  }

</script>

</body>
</html>