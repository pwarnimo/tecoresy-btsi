<?php

/**
 * TECORESY Admin panel 1.0
 *
 * File : TerrainMgr.class.php
 * Description :
 *   This file contains the class for the terrain manager.
 *   With this class, we can manage the single terrains as well as the reservations for each terrain.
 */

class TerrainMgr2 {
    private $dbh;

    /**
     * The constructor creates the database handle.
     */
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

    /**
     * This function loads every possible reservations from the database.
     * The reservations will be fetched from datespan of 8 days.
     *
     * @return string If the query was successful, return the json array for the possible reservations. Else, return false.
     */
    public function getPossibleReservationsForTerrain() {
        $today = date("Y-m-d", time());

        $qry = "SELECT fiDate, idHour, dtWeekDay, fiTerrain FROM tblPossibleReservation, tblHour, tblWeekDay, tblHourWeekDay WHERE fiHourWeekDay = idHourWeekDay AND fiHour = idHour AND fiWeekDay = idWeekDay AND fiDate BETWEEN :date AND DATE_ADD(:date, INTERVAL 7 DAY ) ORDER BY fiDate, idHour";

        try {
            $stmt = $this->dbh->prepare($qry);

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
    }

    /**
     * This function retrieves every dates for a specific timespan.
     *
     * @return string If the query was successful, return the json array for the dates. Else, return false.
     */
    public function getDateSpan() {
        $qry = "SELECT idDate FROM tblDate WHERE idDate BETWEEN CURRENT_DATE() AND DATE_ADD(CURRENT_DATE(), INTERVAL 7 DAY) ORDER BY idDate";

        try {
            $stmt = $this->dbh->prepare($qry);

            if ($stmt->execute()) {
                return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
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

    /**
     * This function loads every reservation for a terrain from the database.
     *
     * @param integer $id This param contains the id of the terrain from which we want to get the reservations.
     *
     * @return string If the query was successful, return the json array for the reservations. Else, return false.
     */
    public function getReservationsForTerrain($id) {
        $qry = "SELECT fiDate, fiTerrain, fiHour, fiPlayer1, fiPlayer2 FROM tblReservation, tblHourWeekDay WHERE fiTerrain = :id AND fiHourWeek = idHourWeekDay";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":id", $id);

            if ($stmt->execute()) {
                return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
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

    /**
     * This function returns the count of every reservations on every terrain.
     *
     * @return string If the query was successful, return the json array for reservation counts. Else, return false.
     */
    public function getReservationCounts() {
        $qry = "SELECT fiTerrain, COUNT(*) AS qcfCount FROM tblReservation GROUP BY fiTerrain";

        try {
            $stmt = $this->dbh->prepare($qry);

            if ($stmt->execute()) {
                return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
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

    /**
     * This function loads every blocked reservations from the database. This is needed in order to limit a user to
     * create a reservation for a specified date and time.
     *
     * @param boolean $id This param contains the id of the terrain.
     *
     * @return string If the query was successful, return the json array for the blocked reservations. Else, return false.
     */
    public function getBlockedReservationsForTerrain($id) {
        $qry = "SELECT fiDate, fiTerrain, fiHour FROM tblPossibleReservation, tblHourWeekDay WHERE fiTerrain = :id AND fiHourWeekDay = idHourWeekDay AND dtIsBlocked = \"Yes\" AND fiDate BETWEEN CURRENT_DATE() AND DATE_ADD(CURRENT_DATE(), INTERVAL 7 DAY)";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":id", $id);

            if ($stmt->execute()) {
                return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
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

    /**
     * This function is used to block a reservation for the specified date and time on a terrain.
     *
     * @param interger $terrain This param contains the ID of the terrain.
     *
     * @param string $date This param contains the full date for the reservation to block.
     *
     * @param integer $hour This param contains the hour on which the reservation should be blocked.
     *
     * @param interger $weekday This param contains the weekday for the reservation to block.
     *
     * @param boolean $state This param contains the state of the reservation. Ex: block or unblock.
     *
     * @return string If the query was successful, return true. Else, return false.
     */
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
                return json_encode(true);
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

    /**
     * This function creates a new reservation in the database.
     *
     * @param string $date This param contains the date for the reservation to create.
     *
     * @param integer $hour This param contains the hour on which the reservation should be created.
     *
     * @param integer $day This param contains the weekday for the reservation to create.
     *
     * @param integer $player1 This param contains the id of the first player for the reservation.
     *
     * @param integer $player2 This param contains the id of the opponent for the reservation.
     *
     * @param integer $terrain This param contains the id of the terrain on which the reservation should be created.
     *
     * @return string If the query was successful, return true. Else, return false.
     */
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
    }

    /**
     * This returns the IDs for every terrain stored in the database.
     *
     * @return string If the query was successful, return the json array for terrain IDs. Else, return false.
     */
    public function getTerrainIds() {
        $qry = "SELECT idTerrain FROM tblTerrain";

        try {
            $stmt = $this->dbh->prepare($qry);

            if ($stmt->execute()) {
                return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
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

    /**
     * This function returns the count of every reservation for the specified terrain.
     *
     * @param integer $id This param contains the ID of the terrain.
     *
     * @return string If the query was successful, return the json array for the terrain IDs. Else, return false.
     */
    public function getReservationCountForTerrain($id) {
        $qry = "SELECT COUNT(*) AS qcfCount FROM tblReservation WHERE fiTerrain = :id";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue("id", $id);

            if ($stmt->execute()) {
                return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
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

    /**
     * This gets the state of a terrain specified by the ID. Ex: Blocked or unblocked.
     *
     * @param integer $id This param contains the ID of the terrain.
     *
     * @return string If the query was successful, return the json array for the terrain state. Else, return false.
     */
    public function getTerrainStatus($id) {
        $qry = "SELECT dtIsActive FROM tblTerrain WHERE idTerrain = :id";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue("id", $id);

            if ($stmt->execute()) {
                return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
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

    /**
     * This function is used to block or unblock a terrain. When a terrain is blocked, no one can create a reservation on that
     * terrain.
     *
     * @param integer $id This param contains the ID of the terrain to block or unblock.
     *
     * @param boolean $state This param contains the state of the terrain. Ex: Blocked or unblocked.
     *
     * @return string If the query was successful, return true. Else, return false.
     */
    public function blockTerrain($id, $state) {
        $qry = "UPDATE tblTerrain SET dtIsActive = :state WHERE idTerrain = :id";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue("id", $id);
            $stmt->bindValue(":state", $state);

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
        }
    }

    /**
     * This function deletes a reservation from the database.
     *
     * @param string $date This param contains the date for the reservation to be deleted.
     *
     * @param integer $day This param contains the day for the reservation to be deleted.
     *
     * @param integer $hour This param contains the hour on which the reservation should be deleted.
     *
     * @param integer $terrain This param contains the ID of the terrain where the reservation should be deleted.
     *
     * @return string If the query was successful, return true. Else, return false.
     */
    public function deleteReservation($date, $day, $hour, $terrain) {
        $qry = "DELETE FROM tblReservation WHERE fiDate = :date AND fiTerrain = :terrain AND fiHourWeek = (SELECT idHourWeekDay FROM tblHourWeekDay WHERE fiHour = :hour AND fiWeekDay = :weekday)";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":date", $date);
            $stmt->bindValue(":terrain", $terrain);
            $stmt->bindValue(":hour", $hour);
            $stmt->bindValue(":weekday", $day);

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
        }
    }
}