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
	* featured tab in the lists index (http://tasks.eternityinc-official.com/lists)
	* file: /list_index.php
	* for php functions, please see /includes/tabs/featured.php
*/


/** 
	* PHP LISTENER: featured_display()
	*
	* PARAMETERS:
	* (none)
	*
	* DESCRIPTION:
	* This function displays the featured tab's list.  
	*
*/

function featured_display() {
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else {
		req = new ActiveXObject("Microsoft.XMLHTTP");
	}
		req.open("POST", "/lists", true);
		req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		req.send("type=featured_display");

		req.onreadystatechange = function() {
		if (req.readyState==4 && req.status==200) {
			document.getElementById('featured-list').innerHTML = req.responseText;
			} else {
		}
	}
}




function featured_add_overlay() {
	document.getElementById('backdrop').style.display = "block";
	document.getElementById('featured-overlay').style.display = "block";
}

function featured_add_overlay_close() {
	document.getElementById('backdrop').style.display = "none";
	document.getElementById('featured-overlay').style.display = "none";
}

/** 
	* PHP LISTENER: featured_add()
	*
	* PARAMETERS:
	* id - the id of the list to add
	*
	* DESCRIPTION:
	* This function adds a specific tasks list to the featured tab.  
	*
*/
function featured_add(id) {
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else {
		req = new ActiveXObject("Microsoft.XMLHTTP");
	}
		req.open("POST", "/lists", true);
		req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		req.send("type=featured_add&id="+encodeURIComponent(id));

		req.onreadystatechange = function() {
		if (req.readyState==4 && req.status==200) {
			document.getElementById('backdrop').style.display = "none";
			document.getElementById('featured-list').innerHTML = req.responseText;					
			} else {
		}
	}
}

/** 
	* PHP LISTENER: featured_remove()
	*
	* PARAMETERS:
	* id - the id of the list to remove
	*
	* DESCRIPTION:
	* This function removes a specific tasks list from the featured tab.  
	*
*/
function featured_remove(id) {
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} else {
		req = new ActiveXObject("Microsoft.XMLHTTP");
	}
		req.open("POST", "/lists", true);
		req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		req.send("type=featured_remove&id="+encodeURIComponent(id));

		req.onreadystatechange = function() {
		if (req.readyState==4 && req.status==200) {
			document.getElementById('featured-list').innerHTML = req.responseText;
					
			} else {
		}
	}
}


/** TOGGLERS: THESE TOGGLE SHOWING THE DESCRIPTION AND/OR  ADMIN REMOVER **/
function featured_row_description(taskid)
{
	document.getElementById(taskid+"description").style.opacity = "0";
	document.getElementById(taskid+"description").style.display = "block";
	setTimeout(function(){document.getElementById(taskid+"description").style.opacity = "1";}, 100);

}


function hide_featured_row_description(taskid)
{	
	document.getElementById(taskid+"description").style.opacity = "1";
	setTimeout(function(){document.getElementById(taskid+"description").style.opacity = "0";}, 100);
	document.getElementById(taskid+"description").style.display = "none";
	
}

function featured_row_show_remover(id)
{
	document.getElementById(id+"Remove").style.opacity = "0";
	document.getElementById(id+"Remove").style.display = "block";
	setTimeout(function(){document.getElementById(id+"Remove").style.opacity = "1";}, 100);
}

function featured_row_hide_remover(id)
{
	document.getElementById(id+"Remove").style.display = "none";
	setTimeout(function(){document.getElementById(id+"Remove").style.opacity = "0";}, 100);
}


