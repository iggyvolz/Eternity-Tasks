function overlay()
{
	document.getElementById("overlay").style.display = "block";
	document.getElementById('backdrop').style.display = "block";
	document.getElementById('backdrop').onclick = function () {
		document.getElementById('overlay').style.display = "none";
		document.getElementById('backdrop').style.display = "none";
	}
	document.getElementById('task_name').value = "";
	document.getElementById('task_description').value = "";
	document.getElementById('task_date').value = "";
	
}
		
function overlay_close () {
	document.getElementById('overlay').style.display = "none";
	document.getElementById('backdrop').style.display = "none";
}

function overlay_check() {
	if(document.getElementById('task_name').value) { list_add_task(document.getElementById('task_name').value, document.getElementById('task_description').value); } else { document.getElementById('error').innerHTML = 'Please fill out this field.' }
}


