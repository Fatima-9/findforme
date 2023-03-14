<?php
session_start();

require_once "config.php";


if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: login.php");
  exit;
}

$annresult = mysqli_query($link, "SELECT * from annonces where id_user='". htmlspecialchars($_SESSION["id"]) ."'");
$nbrannonces = mysqli_num_rows($annresult);
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
        $sql = "INSERT INTO annonces(`id_user`, `titre`, `description`, `prix`, `ville`, `Code Postal`, `adresse`, `num`, `date_publication`, `autre_details`, `images`) VALUES (" . htmlspecialchars($_SESSION["id"]) . " ,'" . $_POST["titre"] . "', '" . addslashes($_POST["textann"]) . "', '" . $_POST["prix"] . "', '" . $_POST["ville"] . "', '" . $_POST["Code Postal"] . "', '" . $_POST["adresse"] . "', '" . $_POST["num"] . "', now() , '" . $_POST["autre"] . "', '" . $_POST["imgs"] . "')";

          if(mysqli_query($link, $sql)){
                header("location: mes_annonces.php");
            }else{
                
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
  <title>Déposer une annonce </title>
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
        <?php if($_SESSION['type'] == 'admin'){
          echo '<a class="nav-link" href="dashboard.php"><i class="fa fa-fw fa-home"></i> Dashboard</a>
                <a class="nav-link active" href="mes_annonces.php"><i class="fa fa-fw fa-bullhorn"></i> Annonces</a>
                <a class="nav-link" href="users.php"><i class="fa fa-fw fa-users"></i> Utilisateurs</a>';
        }else{
          echo '<a class="nav-link active" href="mes_annonces.php"><i class="fa fa-fw fa-bullhorn"></i> Mes annonces
            <span class="badge badge-pill bg-light align-text-bottom">' . $nbrannonces .'</span>';
        }
        ?>
        <a class="nav-link" href="profile.php"><i class="fa fa-fw fa-user"></i> Mon profile</a>
        <a class="nav-link text-danger font-weight-bold" href="logout.php"><i class="fa fa-fw fa-sign-out"></i> Se deconnecter</a>
      </nav>
    </div>
    <div class="my-3 p-3 bg-white rounded shadow-sm">
      <h6 class="border-bottom border-gray pb-2 mb-0"><i class="fa fa-fw fa-bullhorn"></i> Nouvelle annonce :</h6>
      <br>

      <br>

      <div class="container">

        <form id="regForm" method="POST" action="">

          <div style="text-align:center;margin-bottom:40px;display: flex;">
            <div class="step"><span class="num">1</span><br><span class="text">Informations générales</span></div>
            <div class="step"><span class="num">2</span><div class="bar"></div><br><span class="text">Détails de l'annonce</span></div>
            <div class="step"><span class="num">3</span><div class="bar"></div><br><span class="text">Photos de l'annonce</span></div>
            <div class="step"><span class="num">4</span><div class="bar"></div><br><span class="text">Publier l'annonce</span></div>
          
          </div>

          <div class="tab">
            <div class="row">

              <div class="col-6 px-md-5">
                <h3><i class="fa fa-fw fa-info"></i> Informations générales</h3><br>
                
                <div class="form-group">
                  <label for="ville"><span style="color: rgb(209, 54, 73);">*</span> Ville</label>
                  <input type="text" name="ville" class="form-control required">
                </div>
                <div class="form-group">
                  <label for="Code Postal"><span style="color: rgb(209, 54, 73);">*</span> Code Postal</label>
                  <input type="text" name="Code Postal" class="form-control required">
                </div>
                <div class="form-group">
                  <label for="Adresse">Adresse</label>
                  <input type="text" name="adresse" class="form-control">
                </div>

                <br>
                <p>les champs avec (<span style="color: rgb(209, 54, 73);">*</span>) sont obligatoires</p>


              </div>
              <div class="col-6 px-md-5 pt-5">
                <img class="mt-5" src="images/ajouter.svg" height="300px">
              </div>
            </div>
          </div>

          <div class="tab">


            <div class="row px-md-5">
              <h3><i class="fa fa-fw fa-align-left"></i> Description de l'annonce</h3>
            </div>
            <br>
            <div class="row px-md-5">
              <div class="col-md-6">

                <div class="form-group">
                  <label for="titre"><span style="color: rgb(209, 54, 73);">*</span> Titre de l'annonce</label>
                  <input type="text" class="form-control required" name="titre" placeholder="Titre de l'annonce" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="prix"><span style="color: rgb(209, 54, 73);">*</span> Prix (€)</label>
                  <input type="number" class="form-control required" name="prix" placeholder="0" id="number" min="0" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="textann"><span style="color: rgb(209, 54, 73);">*</span> Texte de l’annonce</label>
                  <textarea class="form-control required" name="textann" rows="7" required></textarea>
                </div>
              </div>
            </div>

           
            
            <br>
            <div class="dropdown-divider" style=" border-bottom: 1px solid #e9ecef; "></div><br>

            <div class="row px-md-5">
              <h3><i class="fa fa-fw fa-phone"></i> Informations de contact</h3><br><br>
            </div><br>
            <div class="row px-md-5">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="num"><span style="color: rgb(209, 54, 73);">*</span> Numero de téléphone </label>
                  <input type="number" id="num" class="form-control required " name="num" placeholder="0666666666" required>
                </div>
              </div>
            </div>

          </div>

          <div class="tab">

                <div class="row px-md-5">
                  <h3><i class="fa fa-fw fa-camera"></i> Photos</h3><br><br>
                </div><br>
                
                  <div class="row px-md-5">
                    <div class="col-6 col-md-4"><i class="fa fa-fw fa-exclamation"></i>Photos (5 maximum)</div>
                  </div>
                    <div class="container">
                      <div class="text-center">
                        <button type="button" id="btnupload" class="upload_btn border-primary"><i class="fa fa-fw fa-camera"></i> <br>Ajouter</button>
                      </div>
                      <br><br>
                      <div class="row px-md-5" id="gallery"></div>  
                       
                  <br/><br/>  
                </div>  
                 


          </div>

          <div class="tab">

              <div class="text-center">
                <img src="images/done.png" height="100px"></img><br>

                <button type="submit" class="btn btn-rounded btn-outline-success mt-4">Publier mon annonce</button>
              </div>

          </div>  

          <div style="overflow:auto;margin-top: -50px;margin-right: 28px;">
            <div style="float:right;">
              <button type="button" class="btn btn-primary" id="prevBtn" onclick="nextPrev(-1)">Précedent</button>
              <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextPrev(1)">Suivant</button>
            </div>
          </div>


        </form>


      </div>





    </div>

    <script src="scripts/mdp.js"></script>

  </main>
  <script src="scripts/mdp.js"></script>

<div style="visibility: hidden">  
    <form method="post" id="upload_form">   
      <input type="file" name="images[]" id="select_image" accept="image/*" multiple />  
    </form> 
 </div>  
 <script> 

 (function($){
    $('#btnupload').click(function(){ 
        $('#select_image').click();
    });
})(jQuery);

 $(document).ready(function(){  
      $('#select_image').change(function(){3  
           $('#upload_form').submit();  
      });  
      $('#upload_form').on('submit', function(e){  
           e.preventDefault();  
           $.ajax({  
                url :"upload.php",  
                method:"POST",  
                data:new FormData(this),  
                contentType:false,  
                processData:false,  
                success:function(data){  
                     $('#select_image').val('');  
                     $('#uploadModal').modal('hide');  
                     $('#gallery').html(data);  
                     $("#btnupload").html('<i class="fa fa-fw fa-camera"></i><br>Changer');
                }  
           })  
      });  
 });  
 </script>  

  <script type="text/javascript">
  var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  // This function will display the specified tab of the form ...
  var x = document.getElementsByClassName("tab");
  x[n].style.display = "block";
  // ... and fix the Previous/Next buttons:
  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
  }
  if (n == (x.length - 1)) {
    //document.getElementById("nextBtn").innerHTML = "Publier";
    document.getElementById("nextBtn").style.display = "none";
    document.getElementById("prevBtn").style.display = "none";


  } else {
    document.getElementById("nextBtn").innerHTML = "Suivant";
  } 



  //if (document.getElementById("nextBtn").innerHTML == "Publier") {
        //document.getElementById("nextBtn").type = "submit";
  //}
  // ... and run a function that displays the correct step indicator:
  fixStepIndicator(n)
}

