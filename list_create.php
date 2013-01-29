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
	
	$db->query("INSERT INTO tasks_lists (`name`, `description`, `date`, `creator`, `public`) VALUES ('" . $db->escape($_POST['name']) . "', '" . $db->escape($_POST['description']) . "', NOW(), '" . $_SESSION['username'] . "', '" . $db->escape($_POST['public']) . "')") or error(e0001, $db->error());
	$id = $db->fetch($db->query("SELECT `id` FROM tasks_lists WHERE `name`='" . $db->escape($_POST['name']) . "' AND `description`='" . $db->escape($_POST['description']) . "' AND `creator`='" . $_SESSION['username'] . "'"));
	if($_POST['public'] == 'yes')
	{
		$db->query("INSERT INTO tasks_activity (`username`, `activity`) VALUES ('" . $db->escape($_SESSION['username']) . "', 'created a <a href=\"/lists/view/" . $id . "\">new list</a>')");
	}
	
	header("location:/lists"); die;
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
	<!--// end Assets -->
</head>
<body>
	<?php include SRV_ROOT . '/apps/tasks/includes/eternityx/body-top.php'; ?>
	
	<!-- Main Content -->
	<div id="container">
		<?php include 'includes/interface/header.php'; ?>
		<form action="" method="post">
			<fieldset>
				<h1>Create a List</h1>
				<p>Create your own list on Eternity Tasks, to keep track of things you need to do, or accomplish!  With Eternity Tasks Lists, task-management is put into categories called lists, and it is made easier to keep track of what you need to do, and what you have already done.</p>
				
				<?php if($_SESSION['username']) { ?>	

				<div class="field">
					<div class="labelwrap"><label>Name:</label></div>
					<input required type="text" placeholder="Name your List" name="name"/>
				</div><br />
				
				<div class="field">
					<div class="labelwrap"><label>Public:</label></div>
					<input type="radio" name="public" value="yes" checked/> Yes <input type="radio" name="public" value="no"> No
				</div><br />
				
				<div class="field">
					<div class="labelwrap"><label>Description:</label></div>
					<textarea required name="description" placeholder="describe your list"></textarea>
				</div><br />
				
				<div class="actions">
					
					<input type="submit" value="Submit" />
				</div>
				<? } else { ?>
				<span style="display: block; text-align: center; margin: 15px;">Please Login to create an Eternity Tasks List</span>
				<? } ?>
			</fieldset>
		</form>
	</div>
	<!--// end Main Content -->
	
	<?php include SRV_ROOT . '/apps/tasks/includes/eternityx/body-bottom.php'; ?>
</body>
</html>

<?php
/* END OF FILE */