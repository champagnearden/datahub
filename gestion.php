<?php
include "functions.php";
headd("Gestion");
nav("gestion.php");

if (!isset($_SESSION['pre_nom'])){
    header("Location: /connexion.php");
    die();
}
if(isset($_POST['email'])){
    $_POST['email']=explode("|", $_POST['email']);
    foreach($_POST['email'] as $e){
        $sa=json_decode(file_get_contents("./accounts.json"), true);
        $i=0;
        foreach($sa as $s){
            $k=array_keys($sa)[$i];
            if($s['email']==$e){
                break;
            }
            $i++;
        }
        if(isset($_POST['newmdp'])){
            $sa[$k]['motdepasse']=$_POST['newmdp'];
            echo "<script>alert('Le mot de passe de ".$sa[$k]['username']." à bien été changé en ".$sa[$k]['motdepasse'][0];
            for($i=1;$i<strlen($sa[$k]['motdepasse'])-1;$i++){
                echo "*";
            }
            echo $sa[$k]['motdepasse'][$i]."');</script>";
        }
        if(isset($_POST['newrole'])){
            $sa[$k]['role']=$_POST['newrole'];
        }
        if(isset($_POST['newgrp'])){
            $str="";
            foreach($_POST['newgrp'] as $s){
                $str=$str." | $s";
            }
            $sa[$k]['groupe']=$str;
        }
        file_put_contents("./accounts.json", json_encode($sa));
    }
}
?>

<div style="display : <?php if ($_SESSION['role'] != 'utilisateur'){echo 'block;';  }else{echo 'none;';}?>" class="textblue policesecond bigsize container text-center">
    Cette page est réservée aux administrateurs et modérateurs, pour la gestion des utilisateurs et des groupes. 
