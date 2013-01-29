
/**
	* PHP retriever: update_task_name()
	*
*/
function list_update_title(title) 
{
	if (window.XMLHttpRequest) 
	{
		req = new XMLHttpRequest();
	} 
	else 
	{
		req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	req.open("POST", "", true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	req.send("type=list-title&title=" + encodeURIComponent(title) + "&id=<?php echo $lid; ?>");

	req.onreadystatechange = function() 
	{
		if (req.readyState==4 && req.status==200) 
		{
			document.getElementById('title').value = req.responseText;
			document.getElementById('title').style.background = "yellow";
			var save = 'document.getElementById("title").style.background = "none"';
			setInterval(save, 2000);
		} 
		else 
		{
		}
	}
}
		
