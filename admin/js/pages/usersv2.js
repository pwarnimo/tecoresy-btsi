var oTable;

/* --- OVERLAYS ----------------------------------------------------------------------------------------------------- */

// -- Add new user --

$("#dlgUserAdd").hide();

function DlgUserAdd() {}

DlgUserAdd.prototype.showDialog = function() {
    $("#dlgUserAdd").dialog({
        resizable: false,
        height: 585,
        width: 640,
        modal: true,
        buttons: {
            Ajouter: function() {
                addUser();

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

// -- Delete user --

$("#dlgUserDel").hide();

function DlgUserDel(uid) {
    this.uid = uid;
};

DlgUserDel.prototype.showDialog = function() {
    var currId = this.uid;

    console.log(">> - " + currId);

    $("#dlgUserDel").dialog({
        resizable: false,
        height: 190,
        width: 400,
        modal: true,
        buttons: {
            Appliquer: function() {
                console.log(">>>>" + currId[0]);

                var uid = currId.substring(1);

                $.ajax({
                    type       : "POST",
                    url        : "inc/actionswitcher.inc.php?action=deleteSingleUser",
                    data       : {
                        uid   : uid
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

// -- Multi delete --

$("#dlgUserDelMulti").hide();

function DlgUserDelMulti(uids) {
    this.uids = uids;
};

DlgUserDelMulti.prototype.showDialog = function() {
    var uids = this.uids;
    var uidsJson = JSON.stringify(uids);

    console.log(uidsJson);

    $("#dlgUserDelMulti").dialog({
        resizable: false,
        height: 190,
        width: 400,
        modal: true,
        buttons: {
            Appliquer: function() {
                $.ajax({
                    type       : "POST",
                    url        : "inc/actionswitcher.inc.php?action=deleteUsers",
                    data       : {
                        uids   : uidsJson
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

// -- De/Activate user --

$("#dlgUserStatus").hide();

function DlgUserStatus(uid) {
    this.uid = uid;
};

DlgUserStatus.prototype.showDialog = function() {
    var currId = this.uid;

    console.log(">> - " + currId);

    $("#dlgUserStatus").dialog({
        resizable: false,
        height: 190,
        width: 400,
        modal: true,
        buttons: {
            Appliquer: function() {
                console.log(">>>>" + currId[0]);

                var uid = currId.substring(1);

                if (currId[0] == "A") {
                    console.log("BLOCKING");

                    var state = "No";
                }
                else {
                    console.log("UNBLOCKING");

                    var state = "Yes";
                }

                $.ajax({
                    type       : "POST",
                    url        : "inc/actionswitcher.inc.php?action=changeUserState",
                    data       : {
                        uid   : uid,
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

/* ------------------------------------------------------------------------------------------------------------------ */

$(document).ready(function() {
    console.log("PAGE INIT...");

    $(".sidebar-nav li").removeClass("linkact");
    $("#users").addClass("linkact");

    $("#dtpBirthdate").datepicker({ yearRange: "1900:2014" });

    $("#userview").hide();

    $("#btnAdd").click(function() {
        var dlg0 = new DlgUserAdd();

        dlg0.showDialog();
    });

    $("#btnBack").click(function() {
        $("#userview").fadeOut("fast", function() {
            $("#tableview").fadeIn("fast");
        });
    });

    populateUserTable();

    var helpHtml = "<ul><li><span class=\"glyphicon glyphicon-refresh\"></span> Actualiser les données sur les utilisateurs.</li>" +
        "<li><span class=\"glyphicon glyphicon-plus-sign\"></span> Ajouter un nouveau utilisateur.</li>" +
        "<li><span class=\"glyphicon glyphicon-pencil\"></span> Modifier l'utilisateur selectioné.</li>" +
        "<li><span class=\"glyphicon glyphicon-trash\"></span> Supprimer un ou plusieurs utilisateurs. Fonctionne aussi avec \"glisser-déposer\"</li>" +
        "<li><span class=\"glyphicon glyphicon-ok-circle\"></span>/<span class=\"glyphicon glyphicon-remove-circle\"></span> Activer / Deactiver l'utilisateur.</li></ul>" +
        "<p>Types d'utlisateurs</p>" +
        "<ul><li><span style=\"color: #f0ad4e;\" class=\"glyphicon glyphicon-user\"></span> Visiteur</li>" +
        "<li><span style=\"color: #5bc0de;\" class=\"glyphicon glyphicon-user\"></span> Parent</li>" +
        "<li><span style=\"color: #ac2925;\" class=\"glyphicon glyphicon-user\"></span> Membre</li>" +
        "<li><span style=\"color: #0e4;\" class=\"glyphicon glyphicon-user\"></span> Administrateur</li></ul>" +
        "<p>Pour plusieurs informations ou questions, veuillez envoyer un E-Mail á <a href=\"mailto:pwarnimo@gmail.com\">pwarnimo@gmail.com</a>.</p>";

    $("#help-wrapper").html($("#help-wrapper").html() + helpHtml);

    $("#btnDelete").click(function() {
        console.log("MULTIDELETE");

        var cbs = new Array();

        $("#dataUsers tbody input:checkbox:checked").each(function() {
            cbs.push($(this).attr("id"));
            console.log("checked");
        });

        console.log(cbs);

        var dlg0 = new DlgUserDelMulti(cbs);

        dlg0.showDialog();
    })

    console.log("PAGE LOADED!");
});

function populateUserTable() {
    $.ajax({
        type : "POST",
        url : "inc/actionswitcher.inc.php?action=getUsers",
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
                        case "2" :
                            console.log("T1-VISITOR");
                            userindicator += "<span style=\"color: #f0ad4e;\" class=\"glyphicon glyphicon-user\" title=\"Visiteur\"></span>"

                            break;

                        case "3" :
                            console.log("T2-PARENT");
                            userindicator += "<span style=\"color: #5bc0de;\" class=\"glyphicon glyphicon-user\" title=\"Parent\"></span>"

                            break;

                        case "1" :
                            console.log("T3-MEMBER");
                            userindicator += "<span style=\"color: #ac2925;\" class=\"glyphicon glyphicon-user\" title=\"Membre\"></span>"

                            break;

                        case "0" :
                            console.log("T4-ADMIN");
                            userindicator += "<span style=\"color: #0e4;\" class=\"glyphicon glyphicon-user\" title=\"Administrateur\"></span>"

                            break;
                    }
                }

                var contGeneral = "<span class=\"glyphicon glyphicon glyphicon-pencil edit\"></span><span class=\"glyphicon glyphicon glyphicon glyphicon-trash delete\"></span>";

                if (result[i]["dtIsActive"] == "Yes") {
                    var contState = "<span style=\"color: #0a0;\" class=\"glyphicon glyphicon-ok-circle changestate\"></span>"
                    var uid = "A" + result[i]["idUser"];
                }
                else {
                    var contState = "<span style=\"color: #a00;\" class=\"glyphicon glyphicon-remove-circle changestate\"></span>"
                    var uid = "I" + result[i]["idUser"];
                }

                thtml += "<tr id=\"" + uid + "\"><td><input type=\"checkbox\" id=\"" + result[i]["idUser"] + "\"></td>" +
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

            $("#dataUsers tbody td").each(function () {
                if ($(this).html().trim().length == 0) {
                    $(this).html("/");
                }
            });

            oTable = $("#dataUsers").dataTable({
                "bAutoWidth": false,
                "aoColumns": [
                    {
                        "sTitle": "<input type=\"checkbox\" id=\"checkAll\">",
                        "sWidth": "16px"
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
                        "sTitle": ""
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

            /*$("#dataUsers tbody tr").click(function() {
                $("#tableview").fadeOut("fast", function() {
                    $("#userview").fadeIn("fast");
                });
            });*/

            $(".changestate").click(function() {
                console.log(">UID> " + $(this).parent().parent().attr("id"));

                var dlg0 = new DlgUserStatus($(this).parent().parent().attr("id"));

                dlg0.showDialog();
            });

            $(".delete").click(function() {
                console.log(">UID> " + $(this).parent().parent().attr("id"));

                var dlg0 = new DlgUserDel($(this).parent().parent().attr("id"));

                dlg0.showDialog();
            });

            $(".edit").click(function() {
                var uidr = $(this).parent().parent().attr("id");
                var uid = uidr.substring(1);

                $("#tableview").fadeOut("fast", function() {
                    $("#userview").fadeIn("fast");

                    $.ajax({
                        type       : "POST",
                        url        : "inc/actionswitcher.inc.php?action=getUserData",
                        data       : {
                            uid   : uid
                        },
                        statusCode : {
                            404: function() {
                                console.log("action.inc.php not found!");
                            }
                        },
                        success    : function(data) {
                            console.log(data);

                            var result = JSON.parse(data);

                            $("#idutilisateur").html(result[0]["idUser"]);
                            $("#edtSUsername").val(result[0]["dtUsername"]);
                            $("#edtSFirstname").val(result[0]["dtFirstname"]);
                            $("#edtSLastname").val(result[0]["dtLastname"]);
                            $("#edtSEmail").val(result[0]["dtEmail"]);
                            $("#edtSPhone").val(result[0]["dtPhone"]);
                            $("#edtSLicence").val(result[0]["dtLicence"]);
                            $("#edtSBirthdate").val(result[0]["dtBirthdate"]);
                            $("#edtSStreet").val(result[0]["dtStreet"]);
                            $("#edtSLocation").val(result[0]["dtLocation"]);
                            $("#edtSCP").val(result[0]["dtPostalCode"]);
                            $("#edtSCountry").val(result[0]["dtCountry"]);
                        }
                    });

                    $.ajax({
                        type       : "POST",
                        url        : "inc/actionswitcher.inc.php?action=getTypesForUser",
                        data       : {
                            uid   : uid
                        },
                        statusCode : {
                            404: function() {
                                console.log("action.inc.php not found!");
                            }
                        },
                        success    : function(data) {
                            console.log(data);

                            var result = JSON.parse(data);

                            for (var i = 0; i < result.length; i++) {

                            }
                        }
                    });
                });
            });
        },
        beforeSend : function() {
            $("#progressbar").show();
        },
        complete : function() {
            $("#progressbar").hide()
        }
    });
};

function addUser() {
    var arrUserData = {};

    // :username, :hash, :firstname, :lastname, :email, :phone, :salt, :licence, :birthdate, :state, :street,
    //:location, :postalcode, :country, :abo, :tuteur, NULL";

    arrUserData["username"]   = $("#edtUsername").val();
    arrUserData["password"]   = $("#edtPassword").val();
    arrUserData["firstname"]  = $("#edtFirstname").val();
    arrUserData["lastname"]   = $("#edtLastname").val();
    arrUserData["email"]      = $("#edtEmail").val();
    arrUserData["phone"]      = $("#edtPhone").val();
    arrUserData["licence"]    = $("#edtLicence").val();
    arrUserData["birthdate"]  = $("#edtBirthdate").val();
    arrUserData["street"]     = $("#edtStreet").val();
    arrUserData["location"]   = $("#edtLocation").val();
    arrUserData["postalcode"] = $("#edtPostalCode").val();
    arrUserData["country"]    = $("#edtCountry").val();
    arrUserData["tuteur"]     = $("#lsbTuteur").val();

    var userJson = JSON.stringify(arrUserData);

    console.log(userJson);

    var values = new Array();
    $.each($("input[name='utypes[]']:checked"), function() {
        values.push($(this).val());
    });

    var utypesJson = JSON.stringify(values);

    console.log(utypesJson);

    $.ajax({
        type       : "POST",
        url        : "inc/actionswitcher.inc.php?action=addUser",
        data       : {
            userjson   : userJson,
            utypesjson : utypesJson
        },
        statusCode : {
            404: function() {
                console.log("action.inc.php not found!");

                refreshTable();
            }
        },
        success    : function(data) {
            console.log(data);
        }
    });
};

function refreshTable() {
    console.log("refreshing...");
    oTable.fnDestroy();
    oTable.find("tbody").empty();
    populateUserTable();
};