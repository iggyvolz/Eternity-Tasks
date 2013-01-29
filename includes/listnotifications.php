<?php

include 'eternityx/php.php';

$date = date(Y . '-' . m . '-' . d);
echo $date;
$query = $db->fetch($db->query("SELECT `list` FROM tasks_tasks WHERE `due date`='" . $date . "' AND complete='no' LIMIT 1"));

	$user = $db->fetch($db->query("SELECT `creator` FROM tasks_lists WHERE `id`='" . $db->escape($query) . "'"));
	
	$name = $db->fetch($db->query("SELECT `name` FROM tasks_tasks WHERE `list`='" . $db->escape($query) . "' LIMIT 1"));
	
	$db->query("INSERT INTO messages (`to`, `from`, `subject`, `message`) VALUES ('" . $user . "', 'Eternity Tasks Reminder', '" . $db->escape($name) . " Task due', 'You have a task due by the name of " . $db->escape($name) . "  [url=http://tasks.eternityinc-official.com/lists/view/" . $db->escape($query) . "]Click Here[/url] to view it.')") or error(e0001, $db->error());