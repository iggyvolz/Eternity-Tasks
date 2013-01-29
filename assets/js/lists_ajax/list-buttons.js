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
	* for PHP functions, please see /includes/lists/list-buttons.php
*/

/********************************************************* PRIVATE / PUBLIC *********************************************************************/

/** 
	* PHP LISTENER: list_to_private()
	*
	* PARAMETERS:
	* list - the value of the list's id
 	* button - the button's instance	
	*
	* DESCRIPTION:
	* This function communicates with PHP via AJAX to set the list to private mode.
	*
*/
function list_to_private(list, button) {			
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else {
		 req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	req.open("POST", "/lists/view/"+list, true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	req.send("type=list_to_private&list=" + encodeURIComponent(list));

	req.onreadystatechange = function() {
		if (req.readyState==4 && req.status==200) {
			var parent = document.getElementById("buttons");
			var child = document.getElementById(button);
			parent.removeChild(child);
			parent.innerHTML = req.responseText + parent.innerHTML;
			
		} else {
		}
	}
}	

/** 
	* PHP LISTENER: list_to_public()
	*
	* PARAMETERS:
	* list - the value of the list's id
 	* button - the button's instance	
	*
	* DESCRIPTION:
	* This function communicates with PHP via AJAX to set the list to public mode.
	*
*/

function list_to_public(list, button) {			
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else {
		 req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	req.open("POST", "/lists/view/"+list, true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	req.send("type=list_to_public&list=" + encodeURIComponent(list));

	req.onreadystatechange = function() {
		if (req.readyState==4 && req.status==200) {
			var parent = document.getElementById("buttons");
			var child = document.getElementById(button);
			parent.removeChild(child);
			parent.innerHTML = req.responseText + parent.innerHTML;
			
		} else {
		}
	}
}	



/********************************************************* FAVORITE / UNFAVORITE *********************************************************************/

/** 
	* PHP LISTENER: list_remove_favorite()
	*
	* PARAMETERS:
	* list - the value of the list's id
 	* button - the button's instance	
	*
	* DESCRIPTION:
	* This function communicates with PHP via AJAX to unfavorite the list
	*
*/

function list_remove_favorite(list, button) {			
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else {
		 req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	req.open("POST", "/lists/view/"+list, true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	req.send("type=list_remove_favorite&list=" + encodeURIComponent(list));

	req.onreadystatechange = function() {
		if (req.readyState==4 && req.status==200) {
			var parent = document.getElementById("buttons");
			var child = document.getElementById(button);
			parent.removeChild(child);
			parent.innerHTML = parent.innerHTML + req.responseText;
			
		} else {
		}
	}
}


/** 
	* PHP LISTENER: list_add_favorite()
	*
	* PARAMETERS:
	* list - the value of the list's id
 	* button - the button's instance	
	*
	* DESCRIPTION:
	* This function communicates with PHP via AJAX to favorite the list
	*
*/

function list_add_favorite(list, button) {			
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else {
		 req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	req.open("POST", "/lists/view/"+list, true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	req.send("type=list_add_favorite&list=" + encodeURIComponent(list));

	req.onreadystatechange = function() {
		if (req.readyState==4 && req.status==200) {
			var parent = document.getElementById("buttons");
			var child = document.getElementById(button);
			parent.removeChild(child);
			parent.innerHTML = parent.innerHTML + req.responseText;
			
		} else {
		}
	}
}


/********************************************************* ADD A TASK *********************************************************************/

/** 
	* PHP LISTENER: list_add_favorite()
	*
	* PARAMETERS:
	* list - the list that the task is being added to
	* name - the name of the task to add
 	* description - the description of the task to add
 	* date - the due date of the task to add	
	*
	* DESCRIPTION:
	* This function communicates with PHP via AJAX to add a new task to the list.
	*
*/

id = 0;
function list_add_task(list, name, description, date) {		
	if(id == 0)
	{
		++id;
	}
	
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else {
		 req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	req.open("POST", "/lists/view/"+list, true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	req.send("type=list_add_task&name=" + encodeURIComponent(name) + "&description=" + encodeURIComponent(description) + "&date=" + encodeURIComponent(date) + "&tid=" + id);

	req.onreadystatechange = function() {
		if (req.readyState==4 && req.status==200) {
			// add the new task and close the overlay
			document.getElementById('new_tasks').innerHTML = req.responseText + document.getElementById('new_tasks').innerHTML;
			overlay_close();
			
			// add a timeout for the new task indicator
			var timeout = 'document.getElementById("new'+id+'").style.opacity = "0"';
			setInterval(timeout, 1000);
			
			// add a 2nd timeout for the new task indicator
			var timeout2 = 'document.getElementById("new'+id+'").style.display = "none"';
			setInterval(timeout2, 2000);
			id++;
			
			var parent = document.getElementById("new_tasks");
			var child = document.getElementById("new"+id);
			parent.removeChild(child);
		} else {
		}
	}
}



/********************************************************* LIST DELETION *********************************************************************/

/** 
	* PHP LISTENER: list_delete()
	*
	* PARAMETERS:
	* list - the list that is being deleted
	* 
	* DESCRIPTION:
	* This function communicates with PHP via AJAX to delete the list
	*
*/


function list_delete(list) {			
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else {
		 req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	req.open("POST", "/lists/view/"+list, true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	req.send("type=list_delete&list=" + encodeURIComponent(list));

	req.onreadystatechange = function() {
		if (req.readyState==4 && req.status==200) {
			document.getElementById('prompt').innerHTML = req.responseText;					
		} else {
		}
	}
}

