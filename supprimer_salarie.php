<?php

session_start();

$salaries = json_decode(file_get_contents("salariés.json"), true);
foreach($salaries as $key => $salarie) {
    if($salarie['email'] == $_POST['email']) {
        exec('sudo deluser '.$salarie['username']);
        exec('sudo rm -R /var/www/sardines/intranet/FTP/UTILISATEURS/'.$salarie['username']);
        unset($salaries[$key]);
        break;
    }
}
file_put_contents("salariés.json", json_encode($salaries));
header("Location: ./gestion.php");

?>