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
}