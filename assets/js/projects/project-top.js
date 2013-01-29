/**
 * This function updates the project title within the project viewing page (project_view.php) used as a function to communicate with PHP.
 * 
 * @param title 	The new title of the project
 * @param id		the id of the project
 * @author XenoK Xihelien
 * @copyright 2012 Eternity Incurakai
 */
function projects_updatetitle(title, id) {
	
	
	// we're checking if the notification function is running.  If this runs while the notification function is
	// checking,  we might get some errors, so DONT REMOVE THIS IF STATEMENT EITHER.
	if(titledelay == false) {
		// we're telling the notification function not to run, otherwise we are going to get some messed up errors.  
		// DO NOT REMOVE THE FOLLOWING LINE!!
		delay = true;
		if (window.XMLHttpRequest) {
			req = new XMLHttpRequest();
		} 
		else {
			req = new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		// AJAX Stuff...
		req.open("POST", "/projects/"+id, true);
		req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
		req.send("type=projects_updatetitle&title=" + encodeURIComponent(title));
	
		req.onreadystatechange = function() {
			
			if (req.readyState==4 && req.status==200) {
				// set variables 
				var title = document.getElementById('title');
				var notifier = document.getElementById('changes_saved');
				
				// do something with the notification bar that pops up
				notifier.innerHTML = "Changes Saved";
				notifier.style.opacity = "1";
				
				// do something with the title box
				title.value = req.responseText;
				title.style.bordercolor = "transparent";
				title.style.background = "yellow";
				
				// do something with both
				var save = 'title.style.background = "none"; document.getElementById("changes_saved").style.opacity = "0"';
				setTimeout(save, 2000);
				delay = false;
				titledelay = false;
			} 
			else {
				// set variables
				var title = document.getElementById('title');			
				var notifier = document.getElementById('changes_saved');
				
				// display an error!!!
				notifier.innerHTML = "Error";
				notifier.style.opacity = "1";
				var save = 'document.getElementById("changes_saved").style.opacity = "0"';
				setTimeout(save, 2000);
				delay = false;
				titledelay = false;
			}
	}  
	}
}



function projects_updatedescription(description, id) {
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} 
	else {
		req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	req.open("POST", "/projects/"+id, true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	req.send("type=projects_updatedescription&description=" + encodeURIComponent(description));

	req.onreadystatechange = function() {
		if (req.readyState==4 && req.status==200) {
			document.getElementById('description').innerHTML = '<strong contenteditable="false">Description:</strong>'+req.responseText;
			document.getElementById('description').style.background = "yellow";
			var save = 'document.getElementById("description").style.background = "none"';
			setInterval(save, 10000);
		} 
		else {
		}
	}
}

function tab(tabb, id) {
	if (window.XMLHttpRequest) {
		req = new XMLHttpRequest();
	} 
	else {
		req = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	req.open("POST", "/projects/"+id, true);
	req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
	req.send("type=projects_tab&tabtype=" + encodeURIComponent(tabb));

	req.onreadystatechange = function() {
		if (req.readyState==4 && req.status==200) {
			document.getElementById(tabb+"-tab").innerHTML = req.responseText;
		} 
		else {
		}
	}
}
