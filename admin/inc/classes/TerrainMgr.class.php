<?php

/**
 * TECORESY Admin panel 1.0
 *
 * File : TerrainMgr.class.php
 * Description :
 *   OBSOLETE
 *   This file contains the class for the terrain manager.
 *   With this class, we can manage the single terrains as well as the reservations for each terrain.
 */

class TerrainMgr {
    private $dbh;

    public function __construct() {
        $dsn = dbtype . ":dbname=" . database . ";host=" . hostname;


        try {
            $this->dbh = new PDO($dsn, username, password);
        }
        catch(PDOException $e) {
            echo "PDO has encountered an error: " + $e->getMessage();
            die();
        }
    }

    public function getTerrainsFromDB($withPlayers, $enableOptions) {
        $returnArr = array();

        $qry = "SELECT * FROM tblTerrain";

        try {
            $stmt = $this->dbh->prepare($qry);

            if ($stmt->execute()) {
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($withPlayers === true) {
                    foreach ($res as $row) {
                        $row["lstPlayers"] = "<ul><li>Player 1</li><li>Player 2</li><li>Player 3</li><li>Player 4</li></ul>";

                        array_push($returnArr, $row);
                    }
                }
                else {
                    return json_encode($res);
                }

                if ($enableOptions === true) {
                    //$arrWithOptions = array();

                    $tmpArr = $returnArr;
                    $returnArr = array();

                    foreach ($tmpArr as $row) {
                        $row["checkbox"] = "<input class=\"ckbRow\" type=\"checkbox\" id=\"C" . $row["idTerrain"] . "\">";
                        $row["funcedit"] = "<span id=\"E" . $row["idTerrain"] . "\" class=\"glyphicon glyphicon-pencil edit\"></span>";
                        $row["funcdel"] = "<span id=\"D" . $row["idTerrain"] . "\" class=\"glyphicon glyphicon-trash delete\"></span>";

                        if ($row["dtState"] == 1) {
                            $row["funcstate"] = "<span title=\"Cliquez ici pour deactiver le terrain.\" style=\"color: #0a0;\" id=\"A" . $row["idTerrain"] . "\" class=\"glyphicon glyphicon-ok-circle state\"></span>";
                        }
                        else {
                            $row["funcstate"] = "<span title=\"Cliquez ici pour activer le terrain.\" style=\"color: #a00;\" id=\"D" . $row["idTerrain"] . "\" class=\"glyphicon glyphicon-ban-circle state\"></span>";
                        }

                        if ($row["dtState"] == 1) {
                            $row["dtState"] = "Oui";
                        }
                        else {
                            $row["dtState"] = "Non";
                        }

                        $row["idTerrain"] = "<img width=\"100px\" src=\"images/tennis-court.png\"><p>Terrain N° " . $row["idTerrain"] . "</p>";

                        array_push($returnArr, $row);
                    }

                    return json_encode($returnArr);
                }
                else {
                    return json_encode($res);
                }
            }
            else {
                return false;
            }
        }
        catch(PDOException $e) {
            echo "PDO has encountered an error: " + $e->getMessage();
            die();
        }
    }

    public function addTerrainToDB($terrainJson) {
        $terrain = json_decode($terrainJson, true);

        $qry = "INSERT INTO tblTerrain (idTerrain, dtState) VALUES (:terrainno, :state)";

        try {
            $stmt = $this->dbh->prepare($qry);

            /*foreach ($terrain as $key => $property) {
                $stmt->bindValue(":" . $key, $property);
            }** NOT WORKING WITH DB 1.3 */

            $stmt->bindValue(":terrainno", (int)$terrain["terrainno"]);
            $stmt->bindValue(":state", $terrain["state"]);

            if ($stmt->execute()) {
                return true;
            }
            else {
                return false;
            }
        }
        catch(PDOException $e) {
            echo "PDO has encountered an error: " + $e->getMessage();
            die();
        }
    }

    public function changeTerrainState($id, $state) {
        $qry = "UPDATE tblTerrain SET dtState = :state WHERE idTerrain = :id";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":id", $id);
            $stmt->bindValue(":state", $state);

            if ($stmt->execute()) {
                return true;
            }
            else {
                return false;
            }
        }
        catch(PDOException $e) {
            return "PDO FAIL";
            echo "PDO has encountered an error: " + $e->getMessage();
            die();
        }
    }

    public function deleteTerrainFromDB($id) {
        $qry = "DELETE FROM tblTerrain WHERE idTerrain = :id";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":id", $id);

            if ($stmt->execute()) {
                return true;
            }
            else {
                return false;
            }
        }
        catch(PDOException $e) {
            echo "PDO has encountered an error: " + $e->getMessage();
            die();
        }
    }

    public function getPlayersForReservedTerrains($timespan) {
        $qry = "SELECT dtFirstname, dtLastname, idDateHeure, fiTerrain FROM tblUser, tblReservation WHERE idUser = fiPlayer1 OR idUser = fiPlayer2";
    }
}