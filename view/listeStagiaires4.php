<?php
require_once 'controller/StagiaireController.php';
require_once 'model/Stagiaire.php';
?>
<div class="alert alert-warning">
    <p>Liste Stagiaires</p>
</div>
<table id="myTable" class=" table table-striped snipe-table" 
       data-locale="fr-FR"
       data-toolbar="#toolbar"
       data-search="true"
       data-show-columns="true"
       data-show-toggle="true"   
       data-show-pagination-switch="true"
       data-pagination="true"
       data-page-size="5"
       data-page-list="[5,10, 25, ALL]">
    <thead>
        <tr>
            <th data-sortable="true" data-field="id_stagiaire" data-visible="false">Stagiaire</th>
            <th data-sortable="true" data-field="nom">Nom</th>
            <th data-sortable="true" data-field="prenom">Prenom</th>
            <th data-sortable="true" data-field="nationnalite">Nationnalite</th>
            <th data-sortable="true" data-field="libelle">Formation</th>
            <th data-sortable="true" data-field="period">Formateur N°salle date-Debut Date-Fin</th>
            <th>Action</th>
           

        </tr>
    </thead>
    <tbody >
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
    <tr>
              <td>  <input type="text" name="id_stagiaire" value="<?= $idStagiaire; ?>"></td>
              <td> <input type="text" name="nom" value="<?= $nomStagiaire; ?>"></td>
              <td> <input type="text" name="prenom" value="<?= $prenomStagiaire; ?>"></td>
              <td> <input type="text" name="nationnalite" value="<?= $nationaliteStagiaire; ?>"></td>
              <td> <select class="formation" name="id_formation" id='id_formation'  data-stagiaire="<?= $idStagiaire;?>">  
                    <?php foreach ($formations as $formation) : ?>
                        <option value="<?= $formation->id_formation?>"
                        <?php if ($id_formation === $formation->id_formation) : ?>
                                    selected = "selected"
                                <?php endif; ?>>
                                    <?= $formation->libelle; ?>                        
                        </option>
                    <?php endforeach; ?>
                </select></td>
                <td>
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
               </td>
               <td><button type="submit"><i data-id-stagiaire="<?= $idStagiaire;?>" class="fas fa-edit ajax" title="Modifier La Formation"></i></button>
                    &emsp; <a href="index.php?uc=stagiaire&action=updateStagiaire&id_stagiaire=<?= $idStagiaire;?>"><i class="fas fa-user-edit" title="Modifier Le Stagiaire"></i></a>
                    &emsp;<a href="index.php?uc=stagiaire&action=deleteStagiaire&id_stagiaire=<?= $idStagiaire;?>"><i class="fas fa-trash-alt" title="Supprimer"></i></a></td></tr>   
        </form>
        <?php endforeach; ?>
        </tbody>
            </table>

