<?php

session_start();

$groupes = json_decode(file_get_contents("groupes.json"), true);
$users = json_decode(file_get_contents("salariés.json"), true);
$copy_users = array();
foreach($groupes as $key => $groupe) {
    if($groupe['id'] == $_POST['id']) {
        foreach($users as $u){
            $u['groupe'] = str_replace(" | ".$groupe["nom"], "", $u['groupe']);
            array_push($copy_users, $u);
        }
        unset($groupes[$key]);
        break;
    }
}
file_put_contents("groupes.json", json_encode($groupes));
file_put_contents("salariés.json", json_encode($copy_users));


header("Location: ./gestion.php");

?>