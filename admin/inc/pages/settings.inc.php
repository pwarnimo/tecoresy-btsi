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
                    <p><span class=" glyphicon glyphicon-wrench"></span>&nbsp;Mode de d&eacute;bogage</p>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios1" value="option1" checked>
                            Activ&eacute;
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="optionsRadios" id="optionsRadios2" value="option2">
                            D&eacute;sactiv&eacute;
                        </label>
                    </div>
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

echo "<p>Panel: " . $settingsMgr->checkForPanelUpdate() . "<br>Database: " . $settingsMgr->checkForDBUpdate() . "</p>";

echo <<< PAGE
                    <address>
                        <strong>Warnimont Pol</strong><br>
                        4, rue de l'Ernz<br>
                        L-9391 Reisdorf<br>
                        Luxembourg<br><br>
                        <abbr title="Téléphone"><span class="glyphicon glyphicon glyphicon-earphone"></span>:</abbr> (+352) 691 664 293<br>
                        <abbr title="E-Mail"><span class="glyphicon glyphicon glyphicon glyphicon-envelope"></span>:</abbr> <a href="mailto:pwarnimo@gmail.com">pwarnimo@gmail.com</a><br>
                        <abbr title="Page de web"><span class="glyphicon glyphicon glyphicon-globe"></span>:</abbr> <a href="http://dev.warnimont.de">dev.warnimont.de</a>
                    </address>
                </div>
            </div>
        </div>
    </div>
PAGE;

echo <<< PAGE
    <script src="js/pages/settings.js"></script>
PAGE;
