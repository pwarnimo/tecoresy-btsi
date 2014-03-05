var oTable;

$(document).ready(function() {
    console.log("PAGE INIT...");

    $(".sidebar-nav li").removeClass("linkact");
    $("#terrains").addClass("linkact");

    $("#dlgAddTerrain").hide();
    $("#dlgChangeState").hide();
    $("#dlgDeleteTerrain").hide();

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
            oTable = $("#dataTerrains").dataTable({
                "oLanguage": {
                    "sLengthMenu": "Afficher _MENU_ terrains par page",
                    "sZeroRecords": "Rien trouvé!",
                    "sInfo": "Page _START_ de _END_ et _TOTAL_ terrain(s) en totale",
                    "sInfoEmpty": "Le tableau est vide",
                    "sInfoFiltered": "(filtrée à partir de _MAX_ terrains au total)",
                    "sSearch": "Chercher: ",
                    "oPaginate": {
                        "sNext": "Suivant",
                        "sPrevious": "Précédent"
                    }
                }
            });

            $(".state").click(function() {
                var currentState = $(this).attr("id")[0];
                var tid = $(this).attr("id").substring(1);

                console.log("CSTATE = " + currentState);

                if (currentState == "A") {
                    console.log("TID" + tid + " is activated...");
                    var newState = "0";
                }
                else {
                    console.log("TID" + tid + " is deactivated...");
                    var newState = "1";
                }

                $("#dlgChangeState").dialog({
                    resizable: false,
                    height:200,
                    width: 350,
                    modal: true,
                    buttons: {
                        Change: function() {
                            console.log("Changing TID" + Tid + " to " + newState);
                            changeTerrainState(tid, newState);

                            $(this).dialog("close");
                        },
                        Annuler: function() {
                            $(this).dialog("close");
                        }
                    },
                    //autoOpen: false,
                    show: {
                        effect: "blind",
                        duration: 200
                    },
                    hide: {
                        effect: "blind",
                        duration: 200
                    }
                });
            });

            $(".delete").click(function() {
                var tid = $(this).attr("id").substring(1);

                console.log("Deleting terrain with ID = " + tid);

                $("#dlgDeleteTerrain").dialog({
                    resizable: false,
                    height:200,
                    width: 350,
                    modal: true,
                    buttons: {
                        Supprimer: function() {
                            deleteTerrain(tid);

                            $(this).dialog("close");
                        },
                        Annuler: function() {
                            $(this).dialog("close");
                        }
                    },
                    //autoOpen: false,
                    show: {
                        effect: "blind",
                        duration: 200
                    },
                    hide: {
                        effect: "blind",
                        duration: 200
                    }
                });
            });
        }
    });
}

function refreshTable() {
    console.log("refreshing...");
    oTable.fnDestroy();
    //oTable.find("tbody").empty();
    populateTerrainDataTable();
}

function changeTerrainState(tid, state) {
    $.ajax({
        type    : "POST",
        url     : "inc/action.inc.php?action=changeTerrainState",
        data    : {
            tid   : tid,
            state : state
        },
        statusCode : {
            404: function() {
                console.log("action.inc.php not found!");
            }
        },
        success    : function(data) {
            console.log("AJAX>" + data);

            refreshTable();
        }
    });
};

function deleteTerrain(tid) {
    $.ajax({
        type       : "POST",
        url        : "inc/action.inc.php?action=deleteTerrains",
        data       : {
            tid : tid
        },
        statusCode : {
            404: function() {
                console.log("action.inc.php not found!");
            }
        },
        success    : function(data) {
            refreshTable();
        }
    });
}