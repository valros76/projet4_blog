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
                        <li><a href="">Contact</a></li>
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
        <fieldset>
            <legend>Pages</legend>
            <ul>
                <li><a href="views/pages/chapitre1.php">Chapitre 1</a></li>
            </ul>
        </fieldset>
    ';
$footer = ob_get_clean();?>

<?php require('templates/home.php'); ?>