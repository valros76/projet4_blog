
<?php
$title="Inscription";
?>

<?php ob_start();
echo '
        <h1>Page d\'inscription</h1>
        <fieldset>
            <legend>Menu</legend>
                <ul id="navHome">
                    <li><a href="?action=home">Acceuil</a></li>
                    <li><a href="?action=connexion">Se connecter</a></li>
                </ul>
        </fieldset>
    ';
$header = ob_get_clean();?>

<?php ob_start();
echo '<form action="?action=new_inscription" method="post">
        <fieldset>
            <legend>Inscription</legend>
            <label for="pseudo">Pseudo</label><input type="text" name="pseudo"/><br/>
            <label for="password">Mot de passe</label><input type="password" name="password"/><br/>
            <label for="password">Confirmer le mot de passe</label><input type="password" name="confirmPassword"/><br/>
            <label for="email">Email</label><input type="email" name="email"/><br/>
            <input type="submit" name="inscription"/>
        </fieldset>
    </form>';
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
        <legend>Inscription</legend>
        <ul>
            <li><a href="?action=connexion">Se connecter</a></li>
        </ul>
    </fieldset>
';
$footer = ob_get_clean();?>

<?php require('templates/home.php'); ?>