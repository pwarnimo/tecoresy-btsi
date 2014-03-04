<?php
include "dbconfig.inc.php";

function __autoload($class_name) {
    require_once "classes/" . $class_name . ".class.php";
}

$action = filter_input(INPUT_GET, "action");

switch ($action) {
    case "addUser" :
        $userMgr = new UserMgr();
        echo $userMgr->addUserToDB(filter_input(INPUT_POST, "json"));

        break;
}