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
            
            $lastComments = $bdd->query('SELECT * FROM comments WHERE is_signaled = 1 ORDER BY id DESC LIMIT 0,10');
            while($donnees = $lastComments->fetch()){
                echo '<hr/><p>ID: '. htmlspecialchars($donnees['id']) .' -  Pseudo: <span id="author">' . htmlspecialchars($donnees['author']) . '</span> <hr width="20"/>Message:<br/><p> ' . htmlspecialchars($donnees['comment']) . '</p><hr width=20/>Date:<br/><p class="dateComment">' . htmlspecialchars($donnees['date_comment']) . '<br/><br/><a href="../../models/delete_signaled_comment.php?id='. htmlspecialchars($donnees['id']) .'">Supprimer le commentaire</a> -- <a href="../../models/remove_from_signaled_comment.php?id='. htmlspecialchars($donnees['id']) .'">R.A.S</a></p></p>';
            }
    echo '
            </div>
        </fieldset>';
$comments = ob_get_clean();?>

<?php ob_start();
    echo '';
$postComment = ob_get_clean();?>

<?php ob_start();
    echo '
        <fieldset>
            <legend>Pages</legend>
            <ul>
                <li><a href="chapitre1.php">Chapitre 1</a></li>
            </ul>
        </fieldset>
    ';
$footer = ob_get_clean();?>

<?php require('../../templates/home.php'); ?>