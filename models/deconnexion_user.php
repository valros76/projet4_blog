<?php
    session_start();

    $_SESSION = array();
    session_destroy();

    echo 'Vous êtes déconnecté !';

    header('Location: ../index.php');
?>