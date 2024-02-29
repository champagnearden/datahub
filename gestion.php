<?php
include "functions.php";
headd("Gestion");
nav("gestion.php");

if (!isset($_SESSION['pre_nom'])){
    header("Location: /connexion.php");
    die();
}

if(isset($_POST['username'])){
    $_POST['username']=explode(",", $_POST['username']);
    foreach($_POST['username'] as $e){
        $accounts=json_decode(file_get_contents("./accounts.json"), true);
        $i=0;
        foreach($accounts as $account){
            $k=array_keys($account)[$i];
            if($s['username']==$account){
                break;
            }
            $i++;
        }
        if(isset($_POST['newmdp'])){
            $account[$k]['motdepasse']=$_POST['newmdp'];
            echo "<script>alert('Le mot de passe de ".$account[$k]['username']." à bien été changé en ".$account[$k]['motdepasse'][0];
            for($i=1;$i<strlen($account[$k]['motdepasse'])-1;$i++){
                echo "*";
            }
            echo $account[$k]['motdepasse'][$i]."');</script>";
        }
        if(isset($_POST['newrole'])){
            $account[$k]['role']=$_POST['newrole'];
        }
        if(isset($_POST['newgrp'])){
            $account[$k]['groupe']=$_POST["newgrp"];
        }
        file_put_contents("./accounts.json", json_encode($account));
    }
}

if ($_SESSION['role'] != $const["roles"]["USER"]){
    echo <<< HTML
    <div class="textblue policesecond bigsize container text-center">
        Cette page est réservée aux administrateurs et modérateurs, pour la gestion des utilisateurs et des groupes. 
    </div>
    <br>
    <hr class="textblue">
    <br>
    HTML;
}
?>
<script>
    function display(self) {
        self.type='text';
    }
    function hide(self) {
        self.type='password';
    }
</script>
<div class=" container-fluid textblue text-center policesecond">
    <b class="mediumsize">Liste des utilisateurs</b>
    <br>
</div>
<br>
<div class="container">
    <div class="row">
        <br>
        <table class="table policesecond textblue table-bordered" style="background-color:lightgray;">
            <thead class="text-center">
                <tr>
                    <th>Username</th>
                    <th>Prénom</th>
                    <th>Nom</th>
                    <th>Mail</th>
                    <th>Mot de passe</th>
                    <th>Rôle</th>
                    <th>Groupe</th>
                </tr>
            </thead>
            <tbody>
<?php
    $salaries = json_decode(file_get_contents("./accounts.json"), true);
    foreach ($salaries as $salarie) {
        $salarie["groupe"] = implode(" | ", $salarie["groupe"]);
        echo '
            <tr>
                <th scope="row">'.$salarie["username"].'</th>
                <td>'.$salarie["prenom"].'</td>
                <td>'.$salarie["nom"].'</td>
                <td>'.$salarie["email"].'</td>
                <td>';
        if ( $_SESSION['role'] == $const["roles"]["ADMIN"] ) {
            echo "
            <form action='' method='post'>
                <input type='password' name='newmdp' value='".$salarie['motdepasse']."' onmouseover='display(this)' onmouseout='hide(this)'>
                <input type='hidden' name='username' value='".$salarie['username']."'>
            <button type='submit' class='btn bgmaincolor text-white'>OK</button>
            </form>";
        } else if ( $_SESSION['role'] == $const["roles"]["MODO"] ) {
            if( $salarie["role"] == $const["roles"]["ADMIN"] ||
                $salarie["role"] == $const["roles"]["MODO"] && 
                $salarie["username"] != $_SESSION['username'] 
            ) {
                    echo "*****";
            } else {
                echo "<form action='' method='post'>
                    <input type='password' name='newmdp' value='".$salarie['motdepasse']."' onmouseover='display(this)' onmouseout='hide(this)'>
                    <input type='hidden' name='username' value='".$salarie['username']."'>
                <button type='submit' class='btn bgmaincolor text-white'>OK</button>
                </form>";
            }
        } else if ( $_SESSION['role'] == $const["roles"]["USER"] ) {
            if( $salarie["username"] == $_SESSION['username']) {
                echo "
                <form action='' method='post'>
                    <input type='password' name='newmdp' value='".$salarie['motdepasse']."' onmouseover='display(this)' onmouseout='hide(this)'>
                    <input type='hidden' name='username' value='".$salarie['username']."'>
                <button type='submit' class='btn bgmaincolor text-white'>OK</button>
                </form>";
            } else {
                echo "*****";
            }
        }
        echo '</td>
                <td>'.$salarie["role"].'</td>
                <td>'.$salarie["groupe"].'</td>
                <td style="border: none">';
                if( $_SESSION['username'] != $salarie["username"] ){
                    echo '
                    <form action="del_user.php" method="post">
                        <input type="hidden" name="username" value="'.$salarie["username"].'" >
                        <input type="submit" class="btn btn-sm bgmaincolor text-white material-icons" value="close">
                    </form> ';
                }
        echo '
                </td>
            </tr>';
    }
