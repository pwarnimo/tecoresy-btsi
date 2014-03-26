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
        $qry = "SELECT idDate FROM tblDate WHERE idDate BETWEEN CURRENT_DATE() AND DATE_ADD(CURRENT_DATE(), INTERVAL 7 DAY) ORDER BY idDate";
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

    public function getBlockedReservationsForTerrain($id) {
        $qry = "SELECT fiDate, fiTerrain, fiHour FROM tblPossibleReservation, tblHourWeekDay WHERE fiTerrain = :id AND fiHourWeekDay = idHourWeekDay AND dtIsBlocked = \"Yes\" AND fiDate BETWEEN CURRENT_DATE() AND DATE_ADD(CURRENT_DATE(), INTERVAL 7 DAY)";

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

    public function blockReservation($terrain, $date, $hour, $weekday, $state) {
        $qry = "UPDATE tblPossibleReservation SET dtIsBlocked = :state WHERE fiDate = :date AND fiTerrain = :terrain AND fiHourWeekDay = (SELECT idHourWeekDay FROM tblHourWeekDay WHERE fiHour = :hour AND fiWeekDay = :weekday)";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":terrain", $terrain);
            $stmt->bindValue(":date", $date);
            $stmt->bindValue(":hour", $hour);
            $stmt->bindValue(":weekday", $weekday);
            $stmt->bindValue(":state", $state);

            if ($stmt->execute()) {
                //return json_encode(true);

                return json_encode("H>" . $hour. " D>" . $weekday . " S>" . $state);
            }
            else {
                return json_encode(false);
            }
        }
        catch(PDOException $e) {
            echo "PDO has encountered an error: " + $e->getMessage();
            die();
        }
    }

    public function addReservation($date, $hour, $day, $player1, $player2, $terrain) {
        $qry = "SELECT idHourWeekDay FROM tblHourWeekDay WHERE fiHour = :hour AND fiWeekDay = :day";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":hour", $hour);
            $stmt->bindValue(":day", $day);

            if ($stmt->execute()) {
                $wid = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $qry = "INSERT INTO tblReservation (fiDate, fiTerrain, fiHourWeek, fiPlayer1, fiPlayer2) VALUES (:date, :terrain, :hourweekday, :player1, :player2)";

                $stmt = $this->dbh->prepare($qry);

                $stmt->bindValue(":date", $date);
                $stmt->bindValue(":terrain", $terrain);
                $stmt->bindValue(":hourweekday", $wid[0]["idHourWeekDay"]);
                $stmt->bindValue(":player1", $player1);
                $stmt->bindValue(":player2", $player2);

                if ($stmt->execute()) {
                    return json_encode(true);
                }
                else {

                    return "F2>" . $date . " " . $terrain . " " . $wid[0]["idHourWeekDay"] . " " . $player1 . " " . $player2;
                    return json_encode(false);
                }
            }
            else {
                return json_encode(false);
            }
        }
        catch(PDOException $e) {
            echo "PDO has encountered an error: " + $e->getMessage();
            die();
        }

        /*$qry = "INSERT INTO tblReservation (fiDate, fiTerrain, fiHourWeek, fiPlayer1, fiPlayer2, dtCreateTS) VALUES (:date, :terrain, SELECT idHourWeekDay FROM tblHourWeekDay WHERE fiHour = :hour AND fiWeekDay = :day, :player1, :player2)";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":date", $date);
            $stmt->bindValue(":day", $day);
            $stmt->bindValue(":hour", $hour);
            $stmt->bindValue(":player1", $player1);
            $stmt->bindValue(":player2", $player2);
            $stmt->bindValue(":terrain", $terrain);

            if ($stmt->execute()) {
                return json_encode(true);
            }
            else {
                return json_encode(false);
            }
        }
        catch(PDOException $e) {
            echo "PDO has encountered an error: " + $e->getMessage();
            die();
        }*/
    }

    public function getTerrainIds() {
        $qry = "SELECT idTerrain FROM tblTerrain";

        try {
            $stmt = $this->dbh->prepare($qry);

            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            else {
                return json_encode(false);
            }
        }
        catch(PDOException $e) {
            echo "PDO has encountered an error: " + $e->getMessage();
            die();
        }
    }
}