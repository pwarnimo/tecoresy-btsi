<?php

/*
 * TECORESY Admin panel 1.0
 *
 * File : logout.php
 * Description :
 *   This is page contains the logout function.
 *   This page is obsolete because we are using the logout function of the public interface from Philippe.
 */

session_start();
session_destroy();

header("Location: index.php");