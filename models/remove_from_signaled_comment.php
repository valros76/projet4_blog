<?php

    $bdd = dbConnect();
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    $comment = new Comment([
        'id' => $_GET['RASid']
    ]);

    $manager = new CommentsManager($bdd);
    $manager->unsignaled($comment);

    header('Location:?action=moderation_commentaire');

?>