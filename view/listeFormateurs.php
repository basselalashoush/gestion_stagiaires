<?php
require_once 'controller/formateurController.php';
require_once 'model/Formateur.php';
?>
<div class="alert alert-warning">
<p>Liste Formateurs</p>
</div>
<table id="myTable" class=" table table-striped snipe-table" 
       data-locale="fr-FR"
       data-toolbar="#toolbar"
       data-page-size="5"
       data-search="true"
       data-show-columns="true"
       data-show-toggle="true"   
       data-show-pagination-switch="true"
       data-pagination="true"
       data-page-list="[5,10, 25, ALL]">
    <thead>
        <tr>
            <th data-sortable="true" data-field="id_formateur" data-visible="false">Formateur</th>
            <th data-sortable="true" data-field="nom">Nom</th>
            <th data-sortable="true" data-field="salle">Salle</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($formateurs as $formateur) {
            $idFormateur = $formateur->id_formateur;
            $nomFormateur = $formateur->nom;
            $prenomFormateur = $formateur->salle;
            ?>
            <tr> 
                <td><?php echo $idFormateur; ?></td>
                <td><?php echo $nomFormateur; ?></td>
                <td><?php echo $prenomFormateur; ?></td>
                <td><a href=""><i class="fas fa-eye" title="Afficher"></i></a>
                    &emsp; <a href="index.php?uc=formateur&action=updateFormateur&id_formateur=<?= $idFormateur;?>"><i class="fas fa-edit" title="Modifier"></i></a>
                    &emsp;<a href="index.php?uc=formateur&action=deleteFormateur&id_formateur=<?= $idFormateur;?>"><i class="fas fa-trash-alt" title="Supprimer"></i></a></td>
            </tr> 
        <?php } ?>
    </tbody>
</table>