?>
            </tbody>
        </table>
    </div>
</div>
<hr style="display : <?php if ($_SESSION['role'] != 'utilisateur'){echo 'block;';  }else{echo 'none;';}?>" class="container textblue">
<br>
<?php
if ( $_SESSION['role'] == $const["roles"]["ADMIN"] ) {
    echo <<< HTML
    <div class="container textblue policesecond">
        <b class="mediumsize">Ajouter un utilisateur</b>
    </div>
    <br>
    <div class="bgmaincolor container policesecond">
        <form action="/add_user.php" method="post">
            <div class="row textblue">
                <div class="col-sm">
                    <br>
                    <div class="form-floating">
                        <input type="text" class="form-control" id="username" placeholder="Entrer le nom d'utilisateur" name="username" required>
                        <label for="username">Nom d'utilisateur</label>
                        <br>
                    </div>
                </div>
                <div class="col-sm">
                    <br>
                    <div class="form-floating ">
                        <input type="text" class="form-control" id="prenom" placeholder="Entrer votre prenom" name="prenom" required>
                        <label for="prenom">Prénom</label>
                        <br>
                    </div>
                </div>
                <div class="col-sm">
                <br>
                    <div class="form-floating">
                        <input type="text" class="form-control" id="nom" placeholder="Entrer votre nom" name="nom" required>
                        <label for="nom">Nom</label>
                        <br>
                    </div>
                </div>
            </div>
            <div class="row textblue">
                <div class="col-sm">
                    <br>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="motdepasse" placeholder="Entrer votre mot de passe" name="motdepasse" required>
                        <label for="motdepasse">Mot de passe</label>
                        <br>
                    </div>
                </div>
            </div>
            <div class="form-floating input-group mb-4 textblue" >
                <input type="text" class="form-control" id="email" placeholder="Entrer votre email" name="email" required>
                <label for="email">Email</label>
                <br>
                <span class="input-group-text textblue">@etud.univ-ubs.fr</span>
            </div>
            <div class="row">
                <div class="col-sm mb-4">
                    <label for="role" class="form-label text-white">Rôle :</label>
                    <select class="form-select form-select-lg textblue" id="role" name="role" required>
    HTML;
    foreach ($const["roles"] as $key => $value) {
        echo "<option value='$value'>$key</option>";
    }
    echo <<< HTML
                    </select>
                </div>
                <div class="col-sm mb-4">
                    <label for="groupe" class="form-label text-white">Groupe :</label>
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
            <button type="submit" class="btn bg-white textblue">Ajouter</button><br><br>
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
            <b class="mediumsize">Liste des groupes</b>
            <br>
        </div>
        <br>
        <div class="row">
            <table class="table policesecond textblue table-bordered" style="background-color:lightgray;">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
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
                <form action="supprimer_groupe.php" method="post">
                    <input type="hidden" name="id" value="'.$i.'" >
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
            <b class="mediumsize">Ajouter un groupe</b>
        </div>
        <br>
        <div class="bgmaincolor container-fluid policesecond">
            <form action="/add_group.php" method="post"><br>
                <div class="form-floating textblue">
                <input type="text" class="form-control " id="nom_grp" placeholder="Entrer le nom du groupe" name="nom_grp" required>
                <label for="nom">Nom du groupe</label><br>
                </div>
                <button type="submit" name="ajouter des groupes" class="btn bg-white textblue">Ajouter</button><br><br>
            </form>
        </div>
        <br>
        <hr class='container textblue'>
        <br>
        <div class=" container-fluid textblue text-center policesecond">
            <b class="mediumsize">IP bannies</b>
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
                    <th>Date</th>
                    <th>IP</th>
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
        echo "<h1>Aucune adresse IP n'est actuellement bannie !</h1>";
    }
    echo <<< HTML
        </div>
        </div>
        <br>
        <hr class='textblue'>
        <br>
        <div class='container textblue policesecond'>
            <div class="container textblue policesecond">
                <b class="mediumsize">Gestion de masse</b>
            </div>
            <br>
            <div class="row" style="background-color:lightgray">
                <br>
    HTML;
    $groupes = json_decode(file_get_contents("./groupes.json"), true);
    echo <<< HTML
            <form action="gestion.php#seek" method="post">
                <input type="radio" name="choix" value="users">
                <label for="ch_users">Choix Nom d'utilisateurs</label>
                <select class="form-select form-select-lg" id="ch_users" name="ch_users[]" multiple>
    HTML;
    foreach($salaries as $salarie){
        echo '<option value="'.$salarie["username"].'" selected>'.$salarie["username"].'</option>';
    }
    echo <<< HTML
                </select>
                <br>
                <input type="radio" name="choix" value="groups" checked>
                <label for="ch_groupes">Choix Groupes</label>
                <select class="form-select form-select-lg" id="ch_groupes" name="ch_groupes[]" multiple>
    HTML;
    foreach($groupes as $grp){
        echo '<option value="'.$grp.'" selected>'.$grp.'</option>';
    }
    echo <<< HTML
                </select>
                <br>
                <input type="radio" name="choix" value="roles">
                <label for="ch_roles">Choix Rôles</label>
                <select class="form-select form-select-lg" id="ch_roles" name="ch_roles[]" multiple>
    HTML;
    foreach ($const["roles"] as $name => $role){
        echo '<option value="'.$role.'" selected>'.$role.'</option>';
    }
    echo <<< HTML
                </select>
                <br>
                <button type="submit" class="btn bg-white textblue" id="seek">Rechercher</button>
            </form>
            <br>
            <br>
            <br>
        </div>
        <br>
        <br>
    </div>
    HTML; 
    if(!isset($_POST['choix'])){
        echo "</div>";
        footer();
        die();
    }
    echo <<< HTML
        <div class='container textblue policesecond'>
            <table class="table">
                <tbody>
    HTML;
    if(isset($_POST['choix'])){
        switch ($_POST['choix']) {
            case 'users':
                unset($_POST['ch_groupes']);
                unset($_POST['ch_roles']);
                $post='ch_users';
                break;
            case 'groups':
                unset($_POST['ch_users']);
                unset($_POST['ch_roles']);
                $post='ch_groupes';
                break;
            case 'roles':
                unset($_POST['ch_users']);
                unset($_POST['ch_groupes']);
                $post='ch_roles';
                break;
        }
    }
    $tabmail=array();
    foreach (json_decode(file_get_contents("./accounts.json"), true) as $salarie) {
        if ($_SESSION['role']==$const["roles"]["ADMIN"]){
            $unique="";
            foreach($_POST as $tab=>$v){
                if(is_string($v)){
                    $v=array(" "=>$v);
                }
                foreach($v as $tab2=>$v2){
                    if(!isset($_POST[$post])){
                        $_POST[$post]=array("");
                    }
                    foreach($_POST[$post] as $t){
                        $pass=false;
                        if (str_contains($t,implode(",",$salarie['groupe']))&& !str_contains($unique,$salarie['nom'])) {
                            $unique=$unique.$salarie['nom'];
                            $pass=true;
                            break;
                        }
                    }
                    if ((isset($_POST['ch_users']) && $v2 == $salarie["username"])||(isset($_POST["ch_roles"]) && $v2 == $salarie["role"])||(isset($_POST["ch_groupes"]) && $pass)) {
                        echo '
                        <tr>
                            <th scope="row">'.$salarie["username"].'</th>
                            <td>'.$salarie["prenom"].'</td>
                            <td>'.$salarie["nom"].'</td>
                            <td>'.$salarie["email"].'</td>
                            <td><input type="password" name="newmdp" value="'.$salarie["motdepasse"].'" onmouseover="display(this)" onmouseout="hide(this)"></td>
                            <td>'.$salarie["role"].'</td>
                            <td>'.implode(" | ", $salarie["groupe"]).'</td>
                        </tr>';
                        array_push($tabmail,$salarie["username"]);
                    }    
                }
            }
        }
        if ($_SESSION['role']==$const["roles"]["MODO"]){
            $unique="";
            foreach($_POST as $tab=>$v){
                if(is_string($v)){
                    $v=array(" "=>$v);
                }
                foreach($v as $tab2=>$v2){
                    if(!isset($_POST[$post])){
                        $_POST[$post]=array("");
                    }
                    foreach($_POST[$post] as $t){
                        $pass=false;
                        if (str_contains($t,str_replace(" | ", "", $salarie['groupe']))&& !str_contains($unique,$salarie['nom'])) {
                            $unique=$unique.$salarie['nom'];
                            $pass=true;
                            break;
                        }
                    }
                    if ((isset($_POST['ch_users']) && $v2 == $salarie["username"])||(isset($_POST["ch_roles"]) && $v2 == $salarie["role"])||(isset($_POST["ch_groupes"]) && $pass)) {
                        echo '
                        <tr>
                            <th scope="row">'.$salarie["username"].'</th>
                            <td>'.$salarie["prenom"].'</td>
                            <td>'.$salarie["nom"].'</td>
                            <td>'.$salarie["email"].'</td>
                            <td>'; 
                                if( $salarie["role"]==$const["roles"]["ADMIN"] ||
                                    $salarie["role"]==$const["roles"]["MODO"] &&
                                    $salarie["username"]!=$_SESSION['username']
                                ){
                                    echo "*****";
                                }else{
                                    echo $salarie["motdepasse"];
                                    array_push($tabmail,$salarie["email"]);
                                } 
                                echo'</td>
                            <td>'.$salarie["role"].'</td>
                            <td>'.$salarie["groupe"].'</td>
                        </tr>';
                    }
                }
            }
        }
        if ($_SESSION['role']==$const["roles"]["USER"]){
            $unique="";
            foreach($_POST as $tab=>$v){
                if(is_string($v)){
                    $v=array(" "=>$v);
                }
                foreach($v as $tab2=>$v2){
                    if(!isset($_POST[$post])){
                        $_POST[$post]=array("");
                    }
                    foreach($_POST[$post] as $t){
                        $pass=false;
                        if (str_contains($t,str_replace(" | ", "", $salarie['groupe']))&& !str_contains($unique,$salarie['nom'])) {
                            $unique=$unique.$salarie['nom'];
                            $pass=true;
                            break;
                        }
                    }
                    if ((isset($_POST['ch_users']) && $v2 == $salarie["username"])||(isset($_POST["ch_roles"]) && $v2 == $salarie["role"])||(isset($_POST["ch_groupes"]) && $pass)) {
                        echo '
                        <tr>
                            <th scope="row">'.$salarie["username"].'</th>
                            <td>'.$salarie["prenom"].'</td>
                            <td>'.$salarie["nom"].'</td>
                            <td>'.$salarie["email"].'</td>
                            <td>'; 
                                if($salarie["username"]==$_SESSION['username']){
                                    echo $salarie["motdepasse"];
                                    array_push($tabmail,$salarie["email"]);
                                }else{
                                    echo "*****";
                                }
                                echo'</td>
                            <td>'.$salarie["role"].'</td>
                            <td>'.$salarie["groupe"].'</td>
                        </tr>';
                    }
                }
            }
        }
    }
    echo <<< HTML
                </tbody>
                <thead>
                    <tr>
                        <th scope="col">Username</th>
                        <th scope="col">Prénom</th>
                        <th scope="col">Nom</th>
                        <th scope="col">email</th>
                        <th scope="col">Mot de passe
                            <form action="" method="post">
                                <input type="text" name="newmdp" value="">
    HTML;
    echo '<input type="hidden" name="username" value="'.$salarie["username"].'">';
    echo <<< HTML
                                <button type="submit" class="btn bgmaincolor text-white">OK</button>
                            </form>
                        </th>
                        <th scope="col">Rôle
                            <form action="" method="post">
                                <select class="form-select form-select-lg" name="newrole">
    HTML;
    foreach ($const["roles"] as $name => $role){
        echo '  <option value="'.$role.'">'.$role.'</option>';
    }
    echo <<< HTML
                                </select>
    HTML;
    echo '<input type="hidden" name="username" value="'.$salarie["username"].'">';
    echo <<< HTML
                                <button type="submit" class="btn bgmaincolor text-white">OK</button>
                            </form>
                        </th>
                        <th scope="col">Groupe
                            <form action="" method="post">
                                <select class="form-select form-select-lg" name="newgrp[]" multiple>
    HTML;
    foreach(json_decode(file_get_contents("./groupes.json"), true) as $g){
        echo "  <option value='".$g."'>".$g."</option>";
    }
    echo <<< HTML
                                </select>
    HTML;
    echo '<input type="hidden" name="username" value="'.$salarie["username"].'">';
    echo <<< HTML
                                <button type="submit" class="btn bgmaincolor text-white">OK</button>
                            </form>
                        </th>
                    </tr>
                </thead>
            </table>
        </div>
    HTML;
}
footer();
?>