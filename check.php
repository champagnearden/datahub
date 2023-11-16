<?php
include "functions.php";
headd("Bienvenue");
$file = file_get_contents('./accounts.json');
$fichier = json_decode($file, true);
session_verif($fichier);
echo <<< HTML
    Vous allez être redirigé...
HTML;

footer();
?>