</div>
<br>
<hr style="display : <?php if ($_SESSION['role'] != 'utilisateur'){echo 'block;';  }else{echo 'none;';}?>" class="textblue">
<br>
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
                    if ($_SESSION['role']==$const["ADMIN"]){
                        echo '
                        <tr>
                            <th scope="row">'.$salarie["username"].'</th>
                            <td>'.$salarie["prenom"].'</td>
                            <td>'.$salarie["nom"].'</td>
                            <td>'.$salarie["email"].'</td>
                            <td><form action="" method="post">
                                    <input type="password" name="newmdp" value="'.$salarie["motdepasse"].'" id="'.$salarie["username"].'" onmouseenter="document.getElementById(\''.$salarie["username"].'\').type=\'text\'" onmouseleave=\'document.getElementById("'.$salarie["username"].'").type="password"\'>
                                    <input type="hidden" name="email" value="'.$salarie["email"].'">
                                <button type="submit" class="btn bgmaincolor text-white">OK</button>
                                </form></td>
                            <td>'.$salarie["role"].'</td>
                            <td>'.$salarie["groupe"].'</td>
                            <td style="border: none">';
                            if($_SESSION['username'] != $salarie["username"]){
                                echo '
                                <form action="supprimer_salarie.php" method="post">
                                    <input type="hidden" name="email" value="'.$salarie["email"].'" >
                                    <input type="submit" class="btn btn-sm bgmaincolor text-white material-icons" value="close">
                                </form> ';
                            }
                            echo '
                            </td>
                        </tr>'
                    ;}else if ($_SESSION['role']==$const["MODO"]){
                        echo '
                        <tr>
                            <th scope="row">'.$salarie['username'].'</th>
                            <td>'.$salarie['nom'].'</td>
                            <td>'.$salarie['prenom'].'</td>
                            <td>'.$salarie['email'].'</td>
                            <td>'; if($salarie["role"]==$const["ADMIN"]||$salarie["role"]==$const["MODO"] && $salarie["username"]!=$_SESSION['username']){echo "*****";}else{echo "
                                <form action='' method='post'>
                                    <input type='password' name='newmdp' value='".$salarie['motdepasse']."' id='".$salarie['username']."' onmouseenter=\"document.getElementById('".$salarie['username']."').type='text'\" onmouseleave=\"document.getElementById('".$salarie['username']."').type='password'\">
                                    <input type='hidden' name='email' value='".$salarie['email']."'>
                                <button type='submit' class='btn bgmaincolor text-white'>OK</button>
                                </form>
                                ";} echo'</td>
                            <td>'.$salarie["role"].'</td>
                            <td>'.$salarie["groupe"].'</td>
                            
                        </tr>'
                    ;}else if ($_SESSION['role']==$const["USER"] && ( $salarie["role"] != $const["USER"] || $salarie["username"] == $_SESSION["username"])){
                        echo '
                        <tr>
                            <th scope="row">'.$salarie["username"].'</th>
                            <td>'.$salarie["prenom"].'</td>
                            <td>'.$salarie["nom"].'</td>
                            <td>'.$salarie["email"].'</td>
                            <td>'; 
                            if($salarie["username"]==$_SESSION['username']){
                                echo "
                                <form action='' method='post'>
                                    <input type='password' name='newmdp' value='".$salarie['motdepasse']."' id='".$salarie['username']."' onmouseenter=\"document.getElementById('".$salarie['username']."').type='text'\" onmouseleave=\"document.getElementById('".$salarie['username']."').type='password'\">
                                    <input type='hidden' name='email' value='".$salarie['email']."'>
                                <button type='submit' class='btn bgmaincolor text-white'>OK</button>
                                </form>
                                ";
                            } else {
                                echo "*****";
                            }
                            echo'
                            </td>
                            <td>'.$salarie["role"].'</td>
                            <td>'.$salarie["groupe"].'</td>
                            
                        </tr>'
                    ;}                    
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<hr style="display : <?php if ($_SESSION['role'] != 'utilisateur'){echo 'block;';  }else{echo 'none;';}?>" class="container textblue">
<br>
<div style="display : <?php if ($_SESSION['role'] != 'moderateur' && $_SESSION['role'] != 'utilisateur'){echo 'block;';  }else{echo 'none;';}?>">
    <div class="container textblue policesecond">
        <b class="mediumsize">Ajouter un utilisateur</b>
    </div>
    <br>
    <div class="bgmaincolor container policesecond">
        <div class="row textblue">
            <div class="col-sm">
                <br>
                <form action="/ajouter_salarie.php" method="post">
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
                  <option value=$const["USER"]>Utilisateur</option>
                  <option value=$const["MODO"]>Modérateur</option>
                  <option value=$const["ADMIN"]>Administrateur</option>
                </select>
            </div>
            <div class="col-sm mb-4">
                <label for="groupe" class="form-label text-white">Groupe :</label>
                <tbody>
                    <select multiple class="form-select form-select-lg textblue" id="groupe" name="groupe[]" required>
                    <?php
                    $groupes = json_decode(file_get_contents("./groupes.json"), true);
                    foreach ($groupes as $groupe) {
                        echo "<option>".$groupe['nom']."</option>";
                    }
                    ?>
                    </select>
                </tbody>
            </div>
        </div>
                    <button type="submit" name="ajouter salariés" class="btn bg-white textblue">Ajouter</button><br><br>
                </form>
    </div>
    <br>
    <hr class="textblue">
</div>
<div style="display : <?php if ($_SESSION['role'] != 'utilisateur'){echo 'block;';  }else{echo 'none;';}?>" class="container">
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
                <?php
                $groupes = json_decode(file_get_contents("./groupes.json"), true);
                foreach ($groupes as $groupe) {
                    echo'
                    <tr>
                        <th scope="row">'.$groupe["id"].'</th>
                        <td>'.$groupe["nom"].'</td>
                        <td style="border: none">
                            <form action="supprimer_groupe.php" method="post">
                                <input type="hidden" name="id" value="'.$groupe["id"].'" >
                                <input type="submit" class="btn btn-sm bgmaincolor text-white material-icons" value="close">
                            </form>                        
                        </td>
                    </tr>';
                }
                ?>
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
        <form action="/ajouter_groupe.php" method="post"><br>
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
        <?php 
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
            echo '
        <table class="table policesecond textblue table-bordered" style="background-color:lightgray;">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody>';
            foreach ($ip as $i) {
                echo'
                <tr>
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
            echo '
            </tbody>
        </table>';
        }else{
            echo "<h1>Aucune adresse IP n'est actuellement bannie !</h1>";
        };?>
    </div>
