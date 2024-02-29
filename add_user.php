<?php
session_start();
$salaries = json_decode(file_get_contents("accounts.json"), true);
$_POST["email"] = $_POST["email"]."@etud.univ-ubs.fr";
echo "<script>alert('".var_dump($_POST)."')</script>";
array_push($salaries, $_POST);
file_put_contents("accounts.json", json_encode($salaries));
header("Location: ./gestion.php");

?>