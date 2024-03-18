<?php
include "functions.php";
headd('');
$salaries = json_decode(file_get_contents("accounts.json"), true);
foreach($salaries as $key => $salarie) {
    if($salarie['username'] == $_POST['username']) {
        unset($salaries[$key]);
        break;
    }
}
$_SESSION['notif'] = $const['GESTION']['MODIFIED_USER'];
file_put_contents("./accounts.json", json_encode($salaries));
header("Location: ./gestion.php");
die();
?>