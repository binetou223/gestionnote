<?php
require_once dirname(__DIR__)."/core/database.php";

function getAllMatiere():array{
    $pdo=connexionDB();
    $sql="SELECT * FROM matieres";
    $matieres=query($pdo,$sql,false);
        $pdo=null;

    return  $matieres;
}