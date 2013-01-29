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

include 'includes/lists/list-tasks.php';
include 'includes/lists.php';

// include tabs 
include 'includes/tabs/featured.php';
include 'includes/tabs/favorites.php';
include 'includes/tabs/yourlists.php';
include 'includes/tabs/browse.php';

if(!empty($_POST))
{	
	/* AJAX FUNCTION CALLS HERE */
	// FEATURED TAB
	if($_POST['type'] == "featured_display") { featured_display($db); }
	if($_POST['type'] == "featured_add") { featured_add($_POST['id'], $db); }
	if($_POST['type'] == "featured_remove") { featured_remove($_POST['id'], $db); }
	
	// FAVORITES TAB
	if($_POST['type'] == "favorites_display") { favorites_display($db); }
	if($_POST['type'] == "favorites_remove") { favorites_remove($_POST['list'], $db); }
	
	// YOURLISTS TAB
	if($_POST['type'] == "yourlists_display") { yourlists_display($db); }
	if($_POST['type'] == "list_delete") { list_delete($_POST['list'], $db); } 
	
	
	// BROWSE TAB
	if($_POST['type'] == "browse_display") { browse_display($db); }

	// MISC
	if($_POST['type'] == "la_check") { la_check($db); }
	if($_POST['type'] == "check_list_tasks") { check_list_tasks($_SESSION['username'], $_POST['list'], $db); }
	if($_POST['type'] == "search") { search($_POST['query'], $db); }

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
	<title>Lists / Eternity Tasks</title>
	<!--// End Title -->
	
	<!-- Assets -->
	<?php include 'includes/eternityx/assets.php'; ?>
	
	<!-- TABS -->
	<link rel="stylesheet" href="/assets/style/tabs.css" />
	<script type="text/javascript" src="/assets/js/tabs/tabs.js"></script>	
	<script type="text/javascript" src="/assets/js/tabs/featured.js"></script>
	<script type="text/javascript" src="/assets/js/tabs/favorites.js"></script>
    <script type="text/javascript" src="/assets/js/tabs/yourlists.js"></script>
    <script type="text/javascript" src="/assets/js/tabs/browse.js"></script>
	
	
	<script>
		function update_la() {			
			// continue with AJAX
			if (window.XMLHttpRequest) {
				req = new XMLHttpRequest();
			} else {
				 req = new ActiveXObject("Microsoft.XMLHTTP");
			}
			req.open("POST", "", true);
			req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
			req.send("type=la_check");

			req.onreadystatechange = function() {
				if (req.readyState==4 && req.status==200) {
					document.getElementById('activity-area').innerHTML = req.responseText;
					
				} else {
				}
			}
		}	
		
		function selector(query) {			
			// continue with AJAX
			if (window.XMLHttpRequest) {
				req = new XMLHttpRequest();
			} else {
				 req = new ActiveXObject("Microsoft.XMLHTTP");
			}
			req.open("POST", "", true);
			req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
			req.send("type=search&query="+encodeURIComponent(query));

			req.onreadystatechange = function() {
				if (req.readyState==4 && req.status==200) {
					document.getElementById('search-results').innerHTML = req.responseText;
					
				} else {
				}
			}
		}	
		
		
			
		
		
	</script>
	<!-- OVERLAY BOX --><script type="text/javascript" src="http://tasks.eternityinc-official.com/assets/js/overlay.js"></script>
	<!-- BUTTONS --><script type="text/javascript" src="/assets/js/buttons.js"></script>
	<script type="text/javascript" src="/assets/js/prompts.js"></script>
	<!--// end Assets -->
</head>
<body onload="yourlists_display();">
	<?php include SRV_ROOT . '/apps/tasks/includes/eternityx/body-top.php'; ?>
	<div id="prompt" style="display: none;">
			<h2>Are you Sure?</h2>
			<input id="prompt-confirm" type="button" value="Yes" />
			<input type="button" onclick="document.getElementById('prompt').style.display = 'none'; document.getElementById('backdrop').style.display = 'none';" value="No" />
		</div><div id="backdrop"></div>
	<!-- Main Content -->
	<div id="container">
		<?php include 'includes/interface/header.php'; ?>
		
		<div class="latest-activity">
			<h3>Latest Activity in Lists</h3>
			<div id="activity-area">
				<?php
				$query = $db->query("SELECT * FROM tasks_activity ORDER BY id DESC LIMIT 20 ");
				while($row = $db->create_array($query))
				{
					?>
					<div class="la-row" ><a href="http://eternityinc-official.com/users/<?php echo $row['username']; ?>"><?php echo $row['username']; ?></a> <?php echo $row['activity']; ?></div>
					<?
				}
				?>
			</div>
		</div>
		<button class="add" onclick="parent.location='/lists/create';">Add a New List</button>
		<hr style="visibility: hidden; height: 50px; style: block;" />
		
		<div class="lists">
            <h3 class="tab active" id="yl" onclick="tab('yl');">Your Lists</h3><h3 id="favorites" class="tab unactive" onclick="tab('favorites');">Favorites</h3><h3 id="featured" class="tab unactive" onclick="tab('featured');">Featured</h3><h3 id="browse" class="tab unactive" onclick="tab('browse');">Browse</h3>
            <div id="yl-list" class="list" style="display: block;">Loading...</div>
            <div id="favorites-list" class="list"style="display: none">Loading...</div>
			<div id="featured-list" class="list"style="display: none">Loading...</div>
			<div id="browse-list" class="list"style="display: none">Loading...</div>
		</div>
		
	</div>
	<!--// end Main Content -->
	
	<?php include SRV_ROOT . '/apps/tasks/includes/eternityx/body-bottom.php'; ?>
</body>
</html>

<?php
/* END OF FILE */