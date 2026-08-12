<?php
require_once dirname(__DIR__) . "/model/classe.model.php";
require_once dirname(__DIR__) . "/model/periode.model.php";
require_once dirname(__DIR__) . "/model/matiere.model.php";
require_once dirname(__DIR__) . "/model/evaluation.model.php";

function affichevue()
{
    $matieres = getAllMatiere();
    $periodes = getAllPeriode();
    $classes  = getAllClasse();
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_period = $_POST['periode'];
        $id_classe = $_POST['classe'];
        $id_matiere = $_POST['matiere'];
        $moyen = calcul_moyen($id_period, $id_classe, $id_matiere);
    }

    require_once dirname(__DIR__) . "/view/note.html.php";
}
