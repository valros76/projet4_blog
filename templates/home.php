<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= $locateCss; ?>"/>
    <title><?= $title; ?></title>
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

        <footer id="footHome">
            <?= $footer; ?>
        </footer>
    </div>
</body>
</html>