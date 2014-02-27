<?php

$userMgr = new UserMgr();

echo <<< PAGE
    <div id="dlgAddUser" title="Nouveau compte d'utilisateur">
        <form role="form">
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
    echo "<option value=\"" . $row["idUserType"] . "\">" . $row["dtDescription"] . "</option>";
}
echo "</select>";

echo <<< PAGE
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
        </form>
    </div>

    <div class="page-header">
        <h1>Utilisateurs <small>TECORESY Admin</small></h1>
    </div>

    <table class="table striped">
        <thead>
            <tr>
                <th><input type="checkbox"></th>
                <th><span class="glyphicon glyphicon-sort"></span> Nom d'utilisateur</th>
                <th>E-Mail</th>
                <th><span class="glyphicon glyphicon-sort"></span> Nom</th>
                <th><span class="glyphicon glyphicon-sort"></span> Pr&eacute;nom</th>
                <th><span class="glyphicon glyphicon-sort"></span> Type</th>
                <th><span class="glyphicon glyphicon-sort"></span> Date de naissance (Age)</th>
                <th>License</th>
                <th colspan="3"></th>
            </tr>
        </thead>

        <tbody>
PAGE;

foreach ($userMgr->getUsersFromDB(true) as $user) {
    echo "<tr><td><input type=\"checkbox\" id=\"u" . $user["idUser"] . "\"></td>
        <td>" . $user["dtUsername"] . "</td>
        <td>" . $user["dtEmail"] . "</td>
        <td>" . $user["dtLastname"] . "</td>
        <td>" . $user["dtFirstname"] . "</td>
        <td>" . $user["fiType"] . "</td>
        <td>" . $user["dtBirthdate"] . "</td>
        <td>" . $user["dtLicence"] . "(" . $user["fiAbo"] . ")</td>
        <td>" . $user["dtState"] . "&nbsp;<span class=\"glyphicon glyphicon-ok-circle\"></span></td>
        <td><span class=\"glyphicon glyphicon-pencil\"></span></td>
        <td><span class=\"glyphicon glyphicon-trash\"></span></td></tr>";
}

echo <<< PAGE
        </tbody>
    </table>

    <ul class="pagination pagination-sm">
        <li><a href="#"><span class="glyphicon glyphicon-chevron-left"></span></a></li>
        <li><a href="#">1</a></li>
        <li><a href="#">2</a></li>
        <li><a href="#">3</a></li>
        <li><a href="#">...</a></li>
        <li><a href="#">14</a></li>
        <li><a href="#"><span class="glyphicon glyphicon-chevron-right"></span></a></li>
    </ul>

    <script src="js/dialogs/dlgAddUser.js"></script>
PAGE;
