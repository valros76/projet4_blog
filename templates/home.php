<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= $locateCss; ?>"/>
    <title><?= $title; ?></title>
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=aodwpl4fidsfjdc4lsy7dwdfx22id12dxjh7t7s5vietisvy"></script>
    <script>tinymce.init({ 
        selector:'textarea',
        themes:'advanced',
        width:'99.6%',
        height:'auto'
         });</script>
</head>
<body>
    <div id="containerHome">
        <header id="headHome">
            <?= $header; ?>
        </header>

        <section id="contentHome">
            <?= $content; ?>
        </section>

        <section id="comments">
            <?= $comments; ?>
        </section>

        <section id="postComment">
            <?= $postComment; ?>
        </section>

        <footer id="footHome">
            <?= $footer; ?>
        </footer>
    </div>
    <?php
    if(isset($_SESSION['pseudo']) && $_SESSION['pseudo'] != null){
        $manager = new UsersManager($bdd);
        $admin = $manager->get($_SESSION['pseudo']);
            if($admin->id_group() != 3){
                echo '<script src="js/jquery.min.js"></script>';
                echo "<script src=\"js/tinymce/tinymce.min.js\"></script>";
                echo "<script src=\"js/tinyInit.js\"></script>";
            }
    }
    ?>
    
</body>
</html>