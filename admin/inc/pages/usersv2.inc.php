<?php

$userMgr = new UserMgr();

echo <<< PAGE
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
                        <label for="edtLicense">License</label>
                        <input type="text" class="form-control" id="edtLicense" placeholder="Votre num&eacute;ro de license ici...">
                    </div>
                </div>

                <div class="col-md-6">
                    <label>Type d'utilisateur
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="1">
                                Visiteur
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="2">
                                Parent
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="3">
                                Membre
                            </label>
                        </div>

                        <div class="checkbox">
                            <label>
                                <input type="checkbox" value="4">
                                Administrateur
                            </label>
                        </div>
                    </label>

                    <div class="form-group">
                        <label for="edtAddresse">Addresse</label>
                        <input type="text" class="form-control" id="edtAddresse" placeholder="Ex. 1, rue de la gare">
                    </div>

                    <div class="form-group">
                        <label for="edtLocality">Localit&eacute;</label>
                        <input type="text" class="form-control" id="edtLocality" placeholder="Ex. Diekirch">
                    </div>

                    <div class="form-group">
                        <label for="edtCountry">Pays</label>
                        <input type="text" class="form-control" id="edtPays" placeholder="Ex. Luxembourg">
                    </div>

                    <div class="form-group">
                        <label for="dtpBirthdate">Date de naissance</label>
                        <input type="text" class="form-control" id="dtpBirthdate" placeholder="">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="page-header">
        <h1>Utilisateurs <small>TECORESY Admin // <a href="main.php?page=users">Show Version 1</a></small></h1>
    </div>

    <table id="dataUsers" class="testtable" width="100%">
        <thead>
        </thead>

        <tbody>
        </tbody>
    </table>
PAGE;

echo <<< PAGE
    <script src="js/pages/usersv2.js"></script>
PAGE;
