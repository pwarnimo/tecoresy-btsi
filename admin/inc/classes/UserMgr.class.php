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

        //$qry = "SELECT idUser, dtUsername, dtFirstname, dtLastname, dtEmail, fiAbo, dtBirthdate, dtLicence, dtIsActive, dtStreet, dtLocation, dtPostalCode, dtCountry FROM tblUser";

        $qry = "SELECT idUser, dtUsername, dtFirstname, dtLastname, dtEmail, dtPhone, dtLicence, dtBirthdate, dtIsActive, dtStreet, dtLocation, dtPostalCode, dtCountry, fiAbo FROM tblUser";

        try {
            $stmt = $this->dbh->prepare($qry);

            if ($stmt->execute()) {
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($res as $row) {
                    $usertypes = $this->getUserTypesOfUser($row["idUser"]);

                    $row["usertypes"] = $usertypes;

                    array_push($returnArr, $row);
                }

                return json_encode($returnArr);

                //return json_encode($res);
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

    public function addUserToDB($userJson, $utypesJson) {
        $user = json_decode($userJson, true);
        $utypes = json_decode($utypesJson, true);

        $usercred = $this->getHashAndSalt($user["password"]);

        unset($user["password"]);

        $user["state"] = 0;
        $user["abo"] = 1;
        $user["hash"] = $usercred["hash"];
        $user["salt"] = $usercred["salt"];

        //return var_dump($user);

        /*$debugStr = "";
        foreach ($utypes as $key => $property) {
            $debugStr .= $key . " -> " . $property . "\n";
        }*/

        //return $debugStr;

        /*$qry = "INSERT INTO tblUser (dtUsername, dtHash, dtFirstname, dtLastname, dtEmail, fiAbo, fiType, dtSalt,
            dtLicence, dtBirthdate, dtState, dtStreet, dtLocation, dtPostalCode, dtCountry) VALUES (:username, :hash,
            :firstname, :lastname, :email, :abo, :type, :salt, :license, :birthdate, :state, :address, :location,
            :postalcode, :country)";*/

        $qry = "INSERT INTO tblUser (dtUsername, dtHash, dtFirstname, dtLastname, dtEmail, dtPhone, dtSalt, dtLicence, dtBirthdate, dtIsActive, dtStreet, dtLocation, dtPostalCode, dtCountry, fiAbo, fiTuteur, dtCreateTS) VALUES (:username, :hash, :firstname, :lastname, :email, :phone, :salt, :licence, :birthdate, :state, :street, :location, :postalcode, :country, :abo, :tuteur, NULL)";

        try {
            $stmt = $this->dbh->prepare($qry);

            foreach ($user as $key => $property) {
                $stmt->bindValue(":" . $key, strip_tags($property));
            }

            if ($stmt->execute()) {
                $lastID = $this->dbh->lastInsertId();

                $qry = "INSERT INTO tblUser_TypeUser (fiTypeUser, fiUser, dtCreateTS) VALUES (:utype, $lastID, NULL)";

                $stmt = $this->dbh->prepare($qry);

                foreach ($utypes as $utype) {
                    $stmt->bindValue(":utype", $utype);

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

    public function deleteUserFromDB($id) {
        if ($id != $_SESSION["id"]) {
            $qry = "DELETE FROM tblUser_TypeUser WHERE fiUser = :id";

            try {
                $stmt = $this->dbh->prepare($qry);

                $stmt->bindValue(":id", $id);

                if ($stmt->execute()) {
                    $qry = "DELETE FROM tblUser WHERE idUser = :id";

                    $stmt = $this->dbh->prepare($qry);

                    $stmt->bindValue(":id", $id);

                    if ($stmt->execute()) {
                        return json_encode(true);
                    }
                    else {
                        return json_encode(false);
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
        else {
            return json_encode(false);
        }
        /*$qry = "DELETE FROM tblUser WHERE idUser = :id";

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
        }*/
    }

    public function editUserInDB($username) {

    }

    public function setUserState($id, $state) {
        $qry = "UPDATE tblUser SET dtIsActive = :state WHERE idUser = :id";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":state", $state);
            $stmt->bindValue(":id", $id);

            if ($stmt->execute()) {
                return json_encode(true);
                //return "T" . $state . " for " . $id;
            }
            else {
                return json_encode(false);
                //return "F" . $state . " for " . $id;
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
        $qry = "SELECT idTypeUser, dtDescription FROM tblTypeUser, tblUser_TypeUser WHERE fiUser = :id AND fiTypeUser = idTypeUser";

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

    public function getUserList() {
        $qry = "SELECT idUser, dtFirstname, dtLastname FROM tblUser";

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

    public function getUnblockedUserCount() {
        $qry = "SELECT COUNT(*) AS qcfCount FROM tblUser WHERE dtIsActive = 'Yes'";

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

    public function getBlockedUserCount() {
        $qry = "SELECT COUNT(*) AS qcfCount FROM tblUser WHERE dtIsActive = 'No'";

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

    public function deleteUsers($ids) {
        $arrids = json_decode($ids);

        if (!in_array($_SESSION["id"], $arrids)) {
            $qry = "DELETE FROM tblUser WHERE idUser = :id";

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

    public function getUserData($id) {
        $qry = "SELECT * FROM tblUser WHERE idUser = :id";

        $stmt = $this->dbh->prepare($qry);

        $stmt->bindValue(":id", $id);

        if ($stmt->execute()) {
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            /*foreach ($res as $row) {
                //$usertypes = $this->getUserTypesOfUser($id);

                //$row["usertypes"] = $usertypes;

                array_push($returnArr, $row);
            }

            return json_encode($returnArr);*/

            return json_encode($res);
        }
        else {
            return json_encode(false);
        }
    }

    public function editUser($userJson) {
        //$qry = "UPDATE tblUser SET dtUsername = "
    }
}