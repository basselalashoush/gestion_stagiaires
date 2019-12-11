<?php
require_once 'controller/stagiaireController.php';
require_once 'model/Stagiaire.php';
$stagiaire = new Stagiaire();
define('NATIONNALITE',['Française','Allemande','Russe','Italienne','Anglaise']);
$title = $_REQUEST['action'];
if ($title == 'addStagiaire') {
    $title = 'Ajouter Une Stagiaire';
} else {
    $title = 'Modifier Le Stagiaire';
}
?>
<form class="form" action="index.php?uc=stagiaire&action=recordStagiaire" method="post">
    <fieldset>
        <div class="col-md-6 alert alert-warning"><strong><?= $title; ?>&nbsp;<?php
                if (isset($leStagiaire)): echo strtoupper($leStagiaire->nom).' '.ucfirst($leStagiaire->prenom);
                endif;
                ?></strong>
        </div>    
        <div>
            <input type="hidden" name="id_stagiaire" class="form-control" value="<?= isset($leStagiaire) ? $leStagiaire->id_stagiaire : ''; ?>" />
        </div>
        <div class="form-group col-md-6">
            <label for="nom">Nom Stagiaire </label>
            <input type="text" name="nom" class="form-control" value="<?= isset($leStagiaire) ? $leStagiaire->nom : ''; ?>" />
        </div>
        <div class="form-group col-md-6">
            <label for="lieu">Prenom Stagiaire</label>
            <input type="text" name="prenom" class="form-control" value="<?= isset($leStagiaire) ? $leStagiaire->prenom : ''; ?>"  />
        </div>
        <div class="form-group col-md-6">
            <label for="nationnalite">Nationnalité</label>
            <select name="nationnalite" class="form-control">
            <?php if (!isset($leStagiaire)) : ?>
                        <option> Sélectionner la Nationnalité </option>
                    <?php endif; ?>
                    <?php foreach (NATIONNALITE as $nationnalite) : ?>
                        <option value="<?= $nationnalite?> "
                        <?php if (isset($leStagiaire)&& $leStagiaire->nationnalite === $nationnalite) : ?>
                                    selected = "selected"
                                <?php endif; ?>>
                                    <?= $nationnalite; ?>                        
                        </option>
                    <?php endforeach; ?>
        </div>
        <div class="form-group col-md-6">
                
               <select name="" id=""></select>
        </div>
        <div class="form-group col-md-6">
                <label for="id_formation">Formation</label>
                <select  name="id_formation" id='id_formation' class="form-control" >  
                    <?php if (!isset($leStagiaire)) : ?>
                        <option> Sélectionner la Formation </option>
                    <?php endif; ?>
                    <?php foreach ($formations as $formation) : ?>
                        <option value="<?= $formation->id_formation?>"
                        <?php if (isset($leStagiaire) && $leStagiaire->id_formation === $formation->id_formation) : ?>
                                    selected = "selected"
                                <?php endif; ?>>
                                    <?= $formation->libelle; ?>                        
                        </option>
                    <?php endforeach; ?>
                </select>
        </div>
        <div class="form-group col-md-6">
        <label for="periode">formateur Periodes</label><br>             
                    <?php foreach ($periodes as $periode) : ?>
                        <input type="checkbox" name="id_periode[]"  data-periode ="<?=$periode->id_periode;?>" data-formation = "<?=$periode->id_formation ;?>" class="form-check-label" value="<?= $periode->id_periode?> " 
                        <?php if(isset($leStagiaire)) : ?>
                        <?php foreach($leStagiaire->periode as $v) : ?>  
                        
                        <?php if (isset($leStagiaire)&& strcmp ($v->stagiairePeriode , $periode->formateurPeriode)==0) : ?>
                                    checked = "checked"
                        <?php  endif; endforeach; endif;?>>
                                   <span> <?= $periode->formateurPeriode; ?> </span> </br>                      
                        <?php endforeach;?>
                        

         </div>
        <div class="form-group col-md-6">
        <button type="submit" class="btn btn-outline-light">Valider</button>
        <button type="reset" class="btn btn-outline-light" onClick="window.location.href = 'index.php?uc=Stagiaire&action=listeFormations';">Annuler</button>
        </div>
    </fieldset>
</form>