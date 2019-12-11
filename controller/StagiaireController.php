<?php

require_once 'model/Stagiaire.php';
$stagiaire = new Stagiaire();
$erreur = null;
$success = null;

$action = $_REQUEST['action'];
switch ($action) {
    case 'listeStagiaire':
        $stagiaires = $stagiaire->getStagiaires();
        $allPeriodeFormateur = $stagiaire->getPeriodes();
        // récupérer toutes les formations
        $formations = $stagiaire->getAllFormations();
        include 'view/listeStagiaires.php';
        break;

    case 'addStagiaire':
        $formations = $stagiaire->getAllFormations();
        $periodes = $stagiaire->getPeriodes();
        include 'view/stagiaire.php';
        break;

    case 'deleteStagiaire':
        $id_stagiaire = $_REQUEST['id_stagiaire'];
        $stagiaire->deleteStagiaire($id_stagiaire);
        ?>
                <div class="alert alert-success">
                 <?= $success = "la stagiaire a été supprimée"; ?>
                <p><a href="index.php?uc=stagiaire&action=listeStagiaire">Liste Stagiaires</a></p>
                </div>
        <?php 
        break;

    case 'updateStagiaire':
        //récupérer le id_stagiair
        $id_stagiaire = $_REQUEST['id_stagiaire'];
        //récupérer les data de stagiaire
        $leStagiaire = $stagiaire->getStagiaire($id_stagiaire);
        // récupérer toutes les formations
        $formations = $stagiaire->getAllFormations();
        // récupérer toutes les periodes
        $periodes = $stagiaire->getPeriodes();
        // récupérer les periodes ou le stagiaire inscrit
        $periodeStagiaire = $stagiaire->getPeriodesStagiaire($id_stagiaire);
        // affecter les periodes de stagiaire sur le obget lestagiaire
        $leStagiaire->periode=$periodeStagiaire;
       // die(var_dump($periodes));
        include 'view/stagiaire.php';
        break;

    case 'recordStagiaire':
        die(var_dump($_POST));
        $args = array(
            'id_stagiaire' => FILTER_VALIDATE_INT,
            'nom' => FILTER_SANITIZE_STRING,
            'prenom' => FILTER_SANITIZE_STRING,
            'nationnalite' => FILTER_SANITIZE_STRING,
            'id_formation' => FILTER_VALIDATE_INT
        );
        $myinputs = filter_input_array(INPUT_POST, $args, false);
        
        $lesstagiaires = $stagiaire->getStagiaires();
        $stagiaires=[];
         foreach ($lesstagiaires as $stage) {
            $stagiaires [] =$stage->nom;
        }
                    if ($myinputs["id_stagiaire"] > 0) {
                        $id_stagiaire = $myinputs["id_stagiaire"];
                        unset($myinputs["id_stagiaire"]);
                        $stagiaire->modifierStagiaire($myinputs, $id_stagiaire);
                        $stagiaire->deletePresence($id_stagiaire);
                        if(!is_array($_POST['id_periode'])){
                            $stagiaire->affecterPresence($id_stagiaire,$_POST['id_periode']);
                        }else{
                            foreach($_POST['id_periode'] as $id){
                                $stagiaire->affecterPresence($id_stagiaire,$id);
                            }
                        }
                        
                        header('Location: index.php?uc=stagiaire&action=listeStagiaire');
                        ?>                        
                            <!-- <div class="alert alert-success">
                                <?= $success = "la stagiaire a été modifiée"; ?>
                                <p><a href="index.php?uc=stagiaire&action=listeStagiaire">Liste Stagiaires</a></p>
                            </div> -->
                        <?php
                    } else {  
                            if (in_array($myinputs['nom'], $stagiaires)&& in_array($myinputs['prenom'], $stagiaires)): ?>
                            <div class="alert alert-danger">
                                <?= $erreur = "le  stagiaire exisste déjà"; ?>
                                <p><a href="index.php?uc=stagiaire&action=listeStagiaire">Liste Stagiaires</a></p>
                            </div>
                             <?php
                              else : ?>  
                                <?php
                        // pas besoin de id_stagiaire On le supprime du tableau
                        unset($myinputs["id_stagiaire"]);
                        $stagiaire->ajouterStagiaire($myinputs);
                        
                        if(!is_array($_POST['id_periode'])){
                            $stagiaire->affecterPresence($_GET['lastID'],$_POST['id_periode']);
                        }else{
                            foreach($_POST['id_periode'] as $id){
                                $stagiaire->affecterPresence($_GET['lastID'],$id);
                            }
                        }
                        ?>
                            <div class="alert alert-success">
                                <?= $success = "la stagiaire a été engregistrée"; ?>
                                <p><a href="index.php?uc=stagiaire&action=listeStagiaire">Liste Stagiaires</a></p>
                            </div>
                        <?php
                        // ecrire une fichier text contient toutes les stagiaire ajoutées 
                        $file= __DIR__ .DIRECTORY_SEPARATOR . 'stage' . DIRECTORY_SEPARATOR . 'Stagiaires.txt';
                        if(file_exists($file)){
                               $stages = file($file);
                               $lesStages =[];
                               foreach($stages as  $stag){
                               $lesStages []= trim($stag);
                               }
                               if(!in_array($myinputs['nom'], $lesStages)){
                                   file_put_contents($file,$myinputs["nom"] .PHP_EOL,FILE_APPEND);
                               }
                        }else{
                           file_put_contents($file,$myinputs["nom"] .PHP_EOL,FILE_APPEND);
                        }
                        ?>
                        <?php endif; ?> 
                        <?php
                    }
                    ?>
                
        <?php break; ?>
         
<?php }?>


