<?php
function loadClass($class){
    require '../../models/classes/'.$class.'.php';
}

spl_autoload_register('loadClass');
require('bdd.php');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

if(isset($_POST['inscription']) && isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['confirmMdp']) && isset($_POST['email'])){
    
    if($_POST['password'] == $_POST['confirmPassword']){
        $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $user = new User([
            'pseudo' => $_POST['pseudo'],
            'password' => $pass_hash,
            'email' => $_POST['email']
        ]);

        if(!$user->nomValide()){
            echo 'Le nom choisi est invalide.';
            unset($user);
        }
        elseif($manager->exists($user->nom())){
            echo 'Ce nom est déjà pris.';
            unset($user);
        }
        elseif(!$user->emailValide()){
            echo 'Cet email est invalide.';
            unset($user);
        }
        elseif($manager->exists($user->email())){
            echo 'Cet email est déjà utilisé.';
            unset($user);
        }
        else{
            $manager->add($membre);
            $_POST['pseudo'] = '';
            $_POST['password'] = '';
            $_POST['confirmPassword'] = '';
            $_POST['email'] = '';
        }
    }
    else{
        echo 'Un champs est mal rempli / les mots de passes ne correspondent pas.';
    }
}

header('Location: ../views/pages/connexion.php');

?>
