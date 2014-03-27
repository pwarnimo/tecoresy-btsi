<?php

/*
 * TECORESY Admin panel 1.0
 *
 * File : index.php
 * Description :
 *   This file is used for testing purposes. With this page, the login is performed.
 *   This file is deprecated and will be deleted soon.
 */

echo "<h1>TESTING -- LOGIN</h1>";

echo <<< FRM
    <form action="index.php" method="post">
        <input type="text" id="edtUsername" name="edtUsername" placeholde="Username">
        <input type="password" id="edtPassword" name="edtPassword">
        <input type="submit" value="Login">
    </form>
FRM;

$usernm = filter_input(INPUT_POST, "edtUsername");
$password = filter_input(INPUT_POST, "edtPassword");

if (isset($usernm) && isset($password)) {
    include "inc/dbconfig.inc.php";

    $dsn = dbtype . ":dbname=" . database . ";host=" . hostname;


    try {
        $dbh = new PDO($dsn, username, password);

        $qry = "SELECT dtSalt, dtHash FROM tblUser WHERE dtUsername = :username";

        $stmt = $dbh->prepare($qry);

        $stmt->bindValue(":username", $usernm, PDO::PARAM_STR);
        $stmt->execute();

        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $saltFromDB = $res[0]["dtSalt"];
        $hashFromDB = $res[0]["dtHash"];

        echo "<pre>-- LOCAL  " . hash_hmac("sha512", $password, $saltFromDB) . "<br>-- REMOTE " . $hashFromDB . "</pre>";

        if (hash_hmac("sha512", $password, $saltFromDB) === $hashFromDB) {
            echo "<pre>SETTING SESSION . . .</pre>";

            include "inc/classes/User.class.php";

            $user = new User();

            session_start();

            $_SESSION = $user->getUserDataArray($usernm);
            $_SESSION["login"] = true;

            echo "<pre>";
            foreach ($_SESSION as $k => $v) {
                echo $k . " -> " . $v . "<br>";
            }
            echo "</pre>";

            echo "<pre>OK --> <a href=\"main.php\">PROCEED</a></pre>";
        }
        else {
            echo "<pre>FAILURE</pre>";
        }
    }
    catch(PDOException $e) {
        echo "PDO has encountered an error: " + $e->getMessage();
        die();
    }
}