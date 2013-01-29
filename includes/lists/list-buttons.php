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


/********************************************************* PRIVATE / PUBLIC *********************************************************************/

/** 
	* AJAX CALLER: list_to_private()
	*
	* PARAMETERS:
	* $list - the value of the list's id
 	* $db - the instance of the database class	
	*
	* DESCRIPTION:
	* This function communicates with JS via AJAX to set the list to private mode.
	*
*/

function list_to_private($list, $db)
{
	$db->query("UPDATE tasks_lists SET `public`='no' WHERE `id`='" . $db->escape($list) . "'");
	?>
		<div class="button" id="public-button" onmouseover="showtip('public-button');" onmouseout="hidetip('public-button');">
			<a id="public-button-button" class="button" href="javascript:list_to_public('<?php echo $list; ?>', 'public-button');"><img onmousedown="this.ondragstart = function() { return false; }" src="/assets/images/private.png" /></a>
			<div class="arrow-left" id="public-button-arrow-left"></div>
			<div class="tooltip" id="public-button-tooltip">Click to make Public</div>
		</div>
	<?
	die; 
}


/** 
	* AJAX CALLER: list_to_public()
	*
	* PARAMETERS:
	* $list - the value of the list's id
 	* $db - the instance of the database class	
	*
	* DESCRIPTION:
	* This function communicates with JS via AJAX to set the list to public mode.
	*
*/

function list_to_public($list, $db)
{
	$db->query("UPDATE tasks_lists SET `public`='yes' WHERE `id`='" . $db->escape($list) . "'");
	?>
		<div class="button" id="private-button" onmouseover="showtip('private-button');" onmouseout="hidetip('private-button');">
			<a id="private-button-button" class="button" href="javascript:list_to_private('<?php echo $list; ?>', 'private-button');"><img onmousedown="this.ondragstart = function() { return false; }" src="/assets/images/public.png" /></a>
			<div class="arrow-left" id="private-button-arrow-left"></div>
			<div class="tooltip" id="private-button-tooltip">Click to make Private</div>
		</div>
	<?
	die; 
}

/********************************************************* FAVORITE / UNFAVORITE *********************************************************************/


/** 
	* PHP LISTENER: list_remove_favorite()
	*
	* PARAMETERS:
	* $list - the value of the list's id
 	* $db - the database instance	
	*
	* DESCRIPTION:
	* This function communicates with JS via AJAX to unfavorite the list
	*
*/

function list_remove_favorite($list, $db)
{
	$db->query("DELETE FROM tasks_favorites WHERE `username`='" . $db->escape($_SESSION['username']) . "' AND `list`='" . $db->escape($list) . "'");
	?>
		<div class="button" id="favorite-button" onmouseover="showtip('favorite-button');" onmouseout="hidetip('favorite-button');">
			<a id="favorite-button-button" class="button" href="javascript:list_add_favorite('<?php echo $list; ?>', 'favorite-button');"><img onmousedown="this.ondragstart = function() { return false; }" src="/assets/images/favorite.png" /></a>
			<div class="arrow-left" id="favorite-button-arrow-left"></div>
			<div class="tooltip" id="favorite-button-tooltip">Click to Favorite</div>
		</div>
	<?
	die; 
}



/** 
	* PHP LISTENER: list_add_favorite()
	*
	* PARAMETERS:
	* $list - the value of the list's id
 	* $public - the public field value from the database of the given list 
 	* $db - the database instance	
	*
	* DESCRIPTION:
	* This function communicates with JS via AJAX to favorite the list
	*
*/

function list_add_favorite($list, $public, $db)
{
	$db->query("INSERT INTO tasks_favorites (`timestamp`, `username`, `list`) VALUES (NOW(), '" . $db->escape($_SESSION['username']) . "', '" . $db->escape($list) . "')") or error(e0001, $db->error());
	$name = $db->fetch($db->query("SELECT `name` FROM tasks_lists WHERE `id`='" . $db->escape($list) . "'"));
	?>
		<div class="button" id="unfavorite-button" onmouseover="showtip('unfavorite-button');" onmouseout="hidetip('unfavorite-button');">
			<a id="unfavorite-button-button" class="button" href="javascript:list_remove_favorite('<?php echo $list; ?>', 'unfavorite-button');"><img onmousedown="this.ondragstart = function() { return false; }" src="/assets/images/unfavorite.png" /></a>
			<div class="arrow-left" id="unfavorite-button-arrow-left"></div>
			<div class="tooltip" id="unfavorite-button-tooltip">Click to unFavorite</div>
		</div>
	<?
	
	
	if($public == 'yes')
	{
		$db->query("INSERT INTO tasks_activity (`username`, `activity`) VALUES ('" . $db->escape($_SESSION['username']) . "', ' favorited <a href=\"/lists/view/" . $db->escape($list) . "\">" . $db->escape($name) . "</a>')");
	}
	die; 
}



