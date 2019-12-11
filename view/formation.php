<?php
require_once 'controller/formationController.php';
require_once 'model/Formation.php';
$title = $_REQUEST['action'];
if ($title == 'addFormation') {
    $title = 'Ajouter Une Formation';
} else {
    $title = 'Modifier La Formation';
}
?>
<form class="form" action="index.php?uc=formation&action=recordFormation" method="post">
    <fieldset>
        <div class="col-md-6 alert alert-warning"><strong><?= $title; ?>&nbsp;<?php
                if (isset($laformation)): echo strtoupper($laformation->libelle);
                endif;
                ?></strong></div>    
        <div>
            <input type="hidden" name="id_formation" class="form-control" value="<?= isset($laformation) ? $laformation->id_formation : ''; ?>" />
        </div>
        <div class="form-group col-md-6">
            <label for="label">Formation </label>
            <input type="text" name="libelle" class="form-control" value="<?= isset($laformation) ? $laformation->libelle : ''; ?>" />
        </div>
        <div class="form-group col-md-6">
            <label for="lieu">Lieu</label>
            <input type="text" name="lieu" class="form-control" value="<?= isset($laformation) ? $laformation->lieu : 'Lyon'; ?>"  />
        </div>
        <div class="form-group col-md-6">
            <label for="commentaire">Commentaire</label>
            <textarea type="textarea" rows="2" name="commentaire" class="form-control" value="<?= isset($laformation) ? $laformation->commentaire : ''; ?>"  ></textarea>
        </div>
            <div class="form-group col-md-6">
                <label for="dateDebutFormation">Date Debut</label>
                <input type="date" name="dateDebutFormation" class="form-control" value="<?= isset($laformation) ? $laformation->dateDebutFormation : ''; ?>" required />
            </div>
            <div class="form-group col-md-6">
                <label for="dateFinFormation">Date Fin</label>
                <input type="date" name="dateFinFormation" class="form-control" value="<?= isset($laformation) ? $laformation->dateFinFormation : ''; ?>" required />
         </div>
        <div class="form-group col-md-6">
        <button type="submit" class="btn btn-outline-light">Valider</button>
        <button type="reset" class="btn btn-outline-light" onClick="window.location.href = 'index.php?uc=formation&action=listeFormations';">Annuler</button>
        </div>
    </fieldset>
</form>
