<?php
session_start();
function loadClass($class){
    require 'models/classes/'.$class.'.php';
}

spl_autoload_register('loadClass');
require('controllers/controller.php');

if(isset($_GET['action'])){
    if($_GET['action'] === 'home'){
        home();
    }
    if($_GET['action'] === 'inscription'){
        inscription();
    }
    if($_GET['action'] === 'new_inscription'){
        new_inscription();
    }
    if($_GET['action'] === 'connexion'){
        connexion();
    }
    if($_GET['action'] === 'connect'){
        connect();
    }
    if($_GET['action'] === 'deconnexion'){
        deconnexion();
    }
    if($_GET['action'] === 'member_space'){
        memberSpace();
    }
    if($_GET['action'] === 'latest_posts'){
        latestPost();
    }
    if($_GET['action'] === 'post_comment'){
        postComment();
    }
    if($_GET['action'] === 'create_post'){
        createPost();
    }
    if($_GET['action'] === 'create_article'){
        createArticle();
    }
    if($_GET['action'] === 'moderation_commentaire'){
        moderationCommentaire();
    }
}
elseif(isset($_GET['post_id']) && $_GET['post_id'] > 0){
    postWithCommentary();
}
elseif(isset($_GET['id']) && $_GET['id'] > 0){
    actionOnComment();
}
elseif(isset($_GET['RASid']) && $_GET['RASid'] > 0){
    RASComment();
}
else{
    home();
}

?>