var oTable;

    $(document).ready(function() {
    console.log("PAGE INIT...");

    $(".sidebar-nav li").removeClass("linkact");
    $("#invoices").addClass("linkact");

    $.ajax({
        type : "POST",
        url : "inc/action.inc.php?action=getInvoices",
        statusCode : {
            404: function() {
                console.log("action.inc.php not found!");
            }
        },
        success    : function(data) {
            console.log(JSON.parse(data));

            var result = JSON.parse(data);

            var thtml = "";
            var curRow = null;

            for (var i = 0; i < result.length; i++) {
                if (result[i]["dtPayed"] == true) {
                    var contPayed = "<span style=\"color: #0a0;\" class=\"glyphicon glyphicon glyphicon-euro payed\"></span>";
                    var infPayed = "<span style=\"color: #0a0;\">Oui</span>";
                }
                else {
                    var contPayed = "<span style=\"color: #a00;\" class=\"glyphicon glyphicon glyphicon-euro payed\"></span>";
                    var infPayed = "<span style=\"color: #a00;\">Non!</span>";
                }

                var contGeneral = "<span class=\"glyphicon glyphicon glyphicon-pencil edit\"></span><span class=\"glyphicon glyphicon glyphicon glyphicon-trash delete\"></span>";

                thtml += "<tr id=\"I" + result[i]["idFacture"] + "\"><td><input type=\"checkbox\" id=\"" + result[i]["idFacture"] + "\"></td>" +
                    "<td>" + result[i]["idFacture"] + "</td>" +
                    "<td>" + result[i]["dtCreateTS"] + "</td>" +
                    "<td>" + result[i]["fiDateHeure"] + "</td>" +
                    "<td>" + result[i]["fiTerrain"] + "</td>" +
                    "<td>" + result[i]["dtPlayer1Firstname"] + "&nbsp;" + result[i]["dtPlayer1Lastname"] + "</td>" +
                    "<td>" + result[i]["dtPlayer2Firstname"] + "&nbsp;" + result[i]["dtPlayer2Lastname"] + "</td>" +
                    "<td>" + infPayed + "</td>" +
                    "<td>" + contPayed + "&nbsp;" + contGeneral + "</td></tr>";
            }

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
                        "sTitle": "Date"
                    },
                    {
                        "sTitle": "Date de reservation"
                    },
                    {
                        "sTitle": "Terrain"
                    },
                    {
                        "sTitle": "Joueur 1"
                    },
                    {
                        "sTitle": "Joueur 2"
                    },
                    {
                        "sTitle": "Payé"
                    },
                    {
                        "sTitle": "_CTLS"
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
        }
    });

    console.log("PAGE LOADED!");
});