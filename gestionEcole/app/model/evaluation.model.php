<?php 
function calcul_moyen(int $id_period, int $id_classe, int $id_matiere ):float{
    $pdo=connexionDB();
    $sql="SELECT ROUND(COALESCE(AVG(moyenne_eleve), 0), 2) AS moyenne_classe
FROM (
    SELECT 
        i.id AS inscription_id,
        ROUND(
            (COALESCE(MAX(CASE WHEN ev.evaluation = 'Devoir1' THEN ev.note END), 0)
           + COALESCE(MAX(CASE WHEN ev.evaluation = 'Devoir2' THEN ev.note END), 0)
           + 2 * COALESCE(MAX(CASE WHEN ev.evaluation = 'Composition' THEN ev.note END), 0)
            ) / 4, 2
        ) AS moyenne_eleve
    FROM inscriptions i
    INNER JOIN anneescolaire a 
        ON a.id = i.id_ann
    INNER JOIN matiereclasses mc 
        ON mc.id_classe = i.id_classe
    LEFT JOIN evaluations ev 
        ON ev.inscription_id   = i.id
       AND ev.matiereclasse_id = mc.id
       AND ev.periode_id       = :id_period   
    WHERE i.id_classe   = :id_classe
      AND mc.id_matire  = :id_matiere
      AND a.actif       = 1                      
    GROUP BY i.id
) ";

$data=[
    'id_period'=>$id_period,
    'id_classe'=>$id_classe,
    'id_matiere'=>$id_matiere
];
$resulte = executeQuery( $pdo, $sql, $data,  true);
return $resulte['moyenne_classe'];

}