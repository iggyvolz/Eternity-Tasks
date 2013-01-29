<?php
function browse_display($db)
{
	?>
		<!-- Search Bar -->
		<table class="task-search" style="width: 100%;">
			<tr style="width: 100%;">
				<td class="c1"></td>
				<td class="c2" style="width: 95%;">
					<input style="width: 100%;"class="search" style="" onkeyup="selector(this.value);" placeholder="Search the site" type="text" name="q" />
				</td>
			</tr>
		</table>
		<div id="search-results">
			<?
			$id = $db->query("SELECT * FROM `tasks_lists` ORDER BY `id` DESC");
			while($row = $db->create_array($id))
			{
				?>
                
					<div class="yl-row" onmouseover="yl_row_links('<?php echo $row['id']; ?>');" onmouseout="hide_yl_row_links('<?php echo $row['id']; ?>');">
                    	<a href="/lists/view/<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a>
                        by <?php echo $row['creator']; ?>
                        
                        <span id="<?php echo $row['id']; ?>links" style="display: none; float: right;">
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
                          </span>
                     	</div>
                        
             	<?
			} ?>
       	</div><?php
		die;
}