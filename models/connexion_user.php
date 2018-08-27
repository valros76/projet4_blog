<?php
function loadClass($class){
    require 'classes/'.$class.'.php';
}
spl_autoload_register('loadClass');

    $pseudo = $_POST['pseudo'];
    $bdd = new PDO('mysql:host=localhost;dbname=id6846891_blog_ecrivain;charset=utf8', 'id6846891_valros76', 'granpeper4');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $req = $bdd->prepare('SELECT id,password FROM users WHERE pseudo = :pseudo');
    $req->execute(array(
        'pseudo' => $pseudo));
    $resultat = $req->fetch(PDO::FETCH_ASSOC);
    $req->closeCursor();
    $id = $bdd->prepare('SELECT id_group FROM users WHERE pseudo = :pseudo');
    $id->execute(array(
        'pseudo' => $pseudo));
    $id_group = $id->fetch(PDO::FETCH_ASSOC);
    $id->closeCursor();

    $isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);

    if(!$resultat){
        echo 'Mauvais identifiant ou mot de passe. -- <a href="../index.php">Retour à l\'acceuil</a>';
    }
    else{
        if($isPasswordCorrect){
            session_start();
            $_SESSION['id'] = $resultat['id'];
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['id_group'] = $id_group['id_group'];
            header('Location: ../index.php');
            echo 'Vous êtes connecté !';
        }
        else{
            header('Location: ../index.php');
            echo 'Mauvais identifiant ou mot de passe.';
        }
    }
    

?>