<?php
// Include config file
require_once "config.php";


$nom = "";
$email = "";
$password = "";
$ville="";
$tel = "";
$datnaiss = "";
$genre = "";
$errmsg = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $ville=$_POST['ville'];
    $tel = $_POST['tel'];
    $datnaiss = $_POST['datnaiss'];
    $genre = $_POST['gender'];

    $sql = "INSERT INTO utilisateur(nom,email,genre,mdp,ville,tel,datnaiss,type) VALUES ('$nom', '$email', '$genre', '$password', '$ville', '$tel', '$datnaiss','user')";
    if(mysqli_query($link, $sql)){
        header("location: login.php");
    }else{
        if (mysqli_errno($link) == 1062) {
            $errmsg = "<div class='alert alert-danger' role='alert'>Erreur : email déja existe !</div>";
        }
            echo("Error description: " . $link -> error);
    }
    
    mysqli_close($link);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/all.min.css">
    <script src="scripts/jquery.min.js"></script>
    <script src="scripts/bootstrap.min.js"></script>

    <style>
        .btn-primary{
            float: right !important;
            border-radius: 20px !important;
        }
    </style>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="container login-container">
        <div class="text-center">
            <div class="form-register shadow-sm">
            <div id="resultat"><?= $errmsg ?></div>
                <h2>Sign Up</h2>
                <p>Please fill this form to create an account.</p>
                <form name="register" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="row register-form">
                    <div class="col-md-6">
                        
                        <div class="form-group">
                            <input type="text" class="form-control" name="nom" placeholder="Nom complete *" value="<?php echo $nom;?>" required>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" placeholder="Email *" value="<?php echo $email;?>" required>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="password" placeholder="Mot de passe *" value="<?php echo $password;?>" required>
                        </div>
                        
                        <div class="form-group">
                            <div class="maxl" style=" float: left; ">
                                <label class="radio inline"> 
                                    <input type="radio" name="gender" value="Homme" checked="true">
                                    <span> Homme </span> 
                                </label>
                                <label class="radio inline"> 
                                    <input type="radio" name="gender" value="Femme">
                                    <span> Femme </span> 
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <input type="text" class="form-control" name="ville" placeholder="Ville *" value="<?php echo $ville;?>" required>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-control" name="tel" placeholder="Telephone *" value="<?php echo $tel;?>" required>
                        </div>
                        <div class="form-group">
                            <input type="date" class="form-control" name="datnaiss" placeholder="Date de naissance *" value="<?php echo $datnaiss;?>" required>
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary" value="Créer un compte !">
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <div class="loginbg"></div>

    </div>  
    <script src="scripts/mdp.js"></script>

</body>
</html>