$(document).ready(function() {
    $("#dlgAddUser").dialog({
        resizable: false,
        height: 500,
        width: 350,
        modal: true,
        buttons: {
            Add: function() {
                $( this ).dialog( "close" );
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