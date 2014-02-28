<?php
$action = filter_input(INPUT_GET, "action");

switch ($action) {
    case "addUser" :
        echo filter_input(INPUT_POST, "data");

        break;
}