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


 
	 
if(!empty($_POST)) {
	$db->query("INSERT INTO tasks_projects (`name`, `description`, `date`, `public`, `username`) VALUES ('" . $db->escape($_POST['name']) . "', '" . $db->escape($_POST['description']) . "', NOW(), '" . $db->escape($_POST['public']) . "', '" . $db->escape($_SESSION['username']) . "')");
	$key = rand();
	
	$number = $db->fetch($db->query("SELECT `id` FROM tasks_projects WHERE `id`=LAST_INSERT_ID()"));
	
		$staff = $_POST['staff'];
	
		foreach($staff as $person)
		{
			/**
			 * Email -------------- fix later --------------- 
			 */
			$db->query("INSERT INTO tasks_projects_keys (`key`, `accepted`, `username`) VALUES ('" .  $key . "', 'no', '" . $db->escape($person) . "')");
			$message = file_get_contents('http://tasks.eternityinc-official.com/includes/invite.tpl');
			$message = str_replace('<username>', $person, $message);
			$message = str_replace('<project>', $_POST['name'], $message);
			$message = str_replace('<creator>', $_SESSION['username'], $message);
			$message = str_replace('<id>', $number, $message);
			$message = str_replace('<key>', $key, $message);
			$from = "noreply@tasks.eternityinc-official.com";
			$to = $db->fetch($db->query("SELECT `email` FROM users WHERE username='" . $db->escape($person) . "'"));
			$subject = "Eternity Project Invite";
			$headers  = "From: $from\r\n";
			$headers .= "Content-type: text/html\r\n";
			mail($to, $subject, $message, $headers);
			
			/**
			 * Tasks Messaging System
			 */
			$db->query("INSERT INTO tasks_projects_invites (`username`,`projectID`) VALUES ('" . $db->escape($person) . "', '" . $db->escape($number) . "')"); 
		} 
	 
	 header("location:/projects");
	die;
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
	<title>Create a List / Eternity Tasks</title>
	<!--// End Title -->
	
	<!-- Assets -->
	<?php include 'includes/eternityx/assets.php'; ?>
	<link rel="stylesheet" href="/assets/style/projects.css" />
	<script>
		function tooltip(tip) {
			document.getElementById(tip+"-tooltip").style.opacity = "1";
		}
		
		function hidetooltip(tip) {
			document.getElementById(tip+"-tooltip").style.opacity = "0";
		}
	</script>
	<script type="text/javascript" src="/assets/js/overlay.js"></script>
	<!--// end Assets -->
</head>
<body>
	<?php include SRV_ROOT . '/apps/tasks/includes/eternityx/body-top.php'; ?>
	
	<!-- Main Content -->
	<div id="container">
		<div id="project-creation-interface">
			<div id="project-top">
				<h1>Eternity Projects</h1>
				<p>Description here....</p>
			</div>
			<form action="" method="post">
				<table cellspacing="0" cols="3">
					<tbody>
						<tr>
							<td>Name:</td>
							<td><input required type="text" name="name" placeholder="Name of your Project" onfocus="tooltip('name');" onblur="hidetooltip('name');" maxlength="20" /></td>
							<td id="name-tooltip" class="tooltip"><div class="arrow"></div><div  class="create-tooltip">Give your project a unique identifier in less than 20 characters.</div></td>
						</tr>
						<tr>
							<td>Description:</td>
							<td><textarea required name="description" style="vertical-align: top;" placeholder="Description of your Project" onfocus="tooltip('description');" onblur="hidetooltip('description');"></textarea></td>
							<td id="description-tooltip" class="tooltip"><div class="arrow"></div><div class="create-tooltip">Describe your Project for others to clearly understand what it is.</div></td>
						</tr>
						<tr>
							<td>Public:</td>
							<td><input type="radio" name="public" onfocus="tooltip('public');" value="yes" onblur="hidetooltip('public');">Yes <input type="radio" name="public" onfocus="tooltip('public');" value="no" onblur="hidetooltip('public');">No</td>
							<td id="public-tooltip" class="tooltip"><div class="arrow"></div><div class="create-tooltip">Decide whether or not you want this project to be seen by the public.</div></td>
						</tr>
						<tr>
							<td>Project Staff:</td>
							<td>
								<select required name="staff[]" multiple="multiple" style="vertical-align: top;" onfocus="tooltip('staff');" onblur="hidetooltip('staff');">
									<?php 
									$people = $db->query("SELECT * FROM users");
									while($row = $db->create_array($people))
									{
										?>
										<option value="<?php echo $row['username']; ?>"><?php echo $row['username']; ?></option>
										<?
									}									
									?>
								</select>
							</td>
							<td id="staff-tooltip" class="tooltip"><div class="arrow"></div><div class="create-tooltip">Select the people who you want to participate in this project.</div></td>
						</tr>
						<tr>
							<td colspan="3" style="text-align: center;"><input type="submit" value="Create!" /></td>
						</tr>
					</tbody>
				</table>
				 
				

				
			</form>
		</div>
	</div>
	<!--// end Main Content -->
	
	<?php include SRV_ROOT . '/apps/tasks/includes/eternityx/body-bottom.php'; ?>
</body>
</html>

<?php
/* END OF FILE */