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
	* favorites tab in the lists index (http://tasks.eternityinc-official.com/lists)
	* file: /list_index.php
	* for php functions, please see /includes/tabs/favorites.php
*/



/** 
	* PHP LISTENER: favorites_display()
	*
	* PARAMETERS:
	* (none)
	*
	* DESCRIPTION:
	* This function displays the favorites tab's list.  
	*
*/
function favorites_display()  {
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else {
		req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	req.open("POST", "/lists", true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	req.send("type=favorites_display");

	req.onreadystatechange = function() {
		if (req.readyState==4 && req.status==200) {
			document.getElementById('favorites-list').innerHTML = req.responseText;
		} else {
		}
	}
}


/** 
	* PHP LISTENER: favorites_remove()
	*
	* PARAMETERS:
	* id - the id of the list to remove from favorites
	*
	* DESCRIPTION:
	* This function displays the favorites tab's list.  
	*
*/
function favorites_remove(id)  {
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else {
		req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	req.open("POST", "/lists", true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	req.send("type=favorites_remove&list=" + encodeURIComponent(id));

	req.onreadystatechange = function() {
		if (req.readyState==4 && req.status==200) {
			document.getElementById('favorites-list').innerHTML = req.responseText;
		} else {
		}
	}
}