<?php
        try{
            $bdd = new PDO('mysql:host=localhost;dbname=blog_ecrivain;charset=utf8', 'valros76', 'granpeper4', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch(Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
?>