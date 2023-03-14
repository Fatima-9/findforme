
<nav class="navbar navbar-expand-lg p-3 px-md-4 mb-3 navbar-light bg-white shadow-sm">
  <a class="navbar-brand" href="index.php">
    <div>
      <img src="images/logoo.png" height="40px">
    </div>
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active mr-3 pt-1">
        <a class="nav-link" href="index.php"><i class="fa fa-home"></i> Accueil <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item mr-3 pt-1">
        <a class="nav-link" href="annonces.php"><i class="fa fa-bullhorn"></i> Annonces</a>
      </li>
    </ul>


    <?php if(isset($_SESSION["loggedin"])){
      if($_SESSION["type"] == "admin"){
        ?> <a class="btn btn-outline-primary mr-2" href="dashboard.php"><i class="fa fa-user"></i> Administration</a> 
        <a class="btn btn-danger" href="logout.php"><i class="fa fa-sign-out-alt"></i> Se deconnecter</a> 
      <?php }
      else{
      ?> 
      <div class="mr-2 btn-group">
        <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $_SESSION["nom"]; ?> 
        </button>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="mes_annonces.php">Mes annonces</a>
          <a class="dropdown-item" href="profile.php">Mon profile</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="logout.php">Se deconnecter</a>
        </div>
      </div>
      <a class="btn btn-orange" href="aj_annonce.php"><i class="fa fa-edit"></i> Déposer une annonce</a>

      <?php
    }}
    else{ ?>
      <a class="mr-4 text-dark btn btn-outline-light" href="login.php"><i class="fa fa-user"></i> Se connecter</a>
      <a class="btn btn-orange" href="aj_annonce.php"><i class="fa fa-edit"></i> Déposer une annonce</a>
       <?php
    }?>

    

  </div>
</nav>
