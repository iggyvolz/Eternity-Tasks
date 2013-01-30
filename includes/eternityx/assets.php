<link rel="stylesheet" href="http://eternityinc-official.com/assets/style/style.css" />
<link rel="stylesheet" href="http://tasks.eternityinc-official.com/assets/style/style.css" /> 
<link rel="icon" type="image/png" href="http://eternityinc-official.com/assets/images/favicon.png" /> 
<link rel="apple-touch-icon" href="http://eternityinc-official.com/assets/images/touchicon.png" /> 
<script src="http://eternityinc-official.com/assets/js/behavior.js"></script>

	

	<!-- Google Analytics -->
	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-28493253-3']);
		_gaq.push(['_setDomainName', 'eternityinc-official.com']);
		_gaq.push(['_trackPageview']);

		(function() {
			var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
	<!--// End Google Analytics -->
	


<script type="text/javascript">

	function invitescheck() {
		
		if(delay == false) {
			titledelay = true;
			descriptiondelay = true;
			if (window.XMLHttpRequest) {
				req = new XMLHttpRequest();
			} 
			else {
				req = new ActiveXObject("Microsoft.XMLHTTP");
			}
			
			req.open("POST", "/", true);
			req.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
			req.send("function=yes");
	 
			req.onreadystatechange = function() {
				if (req.readyState==4 && req.status==200) {
					document.getElementById('notifierx').innerHTML = req.responseText + " notifications";
					titledelay = false;
					descriptiondelay = false;
				} 
				else {
	           			titledelay = false;
	           			descriptiondelay = false;
				}
			}
		}
	}
	var delay = false;
	var titledelay = false;
	var descriptiondelay = false;
	setInterval(function() { invitescheck(); }, 1000);
	
</script>
