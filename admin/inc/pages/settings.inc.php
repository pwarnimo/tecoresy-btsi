<?php

$settingsMgr = new SettingsMgr();

echo <<< PAGE
    <div class="page-header">
        <h1>Configuration <small>TECORESY Admin</small></h1>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Base de données</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label for="edtDBHost">Addresse du MySQL serveur</label>
                        <input type="text" class="form-control" id="edtDBHost" placeholder="Ex. 127.0.0.1">
                    </div>
                    <div class="form-group">
                        <label for="edtUser">Utilisateur</label>
                        <input type="text" class="form-control" id="edtUser" placeholder="Ex. johndoe">
                    </div>
                    <div class="form-group">
                        <label for="edtPass">Mot de passe</label>
                        <input type="text" class="form-control" id="edtPass" placeholder="Votre mot de passe ici...">
                    </div>
                    <div class="form-group">
                        <label for="edtDBName">Nom du base de données</label>
                        <input type="text" class="form-control" id="edtDBName" placeholder="Ex. TECORESY">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">SettingPG2</h3>
                </div>
                <div class="panel-body">
                    Panel content
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">A propos de...</h3>
                </div>
                <div class="panel-body">
                    <h4>TECORESY Admin</h4>
PAGE;

echo "<p>Panel: v" . $settingsMgr->getSetting("pnlversion") . "<br>Database: v" . $settingsMgr->getSetting("dbversion") . "</p>";

echo <<< PAGE
                    <address>
                        <strong>Warnimont Pol</strong><br>
                        4, rue de l'Ernz<br>
                        L-9391 Reisdorf<br>
                        Luxembourg<br><br>
                        <abbr title="Téléphone">T:</abbr> (+352) 691 664 293<br>
                        <abbr title="E-Mail">E:</abbr> pwarnimo@gmail.com<br>
                        <abbr title="Page de web">H:</abbr> http://dev.warnimont.de
                    </address>
                </div>
            </div>
        </div>
    </div>
PAGE;

echo <<< PAGE
    <script src="js/pages/settings.js"></script>
PAGE;
