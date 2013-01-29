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
	* favorites tab in the lists index (http://tasks.eternityinc-official.com/lists)
	* file: /list_index.php
	* for javascript/AJAX functions, please see /assets/js/favorites.js
*/


/** 
	* AJAX CALLER: favorites_display()
	*
	* PARAMETERS:
	* $db - used as the database class
	*
	* DESCRIPTION:
	* This function displays the favorites tab's list.  
	*
*/
function favorites_display($db) 
{
	/* Heading */
	?>
		<h2><img src="/assets/images/favorites.png" style="vertical-align: middle;" />Your Favorites</h2>
	<?php 
	
	
	/* If not logged in, die with an error */
	if(!isset($_SESSION['username']))
	{
		?>
			<p>Please <a href="http://eternityinc-official.com/login?refer=tasks.eternityinc-official.com/lists">Login</a> to view your favorites</p>
		<? die;
	}
	
	
	/* If no favorites, die with an error */
	$query = $db->query("SELECT * FROM tasks_favorites WHERE `username`='" . $db->escape($_SESSION['username']) . "'");
	$rows = $db->num_rows($query);
	if($rows == 0)
	{
		echo 'You don\'t have any Favorites Yet.';
		die;
	}
	
	
	/* Output the Favorites */
	while($row = $db->create_array($query))
	{
		$new_query = $db->query("SELECT * FROM tasks_lists WHERE `id`='" . $row['list'] . "'");
		while($row2 = $db->create_array($new_query))
		{
			?>
			<div class="favorites-row">
				<div class="star">
					<span title="Click to unFavorite" class="favorites-star" onclick="favorites_remove('<?php echo $row['list']; ?>');"></span>
					<span title="Number of Favorites" class="favorites-number"><?php echo $db->num_rows($db->query("SELECT * FROM tasks_favorites WHERE `list`='" . $db->escape($row['list']) . "'")); ?></span>
				</div>
				
				<a class="title" href="/lists/view/<?php echo $row2['id']; ?>"><?php echo $row2['name']; ?></a>
				<span class="author"><strong>by</strong> <a href="http://eternityinc-official.com/users/<?php echo $row2['creator']; ?>"><?php echo $row2['creator']; ?></a></span>
			</div><br /><br />
			<?
		}
	}
	die;
}

/** 
	* AJAX CALLER: favorites_remove()
	*
	* PARAMETERS:
 	* $id - used as the list to remove from your favorites 
	* $db - used as the database class
	*
	* DESCRIPTION:
	* This function removes a favorited list
	*
*/
function favorites_remove($id, $db)
{
	$db->query("DELETE FROM tasks_favorites WHERE `username`='" . $db->escape($_SESSION['username']) . "' AND `list`='" . $db->escape($id) . "'");
	favorites_display($db);
}
