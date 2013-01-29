/**
	* Eternity Tasks 3.0 [EternityX app/addon]
	* http://tasks.eternityinc-official.com
	*
	* (C) 2013 Eternity Incurakai Studios, All Rights Reserved
	* Licensed under the ESCLv1 License
	* http://eternityinc-official.com/license
*/



/**
	* This file includes functions that are used to operate on AJAX for the 
	* lists viewer (http://tasks.eternityinc-official.com/lists/view/##)
	* file: /list_view.php
	* for PHP functions, please see /includes/lists/list-tasks.php
*/

/** 
	* PHP LISTENER: list_delete_task()
	*
	* PARAMETERS:
	* list - the list that the task is being deleted from
 	* task - the task that is being deleted 
	* 
	* DESCRIPTION:
	* This function communicates with PHP via AJAX to delete the specified task
	*
*/

function list_delete_task(list, task) {	
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else {
		 req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	req.open("POST", "/lists/view/"+list, true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	req.send("type=list_delete_task&taskid=" + encodeURIComponent(task));

	req.onreadystatechange = function() {
		if (req.readyState==4 && req.status==200) {
			document.getElementById(task).innerHTML = '<img src="/assets/images/progress.gif"  style="vertical-align: middle; margin-right: 10px;"/>Deleting';
		
			// set first timeout
			var timeout2 = 'document.getElementById("'+task+'").innerHTML = \'<img src="/assets/images/check.png"  style="height: 50px; width: 50px; vertical-align: middle; margin-right: 10px;"/>Deleted!\'';
			setInterval(timeout2, 1000);
			
			// set second timeout
			var timeout = 'document.getElementById("'+task+'").style.opacity = "0"';
			setInterval(timeout, 2000);
					
			// set third timeout
			var timeout3 = 'document.getElementById("'+task+'").style.display = "none"';
			setInterval(timeout3, 3000);

		} else {
		}
	}
}


/** 
	* PHP LISTENER: task_to_no()
	*
	* PARAMETERS:
	* list - the list that the task is being marked as incomplete
 	* task - the task that is being deleted 
	* 
	* DESCRIPTION:
	* This function communicates with PHP via AJAX to mark as incomplete
	*
*/

function task_to_no(list, task) {
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else {
		req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	req.open("POST", "/lists/view/"+list, true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	req.send("type=task_to_no&task=" + encodeURIComponent(task));

	req.onreadystatechange = function() {
		if (req.readyState==4 && req.status==200) {
			document.getElementById(task+"check").onclick = task_to_yes(list, task);
		} else {
		}
	}
}


/** 
	* PHP LISTENER: task_to_yes()
	*
	* PARAMETERS:
	* list - the list that the task is being marked as complete
 	* task - the task that is being deleted 
	* 
	* DESCRIPTION:
	* This function communicates with PHP via AJAX to mark as complete
	*
*/

function task_to_yes(list, task) {
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else {
		 req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	req.open("POST", "/lists/view/"+list, true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	req.send("type=task_to_yes&task=" + encodeURIComponent(task));

	req.onreadystatechange = function() {
		if (req.readyState==4 && req.status==200) {
			document.getElementById(task+"check").onclick = task_to_no(list, task);
		} else {
		}
	}
}


/** 
	* PHP LISTENER: task_update_title()
	*
	* PARAMETERS:
	* list - the list that the task is being marked as complete
 	* title - the new task title value 
	* task - the task id
	* 
	* DESCRIPTION:
	* This function communicates with PHP via AJAX to update the title of a task.
	*
*/

function task_update_title(list, title, task) {
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else {
		 req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	req.open("POST", "/lists/view/"+list, true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	req.send("type=task_title&title=" + encodeURIComponent(title) + "&task=" + encodeURIComponent(task));

	req.onreadystatechange = function() {
		if (req.readyState==4 && req.status==200) {
			document.getElementById(task+'name').value = req.responseText;
			if(document.getElementById(task+'name').value == "Title Must Be at least 3 Characters")
			{
				var timeout = "document.getElementById('"+task+"name').value = 'Click to Edit'";
				setTimeout(timeout, 1000);
				
				document.getElementById(task+'name').style.background = "yellow";
				var save = 'document.getElementById("'+task+'name").style.background = "none"';
				setTimeout(save, 1000);
			}
			else 
			{
				document.getElementById(task+'name').value = req.responseText;
				document.getElementById(task+'name').style.background = "yellow";
				var save = 'document.getElementById("'+task+'name").style.background = "none"';
				setTimeout(save, 2000);
			}
		} else {
		}
	}
}

/**
	* PHP LISTENER: task_show_details()
	*
	* PARAMETERS:
	* list - the list that the task is being shown for details
	* task - the task id
	* 
	* DESCRIPTION:
	* This function communicates with PHP via AJAX to show the details of a task.
	*
*/

function task_show_details(list, task) {
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else {
		 req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	req.open("POST", "/lists/view/"+list, true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	req.send("type=task_show_details&task=" + encodeURIComponent(task));

	req.onreadystatechange = function() {
		if (req.readyState==4 && req.status==200) {
			// display the details 
			document.getElementById(task+"details").style.display = "block";
			document.getElementById(task+"details").innerHTML = req.responseText;
			
			// adjust links and innerHTML
			document.getElementById(task+"button").href = "javascript:task_hide_details('"+list+"','"+task+"');";
			document.getElementById(task+"button").innerHTML = "<img title=\"Hide Details\" onmousedown=\"this.ondragstart = function() { return false; }\" src=\"/assets/images/arrow-invert.png\" />";
			
		} else {
			document.getElementById(task+"details").style.display = "block";
			document.getElementById(task+"button").href = "";
					
		}
	}
}



/**
	* PHP LISTENER: task_details_edit_done()
	*
	* PARAMETERS:
	* list - the list of the updated task
	* description - the new description
 	* date - the new due date
 	* task - the id of the task
	*
 	*  
	* DESCRIPTION:
	*
*/
function task_details_edit_done(list, description, date, task) {
	// check for an empty pass in value
	if(!description) {
		description = " ";
	}
			
	//continue with AJAX
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else {
		 req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	req.open("POST", "/lists/view/"+list, true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	req.send("type=task_details_edit_done&description=" + encodeURIComponent(description) + "&date=" + encodeURIComponent(date) + "&id=" + encodeURIComponent(task));

	req.onreadystatechange = function() {
		if (req.readyState==4 && req.status==200) {
			document.getElementById(task+'details').innerHTML = req.responseText;
		} else {
		}
	}
}