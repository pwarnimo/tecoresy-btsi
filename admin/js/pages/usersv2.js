var oTable;

$(document).ready(function() {
    console.log("PAGE INIT...");

    $(".sidebar-nav li").removeClass("linkact");
    $("#users").addClass("linkact");

    populateUserTable();

    var helpHtml = "<ul><li><span class=\"glyphicon glyphicon-refresh\"></span> Actualiser les données sur les utilisateurs.</li>" +
        "<li><span class=\"glyphicon glyphicon-plus-sign\"></span> Ajouter un nouveau utilisateur.</li>" +
        "<li><span class=\"glyphicon glyphicon-pencil\"></span> Modifier l'utilisateur selectioné.</li>" +
        "<li><span class=\"glyphicon glyphicon-trash\"></span> Supprimer un ou plusieurs utilisateurs. Fonctionne aussi avec \"glisser-déposer\"</li>" +
        "<li><span class=\"glyphicon glyphicon-ok-circle\"></span>/<span class=\"glyphicon glyphicon-remove-circle\"></span> Activer / Deactiver l'utilisateur.</li></ul>" +
        "<hr>" +
        "<p>Types d'utlisateurs</p>" +
        "<ul><li><span style=\"color: #f0ad4e;\" class=\"glyphicon glyphicon-user\"></span> Visiteur</li>" +
        "<li><span style=\"color: #5bc0de;\" class=\"glyphicon glyphicon-user\"></span> Parent</li>" +
        "<li><span style=\"color: #ac2925;\" class=\"glyphicon glyphicon-user\"></span> Membre</li>" +
        "<li><span style=\"color: #0e4;\" class=\"glyphicon glyphicon-user\"></span> Administrateur</li></ul>" +
        "<p>Pour plusieurs informations ou questions, veuillez envoyer un E-Mail á <a href=\"mailto:pwarnimo@gmail.com\">pwarnimo@gmail.com</a>.</p>";

    $("#help-wrapper").html($("#help-wrapper").html() + helpHtml);

    console.log("PAGE LOADED!");
});

function populateUserTable() {
    $.ajax({
        type : "POST",
        url : "inc/action.inc.php?action=getUsers",
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
                var usertypes = JSON.parse(result[i]["usertypes"]);
                var userindicator = "";

                for (var j = 0; j < usertypes.length; j++) {
                    console.log(usertypes[j]["dtDescription"]);

                    switch (usertypes[j]["idTypeUser"]) {
                        case "1" :
                            console.log("T1-VISITOR");
                            userindicator += "<span style=\"color: #f0ad4e;\" class=\"glyphicon glyphicon-user\" title=\"Visiteur\"></span>"

                            break;

                        case "2" :
                            console.log("T2-PARENT");
                            userindicator += "<span style=\"color: #5bc0de;\" class=\"glyphicon glyphicon-user\" title=\"Parent\"></span>"

                            break;

                        case "3" :
                            console.log("T3-MEMBER");
                            userindicator += "<span style=\"color: #ac2925;\" class=\"glyphicon glyphicon-user\" title=\"Membre\"></span>"

                            break;

                        case "4" :
                            console.log("T4-ADMIN");
                            userindicator += "<span style=\"color: #0e4;\" class=\"glyphicon glyphicon-user\" title=\"Administrateur\"></span>"

                            break;
                    }
                }

                var contGeneral = "<span class=\"glyphicon glyphicon glyphicon-pencil edit\"></span><span class=\"glyphicon glyphicon glyphicon glyphicon-trash delete\"></span>";

                if (result[i]["dtState"] == true) {
                    var contState = "<span style=\"color: #0a0;\" class=\"glyphicon glyphicon-ok-circle\"></span>"
                    var uid = "A" + result[i]["idUser"];
                }
                else {
                    var contState = "<span style=\"color: #a00;\" class=\"glyphicon glyphicon-remove-circle\"></span>"
                    var uid = "I" + result[i]["idUser"];
                }

                thtml += "<tr id=\"" + result[i]["idUser"] + "\"><td><input type=\"checkbox\" id=\"" + result[i]["idUser"] + "\"></td>" +
                    "<td>" + result[i]["dtEmail"] + "</td>" +
                    "<td>" + result[i]["dtLastname"] + "</td>" +
                    "<td>" + result[i]["dtFirstname"] + "</td>" +
                    "<td>" + result[i]["dtStreet"] + "</td>" +
                    "<td>" + result[i]["dtPostalCode"] + "</td>" +
                    "<td>" + result[i]["dtLocation"] + "</td>" +
                    "<td>" + result[i]["dtCountry"] + "</td>" +
                    "<td>" + userindicator + "</td>" +
                    "<td>" + contState + contGeneral + "</td></tr>";
            }

            $("#dataUsers tbody").html(thtml);

            oTable = $("#dataUsers").dataTable({
                "bAutoWidth": false,
                "aoColumns": [
                    {
                        "sTitle": "<input type=\"checkbox\" id=\"checkAll\">"
                    },
                    {
                        "sTitle": "E-Mail"
                    },
                    {
                        "sTitle": "Nom"
                    },
                    {
                        "sTitle": "Prénom"
                    },
                    {
                        "sTitle": "Addresse"
                    },
                    {
                        "sTitle": "Code postale"
                    },
                    {
                        "sTitle": "Localité"
                    },
                    {
                        "sTitle": "Pays"
                    },
                    {
                        "sTitle": "Type"
                    },
                    {
                        "sTitle": "_CTLS"
                    }

                ],
                "aoColumnDefs": [
                    {
                        bSortable: false,
                        aTargets: [ 0, 4, 5, 8, 9 ]
                    }
                ],
                "oLanguage": {
                    "sLengthMenu": "Afficher _MENU_ utilisateurs par page",
                    "sZeroRecords": "Rien trouvé!",
                    "sInfo": "Utilisateurs _START_ á _END_ de _TOTAL_ Utilisateur(s) en totale",
                    "sInfoEmpty": "Le tableau est vide!",
                    "sInfoFiltered": "(filtrée à partir de _MAX_ utilisateurs au total)",
                    "sSearch": "Chercher: ",
                    "oPaginate": {
                        "sNext": "Suivant",
                        "sPrevious": "Précédent"
                    }
                }
            });
        }
    });
}