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
	<title>View tasks | Eternity Incurakai</title>
	<!--// End Title -->
	
	<!-- Assets -->
	<link rel="stylesheet" href="http://eternityinc-official.com/assets/style/style.css" /> 
	<link rel="icon" type="image/png" href="http://eternityinc-official.com/assets/images/favicon.png" /> 
	<link rel="apple-touch-icon" href="http://eternityinc-official.com/assets/images/touchicon.png" /> 
	<script src="http://eternityinc-official.com/assets/js/behavior.js"></script>
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
		<div class="menu"><a class="button" href="index.php" title="Dashboard">Dashboard</a>  |  <a class="button" href="map.php" title="Timezone Map">Timezone map</a>  |  <a class="button" href="notepad.php" title="Team notepad">Team notepad</a>  |  <a class="button" href="chat.php" title="Team chat">Team chat</a>  |  <a class="button active" href="tasks.php" title="Tasks">My Tasks</a>  |  <?php if ("$_SESSION[username] = 'XenoK'" || "$_SESSION[username] = 'P110'") {echo "<a class=\"button\" href=\"admin.php\" title=\"Eternity Task Admin\">Tasks Admin</a>";} else{ echo " <a class=\"button\" href=\"suggest.php\" title=\"Suggest task\">Suggest a task</a>";} ?></div>
		<!-- End Menu -->
		<h1>Tasks | Eternity Incurakai</h1>
		<p>Here all  of your tasks will be displayed, with status, you can also declare your task as finished for an admin to review.<br/>Also in the new system you can see the amount of EP you will be rewarded when you complete the task.</p>
                <?php
         //VARIABLES
         $username = $_SESSION[username];
         $result = $db->query("SELECT * FROM `tasks` WHERE for='$username'");

	echo '<table id="userst"><tr>
		<th>Task</th>
                <th>EP to receive when complete</th>
		<th>Status</th>
	</tr>';

// fetch profile variables
while($row = $db->create_array($result))
{
		echo "<tr>";
		echo 	"<td>" . $row['task'] . "</td>";
		echo 	"<td>" . $row['worth'] . "</td>";
		echo 	"<td>" . $row['status'] . "</td>";

		echo "</tr>";
}
                echo "</table>";
?>
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