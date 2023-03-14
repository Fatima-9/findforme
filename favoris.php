<?php
session_start();
$id_user = $_SESSION["id"];
$id_annonce = $_GET["id"];
include_once("config.php");

$sql = "INSERT Into favoris(id_user,id_annonce) values($id_user,$id_annonce)";
$resultset = mysqli_query($link, $sql) or die("database error:" . mysqli_error($link));
header('location: annonce.php?id=' . $id_annonce);
?>