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
	* for ajax functions, please see /assets/js/lists_ajax/list-top.js
*/


/** 
	* AJAX CALLER: list_update_title()
	*
	* PARAMETERS:
	* $title - the updated value for the new title
	* $id - the value of the list's id
 	* $db - the database instance to use 	
	*
	* DESCRIPTION:
	* This function communicates with JS via AJAX to update the title of a list
	*
*/
function list_update_title($title, $id, $db)
{
	$db->query("UPDATE tasks_lists SET `name`='" . $db->escape($title) . "' WHERE `id`='" . $db->escape($id) . "'");
	$new_title = $db->fetch($db->query("SELECT `name` FROM tasks_lists WHERE `id`='" . $db->escape($id) . "'"));
	echo stripslashes($new_title); 
	die;
}   


/** 
	* AJAX CALLER: list_update_description()
	*
	* PARAMETERS:
	* $description - the updated value for the new title
	* $id - the value of the list's id
 	* $db - the database instance to use 	
	*
	* DESCRIPTION:
	* This function communicates with JS via AJAX to update the description of a list
	*
*/
function list_update_description($description, $id, $db)
{
	$db->query("UPDATE tasks_lists SET `description`='" . $db->escape($description) . "' WHERE `id`='" . $db->escape($id) . "'");
	$new_description = $db->fetch($db->query("SELECT `description` FROM tasks_lists WHERE `id`='" . $db->escape($id) . "'"));
	echo stripslashes($new_description); 
	die;
}   