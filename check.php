<?php
include "functions.php";
headd($const["FUNCTIONS"]["WELCOME"]);
$file = file_get_contents('./accounts.json');
$fichier = json_decode($file, true);
session_verif($fichier);
echo $const['FUNCTIONS']['REDIRECT'];

footer();
?>