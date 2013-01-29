<?php

// include constants
/* Misc */
define("SRV_ROOT", dirname(dirname(dirname(dirname(dirname(__FILE__)))))); 
include_once SRV_ROOT . '/includes/constants.php';



 
// start the session, and output buffer
ob_start();
session_start();

// classes
include SRV_ROOT . '/classes/database.php'; 

// includes
include SRV_ROOT . '/includes/functions.php'; 
include SRV_ROOT . '/includes/maintenance.php'; 
include SRV_ROOT . '/includes/bans.php';
include SRV_ROOT . '/apps/tasks/includes/project_invites.php';

if($_SESSION['rank'] != "Eternity Team") {
	ob_end_clean();
	header('HTTP/1.1 403 Forbidden');
	include SRV_ROOT . "/errors/403.php"; die; 
}
