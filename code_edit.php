<?php
/**
	* Eternity Tasks 3.0 [EternityX app/addon]
	* http://tasks.eternityinc-official.com
	*
	* (C) 2013 Eternity Incurakai Studios, All Rights Reserved
	* Licensed under the ESCLv1 License
	* http://eternityinc-official.com/license
*/

include'includes/eternityx/php.php';


/* Database Action */
$result = $db->query("SELECT * FROM users WHERE username='" . $db->escape($username) . "'");

// fetch profile variables
while($row = $db->create_array($result))
{
$id = $row[id];
$name = check($row['name']);
$shared_w = check($row['Shared_w']);
$owner = $row['Created_by'];
$date = $row['Created_on'];
$css = $row['Css'];
$html = $row['Javascript'];
$js = $row['Html'];
}

/* Form Action */
if(!empty($_POST))
{
	
	$db->query("INSERT INTO tasks_code (`name`, `Created_by`, `Created_on`, `Shared_w`) VALUES ('" . $db->escape($_POST['name1']) . "', '" . $_SESSION['username'] . "','NOW()', '" . $db->escape($_POST['share_w']) . "')") or error(e0001, $db->error());
	
	header("location:http://tasks.eternityinc-official.com/code-edit?id=$id"); die;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Meta Data -->
	<?php include 'includes/eternityx/meta.php'; ?>
	
	<!-- Title -->
	<title>Edit your code collaboration / Eternity Tasks</title>
	<!--// End Title -->
</head>
<body>	
	<!-- Main Content -->
	<div id="container">
           <label for="html">HTML</label><br/><label for="js">Javascript</label>
           <textarea id="html" rows="12" cols="80" style="font-family:Calibri,Arial;"></textarea><textarea id="js" rows="12" cols="80" style="font-family:Calibri,Arial;"></textarea><br/>
           <p>CSS</p>
           <textarea rows="10" cols="20" style="font-family:Calibri,Arial;"></textarea><div></div>
	</div>
	<!--// end Main Content -->
</body>
</html>