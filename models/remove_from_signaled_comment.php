<?php
function loadClass($class){
    require 'classes/'.$class.'.php';
}
spl_autoload_register('loadClass');

    require('bdd.php');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    $comment = new Comment([
        'id' => $_GET['id']
    ]);

    $manager = new CommentsManager($bdd);
    $manager->unsignaled($comment);

    header('Location: ../views/pages/moderation_commentaire.php');

?>