</div>
<br>
<div style="display : <?php if ($_SESSION['role'] != 'utilisateur'){echo 'block;';  }else{echo 'none;';}?>">
    <hr class='textblue'>
    <br>
    <div class='container textblue policesecond'>
        <div class="container textblue policesecond">
            <b class="mediumsize">Gestion de masse</b>
        </div>
        <br>
        <div class="row" style="display: <?php if($_SESSION['role']=="utilisateurs"){echo "none;";}else{echo "block;";} ?>; background-color:lightgray">
            <br>
            <?php $groupes = json_decode(file_get_contents("./groupes.json"), true); ?>
            <form action="gestion.php#seek" method="post">
                <input type="radio" name="choix" value="users">
                <label for="ch_users">Choix Nom d'utilisateurs</label>
                <select class="form-select form-select-lg" id="ch_users" name="ch_users[]" multiple>
                    <?php
                        foreach($salaries as $salarie){
                            echo '<option value="'.$salarie["username"].'" selected>'.$salarie["username"].'</option>';
                        }
                    ?>
                </select>
                <br>
                <input type="radio" name="choix" value="groups" checked>
                <label for="ch_groupes">Choix Groupes</label>
                <select class="form-select form-select-lg" id="ch_groupes" name="ch_groupes[]" multiple>
                    <?php
                        foreach($groupes as $grp){
                            echo '<option value="'.$grp["nom"].'" selected>'.$grp["nom"].'</option>';
                        }
                    ?>
                </select>
                <br>
                <input type="radio" name="choix" value="roles">
                <label for="ch_roles">Choix Rôles</label>
                <select class="form-select form-select-lg" id="ch_roles" name="ch_roles[]" multiple>
                    <option value=$const["ADMIN"]>administrateur</option>
                    <option value=$const["MODO"]>moderateur</option>
                    <option value=$const["USER"] selected>utilisateur</option>
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
    <?php 
    if(!isset($_POST['choix'])){
        echo "</div>";
        footer();
        die();
    }
    ?>
    <div class='container textblue policesecond'>
        <table class="table">
            <tbody>
                <?php
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
                    if ($_SESSION['role']==$const["ADMIN"]){
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
                                        <td>'.$salarie["motdepasse"].'</td>
                                        <td>'.$salarie["role"].'</td>
                                        <td>'.$salarie["groupe"].'</td>
                                    </tr>';
                                    array_push($tabmail,$salarie["email"]);
                                }    
                            }
                        }
                    }
                    if ($_SESSION['role']==$const["MODO"]){
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
                                            if($salarie["role"]==$const["ADMIN"]
                                             ||$salarie["role"]==$const["MODO"] && $salarie["username"]!=$_SESSION['username']
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
                    if ($_SESSION['role']==$const["USER"]){
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
                ?>
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
                            <input type="hidden" name="email" value="<?php echo implode("|",$tabmail); ?>">
                            <button type="submit" class="btn bgmaincolor text-white">OK</button>
                        </form>
                    </th>
                    <th scope="col">Rôle
                        <form action="" method="post">
                            <select class="form-select form-select-lg" name="newrole">
                                <option value=$const["ADMIN"]>administrateur</option>
                                <option value=$const["MODO"]>moderateur</option>
                                <option value=$const["USER"]>utilisateur</option>
                            </select>
                            <input type="hidden" name="email" value="<?php echo implode("|",$tabmail); ?>">
                            <button type="submit" class="btn bgmaincolor text-white">OK</button>
                        </form>
                    </th>
                    <th scope="col">Groupe
                        <form action="" method="post">
                            <select class="form-select form-select-lg" name="newgrp[]" multiple>
                                <?php 
                                foreach(json_decode(file_get_contents("./groupes.json"), true) as $g){
                                    echo "  <option value='".$g['nom']."'>".$g['nom']."</option>";
                                }
                                ?>
                            </select>
                            <input type="hidden" name="email" value="<?php echo implode("|",$tabmail); ?>">
                            <button type="submit" class="btn bgmaincolor text-white">OK</button>
                        </form>
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<?php
if(isset($_POST['choix'])){footer();}
?>