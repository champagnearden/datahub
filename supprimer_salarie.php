<?php

session_start();

$salaries = json_decode(file_get_contents("salariés.json"), true);
foreach($salaries as $key => $salarie) {
    if($salarie['email'] == $_POST['email']) {
        unset($salaries[$key]);
        break;
    }
}
file_put_contents("salariés.json", json_encode($salaries));
header("Location: ./gestion.php");

?>