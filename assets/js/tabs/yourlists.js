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
	* yourlists tab in the lists index (http://tasks.eternityinc-official.com/lists)
	* file: /list_index.php
	* for php functions, please see /includes/tabs/yourlists.php
*/

/** 
	* PHP LISTENER: yourlists_display()
	*
	* PARAMETERS:
	* (none)
	*
	* DESCRIPTION:
	* This function displays the yourlists tab's list.  
	*
*/
function yourlists_display() {
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else {
		req = new ActiveXObject("Microsoft.XMLHTTP");
	}
		req.open("POST", "/lists", true);
		req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		req.send("type=yourlists_display");

		req.onreadystatechange = function() {
		if (req.readyState==4 && req.status==200) {
			document.getElementById('yl-list').innerHTML = req.responseText;
			} else {
		}
	}
}

/** 
	* PHP LISTENER: list_delete()
	*
	* PARAMETERS:
	* (none)
	*
	* DESCRIPTION:
	* This function deletes a list.  
	*
*/
function list_delete(list) {			
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else {
		 req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	req.open("POST", "/lists", true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	req.send("type=list_delete&list=" + encodeURIComponent(list));

	req.onreadystatechange = function() {
		if (req.readyState==4 && req.status==200) {
			document.getElementById('prompt').innerHTML = req.responseText;					
		} else {
		}
	}
}


/* TOGGLERS: these toggle between showing links, and not showing links */
function yl_row_links(id)
{
	document.getElementById(id+"links").style.display = "inline-block";
}

function hide_yl_row_links(id)
{
	document.getElementById(id+"links").style.display = "none";
}
		