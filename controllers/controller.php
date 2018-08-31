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
        require('models/connexion_user.php');
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