<?php

$terrainMgr = new TerrainMgr();

/* --- OVERLAYS ----------------------------------------------------------------------------------------------------- */

// -- New reservation --

echo <<< DLGNEW
    <div id="dlgAddReservation" title="Nouveau reservation...">
        <form class="form-horizontal" role="form" id="frmAddReservation">
            <div class="form-group">
                <label for="edtTimestamp" class="col-sm-3 control-label">Date</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="edtTimestamp">
                </div>
            </div>

            <div class="form-group">
                <label for="lsbPlayer1" class="col-sm-3 control-label">Joueur 1</label>
                <div class="col-sm-9">
                    <select id="lsbPlayer1" class="form-control">
DLGNEW;

$userMgr = new UserMgr();

$users = $userMgr->getUserList();

foreach ($users as $user) {
    echo "<option value=\"" . $user["idUser"] . "\">" . $user["dtFirstname"] . " " . $user["dtLastname"] . "</option>";
}

echo <<< DLGNEW
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="lsbPlayer2" class="col-sm-3 control-label">Joueur 2</label>
                <div class="col-sm-9">
                    <select id="lsbPlayer2" class="form-control">
DLGNEW;

foreach ($users as $user) {
    echo "<option value=\"" . $user["idUser"] . "\">" . $user["dtFirstname"] . " " . $user["dtLastname"] . "</option>";
}

echo <<< DLGNEW
                    </select>
                </div>
            </div>
        </form>
    </div>
DLGNEW;

// -- Edit reservation --

echo <<< DLGREDEDIT
    <div id="dlgEditReservation" title="Modifier une reservation...">
        <form class="form-horizontal" role="form" id="frmEditReservation">
            <div class="form-group">
                <label for="edtTimestamp" class="col-sm-3 control-label">Date</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="edtTimestamp">
                </div>
            </div>

            <div class="form-group">
                <label for="lbPlayer1" class="col-sm-3 control-label">Joueur 1</label>
                <div class="col-sm-9">
                    <select id="lbPlayer1" class="form-control">
                        <option>Pol Warnimont</option>
                        <option>Brant Bjork</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="lbPlayer2" class="col-sm-3 control-label">Joueur 2</label>
                <div class="col-sm-9">
                    <select id="lbPlayer2" class="form-control">
                        <option>Pol Warnimont</option>
                        <option>Brant Bjork</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
DLGREDEDIT;

// -- De/Activate reservation --

echo <<< DLGRESSTATUS
    <div id="dlgResStatus" title="Bloquer">
        <p>Voulez vous vraiment blocker ou debloquer cet reservation?</p>
    </div>
DLGRESSTATUS;

// -- Remove reservation --

// -- De/Block terrain --

// -- New terrain --

// -- Delete terrain --

/* ------------------------------------------------------------------------------------------------------------------ */

echo <<< PAGE
    <div class="page-header">
        <h1>Terrains <small>TECORESY Admin</a></small></h1>
    </div>

    <ul id="terrainSwitcher" class="nav nav-tabs">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                 <span class="glyphicon glyphicon-cog"></span> <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a href="#"><span class="glyphicon glyphicon-lock"></span> Verrouiller</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-pencil"></span> Modifier</a></li>
                <li class="divider"></li>
                <li><a href="#"><span class="glyphicon glyphicon-plus-sign"></span> Nouveau Terrain</a></li>
            </ul>
        </li>
        <li id="T1" class="active"><a class="tabactive" href="#">1</a></li>
        <li id="T2"><a href="#">2</a></li>
        <li id="T3"><a href="#">3</a></li>
        <li id="T4"><a href="#">4</a></li>
        <li id="T5"><a href="#">5</a></li>
        <li id="T6"><a href="#">6</a></li>
        <li id="T7"><a href="#">7</a></li>
    </ul>


    <table id="dataTerrains" class="testtable" width="100%">
        <thead>
        </thead>

        <tbody>
        </tbody>
    </table>
PAGE;

/*$mgrTerrains2 = new TerrainMgr2();

$testRes = $mgrTerrains2->getPossibleReservationsForTerrain(1);*/

//print_r($testRes);

/*foreach ($testRes as $im1) {
    echo "<p>" . $im1["fiDate"] . " -- " . $im1["dtWeekDay"] . " -- " . $im1["idHour"] . "</p>";
}*/

echo <<< PAGE
    <script src="js/pages/terrainsv3.js"></script>
PAGE;
