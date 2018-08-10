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
        <fieldset id="blocComments">
            <legend>Commentaires</legend>
            <div id="showComments">';
            $bdd = new PDO('mysql:host=localhost;dbname=blog_ecrivain;charset=utf8', 'root', '');
            $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
            
            $lastComments = $bdd->query('SELECT * FROM comments ORDER BY id DESC LIMIT 0,5');
            while($donnees = $lastComments->fetch()){
                echo '<hr/><p>  <span id="author">' . htmlspecialchars($donnees['author']) . '</span> <hr width="20"/> ' . htmlspecialchars($donnees['comment']) . '<hr width=20/><p class="dateComment">' . $donnees['date_comment'] . '</p></p>';
            }
    echo '
            </div>
        </fieldset>';
$comments = ob_get_clean();?>

<?php ob_start();
    echo '
        <form method="post">
            <fieldset>
            <legend>Poster un commentaire</legend>
                <label for="comment">Message</label><textarea row="5" cols="50" name="comment"></textarea><br/>
                <p id="textareaHint">Vous pouvez agrandir la boite de message.</p><br/>
                <input type="submit" value="Poster un commentaire" name="creer"/>
            </fieldset>
        </form>
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