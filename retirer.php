<?php
session_start();
$id_user = $_SESSION["id"];
$id_annonce = $_GET["id"];
include_once("config.php");

$sql = "DELETE FROM favoris where id_annonce = $id_annonce and id_user = $id_user";
$resultset = mysqli_query($link, $sql) or die("database error:" . mysqli_error($link));
header('location: mes_favoris.php');
     