<?php 
require_once dirname(__DIR__)."/model/utilisateur.model.php";

function login(){
    if ($_SERVER['REQUEST_METHOD']=='POST'){
    $email=$_POST['email'];
        $password=$_POST['motdepasse'];
           $result=getUtilisateur($email);

           if(!empty($result) && $password ===$result['mot_de_passe']){

            setSession('conexion' , $result);
            header("Location:http://localhost:8000/");
            exit;
           }

    }
   

require_once dirname(__DIR__)."/view/authentification.html.php";

}