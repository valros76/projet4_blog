<?php
    require('bdd.php');
    
    if(isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['connect'])){
        $pseudo = $_POST['pseudo'];
        $req = $bdd->prepare('SELECT id,mdp FROM users WHERE nom = :nom');
        $req->execute(array(
            'pseudo' => $pseudo));
        $resultat = $req->fetch(PDO::FETCH_ASSOC);

        $isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);

        if(!$resultat){
            echo 'Mauvais identifiant / Mauvais mot de passe.';
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
    }

    header('Location : ../index.php');
?>