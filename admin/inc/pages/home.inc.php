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
            <p id="message-text">Pas de messages.</p>
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

    <p></p>

    <script src="js/pages/home.js"></script>
PAGE;
