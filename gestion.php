<?php
include "functions.php";
headd($const["FUNCTIONS"]["GESTION"]);
nav("gestion.php");

if (!isset($_SESSION['pre_nom'])){
    header("Location: /login.php");
    die();
}

if ( isset($_POST["username"]) ){
    $_POST["usernames"] = $_POST["username"];
}
$salaries = json_decode(file_get_contents("./accounts.json"), true);

if(isset($_POST['usernames'])){
    foreach(explode(",", $_POST['usernames']) as $salarie ) {
        for($c=0; $c < sizeof($salaries); $c++) {
            if ($salaries[$c]['username'] == $salarie) {
                if ( isset($_POST['newmdp']) ) {
                    $salaries[$c]['motdepasse'] = hash_password($_POST['newmdp']);
                    echo "<script>
                    alert('".$const["GESTION"]["PASSWORD_CHANGED_1"].$salaries[$c]['username'].$const["GESTION"]["PASSWORD_CHANGED_2"].$salaries[$c]['motdepasse'][0];
                    for($i=1;$i<strlen($salaries[$c]['motdepasse'])-1;$i++){
                        echo "*";
                    }
                    echo $salaries[$c]['motdepasse'][$i]."');
                    </script>";
                } else if ( isset($_POST['newrole']) ) {
                    $salaries[$c]['role']=$_POST['newrole'];
                } else if ( isset($_POST['newgrp']) ) {
                    $salaries[$c]['groupe']=$_POST["newgrp"];
                }
                file_put_contents("./accounts.json", json_encode($salaries));
                break;
            }
        }
    }
}

if ($_SESSION['role'] != $const["roles"]["USER"]){
    echo '<div class="textblue policesecond bigsize container text-center">'.$const["GESTION"]["RESERVED"];
    echo <<< HTML
    </div>
    <br>
    <hr class="textblue">
    <br>
    HTML;
}
echo '
    <div class="container textblue policesecond">
        <b class="mediumsize">
'.$const['GESTION']['EDIT_INFOS'];
echo <<< HTML
        </b>
    </div>
    <script>
        function display(self) {
            self.type='text';
        }
        function hide(self) {
            self.type='password';
        }
    </script>
    <br>
    <div class="bgmaincolor container policesecond">
        <form action="add_user.php" method="post">
            <div class="row textblue">
                <div class="col-sm"><br>
                    <div class="form-floating">
HTML;
$current = $salaries[array_search($_SESSION['username'], array_column($salaries, 'username'))];
echo '
                        <input type="text" class="form-control" id="prenom" placeholder="'.$const["LOGIN"]["PRENOM_PLACEHOLDER"].'" name="prenom" value="'.$current["prenom"].'" required>
                        <label for="prenom">'.$const["LOGIN"]["PRENOM"].'</label><br>
                    </div>
                </div>
                    <div class="col-sm"><br>
                        <div class="form-floating">
                        <input type="text" class="form-control" id="nom" placeholder="'.$const["LOGIN"]["NOM_PLACEHOLDER"].'" name="nom" value="'.$current["nom"].'" required>
                        <label for="nom">'.$const["LOGIN"]["NOM"].'</label><br>
                        </div>
                    </div>
                    <div class="col-sm"><br>
                        <div class="form-floating">
                            <input type="password" class="form-control" id="motdepasse" placeholder="'.$const["LOGIN"]["PASSWORD_PLACEHOLDER"].'" name="motdepasse" onmouseenter="display(this)" onmouseleave="hide(this)" required>
                            <label for="motdepasse">'.$const["LOGIN"]["PASSWORD"].'</label><br>
                        </div>
                    </div>
                </div>
                <div class="form-floating input-group mb-4 textblue" >
                    <input type="text" class="form-control" id="email" placeholder="'.$const["LOGIN"]["EMAIL_PLACEHOLDER"].'" name="email" value="'.str_replace($const['conf']['MAIL_DOMAIN'], "", $current["email"]).'" required>
                    <label for="email">'.$const["LOGIN"]["EMAIL"].'</label><br>
                    <span class="input-group-text textblue">'.$const["conf"]["MAIL_DOMAIN"].'</span>
                </div>
                <button type="submit" class="btn bg-white textblue">'.$const["GESTION"]["EDIT"].'</button><br><br>
            </div>
        </form>
    </div>
';

if ( 
    $_SESSION['role'] == $const["roles"]["ADMIN"] ||
    $_SESSION['role'] == $const['roles']['MODO']
) {
    echo <<< HTML
    <div class="container textblue policesecond">
        <b class="mediumsize">
    HTML;
    echo $const["GESTION"]["ADD_USER"];
    echo <<< HTML
        </b>
    </div>
    <br>
    <div class="bgmaincolor container policesecond">
        <form action="/add_user.php" method="post">
            <div class="row textblue">
                <div class="col-sm">
                    <br>
                    <div class="form-floating">
    HTML;
    echo '
                        <input type="text" class="form-control" id="username" placeholder="'.$const["GESTION"]["USERNAME_PLACEHOLDER"].'" name="username" required>
                        <label for="username">
    ';
    echo $const["GESTION"]["USERNAME"];
    echo <<< HTML
                        </label>
                        <br>
                    </div>
                </div>
                <div class="col-sm">
                    <br>
                    <div class="form-floating ">
    HTML;
    echo '
                        <input type="text" class="form-control" id="prenom" placeholder="'.$const["LOGIN"]["PRENOM_PLACEHOLDER"].'" name="prenom" required>
                        <label for="prenom">'.$const["LOGIN"]["PRENOM"].'</label>
    ';
    echo <<< HTML
                        <br>
                    </div>
                </div>
                <div class="col-sm">
                <br>
                    <div class="form-floating">
    HTML;
    echo '
                        <input type="text" class="form-control" id="nom" placeholder="'.$const["LOGIN"]["NOM_PLACEHOLDER"].'" name="nom" required>
                        <label for="nom">'.$const["LOGIN"]["NOM"].'</label>
    ';
    echo <<< HTML
                        <br>
                    </div>
                </div>
            </div>
            <div class="row textblue">
                <div class="col-sm">
                    <br>
                    <div class="form-floating">
    HTML;
    echo '
                        <input type="password" class="form-control" id="motdepasse" placeholder="'.$const["LOGIN"]["PASSWORD_PLACEHOLDER"].'" name="motdepasse" onmouseenter="display(this)" onmouseleave="hide(this)" required>
                        <label for="motdepasse">'.$const["LOGIN"]["PASSWORD"].'</label>
    ';
    echo <<< HTML
                        <br>
                    </div>
                </div>
            </div>
            <div class="form-floating input-group mb-4 textblue" >
    HTML;
    echo '
                <input type="text" class="form-control" id="email" placeholder="'.$const["LOGIN"]["EMAIL_PLACEHOLDER"].'" name="email" required>
                <label for="email">'.$const["LOGIN"]["EMAIL"].'</label>
    ';
    echo <<< HTML
                <br>
                <span class="input-group-text textblue">
    HTML;
    echo $const["conf"]["MAIL_DOMAIN"];
    echo <<< HTML
                </span>
            </div>
            <div class="row">
                <div class="col-sm mb-4">
    HTML;
    echo '
                    <label for="role" class="form-label text-white">'.$const["GESTION"]["ROLE"].'</label>
                    <select class="form-select form-select-lg textblue" id="role" name="role" required>
    ';
    if ( $_SESSION['role'] == $const["roles"]["ADMIN"] ) {
        foreach ($const["roles"] as $key => $value) {
            echo "<option value='$value'>".$const['GESTION']["ROLES"][$key]."</option>";
        }
    } else if ($_SESSION['role'] == $const['roles']['MODO']){
        echo "<option value='".$const['roles']['USER']."'>".$const['GESTION']["ROLES"]["USER"]."</option>";
    }
    echo <<< HTML
                    </select>
                </div>
                <div class="col-sm mb-4">
    HTML;
    echo '
                    <label for="groupe" class="form-label text-white">'.$const["GESTION"]["GROUP"].'</label>
    ';
    echo <<< HTML
                    <tbody>
                        <select multiple class="form-select form-select-lg textblue" id="groupe" name="groupe[]" required>
    HTML;
    $groupes = json_decode(file_get_contents("./groupes.json"), true);
    foreach ($groupes as $groupe) {
        echo "<option>".$groupe."</option>";
    }
    echo <<< HTML
                        </select>
                    </tbody>
                </div>
            </div>
    HTML;
    echo '
            <button type="submit" class="btn bg-white textblue">'.$const["GESTION"]["ADD"].'</button><br><br>
    ';
    echo <<< HTML
        </form>
    </div>
    <br>
    <hr class="textblue">
    HTML;
}

if ( $_SESSION['role'] != $const["roles"]["USER"] ) {
    echo <<< HTML
        <div class="container">
        <br>
        <div class=" container-fluid textblue text-center policesecond">
    HTML;
    echo '
            <b class="mediumsize">'.$const["GESTION"]["LIST_GROUPS"].'</b>
    ';
    echo <<< HTML
            <br>
        </div>
        <br>
        <div class="row">
            <table class="table policesecond textblue table-bordered" style="background-color:lightgray;">
                <thead>
                    <tr>
    HTML;
    echo '
                        <th>'.$const["GESTION"]["ID"].'</th>
                        <th>'.$const["LOGIN"]["NOM"].'</th>
    ';
    echo <<< HTML
                    </tr>
                </thead>
                <tbody>
    HTML;
    $groupes = json_decode(file_get_contents("./groupes.json"), true);
    for($i=0; $i < sizeof($groupes) ; $i++) {
        echo'
        <tr>
            <th scope="row">'.$i.'</th>
            <td>'.$groupes[$i].'</td>
            <td style="border: none">
                <form action="del_group.php" method="post">
                    <input type="hidden" name="nom_grp" value="'.$groupes[$i].'" >
                    <input type="submit" class="btn btn-sm bgmaincolor text-white material-icons" value="close">
                </form>                        
            </td>
        </tr>';
    }
    echo <<< HTML
                </tbody>
            </table>
        </div>
        <br>
        <hr class='container textblue'>
        <br>
        <div class="container textblue policesecond">
            <b class="mediumsize">
    HTML;
    echo $const["GESTION"]["ADD_GROUP"];
    echo <<< HTML
            </b>
        </div>
        <br>
        <div class="bgmaincolor container-fluid policesecond">
            <form action="/add_group.php" method="post"><br>
                <div class="form-floating textblue">
    HTML;
    echo '
                <input type="text" class="form-control " id="nom_grp" placeholder="'.$const["GESTION"]["GROUP_NAME_PLACEHOLDER"].'" name="nom_grp" required>
                <label for="nom">'.$const["GESTION"]["GROUP_NAME"].'</label><br>
                </div>
                <button type="submit" name="ajouter des groupes" class="btn bg-white textblue">'.$const["GESTION"]["ADD"].'</button><br><br>
    ';
    echo <<< HTML
            </form>
        </div>
        <br>
        <hr class='container textblue'>
        <br>
        <div class=" container-fluid textblue text-center policesecond">
            <b class="mediumsize">
    HTML;
    echo $const["GESTION"]["BAN_IP"];
    echo <<< HTML
            </b>
            <br>
        </div>
        <br>
        <div class="row">
    HTML;
    $ip = json_decode(file_get_contents("./banned_ip.json"), true);
    if (isset($_POST['ip'])){
        $key=0;
        while ($_POST['ip'] != $ip[$key]['ip']){
            $key++;
        };
        unset($ip[$key]);
        file_put_contents("banned_ip.json", json_encode($ip));
    }
    if (sizeof($ip)>0){
        echo <<< HTML
            <table class="table policesecond textblue table-bordered" style="background-color:lightgray;">
            <thead>
                <tr>
        HTML;
        echo '
                    <th>'.$const["GESTION"]["DATE"].'</th>
                    <th>'.$const["GESTION"]["IP"].'</th>
        ';
        echo <<< HTML
                </tr>
            </thead>
            <tbody>
        HTML;
        foreach ($ip as $i) {
            echo'<tr>
                <th scope="row"><pre class="textblue">'.$i["date"].'</pre></th>
                <td><pre class="textblue">'.$i["ip"].'</pre></td>
                <td style="border: none">
                    <form action="gestion.php" method="post">
                        <input type="hidden" name="ip" value="'.$i["ip"].'" >
                        <input type="submit" class="btn btn-sm bgmaincolor text-white material-icons" value="close">
                    </form>                        
                </td>
            </tr>';
        };
        echo '</tbody>
        </table>';
    } else{
        echo '<h1>'.$const["GESTION"]["NO_BAN_IP"].'</h1>';
    }
    echo "</div></div><br><hr class='textblue'>";
}
echo <<< HTML
    <br>
    <script>
        function autoselect(id) {
            document.getElementById(id).checked = true;
        }
    </script>
    <div class='container textblue policesecond' >
        <div class="container textblue policesecond">
            <b class="mediumsize">
HTML;
echo $const["GESTION"]["FILTERED_SEARCH"];
echo <<< HTML
            </b>
        </div>
        <br>
        <div class="row" style="background-color:lightgray; padding-bottom: 1rem;">
            <br>
HTML;
$groupes = json_decode(file_get_contents("./groupes.json"), true);
echo <<< HTML
            <form action="gestion.php#seek" method="post">
                <input type="radio" name="choix" value="users" id="users">
HTML;
echo '
                <label for="ch_users">'.$const["GESTION"]["CHOICE_USERNAME"].'</label>
                <select class="form-select form-select-lg" id="ch_users" name="ch_users[]" onclick="autoselect(\'users\')" multiple>
';
foreach($salaries as $salarie){
    echo '<option value="'.$salarie["username"].'" selected>'.$salarie["username"].'</option>';
}
echo '
                </select>
                <br>
                <input type="radio" name="choix" value="groups" id="groupes" checked>
                <label for="ch_groupes">'.$const["GESTION"]["CHOICE_GROUPS"].'</label>
                <select class="form-select form-select-lg" id="ch_groupes" name="ch_groupes[]" onclick="autoselect(\'groupes\')" multiple>
';
foreach($groupes as $grp){
    echo '<option value="'.$grp.'" selected>'.$grp.'</option>';
}
echo '
                </select>
                <br>
                <input type="radio" name="choix" value="roles" id="roles">
                <label for="ch_roles">'.$const["GESTION"]["CHOICE_ROLES"].'</label>
                <select class="form-select form-select-lg" id="ch_roles" name="ch_roles[]" onclick="autoselect(\'roles\')"multiple>
';
foreach ($const["roles"] as $name => $role){
    echo '<option value="'.$role.'" selected>'.$const["GESTION"]["ROLES"][$name].'</option>';
}
echo '
                </select>
                <br>
                <button type="submit" class="btn bg-white textblue" id="seek">'.$const["GESTION"]["SEARCH"].'</button>
';
echo <<< HTML
            </form>
        </div>
    </div>
    <hr>
    <div class='container textblue policesecond table-responsive' style="padding: 0%;">
        <table class="table table-striped table-hover">
            <tbody class="table-bordered">
HTML;
if (!isset($_POST["choix"])){
    $_POST["choix"] = 'users';
    $_POST["ch_users"] = array();
    foreach ($salaries as $salarie) {
        array_push($_POST["ch_users"], $salarie["username"]);
    }
}
switch ($_POST['choix']) {
    case 'users':
        $salaries = array_filter($salaries, function($salarie) {
            return in_array($salarie['username'], $_POST['ch_users']);
        });
        break;
    case 'groups':
        $salaries = array_filter($salaries, function($salarie) {
            return count(array_intersect($salarie['groupe'], $_POST['ch_groupes'])) > 0;
        });                
        break;
    case 'roles':
        $salaries = array_filter($salaries, function($salarie) {
            return in_array($salarie['role'], $_POST['ch_roles']);
        });
        break;
}
$usernames = array(
    $const['roles']['ADMIN'] => [], 
    $const['roles']['MODO'] => [],
    $const['roles']['USER'] => []
);
foreach ($salaries as $salarie) {
    // affichage du tableau
    echo '
    <tr>
        <th scope="row">'.$salarie["username"].'</th>
        <td>'.$salarie["prenom"].'</td>
        <td>'.$salarie["nom"].'</td>
        <td><a href="mailto:"'.$salarie["email"].'">'.$salarie["email"].'</a></td>
        <td>'.$salarie["date_creation"].'</td>
    ';
    if ( 
        $_SESSION['role'] == $const["roles"]["ADMIN"] ||
        $_SESSION['role'] == $const["roles"]["MODO"] &&
        (
            $salarie["role"] == $const["roles"]["USER"]
        )
    ) {
        if ($_SESSION['username'] != $salarie['username']) {
            array_push($usernames[$salarie["role"]], $salarie["username"]);
        }
        echo "<td>".$salarie["date_modif"]."</td>";
    } else if ($_SESSION['role'] != $const["roles"]["USER"]) {
        echo "<td>****</td>";
    }
    echo '
        <td>'.$const["GESTION"]["ROLES"][array_search($salarie["role"], $const["roles"])].'</td>
        <td>'.implode(" | ", $salarie["groupe"]).'</td>
    ';
    if (
        $_SESSION["role"] == $const["roles"]["ADMIN"] || 
        $_SESSION["role"] == $const["roles"]["MODO"]
    ) {
        echo '<td class="text-center align-middle">';
        if 
        (
            $_SESSION["username"] == $salarie["username"] ||
            $_SESSION['role'] == $const["roles"]["MODO"] &&
            (
                $salarie['role'] == $const["roles"]["ADMIN"] ||
                $salarie['role'] == $const["roles"]["MODO"]
            )
        ){
            echo '<button class="btn btn-sm btn-danger text-white material-icons" disabled>close</button>';
        } else {
            echo '
                <form action="del_user.php" method="post">
                    <input type="hidden" name="username" value='.$salarie["username"].'></input>
                    <input type="submit" class="btn btn-sm btn-danger text-white material-icons" value="close">
                </form>
            ';
        }
        echo '</td>';
    }
    echo '

    </tr>
    ';
}
//Entête
echo <<< HTML
            </tbody>
            <thead>
                <tr class="table-active">
HTML;
echo '
                    <th scope="col">'.$const["GESTION"]["USERNAME"].'</th>
                    <th scope="col">'.$const["LOGIN"]["PRENOM"].'</th>
                    <th scope="col">'.$const["LOGIN"]["NOM"].'</th>
                    <th scope="col">'.$const["LOGIN"]["EMAIL"].'</th>
                    <th scope="col">'.$const["GESTION"]["CREATED_ON"].'</th>';
$unames = "";
foreach( $usernames as $role) {
    $unames .= implode(",", $role);
}
if ( 
    $_SESSION['role'] == $const["roles"]["USER"] &&
    in_array($_SESSION['username'], $usernames ) ||
    $_SESSION['role'] != $const["roles"]["USER"]
) {
    echo <<< HTML
                    <th scope="col">Modifié le</th>
    HTML;
}
echo '
                    <th scope="col">'.$const["GESTION"]["ROLE"];
if ( $_SESSION['role'] != $const["roles"]["USER"] ) {
    echo <<< HTML
                        <form action="" method="post">
                            <div class="input-group">
                                <select class="form-control form-select form-select-lg search-multiple" name="newrole">
    HTML;
    foreach ($const["roles"] as $name => $role){
        echo "<option value='$role'>".$const['GESTION']["ROLES"][$name]."</option>";
    }
    echo '
                                </select>
                                <input type="hidden" name="usernames" value="'.$unames.'">
                                <div class="input-group-append">
                                    <button type="submit" class="btn bgmaincolor text-white searchOk">'.$const["GESTION"]["OK"].'</button>
                                </div>
                            </div>
                        </form>
    ';
}
echo '
                    </th>
                    <th scope="col">'.$const["GESTION"]["GROUPS"];
if ( $_SESSION['role'] != $const["roles"]["USER"] ) {
    echo <<< HTML
                        <form action="" method="post">
                            <div class="input-group">
                                <select class="form-control form-select form-select-lg search-multiple" name="newgrp[]" multiple>
    HTML;
    foreach(json_decode(file_get_contents("./groupes.json"), true) as $g){
        echo "
                                    <option value='$g'>$g</option>
        ";
    }
    echo '
                                </select>
                                <input type="hidden" name="usernames" value="'.$unames.'">
                                <div class="input-group-append">
                                    <button type="submit" class="btn bgmaincolor text-white searchOk">'.$const["GESTION"]["OK"].'</button>
                                </div>
                            </div>
                        </form>
    ';
}
echo '
                    </th>
';
if (
    $_SESSION["role"] == $const["roles"]["ADMIN"] || 
    $_SESSION["role"] == $const["roles"]["MODO"]
) {
    echo '
                    <th scope="col">'.$const["GESTION"]["REMOVE"].'</th>
    ';
}
echo <<< HTML
                </tr>
            </thead>
        </table>
    </div>
HTML;
footer();
?>