<?php

$terrainMgr = new TerrainMgr();

echo <<< PAGE
    <div class="page-header">
        <h1>Terrains <small>TECORESY Admin</small></h1>
    </div>

    <table class="table striped">
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
    </table>

    <script>
        $(document).ready(function() {
            $(".sidebar-nav li").removeClass("linkact");
            $("#terrains").addClass("linkact");
        });
    </script>
PAGE;
