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
	* for php functions, please see /includes/lists/list-top.php
*/


/** 
	* PHP LISTENER: list_update_title()
	*
	* PARAMETERS:
	* title - the updated value for the new title
	* list - the value of the list's id
	*
	* DESCRIPTION:
	* This function communicates with PHP via AJAX to update the title of a list
	*
*/
function list_update_title(title, list) {
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else {
		 req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	req.open("POST", "/lists/view/"+list, true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	req.send("type=list_update_title&title=" + encodeURIComponent(title));

	req.onreadystatechange = function() {
		if (req.readyState==4 && req.status==200) {
			document.getElementById('title').value = req.responseText;
			document.getElementById('title').style.background = "yellow";
			var save = 'document.getElementById("title").style.background = "none"';
			setInterval(save, 2000);
		} else {
		}
	}
}

/** 
	* PHP LISTENER: list_update_description()
	*
	* PARAMETERS:
	* description - the updated value for the new description
	* list - the value of the list's id
	*
	* DESCRIPTION:
	* This function communicates with PHP via AJAX to update the description of a list
	*
*/
function list_update_description(description, list) {
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else {
		 req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	req.open("POST", "/lists/view/"+list, true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	req.send("type=list_update_description&description=" + encodeURIComponent(description));

	req.onreadystatechange = function() {
		if (req.readyState==4 && req.status==200) {
			document.getElementById('description').value = req.responseText;
			document.getElementById('description').style.background = "yellow";
			var save = 'document.getElementById("description").style.background = "none"';
			setInterval(save, 2000);
		} else {
		}
	}
}
		
		