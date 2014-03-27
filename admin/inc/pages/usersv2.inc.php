<?php

$userMgr = new UserMgr();

echo <<< DLGUSERSTATUS
    <div id="dlgUserStatus" title="Bloquer">
        <p>Voulez vous vraiment blocker ou debloquer cet utilisateur?</p>
    </div>
DLGUSERSTATUS;

echo <<< DLGUSERDEL
    <div id="dlgUserDel" title="Supprimer">
        <p>Voulez vous vraiment supprimer cet utilisateur?</p>
    </div>
DLGUSERDEL;

echo <<< DLGUSERDELMULTI
    <div id="dlgUserDelMulti" title="Supprimer">
        <p>Voulez vous vraiment supprimer les utilisateurs?</p>
    </div>
DLGUSERDELMULTI;

echo <<< DLGUSERADD
    <div id="dlgUserAdd" title="Nouveau compte d'utilisateur">
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
                                <input name="utypes[]" type="checkbox" value="2">
                                Visiteur
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input name="utypes[]" type="checkbox" value="3">
                                Parent
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input name="utypes[]" type="checkbox" value="1">
                                Membre
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input name="utypes[]" type="checkbox" value="0">
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
                        <input type="text" class="form-control" id="edtCountry" placeholder="Ex. Luxembourg">
                    </div>

                    <div class="form-group">
                        <label for="edtBirthdate">Date de naissance</label>
                        <input type="text" class="form-control" id="edtBirthdate" placeholder="">
                    </div>

                    <div class="form-group">
                        <label for="lsbTuteur">Tuteur</label>
                        <select id="lsbTuteur">
                            <option value="NULL">None</option>
DLGUSERADD;

$tuteurs = $userMgr->getUserList();

foreach ($tuteurs as $tuteur) {
    echo "<option value=\"" . $tuteur["idUser"] . "\">" . $tuteur["dtFirstname"] . " " . $tuteur["dtLastname"] . "</option>";
}

echo <<< DLGUSERADD
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="edtPostalCode">Code postale</label>
                        <input type="text" class="form-control" id="edtPostalCode" placeholder="L-9391">
                    </div>
                </div>
            </div>
        </form>
    </div>
DLGUSERADD;


echo <<< PAGE
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
                <h3 class="panel-title">D&eacute;tails sur l'utilisateur <span id="idutilisateur"></span></h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="edtSUsername">Nom d'utilisateur</label>
                            <input type="text" class="form-control" id="edtSUsername">
                        </div>

                        <div class="form-group">
                            <label for="edtSFirstname">Prénom</label>
                            <input type="text" class="form-control" id="edtSFirstname">
                        </div>

                        <div class="form-group">
                            <label for="edtSLastname">Nom</label>
                            <input type="text" class="form-control" id="edtSLastname">
                        </div>

                        <div class="form-group">
                            <label for="edtSEmail">E-Mail</label>
                            <input type="text" class="form-control" id="edtSEmail">
                        </div>

                        <div class="form-group">
                            <label for="edtSPhone">Phone</label>
                            <input type="text" class="form-control" id="edtSPhone">
                        </div>

                        <div class="form-group">
                            <label for="edtSLicence">Licence</label>
                            <input type="text" class="form-control" id="edtSLicence">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="edtSBirthdate">Date de naissance</label>
                            <input type="text" class="form-control" id="edtSBirthdate">
                        </div>

                        <div class="form-group">
                            <label for="edtSStreet">Addresse</label>
                            <input type="text" class="form-control" id="edtSStreet">
                        </div>

                        <div class="form-group">
                            <label for="edtSLocation">Localité</label>
                            <input type="text" class="form-control" id="edtSLocation">
                        </div>

                        <div class="form-group">
                            <label for="edtSCP">Code postale</label>
                            <input type="text" class="form-control" id="edtSCP">
                        </div>

                        <div class="form-group">
                            <label for="edtSCountry">Pays</label>
                            <input type="text" class="form-control" id="edtSCountry">
                        </div>
                    </div>
                    <div class="col-md-6">

                    </div>
                </div>

                <button type="button" id="btnEdit" class="btn btn-default">Editer</button>&nbsp;<button type="button" id="btnNewPw" class="btn btn-default">Nouveau mot de passe</button>
            </div>
        </div>

        <button type="button" id="btnBack" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Retour</button>
    </div>
PAGE;

echo <<< PAGE
    <script src="js/pages/usersv2.js"></script>
PAGE;
