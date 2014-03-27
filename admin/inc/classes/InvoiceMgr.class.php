<?php

/**
 * TECORESY Admin panel 1.0
 *
 * File : InvoiceMgr.class.php
 * Description :
 *   This file contains the class for managing the invoices.
 */

class InvoiceMgr {
    private $dbh;

    /**
     * The constructor creates the database handle.
     */
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

    /**
     * This function loads every invoice from the database.
     *
     * @param boolean $convertFi This parameter is obsolete.
     *
     * @return string If the query was successful, return the json array for the invoices. Else, return false.
     */
    public function getInvoicesFromDB($convertFi) {
        $qry = "SELECT idFacture, dtFirstname, dtLastname, fiDate, fiHour, fiTerrain, dtPayed, dtCreateTS FROM tblFacture";

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
     * This function sets the payment status of an invoice to payed or unpayed.
     *
     * @param int $id This parameter contains the id of the invoice.
     *
     * @param boolean $state This param contains the state of the invoice (Payed or unpayed).
     *
     * @return string If the query was successful, return true. Else, return false.
     */
    public function changePaymentStatus($id, $state) {
        $qry = "UPDATE tblFacture SET dtPayed = :state WHERE idFacture = :iid";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":iid", $id);
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
     * OBSOLETE! This function gets a single invoice from the database.
     *
     * @param int $id This parameter contains the id of the invoice.
     *
     * @param boolean $convertFis This param is obsolete.
     *
     * @return string If the query was successful, return the json array of the invoice details. Else, return false.
     */
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
                return json_encode(false);
            }
        }
        catch(PDOException $e) {
            echo "PDO has encountered an error: " + $e->getMessage();
            die();
        }
    }

    /**
     * This function returns the details of a single invoice.
     *
     * @param int $id This parameter contains the id of the invoice.
     *
     * @return array If the query was successful, return the array of the invoice details. Else, return false.
     */
    public function getInvoice($id) {
        $qry = "SELECT * FROM tblFacture WHERE idFacture = :id";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":id", $id);

            if ($stmt->execute()) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
     * This function deletes a single invoice in the database.
     *
     * @param int $id This parameter contains the id of the invoice.
     *
     * @return string If the query was successful, return true. Else, return false.
     */
    public function deleteSingleInvoice($id) {
        $qry = "DELETE FROM tblFacture WHERE idFacture = :id";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":id", $id);

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
     * This function returns the count of the payed invoices.
     *
     * @return string If the query was successful, return the count as a json array. Else, return false.
     */
    public function getPayedInvoicesCount() {
        $qry = "SELECT COUNT(*) AS qcfCount FROM tblFacture WHERE dtPayed = 'Yes'";

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
     * This function returns the count of the unpayed invoices.
     *
     * @return string If the query was successful, return the count as a json array. Else, return false.
     */
    public function getUnpayedInvoicesCount() {
        $qry = "SELECT COUNT(*) AS qcfCount FROM tblFacture WHERE dtPayed = 'No'";

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
     * This function returns the count of the payed invoices.
     *
     * @param string $ids This param contains a json array of the invoices to delete.
     *
     */
    public function deleteMultipleInvoices($ids) {
        $arrids = json_decode($ids);

        $qry = "DELETE FROM tblFacture WHERE idFacture = :id";

        try {
            foreach ($arrids as $id) {
                $stmt = $this->dbh->prepare($qry);

                $stmt->bindValue(":id", $id);

                $stmt->execute();
            }
        }
        catch(PDOException $e) {
            echo "PDO has encountered an error: " + $e->getMessage();
            die();
        }
    }
}