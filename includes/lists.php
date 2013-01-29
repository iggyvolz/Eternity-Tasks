<?php
 






/**
	* AJAX caller: task_show_details()
	* Parameters
		* $id - sent through ajax as task, but php sends it as id for the id of the task.
		* $db - sent through the function as $db to help access the database.
	*
	* This function retrieves and displays important details about the specified task given the id parameter.
*/



/**
	* AJAX caller: task_edit_details_done()
	* Parameters
		* $description - sent through ajax as description, and it is used as the new description for updating.
		* $id - sent through ajax as task, but php sends it as id for the id of the task.
		* $db - sent through the function as $db to help access the database.
	*
	* This function updates, retrieves, and displays important details about the specified task given the id parameter.
*/










function la_check($db)
{
	$query = $db->query("SELECT * FROM tasks_activity ORDER BY `id` DESC LIMIT 20");
	while($row = $db->create_array($query))
	{
		?>
		<div class="la-row" ><a href="http://eternityinc-official.com/users/<?php echo $row['username']; ?>"><?php echo $row['username']; ?></a> <?php echo $row['activity']; ?></div>
		<?php
	}
	die;
}



function search($query, $db)
{
		$id = $db->query("SELECT * FROM `tasks_lists` WHERE name LIKE '%" . $db->escape($query) . "%' ORDER BY `id` DESC");
		while($row = $db->create_array($id))
		{
				?>
				<div class="yl-row" onmouseover="yl_row_links('<?php echo $row['id']; ?>');" onmouseout="hide_yl_row_links('<?php echo $row['id']; ?>');"><a href="/lists/view/<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a> by <?php echo $row['creator']; ?><span id="<?php echo $row['id']; ?>links" style="display: none; float: right;">
				<?php 
					// retrieve if favorited 
					$favorite = "SELECT `username` FROM tasks_favorites WHERE `list`='" . $db->escape($row['id']) . "' AND `username`='" . $db->escape($_SESSION['username'])	. "'  LIMIT 1";
					if($db->num_rows($db->query($favorite)) > 0)
					{
						echo '<a id="' . $row['id'] . 'favorite" href="javascript:list_remove_favorite(\'' . $_SESSION['username'] . '\', \'' . $row['id'] . '\',\'' . $row['public'] . '\')">unFavorite</a> | ';
					}
					else
					{
						echo '<a id="' . $row['id'] . 'favorite" href="javascript:list_add_favorite(\'' . $_SESSION['username'] . '\', \'' . $row['id'] . '\', \'' . $row['public'] . '\')">Favorite</a> | ';
					}
				?>
					<a href="javascript:list_delete_confirm('<?php echo $row['id']; ?>');">Delete</a></span></div>
				<?
			}
			die;
}



