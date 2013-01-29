<?php
include 'includes/eternityx/php.php';
clearstatcache();
global $db;
/* 404 check */
if($_GET['id'] == "") {
	ob_end_clean();
	header('HTTP/1.1 404 Not found');
	include SRV_ROOT . "/errors/404.php"; die; 
}

/* Get Variables */
$query = $db->query("SELECT * FROM tasks_projects WHERE `id`='" . $db->escape($_GET['id']) . "'");
while($row = $db->create_array($query)) {
	$title = $row['name'];
	$description = $row['description'];
	$date = $row['date'];
	$GLOBALS['creator'] = $row['username'];
}

/* Fix Variables */
// title
$title = trim($title);
$title = htmlspecialchars($title);
$title = stripslashes($title);

// description 
$description = htmlspecialchars($description);
$description = stripslashes($description);
$description = trim($description);
$description = str_replace(htmlspecialchars("&nbsp;"), "", $description);
$description = str_replace(htmlspecialchars('<strong contenteditable="false">Description:</strong>'), ' ', $description);


if(!empty($_POST)) {
	include 'includes/projects/project-top.php';
	
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
	<title>Project / Eternity Tasks</title>
	<!--// End Title -->
	
	<!-- Assets -->
	<?php include 'includes/eternityx/assets.php'; ?>
	<link rel="stylesheet" href="/assets/style/projects.css" />
	<script type="text/javascript" src="/assets/js/overlay.js"></script>
	<script type="text/javascript" src="/assets/js/projects/project-top.js"></script>
	<!--// end Assets -->
</head>
<body>
	<div id="changes_saved"></div>
	<?php include SRV_ROOT . '/apps/tasks/includes/eternityx/body-top.php'; ?> 
	<!-- Main Content -->
	<div id="container">
		<?php
		include 'includes/interface/header.php';
		if($creator == $_SESSION['username']) {
			?>
			<div id="project-top">
				<input id="title" type="text" value="<?php echo $title; ?>" onblur="projects_updatetitle(this.value, '<?php echo $_GET['id']; ?>');" />
				<div id="tabs">
					<button id="details" onclick="tab(this.id, '<?php echo $_GET['id']; ?>')">Details</button>
				</div>
				<div id="details-tab" class="tab">
					<?php
					if($GLOBALS['creator'] == $_SESSION['username']) {
						?><div contenteditable="true" id="description" onblur="projects_updatedescription(this.innerHTML, '<?php echo $_GET['id']; ?>');"><strong contenteditable="false">Description:</strong><?php echo $description; ?></div>
						<strong>Created by:</strong> <?php echo "\t\t" . $GLOBALS['creator']; ?><br /><br />
						<strong>Created on:</strong> <?php echo "\t\t" . $date; 
					}
					else {
						?><p id="description"><?php echo $description; ?></p><?
					} ?>
				</div>
			</div>
			<?php
		} ?>
	</div>
	<!-- End Main Content -->
	
	<?php include SRV_ROOT . '/apps/tasks/includes/eternityx/body-bottom.php'; ?>
</body>
</html>
