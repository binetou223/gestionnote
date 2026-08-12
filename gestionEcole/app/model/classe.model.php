<?php
require_once dirname(__DIR__)."/core/database.php";
function getAllClasse():array{
    $pdo=connexionDB();
    $sql="SELECT *FROM classe";
    $classes=query($pdo,$sql,false);
    $pdo=null;
    return  $classes;
}