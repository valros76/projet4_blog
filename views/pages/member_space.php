<?php
    session_start();
    function loadClass($class){
        require '../../models/classes/'.$class.'.php';
    }
    
    spl_autoload_register('loadClass');
    require('../../models/bdd.php');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    
    $manager = new UsersManager($bdd);
    $profile = $manager->get($_SESSION['pseudo']);

?>

<?php
    $title="Profil membre";
    $locateCss="../../templates/css/style.css";
?>

<?php ob_start();
    echo '
            <h1>Mon profil</h1>
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
        Mes informations
    </h3>
    <div class="texteProfil">
        <fieldset>
            <p><b>Nom</b>  <br/><br/>{', $_SESSION['pseudo'] ,'}</p>
            <p><b>Email</b> <br/><br/>{', $profile->email() ,'}</p>
            <p><b>Date d\'inscription</b> <br/><br/>{', $profile->inscription_date() ,'}</p><br/>
        </fieldset>
    </div>
</article>';
$content = ob_get_clean();?>

<?php ob_start();
    
$comments = ob_get_clean();?>

<?php ob_start();
    echo '
            <section>
                <form method="post">
                    <fieldset>
                        <legend>Modifier le mot de passe</legend>
                        <label for="ancientPassword">Ancien mot de de passe</label><input type="password" name="ancientPassword"/><br/><br/>
                        <label for="newPassword">Nouveau mot de passe</label><input type="password" name="newPassword"/><br/><br/>
                        <label for="confirmNewPassword">Confirmation <br/>du nouveau mot de passe</label><input type="password" name="confirmNewPassword"/><br/><br/>
                        <input type="submit" value="Changer le mot de passe" name="updatePassword"/>
                    </fieldset>
                </form>
            </section>
    ';    
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