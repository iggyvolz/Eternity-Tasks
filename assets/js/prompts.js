/**
	* Eternity Tasks 3.0 [EternityX app/addon]
	* http://tasks.eternityinc-official.com
	*
	* (C) 2013 Eternity Incurakai Studios, All Rights Reserved
	* Licensed under the ESCLv1 License
	* http://eternityinc-official.com/license
*/



/**
	* This file includes functions that are used for prompting the user
*/


/**
	* this function is used when the user clicks on the list delete button in
	* list_view.php to delete the list.  It shows a prompt, asking if they are sure 
	* that they want to delete the list.
*/
function list_delete_confirm(list) {	
	document.getElementById('prompt').style.display = "block";
	document.getElementById('backdrop').style.display = "block";
}	
		