function init(){
	
	//Canvas stuff
	var canvas = document.getElementById('canvas');
	var ctx = canvas.getContext("2d");
	
	var logo = new Image();
	logo.onload = function() {
		ctx.drawImage(logo, 65, 0, 300, 100);
	}
	logo.src = "http://tasks.eternityinc-official.com/eternity tasks logo.png";
	
	function entertext(text, x, y) {
		ctx.font="14px Tahoma";
   		ctx.fillText(text, x, y);
	}
	
	// create text
	setTimeout(function(){ entertext("Welcome!", 65, 150); }, 1000);
	setTimeout(function(){ entertext("With Eternity Tasks, task management is made easy!", 0, 200); }, 2000);
	setTimeout(function(){ entertext("Click here to get started.", 65, 250); 
		canvas.onclick = function() { parent.location = "/lists"; }
	}, 3000);
	
	
}



