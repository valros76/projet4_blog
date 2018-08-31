<?php

    function home(){
        require('views/homeView.php');
    }

    function inscription(){
        require('views/pages/inscription.php');
    }

    function new_inscription(){
        require('models/inscription_user.php');
    }

    function connexion(){
        require('views/pages/connexion.php');
    }

    function connect(){
        require('models/connexion_user.php');
    }

    function deconnexion(){
        require('models/deconnexion_user.php');
    }

    function dbConnect(){
        $dbData = parse_ini_file('config/bdd.ini');
        $host = $dbData['host'];
        $dbname = $dbData['dbname'];
        $username = $dbData['username'];
        $password = $dbData['password'];
        try{
            $bdd = new PDO('mysql:host='. $host .';dbname='. $dbname .';charset=utf8', $username, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            return $bdd;
        }
        catch(Exeption $e){
            die('Erreur : ' .$e->getMessage());
        }
    }

?>