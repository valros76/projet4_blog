<?php
function loadClass($class){
    require 'classes/'.$class.'.php';
}

spl_autoload_register('loadClass');

    if($_POST['pseudo'] != null && $_POST['password'] != null && $_POST['confirmPassword'] && $_POST['email'] != null){
        $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $user = new User([
            'pseudo' => $_POST['pseudo'],
            'password' => $pass_hash,
            'email' => $_POST['email']
        ]);
        
        require('bdd.php');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $manager = new UsersManager($bdd);

        if(!$user->nomValide()){
            echo 'Le nom choisi est invalide.';
            unset($user);
        }
        elseif($manager->exists($user->pseudo())){
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
            $manager->add($user);
        }
    }
    else{
        echo 'Un des champs est mal rempli / les mots de passes ne correspondent pas.';
    }


header('Location: ../views/pages/connexion.php');

?>
