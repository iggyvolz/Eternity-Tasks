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


/**
	* GET Action
	* 
	* sets all the variables retrieved from the GET variable.  sets the lid, title, description,
	* author, and date.  If there is no get variable, or the variable is invalid, or it isn't public, and 
	* the user isn't logged in that owns it, a 404 error will be thrown.  
*/
if(!empty($_GET))
{
	/* Get List Specific Details */
	$result = $db->query("SELECT * FROM tasks_lists WHERE id='" . $db->escape($_GET['id']) . "'");
	while($row = $db->create_array($result)) 
	{
		$lid = stripslashes($row['id']);
		$title = stripslashes($row['name']);
		$description = stripslashes($row['description']);
		$author = stripslashes($row['creator']);
		$date = stripslashes($row['date']);
		$public = stripslashes($row['public']);
	}
	
	/* format the date */
	$date = preg_replace('/(.*)-(.*)-(.*)/is', '$2-$3-$1', $date);
	$date = preg_replace('/01-(.*)-(.*)/is', 'January $1, $2', $date);
	$date = preg_replace('/02-(.*)-(.*)/is', 'February $1, $2', $date);
	$date = preg_replace('/03-(.*)-(.*)/is', 'March $1, $2', $date);
	$date = preg_replace('/04-(.*)-(.*)/is', 'April $1, $2', $date);
	$date = preg_replace('/05-(.*)-(.*)/is', 'May $1, $2', $date);
	$date = preg_replace('/06-(.*)-(.*)/is', 'June $1, $2', $date);
	$date = preg_replace('/07-(.*)-(.*)/is', 'July $1, $2', $date);
	$date = preg_replace('/08-(.*)-(.*)/is', 'August $1, $2', $date);
	$date = preg_replace('/09-(.*)-(.*)/is', 'September $1, $2', $date);
	$date = preg_replace('/10-(.*)-(.*)/is', 'October $1, $2', $date);
	$date = preg_replace('/11-(.*)-(.*)/is', 'November $1, $2', $date);
	$date = preg_replace('/12-(.*)-(.*)/is', 'December $1, $2', $date);
	
	/* retrieve the tasks */
	$tasks = $db->query("SELECT * FROM tasks_tasks WHERE `list`='" . $db->escape($lid) . "' ORDER BY id DESC");
	$number = $db->num_rows($tasks);
	
	/* retrieve favorited */
	$favorite = "SELECT `username` FROM tasks_favorites WHERE `list`='" . $db->escape($lid) . "' AND `username`='" . $db->escape($_SESSION['username'])	. "'  LIMIT 1";
	if($db->num_rows($db->query($favorite)) > 0)
	{
		$favorite = 'yes';
	}
	else
	{
		$favorite = 'no';
	}

	/* 404 check */
	if($_GET['id'] == "" || $title == "" || ($public == "no" && ($author != $_SESSION['username'] && $_SESSION['rank'] != "Eternity Team" )))
	{
		ob_end_clean();
		header('HTTP/1.1 404 Not found');
		include SRV_ROOT . "/errors/404.php"; die; 
	}
}

