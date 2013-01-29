<?php // TASK SUGGEST FILE (http://eternityinc-official.com/tasks)

/*******************************************************************************
* DO NOT REMOVE THIS COMMENT, IT CONTAINS IMPORTANT INFORMATION ABOUT THE FILE, 
* AND CAN VOID THE TERMS OF THE ESCLv1 LICENSE
*
*---------------------------------------------------------------------
*
* (C) Copyright 2012 Eternity Incurakai, All Rights Reserved.
* EternityX1 Project -- ALPHA release Stage
* Licensed under the ESCLv1 http://eternityinc-official.com/license
*
*----------------------------------------------------------------------
*
* Code by: XenoK Xihelien & P110
* support@eternityinc-official.com
*
*******************************************************************************/



/* import constants */
require "../../../includes/constants.php";

ob_start();			 
session_start();

/* include classes */
require SRV_ROOT . "/classes/database.php";

/* include files */
require SRV_ROOT . "/includes/functions.php";		
require SRV_ROOT . "/includes/maintenance.php";		
require SRV_ROOT . "/includes/bans.php"; 		


########## STARTING POINT ##########

/* Variables */
$username = $_SESSION['username'];
$userx = "P110";	
$rank = $_SESSION['rank'];
$form = $_POST['submit'];
$from = "The Eternity X system";	
$to = "P110";				
$subject = "New Suggested task for $_POST[for]";	
$message = $_POST['message'];
$subject_value = "New Suggested task for $_POST[for]";
$message_value = $_GET['message'];

if (isset($message_value))
{
	$message_value = stripslashes($message_value);
	$message_value = str_replace('<br />', "\n", $message_value);
}
	

/* 403 Access Forbidden Check */
if(!isset($username))
{
	ob_end_clean();
	header('HTTP/1.1 403 Forbidden');
	include SRV_ROOT . "/errors/403.php"; die;
}

/* Form Action */
if (isset($form))
{	
	$message = str_replace("\n", '[br /]', $message);
	
	// update database
	$db->query("INSERT INTO messages (`to`,`from`,`subject`,`message`) VALUES ('" . $db->escape($to) . "','" . $db->escape($from) . "','" . $db->escape($subject) . "','" . $db->escape($message) ."')"); // query
	
	$result = $db->query("SELECT email FROM users WHERE username='$to'");
	while($row = $db->create_array($result))
	{
		$to2 = $row['email'];
		$subject2 = "You've recieved a new message | Eternity Incurakai";
		$message2 = "
<html>
<head>
	<link rel=\"stylesheet\" href=\"http://eternityinc-official.com/assets/style/emails.css\" />
</head>
<body>
	<header><img src=\"http://eternityinc-official.com/assets/images/logo.png\" /><br />
	<h1>New Message</h1><p>You've received a new message!</p></header>
	<div class=\"body\"><div class=\"field\">You've recieved a new message on the Eternity Incurakai Site!  View your new message <a href=\"http://eternityinc-official.com/messages\">here!</a></div>
</body>
</html> 
";
		$headers  = "From: noreply@eternityinc-official.com\r\n";
		$headers .= "Content-type: text/html\r\n";
		$sent = mail($to2, $subject2, $message2, $headers);
	}
	
	// throw header information and exit
	header("location:http://eternityinc-official.com/apps/tasks/dash"); exit;
}

/* Username Input Type */
if($userx == "") // type is select
{
	$itype = "select";
}

else // type is text
{
	$itype = "text";
}

// start rendering the page
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Meta Data -->
	<meta name="google-site-verification" content="KM3qNLfR_vzATTWPTTLyMbZfl94PizuzOZinYt4e8GQ" /> 
	<meta charset="UTF-8" /> 
	<!--// End Meta Data -->
	
	<!-- Title -->
	<title>Task Suggest | Eternity Incurakai</title>
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
<body onload="document.compose.message.focus();">
	<!-- Header -->
	<?php include SRV_ROOT . "/includes/header.php"; ?>
	<!--// end Header -->
	
	<!-- Notifications -->
	<?php include SRV_ROOT . "/includes/notifications.php"; ?>
	<!--// end Notifications -->
	
	
           	<!-- Menu --> 
		<div class="menu"><a class="button" href="index.php" title="Dashboard">Dashboard</a>  |  <a class="button" href="map.php" title="Timezone Map">Timezone map</a>  |  <a class="button" href="notepad.php" title="Team notepad">Team notepad</a>  |  <a class="button" href="chat.php" title="Team chat">Team chat</a>  |  <a class="button" href="tasks.php" title="Tasks">My Tasks</a>  |  <?php if ("$_SESSION[username] = 'XenoK'" || "$_SESSION[username] = 'P110'") {echo "<a class=\"button\" href=\"admin.php\" title=\"Eternity Task Admin\">Tasks Admin</a>";} else{ echo " <a class=\"button active\" href=\"suggest.php\" title=\"Suggest task\">Suggest a task</a>";} ?></div>
		<!-- End Menu -->
                <!-- Main Content -->
                <div class="content">
                <h1>Suggest a task</h1>
                Here you can suggest a task for another member of the Eternity Team, an Eternity Admin will review this task then, will either contact you back<br/>add the task to that persons list, or refuse the task, in which case they will probably send you a message.<br/><br/>
		<!-- Form -->
		<form action="http://eternityinc-official.com/apps/tasks/dash/suggest.php?userx=<?php echo $username; ?>" name="compose" method="post">
			<fieldset>
				<legend align="left">Suggest a new task</legend>
				
				<div class="field">	
					<div class="labelwrap"><label for="for">Task for:</label></div>
					<?php 
							echo "<select id=\"for\" name=\"for\">";
							
							$result = $db->query("SELECT * FROM users WHERE rank='Eternity Team'"); // query
							while($row = $db->create_array($result))
								echo "<option value=\"" . $row['username'] . "\">" . $row['username'] . "</option>";
					?>
				</select></div><br /><br />
				
				<div class="field">
					<div class="labelwrap"><label for="message">Suggested Task:</label></div>
					<textarea required id="message" name="message"><?php if(isset($message_value)) { echo "\n\n\n" . '[quote=' . $userx . ']' . "\n" . '' . $message_value . '[/quote]'; } ?></textarea>
				</div><br /><br />
				
				<div class="actions">
					<input type="submit" value="Send" name="submit"/>
					<input type="button" value="Cancel" onclick="history.go(-1);" />
				</div>
			</fieldset>
		</form>
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

/* 
* file last modified: 10-07-2012 10:47 AM CDT by XenoK Xihelien, see http://eternityinc-official.com/logs/change/  for details
* END FILE: MESSAGE COMPOSE FILE (http://eternityinc-official.com/messages-compose/USERNAMEHERE)
*/