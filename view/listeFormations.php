<?php
require_once 'controller/formationController.php';
require_once 'model/Formation.php';
?>
<div class="alert alert-warning">
    <p>Liste Formations</p>
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
            <th data-sortable="true" data-field="id_formation" data-visible="false">id</th>
            <th data-sortable="true" data-field="libelle">type</th>
            <th data-sortable="true" data-field="lieu">Lieu</th>
            <th data-sortable="true" data-field="commentaire">Commentaire</th>
            <th data-sortable="true" data-field="dateDebutFormation">Date Debut</th>
            <th data-sortable="true" data-field="dateFinFormation">Date Fin</th>
            
            <th>Action</th> 
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($formations as $formation) {
                $idFormation = $formation->id_formation;
                $label = $formation->libelle;
                $lieu = $formation->lieu;
                $commentaire = $formation->commentaire;
                $dateDebutFormation = $formation->dateDebutFormation;
                $dateFinFormation = $formation->dateFinFormation;
                ?>
            <tr> 
                <td><?= $idFormation; ?></td>
                <td><?= $label; ?></td>
                <td><?= $lieu; ?></td>
                <td><?= $commentaire; ?></td>
                <td><?= $dateDebutFormation; ?></td>
                <td><?= $dateFinFormation; ?></td>
                <td><a href=""><i class="fas fa-eye" title="Afficher Les Stagiaires"></i></a>
                    &emsp;<a href="index.php?uc=formation&action=updateFormation&id_formation=<?= $idFormation;?>"><i class="fas fa-edit" title="Modifier"></i></a>
                    &emsp;<a href="index.php?uc=formation&action=deleteFormation&id_formation=<?= $idFormation;?>"><i class="fas fa-trash-alt" title="Supprimer"></i></a></td>
            </tr> 
        <?php } ?>
    </tbody>
</table>


