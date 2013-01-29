<?php
/**
	* Eternity Tasks 3.0 [EternityX app/addon]
	* http://tasks.eternityinc-official.com
	*
	* (C) 2013 Eternity Incurakai Studios, All Rights Reserved
	* Licensed under the ESCLv1 License
	* http://eternityinc-official.com/license
*/

// import eternityx php lines
include 'includes/eternityx/php.php';



/* Form Action */
if(!empty($_POST))
{
	
	$db->query("INSERT INTO tasks_code (`name`, `Created_by`, `Created_on`, `Shared_w`, `Html`) VALUES ('" . $db->escape($_POST['name1']) . "', '" . $_SESSION['username'] . "','NOW()', '" . $db->escape($_POST['share_w']) . "', '<div style=\"font-family:Calibri,Arial\">Your code will appear in this frame</div>')") or error(e0001, $db->error());
	
	header("location:http://tasks.eternityinc-official.com/code_collab"); die;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Meta Data -->
	<?php include 'includes/eternityx/meta.php'; ?>
	
	<!--<meta name="author" content="Eternity Incurakai" /> 
	<meta name="description" content="Team tasks system" /> 
	<meta name="keywords" content="All if the team can collaborate here" /> -->
	<!--// End Meta Data -->
	
	<!-- Title -->
	<title>Start new code / Eternity Tasks</title>
	<!--// End Title -->
	
	<!-- Assets -->
	<?php include 'includes/eternityx/assets.php'; ?>
	<!--// end Assets -->
</head>
<body>
	<?php include SRV_ROOT . '/apps/tasks/includes/eternityx/body-top.php'; ?>
	
	<!-- Main Content -->
	<div id="container">

		<form action="" method="post">
			<div class="fieldset-2" style="text-align:center;">
				<h1>Create a new code collaboration</h1>
				<p>Create a new code collab project here. So you can collaborate with friends or colleagues to create your code.</p>
				
				<?php if($_SESSION['username']) { ?>	

				<div class="field-2">
					<div class="labelwrap"><label>Code Name:</label></div>
					<input id="name1" required="" type="text" placeholder="Name your project" name="name1"/>
				</div><br />

				<div class="field-2">
					<div class="labelwrap"><label>Shared with?:</label></div>
					<input id="share_w" required="" type="text" placeholder="Separated by a comma" name="share_w"/>
				</div><br />
				
				
				<div class="actions">
					
					<input type="submit" value="Submit" />
				</div>
				<? } else { ?>
				<span style="display: block; text-align: center; margin: 15px;">Sorry, you have got to sign into the EX1 system to use our apps</span>
				<? } ?>
			</div>
		</form>
	</div>
	<!--// end Main Content -->
	
	<?php include SRV_ROOT . '/apps/tasks/includes/eternityx/body-bottom.php'; ?>
</body>
</html>

<?php
/* END OF FILE */