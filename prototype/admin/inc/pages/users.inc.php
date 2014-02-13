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
                <th>No° License</th>
                <th colspan="2"></th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td><input type="checkbox"></td>
                <td>pwarnimo</td>
                <td>pwarnimo@gmail.com</td>
                <td>Warnimont</td>
                <td>Pol</td>
                <td>Administrateur</td>
                <td>16.11.1990 (23)</td>
                <td>LU328293472394</td>
                <td><span class="glyphicon glyphicon-pencil"></span></td>
                <td><span class="glyphicon glyphicon-trash"></span></td>
            </tr>
            <tr>
                <td><input type="checkbox"></td>
                <td>dwarnimo</td>
                <td>d.warnimont@gmail.com</td>
                <td>Warnimont</td>
                <td>Daniel</td>
                <td>Membre (Adulte)</td>
                <td>16.11.1990 (23)</td>
                <td>LU023878594334</td>
                <td><span class="glyphicon glyphicon-pencil"></span></td>
                <td><span class="glyphicon glyphicon-trash"></span></td>
            </tr>
            <tr>
                <td><input type="checkbox"></td>
                <td>jgarcia</td>
                <td>john@gmail.com</td>
                <td>Garcia</td>
                <td>John</td>
                <td>Membre (Adulte)</td>
                <td>23.09.1984 (29)</td>
                <td>LU309684922344</td>
                <td><span class="glyphicon glyphicon-pencil"></span></td>
                <td><span class="glyphicon glyphicon-trash"></span></td>
            </tr>
            <tr>
                <td><input type="checkbox"></td>
                <td>jackbender</td>
                <td>jb@gmail.com</td>
                <td>Bender</td>
                <td>Jack</td>
                <td>Membre (Adulte)</td>
                <td>14.04.1986 (27)</td>
                <td>LU983475789327</td>
                <td><span class="glyphicon glyphicon-pencil"></span></td>
                <td><span class="glyphicon glyphicon-trash"></span></td>
            </tr>
            <tr>
                <td><input type="checkbox"></td>
                <td>minjacob</td>
                <td>minjacob@gmail.com</td>
                <td>Minkowsky</td>
                <td>Jacob</td>
                <td>Membre (Jeune)</td>
                <td>06.06.2000 (13)</td>
                <td>LU736257843734</td>
                <td><span class="glyphicon glyphicon-pencil"></span></td>
                <td><span class="glyphicon glyphicon-trash"></span></td>
            </tr>
            <tr>
                <td><input type="checkbox"></td>
                <td>horst</td>
                <td>horstb@gmail.com</td>
                <td>Bierfass</td>
                <td>Horst</td>
                <td>Membre (Jeune)</td>
                <td>06.06.1999 (14)</td>
                <td>LU908430945589</td>
                <td><span class="glyphicon glyphicon-pencil"></span></td>
                <td><span class="glyphicon glyphicon-trash"></span></td>
            </tr>
            <tr>
                <td><input type="checkbox"></td>
                <td>dwarnimo</td>
                <td>d.warnimont@gmail.com</td>
                <td>Warnimont</td>
                <td>Daniel</td>
                <td>Membre (Adulte)</td>
                <td>16.11.1990 (23)</td>
                <td>LU023878594334</td>
                <td><span class="glyphicon glyphicon-pencil"></span></td>
                <td><span class="glyphicon glyphicon-trash"></span></td>
            </tr>
            <tr>
                <td><input type="checkbox"></td>
                <td>jgarcia</td>
                <td>john@gmail.com</td>
                <td>Garcia</td>
                <td>John</td>
                <td>Membre (Adulte)</td>
                <td>23.09.1984 (29)</td>
                <td>LU309684922344</td>
                <td><span class="glyphicon glyphicon-pencil"></span></td>
                <td><span class="glyphicon glyphicon-trash"></span></td>
            </tr>
            <tr>
                <td><input type="checkbox"></td>
                <td>jackbender</td>
                <td>jb@gmail.com</td>
                <td>Bender</td>
                <td>Jack</td>
                <td>Membre (Adulte)</td>
                <td>14.04.1986 (27)</td>
                <td>LU983475789327</td>
                <td><span class="glyphicon glyphicon-pencil"></span></td>
                <td><span class="glyphicon glyphicon-trash"></span></td>
            </tr>
            <tr>
                <td><input type="checkbox"></td>
                <td>minjacob</td>
                <td>minjacob@gmail.com</td>
                <td>Minkowsky</td>
                <td>Jacob</td>
                <td>Membre (Jeune)</td>
                <td>06.06.2000 (13)</td>
                <td>LU736257843734</td>
                <td><span class="glyphicon glyphicon-pencil"></span></td>
                <td><span class="glyphicon glyphicon-trash"></span></td>
            </tr>
            <tr>
                <td><input type="checkbox"></td>
                <td>horst</td>
                <td>horstb@gmail.com</td>
                <td>Bierfass</td>
                <td>Horst</td>
                <td>Membre (Jeune)</td>
                <td>06.06.1999 (14)</td>
                <td>LU908430945589</td>
                <td><span class="glyphicon glyphicon-pencil"></span></td>
                <td><span class="glyphicon glyphicon-trash"></span></td>
            </tr>
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
