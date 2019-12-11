<?php

require_once 'connections/Connection.php';


class Formateur {

    public function getFormateurs() {
        try {
            $req = "SELECT formateur.id_formateur, formateur.nom,formateur.salle
                    FROM formateur";
            $pdo = Connection::getPDO();
            $res = $pdo->query($req);
            $formateurs = $res->fetchAll(PDO::FETCH_OBJ);
            return $formateurs;
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

    public function getFormateur($idFormateur) {
        try {
            $req = "SELECT formateur.id_formateur, formateur.nom,formateur.salle
                    FROM `formateur`
                    WHERE `id_formateur` ='$idFormateur'";
            $pdo = Connection::getPDO();
            $res = $pdo->query($req);
            $formateur = $res->fetch(PDO::FETCH_OBJ);
            return $formateur;
        } catch (PDOException $ex) {
            echo $ex;
        }
    }




    public function ajouterFormateur($myinputs) {
        // 1 : On récupère les clés de $myinputs 
        // qui correspondent aux colonnes de la table formateur
        $keys= array_keys($myinputs);
         // 2 : On construit une chaîne (id_formateur,nom,etc...) automatiquement
        $fields = '`'.implode('`, `',$keys).'`';
        // 3 on sécurise la requête, il faut mettre  des ?, 
        // autant de ? qu'il y a de colonne dans le tableau des colonnes, $keys
        $placeholder = substr(str_repeat('?,',count($keys)),0,-1); 
        $values= array_values($myinputs);
        try {
            // 4 On prépare la requête, on se connecte à PDO
            $req = "INSERT INTO `formateur`($fields) VALUES ($placeholder)";
            $pdo = Connection::getPDO();
            $res = $pdo->prepare($req);
            // 5 On éxécute la requête en envoyant directement 
            // les valeurs de $myinputs
            $res->execute($values);
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

    public function modifierFormateur($myinputs, $id_formateur) {
        // 1 : On récupère les clés de $myinputs 
        // qui correspondent aux colonnes de la table formateur
        $kyes = array_keys($myinputs);
        // 2 : On construit une chaîne (id_groupe,nom,etc...) automatiquement
        $fileds = '`' . implode('`=?, `', $kyes) . '`';
        $fileds .= '=?';
        $values = array_values($myinputs);
        try {
            // 3 : On prépare la requête, on se connecte à PDO
            $req = "UPDATE `formateur` SET $fileds
                    WHERE id_formateur=$id_formateur";
            $pdo = Connection::getPDO();
            $res = $pdo->prepare($req);
            // 4 : On éxécute la requête en envoyant directement 
            // les valeurs de $myinputs
            $res->execute($values);
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

    public function deleteFormateur($id_formateur) {
        try {
            $req = "DELETE FROM  `formateur`
                    WHERE id_formateur='$id_formateur'";
            $pdo = Connection::getPDO();
            $res = $pdo->prepare($req);
            $res->execute();
        } catch (PDOException $ex) {
            echo $ex;
        }
    }

}
