<?php 
/*******************************************************************************
* DO NOT REMOVE THIS COMMENT, IT CONTAINS IMPORTANT INFORMATION ABOUT THE FILE, 
* AND CAN VOID THE TERMS OF THE ESCLv1 LICENSE
*
*---------------------------------------------------------------------
*
* (C) Copyright 2012 Eternity Incurakai, All Rights Reserved.
* EternityX1 Project 
* Licensed under the ESCLv1 http://eternityinc-official.com/license
*
*----------------------------------------------------------------------
*
* Code by: XenoK Xihelien & P110
* support@eternityinc-official.com
*
*----------------------------------------------------------------------
*
* This is the file that team members will use to get team news, post team updates,
* Navigate to team privelege files, and use their permissions to an effective level.
* This file uses a couple of variables:
*
* SRV_ROOT	-	defines the root directory
* $db		- 	used to access and manage the database
* $username	-	defines the current session's username value
* $rank		-	defines the current session's rank value
* $form		-	stores the POST value of the submit button
* $notepad	-	stores the value of the notepad textarea contents
*
*******************************************************************************/ 
include "../../../includes/constants.php";	# imports constants, and sets initialization variables

ob_start();			 
session_start();	// must be placed AFTER the ob_start(); and including of constants

/* include classes */
require SRV_ROOT . "/classes/database.php";

/* include files */
include SRV_ROOT . "/includes/functions.php";		
include SRV_ROOT . "/includes/maintenance.php";		
include SRV_ROOT . "/includes/bans.php"; 	

########## STARTING POINT ##########

/* Variables */
$username = $_SESSION['username'];
$rank = $_SESSION['rank'];
$form = $_POST['submit'];
$notepad = $_POST['notepad'];

/* 403 Check */
if(!isset($username) || $rank != "Eternity Team") 
{  
	ob_end_clean();
	header('HTTP/1.1 403 Forbidden');
	include SRV_ROOT . "/errors/403.php"; die;
} 
 
/* Form Actions */
if(isset($form))
{
	$db->query("UPDATE tasks_content SET content='" . $db->escape($notepad) . "' WHERE name='notepad'"); // query
}

/* Unset Form Actions */
else
{ 	
	// set notepad variable
	$notepad = stripslashes(stripslashes($db->fetch($db->query("SELECT content FROM tasks_content WHERE name='notepad'"))));	// at least two stripslashes seem to get the job done.  
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Meta Data -->
	<meta name="google-site-verification" content="KM3qNLfR_vzATTWPTTLyMbZfl94PizuzOZinYt4e8GQ" /> 
	<meta charset="UTF-8" />
	<!--// End Meta Data -->
	
	<!-- Title -->
	<title>Team Notepad | Eternity Incurakai</title>
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
	<?php include SRV_ROOT . "/includes/header.php"; ?>
	<!--// end Header -->
	
	<!-- Notifications -->
	<?php include SRV_ROOT . "/includes/notifications.php"; ?>
	<!--// end Notifications -->
	
	<!-- Main Content -->
	<div id="container">
		<!-- Navigation -->
           	<!-- Menu --> 
		<div class="menu"><a class="button" href="index.php" title="Dashboard">Dashboard</a>  |  <a class="button" href="map.php" title="Timezone Map">Timezone map</a>  |  <a class="button active" href="notepad.php" title="Team notepad">Team notepad</a>  |  <a class="button" href="chat.php" title="Team chat">Team chat</a>  |  <a class="button" href="tasks.php" title="Tasks">My Tasks</a>  |  <?php if ("$_SESSION[username] = 'XenoK'" || "$_SESSION[username] = 'P110'") {echo "<a class=\"button\" href=\"admin.php\" title=\"Eternity Task Admin\">Tasks Admin</a>";} else{ echo " <a class=\"button\" href=\"suggest.php\" title=\"Suggest task\">Suggest a task</a>";} ?></div>
		<!-- End Menu -->
		<!--// end Navigation -->

		<!-- Description -->
		<section>
			<h1>Team Notepad | Eternity Incurakai</h1>
			<p>Welcome to the team notepad, here is a small section of text where all of the team can talk, this is experimental and may get removed if too cluttered.</p>
		</section>
		
		
		<!-- Team Notepad -->
		<div class="notepad">
			<h2>Team Notepad</h2>
			<form action="http://eternityinc-official.com//apps/tasks/dash/notepad.php" method="post">
				<textarea name="notepad"><?php echo stripslashes($notepad); // only seems to work with three stipslashes ?></textarea>
				
				<div class="actions">
					<input type="submit" name="submit" value="Update" />
				</div>
			</form>
		</div>
	</div>
	<!--// end Main Content -->
	
	<!-- Sidebar -->
	<?php include SRV_ROOT . "/includes/sidebar.php"; ?>
	<!--// end Sidebar -->
	
	<!-- Footer -->
	<?php include SRV_ROOT . "/includes/footer.php"; ?>
	<!--// end Footer -->
</body>
</html>

<?php 

/* END OF FILE */