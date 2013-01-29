<?php
/**
	* Eternity Tasks 3.0 [EternityX app/addon]
	* http://tasks.eternityinc-official.com
	*
	* (C) 2013 Eternity Incurakai Studios, All Rights Reserved
	* Licensed under the ESCLv1 License
	* http://eternityinc-official.com/license
*/



/**
	* This file includes functions that are used to operate on AJAX for the 
	* lists viewer (http://tasks.eternityinc-official.com/lists/view/##)
	* file: /list_view.php
	* for PHP functions, please see /includes/lists/list-tasks.php
*/


/** 
	* AJAX CALLER: list_delete_task()
	*
	* PARAMETERS:
	* $id - the task that is being deleted
 	* $db - the database instance
	* 
	* DESCRIPTION:
	* This function communicates with JS via AJAX to delete the specified task
	*
*/

function list_delete_task($id, $db)
{
	$db->query("DELETE FROM tasks_tasks WHERE `id`='" . $db->escape($id) . "'");
	die;
}


/** 
	* AJAX CALLER: task_to_no()
	*
	* PARAMETERS:
	* $id - the task that is being marked as incomplete
 	* $db - the database instance
	* 
	* DESCRIPTION:
	* This function communicates with JS via AJAX to mark as incomplete
	*
*/

function task_to_no($id, $db)
{
	$db->query("UPDATE tasks_tasks SET `complete`='no' WHERE `id`='" . $db->escape($id) . "'");
	die;
}


/** 
	* AJAX CALLER: task_to_yes()
	*
	* PARAMETERS:
	* $id - the task that is being marked as complete
 	* $db - the database instance
	* 
	* DESCRIPTION:
	* This function communicates with JS via AJAX to mark as complete
	*
*/

function task_to_yes($id, $db)
{
	$db->query("UPDATE tasks_tasks SET `complete`='yes' WHERE `id`='" . $db->escape($id) . "'");
	die;
}


/** 
	* AJAX CALLER: task_update_title()
	*
	* PARAMETERS:
	* $title - the new title value
 	* $id - the id of the task
 	* $db - the database instance  
	* 
	* DESCRIPTION:
	* This function communicates with JS via AJAX to update the title
	*
*/

function task_update_title($title, $id, $db)
{	
	if(strlen($title) <= 2)
	{
		$db->query("UPDATE tasks_tasks SET `name`='Click to Edit' WHERE `id`='" . $db->escape($id) . "'");
		die("Title Must Be at least 3 Characters");
	}
	$db->query("UPDATE tasks_tasks SET `name`='" . $db->escape($title) . "' WHERE `id`='" . $db->escape($id) . "'");
	$new_name = $db->fetch($db->query("SELECT `name` FROM tasks_tasks WHERE `id`='" . $db->escape($id) . "'"));
	echo $new_name;
	die;
}



/**
	* AJAX CALLER: task_show_details()
	*
	* PARAMETERS:
	* $id - the id of the task 
	* $author - the author of the list
 	* $username - the username of the current person
 	* $list - the list that the task is in  
 	* $db - the database instance 
	*
 	*  
	* DESCRIPTION:
	* This function communicates with JS via AJAX to show the details of a task.
	*
*/

function task_show_details($id, $author, $username, $list, $db)
{
	// check if the task still exists
	$test = $db->query("SELECT * FROM tasks_tasks WHERE `list`='" . $db->escape($list) . "' AND `id`='" . $db->escape($id) . "'");
	if(!$db->create_array($test))
	{
		
		die('<meta http-equiv="Refresh" content="3; url=" /> This Task does not exists anymore.  Please wait while the page refreshes.');
	}
	
	$new_description = $db->fetch($db->query("SELECT `description` FROM tasks_tasks WHERE `id`='" . $db->escape($id) . "'"));
	$date = $db->fetch($db->query("SELECT `date added` FROM tasks_tasks WHERE `id`='" . $db->escape($id) . "' "));
	$date = preg_replace('/(.*)-(.*)-(.*)/is', '$2/$3/$1', $date);
	$duedate1 = $db->fetch($db->query("SELECT `due date` FROM tasks_tasks WHERE `id`='" . $db->escape($id) . "'"));
	$duedate2 = preg_replace('/(.*)-(.*)-(.*)/is', '$2/$3/$1', $duedate1);
	
	$detail = 
		'<strong>Description: </strong>' . stripslashes($new_description) . '<br /><br />' . 
		'<strong>Date Added: </strong>' . stripslashes($date) . '<br /><br />' . 
		'<strong>Due Date: </strong>' . stripslashes($duedate2);
		
	if($author == $username)
	{
		$detail .= '<a class="icon" href="javascript:task_details_edit(\'' . $list . '\', \'' . stripslashes($id) .  '\',\'' . stripslashes($new_description) . '\',\'' . stripslashes($duedate1) . '\');"><img title="Edit" onmousedown="this.ondragstart = function() { return false; }" src="/assets/images/pencil.png" /></a>';
	}
	
	echo $detail; 
	die;
}


/**
	* AJAX CALLER: task_details_edit_done()
	*
	* PARAMETERS:
	* $description - the new description 
	* $date - the new due date
 	* $id - the id of the task
 	* $db - the database instance 
	*
 	*  
	* DESCRIPTION:
	* This function communicates with JS via AJAX to edit the details of a task.
	*
*/
function task_details_edit_done($description, $date, $id, $db)
{
	// update it
	$db->query("UPDATE tasks_tasks SET `description`='" . $db->escape($description) . "', `due date`='" . $db->escape($date) . "' WHERE `id`='" . $db->escape($id) . "'");
	
	$new_description = $db->fetch($db->query("SELECT `description` FROM tasks_tasks WHERE `id`='" . $db->escape($id) . "'"));
	$date = $db->fetch($db->query("SELECT `date added` FROM tasks_tasks WHERE `id`='" . $db->escape($id) . "' "));
	$date = preg_replace('/(.*)-(.*)-(.*)/is', '$2/$3/$1', $date);
	$duedate1 = $db->fetch($db->query("SELECT `due date` FROM tasks_tasks WHERE `id`='" . $db->escape($id) . "'"));
	$duedate2 = preg_replace('/(.*)-(.*)-(.*)/is', '$2/$3/$1', $duedate1);
	
	$detail = 
	'<strong>Description: </strong>' . stripslashes($new_description) . '<br /><br />' . 
	'<strong>Date Added: </strong>' . stripslashes($date) . '<br /><br />' . 
	'<strong>Due Date: </strong>' . stripslashes($duedate2);
	if($author == $username || $_SESSION['rank'] == "Eternity Team")
	{
		$detail .= '<a class="icon" href="javascript:task_details_edit(\'' . stripslashes($id) .  '\',\'' . stripslashes($new_description) . '\',\'' . stripslashes($duedate1) . '\');"><img onmousedown="this.ondragstart = function() { return false; }" src="/assets/images/pencil.png" /></a>';
	}
	
	echo $detail; 
	die;
}
