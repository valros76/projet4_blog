

<?php
    $title="Connexion à l'espace membre";
?>

<?php ob_start();
    echo '
            <h1>Page de connexion</h1>
            <fieldset>
                <legend>Menu</legend>
                    <ul id="navHome">
                        <li><a href="?action=home">Acceuil</a></li>
                        <li><a href="?action=inscription">S\'inscrire</a></li>
                    </ul>
            </fieldset>
        ';
$header = ob_get_clean();?>

<?php ob_start();
    echo '<form action="?action=connect" method="post">
            <fieldset>
                <legend>Connexion</legend>
                <label for="pseudo">Pseudo</label><input type="text" name="pseudo"/><br/>
                <label for="password">Mot de passe</label><input type="password" name="password"/><br/>
                <input type="submit" name="connect"/>
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
                <li><a href="?action=inscription">S\'inscrire</a></li>
            </ul>
        </fieldset>
    ';
$footer = ob_get_clean();?>

<?php require('templates/home.php'); ?>