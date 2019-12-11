<?php

require_once 'connections/Connection.php';

class Formation {

    public function
    getFormations() {
        try {
            $req = "SELECT *
                    FROM formation";
            $pdo = Connection::getPDO();
            $res = $pdo->query($req);
            $formations = $res->fetchAll(PDO::FETCH_OBJ);
            return $formations;
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

    public function getFormation($idFormation) {
        try {
            $req = "SELECT  *
                FROM formation
                WHERE id_formation='$idFormation'";
            $pdo = Connection::getPDO();
            $res = $pdo->query($req);
            $formation = $res->fetch(PDO::FETCH_OBJ);
            return $formation;
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

    public function modifierFormation($myinputs, $idFormation) {
        // 1 : On récupère les clés de $myinputs 
        // qui correspondent aux colonnes de la table formation
        $keys = array_keys($myinputs);
        // 2 : On construit une chaîne (idFormation, nomFormation,etc...)
        // automatiquement
        $fields = '`' . implode('`=?, `', $keys) . '`';
        $fields .= '=?';
        $values = array_values($myinputs);
        try {
            // 4 On prépare la requête, on se connecte à PDO
            $req = "UPDATE  `formation` SET $fields WHERE id_formation=$idFormation";
            $pdo = Connection::getPDO();
            $res = $pdo->prepare($req);
            // 5 On éxécute la requête en envoyant directement 
            // les valeurs de $myinputs
            $res->execute($values);
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

    public function ajouterFormation($myinputs) {
        // 1 : On récupère les clés de $myinputs 
        // qui correspondent aux colonnes de la table formation
        $keys = array_keys($myinputs);
        // 2 : On construit une chaîne (idFormation, nomFormation,etc...)
        // automatiquement
        $fields = '`' . implode('`, `', $keys) . '`';

        // 3 on sécurise la requête, il faut mettre  des ?, 
        // autant de ? qu'il y a de colonne dans le tableau des colonnes, $keys
        $placeholder = substr(str_repeat('?,', count($keys)), 0, -1);
        $values = array_values($myinputs);
                    
        try {
            // 4 On prépare la requête, on se connecte à PDO
            $req = "INSERT INTO `formation`($fields) VALUES($placeholder)";
            $pdo = Connection::getPDO();
            $res = $pdo->prepare($req);
            // 5 On éxécute la requête en envoyant directement 
            // les valeurs de $myinputs
            $res->execute($values);
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

    public function deleteFormation($idFormation) {
        try {
            $req = "DELETE FROM formation 
                    WHERE id_formation='$idFormation'";
            $pdo = Connection::getPDO();
            $res = $pdo->prepare($req);
            $res->execute();
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

}
