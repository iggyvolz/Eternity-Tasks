<?php
if($_POST['type'] == "projects_updatetitle") { projects_updatetitle($_POST['title']); }
if($_POST['type'] == "projects_updatedescription") { projects_updatedescription($_POST['description']); }
if($_POST['type'] == "projects_tab") { projects_tab($_POST['tabtype'], $db); }



/**
 * This function updates the project title within the project viewing page (project_view.php) used as a function to communicate with AJAX.
 * 
 * @param $title 	The new title of the project
 * @author XenoK Xihelien
 * @copyright 2012 Eternity Incurakai
 * 
 */
function projects_updatetitle($title) {
	
	/* Check for accurate username */
	if($GLOBALS['creator'] != $_SESSION['username']) {
		die;
	}
	
	/* mark globals to use, set variables */
	global $db;
	$original_title = $title;
	$length_error = 'Must be at least 3 characters in length.';
	$title_length = strlen($title);
	$report = time() . ':' . $_SESSION['username'] . "/" . $_SERVER['REMOTE_ADDR'] . ' changed the name of a project';
	$current_activity = file_get_contents('http://tasks.eternityinc-official.com/logs/activity.log') . "\n";

	/* Check the title value for inefficiency, must be 3 characters in length. */
	if(!isset($title) || $title_length < 3) {
		echo $length_error;
		die;
	}
	
	/* Check for Innappropriate words */
	include 'includes/censor.php';
	$title = censorstring($title);
	if($title != $original_title) { // this means that the censor found a bad word, let's report it.
		$db->query("INSERT INTO `reports` (`time`, `reported user`, `reporting user`, `reason`) VALUES (NOW(), '" . $db->escape($_SESSION['username']) . "', 'Eternity Tasks', 'The user tried to rename <a href=\"http://tasks.eternityinc-official.com/projects/" . $db->escape($_GET['id']) . "\">this project</a> with an innappropriate word in it.')");
		$fp = fopen('logs/activity.log', 'w');
		fwrite($fp, $current_activity . $report . " with an innappropriate word.");
		fclose($fp);
	}
	
	/* update the database and fetch the new value, add a description to the activity report */
	$db->query("UPDATE tasks_projects SET `name`='" . $db->escape($title) . "' WHERE `id`='" . $db->escape($_GET['id']) . "'");
	$title = $db->fetch($db->query("SELECT `name` FROM tasks_projects WHERE `id`='" . $db->escape($_GET['id']) . "'"));
	$fp = fopen('logs/activity.log', 'w');
	fwrite($fp, $current_activity . $report);
	fclose($fp);
	
	/* Fix the Value, and output the result */
	$title = trim($title);
	$title = stripslashes($title);
	$title = htmlspecialchars($title);
	echo $title;
	die;
}






/**
 * This function updates the project description within the project viewing page (project_view.php) used as a function to communicate with AJAX.
 * 
 * @param $description 	The new description of the project
 * @author XenoK Xihelien
 * @copyright 2012 Eternity Incurakai
 * 
 */
function projects_updatedescription($description) {
			
	/* Check for accurate username */
	if($GLOBALS['creator'] != $_SESSION['username']) {
		die;
	}
		
	/* mark globals to use, set variables */
	global $db;
	$description = str_replace(htmlspecialchars('<strong contenteditable="false">Description:</strong>'), ' ', $description);
	$original_description = $description;
	$length_error = 'Must be at least 3 characters in length.';
	$description_length = strlen($description);
	$report = time() . ':' . $_SESSION['username'] . "/" . $_SERVER['REMOTE_ADDR'] . ' updated the description of a project';
	$current_activity = file_get_contents('http://tasks.eternityinc-official.com/logs/activity.log') . "\n";
	
	/* Check the description value for inefficiency, must be 3 characters in length. */
	if(!isset($description) || $description_length < 3) {
		echo $length_error;
		die;
	}
	
	/* Check for Innappropriate words */
	include 'includes/censor.php';
	$description = censorstring($description);
	if($title != $original_title) { // this means that the censor found a bad word, let's report it.
		$db->query("INSERT INTO `reports` (`time`, `reported user`, `reporting user`, `reason`) VALUES (NOW(), '" . $db->escape($_SESSION['username']) . "', 'Eternity Tasks', 'The user tried to update the description of  <a href=\"http://tasks.eternityinc-official.com/projects/" . $db->escape($_GET['id']) . "\">this project</a> with an innappropriate word in it.')");
		$fp = fopen('logs/activity.log', 'w');
		fwrite($fp, $current_activity . $report . " with an innappropriate word.");
		fclose($fp);
	}
	
	
	/* update the database and fetch the new value, add a description to the activity report */
	$db->query("UPDATE tasks_projects SET `description`='" . $db->escape($description) . "' WHERE `id`='" . $db->escape($_GET['id']) . "'");
	$description = $db->fetch($db->query("SELECT `description` FROM tasks_projects WHERE `id`='" . $db->escape($_GET['id']) . "'"));
	$fp = fopen('logs/activity.log', 'w');
	fwrite($fp, $current_activity . $report);
	fclose($fp);
	
	/* Fix the Value, and output the result */
	$description = htmlspecialchars($description);
	$description = trim($description);
	$description = stripslashes($description);
	$description = str_replace(htmlspecialchars("&nbsp;"), "", $description);	
	$description = str_replace(htmlspecialchars('<strong contenteditable="false">Description:</strong>'), ' ', $description);
	echo $description;
	die;
	
}




function projects_tab($tabby, $db) {
	if($tabby == "details") {
		$description = $db->fetch($db->query("SELECT `description` FROM tasks_projects WHERE `id`='" . $db->escape($_GET['id']) . "'"));
		$description = trim($description);
		$description = htmlspecialchars($description);
		$description = stripslashes($description);
		if($GLOBALS['creator'] == $_SESSION['username']) {
			echo '<textarea id="description" onblur="projects_updatedescription(this.value, \'' . $_GET['id'] . '\');">' . stripslashes($description) . '</textarea>';
		}
		else {
			echo $description;
		}
		die;
	}
	else {
		echo 'error';
		die;
	}
	die;
}
