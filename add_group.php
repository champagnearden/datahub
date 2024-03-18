<?php
include "functions.php";
headd('');
$groupes = json_decode(file_get_contents("./groupes.json"), true);
if ( !in_array($_POST["nom_grp"], $groupes) ) {
    array_push($groupes, $_POST["nom_grp"]);
    file_put_contents("./groupes.json", json_encode($groupes));
    $_SESSION['notif'] = $const['GESTION']['ADDED_GROUP'];
}
header("Location: /gestion.php");
die();
?>