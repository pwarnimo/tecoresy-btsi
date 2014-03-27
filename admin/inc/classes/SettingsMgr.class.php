<?php

/**
 * TECORESY Admin panel 1.0
 *
 * File : SettingsMgr.class.php
 * Description :
 *   This file contains the class for the settings manager.
 *   With this class, we can retrieve the settings for the page from the database.
 */

class SettingsMgr {
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
     * This function gets a setting from the database.
     *
     * @param string $setting This param is used to determine which setting we are going to retrieve from the database.
     *
     * @return string If the query was successful, return the value of the setting. Else, return false.
     */
    public function getSetting($setting) {
        $qry = "SELECT dtString FROM tblParam WHERE dtDescription = :setting";

        try {
            $stmt = $this->dbh->prepare($qry);

            $stmt->bindValue(":setting", $setting);

            if ($stmt->execute()) {
                $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

                return $res[0]["dtString"];
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
     * This function is used to check if we have a database update. In order to check for the update, we are first going
     * to check if we have a new version from the master server "updates.warnimont.de". Then we're going to compare this
     * with the version value stored in the database.
     *
     * The master server "updates.warnimont.de" contains, the files for the TECORESY admin panel. If we have a new file,
     * we can download it here.
     *
     * @return string Returns the html code if the database is up to date or old.
     */
    public function checkForDBUpdate() {
        $data = json_decode(file_get_contents("http://updates.warnimont.de/tecoresy/version.php"), true);

        $remoteVersion = floatval($data["database"]);

        if ($remoteVersion > floatval($this->getSetting("dbversion"))) {
            return "<span style=\"color: #a00;\">v" . $this->getSetting("dbversion") . " VIEUX! (Actuelle v" . $remoteVersion . ")</span>";
        }
        else {
            return "<span style=\"color: #0a0;\">v" . $this->getSetting("dbversion") . " OK!</span>";
        }
    }

    /**
     * This function is used to check if we have a admin panel update. In order to check for the update, we are first going
     * to check if we have a new version from the master server "updates.warnimont.de". Then we're going to compare this
     * with the version value stored in the database.
     *
     * The master server "updates.warnimont.de" contains, the files for the TECORESY admin panel. If we have a new file,
     * we can download it here.
     *
     * @return string Returns the html code if the database is up to date or old.
     */
    public function checkForPanelUpdate() {
        $data = json_decode(file_get_contents("http://updates.warnimont.de/tecoresy/version.php"), true);

        $remoteVersion = floatval($data["panel"]);

        if ($remoteVersion > floatval($this->getSetting("pnlversion"))) {
            return "<span style=\"color: #a00;\">v" . $this->getSetting("pnlversion") . " VIEUX! (Actuelle v" . $remoteVersion . ")</span>";
        }
        else {
            return "<span style=\"color: #0a0;\">v" . $this->getSetting("pnlversion") . " OK!</span>";
        }
    }
}