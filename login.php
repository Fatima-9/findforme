<?php

session_start();

if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: mes_annonces.php");
    exit;
}

require_once "config.php";

$email = "";
$password = "";
$errmsg = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $email = $_POST["email"];
    $password = $_POST["password"];

    if(!empty($cin) || !empty($password)){
        $sql = "Select * from utilisateur where email = '$email'";
        $result = mysqli_query($link, $sql);
        $qry = mysqli_fetch_assoc($result);
        if (password_verify($password, $qry['mdp'])) {
            session_start();
            $_SESSION["loggedin"] = true;
            $_SESSION["email"] = $email;   
            $_SESSION["type"] = $qry['type'];  
            $_SESSION["nom"] = $qry['nom'];  
            $_SESSION["id"] = $qry['id'];  
            if($qry['type'] == 'admin'){
                header("location: dashboard.php");
            }else{
                header("location: mes_annonces.php");
            }
        }else{
            $errmsg = "<div class='alert alert-danger' role='alert'>Les données sont incorrects ! </div>";
        }

    }else{
        $errmsg = "<div class='alert alert-danger' role='alert'> Remplir tous les champs ! </div>s";
    }
    
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/all.min.css">
    <script src="scripts/jquery.min.js"></script>
    <script src="scripts/bootstrap.min.js"></script>
    <title>Se connecter - leboncoin</title>
</head>
<body>

    <?php include('header.php'); ?>

    <div class="container login-container">

      <div class="login-form shadow-sm">

        <div class="text-center">
            <h2>Bonjour</h2>
            <p>Connectez-vous à votre compte</p>
        </div>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-signin">
            <?php echo $errmsg; ?>
            <label for="inputemail">Email</label>
            <input type="email" id="inputemail" class="form-control" name="email" required autofocus>
            <label for="inputPassword" >Mot de passe</label>
            <input type="password" id="inputPassword" class="form-control" name="password" required>
            <button class="btn btn-primary btn-block" type="submit">Se connecter</button>
            <br>
            <div class="dropdown-divider mb-3"></div>
            <p>Pas encore inscrit? <a href="register.php"> S'inscrire gratuitement</a>.</p>
        </form>
    </div>  
    <div class="loginbg"></div>    
</div> 


</body>
</html>
