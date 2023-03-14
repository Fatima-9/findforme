<?php
session_start();

require_once "config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

if ($_SESSION["type"] == "admin") {
    $annresult = mysqli_query($link, "SELECT * from annonces ORDER BY id_annonce DESC");
} else {
    $annresult = mysqli_query($link, "SELECT * from annonces where id_user=" . htmlspecialchars($_SESSION["id"]) . "  ORDER BY id_annonce DESC");
}
$nbrannonces = mysqli_num_rows($annresult);

?>

<!DOCTYPE html>
<html lang="en">

<head>
<link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <meta charset="UTF-8">
    <title><?php echo ($_SESSION["type"] == "admin") ? "Annonces - Find for me" : "Mes annonces - Find for me" ?></title>
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/all.min.css">
    <script src="scripts/jquery.min.js"></script>
    <script src="scripts/bootstrap.min.js"></script>
    <script src="scripts/bootbox.min.js"></script>

</head>

<body class="bg-light">

    <?php include('header.php'); ?>

    <br>





    <main role="main" class="container">
        <div class="nav-scroller bg-white shadow-sm">
            <nav class="nav nav-underline">
                <?php if ($_SESSION['type'] == 'admin') {
                    echo '<a class="nav-link" href="dashboard.php"><i class="fa fa-fw fa-home"></i> Dashboard</a>
              <a class="nav-link active" href="mes_annonces.php"><i class="fa fa-fw fa-bullhorn"></i> Annonces</a>
              <a class="nav-link" href="users.php"><i class="fa fa-fw fa-users"></i> Utilisateurs</a>';
                } else {
                    echo '<a class="nav-link active" href="mes_annonces.php"><i class="fa fa-fw fa-bullhorn"></i> Mes annonces
              <span class="badge badge-pill bg-light align-text-bottom">' . $nbrannonces . '</span>';
                }
                ?>
                <a class="nav-link" href="mes_favoris.php"><i class="fa fa-fw fa-star"></i> Mes favoris</a>
                <a class="nav-link" href="profile.php"><i class="fa fa-fw fa-user"></i> Mon profile</a>
                <a class="nav-link text-danger font-weight-bold" href="logout.php"><i class="fa fa-fw fa-sign-out-alt"></i> Se deconnecter</a>
            </nav>
        </div>
        </div>
        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <h6 class="border-bottom border-gray pb-2 mb-0"><i class="fa fa-fw fa-bullhorn"></i> <?php echo ($_SESSION["type"] == "admin") ? "Annonces :" : "Mes annonces :" ?></h6>
            <br>
            <?php
            if (mysqli_num_rows($annresult) == 0) { ?>
                <div class="text-center">
                    <h4 class="text-primary mb-5">Trouvez ce que vous cherchez facilement.</h4>
                    <a class="btn btn-outlined-orange" href="aj_annonce.php"><i class="fa fa-edit"></i> Publier votre annonce gratuitement</a><br>
                    <img src="images/annonce.jpg">
                </div>
                <br>

            <?php } else { ?>
                <div class="text-left">
                    <a class="btn btn-outlined-orange mb-4" href="aj_annonce.php"><i class="fa fa-edit"></i> Publier une annonce</a><br>
                </div>
                <ul class="list-group">
                <?php }
            while ($row = mysqli_fetch_array($annresult)) {
                $imgs = explode(",", $row['images']);
                ?>


                    <li class="list-group-item">
                        <div class="media align-items-lg-center flex-column flex-lg-row p-3">
                            <div class="media-body order-2 order-lg-2">
                                <div class="d-flex  justify-content-between pl-0">
                                    <h5 class="mt-0 font-weight-bold mb-2"><?php echo  $row['titre']; ?></h5>
                                    <div class="text-right"><?php echo ($_SESSION["type"] == "admin") ? "<div class='small'>Publié par " . $row['id_user'] . "</div>" : ""; ?></div>
                                </div>

                                <p class="font-italic text-muted mb-0 small mb-5"><?php echo $row['description']; ?></p>
                                <div class="d-flex align-items-center justify-content-between mt-1">
                                    <h6 class="font-weight-bold my-2 text-orange"><?php echo $row['prix']; ?> €</h6>
                                    <ul class="list-inline small">
                                        <a href="md_annonce.php?id=<?php echo $row['id_annonce']; ?>" class="btn btn-light"><i class="fa fa-edit"></i> Modifier</a>
                                        <button data-id="<?php echo $row['id_annonce']; ?>" class="btn btn-danger delete_annonce"><i class="fa fa-remove"></i> Supprimer</button>
                                    </ul>
                                </div>
                            </div>
                            <div <?php echo "style='background-image: url(upload/" . $imgs[0] . ")'"  ?> class="mr-lg-5 order-1 order-lg-1 anncimg">
                            </div>
                    </li>

                <?php

            }
                ?>



                </ul>



        </div>



    </main>

    <script>
        $(document).ready(function() {
            $('.delete_annonce').click(function(e) {
                e.preventDefault();
                var annonceid = $(this).attr('data-id');
                var parent = $(this).parent("div").parent("ul");
                bootbox.dialog({
                    message: "Etes-vous sûr que vous voulez supprimer l'annonce?",
                    title: "<i class='glyphicon glyphicon-trash'></i> Supprimer !",
                    buttons: {
                        success: {
                            label: "Annuler",
                            className: "btn-success",
                            callback: function() {
                                $('.bootbox').modal('hide');
                            }
                        },
                        danger: {
                            label: "Supprimer !",
                            className: "btn-danger",
                            callback: function() {
                                $.ajax({
                                        type: 'POST',
                                        url: 'supprimer.php',
                                        data: 'annonceid=' + annonceid
                                    })
                                    .done(function(response) {
                                        bootbox.alert(response);
                                        parent.fadeOut('slow');
                                        location.reload(true);
                                    })
                                    .fail(function() {
                                        bootbox.alert('Erreur de suppression....');
                                    })
                            }
                        }
                    }
                });
            });
        });
    </script>


</body>

</html>