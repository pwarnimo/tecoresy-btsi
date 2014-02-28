$(document).ready(function() {
    $("#dlgAddUser").dialog({
        resizable: false,
        height: 585,
        width: 640,
        modal: true,
        buttons: {
            Add: function() {
                var user = {
                    "username"  : $("#edtUsername").val(),
                    "password"  : $("#edtPassword").val(),
                    "email"     : $("#edtEmail").val(),
                    "firstname" : $("#edtFirstname").val(),
                    "lastname"  : $("#edtLastname").val(),
                    "type"      : $("#cmbType").val(),
                    "license"   : $("#edtLicense").val()
                }

                console.log(user);
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