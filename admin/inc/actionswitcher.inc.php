<?php

/**
 * TECORESY Admin panel 1.0
 *
 * File : actionswitcher.inc.php
 * Description :
 *   This file is used for the ajax request in order to determine which action should be performed. Ex: Add a new user
 *   or delete a reservation.
 */

session_start();

include "dbconfig.inc.php";

function __autoload($class_name) {
    require_once "classes/" . $class_name . ".class.php";
}

$action = filter_input(INPUT_GET, "action");

switch ($action) {
    case "addUser" :
        $userMgr = new UserMgr();
        echo $userMgr->addUserToDB(filter_input(INPUT_POST, "userjson"), filter_input(INPUT_POST, "utypesjson"));

        break;

    case "getUsers" :
        $userMgr = new UserMgr();
        echo $userMgr->getUsersFromDB(true, true);

        break;

    case "deleteSingleUser" :
        $userMgr = new UserMgr();
        echo $userMgr->deleteUserFromDB(filter_input(INPUT_POST, "uid"));

        break;

    case "changeUserState" :
        $userMgr = new UserMgr();
        echo $userMgr->setUserState(filter_input(INPUT_POST, "uid"), filter_input(INPUT_POST, "state"));

        break;

    case "addTerrain" :
        $terrainMgr = new TerrainMgr();
        echo $terrainMgr->addTerrainToDB(filter_input(INPUT_POST, "json"));

        break;

    case "getTerrains" :
        $terrainMgr = new TerrainMgr();
        echo $terrainMgr->getTerrainsFromDB(true, true);

        break;

    case "getTerrainsv2" :
        $terrainMgr = new TerrainMgr();
        echo $terrainMgr->getTerrainsFromDB(false, false);

        break;

    case "changeTerrainState" :
        $terrainMgr = new TerrainMgr();
        echo $terrainMgr->changeTerrainState(filter_input(INPUT_POST, "tid"), filter_input(INPUT_POST, "state"));

        break;

    case "deleteTerrains" :
        $terrainMgr = new TerrainMgr();
        echo $terrainMgr->deleteTerrainFromDB(filter_input(INPUT_POST, "tid"));

        break;

    case "getInvoices" :
        $invoiceMgr = new InvoiceMgr();
        echo $invoiceMgr->getInvoicesFromDB(true);

        break;

    case "changePaymentStatus" :
        $invoiceMgr = new InvoiceMgr();
        echo $invoiceMgr->changePaymentStatus(filter_input(INPUT_POST, "iid"), filter_input(INPUT_POST, "state"));
        //echo "STATE = " . filter_input(INPUT_POST, "state") . " ID = " . filter_input(INPUT_POST, "iid");

        break;

    case "getSingleInvoice" :
        $invoiceMgr = new InvoiceMgr();
        echo $invoiceMgr->getSingleInvoice(filter_input(INPUT_POST, "iid"), true);

        break;

    case "getReservations" :
        $terrainMgr = new TerrainMgr2();
        echo $terrainMgr->getPossibleReservationsForTerrain();

        break;

    case "getDateSpan" :
        $terrainMgr = new TerrainMgr2();
        echo $terrainMgr->getDateSpan();

        break;

    case "getReservationsForTerrain" :
        $terrainMgr = new TerrainMgr2();
        echo $terrainMgr->getReservationsForTerrain(filter_input(INPUT_POST, "tid"));

        break;

    case "getReservationCounts" :
        $terrainMgr = new TerrainMgr2();
        echo $terrainMgr->getReservationCounts();

        break;

    case "getBlockedReservationsForTerrain" :
        $terrainMgr = new TerrainMgr2();
        echo $terrainMgr->getBlockedReservationsForTerrain(filter_input(INPUT_POST, "tid"));

        break;

    case "getLatestMessage" :
        $messageMgr = new MessageMgr();
        echo $messageMgr->getNewestMessage(filter_input(INPUT_POST, "tuser"));

        break;

    case "postMessage" :
        $messageMgr = new MessageMgr();
        echo $messageMgr->addMessage(filter_input(INPUT_POST, "message"), filter_input(INPUT_POST, "state"), filter_input(INPUT_POST, "utypes"));

        break;

    case "blockReservation" :
        $terrainMgr = new TerrainMgr2();
        echo $terrainMgr->blockReservation(filter_input(INPUT_POST, "terrain"), filter_input(INPUT_POST, "date"), filter_input(INPUT_POST, "hour"), filter_input(INPUT_POST, "day"), filter_input(INPUT_POST, "status"));

        break;

    case "addReservation" :
        $terrainMgr = new TerrainMgr2();
        //date, hour, day, player1, player2, terrain
        echo $terrainMgr->addReservation(filter_input(INPUT_POST, "date"), filter_input(INPUT_POST, "hour"), filter_input(INPUT_POST, "day"), filter_input(INPUT_POST, "player1"), filter_input(INPUT_POST, "player2"), filter_input(INPUT_POST, "terrain"));

        break;

    case "deleteSingleInvoice" :
        $invoiceMgr = new InvoiceMgr();
        echo $invoiceMgr->deleteSingleInvoice(filter_input(INPUT_POST, "iid"));

        break;

    case "deleteUsers" :
        $userMgr = new UserMgr();
        echo $userMgr->deleteUsers(filter_input(INPUT_POST, "uids"));

        break;

    case "getTerrainStatus" :
        $terrainMgr = new TerrainMgr2();
        echo $terrainMgr->getTerrainStatus(filter_input(INPUT_POST, "id"));

        break;

    case "blockTerrain" :
        $terrainMgr = new TerrainMgr2();
        echo $terrainMgr->blockTerrain(filter_input(INPUT_POST, "id"), filter_input(INPUT_POST, "state"));

        break;

    case "deleteReservation" :
        $terrainMgr = new TerrainMgr2();
        echo $terrainMgr->deleteReservation(filter_input(INPUT_POST, "date"), filter_input(INPUT_POST, "day"), filter_input(INPUT_POST, "hour"), filter_input(INPUT_POST, "terrain"));

        break;

    case "deleteInvoices" :
        $invoiceMgr = new InvoiceMgr();
        echo $invoiceMgr->deleteMultipleInvoices(filter_input(INPUT_POST, "iids"));

        break;

    case "getUserData" :
        $userMgr = new UserMgr();
        echo $userMgr->getUserData(filter_input(INPUT_POST, "uid"));

        break;

    case "getTypesForUser" :
        $userMgr = new UserMgr();
        echo $userMgr->getUserTypesOfUser(filter_input(INPUT_POST, "uid"));

        break;
}