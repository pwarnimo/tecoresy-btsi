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
        $qry = "SELECT dtUsername, dtFirstname, dtLastname, dtEmail FROM tblUser WHERE dtUsername = :username";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":username", $username, PDO::PARAM_STR);
            $stmt->execute();

            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $userdata = array(
                "uname" => $res[0]["dtUsername"],
                "fname" => $res[0]["dtFirstname"],
                "lname" => $res[0]["dtLastname"],
                "email" => $res[0]["dtEmail"]
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

            if ($stmt->execute()) {
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $res[0]["dtDescription"];
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

    public function TypeAboToDescription($tID) {
        $qry = "SELECT dtDescription FROM tblAbo WHERE idAbo = :tid";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":tid", $tID, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $res[0]["dtDescription"];
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

    public function checkLogin() {
        if (isset($_SESSION["login"])) {
            if ($_SESSION["login"] === false) {
                header("Location: index.php");
            }
        }
        else {
            header("Location: index.php");
        }
    }
}