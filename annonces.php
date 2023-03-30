<?php
// Initialize the session
session_start();

require_once "config.php";


$rech='';$pmin='';$pmax='';
$ifpmin = empty($_GET['pmax'])?"":" and prix <= ".$_GET['pmax']."";
$ifpmax = empty($_GET['pmin'])?"":" and prix >= ".$_GET['pmin']."";
$orderby = ' ORDER BY date_publication DESC';

if (!empty($_GET['sort'])) {
  if ($_GET['sort'] == 'prix') {
    $orderby = ' ORDER BY prix ASC';
  }
}

$req = "SELECT *,DATE_FORMAT(`date_publication`, '%Y/%m/%d à %Hh%i') as date FROM annonces" . $orderby;


if (isset($_GET['rech'])) {
  $rech = $_GET['rech'];$pmin = $_GET['pmin'];$pmax = $_GET['pmax'];

  $req = "SELECT *,DATE_FORMAT(`date_publication`, '%Y/%m/%d à %Hh%i') as date FROM annonces WHERE titre like '%" . $rech . "%'" . $ifpmin . $ifpmax . $orderby;
}


$allannonces = mysqli_query($link, $req) or die(mysqli_error($link));;

?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" type="image/x-icon" href="images/favicon.ico">
  <meta charset="UTF-8">
  <title>Annonces - Find for me</title>
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
  <div class="container">
    <form class="row" method="GET">
      <div class="my-3 p-3 bg-light rounded col-9 bg-white border border-primary text-center mx-auto shadow-sm">
        <h5 class="text-orange text-left pl-4 pb-2"><i class="fa fa-search"></i> Recherche :</h5>
                
        <div class="form-row px-4">
          <div class="col-8">
            <input type="text" class="form-control" name="rech" value="<?php echo $rech; ?>" placeholder="Que recherchez-vous ?">
          </div>
          <div class="col">
            <select class="custom-select" id="locality-dropdown" name='ville'>

            </select>
          </div>
        </div>
        <div class="dropdown-divider mb-1 mt-3"></div>

        <p class="text-muted text-right mr-4 my-2" data-toggle="collapse" href="#rechavance" role="button" aria-expanded="false" aria-controls="rechavance">Filtrer
       <i class="fa fa-plus"></i>
       </p>

       <div class="collapse" id="rechavance">
        <div class="card card-body border-0 p-0 px-3">
          <div class="row">
            <div class="form-group form-inline col-4 ml-2">
              <Libelle_acheminement for="prix">Prix :</Libelle_acheminement>
              <input type="text" name="pmin" class="form-control number mx-sm-2 col-4" placeholder="min" >-
              <input type="text" name="pmax" class="form-control number mx-sm-2 col-4" placeholder="max">
            </div>
     
            
            

          </div>
        </div>
      </div>

      <div class="row mt-3">
        <input type="submit" class="btn btn-primary mx-auto" value="Rechercher"></input>
      </div>
    </div>  
  </form>
</div>


<main role="main" class="container">
  <div class="row">
    <div class="my-3 p-3 bg-light rounded col-12">

      <?php
      if (mysqli_num_rows($allannonces) == 0){ ?>
        <div class="text-center bg-white">
          <img src="images/noresult.png">
          <p class="text-muted">Aucun résultat trouvé</p><br>

        </div>
        <br>

      <?php }else{
        ?><ul class="list-group">
          <div class="row">
            <small class="text-muted pt-3 ml-4">Nombre d'annonces : </small><small class="text-orange pt-3 pl-1"> <?php echo mysqli_num_rows(mysqli_query($link,"select * from annonces")); ?></small>
            <div class="ml-auto pr-3">
              <select onchange="location = '?sort=' + this.value;" class="custom-select mb-1 tri" id='tri'>
                <option value="date">Trier Par Date</option>
                <option value="prix">Trier Par Prix</option>
              </select>    
            </div>
          </div>
          <?php
          while ($row = mysqli_fetch_array($allannonces)) {
            $imgs = explode (",", $row['images']); 
            
            echo '<a href="annonce.php?id=' . $row['id_annonce'] . '" class="annoncelist mb-3">'; ?>
            <li class="list-group-item annonce border">
              <div class="media align-items-lg-center flex-column flex-lg-row p-2">
                <div class="media-body order-2 order-lg-2" style=" height: 145px; ">
                  <h5 class="mt-0 font-weight-bold mb-2 text-muted"><?php echo $row['titre']; ?></h5>
                  <p class="font-weight-bold mb-0 small text-orange"><?php echo $row['prix']; ?> € </p>
                  <div class="d-flex align-items-start flex-column" style="height: 97px;">
                    <small class="mt-auto pt-5 font-weight-light text-muted"><?php echo $row['ville']; ?></small>
                    <small class="mb-auto font-weight-light text-muted"><?php echo $row['date']; ?></small>
                  </div>
                </div><div <?php echo "style='background-image: url(upload/" . $imgs[0] . ")'"  ?> class="mr-lg-4 order-1 order-lg-1 anncimg">
                
                </div>
              </li>
            </a>
            <?php 
          }
          ?></ul>
          <div class="row">
            <div class="mr-auto pl-3 text-right">
              <?php echo '<a href="?page=' . ((empty($_GET['page'])? 1 : $_GET['page']) - 1) . '" class="btn btn-primary">Page précedent</a> '; ?>
            </div> 
            <div class="ml-auto pr-3 text-left">
              <?php echo '<a href="?page=" class="btn btn-primary">Page suivant</a> '; ?>
            </div>

          </div>
        <?php }
        ?>

      

    <script type="text/javascript">


      $('input.number').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g,'').replace(/(\..*)\./g, '$1');
      });

      let dropdown = $('#locality-dropdown');
      dropdown.empty();
      dropdown.append('<option value="" selected="true">Toute la France</option>');
      dropdown.prop('selectedIndex', 0);
      const url = 'scripts/france.json';
      $.getJSON(url, function (data) {
        $.each(data, function (key, entry) {
          //console.log(entry)
          dropdown.append($('<option></option>').attr('value', entry.Libelle_acheminement).text(entry.Libelle_acheminement));
        })
      });


      $(function(){
        $('#tri').on('change', function () {
          var url = $(this).val();
          var currenturl = window.location.href;
          if (url) {
            if(currenturl.indexOf('sort') != -1){
              currenturl = removeParam('sort',currenturl);
            }
            if (currenturl.indexOf('?') != -1) { 
              window.location = currenturl + '&sort=' + url;
            } else {
              window.location = currenturl + '?sort=' + url;
            }
          }
          return false;
        });
      });


      function removeParam(key, sourceURL) {
        var rtn = sourceURL.split("?")[0],
        param,
        params_arr = [],
        queryString = (sourceURL.indexOf("?") !== -1) ? sourceURL.split("?")[1] : "";
        if (queryString !== "") {
          params_arr = queryString.split("&");
          for (var i = params_arr.length - 1; i >= 0; i -= 1) {
            param = params_arr[i].split("=")[0];
            if (param === key) {
              params_arr.splice(i, 1);
            }
          }
          rtn = rtn + "?" + params_arr.join("&");
        }
        return rtn;
      }

    </script>
    <script type="text/javascript">
      document.getElementById('tri').value = "<?php echo $_GET['sort'];?>";
    </script>
  </body>
  </html>