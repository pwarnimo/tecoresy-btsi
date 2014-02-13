<?php
    include "inc/whitelists/whitelist.inc.php";

    function __autoload($class_name) {
        require_once "inc/classes/" . $class_name . ".class.php";
    }
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

        <script src="js/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>
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
                    <a class="navbar-brand" href="index.php">TECORESY</a>
                </div>
                <div class="navbar-collapse collapse">
                    <!--<ul class="nav navbar-nav">
                        <li class="active"><a href="index.php"><span class="glyphicon glyphicon-refresh"></span> Actualiser</a></li>

                    </ul>-->
                    <button type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-refresh"></span> Actualiser</button>
                    <button type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-plus-sign"></span> Ajouter</button>
                    <button type="button" class="btn btn-default navbar-btn"><span class="glyphicon glyphicon-pencil"></span> Modifier</button>
                    <button type="button" class="btn btn-danger navbar-btn navbar-right"><span class="glyphicon glyphicon-trash"></span> Supprimer</button>
                </div><!--/.navbar-collapse -->
            </div>
        </div>

        <div id="wrapper">
            <div id="sidebar-wrapper">
                <ul class="sidebar-nav">
                    <li class="norm"><a href="index.php"><span class="glyphicon glyphicon-home"></span> Page d'acceuil</a></li>
                    <li></li>
                    <li class="norm"><a href="#"><span class="glyphicon glyphicon-tags"></span> Terrains</a></li>
                    <li class="norm"><a href="#"><span class="glyphicon glyphicon-book"></span> Reservations</a></li>
                    <li class="norm"><a href="#"><span class="glyphicon glyphicon-credit-card"></span> Factures</a></li>
                    <li class="norm linkact"><a href="#"><span class="glyphicon glyphicon-user"></span> Utilisateurs</a></li>
                    <li></li>
                    <li class="norm"><a href="#"><span class="glyphicon glyphicon-cog"></span> Settings</a></li>
                </ul>
            </div>
            <div id="page-content-wrapper">
                <div class="page-content">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                    $page = filter_input(INPUT_GET, "page");

                                    if ($page != false) {
                                        if (in_array($page, $whitelist)) {
                                            include("inc/pages/" . $page . ".inc.php");
                                        }
                                        else {
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

        <footer id="colophon">
            <p>Tennis Court Reservation System Admin Panel <strong>PROTOTYPE</strong>, Copyright &copy; 2014 Warnimont Pol</p>
        </footer>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.10.1.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/vendor/jquery.dataTables.min.js"></script>

        <script src="js/main.js"></script>

        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>
