<?php
        try{
            $bdd = new PDO('mysql:host=localhost;dbname=id6846891_blog_ecrivain;charset=utf8', 'id6846891_valros76', 'granpeper4', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch(Exception $e){
            die('Erreur : ' . $e->getMessage());
        }
?>