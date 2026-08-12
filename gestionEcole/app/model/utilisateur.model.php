<?php 
function getUtilisateur(string $email){
    $connexion=connexiondb();
$sql="SELECT u.*,r.* from utilisateurs u
inner join roles r on u.id_role=r.id
 WHERE
email=:email 
;";
$result=executeQuery($connexion,$sql,[
    'email'=>$email
]);
$connexion=null;
return $result;
};