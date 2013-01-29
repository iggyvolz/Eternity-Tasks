/**
	* Eternity Tasks 3.0 [EternityX app/addon]
	* http://tasks.eternityinc-official.com
	*
	* (C) 2013 Eternity Incurakai Studios, All Rights Reserved
	* Licensed under the ESCLv1 License
	* http://eternityinc-official.com/license
*/



/**
	* This file includes some functions that are relevant to buttons in the HTML,
	* that need some behavior, that don't involve AJAX.
*/


/**
	* this function shows a tooltip for buttons in lists_view.php, given the tip parameter
*/
function showtip(tip) {
	document.getElementById(tip+"-arrow-left").style.visibility = "visible";
	document.getElementById(tip+"-tooltip").style.visibility = "visible";
}


/**
	* this function hides a tooltip for buttons in lists_view.php, given the tip parameter 
*/
function hidetip(tip) {
	document.getElementById(tip+"-arrow-left").style.visibility = "hidden";
	document.getElementById(tip+"-tooltip").style.visibility = "hidden";
	
}


/**
	* this function hides the details of a task in lists_view.php, given the task parameter.
*/
function task_hide_details(list, task)
{	
	// update the div area
	document.getElementById(task+"details").style.display = "none";
	document.getElementById(task+"details").innerHTML = "";
			
	// update the anchor tag.
	document.getElementById(task+"button").href = "javascript:task_show_details('"+list+"', '"+task+"');";
	document.getElementById(task+"button").innerHTML = "<img title=\"Show Details\" onmousedown=\"this.ondragstart = function() { return false; }\" src=\"/assets/images/arrow.png\" />";
}


/**
	* this function shows a form for editing a task's details.
*/
function task_details_edit(list, task, description, date)
{
	// update the task details div area.
	document.getElementById(task+"details").innerHTML = "<strong>Description:</strong> <textarea style=\"opacity: 1;\" id=\""+task+"textarea\" >"+description+"</textarea><br /><br /><strong>Due Date: </strong> <input type=\"date\" id=\""+task+"date\" value=\""+date+"\"/><a class=\"icon\" style=\"text-align: right; display: block;\" href=\"javascript:task_details_edit_done(\'"+list+"\', document.getElementById(\'"+task+"textarea\').value, document.getElementById(\'"+task+"date\').value, '"+task+"');\" style=\"vertical-align: top;\"><img title=\"done\" onmousedown=\"this.ondragstart = function() { return false; }\" src=\"/assets/images/pencil-done.png\" /></a>";
}