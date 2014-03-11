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
        $returnArr = array();

        $qry = "SELECT idUser, dtUsername, dtFirstname, dtLastname, dtEmail, fiAbo, dtBirthdate, dtLicence, dtState, dtStreet, dtLocation, dtPostalCode, dtCountry FROM tblUser";

        try {
            $stmt = $this->dbh->prepare($qry);

            if ($stmt->execute()) {
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if ($convertFI === true) {
                    $tmpuser = new User();

                    //$res["fiAbo"] = $tmpuser->TypeAboToDescription($res["fiAbo"]);
                    //$res["fiType"] = $tmpuser->TypeIDToDescription($res["fiType"]);

                    //return json_encode($res);

                    foreach ($res as $row) {
                        //$row["fiType"] = $tmpuser->TypeIDToDescription($row["fiType"]);
                        $row["fiAbo"] = $tmpuser->TypeAboToDescription($row["fiAbo"]);

                        array_push($returnArr, $row);
                    }
                }
                /*else {
                    //return json_encode($res);
                }*/

                if ($enableOptions === true) {
                    //$arrWithOptions = array();

                    $tmpArr = $returnArr;
                    $returnArr = array();

                    foreach ($tmpArr as $row) {
                        $row["checkbox"] = "<input class=\"ckbRow\" type=\"checkbox\" id=\"C" . $row["idUser"] . "\">";
                        $row["funcedit"] = "<span id=\"E" . $row["idUser"] . "\" class=\"glyphicon glyphicon-pencil edit\"></span>";
                        $row["funcdel"] = "<span id=\"D" . $row["idUser"] . "\" class=\"glyphicon glyphicon-trash delete\"></span>";

                        if ($row["dtState"] == 1) {
                            $row["funcstate"] = "<span title=\"Cliquez ici pour deactiver l'utilisateur.\" style=\"color: #0a0;\" id=\"A" . $row["idUser"] . "\" class=\"glyphicon glyphicon-ok-circle state\"></span>";
                        }
                        else {
                            $row["funcstate"] = "<span title=\"Cliquez ici pour activer l'utilisateur.\" style=\"color: #a00;\" id=\"D" . $row["idUser"] . "\" class=\"glyphicon glyphicon-ban-circle state\"></span>";
                        }

                        if ($row["dtState"] == 1) {
                            $row["dtState"] = "Oui";
                        }
                        else {
                            $row["dtState"] = "Non";
                        }

                        array_push($returnArr, $row);
                    }

                    return json_encode($returnArr);
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

    public function deleteUserFromDB($id) {
        $qry = "DELETE FROM tblUser WHERE idUser = :id";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":id", $id);

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

    public function setUserState($id, $state) {
        $qry = "UPDATE tblUser SET dtState = :state WHERE idUser = :id";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":state", (int)$state);
            $stmt->bindValue(":id", $id);

            if ($stmt->execute()) {
                //return true;
                return "T" . $state . " for " . $id;
            }
            else {
                //return false;
                return "F" . $state . " for " . $id;
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