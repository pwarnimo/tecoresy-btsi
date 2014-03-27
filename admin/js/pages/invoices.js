var oTable;

/* --- OVERLAYS ----------------------------------------------------------------------------------------------------- */

// -- Change payment status --

$("#dlgInvoiceStatus").hide();

function DlgInvoiceStatus(iid) {
    this.iid = iid;
};

DlgInvoiceStatus.prototype.showDialog = function() {
    var currId = this.iid;

    $("#dlgInvoiceStatus").dialog({
        resizable: false,
        height: 190,
        width: 400,
        modal: true,
        buttons: {
            Appliquer: function() {
                console.log(">>>>" + currId[0]);

                var iid = currId.substring(1);

                console.log(">>" + iid);

                if (currId[0] == "P") {
                    console.log("NOT PAYED");

                    var state = "No";
                }
                else {
                    console.log("PAYED");

                    var state = "Yes";
                }

                $.ajax({
                    type       : "POST",
                    url        : "inc/actionswitcher.inc.php?action=changePaymentStatus",
                    data       : {
                        iid   : iid,
                        state : state
                    },
                    statusCode : {
                        404: function() {
                            console.log("action.inc.php not found!");
                        }
                    },
                    success    : function(data) {
                        console.log(data);

                        refreshTable();
                    }
                });

                $(this).dialog("close");
            },
            Annuler: function() {
                $(this).dialog("close");
            }
        },
        show: {
            effect: "blind",
            duration: 200
        },
        hide: {
            effect: "blind",
            duration: 200
        }
    });
};

// -- Delete invoice --

$("#dlgInvoiceDelete").hide();

function DlgInvoiceDelete(iid) {
    this.iid = iid;
};

DlgInvoiceDelete.prototype.showDialog = function() {
    var currId = this.iid;

    console.log(">> - " + currId);

    $("#dlgInvoiceDelete").dialog({
        resizable: false,
        height: 190,
        width: 400,
        modal: true,
        buttons: {
            Appliquer: function() {
                console.log(">>>>" + currId[0]);

                var iid = currId.substring(1);

                $.ajax({
                    type       : "POST",
                    url        : "inc/actionswitcher.inc.php?action=deleteSingleInvoice",
                    data       : {
                        iid   : iid
                    },
                    statusCode : {
                        404: function() {
                            console.log("action.inc.php not found!");
                        }
                    },
                    success    : function(data) {
                        console.log(data);

                        refreshTable();
                    }
                });

                $(this).dialog("close");
            },
            Annuler: function() {
                $(this).dialog("close");
            }
        },
        show: {
            effect: "blind",
            duration: 200
        },
        hide: {
            effect: "blind",
            duration: 200
        }
    });
}

// -- Multi delete --

$("#dlgInvoiceDelMulti").hide();

function DlgInvoiceDelMulti(iids) {
    this.iids = iids;
};

DlgInvoiceDelMulti.prototype.showDialog = function() {
    var iids = this.iids;
    var iidsJson = JSON.stringify(iids);

    console.log("IIDJSON = " + iidsJson);

    $("#dlgInvoiceDelMulti").dialog({
        resizable: false,
        height: 190,
        width: 400,
        modal: true,
        buttons: {
            Appliquer: function() {
                $.ajax({
                    type       : "POST",
                    url        : "inc/actionswitcher.inc.php?action=deleteInvoices",
                    data       : {
                        iids   : iidsJson
                    },
                    statusCode : {
                        404: function() {
                            console.log("action.inc.php not found!");
                        }
                    },
                    success    : function(data) {
                        console.log(data);

                        refreshTable();
                    }
                });

                $(this).dialog("close");
            },
            Annuler: function() {
                $(this).dialog("close");
            }
        },
        show: {
            effect: "blind",
            duration: 200
        },
        hide: {
            effect: "blind",
            duration: 200
        }
    });
};

/* ------------------------------------------------------------------------------------------------------------------ */

