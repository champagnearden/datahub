<?php
include "functions.php";
if (!isset($_SESSION['username'])){
    header("Location: ./login.php");
    die();
} else if 
(
    $_SESSION['role'] == $const["roles"]["USER"] && 
    $_POST['username'] == $_SESSION['username'] ||
    $_SESSION['role'] == $const["roles"]["MODO"] &&
    $_POST['role'] == $const['roles']['USER'] ||
    $_SESSION['role'] == $const["roles"]["ADMIN"]
) {
    $salaries = json_decode(file_get_contents("accounts.json"), true);
    $_POST["email"] = $_POST["email"].$const['conf']['MAIL_DOMAIN'];
    $_POST["motdepasse"] = hash_password($_POST["motdepasse"]);
    $key = array_search($_SESSION['username'], array_column($salaries, 'username'));
    if (is_int($key)) {
        $_POST['date_creation'] = $salaries[$key]['date_creation'];
        $_POST['date_modif'] = date(DATE_RFC2822);
        $_POST['groupe'] = $salaries[$key]['groupe'];
        $_POST['username'] = $salaries[$key]['username'];
        $_POST['role'] = $salaries[$key]['role'];
        $salaries[$key] = $_POST;
    } else {
        $_POST["date_creation"] = date(DATE_RFC2822);
        $_POST["date_modif"] = $const["GESTION"]['NEVER'];
        array_push($salaries, $_POST);
    }
    file_put_contents("accounts.json", json_encode($salaries));
}
header("Location: ./gestion.php");
die();
?>