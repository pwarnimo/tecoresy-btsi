<?php

echo <<< PAGE
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
                <th colspan="2"></th>
            </tr>
        </thead>

        <tbody>
PAGE;

$userMgr = new UserMgr();

foreach ($userMgr->getUsersFromDB(true) as $user) {
    echo "<tr><td><input type=\"checkbox\" id=\"u" . $user["idUser"] . "\"></td>
        <td>" . $user["dtUsername"] . "</td>
        <td>" . $user["dtEmail"] . "</td>
        <td>" . $user["dtLastname"] . "</td>
        <td>" . $user["dtFirstname"] . "</td>
        <td>" . $user["fiType"] . "</td>
        <td>" . $user["dtBirthdate"] . "</td>
        <td>" . $user["fiAbo"] . "</td>
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
PAGE;
