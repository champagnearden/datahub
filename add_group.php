<?php
include "functions.php";
if (
    (
        $_SESSION['role'] == $const['roles']['ADMIN'] ||
        $_SESSION['role'] == $const['roles']['MODO']
    ) && 
    isset($_POST['nom_grp']) &&
    $_POST['nom_grp'] != ""
) {
    $groupes = json_decode(file_get_contents("./groupes.json"), true);
    if ( !in_array($_POST["nom_grp"], $groupes) ) {
        array_push($groupes, $_POST["nom_grp"]);
        file_put_contents("./groupes.json", json_encode($groupes));
    }
}
header("Location: /gestion.php");
die();
?>