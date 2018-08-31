<?php
    session_start();
    $_SESSION = array();
    session_destroy();
    header('Location:?action=home');
    echo 'Vous êtes déconnecté !';
    
?>