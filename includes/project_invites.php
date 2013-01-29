


<?php 


	if(!empty($_POST))
	{
		if(isset($_POST['function']))
		{
		$query = "SELECT * FROM tasks_projects_invites WHERE `username`='" . $db->escape($_SESSION['username']) . "'";
		$number = $db->num_rows($db->query($query));
		if($number > 0) {
			echo $number; die;
		}
		else {
			echo '0'; die;
		}}
	}