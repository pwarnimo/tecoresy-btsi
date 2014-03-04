<?php

$userMgr = new UserMgr();

echo <<< PAGE
    <div id="dlgChangeState" title="Activer/Deactiver l'utilisateur?">
        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous vraiment changer le statut de cet utilisateur?</p>
    </div>

    <div id="dlgDelete" title="Supprimer l'utilisateur?">
        <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Voulez-vous vraiment supprimer cet utilisateur?</p>
    </div>

    <div id="dlgAddUser" title="Nouveau compte d'utilisateur">
        <form role="form" id="frmAddUser">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="edtUsername">Nom d'utilisateur</label>
                        <input type="text" class="form-control" id="edtUsername" placeholder="Votre nom d'utilisateur ici...">
                    </div>
                    <div class="form-group">
                        <label for="edtPassword">Mot de passe</label>
                        <input type="password" class="form-control" id="edtPassword" placeholder="Votre mot de passe ici...">
                    </div>
                    <div class="form-group">
                        <label for="cmbType">Type d'utilisateur</label>
PAGE;

$utypes = $userMgr->getUserTypesFromDB();

echo "<select class=\"form-control\" id=\"cmbType\">";
foreach ($utypes as $row) {
    echo "<option value=\"" . $row["idTypeUser"] . "\">" . $row["dtDescription"] . "</option>";
}
echo "</select>";

echo <<< PAGE
                    </div>
                    <div class="form-group">
                        <label for="edtLicense">License</label>
                        <input type="text" class="form-control" id="edtLicense" placeholder="Votre nom license ici...">
                    </div>
                    <div class="form-group">
                        <label for="edtPostalCode">Code postale</label>
                        <input type="text" class="form-control" id="edtPostalCode" placeholder="Ex. L-1337">
                    </div>
                    <div class="form-group">
                        <label for="edtCountry">Pays</label>
                        <input type="text" class="form-control" id="edtCountry" placeholder="Ex. Luxembourg">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="edtEmail">E-Mail</label>
                        <input type="email" class="form-control" id="edtEmail" placeholder="Ex. john@example.com">
                    </div>
                    <div class="form-group">
                        <label for="edtFirstname">Pr&eacute;nom</label>
                        <input type="text" class="form-control" id="edtFirstname" placeholder="John">
                    </div>
                    <div class="form-group">
                        <label for="edtLastname">Nom</label>
                        <input type="text" class="form-control" id="edtLastname" placeholder="Doe">
                    </div>
                    <div class="form-group">
                        <label for="dtpBirthdate">Date de naissance</label>
                        <input type="text" class="form-control" id="dtpBirthdate" placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="edtAddress">Adresse</label>
                        <input type="text" class="form-control" id="edtAddress" placeholder="Ex. 1, rue de la gare">
                    </div>
                    <div class="form-group">
                        <label for="edtLocality">Localit&eacute;</label>
                        <input type="text" class="form-control" id="edtLocality" placeholder="Ex. Diekirch">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="page-header">
        <h1>Utilisateurs <small>TECORESY Admin</small></h1>
    </div>

    <table id="dataUsers">
        <thead>
            <tr>
                <th><input type="checkbox" id="checkAll"></th>
                <th>Nom d'utilisateur</th>
                <th>E-Mail</th>
                <th>Nom</th>
                <th>Pr&eacute;nom</th>
                <th>Type</td>
                <th>Date de naissance</th>
                <th>Licence</th>
                <th>Active</th>
                <th>ACT</th>
                <th>EDT</th>
                <th>DEL</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
PAGE;

    /*
     *
     * "aoColumns": [
            {"sTitle": "<input type=\"checkbox\" id=\"checkall\">"},
            {"sTitle": "Nom d'utilisateur"},
            {"sTitle": "E-Mail"},
            {"sTitle": "Nom"},
            {"sTitle": "Pr&eacute;nom"},
            {"sTitle": "Type"},
            {"sTitle": "Date de naissance"},
            {"sTitle": "Licence"},
            {"sTitle": "Active"},
            {"sTitle": "ACT"},
            {"sTitle": "EDT"},
            {"sTitle": "DEL"}
        ]
     *
     *
     * <table class="table striped">
        <thead>
            <tr>
                <th><input type="checkbox"></th>
                <th><span class="glyphicon glyphicon-sort"></span> Nom d'utilisateur</th>
                <th>E-Mail</th>
                <th><span class="glyphicon glyphicon-sort"></span> Nom</th>
                <th><span class="glyphicon glyphicon-sort"></span> Pr&eacute;nom</th>
                <th><span class="glyphicon glyphicon-sort"></span> Type</th>
                <th><span class="glyphicon glyphicon-sort"></span> Date de naissance</th>
                <th>License</th>
                <th colspan="3"></th>
            </tr>
        </thead>

        <tbody>
PAGE;

$usertype = array();

foreach ($utypes as $row) {
    $usertype[$row["idTypeUser"]] = $row["dtDescription"];
}

$abo = array();

foreach ($userMgr->getAbosFromDB() as $row) {
    $abo[$row["idAbo"]] = $row["dtDescription"];
}

foreach ($userMgr->getUsersFromDB(true) as $userrow) {
    if ($userrow["dtState"] == true) {
        $state = "Active";
    }
    else {
        $state = "Inactive";
    }

    echo "<tr><td><input type=\"checkbox\" id=\"u" . $userrow["idUser"] . "\"></td>
        <td>" . $userrow["dtUsername"] . "</td>
        <td>" . $userrow["dtEmail"] . "</td>
        <td>" . $userrow["dtLastname"] . "</td>
        <td>" . $userrow["dtFirstname"] . "</td>
        <td>" . $usertype[strval($userrow["fiType"])] . "</td>
        <td>" . $userrow["dtBirthdate"] . "</td>
        <td>" . $userrow["dtLicence"] . "(" . $abo[strval($userrow["fiAbo"])] . ")</td>
        <td>" . $state . "&nbsp;<span class=\"glyphicon glyphicon-ok-circle\"></span></td>
        <td><span class=\"glyphicon glyphicon-pencil\"></span></td>
        <td><span class=\"glyphicon glyphicon-trash\"></span></td></tr>";
}

echo <<< PAGE
        </tbody>
    </table>*/
echo <<< PAGE

    <script src="js/dialogs/dlgAddUser.js"></script>
    <script>
        $(document).ready(function() {
            $(".sidebar-nav li").removeClass("linkact");
            $("#users").addClass("linkact");
        });
    </script>
PAGE;
