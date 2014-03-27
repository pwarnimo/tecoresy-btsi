<?php

/**
 * TECORESY Admin panel 1.0
 *
 * File : UserMgr.class.php
 * Description :
 *   This file contains the class for the user manager.
 *   With this class, we can manage the users which are stored in the database.
 */

class UserMgr {
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
     * This function loads every user from the database into a json array.
     *
     * @param boolean $convertFI OBSOLETE
     *
     * @return string If the query was successful, return the json array for the users. Else, return false.
     */
    public function getUsersFromDB($convertFI) {
        $returnArr = array();

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
            }
            else {
                return jsone_encode(false);
            }
        }
        catch(PDOException $e) {
            echo "PDO has encountered an error: " + $e->getMessage();
            die();
        }
    }

    /**
     * This function loads the available usertypes into an array.
     *
     * @return string If the query was successful, return an array containing the usertypes. Else, return false.
     */
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

    /**
     * This function loads the available abos from the database into an array.
     *
     * @return string If the query was successful, return an array containing the abos. Else, return false.
     */
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

    /**
     * This function adds a new user into the database. The user and usertypes are passed via a json array to the
     * function. Then, we are creating a salt which is used for the encryption of the password. The password will be
     * encrypted with the SHA512 algorithm.
     *
     * Firstly, we are executing the query which adds the user into the database. After that, a second query will be
     * executed which adds the usertypes for the new user into the database.
     *
     * @param string $userJson This param contains the json array which contains the details of the user to be added.
     *
     * @param string $utypesJson This param contains the json array of the usertypes which are added for the new user.
     *
     * @return string If the query was successful, return true. Else, return false.
     */
    public function addUserToDB($userJson, $utypesJson) {
        $user = json_decode($userJson, true);
        $utypes = json_decode($utypesJson, true);

        $usercred = $this->getHashAndSalt($user["password"]);

        unset($user["password"]);

        $user["state"] = 0;
        $user["abo"] = 1;
        $user["hash"] = $usercred["hash"];
        $user["salt"] = $usercred["salt"];

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

    /**
     * This function deletes a user ín the database.
     *
     * @param integer $id This param contains the id of the user which is going to be deleted.
     *
     * @return string If the query was successful, return true. Else, return false.
     */
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
    }

    /**
     * This function is used to edit the details of a user. The user data and types are passed via a json array to the
     * function.
     *
     * @param string $userJson This param contains a json array with the details of a user.
     *
     * @param string $utypesJson This param contains a json array with the usertypes for the user to be edited.
     *
     * @return string If the query was successful, return true. Else, return false.
     */
    public function editUserInDB($userJson, $utypesJson) {
        return false;
    }

    /**
     * This function blocks or unblocks a user. A user cannot login if the state is set to blocked.
     *
     * @param integer $id This param contains the id of the user which state should be changed.
     *
     * @param boolean $state This param contains the new state of the user. Ex: Blocked or unblocked.
     *
     * @return string If the query was successful, return true. Else, return false.
     */
    public function setUserState($id, $state) {
        $qry = "UPDATE tblUser SET dtIsActive = :state WHERE idUser = :id";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":state", $state);
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
     * This function returns an array containing the salt and hash of a user. We need this in order to check if the
     * password of the user is correct, when we login.
     *
     * @param string $password This param contains the password of the user.
     *
     * @return string Return an array containing the salt and hash.
     */
    public function getHashAndSalt($password) {
        $salt = uniqid(mt_rand(), true);
        $hash = hash_hmac("sha512", $password, $salt);

        $arr_return = array(
            "salt" => $salt,
            "hash" => $hash
        );

        return $arr_return;
    }

    /**
     * This function returns a json array containing the usertypes of a user. Ex: Is the user an administrator or
     * member.
     *
     * @param integer $id This param contains the id of the user.
     *
     * @return string If the query was successful, return the json array for the usertypes. Else, return false.
     */
    public function getUserTypesOfUser($id) {
        $qry = "SELECT idTypeUser, dtDescription FROM tblTypeUser, tblUser_TypeUser WHERE fiUser = :id AND fiTypeUser = idTypeUser";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":id", $id);

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
     * This function returns an array containing the IDs, firstnames and lastnames of every user in the database.
     *
     * @return array If the query was successful, return an array containing the IDs, firstnames and lastnames of every
     * user. Else, return false.
     */
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

    /**
     * This function returns the count of every active users in the database.
     *
     * @return string If the query was successful, return the json array for the count. Else, return false.
     */
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

    /**
     * This function returns the count of every blocked users in the database.
     *
     * @return string If the query was successful, return the json array for the count. Else, return false.
     */
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

    /**
     * This function deletes multiple users in the database. The IDs are passed via a json array to the function. We are
     * also checking if the array does not contain the ID of the currently logged in user because it should not be
     * deleted.
     *
     * @param string $ids This param contains a json array of the IDs of the users to be deleted.
     *
     * @return string If the query was successful, return true. Else, return false.
     */
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

    /**
     * This function returns every details of a user specified by the ID in a json array.
     *
     * @param integer $id This param contains the ID of the user.
     *
     * @return string If the query was successful, return the json array for the user details. Else, return false.
     */
    public function getUserData($id) {
        $qry = "SELECT * FROM tblUser WHERE idUser = :id";

        $stmt = $this->dbh->prepare($qry);

        $stmt->bindValue(":id", $id);

        if ($stmt->execute()) {
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($res);
        }
        else {
            return json_encode(false);
        }
    }
}