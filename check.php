<?php
include "functions.php";
headd("Bienvenue");
$file = file_get_contents('./accounts.json');
$fichier = json_decode($file, true);
session_verif($fichier);
echo $const['CHECK']['REDIRECT'];

footer();
?>