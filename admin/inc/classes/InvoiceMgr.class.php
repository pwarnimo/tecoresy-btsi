<?php

class InvoiceMgr {
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

    public function getInvoicesFromDB($convertFi) {
        if ($convertFi === true) {
            $qry = "SELECT F.idFacture, F.fiTerrain, F.fiDateHeure, F.fiPlayer1, F.fiPlayer2, U1.dtFirstname AS dtPlayer1Firstname, U2.dtFirstname AS dtPlayer2Firstname, U1.dtLastname AS dtPlayer1Lastname, U2.dtLastname AS dtPlayer2Lastname, F.dtPrix, F.dtPayed, F.dtCreateTS FROM tblFacture F LEFT JOIN tblUser U1 ON U1.idUser = fiPlayer1 LEFT JOIN tblUser U2 ON U2.idUser = fiPlayer2";
        }
        else {
            $qry = "SELECT * FROM tblFacture";
        }

        $stmt = $this->dbh->prepare($qry);

        try {
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

    public function changePaymentStatus($id, $state) {
        $qry = "UPDATE tblFacture SET dtPayed = :state WHERE idFacture = :iid";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":iid", $id);
            $stmt->bindValue(":state", $state);

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

    public function getSingleInvoice($id, $convertFis) {
        if ($convertFis === true) {
            $qry = "SELECT F.idFacture, F.fiTerrain, F.fiDateHeure, F.fiPlayer1, F.fiPlayer2, U1.dtFirstname AS dtPlayer1Firstname, U2.dtFirstname AS dtPlayer2Firstname, U1.dtLastname AS dtPlayer1Lastname, U2.dtLastname AS dtPlayer2Lastname, F.dtPrix, F.dtPayed, F.dtCreateTS FROM tblFacture F LEFT JOIN tblUser U1 ON U1.idUser = fiPlayer1 LEFT JOIN tblUser U2 ON U2.idUser = fiPlayer2 WHERE F.idFacture = :id";
        }
        else {
            $qry = "SELECT * FROM tblFacture WHERE idFacture = :id";
        }

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue("id", $id);

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