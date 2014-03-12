<?php

$userMgr = new UserMgr();

echo <<< PAGE
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