$(document).ready(function() {
    console.log("PAGE INIT...");

    $(".sidebar-nav li").removeClass("linkact");
    $("#invoices").addClass("linkact");

    $("#dlgChangePaymentStatus").hide();
    $("#factureOverview").hide();

    populateInvoiceDataTable();

    $("#btnRefresh").click(function() {
        refreshTable();
    });

    $("#btnReturn").click(function() {
        $("#factureOverview").fadeOut("fast", function() {
            $("#tblOverview").fadeIn("fast");
        });
    });

    var helpHtml = "<ul><li><span class=\"glyphicon glyphicon-refresh\"></span> Actualiser les données sur les factures.</li>" +
        "<li><span class=\"glyphicon glyphicon glyphicon-plus-sign\"></span> Ajouter une nouvelle facture.</li>" +
        "<li><span class=\"glyphicon glyphicon glyphicon-pencil\"></span> Modifier une facture selectioné.</li>" +
        "<li><span class=\"glyphicon glyphicon glyphicon-trash\"></span> Supprimer une ou plusieures factures. Fonctionne aussi avec \"glisser-déposer\"</li>" +
        "<li><span class=\"glyphicon glyphicon-euro\"></span> Marquer une facture comme payé / non-payé.</li></ul>" +
        "<p>Pour plusieurs informations ou questions, veuillez envoyer un E-Mail á <a href=\"mailto:pwarnimo@gmail.com\">pwarnimo@gmail.com</a>.</p>";

    $("#help-wrapper").html($("#help-wrapper").html() + helpHtml);

    $("#btnDelete").click(function() {
        console.log("MULTIDELETE");

        var cbs = new Array();

        $("#dataInvoices tbody input:checkbox:checked").each(function() {
            cbs.push($(this).attr("id"));
            console.log("checked");
        });

        console.log(cbs);

        var dlg0 = new DlgInvoiceDelMulti(cbs);

        dlg0.showDialog();
    });

    console.log("PAGE LOADED!");
});

function refreshTable() {
    console.log("refreshing...");
    oTable.fnDestroy();
    oTable.find("tbody").empty();
    populateInvoiceDataTable();
}

