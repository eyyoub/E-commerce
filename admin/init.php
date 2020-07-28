<?php

include 'connect.php';
// Routes : masarat

$tpl = 'includes/templates/'; //Template Directory
$css = 'Design/css/';
$js = 'Design/js/';
$lng = 'includes/languages/';
$func = 'includes/functions/';

// Include The Important Files

include $func . 'function.php';
include $lng . 'english.php';
include $tpl . 'header.php'; 

// Include Navbar On All Pages Expect The One With $noNavbar Variable

if (!isset($noNavbar)) { include $tpl . 'navbar.php'; }



