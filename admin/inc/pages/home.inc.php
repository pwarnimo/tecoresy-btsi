<?php
echo <<< PAGE
    <div class="page-header">
PAGE;

echo "<h1>TECORESY Admin <small>Bienvenue " . $_SESSION["lname"] . " " . $_SESSION["fname"] . "!</small></h1>";

echo <<< PAGE
    </div>

<div class="panel panel-default">
    <div class="panel-heading">
        Messages importants <span class="pull-right"><button type="button" class="btn btn-info btn-xs"><span class="glyphicon glyphicon-info-sign"></span></button>&nbsp;<button type="button" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-warning-sign"></span></button>&nbsp;<button type="button" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon glyphicon-exclamation-sign"></span></button>&nbsp;&nbsp;<button id="btnShowMsgBox" type="button" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-plus-sign"></span></button></span>
    </div>
    <div class="panel-body">
        <p class="text-success">test</p>
        <form id="messagebox">
            <input type="text" class="form-control"><br>
            <button type="button" class="btn btn-default"><span class="glyphicon glyphicon glyphicon-pencil"></span></button>
            <select>
                <option>Information</option>
                <option>Avertissement</option>
                <option>Important</option>
            </select>
        </form>
    </div>
</div>

    <script src="js/pages/home.js"></script>
PAGE;
