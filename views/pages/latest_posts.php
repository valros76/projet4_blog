<?php
    session_start();
    function loadClass($class){
        require '../../models/classes/'.$class.'.php';
    }
    
    spl_autoload_register('loadClass');
    require('../../models/bdd.php');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    $hint = "Vous pouvez agrandir la boite de message.";

    $manager = new CommentsManager($bdd);
    if(isset($_POST['creer']) && isset($_SESSION['pseudo']) && isset($_POST['comment'])){
        if($_SESSION['pseudo'] != null && $_POST['comment'] != null){
            $comment = new Comment([
                'author' => $_SESSION['pseudo'],
                'comment' => $_POST['comment']
            ]);
            
            if($_SESSION['pseudo'] == null){
                echo 'Vous n\'êtes pas connecté.';
                $hint = 'Vous n\'êtes pas connecté.';
                unset($comment);
            }
            if($_POST['comment'] == null){
                echo 'Vous n\'avez pas rempli la partie message.';
                $hint = 'Vous n\'avez pas rempli la partie message.';
                unset($comment);
            }
            if($manager->exists_comment($comment->comment())){
                echo 'Vous avez déjà posté ce commentaire.';
                $hint = 'Vous avez déjà posté ce commentaire.';
                unset($comment);
            }
            else{
                $manager->add($comment);
            }
        }
    }
?>

<?php
    $title="Derniers articles";
    $locateCss="../../templates/css/style.css";
?>

<?php ob_start();
    echo '
            <h1>Derniers articles</h1>
            <fieldset>
                <legend>Menu</legend>
                    <ul id="navHome">
                        <li><a href="../../index.php">Acceuil</a></li>
        ';
        if(isset($_SESSION['pseudo'])){
            echo    '<li><a href="member_space.php">Mon profil</a></li>';
            if($_SESSION['id_group'] == 3){
                echo '<li><a href="create_post.php">Créer un article</a></li>';
                echo '<li><a href="moderation_commentaire.php">Modérer les commentaires</a></li>';
            }
            echo   '<li><a href="../../models/deconnexion_user.php">Se deconnecter</a></li>';
        } 
        else{             
            echo   '
                    <li><a href="inscription.php">S\'inscrire</a></li>
                    <li><a href="connexion.php">Se connecter</a></li>
                ';
        }
        echo        '
                    </ul>
            </fieldset>
        ';
$header = ob_get_clean();?>

<?php ob_start();
    echo '<article>
            <h2>
                Tous les articles
            </h2>
            <div class="texteDescription">
                <p>';
                    $lastPosts = $bdd->query('SELECT * FROM posts ORDER BY id DESC LIMIT 0,3');
                    while($donnees = $lastPosts->fetch()){
                        echo '<div id="postContent"><header><h3>'. htmlspecialchars($donnees['title']) .'</h3></header><hr/><br/><section>'. $donnees['content'] .'</section><br/><hr/><footer><p>'. $donnees['date'] .'</p></footer></div><br/><br/>';
                    }
            echo '</p>
            </div>
        </article>';
$content = ob_get_clean();?>

<?php ob_start();
    echo '
        <fieldset id="blocComments">
            <legend>Commentaires</legend>
            <div id="showComments">';
            require('../../models/bdd.php');
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            
            $lastComments = $bdd->query('SELECT * FROM comments ORDER BY id DESC LIMIT 0,5');
            while($donnees = $lastComments->fetch()){
                echo '<hr/><p>ID: '. htmlspecialchars($donnees['id']) .' - <span id="author">' . htmlspecialchars($donnees['author']) . '</span> <hr width="50"/><p>' . $donnees['comment'] . '</p><hr width=50/><p class="dateComment">Date: ' . htmlspecialchars($donnees['date_comment']) . '<br/><br/>';
                if(isset($_SESSION['pseudo'])){
                    if($_SESSION['id_group'] >= 1){    
                        echo '<a href="models/signaled_comment.php?id='. htmlspecialchars($donnees['id']) .'">Signaler le commentaire</a>';
                            if($_SESSION['id_group'] == 3){
                                echo ' -- <a href="models/delete_signaled_comment.php?id='. htmlspecialchars($donnees['id']) .'">Supprimer le commentaire</a>';
                            }
                    }
                }
                else{}
                echo '</p></p>';
            }
    echo '
            </div>
        </fieldset>';
$comments = ob_get_clean();?>

<?php ob_start();
   if(isset($_SESSION['pseudo'])){
    echo '
        <form method="post">
            <fieldset>
            <legend>Poster un commentaire</legend>
                <label for="comment">Message</label><textarea row="5" cols="50" name="comment"></textarea><br/>
                <p id="textareaHint">', $hint ,'</p><br/>
                <input type="submit" value="Poster un commentaire" name="creer"/>
            </fieldset>
        </form>
    ';
}
else{
    echo '';
}
$postComment = ob_get_clean();?>

<?php ob_start();
    echo '
        <fieldset>
            <legend>Pages</legend>
            <ul>
                <li><a href="latest_posts.php">Derniers posts</a></li>
            </ul>
        </fieldset>
    ';
$footer = ob_get_clean();?>

<?php require('../../templates/home.php'); ?>