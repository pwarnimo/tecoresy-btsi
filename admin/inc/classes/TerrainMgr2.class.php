<?php

class TerrainMgr2 {
    private $dbh;

    public function __construct() {
        date_default_timezone_set('Europe/Luxembourg');

        $dsn = dbtype . ":dbname=" . database . ";host=" . hostname;


        try {
            $this->dbh = new PDO($dsn, username, password);
        }
        catch(PDOException $e) {
            echo "PDO has encountered an error: " + $e->getMessage();
            die();
        }
    }

    public function getPossibleReservationsForTerrain() {
        $today = date("Y-m-d", time());

        //$today = "2014-03-21";

        $qry = "SELECT fiDate, idHour, dtWeekDay, fiTerrain FROM tblPossibleReservation, tblHour, tblWeekDay, tblHourWeekDay WHERE fiHourWeekDay = idHourWeekDay AND fiHour = idHour AND fiWeekDay = idWeekDay AND fiDate BETWEEN :date AND DATE_ADD(:date, INTERVAL 7 DAY ) ORDER BY fiDate, idHour";

        try {
            $stmt = $this->dbh->prepare($qry);

            //$stmt->bindValue(":tid", $tid);
            $stmt->bindValue(":date", $today);

            if ($stmt->execute()) {
                return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
            }
            else {
                return false;
            }
        }
        catch(PDOException $e) {
            echo "PDO has encountered an error: " + $e->getMessage();
            die();
        }

        //return "SELECTING FROM " . $today;
    }

    public function getDateSpan() {
        $qry = "SELECT idDate FROM tblDate WHERE idDate BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 7 DAY) ORDER BY idDate";
        //$qry = "SELECT idDate FROM tblDate WHERE idDate BETWEEN \"2014-03-19\" AND DATE_ADD(\"2014-03-19\", INTERVAL 7 DAY) ORDER BY idDate";

        try {
            $stmt = $this->dbh->prepare($qry);

            if ($stmt->execute()) {
                return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
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

    public function getReservationsForTerrain($id) {
        $qry = "SELECT fiDate, fiTerrain, fiHour, fiPlayer1, fiPlayer2 FROM tblReservation, tblHourWeekDay WHERE fiTerrain = :id AND fiHourWeek = idHourWeekDay";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":id", $id);

            if ($stmt->execute()) {
                return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
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

    public function getReservationCounts() {
        $qry = "SELECT fiTerrain, COUNT(*) AS qcfCount FROM tblReservation GROUP BY fiTerrain";

        try {
            $stmt = $this->dbh->prepare($qry);

            if ($stmt->execute()) {
                return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
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
}