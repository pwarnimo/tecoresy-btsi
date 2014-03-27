<?php

/**
 * TECORESY Admin panel 1.0
 *
 * File : User.class.php
 * Description :
 *   This file contains the class for a user.
 *   This class defines the properties of a user and is also used to check the login and type of the user.
 */

class User {
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
     * This functions loads the details of user into the session.
     *
     * @param string $username This param contains the username which is needed to get the details of a user from the
     * database.
     *
     * @return array Returns the details of a user in an array.
     */
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

    /*public function TypeIDToDescription($tID) {
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
    }*/

    /**
     * This function checks if the user has successfully logged in and is of the type administrator. If not, return to
     * the index site of the public interface by Philippe.
     */
    public function checkLogin() {
        if (isset($_SESSION["login"])) {
            if ($_SESSION["login"] === false) {
                header("Location: index.php");
            }
            else {
                if (!in_array(0, $_SESSION["type"])) {
                    header("Location: index.php");
                }
            }
        }
        else {
            header("Location: index.php");
        }
    }
}