function populateInvoiceDataTable() {
    $.ajax({
        type : "POST",
        url : "inc/actionswitcher.inc.php?action=getInvoices",
        statusCode : {
            404: function() {
                console.log("action.inc.php not found!");
            }
        },
        success    : function(data) {
            console.log(JSON.parse(data));

            var result = JSON.parse(data);

            var thtml = "";

            for (var i = 0; i < result.length; i++) {
                if (result[i]["dtPayed"] == "Yes") {
                    var contPayed = "<span style=\"color: #0a0;\" class=\"glyphicon glyphicon glyphicon-euro payed\"></span>";
                    var infPayed = "<span style=\"color: #0a0;\">Oui</span>";
                    var iid = "P" + result[i]["idFacture"];
                }
                else {
                    var contPayed = "<span style=\"color: #a00;\" class=\"glyphicon glyphicon glyphicon-euro payed\"></span>";
                    var infPayed = "<span style=\"color: #a00;\">Non!</span>";
                    var iid = "N" + result[i]["idFacture"];
                }

                var contGeneral = "<span class=\"glyphicon glyphicon-zoom-in pdf\"></span><span class=\"glyphicon glyphicon glyphicon glyphicon-trash delete\"></span>";

                thtml += "<tr id=\"" + iid + "\"><td><input type=\"checkbox\" id=\"" + result[i]["idFacture"] + "\"></td>" +
                    "<td>" + result[i]["idFacture"] + "</td>" +
                    "<td>" + result[i]["dtLastname"] + " " + result[i]["dtFirstname"] + "</td>" +
                    "<td>" + result[i]["dtCreateTS"] + "</td>" +
                    "<td>" + result[i]["fiDate"] + " " + result[i]["fiHour"] + ":00" + "</td>" +
                    "<td>" + result[i]["fiTerrain"] + "</td>" +
                    "<td>" + contPayed + "</td>" +
                    "<td>" + contGeneral + "</td></tr>";
            }

            /*var thtml = "";
            var curRow = null;

            for (var i = 0; i < result.length; i++) {
                if (result[i]["dtPayed"] == true) {
                    var contPayed = "<span style=\"color: #0a0;\" class=\"glyphicon glyphicon glyphicon-euro payed\"></span>";
                    var infPayed = "<span style=\"color: #0a0;\">Oui</span>";
                    var iid = "PI" + result[i]["idFacture"];
                }
                else {
                    var contPayed = "<span style=\"color: #a00;\" class=\"glyphicon glyphicon glyphicon-euro payed\"></span>";
                    var infPayed = "<span style=\"color: #a00;\">Non!</span>";
                    var iid = "NI" + result[i]["idFacture"];
                }

                var contGeneral = "<span class=\"glyphicon glyphicon glyphicon-pencil edit\"></span><span class=\"glyphicon glyphicon glyphicon glyphicon-trash delete\"></span>";

                thtml += "<tr id=\"" + iid + "\"><td><input type=\"checkbox\" id=\"" + result[i]["idFacture"] + "\"></td>" +
                    "<td>" + result[i]["idFacture"] + "</td>" +
                    "<td>" + result[i]["dtCreateTS"] + "</td>" +
                    "<td>" + result[i]["fiDateHeure"] + "</td>" +
                    "<td>" + result[i]["fiTerrain"] + "</td>" +
                    "<td>" + result[i]["dtPlayer1Firstname"] + "&nbsp;" + result[i]["dtPlayer1Lastname"] + "</td>" +
                    "<td>" + result[i]["dtPlayer2Firstname"] + "&nbsp;" + result[i]["dtPlayer2Lastname"] + "</td>" +
                    "<td>" + infPayed + "</td>" +
                    "<td>" + contPayed + "&nbsp;" + contGeneral + "</td></tr>";
            }*/

            $("#dataInvoices tbody").html(thtml);

            oTable = $("#dataInvoices").dataTable({
                "bAutoWidth": false,
                "aoColumns": [
                    {
                        "sTitle": "<input type=\"checkbox\" id=\"checkAll\">"
                    },
                    {
                        "sTitle": "ID"
                    },
                    {
                        "sTitle": "Destinaire"
                    },
                    {
                        "sTitle": "Date"
                    },
                    {
                        "sTitle": "Date de reservation"
                    },
                    {
                        "sTitle": "Terrain"
                    },
                    {
                        "sTitle": "Payé"
                    },
                    {
                        "sTitle": ""
                    }

                ],
                "aoColumnDefs": [
                    {
                        bSortable: false,
                        aTargets: [ 0, 1, 4, 7 ]
                    }
                ],
                "oLanguage": {
                    "sLengthMenu": "Afficher _MENU_ factures par page",
                    "sZeroRecords": "Rien trouvé!",
                    "sInfo": "Factures _START_ á _END_ de _TOTAL_ facture(s) en totale",
                    "sInfoEmpty": "Le tableau est vide!",
                    "sInfoFiltered": "(filtrée à partir de _MAX_ factures au total)",
                    "sSearch": "Chercher: ",
                    "oPaginate": {
                        "sNext": "Suivant",
                        "sPrevious": "Précédent"
                    }
                }
            });

            $(".payed").click(function() {
                var dlg0 = new DlgInvoiceStatus($(this).parent().parent().attr("id"));

                dlg0.showDialog();
            });

            $(".pdf").click(function() {
                var currId = $(this).parent().parent().attr("id");
                var iid = currId.substring(1);

                console.log(iid);

                window.location = "inc/pdfInvoice.inc.php?iid=" + iid;
            });

            $(".delete").click(function() {
                dlg0 = new DlgInvoiceDelete($(this).parent().parent().attr("id"));

                dlg0.showDialog();
            });

            /*$("tbody tr").click(function() {
                console.log("Loading detail view of invoice IID " + $(this).attr("id").substring(2));

                showInvoice($(this).attr("id").substring(2));
            });*/
        }
    });
}

function setPaymentStatus(iid, state) {
    $.ajax({
        type       : "POST",
        url        : "inc/actionswitcher.inc.php?action=changePaymentStatus",
        data       : {
            iid   : iid,
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
}

function showInvoice(iid) {
    $("#tblOverview").fadeOut("fast", function() {
        $("#factureOverview").fadeIn("fast");
    });

    $.ajax({
        type       : "POST",
        url        : "inc/actionswitcher.inc.php?action=getSingleInvoice",
        data       : {
            iid   : iid
        },
        statusCode : {
            404: function() {
                console.log("action.inc.php not found!");
            }
        },
        success    : function(data) {
            console.log("AJAX>" + data);

            result = JSON.parse(data);

            $("#fNoInvoice").html("Facture N°" + result[0]["idFacture"]);
            $("#fTimestamp").html("Date: " + result[0]["dtCreateTS"]);
        }
    });
}