<?php

    function home(){
        require('views/homeView.php');
    }

    function inscription(){
        require('views/pages/inscription.php');
    }

    function new_inscription(){
        if($_POST['pseudo'] != null && $_POST['password'] != null && $_POST['confirmPassword'] && $_POST['email'] != null){
            $pass_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
            $user = new User([
                'pseudo' => $_POST['pseudo'],
                'password' => $pass_hash,
                'email' => $_POST['email']
            ]);
            
            $bdd = dbConnect();
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
    
    
        header('Location:?action=connexion');
    }

    function connexion(){
        require('views/pages/connexion.php');
    }

    function connect(){
        $pseudo = $_POST['pseudo'];
        $bdd = dbConnect();
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
        session_start();
        $_SESSION = array();
        session_destroy();
        header('Location:?action=home');
        echo 'Vous êtes déconnecté !';
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
        $bdd = dbConnect();
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $manager = new CommentsManager($bdd);
        if(isset($_POST['creer']) && isset($_SESSION['pseudo']) && isset($_POST['comment'])){
            if($_SESSION['pseudo'] != null && $_POST['comment'] != null){
                $comment = new Comment([
                    'author' => $_SESSION['pseudo'],
                    'comment' => $_POST['comment'],
                    'post_id' => $_GET['post_idu']
                ]);
                
                if($_SESSION['pseudo'] == null){
                    echo 'Vous n\'êtes pas connecté.';
                    $hint = 'Vous n\'êtes pas connecté.';
                    unset($comment);
                    header('Location:?action=latest_posts');
                }
                if($_POST['comment'] == null){
                    echo 'Vous n\'avez pas rempli la partie message.';
                    $hint = 'Vous n\'avez pas rempli la partie message.';
                    unset($comment);
                    header('Location:?action=latest_posts');
                }
                if($manager->exists_comment($comment->comment())){
                    echo 'Vous avez déjà posté ce commentaire.';
                    $hint = 'Vous avez déjà posté ce commentaire.';
                    unset($comment);
                    header('Location:?action=latest_posts');
                }
                else{
                    $manager->add($comment);
                    header('Location:?post_id='. $_GET['post_idu'] .'');
                }
            }
            
        }
    }

    function signaledComment(){
        $bdd = dbConnect();
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $comment = new Comment([
            'id' => $_GET['id']
        ]);

        $manager = new CommentsManager($bdd);
        $manager->can_signaled($comment);

        header('Location:?post_id='. $_GET['post_idu'] .'');
    }

    function RASComment(){
        $bdd = dbConnect();
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $comment = new Comment([
            'id' => $_GET['RASid']
        ]);

        $manager = new CommentsManager($bdd);
        $manager->unsignaled($comment);

        header('Location:?action=moderation_commentaire');
    }

    function deleteComment(){
        $bdd = dbConnect();
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

        $comment = new Comment([
            'id' => $_GET['id']
        ]);

        $manager = new CommentsManager($bdd);
        $manager->delete($comment);

        header('Location:?post_id='. $_GET['post_idu'] .'');

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
        $bdd = dbConnect();
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            if($_POST['title'] != null && $_POST['content'] != null){

                $post = new Post([
                    'title' => $_POST['title'],
                    'content' => $_POST['content']
                ]);

                $manager = new PostsManager($bdd);
                $manager->add($post);
            }
            
        header('Location:?action=latest_posts');
    }

    function moderationCommentaire(){
        require('views/pages/moderation_commentaire.php');
    }

?>