/**
	* POST Action
	*  
	* mainly used for AJAX, we use the POST action here to update some fields and die, so the rest of the page 
	* is not rendered.  
*/
if(!empty($_POST))
{
	// import AJAX functions
	include 'includes/lists.php';
	include 'includes/lists/list-top.php';
	include 'includes/lists/list-buttons.php';
	include 'includes/lists/list-tasks.php';
	
	/* TAKE ACTION */
	// list top actions
	if($_POST['type'] == "list_update_title") { list_update_title($_POST['title'], $_GET['id'], $db); }
	if($_POST['type'] == "list_update_description") { list_update_description($_POST['description'], $_GET['id'], $db); }
	
	
	// list button actions
	if($_POST['type'] == "list_to_private") { list_to_private($_POST['list'], $db); } 
	if($_POST['type'] == "list_to_public") { list_to_public($_POST['list'], $db); } 
	if($_POST['type'] == "list_remove_favorite") { list_remove_favorite($_POST['list'], $db); }
	if($_POST['type'] == "list_add_favorite") { list_add_favorite($_POST['list'], $public, $db); } 
	if($_POST['type'] == "list_add_task") { list_add_task($_POST['name'], $_POST['description'], $_POST['date'], $_GET['id'], $_POST['tid'], $public, $db); }
	if($_POST['type'] == "list_delete") { list_delete($_POST['list'], $db); }
	
	// task specific actions
	if($_POST['type'] == "list_delete_task") { list_delete_task($_POST['taskid'], $db); }
	if($_POST['type'] == "task_to_no") { task_to_no($_POST['task'], $db); }
	if($_POST['type'] == "task_to_yes") { task_to_yes($_POST['task'], $db); }
	if($_POST['type'] == "task_title") { task_update_title($_POST['title'], $_POST['task'], $db); }
	if($_POST['type'] == "task_show_details") { task_show_details($_POST['task'], $author, $_SESSION['username'], $_GET['id'], $db); }
	if($_POST['type'] == "task_details_edit_done") { task_details_edit_done($_POST['description'], $_POST['date'], $_POST['id'], $db); }
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
	<title><?php echo $title; ?> List / Eternity Tasks</title>
	<!--// End Title -->
	
	<!-- Assets -->
	<?php include 'includes/eternityx/assets.php'; ?>
	
	<script type="text/javascript" src="/assets/js/lists_ajax/list-top.js"></script>
	<script type="text/javascript" src="/assets/js/lists_ajax/list-buttons.js"></script>
	<script type="text/javascript" src="/assets/js/lists_ajax/list-tasks.js"></script>
	<script type="text/javascript" src="/assets/js/prompts.js"></script>
	
	<!-- OVERLAY BOX --><script type="text/javascript" src="/assets/js/overlay.js"></script>
	<!-- BUTTONS --><script type="text/javascript" src="/assets/js/buttons.js"></script>
	<!--// end Assets -->
</head>
<body>
	<?php include SRV_ROOT . '/apps/tasks/includes/eternityx/body-top.php'; ?>
	
	<!-- Preloaded Images -->
	<div style="display: none;">
		<img src="/assets/images/progress.gif" />
		<img src="/assets/images/check.png" />
		<img src="/assets/images/pencil.png" />
		<img src="/assets/images/pencil-done.png" />
		<img src="/assets/images/public.png" />
		<img src="/assets/images/private.png" />
		<img src="/assets/images/favorite.png" />
		<img src="/assets/images/unfavorite.png" />
		<img src="/assets/images/add.png" />
	</div>
	
	<!-- Main Content -->
	<div id="container">
		<?php include 'includes/interface/header.php'; ?>
		
		<!-- Overlay -->
		<?php if ($author == $_SESSION['username'] || $_SESSION['rank'] == "Eternity Team")
		{ ?>
			<div id="backdrop" class="backdrop"></div>
			<div id="overlay" class="overlay">
				<a href="javascript:overlay_close();">X</a><h2>Add a Task</h2>
				<br />
				<br style="clear: both;" />
				<form autocomplete="off">
					<table style="text-align: center;">
						<tr style="text-align: left;">
							<td>Name:</td>
							<td><input type="text" id="task_name" /><div id="error" style="display: inline;"></div></td>
						</tr>
						<tr style="text-align: left;">
							<td>Description:</td>
							<td><textarea id="task_description" ></textarea></td>
						</tr>
						<tr style="text-align: left;">
							<td>Due Date:</td>
							<td><input type="date" id="task_date" /></td>
						</tr>
						<tr>
							<td colspan="2"><input type="button" onclick="if(document.getElementById('task_name').value) {list_add_task('<?php echo $_GET['id']; ?>', document.getElementById('task_name').value, document.getElementById('task_description').value, document.getElementById('task_date').value); } else { document.getElementById('error').innerHTML = 'please fill out this field'; }"  style="text-align: center;" value="Submit" /></td>
						</tr>
					</table>
				</form>
			</div><?php 
		} ?>
		
		<!-- Prompt -->
		<div id="prompt" style="display: none;">
			<h2>Are you Sure?</h2>
			<input id="prompt-confirm" type="button" onclick="list_delete('<?php echo $lid; ?>');" value="Yes" />
			<input type="button" onclick="document.getElementById('prompt').style.display = 'none'; document.getElementById('backdrop').style.display = 'none';" value="No" />
		</div>
		
		<!-- List Top -->
		<div id="list-top">
		
			<?php  /* Generate List Top where the the currently viewing user is the owner, or an admin */ 
			if($author == $_SESSION['username'] || $_SESSION['rank'] == "Eternity Team" || $_SESSION['rank'] == "Retired Eternity Team")
			{
				?>				
				<!-- List Top -->
				<input id="title" value="<?php echo $title; ?>" onblur="list_update_title(this.value, '<?php echo $_GET['id']; ?>');" title="Click to Edit" />
				<textarea id="description" onblur="list_update_description(this.value, '<?php echo $_GET['id']; ?>');" title="Click to Edit"><?php echo $description; ?></textarea>
				<p id="info">Created by: <a href="http://eternityinc-official.com/users/<?php echo $author; ?>"><?php echo $author; ?></a> on <?php echo $date; ?></p>
				<?
			}
			
			/* Generate List Top where it is publicized. */
			else
			{	
				?>
				<h1><?php echo $title; ?></h1>
				<p id="description"><?php echo $description; ?></p>
				<p id="info">Created by: <a href="http://eternityinc-official.com/users/<?php echo $author; ?>"><?php echo $author; ?></a> on <?php echo $date; ?></p></p>
				<?
			}
			?>		
		</div>
		
		<!-- List Bottom -->
		<div id="list-bottom">
		
			<?php  /* List Bottom Where Author is viewing it, or admin is viewing it. */
			if($author == $_SESSION['username'] || ($_SESSION['rank'] == "Eternity Team" || $_SESSION['rank'] == "Retired Eternity Team"))
			{
			
				/* ADMIN CAPABILITIES INDICATOR */
				if($_SESSION['rank'] == "Eternity Team" || $_SESSION['rank'] == "Retired Eternity Team") 
				{
					echo '<div class="admin-capabilities">Admin Capabilities are enabled</div>';
				}
				
				
				/* BUTTONS */
				?>
				<!-- Buttons -->
				<!-- ADD TASK -->
				<div class="button" id="add-task" onmouseover="showtip('add-task');" onmouseout="hidetip('add-task');">
					<a id="lists-add" href="javascript:overlay();" class="button" ><img onmousedown="this.ondragstart = function() { return false; }" src="/assets/images/add.png" /></a>
					<div class="arrow-left" id="add-task-arrow-left"></div>
					<div class="tooltip" id="add-task-tooltip">Click to add a Task</div>
				</div>
				
				<!-- Buttons >> TOGGLERS -->
				<div id="buttons">
					<?
					// public/private button
					if($public == 'yes')
					{
						?>
						<!-- PRIVATE / PUBLIC -->
						<div class="button" id="private-button" onmouseover="showtip('private-button');" onmouseout="hidetip('private-button');">
							<a id="private-button-button" class="button" href="javascript:list_to_private('<?php echo $lid; ?>', 'private-button');"><img onmousedown="this.ondragstart = function() { return false; }" src="/assets/images/public.png" /></a>
							<div class="arrow-left" id="private-button-arrow-left"></div>
							<div class="tooltip" id="private-button-tooltip">Click to make Private</div>
						</div>
						<?
					}
					elseif($public == 'no') 
					{
						?>
						<!-- PRIVATE / PUBLIC -->
						<div class="button" id="public-button" onmouseover="showtip('public-button');" onmouseout="hidetip('public-button');">
							<a id="public-button-button" class="button" href="javascript:list_to_public('<?php echo $lid; ?>', 'public-button');"><img onmousedown="this.ondragstart = function() { return false; }" src="/assets/images/private.png" /></a>
							<div class="arrow-left" id="public-button-arrow-left"></div>
							<div class="tooltip" id="public-button-tooltip">Click to make Public</div>
						</div>
						<?
					}
					
					// favorite/unfavorite button
					if($favorite == 'yes')
					{
						?>
						<!-- FAVORITE / UNFAVORITE -->
						<div class="button" id="unfavorite-button" onmouseover="showtip('unfavorite-button');" onmouseout="hidetip('unfavorite-button');">
							<a id="unfavorite-button-button" class="button" href="javascript:list_remove_favorite('<?php echo $lid; ?>', 'unfavorite-button');"><img onmousedown="this.ondragstart = function() { return false; }" src="/assets/images/unfavorite.png" /></a>
							<div class="arrow-left" id="unfavorite-button-arrow-left"></div>
							<div class="tooltip" id="unfavorite-button-tooltip">Click to unFavorite</div>
						</div>
						<?
					}
					elseif($favorite == 'no')
					{
						?>
						<!-- FAVORITE / UNFAVORITE -->
						<div class="button" id="favorite-button" onmouseover="showtip('favorite-button');" onmouseout="hidetip('favorite-button');">
							<a id="favorite-button-button" class="button" href="javascript:list_add_favorite('<?php echo $lid; ?>', 'favorite-button');"><img onmousedown="this.ondragstart = function() { return false; }" src="/assets/images/favorite.png" /></a>
							<div class="arrow-left" id="favorite-button-arrow-left"></div>
							<div class="tooltip" id="favorite-button-tooltip">Click to Favorite</div>
						</div>
						<?
					}
					?>
				</div>
				<!-- BUTTONS (NOT TOGGLER) -->
				<!-- DELETE BUTTON -->
				<div class="button" id="delete-list" onmouseover="showtip('delete-list');" onmouseout="hidetip('delete-list');">
					<a id="delete-list" class="button" href="javascript:list_delete_confirm('<?php echo $lid; ?>');"><img onmousedown="this.ondragstart = function() { return false; }" src="/assets/images/delete.png" /></a>
					<div class="arrow-left" id="delete-list-arrow-left"></div>
					<div class="tooltip" id="delete-list-tooltip">Click to delete the list</div>
				</div>
				
				<br />
				<br />
				
				<!-- TASKS AREA! -->
				<div id="new_tasks"></div>
				<?php  
				
				/* Start Outputting Tasks */
				while($row = $db->create_array($tasks))
				{
					?>
					<div class="task" id="<?php echo $row['id']; ?>">
						<input id="<?php echo $row['id']; ?>check" type="checkbox"  <?php if ($row['complete'] == 'yes') { echo 'checked '; echo 'onclick="task_to_no(\'' . $_GET['id'] . '\', \'' . $row['id'] . '\');"'; } else { echo 'onclick="task_to_yes(\'' . $_GET['id'] . '\',\'' . $row['id'] . '\');"'; } ?> />
						<span class="name"><input id="<?php echo $row['id']; ?>name" type="text" value="<?php echo $row['name']; ?>" onblur="task_update_title('<?php echo $_GET['id']; ?>', this.value, '<?php echo $row['id']; ?>');"/></span>
						<div class="links">
							<a id="<?php echo $row['id']; ?>button" style="height: 32px; width: 32px;" class="icon" href="javascript:task_show_details('<?php echo $_GET['id']; ?>', '<?php echo $row['id']; ?>');" style="padding-left: 5px;"><img title="Show Details" onmousedown="this.ondragstart = function() { return false; }" src="/assets/images/arrow.png" /></a> 
							<a id="<?php echo $row['id']; ?>delete"  title="Delete" style="padding-left: 10px;" href="javascript:list_delete_task('<?php echo $_GET['id']; ?>', '<?php echo $row['id']; ?>');" class="icon"><img onmousedown="this.ondragstart = function() { return false; }" src="/assets/images/trash.png" alt="Delete" /></a>	
						</div> 
						<div class="details" id="<?php echo $row['id']; ?>details" style="display: none;"></div>
					</div>
					<?
				}
			}
			
			/* List Bottom Where Public is viewing it. */
			else
			{
				?>
				<!-- BUTTONS -->
				<div id="buttons">
					<?
					if(isset($_SESSION['username']))
					{
						// favorite/unfavorite button
						if($favorite == 'yes')
						{
							?>
							<!-- FAVORITE / UNFAVORITE -->
							<div class="button" id="unfavorite-button" onmouseover="showtip('unfavorite-button');" onmouseout="hidetip('unfavorite-button');">
								<a id="unfavorite-button-button" class="button" href="javascript:list_remove_favorite('<?php echo $lid; ?>', 'unfavorite-button');"><img onmousedown="this.ondragstart = function() { return false; }" src="/assets/images/unfavorite.png" /></a>
								<div class="arrow-left" id="unfavorite-button-arrow-left"></div>
								<div class="tooltip" id="unfavorite-button-tooltip">Click to unFavorite</div>
							</div>
							<?
						}
						elseif($favorite == 'no')
						{
							?>
							<!-- FAVORITE / UNFAVORITE -->
							<div class="button" id="favorite-button" onmouseover="showtip('favorite-button');" onmouseout="hidetip('favorite-button');">
								<a id="favorite-button-button" class="button" href="javascript:list_add_favorite('<?php echo $lid; ?>', 'favorite-button');"><img onmousedown="this.ondragstart = function() { return false; }" src="/assets/images/favorite.png" /></a>
								<div class="arrow-left" id="favorite-button-arrow-left"></div>
								<div class="tooltip" id="favorite-button-tooltip">Click to Favorite</div>
							</div>
							<?
						}
					}?>
				</div>
				
				<br style="clear: both;"/><br />
				
				<? /* START OUTPUTTING TASKS */
				while($row = $db->create_array($tasks))
				{
					?>
					<div class="task" id="<?php echo $row['id']; ?>">
						<input id="<?php echo $row['id']; ?>check" type="checkbox"  Disabled <?php if($row['complete'] == 'yes' ) { echo 'checked'; } ?> /> 
						<span class="name"><?php echo $row['name']; ?></span>
						<div class="links">
							<a id="<?php echo $row['id']; ?>button" class="icon" href="javascript:task_show_details('<?php echo $row['id']; ?>', '<?php echo $row['id']; ?>');"><img onmousedown="this.ondragstart = function() { return false; }" title="Show Details" src="/assets/images/arrow.png" /></a>
						</div>
						<div class="details" id="<?php echo $row['id']; ?>details" style="display: none;"></div>
					</div>
					<?
				}
			}
			
			?>
		</div>
	</div>
	<!--// end Main Content -->
	
	<?php include SRV_ROOT . '/apps/tasks/includes/eternityx/body-bottom.php'; ?>
</body>
</html>

<?php
/* END OF FILE */