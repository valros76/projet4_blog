<?php
    $bdd = dbConnect();
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);

    $manager = new UsersManager($bdd);
    $profile = $manager->get($_SESSION['pseudo']);
    
?>

<?php
    $title="Profil membre";
?>

<?php ob_start();
    echo '
            <h1>Mon profil</h1>
            <fieldset>
                <legend>Menu</legend>
                    <ul id="navHome">
                        <li><a href="?action=home">Acceuil</a></li>
        ';
        if(isset($_SESSION['pseudo'])){
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
    <h3>
        Mes informations
    </h3>
    <div class="texteProfil">
        <fieldset>
                <p><b>Nom</b>  <br/><br/>{', $profile->pseudo() ,'}</p>
                <p><b>Email</b> <br/><br/>{', $profile->email() ,'}</p>
                <p><b>Date d\'inscription</b> <br/><br/>{', $profile->inscription_date() ,'}</p>
                <p><b>Rôle</b> <br/><br/>{', $profile->id_group() ,', <i>', $profile->group_name() ,'</i>}</p>
        </fieldset>
    </div>
</article>';
$content = ob_get_clean();?>

<?php ob_start();
    
$comments = ob_get_clean();?>

<?php ob_start();
    
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