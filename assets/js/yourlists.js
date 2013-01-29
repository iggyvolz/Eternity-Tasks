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