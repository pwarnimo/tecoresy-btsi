<?php

/**
 * TECORESY Admin panel 1.0
 *
 * File : home.inc.php
 * Description :
 *   This file contains the homepage. On this page, we are going to display general informations.
 */

echo <<< PAGE
    <div class="page-header">
PAGE;

echo "<h1>TECORESY Admin <small>Bienvenue " . $_SESSION["lname"] . " " . $_SESSION["fname"] . "!</small></h1>";

echo <<< PAGE
    </div>

    <!-- This section contains the message system. Here we can add new messages to the database -->
    <div class="panel panel-default">
        <div class="panel-heading">
            Messages importants <span class="pull-right"><button type="button" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-info-sign"></span></button>&nbsp;<button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-warning-sign"></span></button>&nbsp;<button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon glyphicon-exclamation-sign"></span></button>&nbsp;&nbsp;<button id="btnShowMsgBox" type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-plus-sign"></span></button></span>
        </div>
        <div class="panel-body">
            <pre id="message-text">Pas de messages.</pre>
            <form id="messagebox">
                <input id="edtMessageText" type="text" class="form-control"><br>
                <button id="btnPost" type="button" class="btn btn-default"><span class="glyphicon glyphicon glyphicon-pencil"></span></button>
                <select id="lsbState">
                    <option value="1">Information</option>
                    <option value="2">Avertissement</option>
                    <option value="3">Important</option>
                </select>
PAGE;

/* In this section, we are loading the usertypes from the database. We're then going to generate the checkboxes for
 * selecting a usertype for the message.
 */

$userMgr = new UserMgr();

$utypes = $userMgr->getUserTypesFromDB();

foreach ($utypes as $utype) {
    //echo "<p>" . $utype["dtDescription"] . " " . $utype["idTypeUser"] .  "</p>";
    echo "&nbsp;<input type=\"checkbox\" name=\"utypes[]\" value=\"" . $utype["idTypeUser"] . "\"> " . $utype["dtDescription"];
}

echo <<< PAGE
            </form>
        </div>
    </div>

    <h3>Informations générales</h3>

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Reservations</h3>
            </div>
            <div class="panel-body">
                <ul class="list-group">
PAGE;

// Here, we are loading the counts of reservations for every terrain.

$terrainMgr = new TerrainMgr2();

$terrains = json_decode($terrainMgr->getTerrainIds());

foreach ($terrains as $terrain) {
    foreach ($terrain as $val) {
        $rescount = json_decode($terrainMgr->getReservationCountForTerrain($val));

        $dataObj = (object) $rescount[0];

        if ($dataObj->{"qcfCount"} > 0) {
            echo "<li class=\"list-group-item text-success\"><span class=\"badge\">" . $dataObj->{"qcfCount"} . "</span> <strong>Terrain " . $val . "</strong></li>";
        }
        else {
            echo "<li class=\"list-group-item\"><span class=\"badge\">" . $dataObj->{"qcfCount"} . "</span> Terrain " . $val . "</li>";
        }
    }
}

echo <<< PAGE
                </ul>

                <button id="btnPgTerrains" type="button" class="btn btn-default">Gestion</button>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Factures</h3>
            </div>
            <div class="panel-body">
                <ul class="list-group">
PAGE;

// Here, we are loading the counts of the payed and non payed reservations.

$invoiceMgr = new InvoiceMgr();

$payedinvoices = json_decode($invoiceMgr->getPayedInvoicesCount());
$unpayedinvoices = json_decode($invoiceMgr->getUnpayedInvoicesCount());

$dataObj = (object) $payedinvoices[0];

//echo "<p>" . $dataObj->{"qcfCount"} . "</p>";
if ($dataObj->{"qcfCount"} > 0) {
    echo "<li class=\"list-group-item text-success\"><span class=\"badge\">" . $dataObj->{"qcfCount"} . "</span> <strong>Factures payées</strong></li>";
}
else {
    echo "<li class=\"list-group-item text-success\"><span class=\"badge\">" . $dataObj->{"qcfCount"} . "</span> Factures payées</li>";
}

$dataObj = (object) $unpayedinvoices[0];

//echo "<p>" . $dataObj->{"qcfCount"} . "</p>";

if ($dataObj->{"qcfCount"} > 0) {
    echo "<li class=\"list-group-item text-danger\"><span class=\"badge\">" . $dataObj->{"qcfCount"} . "</span> <strong>Factures non payées</strong></li>";
}
else {
    echo "<li class=\"list-group-item text-danger\"><span class=\"badge\">" . $dataObj->{"qcfCount"} . "</span> Factures non payées</li>";
}

echo <<< PAGE
                </ul>

                <button id="btnPgInvoices" type="button" class="btn btn-default">Gestion</button>
            </div>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Utilisateurs</h3>
            </div>
            <div class="panel-body">
                <ul class="list-group">
PAGE;

// Here we are going to load the counts of active and blocked users.

$userMgr = new UserMgr();

$activeusercount = json_decode($userMgr->getUnblockedUserCount());
$blockedusercount = json_decode($userMgr->getBlockedUserCount());

$dataObj = (object) $activeusercount[0];

//echo "<p>" . $dataObj->{"qcfCount"} . "</p>";
if ($dataObj->{"qcfCount"} > 0) {
    echo "<li class=\"list-group-item text-success\"><span class=\"badge\">" . $dataObj->{"qcfCount"} . "</span> <strong>Utilisateurs actives</strong></li>";
}
else {
    echo "<li class=\"list-group-item text-success\"><span class=\"badge\">" . $dataObj->{"qcfCount"} . "</span> Utilisateurs actives</li>";
}

$dataObj = (object) $blockedusercount[0];

//echo "<p>" . $dataObj->{"qcfCount"} . "</p>";

if ($dataObj->{"qcfCount"} > 0) {
    echo "<li class=\"list-group-item text-danger\"><span class=\"badge\">" . $dataObj->{"qcfCount"} . "</span> <strong>Utilisateurs bloqués</strong></li>";
}
else {
    echo "<li class=\"list-group-item text-danger\"><span class=\"badge\">" . $dataObj->{"qcfCount"} . "</span> Utilisateurs bloqués</li>";
}

echo <<< PAGE
                </ul>

                <button id="btnPgUsers" type="button" class="btn btn-default">Gestion</button>
            </div>
        </div>
    </div>

    <script src="js/pages/home.js"></script>
PAGE;
