<?php

$userMgr = new UserMgr();

echo <<< PAGE
    <div id="progressbar" style="margin-top: 15px;"><div class="progress-label">Chargement en cours...</div></div>

    <div id="dlgAddUser" title="Nouveau compte d'utilisateur">
        <form role="form" id="frmAddUser">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="edtUsername">Nom d'utilisateur</label>
                        <input type="text" class="form-control" id="edtUsername" placeholder="Votre nom d'utilisateur ici...">
                    </div>

                    <div class="form-group">
                        <label for="edtEmail">Addresse E-Mail</label>
                        <input type="email" class="form-control" id="edtEmail" placeholder="Ex. john@example.fr">
                    </div>

                    <div class="form-group">
                        <label for="edtPassword">Mot de passe</label>
                        <input type="password" class="form-control" id="edtPassword" placeholder="Votre mot de passe ici...">
                    </div>

                    <div class="form-group">
                        <label for="edtFirstname">Pr&eacute;nom</label>
                        <input type="text" class="form-control" id="edtFirstname" placeholder="Ex. John">
                    </div>

                    <div class="form-group">
                        <label for="edtLastname">Nom</label>
                        <input type="text" class="form-control" id="edtLastname" placeholder="Ex. Doe">
                    </div>

                    <div class="form-group">
                        <label for="edtLicence">License</label>
                        <input type="text" class="form-control" id="edtLicence" placeholder="Votre num&eacute;ro de license ici...">
                    </div>

                    <div class="form-group">
                        <label for="edtPhone">Téléphone</label>
                        <input type="text" class="form-control" id="edtPhone" placeholder="Votre num&eacute;ro de téléphone ici...">
                    </div>
                </div>

                <div class="col-md-6">
                    <label>Type d'utilisateur
                        <div class="checkbox">
                            <label>
                                <input name="utypes[]" type="checkbox" value="1">
                                Visiteur
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input name="utypes[]" type="checkbox" value="2">
                                Parent
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input name="utypes[]" type="checkbox" value="3">
                                Membre
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input name="utypes[]" type="checkbox" value="4">
                                Administrateur
                            </label>
                        </div>
                    </label>

                    <div class="form-group">
                        <label for="edtStreet">Addresse</label>
                        <input type="text" class="form-control" id="edtStreet" placeholder="Ex. 1, rue de la gare">
                    </div>

                    <div class="form-group">
                        <label for="edtLocation">Localit&eacute;</label>
                        <input type="text" class="form-control" id="edtLocation" placeholder="Ex. Diekirch">
                    </div>

                    <div class="form-group">
                        <label for="edtCountry">Pays</label>
                        <input type="text" class="form-control" id="edtPays" placeholder="Ex. Luxembourg">
                    </div>

                    <div class="form-group">
                        <label for="edtBirthdate">Date de naissance</label>
                        <input type="text" class="form-control" id="edtBirthdate" placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="lsbTuteur">Tuteur</label>
                        <select id="lsbTuteur">
                            <option value="">None</option>
PAGE;

$tuteurs = $userMgr->getUserList();

foreach ($tuteurs as $tuteur) {
    echo "<option value=\"" . $tuteur["idUser"] . "\">" . $tuteur["dtFirstname"] . " " . $tuteur["dtLastname"] . "</option>";
}

echo <<< PAGE
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="page-header">
        <h1>Utilisateurs <small>TECORESY Admin</a></small></h1>
    </div>

    <div id="tableview">
        <table id="dataUsers" class="testtable" width="100%">
            <thead>
            </thead>

            <tbody>
            </tbody>
        </table>
    </div>

    <div id="userview">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">D&eacute;tails sur l'utilisateur </h3>
            </div>
            <div class="panel-body">
                <p>test</p>
            </div>
        </div>

        <button type="button" id="btnBack" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Retour</button>
    </div>
PAGE;

echo <<< PAGE
    <script src="js/pages/usersv2.js"></script>
PAGE;