/********************************************************* ADD A TASK *********************************************************************/

/** 
	* AJAX CALLER: list_add_task()
	*
	* PARAMETERS:
	* $name - the name of the task to add
 	* $description - the description of the task to add
 	* $date - the due date of the task to add
 	* $list - the list to add the task to
 	* $lid - the id of the new task that is to show up in the new section
 	* $public - the public field of the LIST that the task it being added to. 
 	* $db - the instance of the database class 	 	
	*
	* DESCRIPTION:
	* This function communicates with JS via AJAX to add a new task to the list.
	*
*/

function list_add_task($name, $description, $date, $list, $lid, $public, $db)
{
	$list_name = $db->fetch($db->query("SELECT `name` FROM tasks_lists WHERE `id`='" . $db->escape($list) . "'"));
	$test = $db->query("SELECT * FROM tasks_tasks WHERE `list`='" . $db->escape($list) . "'");
	while($row = $db->create_array($test))
	{
		if($name == $row['name'])
		{
			die('<div class="newtask" id="new' . $lid . '">That Task Already exists</div>');
		}
	}
	
	if(!$description)
	{
		$description = " ";
	}
	
	$db->query("INSERT INTO tasks_tasks (`date added`, `name`, `description`, `list`, `due date`) VALUES (NOW(), '" . $db->escape($name) . "', '" . $db->escape($description) . "', '" . $db->escape($list) . "', '" . $db->escape($date) . "')");
	$new_tasks = $db->query("SELECT * FROM tasks_tasks WHERE `list`='" . $db->escape($list) . "' AND `name`='" . $db->escape($name) . "' AND `description`='" . $db->escape($description) . "'");
	while($row = $db->create_array($new_tasks))
	{
		?>
		<!-- New Task Added Indicator -->
		<div class="newtask" id="new<?php echo $lid; ?>">Task Added</div>
		
		<!-- New Task -->
		<div class="task" id="<?php echo $row['id']; ?>">
			
			<!-- Task Name and Checkbox -->
			<input id="<?php echo $row['id']; ?>check" type="checkbox"  <?php if ($row['complete'] == 'yes') { echo 'checked '; echo 'onclick="task_to_no(\'' . $list . '\', \'' . $row['id'] . '\');"'; } else { echo 'onclick="task_to_yes(\'' . $list . '\', \'' . $row['id'] . '\');"'; } ?> />
			<span class="name"><input id="<?php echo $row['id']; ?>name" type="text" value="<?php echo $row['name']; ?>" onblur="task_update_name('<?php echo $list; ?>', '<?php echo $row['id']; ?>', this.value);"/></span>
			
			<!-- Action Links -->
			<div class="links">
				<a id="<?php echo $row['id']; ?>button" class="icon" href="javascript:task_show_details('<?php echo $row['id']; ?>', '<?php echo $row['id']; ?>');"><img onmousedown="this.ondragstart = function() { return false; }" title="Show Details" src="/assets/images/arrow.png" /></a> 
				<a id="<?php echo $row['id']; ?>delete" title="Delete" class="icon" href="javascript:list_delete_task('<?php echo $list; ?>', '<?php echo $row['id']; ?>');"><img onmousedown="this.ondragstart = function() { return false; }" src="/assets/images/trash.png" alt="Delete" /></a>
			</div>
			
			<!-- Task Details -->
			<div class="details" id="<?php echo $row['id']; ?>details" style="display: none;"></div>
		</div>
		<?
	} 
	
	if($public == 'yes')
	{
		$db->query("INSERT INTO tasks_activity (`username`, `activity`) VALUES ('" . $db->escape($_SESSION['username']) . "', ' added a task to <a href=\"/lists/view/" . $db->escape($list) . "\">" . $db->escape($list_name) . "</a>')");
	}
	die;	
}


/********************************************************* LIST DELETION *********************************************************************/

/** 
	* AJAX CALLER: list_delete()
	*
	* PARAMETERS:
	* $list - the list that is being deleted
 	* $db - the database instance 
	* 
	* DESCRIPTION:
	* This function communicates with JS via AJAX to delete the list
	*
*/

function list_delete($list, $db)
{
	$db->query("DELETE FROM tasks_lists WHERE `id`='" . $db->escape($list) . "'");
	$db->query("DELETE FROM tasks_favorites WHERE `list`='" . $db->escape($list) . "'");
	echo '<meta http-equiv="refresh" content="0; url=http://tasks.eternityinc-official.com/lists" />';
	die; 
}
