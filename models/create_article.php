<?php
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
?>