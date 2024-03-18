<?php
include "functions.php";
headd('');
$groupes = json_decode(file_get_contents("./groupes.json"), true);
$users = json_decode(file_get_contents("./accounts.json"), true);

for ($i = 0; $i < sizeof($groupes); $i++) {
    if ($groupes[$i] == $_POST['nom_grp']) {
        for ($j = 0; $j < sizeof($users); $j++) {
            $index = array_search($_POST["nom_grp"], $users[$j]["groupe"]);
            if ($index !== false) {
                unset($users[$j]["groupe"][$index]);
                $users[$j]["groupe"] = array_values($users[$j]["groupe"]); // Reindex the array
                print_r($users[$j]["groupe"]);
            }
        }
        unset($groupes[$i]);
        $_SESSION['notif'] = $const['GESTION']['DELETED_GROUP'];
        $groupes = array_values($groupes); // Reindex the array
        break;
    }
}

file_put_contents("./groupes.json", json_encode($groupes));
file_put_contents("./accounts.json", json_encode($users));
header("Location: ./gestion.php");
die();
?>