function nextPrev(n) {
  // This function will figure out which tab to display
  var x = document.getElementsByClassName("tab");
  // Exit the function if any field in the current tab is invalid:
  if (n == 1 && !validateForm()) return false;
  // Hide the current tab:
  x[currentTab].style.display = "none";
  // Increase or decrease the current tab by 1:
  currentTab = currentTab + n;
  // if you have reached the end of the form... :
  if (currentTab >= x.length) {
    //...the form gets submitted:
    document.getElementById("regForm").submit();
    return false;
  }
  
  // Otherwise, display the correct tab:
  showTab(currentTab);
}

function validateForm() {
  // This function deals with validation of the form fields
  var x, y, i, valid = true;
  let num = document.getElementById("num")
  if(currentTab==1){
    if(num?.value?.length != 10){
      num.className += "invalid";
      valid = false;
    }
  }
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByClassName("required");
  // A loop that checks every input field in the current tab:
  
  for (i = 0; i < y.length; i++) {
    // If a field is empty...
    if (y[i].value == "") {
      // add an "invalid" class to the field:
      y[i].className += " invalid";
      // and set the current valid status to false:
      valid = false;
    }
  }
  // If the valid status is true, mark the step as finished and valid:
  if (valid) {
    document.getElementsByClassName("num")[currentTab].className += " finish";
    document.getElementsByClassName("bar")[currentTab].className += " finish";


  }
  return valid; // return the valid status
}

function fixStepIndicator(n) {
  // This function removes the "active" class of all steps...
  var i, x = document.getElementsByClassName("num");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  //... and adds the "active" class to the current step:
  x[n].className += " active";
}
</script>


<script type="text/javascript">
var number = document.getElementById('number');
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