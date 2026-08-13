<?php 
function calcul_moyen(int $id_period, int $id_classe, int $id_matiere): float {
    $pdo = connexionDB();
    $sql = "SELECT
        a.nom AS annee_scolaire,
        ROUND(
            AVG(
                (
                    (
                        COALESCE(ev.devoir1, 0) + COALESCE(ev.devoir2, 0)
                    ) / 2 + COALESCE(ev.composition, 0)
                ) / 2
            ),
        2
        ) AS moyenne_generale
    FROM
        evaluations ev
    INNER JOIN inscriptions i ON i.id = ev.inscription_id
    INNER JOIN anneescolaires a ON a.id = i.annee_id
    WHERE
        i.classe_id = :id_classe
        AND ev.matiere_id = :id_matiere
        AND ev.periode_id = :id_period
        AND a.actif = 1
    GROUP BY
        a.nom
    ";

    $data = [
        'id_period' => $id_period,
        'id_classe' => $id_classe,
        'id_matiere' => $id_matiere
    ];

    $resulte = executeQuery($pdo, $sql, $data, true);

    // Gestion du cas où aucune donnée n'est trouvée
    if (!$resulte || !isset($resulte['moyenne_generale']) || $resulte['moyenne_generale'] === null) {
        return 0.0;
    }
    $pdo=null;

    return (float) $resulte['moyenne_generale'];
}

function getAllEval(int $id_period, int $id_classe, int $id_matiere): array
{
    $pdo = connexionDB();

    $sql = "SELECT 
        ev.id AS evid,
        e.nom,
        e.prenom,
        e.matricule,
        COALESCE(ev.devoir1, 0) AS devoir1,
        COALESCE(ev.devoir2, 0) AS devoir2,
        COALESCE(ev.composition, 0) AS composition,
        ROUND(
            (
                COALESCE(ev.devoir1, 0) 
                + COALESCE(ev.devoir2, 0) 
                + 2 * COALESCE(ev.composition, 0)
            ) / 4, 2
        ) AS moyenne,
        CASE 
            WHEN ROUND((COALESCE(ev.devoir1, 0) + COALESCE(ev.devoir2, 0) + 2 * COALESCE(ev.composition, 0)) / 4, 2) < 10 THEN 'Insuffisant'
            WHEN ROUND((COALESCE(ev.devoir1, 0) + COALESCE(ev.devoir2, 0) + 2 * COALESCE(ev.composition, 0)) / 4, 2) BETWEEN 10 AND 12 THEN 'Passable'
            WHEN ROUND((COALESCE(ev.devoir1, 0) + COALESCE(ev.devoir2, 0) + 2 * COALESCE(ev.composition, 0)) / 4, 2) > 12 
                AND ROUND((COALESCE(ev.devoir1, 0) + COALESCE(ev.devoir2, 0) + 2 * COALESCE(ev.composition, 0)) / 4, 2) <= 14 THEN 'Assez bien'
            WHEN ROUND((COALESCE(ev.devoir1, 0) + COALESCE(ev.devoir2, 0) + 2 * COALESCE(ev.composition, 0)) / 4, 2) > 14 
                AND ROUND((COALESCE(ev.devoir1, 0) + COALESCE(ev.devoir2, 0) + 2 * COALESCE(ev.composition, 0)) / 4, 2) <= 16 THEN 'Bien'
            WHEN ROUND((COALESCE(ev.devoir1, 0) + COALESCE(ev.devoir2, 0) + 2 * COALESCE(ev.composition, 0)) / 4, 2) > 16 THEN 'Très bien'
        END AS appreciation
    FROM inscriptions i
    INNER JOIN eleves e ON e.id = i.eleve_id
    LEFT JOIN evaluations ev 
        ON ev.inscription_id = i.id 
        AND ev.matiere_id = :matiere_id
        AND ev.periode_id = :periode_id
    WHERE i.classe_id = :classe_id
        AND i.annee_id = (SELECT id FROM anneeScolaires WHERE actif = 1)
    ORDER BY ev.id ASC";

    $data = [
        'periode_id' => $id_period,
        'classe_id'  => $id_classe,
        'matiere_id' => $id_matiere,
    ];

    $resulte = executeQuery($pdo, $sql, $data, false);
    $pdo = null;
    return $resulte;
}