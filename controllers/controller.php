<?php

    function home(){
        require('views/homeView.php');
    }

    function inscription(){
        require('views/pages/inscription.php');
    }

    function new_inscription(){
        require('models/inscription_user.php');
    }

    function connexion(){
        require('views/pages/connexion.php');
    }

    function connect(){
        $pseudo = $_POST['pseudo'];
    $bdd = dbConnect();
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
            header('Location:index.php');
            echo 'Vous êtes connecté !';
        }
        else{
            header('Location:?action=home');
            echo 'Mauvais identifiant ou mot de passe.';
        }
    }
    }

    function deconnexion(){
        require('models/deconnexion_user.php');
    }

    function memberSpace(){
        require('views/pages/member_space.php');
    }

    function latestPost(){
        require('views/pages/latest_posts.php');
    }

    function postWithCommentary(){
        require('views/pages/post_with_commentary.php');
    }

    function postComment(){
        require('models/post_comment.php');
    }

    function signaledComment(){
        require('models/signaled_comment.php');
    }

    function RASComment(){
        require('models/remove_from_signaled_comment.php');
    }

    function deleteComment(){
        require('models/delete_signaled_comment.php');
    }

    function actionOnComment(){
        if(isset($_SESSION['id_group'])){
            if($_SESSION['id_group'] < 3){
                signaledComment();
            }
            else{
                deleteComment();
            }
        }
        else{}
    }

    function createPost(){
        require('views/pages/create_post.php');
    }

    function createArticle(){
        require('models/create_article.php');
    }

    function moderationCommentaire(){
        require('views/pages/moderation_commentaire.php');
    }

    function dbConnect(){
        $dbData = parse_ini_file('config/bdd.ini');
        $host = $dbData['host'];
        $dbname = $dbData['dbname'];
        $username = $dbData['username'];
        $password = $dbData['password'];
        try{
            $bdd = new PDO('mysql:host='. $host .';dbname='. $dbname .';charset=utf8', $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            return $bdd;
        }
        catch(Exeption $e){
            die('Erreur : ' .$e->getMessage());
        }
    }

?>