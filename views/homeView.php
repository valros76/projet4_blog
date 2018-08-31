
<?php
    $title="Acceuil";
?>

<?php ob_start();
    echo '
            <h1>Acceuil</h1>
            <fieldset>
                <legend>Menu</legend>
                    <ul id="navHome">
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
            echo  '
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