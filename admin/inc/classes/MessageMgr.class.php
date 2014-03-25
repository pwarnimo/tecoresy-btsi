<?php

class MessageMgr {
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

    public function getAllMessages() {
        $qry = "";
    }

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

    public function removeMessages($ids) {
        $qry = "";
    }
}