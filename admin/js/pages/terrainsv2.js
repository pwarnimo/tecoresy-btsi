var oTable;

$(document).ready(function() {
    console.log("PAGE INIT...");

    $(".sidebar-nav li").removeClass("linkact");
    $("#terrains").addClass("linkact");

    $("#dlgAddTerrain").hide();
    $("#dlgChangeState").hide();
    $("#dlgDeleteTerrain").hide();

    buildDataTable();

    console.log("PAGE LOADED!");
});

function buildDataTable() {
    $.ajax({
        type       : "POST",
        url        : "inc/action.inc.php?action=getTerrainsv2",
        statusCode : {
            404: function() {
                console.log("action.inc.php not found!");
            }
        },
        success    : function(data) {
            console.log("OK!");
            console.log("JSON>" + data);

            var htmlHead = "<tr><th colspan=\"2\"></th>";

            var dataHead = JSON.parse(data);

            for (var i = 0; i < dataHead.length; i++) {
                htmlHead += "<th>Terrain " + dataHead[i]["idTerrain"] + "<span class=\"terrainOpts\"><span class=\"glyphicon glyphicon glyphicon-ok-circle\"></span><span class=\"lyphicon glyphicon glyphicon-pencil\"></span><span class=\"glyphicon glyphicon glyphicon-trash\"></span></span></th>";
            }

            htmlHead += "</tr>";

            $("#dataTerrain thead").html(htmlHead);

            var arrDays = new Array("LUN", "MAR", "MER", "JEU", "VEN", "SAM", "DIM");
            var arrHours = new Array("08-09", "09-10", "10-11", "11-12", "12-13", "13-14", "14-15", "15-16", "16-17", "17-18");

            var htmlBody = "";

            for (var i = 0; i <= (10 * arrDays.length) -1; i++) {
                htmlBody += "<tr>";

                if (i % 10 === 0) {
                    console.log("T-OUT> DAY");
                    console.log("CNT-I> " + i);
                    console.log("CALC> " + i % 10);
                    htmlBody += "<td rowspan=\"10\">" + arrDays[i % 9] + "</td><td>" + arrHours[i % 10] + "</td>";
                    for (var j = 0; j <= dataHead.length -1; j++) {
                        htmlBody += "<td class=\"players\">o<span class=\"playerControls\"><span class=\"glyphicon glyphicon glyphicon-ok-circle\"></span><span class=\"lyphicon glyphicon glyphicon-pencil\"></span><span class=\"glyphicon glyphicon glyphicon-trash\"></span></span></td>";
                    }
                }
                else {
                    htmlBody += "<td>" + arrHours[i % 10] + "</td>";
                    for (var j = 0; j <= dataHead.length -1; j++) {
                        htmlBody += "<td class=\"players\">o<span class=\"playerControls\"><span class=\"glyphicon glyphicon glyphicon-ok-circle\"></span><span class=\"lyphicon glyphicon glyphicon-pencil\"></span><span class=\"glyphicon glyphicon glyphicon-trash\"></span></span></td>";
                    }
                }

                htmlBody += "</tr>";
            }

            $("#dataTerrain tbody").html(htmlBody);

            $(".playerControls").hide();

            $(".players").hover(function() {
                $(this).find(".playerControls").show();
                $(this).addClass("playerHighlighted");
            },
            function() {
                $(this).find(".playerControls").hide();
                $(this).removeClass("playerHighlighted");
            });

            $(".terrainOpts").hide();

            $("thead td").hover(function() {
                $(this).find(".terrainOpts").show();
                    alert("test");
            },
            function() {
                $(this).find(".terrainOpts").hide();
                alert("test");
            });
        }
    });
}