<?php
    $bdd = dbConnect();
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
                Tous les articles
            </h2>
            <div class="texteDescription">
                <p>';
                    $lastPosts = $bdd->query('SELECT * FROM posts ORDER BY id DESC LIMIT 0,35');
                    while($donnees = $lastPosts->fetch()){
                        echo '<div id="postContent"><header><h3>'. htmlspecialchars($donnees['title']) .'</h3></header><hr/><br/><section>'. $donnees['content'] .'</section><br/><hr/><footer><p>'. $donnees['date'] .'</p><p><a href="?post_id='. $donnees['id'] .'">[Commentaires]</a></p></footer></div><br/><br/>';
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
                <li><a href="?action=latest_posts">Derniers posts</a></li>
            </ul>
        </fieldset>
    ';
$footer = ob_get_clean();?>

<?php require('templates/home.php'); ?>