<?php
    function loadClass($class){
        require 'classes/'.$class.'.php';
    }
    spl_autoload_register('loadClass');
    
        $pseudo = $_POST['pseudo'];
        $bdd = new PDO('mysql:host=localhost;dbname=blog_ecrivain;charset=utf8', 'root', '');
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $req = $bdd->prepare('SELECT id,password FROM users WHERE pseudo = :pseudo');
        $req->execute(array(
            'pseudo' => $pseudo));
        $resultat = $req->fetch(PDO::FETCH_ASSOC);
    
        $isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);
    
        if(!$resultat){
            echo 'Mauvais identifiant ou mot de passe.';
        }
        else{
            if($isPasswordCorrect){
                session_start();
                $_SESSION['id'] = $resultat['id'];
                $_SESSION['pseudo'] = $pseudo;
                echo 'Vous êtes connecté !';
            }
            else{
                echo 'Mauvais identifiant ou mot de passe.';
            }
        }
    
        header('Location: ../index.php');
?>