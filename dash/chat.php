<?php
/****************************************************************
*Eternity Tasks - EternityX1 app/addon [version 3.0]
*(C) Copyright 2012, Eternity Incurakai, All Rights Reserved
*----------------------------------------------------------------
* Licensed under the ESCLv1 License 
* (http://eternityinc-official.com/license)
*----------------------------------------------------------------
* This is the index file for the app. it uses a couple of variables:
*
* SRV_ROOT	-	defines the root directory of the website
* $db		- 	used to access and manage the database 
*
****************************************************************/
include '../../../includes/constants.php';	# imports constants, and sets initialization variables

ob_start();
session_start();	// must be placed AFTER the ob_start(); and including of constants

/* include classes */
include SRV_ROOT . '/classes/database.php';

/* include files */
include SRV_ROOT . '/includes/functions.php';
include SRV_ROOT . '/includes/maintenance.php';
include SRV_ROOT . '/includes/bans.php';

########## STARTING POINT ##########



?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Meta Data -->
	<meta name="google-site-verification" content="KM3qNLfR_vzATTWPTTLyMbZfl94PizuzOZinYt4e8GQ" />
	<meta charset="UTF-8" />
	<meta name="author" content="Eternity Incurakai" /> 
	<meta name="description" content="Team tasks system" /> 
	<meta name="keywords" content="All if the team can collaborate here" /> 
	<!--// End Meta Data -->
	
	<!-- Title -->
	<title>Team Chat | Eternity Incurakai</title>
	<!--// End Title -->
	
	<!-- Assets -->
	<link rel="stylesheet" href="http://eternityinc-official.com/assets/style/style.css" /> 
	<link rel="icon" type="image/png" href="http://eternityinc-official.com/assets/images/favicon.png" /> 
	<link rel="apple-touch-icon" href="http://eternityinc-official.com/assets/images/touchicon.png" /> 
	<script src="http://eternityinc-official.com/assets/js/behavior.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
        <script type="text/javascript" src="http://eternityinc-official.com/apps/tasks/dash/chat/lightIRC/config.js"></script>
	<!--// End Assets -->
	

	<!-- Google Analytics -->
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-28493253-3']);
		_gaq.push(['_setDomainName', 'eternityinc-official.com']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
	<!--// End Google Analytics -->
</head>
<body>
	<!-- Header -->
	<?php include SRV_ROOT . '/includes/header.php'; ?>
	<!--// end Header -->
	
	<!-- Notifications -->
	<?php include SRV_ROOT . '/includes/notifications.php'; ?>
	<!--// end Notifications -->
	
	<!-- Main Content -->
	<div id="container">
           	<!-- Menu --> 
		<div class="menu"><a class="button" href="index.php" title="Dashboard">Dashboard</a>  |  <a class="button" href="map.php" title="Timezone Map">Timezone map</a>  |  <a class="button" href="notepad.php" title="Team notepad">Team notepad</a>  |  <a class="button active" href="chat.php" title="Team chat">Team chat</a>  |  <a class="button" href="tasks.php" title="Tasks">My Tasks</a>  |  <?php if ("$_SESSION[username] = 'XenoK'" || "$_SESSION[username] = 'P110'") {echo "<a class=\"button\" href=\"admin.php\" title=\"Eternity Task Admin\">Tasks Admin</a>";} else{ echo " <a class=\"button\" href=\"suggest.php\" title=\"Suggest task\">Suggest a task</a>";} ?></div>
		<!-- End Menu -->
                <h1>Team Chat</h1>
		<p>Welcome to the chat for the Eterntiy Team, here you can chat with all other members of the Eternity team, that are currently online. Please note: It can take a while to load, it can sometimes LOOK like it has called an error, enjoy! Scroll down \ /</p>
                  <div id="lightIRC" style="height:100%; text-align:center;">
                  <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
                  </div>
 
                  <script type="text/javascript">
                      	swfobject.embedSWF("http://eternityinc-official.com/apps/tasks/dash/chat/lightIRC/lightIRC.swf", "lightIRC", "100%", "500px", "10.0.0", "http://eternityinc-official.com/apps/tasks/dash/chat/lightIRC/expressInstall.swf", params);
                   </script>
 
	</div>
	<!--// end Main Content -->
	
	<!-- Sidebar -->
	<?php include SRV_ROOT . '/includes/sidebar.php'; ?>
	<!--// end Sidebar -->
	
	<!-- Footer -->
	<?php include SRV_ROOT . '/includes/footer.php'; ?>
	<!--// end Footer -->
</body>
</html>

<?php
/* END OF FILE */