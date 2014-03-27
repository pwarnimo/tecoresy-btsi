<?php

/**
 * TECORESY Admin panel 1.0
 *
 * File : MessageMgr.class.php
 * Description :
 *   This file contains the class message system.
 */

class MessageMgr {
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
     * This function gets the newest message from the database.
     *
     * @param integer $usertype This param is used to determine if the message is directed for a specific usertype.
     * Ex: Destined for admins, members or both.
     *
     * @return string If the query was successful, return the message as a json array. Else, return false.
     */
    public function getNewestMessage($usertype) {
        $qry = "SELECT idMessage, dtMessageText, fiMessageState, M.dtCreateTS FROM tblMessage M, tblTypeUser_Message WHERE fiMessage = idMessage AND fiTypeUser = :tuser ORDER BY M.dtCreateTS DESC LIMIT 1";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":tuser", $usertype);

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
     * This adds a new message to the database.
     *
     * @param string $message This param contains the message text.
     *
     * @param integer $state This param contains the state of the message. Ex: Important, Warning or Information.
     *
     * @param string $usertypes This param contains a json array of the usertypes for which the message is directed.
     *
     * @return string If the query was successful, return true. Else, return false.
     */
    public function addMessage($message, $state, $usertypes) {
        $arrUTypes = json_decode($usertypes);

        $qry = "INSERT INTO tblMessage (dtMessageText, fiMessageState, dtCreateTS) VALUES (:message, :state, NULL)";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":message", strip_tags($message));
            $stmt->bindValue(":state", $state);

            if ($stmt->execute()) {
                $lastID = $this->dbh->lastInsertId();

                $qry = "INSERT INTO tblTypeUser_Message (fiTypeUser, fiMessage) VALUES (:tuser, $lastID)";

                $stmt = $this->dbh->prepare($qry);

                foreach ($arrUTypes as $usertype) {
                    $stmt->bindValue(":tuser", $usertype);

                    if (!$stmt->execute()) {
                        return json_encode(false);
                    }
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
}