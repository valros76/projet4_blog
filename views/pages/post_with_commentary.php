<?php
    $bdd = dbConnect();
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $hint = "Vous pouvez agrandir la boite de message.";
?>

<?php
    $title= "Article";
?>

<?php ob_start();
    echo '
            <h1>Article</h1>
            <fieldset>
                <legend>Menu</legend>
                    <ul id="navHome">
                        <li><a href="?action=home">Acceuil</a></li>
        ';
        if(isset($_SESSION['pseudo'])){
            echo    '<li><a href="?action=member_space">Mon profil</a></li>';
            if($_SESSION['id_group'] == 3){
                echo '<li><a href="?action=create_post">Créer un article</a></li>';
                echo '<li><a href="?action=moderation_commentaire">Modérer les commentaires</a></li>';
            }
            echo   '<li><a href="?action=deconnexion">Se deconnecter</a></li>';
        } 
        else{             
            echo   '
                    <li><a href="?action=inscription">S\'inscrire</a></li>
                    <li><a href="?action=connexion">Se connecter</a></li>
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
                Article
            </h2>
            <div class="texteDescription">
                <p>';
                    $lastPosts = $bdd->query('SELECT * FROM posts WHERE id ='.$_GET['post_id']);
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
        
        
        $lastComments = $bdd->query('SELECT * FROM comments WHERE post_id = '.$_GET['post_id'].' ORDER BY id DESC LIMIT 0,5');
        while($donnees = $lastComments->fetch()){
            echo '<hr/><p><span id="author">' . htmlspecialchars($donnees['author']) . '</span> <hr width="50"/><p>' . $donnees['comment'] . '</p><hr width=50/><p class="dateComment">Date: ' . htmlspecialchars($donnees['date_comment']) . '<br/><br/>';
            if(isset($_SESSION['pseudo'])){
                if($_SESSION['id_group'] == 1 OR $_SESSION['id_group'] == 2){    
                    echo '<a href="?id='. htmlspecialchars($donnees['id']) .'&post_idu='. $_GET['post_id'] .'">Signaler le commentaire</a>';     
                }
                if($_SESSION['id_group'] == 3){
                    echo '<a href="?id='. htmlspecialchars($donnees['id']) .'&post_idu='. $_GET['post_id'] .'">Supprimer le commentaire</a>';
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
        <form action="?action=post_comment&post_idu='. $_GET['post_id'] .'" method="post" >
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
                <li><a href="?action=latest_posts">Derniers posts</a></li>
            </ul>
        </fieldset>
    ';
$footer = ob_get_clean();?>

<?php require('templates/home.php'); ?>