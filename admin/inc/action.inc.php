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

    case "getUsers" :
        $userMgr = new UserMgr();
        echo $userMgr->getUsersFromDB(false, true);

        break;

    case "deleteUsers" :
        $userMgr = new UserMgr();
        echo $userMgr->deleteUserFromDB(filter_input(INPUT_POST, "uid"));

        break;

    case "changeUserState" :
        $userMgr = new UserMgr();
        echo $userMgr->setUserState(filter_input(INPUT_POST, "uid"), filter_input(INPUT_POST, "state"));
        //echo filter_input(INPUT_POST, "uid") . "  " . filter_input(INPUT_POST, "state");

        break;
}