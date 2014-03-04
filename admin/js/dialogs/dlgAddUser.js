$(document).ready(function() {
    $("#dlgAddUser").dialog({
        resizable: false,
        height: 585,
        width: 640,
        modal: true,
        buttons: {
            Add: function() {
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
                    url        : "inc/action.inc.php?action=addUser",
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
                    }
                });
            },
            Cancel: function() {
                $( this ).dialog( "close" );
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
        $("#dlgAddUser").dialog("open");
    });

    $("#dtpBirthdate").datepicker();
});