<?php 
require('../../models/bdd.php');
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= $locateCss; ?>"/>
    <title><?= $title; ?></title>
    <?php
    if(isset($_SESSION['pseudo']) && $_SESSION['pseudo'] != null){
        $manager = new UsersManager($bdd);
        $admin = $manager->get($_SESSION['pseudo']);
            if($admin->id_group() != 3){
                echo "<script src=\"https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=aodwpl4fidsfjdc4lsy7dwdfx22id12dxjh7t7s5vietisvy\"></script>";
                echo "
                    <script>
                        tinymce.init({ 
                            selector:'#mytextarea'
                            plugins: [
                                'advlist autolink lists link image charmap print preview anchor textcolor',
                                'searchreplace visualblocks code fullscreen',
                                'insertdatetime media table contextmenu paste code help wordcount'
                              ],
                              toolbar: 'insert | undo redo |  formatselect | bold italic backcolor  | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat | help'
                        });
                    </script>
                    ";
            }
    }
    ?>
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
</body>
</html>