<?php
// Initialize the session
session_start();
$id_user = $_SESSION["id"];



require_once "config.php";

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}


$users = mysqli_query($link, "SELECT DISTINCT(favoris.id_annonce), annonces.* from annonces, favoris where annonces.id_annonce = favoris.id_annonce and favoris.id_user = $id_user");


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
    <title>Mes favoris - Find for me</title>
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/font.css">
    <link rel="stylesheet" href="css/all.min.css">
    <script src="scripts/jquery.min.js"></script>
    <script src="scripts/bootstrap.min.js"></script>
    <script src="scripts/datatablesjq.js"></script>
    <script src="scripts/datatables.js"></script>
    <link rel="stylesheet" href="css/dataTables.css" />
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
              <a class="nav-link" href="mes_annonces.php"><i class="fa fa-fw fa-bullhorn"></i> Annonces</a>
              <a class="nav-link" href="users.php"><i class="fa fa-fw fa-users"></i> Utilisateurs</a>';
                } else {
                    echo '<a class="nav-link" href="mes_annonces.php"><i class="fa fa-fw fa-bullhorn"></i> Mes annonces
              <span class="badge badge-pill bg-light align-text-bottom">' . $nbrannonces . '</span>';
                }
                ?>
                <a class="nav-link active" href="mes_favoris.php"><i class="fa fa-fw fa-star"></i> Mes favoris</a>
                <a class="nav-link" href="profile.php"><i class="fa fa-fw fa-user"></i> Mon profile</a>
                <a class="nav-link text-danger font-weight-bold" href="logout.php"><i class="fa fa-fw fa-sign-out-alt"></i> Se deconnecter</a>
            </nav>
        </div>
        <div class="my-3 p-3 bg-white rounded shadow-sm">
            <h6 class="border-bottom border-gray pb-2 mb-0"><i class="fas fa-star"></i>Mes favoris:</h6>
            <div class="page-header">


                <div class="table-responsive px-5 py-3">

                    <table id="users" class="table table-striped table-bordered">
                        <thead>
                            <tr>

                                <th>Annonces</th>
                                <th>Retirer</th>

                            </tr>
                        </thead>
                        <tbody>


                            <?php
                            while ($row = mysqli_fetch_array($users)) {
                                echo '<tr>';
                                echo '<td><a href="annonce.php?id=' . $row['id_annonce'] . '">' . $row['titre'] . '</a></td>';
                                echo '<td><a href="retirer.php?id=' . $row['id_annonce'] . '"><i class="fa fa-fw fa-trash text-danger"></i></a></td>';
                                echo '</tr>';
                            }
                            ?>

                            </tr>
                        </tbody>
                    </table>
                </div>


            </div>

        </div>

    </main>




</body>

</html>