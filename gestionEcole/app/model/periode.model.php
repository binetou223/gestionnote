<?php
require_once dirname(__DIR__)."/core/database.php";
function getAllPeriode():array{
    $pdo=connexionDB();
    $sql="SELECT *FROM periode";
    $periodes=query($pdo,$sql,false);
      $pdo=null;
    return  $periodes;
}