<?php

require_once 'controller/formateurController.php';
require_once 'model/Formateur.php';
$title = $_REQUEST['action'];
if ($title == 'updateFormateur') {
    $title = 'Modifier Le Formateur';
} else {
    $title = 'Ajouter Un Formateur';
}
?>

<form class="form"  action="index.php?uc=formateur&action=recordFormateur" method="post" onsubmit="return chambreVide()">
    <fieldset>
        <div class=" col-md-6 alert alert-warning"><strong><?= $title; ?>&nbsp;<?php if (isset($leFormateur)): echo strtoupper($leFormateur->nom);
endif;
?></strong></div>   
        <div class="form-group col-md-6">
            <input type="hidden" name="id_formateur" class="form-control" value="<?= isset($leFormateur) ? $leFormateur->id_formateur : ''; ?>" />
        </div>
        <div class="form-group col-md-6">
            <label for="nom">Nom Formateur</label>
            <input type="text" name="nom" class="form-control" value="<?= isset($leFormateur) ? $leFormateur->nom : ''; ?>" />
        </div>
        <div class="form-group col-md-6">
            <label for="salle">Salle </label>
            <input type="text" name="salle" class="form-control" value="<?= isset($leFormateur) ? $leFormateur->salle : ''; ?>" />
        </div>
        <button type="submit" class="btn btn-outline-light">Valider</button>
        <button type="reset" class="btn btn-outline-light" onClick="window.location.href = 'index.php?uc=groupe&action=listeGroupes';">Annuler</button>
    </fieldset>
</form>