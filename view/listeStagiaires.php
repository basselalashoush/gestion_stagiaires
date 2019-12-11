<?php
require_once 'controller/StagiaireController.php';
require_once 'model/Stagiaire.php';
?>
<div class="alert alert-warning">
    <p>Liste Stagiaires</p>
</div>
            <div class="row-stagiaire">
            <div class="col-small small-div">
                        Nom
            </div>
            <div class="col-small small-div">
                        Prenom
            </div>
            <div class="col-small small-div">
            Nationnalite
            </div>
            <div class="col-small small-div">
            Formation
            </div>
            <div class="col-grand">
            Formateur N°salle date-Debut Date-Fin
            </div>
            <div class="col-small small-div">
            Action
            </div>

</div>

    
        <?php
        foreach ($stagiaires as $stagiaire) :
            $idStagiaire = $stagiaire->id_stagiaire;
            $id_formation = $stagiaire->id_formation;
            $nomStagiaire = $stagiaire->nom;
            $prenomStagiaire = $stagiaire->prenom;
            $nationaliteStagiaire = $stagiaire->nationnalite;
            $label = $stagiaire->libelle;
            $period = $stagiaire->period;
            ?>
            <form id="formTest" method="POST" action="index.php?uc=stagiaire&action=recordStagiaire">

      <div class="row-stagiaire"> 
        <div class="col-hidden">
          <input type="hidden" name="id_stagiaire" value="<?= $idStagiaire; ?>">
        </div>
        <div class="col-small small-div">
         <input type="text" name="nom" class="form-control" value="<?= $nomStagiaire; ?>">
        </div>
        <div class="col-small small-div">
         <input type="text" name="prenom" class="form-control" value="<?= $prenomStagiaire; ?>">
        </div>
        <div class="col-small small-div">
         <input type="text" name="nationnalite" class="form-control" value="<?= $nationaliteStagiaire; ?>">
        </div>
        <div class="col-small small-div">
         <select class="formation form-control" name="id_formation" id='id_formation'  data-stagiaire="<?= $idStagiaire;?>">  
                    <?php foreach ($formations as $formation) : ?>
                        <option value="<?= $formation->id_formation?>"
                        <?php if ($id_formation === $formation->id_formation) : ?>
                                    selected = "selected"
                                <?php endif; ?>>
                                    <?= $formation->libelle; ?>                        
                        </option>
                    <?php endforeach; ?>
                </select>
        </div>
        <div class="col-grand">
                <?php
                $p = explode(',',$period );?>
               
               <?php foreach ($allPeriodeFormateur as $data):?>
               <?php
                $attribute = '';
                foreach ($p as $v){
                     
                    if(strcmp ($v , $data->formateurPeriode )==0){
                        $attribute = 'checked';
                    }
                }
                $disabled ='';
                if($data->id_formation !== $id_formation){
                    $disabled = 'disabled';
                    $class = 'hide';
                }
               ?>
                <input type="checkbox"  id="scales" <?=$disabled;?> name="id_periode[]" <?=$attribute;?> data-id ="<?= $idStagiaire;?>"
                   data-periode="<?=$data->id_periode; ?>" data-formation = "<?=$data->id_formation;?>" value="<?=$data->id_periode;?>" ><span><?=$data->formateurPeriode;?></span></br>
               <?php endforeach;?>
        </div>
        <div class="col-small ">
               <button class="ajax" type="submit"><i data-id-stagiaire="<?= $idStagiaire;?>" class="fas fa-edit" title="Modifier La Formation"></i></button></br>
                    <a href="index.php?uc=stagiaire&action=updateStagiaire&id_stagiaire=<?= $idStagiaire;?>"><i class="fas fa-user-edit" title="Modifier Le Stagiaire"></i></a></br>
                    <a href="index.php?uc=stagiaire&action=deleteStagiaire&id_stagiaire=<?= $idStagiaire;?>"><i class="fas fa-trash-alt" title="Supprimer"></i></a></br>
        </div>
    
             
            </div> 
        
</form>
<hr>
<?php endforeach; ?>
