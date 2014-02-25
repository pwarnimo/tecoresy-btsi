<?php

class User {
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

    public function getUserDataArray($username) {
        $qry = "SELECT dtUsername, dtFirstname, dtLastname, dtEmail, dtAbo, dtType FROM tblUser WHERE dtUsername = :username";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":username", $username, PDO::PARAM_STR);

            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $userdata = array(
                username  => $res[0]["dtUsername"],
                firstname => $res[0]["dtFirstname"],
                lastname  => $res[0]["dtLastname"],
                email     => $res[0]["dtEmail"],
                abo       => $res[0]["dtAbo"],
                type      => $res[0]["dtType"]
            );

            return $userdata;
        }
        catch(PDOException $e) {
            echo "PDO has encountered an error: " + $e->getMessage();
            die();
        }
    }

    public function TypeIDToDescription($tID) {
        $qry = "SELECT dtDescription FROM tblTypeUser WHERE idTypeUser = :tid";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":tid", $tID, PDO::PARAM_INT);

            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $res[0]["dtDescription"];
        }
        catch(PDOException $e) {
            echo "PDO has encountered an error: " + $e->getMessage();
            die();
        }
    }

    public function TypeAboToDescription($tID) {
        $qry = "SELECT dtDescription FROM tblAbo WHERE idAbo = :tid";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":tid", $tID, PDO::PARAM_INT);

            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $res[0]["dtDescription"];
        }
        catch(PDOException $e) {
            echo "PDO has encountered an error: " + $e->getMessage();
            die();
        }
    }
}