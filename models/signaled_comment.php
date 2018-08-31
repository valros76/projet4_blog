<?php
    $bdd = dbConnect();
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    $comment = new Comment([
        'id' => $_GET['id']
    ]);

    $manager = new CommentsManager($bdd);
    $manager->can_signaled($comment);

    header('Location:?post_id='. $_GET['post_idu'] .'');

?>