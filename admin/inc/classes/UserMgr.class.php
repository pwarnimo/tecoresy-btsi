<?php

class UserMgr {
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

    public function getUsersFromDB($convertFI, $enableOptions) {
        $qry = "SELECT idUser, dtUsername, dtFirstname, dtLastname, dtEmail, fiType, fiAbo, dtBirthdate, dtLicence, dtState FROM tblUser";

        try {
            $stmt = $this->dbh->prepare($qry);

            if ($stmt->execute()) {
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

                /*if ($convertFI === true) {
                    $tmpuser = new User();

                    //$res["fiAbo"] = $tmpuser->TypeAboToDescription($res["fiAbo"]);
                    //$res["fiType"] = $tmpuser->TypeIDToDescription($res["fiType"]);

                    return json_encode($res);
                }
                else {
                    return json_encode($res);
                }*/

                if ($enableOptions === true) {
                    $arrWithOptions = array();

                    foreach ($res as $row) {
                        $row["checkbox"] = "<input type=\"checkbox\" id=\"C" . $row["idUser"] . "\">";
                        $row["funcedit"] = "<span id=\"E" . $row["idUser"] . "\" class=\"glyphicon glyphicon-pencil edit\"></span>";
                        $row["funcdel"] = "<span id=\"D" . $row["idUser"] . "\" class=\"glyphicon glyphicon-trash delete\"></span>";
                        $row["funcstate"] = "<span id=\"S" . $row["idUser"] . "\" class=\"glyphicon glyphicon-ok-circle state\"></span>";

                        array_push($arrWithOptions, $row);
                    }

                    return json_encode($arrWithOptions);
                }
                else {
                    return json_encode($res);
                }
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

    public function getUserTypesFromDB() {
        $qry = "SELECT * FROM tblTypeUser";

        try {
            $stmt = $this->dbh->prepare($qry);

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

    public function getAbosFromDB() {
        $qry = "SELECT * FROM tblAbo";

        try {
            $stmt = $this->dbh->prepare($qry);

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

    public function addUserToDB($userJson) {
        $user = json_decode($userJson, true);

        $usercred = $this->getHashAndSalt($user["password"]);

        unset($user["password"]);

        $user["state"] = 0;
        $user["abo"] = 1;
        $user["hash"] = $usercred["hash"];
        $user["salt"] = $usercred["salt"];

        /*$debugStr = "";
        foreach ($user as $key => $property) {
            $debugStr .= $key . " -> " . $property . "\n";
        }

        return $debugStr;*/

        $qry = "INSERT INTO tblUser (dtUsername, dtHash, dtFirstname, dtLastname, dtEmail, fiAbo, fiType, dtSalt,
            dtLicence, dtBirthdate, dtState, dtStreet, dtLocation, dtPostalCode, dtCountry) VALUES (:username, :hash,
            :firstname, :lastname, :email, :abo, :type, :salt, :license, :birthdate, :state, :address, :location,
            :postalcode, :country)";

        try {
            $stmt = $this->dbh->prepare($qry);

            foreach ($user as $key => $property) {
                $stmt->bindValue(":" . $key, $property);
            }

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

    public function deleteUserFromDB($username) {
        $qry = "DELETE FROM tblUser WHERE dtUsername = :username";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":username", $username);

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

    public function editUserInDB($username) {

    }

    public function setUserState($username, $state) {
        $qry = "UPDATE tblUser SET dtState = :state WHERE dtUsername = :username";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":state", $state);
            $stmt->bindValue(":username", $username);

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

    public function getHashAndSalt($password) {
        $salt = uniqid(mt_rand(), true);
        $hash = hash_hmac("sha512", $password, $salt);

        $arr_return = array(
            "salt" => $salt,
            "hash" => $hash
        );

        return $arr_return;
    }
}