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
    $title="Modération des commentaires";
    $locateCss="../../templates/css/style.css";
?>

<?php ob_start();
    echo '
            <h1>Espace de modération des commentaires</h1>
            <fieldset>
                <legend>Menu</legend>
                    <ul id="navHome">
                        <li><a href="../../index.php">Acceuil</a></li>
        ';
        if(isset($_SESSION['pseudo'])){
            echo    '<li><a href="member_space.php">Mon profil</a></li>';
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
            <h3>
                Comment modérer les commentaires ?
            </h3>
            <div class="texteDescription">
                <p>
                    Si un commentaire n\'a pas sa place sur le site et qu\'il est remonté par les utilisateurs,
                    vous pouvez choisir de la supprimer ou de le laisser visible.
                    <br/><br/>
                    Pour supprimer un commentaire, appuyez sur le bouton "supprimer".
                    <br/><br/>
                    Pour laisser le commentaire visible, appuyez sur le bouton "R.A.S".
                </p>
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
                echo '<hr/><p>  <span id="author">' . htmlspecialchars($donnees['author']) . '</span> <hr width="20"/> ' . htmlspecialchars($donnees['comment']) . '<hr width=20/><p class="dateComment">' . $donnees['date_comment'] . '</p></p>';
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
                <li><a href="">Chapitre 1</a></li>
            </ul>
        </fieldset>
    ';
$footer = ob_get_clean();?>

<?php require('../../templates/home.php'); ?>