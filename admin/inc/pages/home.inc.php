<?php
echo <<< PAGE
    <div class="page-header">
PAGE;

echo "<h1>TECORESY Admin <small>Bienvenue " . $_SESSION["lname"] . " " . $_SESSION["fname"] . "!</small></h1>";

echo <<< PAGE
    </div>

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

    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Reservations</h3>
            </div>
            <div class="panel-body">
                <ul class="list-group">
PAGE;

$terrainMgr = new TerrainMgr2();

$terrains = json_decode($terrainMgr->getTerrainIds());

foreach ($terrains as $terrain) {
    /*var_dump($terrain);
    //echo "<p>Terrain " . $terrain["idTerrain"] . "</p>";*/
    foreach ($terrain as $val) {
        //$rescount = $terrainMgr->getReservationCounts();
        $rescount = json_decode($terrainMgr->getReservationCountForTerrain($val));

        $dataObj = (object) $rescount[0];

        //echo "<p>Terrain " . $val . ": " . $dataObj->{"qcfCount"} . " Reservations</p>";
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
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Factures</h3>
            </div>
            <div class="panel-body">
                <ul class="list-group">
PAGE;

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
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Utilisateurs</h3>
            </div>
            <div class="panel-body">
                <p>NONE</p>
            </div>
        </div>
    </div>

    <script src="js/pages/home.js"></script>
PAGE;
