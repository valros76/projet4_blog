<?php
    function loadClass($class){
        require 'classes/'.$class.'.php';
    }
    spl_autoload_register('loadClass');
    require('bdd.php');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        if($_POST['title'] != null && $_POST['content'] != null){

            $post = new Post([
                'title' => $_POST['title'],
                'content' => $_POST['content']
            ]);

            $manager = new PostsManager($bdd);
            $manager->add($post);
        }
        
    header('Location:../index.php');
?>