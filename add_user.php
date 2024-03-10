<?php
include "functions.php";
session_start();
$salaries = json_decode(file_get_contents("accounts.json"), true);
$_POST["email"] = $_POST["email"].$const['conf']['MAIL_DOMAIN'];
$_POST["motdepasse"] = hash_password($_POST["motdepasse"]);
$_POST["date_creation"] = date(DATE_RFC2822);
$_POST["date_modif"] = "Jamais";
echo "<script>alert('".var_dump($_POST)."')</script>";
array_push($salaries, $_POST);
file_put_contents("accounts.json", json_encode($salaries));
header("Location: ./gestion.php");
die();
?>