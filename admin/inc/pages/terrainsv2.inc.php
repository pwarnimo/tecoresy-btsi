<?php

/**
 * TECORESY Admin panel 1.0
 *
 * File : terrainsv2.inc.php
 * Description :
 *   This file contains the page for displaying the terrains and reservations for every terrain. Here, we can create new
 *   reservations or edit and delete existing reservations. Also, we can block specific time slots or block a whole
 *   terrain.
 */

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

/* Here, we're going to load the user details for every user in the database. We need this to select a player for a new
 * reservation.
 */
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

/* Here, we're going to load the user details for every user in the database. We need this to select an oponent for a
 * new reservation.
 */

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

// -- De/Activate reservation --

echo <<< DLGRESSTATUS
    <div id="dlgResStatus" title="Bloquer">
        <p>Voulez vous vraiment blocker ou debloquer cet reservation?</p>
    </div>
DLGRESSTATUS;

// -- Remove reservation --

echo <<< DLGRESDELETE
    <div id="dlgResDelete" title="Bloquer">
        <p>Voulez vous vraiment supprimer cet reservation?</p>
    </div>
DLGRESDELETE;

// -- De/Block terrain --

echo <<< DLGTERRAINSTATUS
    <div id="dlgTerrainStatus" title="Bloquer">
        <p>Voulez vous vraiment blocker ou debloquer ce terrain?</p>
    </div>
DLGTERRAINSTATUS;

// -- New terrain --

// -- Delete terrain --

/* ------------------------------------------------------------------------------------------------------------------ */

echo <<< PAGE
    <div class="page-header">
        <h1>Terrains et r&eacute;servations <small>TECORESY Admin</a></small></h1>
    </div>

    <ul id="terrainSwitcher" class="nav nav-tabs">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                 <span class="glyphicon glyphicon-cog"></span> <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
                <li><a id="blockterrain" href="#"></a></li>
                <!--<li><a href="#"><span class="glyphicon glyphicon-pencil"></span> Modifier</a></li>
                <li class="divider"></li>
                <li><a href="#"><span class="glyphicon glyphicon-plus-sign"></span> Nouveau Terrain</a></li>-->
            </ul>
        </li>
        <li id="T1" class="active terrains"><a class="tabactive" href="#">1</a></li>
        <li id="T2" class="terrains"><a href="#">2</a></li>
        <li id="T3" class="terrains"><a href="#">3</a></li>
        <li id="T4" class="terrains"><a href="#">4</a></li>
        <li id="T5" class="terrains"><a href="#">5</a></li>
        <li id="T6" class="terrains"><a href="#">6</a></li>
        <li id="T7" class="terrains"><a href="#">7</a></li>
    </ul>


    <table id="dataTerrains" class="testtable" width="100%">
        <thead>
        </thead>

        <tbody>
        </tbody>
    </table>

    <button id="btnBackwards" type="button" class="btn btn-default">Précédent</button>&nbsp;<button id="btnForward" type="button" class="btn btn-default">Avancer</button>

    <script src="js/pages/terrainsv3.js"></script>
PAGE;
