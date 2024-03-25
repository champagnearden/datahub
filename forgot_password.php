<?php 
include "functions.php";

if (!isset($_POST['token']) && !isset($_POST['username'])  ) {
    header("Location: login.php");
    die();
}
$salaries = json_decode(file_get_contents("accounts.json"), true);
$tokens = json_decode(file_get_contents("tokens.json"), true);
$key = isset($_POST['username']) ? array_search($_POST['username'], array_column($salaries, 'username')): null;
if (
    is_int($key) && 
    isset($_POST['email']) && 
    $_POST['email'] == $salaries[$key]['email'] &&
    $salaries[$key] != null
) {
    // Just sent the forgot password form
    // check if the email correspond to username
    $user = $salaries[array_search($_POST['email'], array_column($salaries, 'email'))];
    if (
        $user =! null && 
        $user['username'] == $_POST['username'] 
    ){
        $token = bin2hex(random_bytes(16));
        $ret = send_email($user['prenom'], $user[$key]['nom'], $_POST['email'], $token);
        if ($ret == true){
            $tokens = json_decode(file_get_contents("tokens.json"), true);
            $tokens[$token] = $_POST['username'];
            file_put_contents("tokens.json", json_encode($tokens));
            echo $const['LOGIN']['CONFIRM_SENT'].$_POST['email'];
            //notif(email sent)
        } else {
            echo $ret;
            echo $const['LOGIN']['SENT_ERROR'];
            //notif(email not sent)
        }
    }
    header("Location: login.php");
    die();
} else if (
    isset($_POST['token']) && 
    isset($_POST['password']) && 
    isset($_POST['password2'])
){
    // sent the new password form
    if($_POST['password'] == $_POST['password2']){
        //notif(ERROR BG);
        $username = $tokens[$_POST['token']];
        $key = array_search($username, array_column($salaries, 'username'));
        if(is_int($key)){
            $salaries[$key]['motdepasse'] = hash_password($_POST['password']);
            unset($tokens[$token]);
            file_put_contents("tokens.json", json_encode($tokens));
            file_put_contents("accounts.json", json_encode($salaries));
            //notif(success BG);
        } else {
            //notif(error BG);
        }
    }
    header("Location: login.php");
    die(); 
} else if (
    isset($_POST['token']) && 
    $_POST['token'] != null
){
    // clicked on the button in the email
    //verify the token and output the form to change the password
    $token = $_POST['token'];
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
                        <input type='hidden'name='token' value='".$token."'>
                        <div class='row textblue'>
                            <div class='col-sm'><br>
                                <div class='form-floating'>
                                    <input type='password' class='form-control' id='password' placeholder='".$const['LOGIN']['PASSWORD_PLACEHOLDER']."' name='password' required>
                                    <label for='username'>".$const['LOGIN']['PASSWORD']."</label><br>
                                </div>
                            </div>
                        </div>
                        <div class='row textblue'>
                            <div class='col-sm'>
                                <div class='form-floating'>
                                    <input type='password' class='form-control' id='password2' placeholder='".$const['LOGIN']['PASSWORD_CONFIRM_PLACEHOLDER']."' name='password2' onkeyup='validatePassword()' required>
                                    <label for='password2'>".$const['LOGIN']['PASSWORD_CONFIRM']."</label><br>
                                </div>
                            </div>
                        </div>
                        <button type='submit' class='btn bg-white textblue' id='submit' disabled>".$const['LOGIN']['ADD']."</button><br><br>
                    </form>
                </div>
            </div>
            <script>
                function validatePassword() {
                    var password = document.getElementById('password').value;
                    var password2 = document.getElementById('password2').value;
                    if (password != password2) {
                        //console.log('".$const['LOGIN']['PASSWORD_NOT_MATCH']."');
                        document.getElementById('submit').disabled = true;
                    } else {
                        document.getElementById('submit').disabled = false;
                    }
                }
            </script>
        ";
        footer();
    }
} else {
    header("Location: login.php");
    die();
}

?>