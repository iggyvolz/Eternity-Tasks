<?php
include 'includes/eternityx/php.php';

	$result = $db->query("SELECT * FROM tasks_code WHERE id='$_GET[id]'"); // start query

	// fetch profile variables
	while($row = $db->create_array($result))
        {
		$css = $row['Css'];
		$js = $row['Javascript'];
		$html = $row['Html'];
	}
?>

<html>
<head>
<style type="text/css">
<?php echo "$css"; ?>
</style>
<script type="text/JavaScript">
<?php echo"$js"; ?>
</script>
</head>
<body>
<?php echo"$html"; ?>
</body>
</html>