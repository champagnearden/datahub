<?php
include "functions.php";
headd("Gestion");
nav("gestion.php");

if (!isset($_SESSION['pre_nom'])){
    header("Location: /connexion.php");
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
                    alert('Le mot de passe de ".$salaries[$c]['username']." à bien été changé en ".$salaries[$c]['motdepasse'][0];
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
    echo <<< HTML
    <div class="textblue policesecond bigsize container text-center">
        Cette page est réservée aux administrateurs et modérateurs, pour la gestion des utilisateurs et des groupes. 
    </div>
    <br>
    <hr class="textblue">
    <br>
    HTML;
}

if ( $_SESSION['role'] == $const["roles"]["ADMIN"] ) {
    echo <<< HTML
    <script>
        function display(self) {
            self.type='text';
        }
        function hide(self) {
            self.type='password';
        }
    </script>
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
    echo "</div></div><br><hr class='textblue'>";
}
echo <<< HTML
    <br>
    <div class='container textblue policesecond'>
        <div class="container textblue policesecond">
            <b class="mediumsize">Recherche filtrée</b>
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
}
$usernames = array();
foreach ($salaries as $salarie) {
    // affichage du tableau
    echo '
    <tr>
        <th scope="row">'.$salarie["username"].'</th>
        <td>'.$salarie["prenom"].'</td>
        <td>'.$salarie["nom"].'</td>
        <td>'.$salarie["email"].'</td>
        <td>'.$salarie["date_creation"].'</td>
        <td>';
    if ( 
        $_SESSION['role'] == $const["roles"]["ADMIN"] ||
        $_SESSION['role'] == $const["roles"]["MODO"] &&
        (
            $salarie["role"] == $const["roles"]["ADMIN"] ||
            $salarie["role"] == $const["roles"]["MODO"] &&
            $salarie["username"] != $_SESSION['username']
        ) ||
        $_SESSION['role'] == $const["roles"]["USER"] && 
        $salarie ["username"] == $_SESSION['username']
    ) {
        array_push($usernames, $salarie["username"]);
        echo $salarie["date_modif"];
    } else {
        echo "*****";
    }
    echo '</td>
        <td>'.$salarie["role"].'</td>
        <td>'.implode(" | ", $salarie["groupe"]).'</td>
    </tr>';
}
//Entête
echo <<< HTML
            </tbody>
            <thead>
                <tr>
                    <th scope="col">Username</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Nom</th>
                    <th scope="col">email</th>
                    <th scope="col">Créé le</th>
HTML;
$unames = implode(",",$usernames);
if ( $_SESSION['role'] == $const["roles"]["USER"] &&
     in_array($_SESSION['username'], $usernames ) ||
     $_SESSION['role'] != $const["roles"]["USER"]
) {
    echo <<< HTML
        <th scope="col">Modifié le</th>
    HTML;
}
echo <<< HTML
                    <th scope="col">Rôle
HTML;
if ( $_SESSION['role'] != $const["roles"]["USER"] ) {
    echo <<< HTML
                        <form action="" method="post">
                            <select class="form-select form-select-lg" name="newrole">
    HTML;
    foreach ($const["roles"] as $name => $role){
        echo "<option value='$role'>$role</option>";
    }
    echo <<< HTML
                            </select>
    HTML;
    echo "<input type='hidden' name='usernames' value='$unames'>";
    echo <<< HTML
                            <button type="submit" class="btn bgmaincolor text-white">OK</button>
                        </form>
    HTML;
}
echo <<< HTML
                    </th>
                    <th scope="col">Groupes
HTML;
if ( $_SESSION['role'] != $const["roles"]["USER"] ) {
    echo <<< HTML
                        <form action="" method="post">
                            <select class="form-select form-select-lg" name="newgrp[]" multiple>
    HTML;
    foreach(json_decode(file_get_contents("./groupes.json"), true) as $g){
        echo "<option value='$g'>$g</option>";
    }
    echo <<< HTML
                                </select>
    HTML;
    echo "<input type='hidden' name='usernames' value='$unames'>";
    echo <<< HTML
                            <button type="submit" class="btn bgmaincolor text-white">OK</button>
                        </form>
    HTML;
}
echo <<< HTML
                    </th>
                </tr>
            </thead>
        </table>
    </div>
HTML;
footer();
?>