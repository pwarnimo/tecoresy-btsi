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

    public function getUsersFromDB($convertFI) {
        $returnArr = array();

        $qry = "SELECT idUser, dtUsername, dtFirstname, dtLastname, dtEmail, fiAbo, dtBirthdate, dtLicence, dtState, dtStreet, dtLocation, dtPostalCode, dtCountry FROM tblUser";

        try {
            $stmt = $this->dbh->prepare($qry);

            if ($stmt->execute()) {
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($res as $row) {
                    $usertypes = $this->getUserTypesOfUser($row["idUser"]);

                    $row["usertypes"] = $usertypes;

                    array_push($returnArr, $row);
                }

                /*if ($convertFI === true) {
                    $tmpuser = new User();

                    //$res["fiAbo"] = $tmpuser->TypeAboToDescription($res["fiAbo"]);
                    //$res["fiType"] = $tmpuser->TypeIDToDescription($res["fiType"]);

                    //return json_encode($res);

                    foreach ($res as $row) {
                        //$row["fiType"] = $tmpuser->TypeIDToDescription($row["fiType"]);
                        $row["fiAbo"] = $tmpuser->TypeAboToDescription($row["fiAbo"]);

                        array_push($returnArr, $row);
                    }

                    return json_encode($returnArr);
                }
                else {
                    return json_encode($res);
                }*/

                return json_encode($returnArr);
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

    public function getUserTypesOfUser($id) {
        $qry = "SELECT idTypeUser, dtDescription FROM tblTypeUser, tblUserTypeUser WHERE fiUser = :id AND fiTypeUser = idTypeUser";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":id", $id);

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