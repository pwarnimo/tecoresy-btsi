var oTable;

console.log("Loaded.");

$(document).ready(function() {
    console.log("jquery");

    $("#dlgAddUser").dialog({
        resizable: false,
        height: 585,
        width: 640,
        modal: true,
        buttons: {
            Ajouter: function() {
                var userJson = "{\"username\":\"" + $("#edtUsername").val() + "\"," +
                    "\"password\":\"" + $("#edtPassword").val()  + "\"," +
                    "\"email\":\"" + $("#edtEmail").val() + "\"," +
                    "\"firstname\":\"" + $("#edtFirstname").val() + "\"," +
                    "\"lastname\":\"" + $("#edtLastname").val() + "\"," +
                    "\"type\":\"" + $("#cmbType").val() + "\"," +
                    "\"license\":\"" + $("#edtLicense").val() + "\"," +
                    "\"birthdate\":\"" + $("#dtpBirthdate").val() + "\"," +
                    "\"address\":\"" + $("#edtAddress").val() + "\"," +
                    "\"postalcode\":\"" + $("#edtPostalCode").val() + "\"," +
                    "\"location\":\"" + $("#edtLocality").val() + "\"," +
                    "\"country\":\"" + $("#edtCountry").val() + "\"}";

                console.log(userJson);

                $.ajax({
                    type       : "POST",
                    url        : "inc/actionswitcher.inc.php?action=addUser",
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

    $("#dlgDelete").hide();
    $("#dlgChangeState").hide();

    $("#btnAdd").click(function() {
        $("#dlgAddUser").dialog("open");
    });

    $("#btnEdit").click(function() {
        console.log("edit");
        alert("edit");
    });

    $("#btnRefresh").click(function() {
        refreshTable();
    });

    $("#dtpBirthdate").datepicker();

    //dtableData = getUserDataArray();
    //console.log(dtableData);

    populateUserDataTable();

    //$("#dataUsers").dataTable({});
});

function populateUserDataTable() {
    $.ajax({
        type : "POST",
        url : "inc/actionswitcher.inc.php?action=getUsers",
        statusCode : {
            404: function() {
                console.log("action.inc.php not found!");
            }
        },
        success    : function(data) {
            console.log("OK!");
            //console.log("Returned data: " + data);

            var result = JSON.parse(data);

            console.log(result.length);
            console.log(result);

            var thtml = "";
            var curRow = null;

            for (var i = 0; i < result.length; i++) {
                thtml += "<tr><td>" + result[i]["checkbox"] + "</td>" +
                    "<td>" + result[i]["dtUsername"] + "</td>" +
                    //"<td>" + result[i]["dtEmail"] + "</td>" +
                    "<td>" + result[i]["dtLastname"] + "</td>" +
                    "<td>" + result[i]["dtFirstname"] + "</td>" +
                    //"<td>" + result[i]["fiType"] + "</td>" +
                    "<td>" + result[i]["dtBirthdate"] + "</td>td>" +
                    "<td>" + result[i]["dtLicence"] + "</td>" +
                    //"<td>" + result[i]["dtState"] + "</td>" +
                    //"<td>" + result[i]["funcstate"] + "</td>" +
                    //"<td>" + result[i]["funcedit"] + "</td>" +
                    "<td>" + result[i]["dtStreet"] + " " + result[i]["dtPostalCode"] +"</td>" +
                    "<td>" + result[i]["dtLocation"] + "</td>" +
                    "<td>" + result[i]["dtCountry"] + "</td>" +
                    "<td>" + result[i]["funcstate"] + "&nbsp;" + result[i]["funcedit"] + "&nbsp;" + result[i]["funcdel"] + "</td></tr>"
                //curRow = result[i];
                //console.log(i);
                //console.log(result[i]["checkbox"]);
            }

            $("#dataUsers tbody").html(thtml);

            //return data;
            oTable = $("#dataUsers").dataTable({
                "bAutoWidth": false, // Disable the auto width calculation
                "aoColumns": [
                    {
                        "sTitle" : "<input type=\"checkbox\">",
                        "sWidth":"10px"
                    },
                    {
                        "sTitle": "Utilistateur"
                    },
                    {
                        "sTitle": "Nom"
                    },
                    {
                        "sTitle": "Prénom"
                    },
                    {
                        "sTitle": "Date de naissance"
                    },
                    {
                        "sTitle": "License"
                    },
                    {
                        "sTitle": "Addresse"
                    },
                    {
                        "sTitle": "Localité"
                    },
                    {
                        "sTitle": "Pays"
                    },
                    {
                        "sWidth":"85px"
                    }
                ],
                "aoColumnDefs": [
                    {
                        bSortable: false,
                        aTargets: [ 0, 1, 2, 6, 7 ]
                    }
                ]
            });

            $(".state").click(function() {
                var currentState = $(this).attr("id")[0];
                var uid = $(this).attr("id").substring(1);

                console.log("CSTATE = " + currentState);

                if (currentState == "A") {
                    console.log("UID" + uid + " is activated...");
                    var newState = "0";
                }
                else {
                    console.log("UID" + uid + " is deactivated...");
                    var newState = "1";
                }

                $("#dlgChangeState").dialog({
                    resizable: false,
                    height:200,
                    width: 350,
                    modal: true,
                    buttons: {
                        Change: function() {
                            console.log("Changing UID" + uid + " to " + newState);
                            changeUserState(uid, newState);

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
                var uid = $(this).attr("id").substring(1);

                console.log("Deleting user with ID = " + uid);

                $("#dlgDelete").dialog({
                    resizable: false,
                    height:200,
                    width: 350,
                    modal: true,
                    buttons: {
                        Supprimer: function() {
                            deleteUser(uid);

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

                //$("#dlg")
            });
        }
    });

    $("#checkAll").click(function() {
        console.log("Check All");
        $(".ckbRow").prop('checked', $(this).prop('checked'));
    });
}

function refreshTable() {
    console.log("refreshing...");
    oTable.fnDestroy();
    oTable.find("tbody").empty();
    populateUserDataTable();
}

function deleteUser(uid) {
    $.ajax({
        type       : "POST",
        url        : "inc/actionswitcher.inc.php?action=deleteUsers",
        data       : {
            uid : uid
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

function changeUserState(uid, state) {
    console.log("FUNC changeUserState params = " + uid + ", " + state);

    $.ajax({
        type    : "POST",
        url     : "inc/actionswitcher.inc.php?action=changeUserState",
        data    : {
            uid   : uid,
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