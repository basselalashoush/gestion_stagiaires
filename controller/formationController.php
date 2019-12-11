<?php

require_once 'model/Formation.php';
$formation = new Formation();


$action = $_REQUEST['action'];
switch ($action) {
    case 'listeFormations': {
            $formations = $formation->getFormations();
            include 'view/listeFormations.php';
            break;
        }
    case 'addFormation': {
            include 'view/formation.php';
            break;
        }
    case 'deleteFormation': {
            $idFormation = $_REQUEST['id_formation'];
            $formation->deleteFormation($idFormation);
            ?>
                    <div class="alert alert-success">
                       <?= $success = "la Formation a été supprimée"; ?>
                      <p><a href="index.php?uc=formation&action=listeFormations">Liste Formations</a></p>
                    </div>
            <?php
            break;
        }
    case 'updateFormation': {
            $idFormation = $_REQUEST['id_formation'];
            $laformation = $formation->getFormation($idFormation);
            include 'view/formation.php';
            break;
        }
    case 'recordFormation': {
            $args1 = array(
                'id_formation' => FILTER_VALIDATE_INT,
                'libelle' => FILTER_SANITIZE_STRING,
                'lieu' => FILTER_SANITIZE_STRING,
                'commentaire' => FILTER_SANITIZE_STRING,
                'dateDebutFormation' => FILTER_SANITIZE_STRING,
                'dateFinFormation' => FILTER_SANITIZE_STRING,
            );
            $formations = $formation->getFormations();
            $dataFormation = [];
            foreach ($formations  as $uneFormation) {
                $dataFormation [] = $uneFormation->libelle;
            }
            $myinputs = filter_input_array(INPUT_POST, $args1, false);
            //  var_dump(!is_null($myinputs['id_formation'])); 
            // exit(); 

            if(in_array($myinputs['libelle'] , $dataFormation) && empty($myinputs['id_formation'])) : ?>
                <div class="alert alert-danger">
                    <?= $erreur = "le nom de la formation exisste déjà"; ?>
                    <p><a href="index.php?uc=formation&action=listeFormations">Liste Formations</a></p>
                </div>
            <?php else : ?>
                <?php
            if ($myinputs["id_formation"] > 0) {
                $idFormation = $myinputs["id_formation"];
                unset($myinputs["id_formation"]);
                $formation->modifierFormation($myinputs,$idFormation);
                ?>
                             <div class="alert alert-success">
                                <?= $success = "la Formation a été modifiée"; ?>
                                <p><a href="index.php?uc=formation&action=listeFormations">Liste Formations</a></p>
                            </div>
            <?php
            } else {
                // Puisque qu'on ajoute une compétition, pas besoin de id_competition
                // On le supprime du tableau
                unset($myinputs['id_formation']);
                $formation->ajouterFormation($myinputs);
                ?>
                            <div class="alert alert-success">
                                <?= $success = "la Formation a été engregistrée"; ?>
                                <p><a href="index.php?uc=formation&action=listeFormations">Liste Formations</a></p>
                            </div>
                <?php } ?>
        <?php break; ?>
        <?php endif; ?>
        <?php }}?>