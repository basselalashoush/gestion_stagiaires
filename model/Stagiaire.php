<?php
require_once 'connections/Connection.php';
require_once 'model/Formation.php';

class Stagiaire {
    public function getStagiaires(): array {
        try{
        $req = "SELECT stagiaire.id_stagiaire,stagiaire.nom,stagiaire.prenom,stagiaire.nationnalite,stagiaire.id_formation,formation.libelle ,GROUP_CONCAT(formateur.nom,' ',formateur.salle,' ',periode.date_debut,' _ ',periode.date_fin)AS period
        FROM stagiaire
        RIGHT join presence ON(stagiaire.id_stagiaire = presence.id_stagiaire)
        RIGHT JOIN periode on (presence.id_periode = periode.id_periode)
        RIGHT JOIN cours ON(periode.id_periode = cours.id_periode)
        RIGHT JOIN formateur on(cours.id_formateur = formateur.id_formateur)
        RIGHT JOIN formation ON(cours.id_formation = formation.id_formation)
        GROUP BY stagiaire.id_stagiaire";
        $pdo= Connection::getPDO();
        $res = $pdo->query($req);
        $stagiaires=$res->fetchAll(PDO::FETCH_OBJ);
        return $stagiaires;
        } catch (PDOException $ex) {
                echo $ex;
        }
    }

    public function getPeriodes(){
        try{
            $req = "SELECT periode.id_periode,cours.id_formation,GROUP_CONCAT(formateur.nom,' ',formateur.salle,' ',periode.date_debut,' _ ',periode.date_fin)AS formateurPeriode
            FROM `formateur`
            INNER JOIN cours ON(formateur.id_formateur = cours.id_formateur)
            INNER JOIN periode ON(cours.id_periode = periode.id_periode)
            GROUP BY formateur.id_formateur";
            $pdo= Connection::getPDO();
            $res = $pdo->query($req);
            $periodes=$res->fetchAll(PDO::FETCH_OBJ);
            return $periodes;
            } catch (PDOException $ex) {
                    echo $ex;
            }
    }

    public function getPeriodesStagiaire($id_stagiaire){
        try{
            $req = "SELECT stagiaire.id_stagiaire,periode.id_periode,GROUP_CONCAT(formateur.nom,' ',formateur.salle,' ',periode.date_debut,' _ ',periode.date_fin)AS stagiairePeriode
            FROM `stagiaire`
            INNER JOIN presence ON (stagiaire.id_stagiaire = presence.id_stagiaire)
            INNER JOIN periode ON (presence.id_periode = periode.id_periode)
            INNER JOIN cours ON (periode.id_periode = cours.id_periode)
            INNER JOIN formateur ON (cours.id_formateur = formateur.id_formateur)
            INNER JOIN formation ON (cours.id_formation = formation.id_formation)
            WHERE stagiaire.id_stagiaire = $id_stagiaire
            GROUP BY formateur.id_formateur";
            
            $pdo= Connection::getPDO();
            $res = $pdo->query($req);
            $periodes=$res->fetchAll(PDO::FETCH_OBJ);
            return $periodes;
            } catch (PDOException $ex) {
                    echo $ex;
            }
    }
    public function getStagiaire($id_stagiaire) {
        try{
        $req = "select * from stagiaire where id_stagiaire='$id_stagiaire'";
        $pdo= Connection::getPDO();
        $res = $pdo->query($req);
        $stagiaire=$res->fetch(PDO::FETCH_OBJ);
        return $stagiaire;
        } catch (PDOException $ex) {
                echo $ex;
        }
    }
    public function getAllFormations(){
        $formation = new Formation();
        return $formation->getFormations();
    }

    public function affecterPresence($id_stagiaire,$id_periode){
        try{
            $pdo = Connection::getPDO();
            $res = $pdo->prepare("call InsertPeriode($id_stagiaire,$id_periode)");
            $res->execute();
            } catch (PDOException $ex) {
                $ex;
            }
    }

    public function deletePresence($id_stagiaire){
        try{
            $req = "DELETE FROM presence WHERE id_stagiaire='$id_stagiaire'";
            $pdo= Connection::getPDO();
            $res = $pdo->prepare($req);
            $res->execute();
            } catch (PDOException $ex) {
                    echo $ex;
            }
    }



    public function modifierStagiaire($myinputs,$id_stagiaire) {
         // 1 : On récupère les clés de $myinputs 
        // qui correspondent aux colonnes de la table stagiaire
        $keys = array_keys($myinputs); 
        // 2 : On construit une chaîne (id_stagiaire, nom) automatiquement
        $fields = '`'.implode('`=?, `',$keys).'`';
        $fields .= '=?';
        $values = array_values($myinputs);       
        try {
            // 4 On prépare la requête, on se connecte à PDO
            $req = "UPDATE  `stagiaire` SET $fields WHERE id_stagiaire = $id_stagiaire";
            $pdo = Connection::getPDO();
            $res = $pdo->prepare($req);
            // 5 On éxécute la requête en envoyant directement 
            // les valeurs de $myinputs
            $res->execute($values);
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

    public function ajouterStagiaire($myinputs) {

        // 1 : On récupère les clés de $myinputs 
        // qui correspondent aux colonnes de la table stagiaire
        $keys = array_keys($myinputs); 
        // 2 : On construit une chaîne (id_stagiaire, nom) automatiquement
        $fields = '`'.implode('`, `',$keys).'`';
        // 3 on sécurise la requête, il faut mettre  des ?, 
        // autant de ? qu'il y a de colonne dans le tableau des colonnes, $keys
        $placeholder = substr(str_repeat('?,',count($keys)),0,-1);        
        $values = array_values($myinputs);  

        try {
            // 4 On prépare la requête, on se connecte à PDO
            $req = "INSERT INTO `stagiaire`($fields) VALUES($placeholder)";
            $pdo = Connection::getPDO();
            $res = $pdo->prepare($req);
            // 5 On éxécute la requête en envoyant directement 
            // les valeurs de $myinputs
            $res->execute($values);
            $lastID = $pdo->lastInsertId();
            $_GET['lastID']= $lastID;
        } catch (PDOException $ex) {
            $ex;
        }
    }

    public function deleteStagiaire($id_stagiaire) {
        try{
        $req = "DELETE FROM stagiaire WHERE id_stagiaire='$id_stagiaire'";
        $pdo= Connection::getPDO();
        $res = $pdo->prepare($req);
        $res->execute();
        } catch (PDOException $ex) {
                echo $ex;
        }
    }
}
