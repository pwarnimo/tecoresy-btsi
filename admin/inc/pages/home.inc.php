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
                <p>Pas de reservations ajourd hui.</p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Factures</h3>
            </div>
            <div class="panel-body">
                <p>Pas de factures ajourd hui.</p>
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
