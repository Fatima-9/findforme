<?php

require_once "config.php";

if($_REQUEST['userid']) {
	$sql = "DELETE FROM utilisateur WHERE id='".$_REQUEST['userid']."'";
	$resultset = mysqli_query($link, $sql) or die("database error:". mysqli_error($link));
	if($resultset) {
		echo "Annonce supprimé avec succès !";
	}
}

?>