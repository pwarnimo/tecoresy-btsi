<?php

$terrainMgr = new TerrainMgr();

/*echo <<< PAGE
    <div id="dlgChangeState" title="Activer/Deactiver le terrain?">
        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous vraiment changer le statut du terrain?</p>
    </div>

    <div id="dlgDeleteTerrain" title="Supprimer le terrain?">
        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous vraiment supprimer cet terrain?</p>
    </div>

    <div id="dlgAddTerrain" title="Nouveau terrain...">
        <form role="form" id="frmAddTerrain">
            <div class="form-group">
                <label for="edtTerrainNo">Numèro du terrain</label>
                <input type="text" class="form-control" id="edtTerrainNo" placeholder="Numéro du terrain">
            </div>
            <div class="form-group">
                <label for="edtDescription">Description</label>
                <textarea class="form-control" rows="3" id="edtDescription" placeholder="Description du terrain"></textarea>
            </div>
            <div class="checkbox">
                <label>
                    <input id="ckbState" type="checkbox"> Disponible
                </label>
            </div>
        </form>
    </div>

    <div class="page-header">
        <h1>Terrainsv2 <small>TECORESY Admin // <a href="main.php?page=terrains">View Version 1</a></small></h1>
    </div>

    <p>Dynamic version</p>

    <table id="dataTerrain" class="testtable" width="100%">
        <thead>
        </thead>

        <tbody>
        </tbody>
    </table>

    <p>Static version</p>

    <table id="dataTerrain2" class="testtable" width="100%">
        <thead>
            <tr>
                <th colspan="2"></th>
                <th>TERRAIN 1 <span class="controls"><span class="glyphicon glyphicon glyphicon-ok-circle"></span><span class="glyphicon glyphicon glyphicon-pencil"></span><span class="glyphicon glyphicon glyphicon-trash"></span></span></th>
                <th>TERRAIN 2 <span class="controls"><span class="glyphicon glyphicon glyphicon-ok-circle"></span><span class="glyphicon glyphicon glyphicon-pencil"></span><span class="glyphicon glyphicon glyphicon-trash"></span></span></th>
                <th>TERRAIN 3 <span class="controls"><span class="glyphicon glyphicon glyphicon-ok-circle"></span><span class="glyphicon glyphicon glyphicon-pencil"></span><span class="glyphicon glyphicon glyphicon-trash"></span></span></th>
                <th>TERRAIN 4 <span class="controls"><span class="glyphicon glyphicon glyphicon-ok-circle"></span><span class="glyphicon glyphicon glyphicon-pencil"></span><span class="glyphicon glyphicon glyphicon-trash"></span></span></th>
                <th>TERRAIN 5 <span class="controls"><span class="glyphicon glyphicon glyphicon-ok-circle"></span><span class="glyphicon glyphicon glyphicon-pencil"></span><span class="glyphicon glyphicon glyphicon-trash"></span></span></th>
                <th>TERRAIN 6 <span class="controls"><span class="glyphicon glyphicon glyphicon-ok-circle"></span><span class="glyphicon glyphicon glyphicon-pencil"></span><span class="glyphicon glyphicon glyphicon-trash"></span></span></th>
                <th>TERRAIN 7 <span class="controls"><span class="glyphicon glyphicon glyphicon-ok-circle"></span><span class="glyphicon glyphicon glyphicon-pencil"></span><span class="glyphicon glyphicon glyphicon-trash"></span></span></th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>LUN</td>
                <td>08-09<br>09-10<br>10-11<br>11-12<br>12-13<br>13-14<br>14-15<br>15-16<br>16-17<br>17-18</td>
                <td>&Oslash;<br>Pol - Daniel<br>&Oslash;<br>&Oslash;<br>Pol - Josh<br>John - Brant<br>&Oslash;<br>&Oslash;<br>Daniel - Josh<br>&Oslash;</td>
                <td>Josh - Brant<br>&Oslash;<br>&Oslash;<br>Chris - Pol<br>Daniel - Pol<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;</td>
                <td>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>Chris - John<br>John - Homme<br>&Oslash;<br>Brant - John<br>&Oslash;</td>
                <td>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;</td>
                <td>&Oslash;<br>Pol - Daniel<br>&Oslash;<br>&Oslash;<br>Pol - Josh<br>John - Brant<br>&Oslash;<br>&Oslash;<br>Daniel - Josh<br>&Oslash;</td>
                <td>Josh - Brant<br>&Oslash;<br>&Oslash;<br>Chris - Pol<br>Daniel - Pol<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;</td>
                <td>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>Chris - John<br>John - Homme<br>&Oslash;<br>Brant - John<br>&Oslash;</td>
            </tr>
            <tr>
                <td>MAR</td>
                <td>08-09<br>09-10<br>10-11<br>11-12<br>12-13<br>13-14<br>14-15<br>15-16<br>16-17<br>17-18</td>
                <td>&Oslash;<br>Pol - Daniel<br>&Oslash;<br>&Oslash;<br>Pol - Josh<br>John - Brant<br>&Oslash;<br>&Oslash;<br>Daniel - Josh<br>&Oslash;</td>
                <td>Josh - Brant<br>&Oslash;<br>&Oslash;<br>Chris - Pol<br>Daniel - Pol<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;</td>
                <td>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>Chris - John<br>John - Homme<br>&Oslash;<br>Brant - John<br>&Oslash;</td>
                <td>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;</td>
                <td>&Oslash;<br>Pol - Daniel<br>&Oslash;<br>&Oslash;<br>Pol - Josh<br>John - Brant<br>&Oslash;<br>&Oslash;<br>Daniel - Josh<br>&Oslash;</td>
                <td>Josh - Brant<br>&Oslash;<br>&Oslash;<br>Chris - Pol<br>Daniel - Pol<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;</td>
                <td>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>Chris - John<br>John - Homme<br>&Oslash;<br>Brant - John<br>&Oslash;</td>
            </tr>
            <tr>
                <td>MER</td>
                <td>08-09<br>09-10<br>10-11<br>11-12<br>12-13<br>13-14<br>14-15<br>15-16<br>16-17<br>17-18</td>
                <td>&Oslash;<br>Pol - Daniel<br>&Oslash;<br>&Oslash;<br>Pol - Josh<br>John - Brant<br>&Oslash;<br>&Oslash;<br>Daniel - Josh<br>&Oslash;</td>
                <td>Josh - Brant<br>&Oslash;<br>&Oslash;<br>Chris - Pol<br>Daniel - Pol<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;</td>
                <td>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>Chris - John<br>John - Homme<br>&Oslash;<br>Brant - John<br>&Oslash;</td>
                <td>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;</td>
                <td>&Oslash;<br>Pol - Daniel<br>&Oslash;<br>&Oslash;<br>Pol - Josh<br>John - Brant<br>&Oslash;<br>&Oslash;<br>Daniel - Josh<br>&Oslash;</td>
                <td>Josh - Brant<br>&Oslash;<br>&Oslash;<br>Chris - Pol<br>Daniel - Pol<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;</td>
                <td>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>Chris - John<br>John - Homme<br>&Oslash;<br>Brant - John<br>&Oslash;</td>
            </tr>
            <tr>
                <td>JEU</td>
                <td>08-09<br>09-10<br>10-11<br>11-12<br>12-13<br>13-14<br>14-15<br>15-16<br>16-17<br>17-18</td>
                <td>&Oslash;<br>Pol - Daniel<br>&Oslash;<br>&Oslash;<br>Pol - Josh<br>John - Brant<br>&Oslash;<br>&Oslash;<br>Daniel - Josh<br>&Oslash;</td>
                <td>Josh - Brant<br>&Oslash;<br>&Oslash;<br>Chris - Pol<br>Daniel - Pol<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;</td>
                <td>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>Chris - John<br>John - Homme<br>&Oslash;<br>Brant - John<br>&Oslash;</td>
                <td>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;</td>
                <td>&Oslash;<br>Pol - Daniel<br>&Oslash;<br>&Oslash;<br>Pol - Josh<br>John - Brant<br>&Oslash;<br>&Oslash;<br>Daniel - Josh<br>&Oslash;</td>
                <td>Josh - Brant<br>&Oslash;<br>&Oslash;<br>Chris - Pol<br>Daniel - Pol<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;</td>
                <td>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>Chris - John<br>John - Homme<br>&Oslash;<br>Brant - John<br>&Oslash;</td>
            </tr>
            <tr>
                <td>VEN</td>
                <td>08-09<br>09-10<br>10-11<br>11-12<br>12-13<br>13-14<br>14-15<br>15-16<br>16-17<br>17-18</td>
                <td>&Oslash;<br>Pol - Daniel<br>&Oslash;<br>&Oslash;<br>Pol - Josh<br>John - Brant<br>&Oslash;<br>&Oslash;<br>Daniel - Josh<br>&Oslash;</td>
                <td>Josh - Brant<br>&Oslash;<br>&Oslash;<br>Chris - Pol<br>Daniel - Pol<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;</td>
                <td>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>Chris - John<br>John - Homme<br>&Oslash;<br>Brant - John<br>&Oslash;</td>
                <td>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;</td>
                <td>&Oslash;<br>Pol - Daniel<br>&Oslash;<br>&Oslash;<br>Pol - Josh<br>John - Brant<br>&Oslash;<br>&Oslash;<br>Daniel - Josh<br>&Oslash;</td>
                <td>Josh - Brant<br>&Oslash;<br>&Oslash;<br>Chris - Pol<br>Daniel - Pol<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;</td>
                <td>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>Chris - John<br>John - Homme<br>&Oslash;<br>Brant - John<br>&Oslash;</td>
            </tr>
            <tr>
                <td>SAM</td>
                <td>08-09<br>09-10<br>10-11<br>11-12<br>12-13<br>13-14<br>14-15<br>15-16<br>16-17<br>17-18</td>
                <td>&Oslash;<br>Pol - Daniel<br>&Oslash;<br>&Oslash;<br>Pol - Josh<br>John - Brant<br>&Oslash;<br>&Oslash;<br>Daniel - Josh<br>&Oslash;</td>
                <td>Josh - Brant<br>&Oslash;<br>&Oslash;<br>Chris - Pol<br>Daniel - Pol<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;</td>
                <td>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>Chris - John<br>John - Homme<br>&Oslash;<br>Brant - John<br>&Oslash;</td>
                <td>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;</td>
                <td>&Oslash;<br>Pol - Daniel<br>&Oslash;<br>&Oslash;<br>Pol - Josh<br>John - Brant<br>&Oslash;<br>&Oslash;<br>Daniel - Josh<br>&Oslash;</td>
                <td>Josh - Brant<br>&Oslash;<br>&Oslash;<br>Chris - Pol<br>Daniel - Pol<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;</td>
                <td>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>Chris - John<br>John - Homme<br>&Oslash;<br>Brant - John<br>&Oslash;</td>
            </tr>
            <tr>
                <td>DIM</td>
                <td>08-09<br>09-10<br>10-11<br>11-12<br>12-13<br>13-14<br>14-15<br>15-16<br>16-17<br>17-18</td>
                <td>&Oslash;<br>Pol - Daniel<br>&Oslash;<br>&Oslash;<br>Pol - Josh<br>John - Brant<br>&Oslash;<br>&Oslash;<br>Daniel - Josh<br>&Oslash;</td>
                <td>Josh - Brant<br>&Oslash;<br>&Oslash;<br>Chris - Pol<br>Daniel - Pol<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;</td>
                <td>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>Chris - John<br>John - Homme<br>&Oslash;<br>Brant - John<br>&Oslash;</td>
                <td>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;</td>
                <td>&Oslash;<br>Pol - Daniel<br>&Oslash;<br>&Oslash;<br>Pol - Josh<br>John - Brant<br>&Oslash;<br>&Oslash;<br>Daniel - Josh<br>&Oslash;</td>
                <td>Josh - Brant<br>&Oslash;<br>&Oslash;<br>Chris - Pol<br>Daniel - Pol<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;</td>
                <td>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>&Oslash;<br>Chris - John<br>John - Homme<br>&Oslash;<br>Brant - John<br>&Oslash;</td>
            </tr>
        </tbody>
    </table>
PAGE;*/

echo <<< PAGE
    <div id="cntnr">
        <ul id="items">
            <li><a href="#">Action</a></li>
            <li><a href="#">Action</a></li>
            <li><a href="#">Action</a></li>
        </ul>
    </div>

    <div class="page-header">
        <h1>Terrainsv2 <small>TECORESY Admin // <a href="main.php?page=terrains">View Version 1</a></small></h1>
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
