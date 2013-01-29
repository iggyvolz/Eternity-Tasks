<?php
function yourlists_display($db)
{
	$query = $db->query("SELECT * FROM tasks_lists WHERE `creator`='" . $db->escape($_SESSION['username']) . "'");
	$rows = $db->num_rows($query);
	if($rows == 0)
	{
		echo 'You dont have any Lists yet.  <a href="/lists/create" style="color: white;">Click Here</a> to create one!';
	}
	while($row = $db->create_array($query))
	{
		?>
		<div class="yl-row" onmouseover="yl_row_links('<?php echo $row['id']; ?>');" onmouseout="hide_yl_row_links('<?php echo $row['id']; ?>');">
            <a href="/lists/view/<?php echo $row['id']; ?>">
                <?php echo $row['name']; ?>
            </a> by <?php echo $row['creator']; ?>
            
            <span id="<?php echo $row['id']; ?>links" style="display: none; float: right;">
				<a href="javascript:list_delete_confirm('<?php echo $row['id']; ?>');">Delete</a>
			</span>
		</div>
			<?
	}
	die;
}
