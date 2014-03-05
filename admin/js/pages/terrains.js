var oTable;

$(document).ready(function() {
    console.log("PAGE INIT...");

    $(".sidebar-nav li").removeClass("linkact");
    $("#terrains").addClass("linkact");

    $("#dlgAddTerrain").hide();

    $("#dlgAddTerrain").dialog({
        resizable: false,
        height: 380,
        width: 300,
        modal: true,
        buttons: {
            Ajouter: function() {
                if ($("#ckbState").prop("checked")) {
                    state = true;
                }
                else {
                    state = false;
                }

                var userJson = "{\"terrainno\":\"" + $("#edtTerrainNo").val() + "\"," +
                    "\"description\":\"" + $("#edtDescription").val()  + "\"," +
                    "\"state\":\"" + state + "\"}";

                console.log("JSONREQ>" + userJson);

                $.ajax({
                    type       : "POST",
                    url        : "inc/action.inc.php?action=addTerrain",
                    data       : {
                        json : userJson
                    },
                    statusCode : {
                        404: function() {
                            console.log("action.inc.php not found!");
                        }
                    },
                    success    : function(data) {
                        console.log("OK!");
                        console.log("Returned data: " + data);
                        refreshTable();
                    }
                });

                $(this).dialog("close");
            },
            Annuler: function() {
                $(this).dialog("close");
            }
        },
        autoOpen: false,
        show: {
            effect: "blind",
            duration: 200
        },
        hide: {
            effect: "blind",
            duration: 200
        }
    });

    $("#btnAdd").click(function() {
        $("#dlgAddTerrain").dialog("open");
    });

    $("#btnRefresh").click(function() {
        refreshTable();
    });

    populateTerrainDataTable();

    console.log("INIT COMPLETE!");
});

function populateTerrainDataTable() {
    $.ajax({
        type : "POST",
        url : "inc/action.inc.php?action=getTerrains",
        statusCode : {
            404: function() {
                console.log("action.inc.php not found!");
            }
        },
        success    : function(data) {
            console.log("OK!");
            //console.log("Returned data: " + data);

            console.log(data);

            var result = JSON.parse(data);

            console.log(result.length);
            console.log(result);

            var thtml = "";
            var curRow = null;

            for (var i = 0; i < result.length; i++) {
                thtml += "<tr><td>" + result[i]["checkbox"] + "</td>" +
                    "<td>" + result[i]["idTerrain"] + "</td>" +
                    "<td>" + result[i]["lstPlayers"] + "</td>" +
                    "<td>" + result[i]["dtState"] + "</td>" +
                    "<td>" + result[i]["funcstate"] + "</td>" +
                    "<td>" + result[i]["funcedit"] + "</td>" +
                    "<td>" + result[i]["funcdel"] + "</td></tr>"
                //curRow = result[i];
                //console.log(i);
                //console.log(result[i]["checkbox"]);
            }

            $("#dataTerrains tbody").html(thtml);

            //return data;
            oTable = $("#dataTerrains").dataTable({});
        }
    });
}

function refreshTable() {
    console.log("refreshing...");
    oTable.fnDestroy();
    //oTable.find("tbody").empty();
    populateTerrainDataTable();
}