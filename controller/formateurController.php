
<?php
require_once 'model/Formateur.php';
$formateur = new Formateur();
$action = $_REQUEST['action'];
switch ($action) {
    case 'listeFormateurs': 
            $formateurs = $formateur->getFormateurs();
            include 'view/listeFormateurs.php';
            break;
        
    case 'addFormateur': 
        include 'view/formateur.php';
            break;
        
    case 'deleteFormateur': 
             $id_formateur =$_REQUEST['id_formateur'];
             $formateur->deleteFormateur($id_formateur);
             ?>
                <div class="alert alert-success">
                    <?= $success = "le formateur a été supprimé"; ?>
                    <p><a href="index.php?uc=formateur&action=listeFormateurs">Liste Formateurs</a></p>
                 </div>
            <?php
            break;
        
    case 'updateFormateur': 
            $id_formateur =$_REQUEST['id_formateur'];
            $leFormateur = $formateur->getFormateur($id_formateur);
            include 'view/formateur.php';
            break;
        
        case 'recordFormateur':
           $args = array(
            'id_formateur' => FILTER_VALIDATE_INT,
            'nom'=>FILTER_SANITIZE_STRING,
            'salle' => FILTER_SANITIZE_STRING);
            $myinputs = filter_input_array(INPUT_POST, $args, false);
            $formateurs = $formateur->getFormateurs();
            $nomFormateurs = [];
            foreach($formateurs as $form){
                $nomFormateurs [] = $form->nom;
            }
            ?>

           <?php if(in_array($myinputs['nom'],$nomFormateurs)&& empty($myinputs['id_formateur'])): ?>
           <div class="alert alert-danger">
               <?= $error = "le nom de formateur  exisste déjà"; ?>
                    <p><a href="index.php?uc=formateur&action=listeFormateurs">Liste Formateurs</a></p>
           </div>
           <?php exit; ?>
           <?php else : ?>
           <?php 
           
            if ($myinputs['id_formateur']> 0) {
                $id_formateur=$myinputs['id_formateur'];
                unset($myinputs['id_formateur']);
        $formateur->modifierFormateur($myinputs,$id_formateur);
        ?>
        <div class="alert alert-success">
               <?= $error = "le formateur à été modifié"; ?>
                    <p><a href="index.php?uc=formateur&action=listeFormateurs">Liste Formateurs</a></p>
           </div>
           <?php
    } else {
        unset($myinputs['id_formateur']);
         $formateur->ajouterFormateur($myinputs);
         ?>
         <div class="alert alert-success">
               <?= $error = "le formateur à été enregistré"; ?>
                    <p><a href="index.php?uc=formateur&action=listeFormateurs">Liste Formateurs</a></p>
           </div>
           <?php
    }
            endif;
            break;
}

