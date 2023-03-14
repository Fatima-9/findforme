<?php
// Initialize the session
session_start();


require_once "config.php";

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["type"] != "admin"){
    header("location: login.php");
    exit;
}


$users = mysqli_query($link, "SELECT * from utilisateur");


?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <meta charset="UTF-8">
    <title>Dashboard - Find for me</title>
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
            <a class="nav-link" href="dashboard.php"><i class="fa fa-fw fa-home"></i> Dashboard</a>
            <a class="nav-link" href="mes_annonces.php"><i class="fa fa-fw fa-bullhorn"></i> Annonces</a>
            <a class="nav-link active" href="users.php"><i class="fa fa-fw fa-users"></i> Utilisateurs</a>
            <a class="nav-link" href="profile.php"><i class="fa fa-fw fa-user"></i> Mon profile</a>
            <a class="nav-link text-danger font-weight-bold" href="logout.php"><i class="fa fa-fw fa-sign-out-alt"></i> Se deconnecter</a>
        </nav>
    </div>
    <div class="my-3 p-3 bg-white rounded shadow-sm">
        <h6 class="border-bottom border-gray pb-2 mb-0"><i class="fa fa-fw fa-users"></i> Les utilisateurs :</h6>
        <div class="page-header">


            <div class="table-responsive px-5 py-3">  

                <table id="users" class="table table-striped table-bordered">  
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Genre</th>
                            <th>Tel</th>
                            <th>Ville</th>
                            <th>Date de naissance</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>


                        <?php 
                        while ($row = mysqli_fetch_array($users)) {
                            echo '<tr>';
                            echo '<td>' . $row['id'] . '</td>';
                            echo '<td>' . $row['nom'] . '</td>';
                            echo '<td>' . $row['email'] . '</td>';
                            echo '<td>' . $row['genre'] . '</td>';
                            echo '<td>' . $row['tel'] . '</td>';
                            echo '<td>' . $row['ville'] . '</td>';
                            echo '<td>' . $row['datnaiss'] . '</td>';
                            echo '<td class="text-center"> 
                            <a href="edit_user.php?id=' . $row['id'] . '" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons"><i class="fa fa-edit"></i></i></a>
                            <a href="#" data-id="' . $row['id'] . '" class="delete" title="Delete" data-toggle="tooltip"><i class="material-icons"><i class="fa fa-trash"></i></i></a></td>';
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
<script>  
 $(document).ready(function(){  
  $('#users').DataTable();  
});  
</script>  

<script>
    $(document).ready(function(){
        $('.delete').click(function(e){
            e.preventDefault();
            var annonceid = $(this).attr('data-id');
            var parent = $(this).parent("div").parent("ul");
            bootbox.dialog({
                message: "Etes-vous sûr que vous voulez supprimer l'utilisateur?",
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
                                url: 'supuser.php',
                                data: 'userid='+annonceid
                            })
                            .done(function(response){
                                bootbox.alert(response);
                                parent.fadeOut('slow');
                                location.reload(true);
                            })
                            .fail(function(){
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