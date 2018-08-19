<?php
    session_start();
    function loadClass($class){
        require '../../models/classes/'.$class.'.php';
    }
    
    spl_autoload_register('loadClass');
    require('../../models/bdd.php');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
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
                        echo '<div id="postContent"><header><h3>'. htmlspecialchars($donnees['title']) .'</h3></header><hr/><br/><section>'. $donnees['content'] .'</section><br/><hr/><footer><p>'. $donnees['date'] .'</p><p><a href="post_with_commentary.php?post_id='. $donnees['id'] .'">[Commentaires]</a></p></footer></div><br/><br/>';
                    }
            echo '</p>
            </div>
        </article>';
$content = ob_get_clean();?>

<?php ob_start();
    echo '';
$comments = ob_get_clean();?>

<?php ob_start();
    echo '';
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