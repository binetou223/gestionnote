<?php 
function getUtilisateur(string $email){
    $connexion=connexiondb();
$sql="SELECT u.*,r.* from utilisateurs u
inner join roles r on u.role_id=r.id
 WHERE
email=:email 
";
$result=executeQuery($connexion,$sql,[
    'email'=>$email
]);
$connexion=null;
return $result;
};