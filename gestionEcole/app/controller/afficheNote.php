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
    $moyenne  = null;
     $evaluations=[];

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['periode'], $_POST['classe'], $_POST['matiere'])) {
        $id_period  = (int) $_POST['periode'];
        $id_classe  = (int) $_POST['classe'];
        $id_matiere = (int) $_POST['matiere'];
        $moyenne = calcul_moyen($id_period, $id_classe, $id_matiere);
        $evaluations=getAllEval($id_period,  $id_classe,  $id_matiere );

    }

    require_once dirname(__DIR__) . "/view/note.html.php";
}