<?php
   
    $bdd = dbConnect();
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
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
                        <li><a href="?action=home">Acceuil</a></li>
        ';
        if(isset($_SESSION['pseudo'])){
            echo    '<li><a href="?action=member_space">Mon profil</a></li>';
            if($_SESSION['id_group'] == 3){
                echo '<li><a href="?action=create_post">Créer un article</a></li>';
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
            $lastComments = $bdd->query('SELECT * FROM comments WHERE is_signaled = 1 ORDER BY id DESC LIMIT 0,50');
            while($donnees = $lastComments->fetch()){
                echo '<hr/><p>ID: '. htmlspecialchars($donnees['id']) .' -  Pseudo: <span id="author">' . htmlspecialchars($donnees['author']) . '</span> <hr width="20"/>Message:<br/><p> ' . htmlspecialchars($donnees['comment']) . '</p><hr width=20/>Date:<br/><p class="dateComment">' . htmlspecialchars($donnees['date_comment']) . '<br/><br/><a href="?id='. htmlspecialchars($donnees['id']) .'">Supprimer le commentaire</a> -- <a href="?RASid='. htmlspecialchars($donnees['id']) .'">R.A.S</a></p></p>';
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
                <li><a href="?action=latest_posts">Derniers posts</a></li>
            </ul>
        </fieldset>
    ';
$footer = ob_get_clean();?>

<?php require('templates/home.php'); ?>