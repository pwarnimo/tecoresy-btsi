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
        <h1>Terrains <small>TECORESY Admin // <a href="main.php?page=terrainsv2">View Version 2</a></small></h1>
    </div>

    <table id="dataTerrains" width="100%">
        <thead>
            <tr>
                <th><input type="checkbox" id="checkAll"></th>
                <th>Terrain N°</th>
                <th>Liste de joueurs (1 semaine)</th>
                <th>Disponible</th>
                <th>ACT</th>
                <th>EDT</th>
                <th>DEL</th>
            </tr>
        </thead>

        <tbody>
        </tbody>
    </table>
PAGE;

/*    <table class="table striped">
        <thead>
            <tr>
                <th width="16px"><input type="checkbox"></th>
                <th width="160px">Terrain N°</th>
                <th>Joueurs (1 Semaine)</th>
                <th>Disponible</th>
                <th colspan="3"></th>
            </tr>
        </thead>

        <tbody>
PAGE;

$terrains = $terrainMgr->getTerrainsFromDB();

foreach ($terrains as $terrain) {
    if ($terrain["dtState"] == true) {
        $state = "<p style=\"color: #0a0;\">Disponible</p>";
        echo "<tr>";
    }
    else {
        $state = "<p  style=\"color: #a00;\">Non disponible</p>";
        echo "<tr>";
    }

    echo "<td><input type=\"checkbox\" value=\"" . $terrain["idTerrain"] . "\"></td>
        <td><img width=\"150px\" alt=\"tennis\" src=\"images/tennis-court.png\"><p>Terrain N°" . $terrain["idTerrain"] . "</p></td>
        <td>Pas de joueurs.</td>
        <td>" . $state . "</td>
        <td width=\"32\"><span class=\"glyphicon glyphicon-ok-circle\" style=\"color: #0a0;\"></span></td>
        <td width=\"32\"><span class=\"glyphicon glyphicon-pencil\"></span></td>
        <td width=\"32\"><span class=\"glyphicon glyphicon-trash\"></span></td></tr>";
}

echo <<< PAGE
        </tbody>
    </table>*/
echo <<< PAGE
    <script src="js/pages/terrains.js"></script>
PAGE;
