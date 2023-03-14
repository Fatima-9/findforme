<?php
include_once("config.php");
if($_REQUEST['annonceid']) {
	$sql = "DELETE FROM annonces WHERE id_annonce='".$_REQUEST['annonceid']."'";
	$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
	if($resultset) {
		echo "Annonce supprimé avec succès !";
	}
}
?>