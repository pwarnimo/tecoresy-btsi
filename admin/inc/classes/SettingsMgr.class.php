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
}