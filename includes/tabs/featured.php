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
	* featured tab in the lists index (http://tasks.eternityinc-official.com/lists)
	* file: /list_index.php
	* for javascript/AJAX functions, please see /assets/js/featured.js
*/


/** 
	* AJAX CALLER: featured_display()
	*
	* PARAMETERS:
	* $db - used as the database class
	*
	* DESCRIPTION:
	* This function displays the featured tab's list.  
	*
*/
function featured_display($db)
{
	/* HEADER */
	?>
       	<h2><img src="/assets/images/spotlight.png" style="vertical-align: middle;"/>Featured Tasks Lists</h2>
    <?php
	
	/* START OUTPUTTING FEATURED */
	$id = $db->query("SELECT * FROM `tasks_lists-featured`");
	while($row2 = $db->create_array($id))
	{
		$query = $db->query("SELECT * FROM tasks_lists WHERE `id`='" . $db->escape($row2['list']) . "'");
		while($row = $db->create_array($query))
		{
			/* CHECK TO SEE IF THERE AREN'T ANY FEATURED LISTS */
			$number = $db->num_rows($db->query("SELECT `id` FROM tasks_tasks WHERE `list`='" . $db->escape($row2['list']) . "'"));
			if($number == 0)
			{
				echo 'There are currently no featured lists.'; die;
			}
			
			/* THERE ARE, LETS MOVE ON AND OUTPUT */
			?>
			<div class="featured-row" onmouseover="featured_row_description('<?php echo $row['id']; ?>'); <?php if($_SESSION['rank'] == "Eternity Team") { echo 'featured_row_show_remover(' . $row['id'] . ');'; } ?>" onmouseout="hide_featured_row_description('<?php echo $row['id']; ?>');<?php if($_SESSION['rank'] == "Eternity Team") { echo 'featured_row_hide_remover(' . $row['id'] . ');'; } ?>">
				<div class="featured-row-tasks">
					<span class="number"><?php echo $number; ?></span>
					<span class="label">Tasks</span>
				</div>
				
				<span id="<?php echo $row['id']; ?>description" class="description"><?php echo $row['description']; ?></span>
				<span class="name"><a href="/lists/view/<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></span>
				<span class="author">by <?php echo $row['creator']; ?></span>
				
				<?
					/* ADMIN CAPABILITIES HERE IF RANK IS EQUAL TO ETERNITY TEAM.
						* note: please do not add functionality for retired eternity team members, they should not be allowed this.
					*/
					if($_SESSION['rank'] == "Eternity Team")
					{ 
						?>
							<div class="remove-from-featured" style="display: none;" id="<?php echo $row['id']; ?>Remove"><a href="javascript:featured_remove('<?php echo $row['id']; ?>');">Remove From Featured</a></div>
						<?
					}
				?>
					
			</div>
			<?
		}
	}
	
	/* ADMIN CAPABILITIES HERE IF RANK IS EQUAL TO ETERNITY TEAM.
		* note: please do not add functionality for retired eternity team members, they should not be allowed this. 
	*/
	if($_SESSION['rank'] == "Eternity Team")
	{
		/* ONLY OUTPUT IF THERE ARE LESS THAN THREE FEATURED LISTS*/
		if($number < 3)
		{
			// output
			?>
				<!-- Button -->
				<div class="add-to-featured" onclick="featured_add_overlay();">
					<table>
						<tbody>
							<tr>
								<td class="c1"></td>
								<td>Feature a List</td>
							</tr>
						</tbody>
					</table>
				</div>
				
				<!-- Overlay -->
				<div id="featured-overlay" class="add-to-featured-overlay">
					<a href="javascript:featured_add_overlay_close();">X</a><h2>Feature a Tasks List!</h2>
					<img src="/assets/images/url.png" />
					<p>Input the id of the list you want to feature in below.</p><br />
					<input id="listid"  type="text" placeholder="id goes here"/><input type="button" value="ADD" onclick="featured_add(document.getElementById('listid').value);"/>
				</div> 
			<?
		}
	}
	/* NOW DIE, WE DONT WANT THE REST OF THE PAGE TO EXECUTE AND/OR DISPLAY.
		* note: please, DO NOT REMOVE THE FOLLOWING LINE!!!! 
	*/
	die;
}




/** 
	* AJAX CALLER: featured_remove()
	*
	* PARAMETERS:
	* $id - used as the id of the task list to remove from the featured table.
	* $db - used as the database class
	*
	* DESCRIPTION:
	* This function removes a specific task list from the featured list, and displays the rest of the rows. 
	*
*/
function featured_remove($id, $db)
{
	$db->query("DELETE FROM `tasks_lists-featured` WHERE `list`='" . $db->escape($id) . "'");
	featured_display($db);
	// we dont need to die, the previous function takes care of that for us.
}

/** 
	* AJAX CALLER: featured_remove()
	*
	* PARAMETERS:
	* $id - used as the id of the task list to remove from the featured table.
	* $db - used as the database class
	*
	* DESCRIPTION:
	* This function removes a specific task list from the featured list, and displays the rest of the rows. 
	*
*/
function featured_add($id, $db)
{
        $public = $db->fetch($db->query("SELECT public FROM tasks_lists WHERE id='" . $db->escape($id) . "'"));
        If($public == "yes")
        {
			$db->query("INSERT INTO `tasks_lists-featured` (`list`) VALUES ('" . $db->escape($id) . "')");
			$db->query("INSERT INTO tasks_activity (username, activity) VALUES ('" . $db->escape($_SESSION['username']) . "', ' featured a new list')");
			featured_display($db);
			// we dont need to die, the previous function takes care of that for us.
        }
        Else 
        {
            featured_display($db);
        }
}
