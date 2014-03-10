<?php

class SettingsMgr {
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

    public function checkForDBUpdate() {
        $data = json_decode(file_get_contents("http://tecoresy.warnimont.de/updates/version.php"), true);

        $remoteVersion = floatval($data["database"]);

        if ($remoteVersion > floatval($this->getSetting("dbversion"))) {
            return "<span style=\"color: #a00;\">v" . $this->getSetting("dbversion") . " VIEUX! (Actuelle v" . $remoteVersion . ")</span>";
        }
        else {
            return "<span style=\"color: #0a0;\">v" . $this->getSetting("dbversion") . " OK!</span>";
        }
    }

    public function checkForPanelUpdate() {
        $data = json_decode(file_get_contents("http://tecoresy.warnimont.de/updates/version.php"), true);

        $remoteVersion = floatval($data["panel"]);

        if ($remoteVersion > floatval($this->getSetting("pnlversion"))) {
            return "<span style=\"color: #a00;\">v" . $this->getSetting("pnlversion") . " VIEUX! (Actuelle v" . $remoteVersion . ")</span>";
        }
        else {
            return "<span style=\"color: #0a0;\">v" . $this->getSetting("pnlversion") . " OK!</span>";
        }
    }
}