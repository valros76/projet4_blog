<?php
    $title="Acceuil";
    $locateCss="../../templates/css/style.css";
?>

<?php ob_start();
    echo '
            <h1>Chapitre 1 - Le commencement</h1>
            <fieldset>
                <legend>Menu</legend>
                    <ul id="navHome">
                        <li><a href="../../index.php">Acceuil</a></li>
                        <li><a href="">Contact</a></li>
                    </ul>
            </fieldset>
        ';
$header = ob_get_clean();?>

<?php ob_start();
    echo '<article>
            <h3>
                Chapitre 1 - Le commencement
            </h3>
            <div class="texteDescription">
                <p>
                    Lorem ipsum dolor sit amet.
                    <br>
                    <br>
                    Lorem ipsum dolor sit amet.
                    <br>
                    <br>
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. 
                    Modi molestias nemo neque eos, vitae quia nostrum dignissimos recusandae,
                    esse est, quo asperiores maxime itaque! 
                    Adipisci quam id ipsa necessitatibus est magni sapiente numquam, 
                    nam praesentium similique placeat incidunt fugit hic.
                </p>
            </div>
        </article>';
$content = ob_get_clean();?>

<?php ob_start();
    echo '
        <fieldset>
            <legend>Commentaires</legend>
            <div id="showComments">
                
            </div>
        </fieldset>
    ';
$comments = ob_get_clean();?>

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