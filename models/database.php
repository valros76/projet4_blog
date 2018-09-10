<?php
    function dbConnect(){
        $dbData = parse_ini_file('config/bdd.ini');
        $dbData = $dbData;
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