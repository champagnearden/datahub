<?php 
include "functions.php";

if (!isset($_POST['token']) && !isset($_POST['username'])  ) {
    header("Location: login.php");
    die();
}
$salaries = json_decode(file_get_contents("accounts.json"), true);
$key = isset($_POST['username']) ? array_search($_POST['username'], array_column($salaries, 'username')): null;
if (
    is_int($key) && 
    isset($_POST['email']) && 
    $_POST['email'] == $salaries[$key]['email']
) {
    $token = bin2hex(random_bytes(16));
    $tokens = json_decode(file_get_contents("tokens.json"), true);
    $tokens[$token] = $_POST['username'];
    $ret = send_email($salaries[$key]['prenom'], $salaries[$key]['nom'], $_POST['email'], $token);
    if ($ret == true){
        echo $const['LOGIN']['CONFIRM_SENT'].$_POST['email'];
    } else {
        echo $const['LOGIN']['SENT_ERROR'];
    }
    file_put_contents("tokens.json", json_encode($tokens));
    //header("Location: login.php");
    //die();
} else if (isset($_POST['token']) && $_POST['token'] != null){
    //verify the token and output the form to change the password
    $token = $_POST['token'];
    $tokens = json_decode(file_get_contents("tokens.json"), true);
    if ($tokens[$token] == null){
        header("Location: login.php");
        die();
    }
    headd($const['LOGIN']['FORGOT_PASSWORD']);
    nav("forgot_password.php");
    if ($tokens[$token] != null){
        echo "
            <div class='container textblue policesecond'>
                <b class='mediumsize'>".$const['LOGIN']['FORGOT_PASSWORD']."</b></div><br>
                <div class='bgmaincolor container policesecond'>
                    <form action='forgot_password.php' method='post' class='inline'>
                        <div class='row textblue'>
                        <div class='col-sm'><br>
                            <div class='form-floating'>
                                <input type='text' class='form-control' id='username' placeholder='".$const['GESTION']['USERNAME_PLACEHOLDER']."' name='username' value='".$tokens[$token]."' required>
                                <label for='username'>".$const['GESTION']['USERNAME']."</label><br>
                            </div>
                        </div>
                        </div>
                        <div class='form-floating input-group mb-4 textblue' >
                            <input type='password' class='form-control' id='password' placeholder='".$const['LOGIN']['PASSWORD_PLACEHOLDER']."' name='password' required>
                            <label for='password'>".$const['LOGIN']['PASSWORD']."</label><br>
                        </div>
                        <button type='submit' class='btn bg-white textblue'>".$const['LOGIN']['ADD']."</button><br><br>
                    </form>
                </div>
            </div>
        ";
        footer();
    }
} else if (isset($_POST['username']) && isset($_POST['password'])){
    //verify change the password and delete the token
    $salaries[$key]['motdepasse'] = hash_password($_POST['password']);
    file_put_contents("accounts.json", json_encode($salaries));
    unset($tokens[$token]);
    file_put_contents("tokens.json", json_encode($tokens));
    //notif(OK BG);
    header("Location: login.php");
    die(); 
}

?>