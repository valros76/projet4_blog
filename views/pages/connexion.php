<?php
    function loadClass($class){
        require '../../models/classes/'.$class.'.php';
    }
    
    spl_autoload_register('loadClass');
    require('../../models/bdd.php');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);


    if(isset($_POST['pseudo']) && isset($_POST['password']) && isset($_POST['connect'])){
        $pseudo = $_POST['pseudo'];
        $req = $bdd->prepare('SELECT id,mdp FROM users WHERE nom = :nom');
        $req->execute(array(
            'pseudo' => $pseudo));
        $resultat = $req->fetch(PDO::FETCH_ASSOC);

        $isPasswordCorrect = password_verify($_POST['password'], $resultat['password']);

        if(!$resultat){
            echo 'Mauvais identifiant / Mauvais mot de passe.';
        }
        else{
            if($isPasswordCorrect){
                session_start();
                $_SESSION['id'] = $resultat['id'];
                $_SESSION['pseudo'] = $pseudo;
                echo 'Vous êtes connecté !';
            }
            else{
                echo 'Mauvais identifiant ou mot de passe.';
            }
        }
    }
   
?>

<?php
    $title="Connexion à l'espace membre";
    $locateCss="../../templates/css/style.css";
?>

<?php ob_start();
    echo '
            <h1>Page de connexion</h1>
            <fieldset>
                <legend>Menu</legend>
                    <ul id="navHome">
                        <li><a href="../../index.php">Acceuil</a></li>
                        <li><a href="">Se connecter</a></li>
                    </ul>
            </fieldset>
        ';
$header = ob_get_clean();?>

<?php ob_start();
    echo '<form method="post">
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
                <li><a href="inscription.php">S\'inscrire</a></li>
            </ul>
        </fieldset>
    ';
$footer = ob_get_clean();?>

<?php require('../../templates/home.php'); ?>