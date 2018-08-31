<?php

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
?>