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

	$result = $db->query("SELECT * FROM tasks_code WHERE id='$_GET[id]'"); // start query

	// fetch profile variables
	while($row = $db->create_array($result))
	{
		$name = check($row['name']);
		$owner = check($row['Created_by']);
		$date = check($row['Created_on']);
		$shared = check($row['Shared_w']);
		$css = $row['Css'];
		$js = $row['Javascript'];
		$html = $row['Html'];
	}

/* Form Action */
if(!empty($_POST))
{
        $htmls = stripslashes($_POST[html]);
        $jss = stripslashes($_POST[js]);
        $csss = stripslashes($_POST[css]);
   	$db->query("UPDATE tasks_code SET Html='" . $db->escape($htmls) . "' WHERE id='" . $_GET[id] . "'");
	$db->query("UPDATE tasks_code SET Css='" . $db->escape($csss) . "' WHERE id='" . $_GET[id] . "'");				
	$db->query("UPDATE tasks_code SET Javascript='" . $db->escape($jss) . "' WHERE id='" . $_GET[id] . "'");		
        header('location:/apps/tasks/code_create2.php?id=' . $_GET[id] . '');
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
	<title>Edit your code collab / Eternity Tasks</title>
	<!--// End Title -->
	
	<!-- Assets -->
	<?php include 'includes/eternityx/assets.php'; ?>
	<!--// end Assets -->
        <!-- OVERLAY BOX --><script type="text/javascript" src="/assets/js/overlay.js"></script>
</head>
<?php if($owner = $_SESSION[username])
{?>
<body onload=" overlay(); hide('html'); hide('js');  hide('css'); hide('htmll'); hide('jsl');  hide('cssl');">
<?php 
}
else
{?>
<body onload=" overlay(); hide('html'); hide('js');  hide('css'); hide('htmll'); hide('jsl');  hide('cssl');">
<?php
}
?>
	<?php include SRV_ROOT . '/apps/tasks/includes/eternityx/body-top.php'; ?>
	
	<!-- Main Content --><!-- OVERLAY BOX --><script type="text/javascript" src="http://tasks.eternityinc-official.com/assets/js/overlay.js"></script>
        <div id="container"><div id="backdrop"></div>
		<center><div id="overlay">
				<div style="height: 20%; position: fixed; background: #00FF00; width: 40%; text-align: center; box-shadow: 0 0 25px #0F0; border: 2px solid #0A0; padding: 5px; ">
					<span style="font-family: tahoma, verdana; font-size: 24px;"><ins>Sorry!</ins></span><br />
					<span style="font-family: tahoma, verdana; font-size: 20px;">This Code collab isn't shared with you.<br/> If this is an error, please contact us<br/> or if not please contact the owner</span><br />
				</div>
		</div></center>


           <div style="text-align:center;"><h2>Welcome to the <?php echo"$name"; ?> code collab set up by <?php echo"$owner"; ?></h2></div>
           <div style="text-align:center;"><h3><ins>Please select the code you would like to edit</ins></h3><br/><a href="javascript: show('html'); hide('js');  hide('css'); show('htmll'); hide('jsl');  hide('cssl');" title="">Edit Html</a> | <a href="javascript: hide('html'); show('js');  hide('css'); hide('htmll'); show('jsl');  hide('cssl');" title="">Edit Javascript</a> | <a href="javascript: hide('html'); hide('js');  show('css'); hide('htmll'); hide('jsl');  show('cssl');" title="">Edit CSS</a></div>
           <form name="input" action="code_create2.php?id=<?php echo"$_GET[id]"; ?>" method="post">
           <label id="htmll" for="html">Html Code:</label><br/><textarea id="html" name="html" rows="13"><?php echo"$html"; ?></textarea>
           <label id="jsl" for="html">Javascript Code:</label><br/><textarea id="js" name="js" rows="13"><?php echo"$js"; ?></textarea>
           <label id="cssl" for="html">CSS Code:</label><br/><textarea id="css" name="css" rows="13"><?php echo"$css"; ?></textarea>
           <input type="submit" value="Update Code" />
           <div name="show"><iframe width="100%" height="400px" src="code.php?id=<?php echo"$_GET[id]"; ?>"></iframe></div>
           </form>
	</div></center>
	<!--// end Main Content -->
	
	<?php include SRV_ROOT . '/apps/tasks/includes/eternityx/body-bottom.php'; ?>
</body>
</html>

<?php
/* END OF FILE */