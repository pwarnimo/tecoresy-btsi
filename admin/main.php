<?php
/*
 * TECORESY Admin panel 1.0
 *
 * File : main.php
 * Description :
 *   This is page contains the main container for the single pages. Every page will be loaded inside the div with the
 *   id container.
 *   The single pages (Ex. invoices or users) are located in the inc/pages folder. Also, if you add a new page, you have
 *   to add the filename into the whitelist which is located in the inc/whitelist.inc.php file.
 *   This page also includes the javascript and css files for bootstrap, datatables and the layout for the page.
 */

    /* We are starting the session. We need this in order to check if the user is an administrator. We also store the
     * username, firstname as well the lastname inside the session.
     */
    session_start();

    include "inc/whitelists/whitelist.inc.php";
    include "inc/dbconfig.inc.php";

    // The autoload function is used in order to automatically load a class when we create an object.
    function __autoload($class_name) {
        require_once "inc/classes/" . $class_name . ".class.php";
    }

    /* We are creating a new user object here. Now we can check if the user is an administrator and if the login was
     * successful.
     */
    $user = new User();
    $user->checkLogin();
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>TECORESY Admin</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/jquery.dataTables.css">
        <link rel="stylesheet" href="css/smoothness/jquery-ui-1.10.4.custom.min.css">

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
        <![endif]-->
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="main.php">TECORESY</a>
                </div>
                <!-- This div defines the topbar of the site (The buttons for refreshing, adding, etc... are created here.). -->
                <div class="navbar-collapse collapse">
                    <!--<button id="btnRefr "type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-refresh"></span> Actualiser</button>-->
                    <button id="btnRefresh" type="button" class="btn btn-default navbar-btn btn-sm"><span class="glyphicon glyphicon-refresh"></span> Actualiser</button>
                    <button id="btnAdd" type="button" class="btn btn-default navbar-btn btn-sm"><span class="glyphicon glyphicon-plus-sign"></span> Ajouter</button>
                    <!--<button id="btnEdit" type="button" class="btn btn-default navbar-btn btn-sm"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>-->
                    <button id="btnHelp" type="button" class="btn btn-default navbar-btn btn-sm"><span class="glyphicon glyphicon-question-sign"></span> Aide</button>
                    <button id="btnDelete" type="button" class="btn btn-danger navbar-btn btn-sm"><span class="glyphicon glyphicon-trash"></span> Supprimer</button>
                    <button id="btnLogout" type="button" class="btn btn-default navbar-btn btn-sm navbar-right"><span class="glyphicon glyphicon-log-out"></span> D&eacute;connexion</button>
                </div><!--/.navbar-collapse -->
            </div>

            <!-- This div is used for the display of the help -->
            <div id="help-wrapper">
                <p>Aide sur les fonctions</p>
            </div>
        </div>

        <!-- This div is used for the sidebar from where we can access the pages (invoices, users, etc...). -->
        <div id="wrapper">
            <div id="sidebar-wrapper">
                <ul class="sidebar-nav">
                    <li id="main" class="norm"><a href="main.php"><span class="glyphicon glyphicon-home"></span> Page d'acceuil</a></li>
                    <li></li>
                    <li id="terrains" class="norm"><a href="main.php?page=terrainsv2"><span class="glyphicon glyphicon-tags"></span> Terrains</a></li>
                    <!--OBSOLETE<li id="reservations" class="norm"><a href="main.php?page=reservations"><span class="glyphicon glyphicon-book"></span> Reservations</a></li>-->
                    <li id="invoices" class="norm"><a href="main.php?page=invoices"><span class="glyphicon glyphicon-credit-card"></span> Factures</a></li>
                    <li id="users" class="norm"><a href="main.php?page=usersv2"><span class="glyphicon glyphicon-user"></span> Utilisateurs</a></li>
                    <li></li>
                    <li id="settings" class="norm"><a href="main.php?page=settings"><span class="glyphicon glyphicon-cog"></span> Configuration</a></li>
                </ul>
            </div>

            <!-- This section of divs is the heart of the page. The content of the pages will be loaded inside this divs -->
            <div id="page-content-wrapper">
                <div class="page-content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                    // This variable is used to determine which page we are going to load.
                                    $page = filter_input(INPUT_GET, "page");

                                    // If the page variable is not empty, then...
                                    if ($page != false) {
                                        // ... proceed to check if the whitelist contains the page.
                                        if (in_array($page, $whitelist)) {
                                            // If the page is in the whitelist, then load the contents.
                                            include("inc/pages/" . $page . ".inc.php");
                                        }
                                        else {
                                            // If the page is not in the whitelist, then show an error.
                                            include("inc/pages/error.inc.php");
                                        }
                                    }
                                    else {
                                        include("inc/pages/home.inc.php");
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- This section is used for loading the jquery and bootstrap plugins. -->
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/vendor/jquery.dataTables.min.js"></script>
        <script src="js/vendor/jquery-ui-1.10.4.custom.min.js"></script>
        <script src="js/vendor/jquery.contextmenu.js"></script>

        <script src="js/main.js"></script>

        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>
