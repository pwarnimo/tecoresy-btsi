<?php

$terrainMgr = new TerrainMgr();

echo <<< PAGE
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

    <table id="dataTerrain" class="testtable" width="100%">
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
PAGE;

echo <<< PAGE
    <script src="js/pages/terrainsv2.js"></script>
PAGE;
