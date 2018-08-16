<?php
    session_start();
    require('models/bdd.php');
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
    $title="Acceuil";
    $locateCss="templates/css/style.css";
?>

<?php ob_start();
    echo '
            <h1>Acceuil</h1>
            <fieldset>
                <legend>Menu</legend>
                    <ul id="navHome">
                        <li><a href="">Acceuil</a></li>
        ';
        if(isset($_SESSION['pseudo'])){
            echo    '<li><a href="views/pages/member_space.php">Mon profil</a></li>';
            if($_SESSION['id_group'] == 3){
                echo '<li><a href="views/pages/create_post.php">Créer un article</a></li>';
                echo '<li><a href="views/pages/moderation_commentaire.php">Modérer les commentaires</a></li>';
            }
            echo   '<li><a href="models/deconnexion_user.php">Se deconnecter</a></li>';
        } 
        else{             
            echo   '
                    <li><a href="views/pages/inscription.php">S\'inscrire</a></li>
                    <li><a href="views/pages/connexion.php">Se connecter</a></li>
                ';
        }
        echo        '
                    </ul>
            </fieldset>
        ';
$header = ob_get_clean();?>

<?php ob_start();
    echo '<article>
            <h3>
                Bienvenue sur mon blog
            </h3>
            <div class="texteDescription">
                <p>
                    Je me nomme Jean Forteroche, je suis acteur et écrivain.
                    <br/><br/>
                    J\'ai créé ce blog pour écrire mon prochain roman qui se nommera "Billet simple pour l\'Alaska".
                    <br/><br/>
                    Ce blog fera office de "livre virtuel", j\'écrirais mon livre chapitre par chapitre et rendrais le contenu accessible ici.
                    <br/><br/>
                    Je vous souhaite une bonne visite et une bonne lecture.
                </p>
            </div>
        </article>';
$content = ob_get_clean();?>

<?php ob_start();
    echo '
        <fieldset id="blocComments">
            <legend>Commentaires</legend>
            <div id="showComments">';
            require('models/bdd.php');;
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            
            
            $lastComments = $bdd->query('SELECT * FROM comments WHERE is_signaled = 0 ORDER BY id DESC LIMIT 0,5');
            while($donnees = $lastComments->fetch()){
                echo '<hr/><p>ID: '. htmlspecialchars($donnees['id']) .' - <span id="author">' . htmlspecialchars($donnees['author']) . '</span> <hr width="50"/><p>' . htmlspecialchars($donnees['comment']) . '</p><hr width=50/><p class="dateComment">Date: ' . htmlspecialchars($donnees['date_comment']) . '<br/><br/><a href="models/signaled_comment.php?id='. htmlspecialchars($donnees['id']) .'">Signaler le commentaire</a></p></p>';
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
                <li><a href="views/pages/latest_posts.php">Derniers posts</a></li>
            </ul>
        </fieldset>
    ';
$footer = ob_get_clean();?>

<?php require('templates/home.php'); ?>