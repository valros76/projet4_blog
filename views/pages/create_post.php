<?php
    session_start();
    function loadClass($class){
        require '../../models/classes/'.$class.'.php';
    }
    spl_autoload_register('loadClass');
    require('../../models/bdd.php');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    if($_SESSION['pseudo'] != null){
        $manager = new UsersManager($bdd);
        $admin = $manager->get($_SESSION['pseudo']);
        if($admin->id_group() != 3){
            echo "Cette page est réservée à l'administrateur !";
            header('Location:../..');
        }
    }
    else{
        header('Location:../..');
    }

    
?>

<?php
    $title="Page de création de contenu";
    $locateCss="../../templates/css/style.css";
?>

<?php ob_start();
    echo '
            <h1>Création de posts</h1>
            <fieldset>
                <legend>Menu</legend>
                    <ul id="navHome">
                        <li><a href="../../index.php">Acceuil</a></li>
        ';
        if(isset($_SESSION['pseudo'])){
            echo    '<li><a href="member_space.php">Mon profil</a></li>';
            if($_SESSION['id_group'] == 3){
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
    echo '<article id="createArticle">
            <h3>
                Créer un post
            </h3>
            <div class="texteArticle">
                <p>
                    <fieldset id="createPost">
                        <legend>Créer un post</legend>
                        <form action="../../models/create_article.php" method="post">
                           <label for="title"><b>Titre</b></label><br/>
                           <input type="text" name="title"/>
                           <br/><br/>
                           <label for="content"><b>Contenu</b></label><br/>
                           <textarea class="tinyMCE" name="content" cols="30" rows="20"></textarea>
                           <br/><br/>
                           <input type="submit" value="Poster" name="postContent"/> 
                        </form>
                    </fieldset>
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
                <li><a href="chapitre1.php">Chapitre 1</a></li>
            </ul>
        </fieldset>
    ';
$footer = ob_get_clean();?>

<?php require('../../templates/home.php'); ?>