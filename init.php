<?php

	//Error Reporting 

ini_set('display_errors', 'On');
error_reporting(E_ALL);

include 'admin/connect.php';

$sessionUser = '';

if (isset($_SESSION['user'])){
	$sessionUser = $_SESSION['user'];
}

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





