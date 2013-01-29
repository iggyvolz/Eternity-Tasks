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
clearstatcache()


?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- Meta Data -->
	<?php include 'includes/eternityx/meta.php'; ?>
	
	<meta name="author" content="Eternity Incurakai" /> 
	<meta name="description" content="Team tasks system" /> 
	<meta name="keywords" content="All if the team can collaborate here" /> 
	<!--// End Meta Data -->
	
	<!-- Title -->
	<title>Eternity Incurakai Tasks</title>
	<!--// End Title -->
	
	<!-- Assets -->
	<?php include 'includes/eternityx/assets.php'; ?>
	<script type="text/javascript" src="/assets/js/homecanvas.js"></script>
	<!--// end Assets -->
</head>
<body onload="init();">
	<?php include SRV_ROOT . '/apps/tasks/includes/eternityx/body-top.php'; ?>
	
	<!-- Main Content -->
	<div id="container">
		<?php include 'includes/interface/header.php'; ?>
		<section>
			<div style="text-align:center;">
				<img src="http://eternityinc-official.com/apps/tasks/eternity tasks logo.png" alt="Eternity Incurakai" style="width: 500px; vertical-align: middle; display: inline-block;" />
			</div>
			
			<h1>Welcome to Eternity Tasks 3.0</h1>
		</section>
		<canvas id="canvas" width="400" height="400" style="border: 1px solid black;"></canvas>
		<section>
			<p>Welcome to the Eternity Tasks 3.0 system, here the team can collaborate on their current jobs</p><br />
            <div style="text-align:center">
				<?php if($_SESSION['rank']=="Eternity Team") {
					echo"<input type=\"button\" onclick=\"parent.location='http://eternityinc-official.com/apps/tasks/dash'\" value=\"Enter Tasks\" title=\"Enter the task dashboard\" />";} else{echo"We're sorry but we can only permit Eternity Team members beyond this point, if you are an eternity team member please log-in";}?>
			</div>
			
		</section>
	</div>
	<!--// end Main Content -->
	
	<?php include SRV_ROOT . '/apps/tasks/includes/eternityx/body-bottom.php'; ?>
</body>
</html>

<?php
/* END OF FILE */