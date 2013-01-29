/**
	* Eternity Tasks 3.0 [EternityX app/addon]
	* http://tasks.eternityinc-official.com
	*
	* (C) 2013 Eternity Incurakai Studios, All Rights Reserved
	* Licensed under the ESCLv1 License
	* http://eternityinc-official.com/license
*/

function tab(tab)
{
	document.getElementById(tab).classList.remove('unactive');
	if(tab == "favorites")
	{
		// unactives
		document.getElementById("yl").classList.add('unactive');
		document.getElementById("featured").classList.add('unactive');
		document.getElementById("browse").classList.add('unactive');
		
		// lists
		document.getElementById("browse-list").style.display = "none";
		document.getElementById("yl-list").style.display = "none";
		document.getElementById("featured-list").style.display = "none";
		document.getElementById("favorites-list").style.display = "block";
		favorites_display();
	}
	else if(tab == 'yl')
	{
		// unactives
		document.getElementById("favorites").classList.add('unactive');
		document.getElementById("featured").classList.add('unactive');
		document.getElementById("browse").classList.add('unactive');
		
		// lists
		document.getElementById("browse-list").style.display = "none";
		document.getElementById("yl-list").style.display = "block";
		document.getElementById("featured-list").style.display = "none";
		document.getElementById("favorites-list").style.display = "none";
		yourlists_display();
	}
	else if(tab == 'featured')
	{
		// unactives
		document.getElementById("favorites").classList.add('unactive');
		document.getElementById("yl").classList.add('unactive');
		document.getElementById("browse").classList.add('unactive');
		
		// lists
		document.getElementById("browse-list").style.display = "none";
		document.getElementById("yl-list").style.display = "none";
		document.getElementById("featured-list").style.display = "block";
		document.getElementById("favorites-list").style.display = "none";
		featured_display();
	}
	else if(tab == 'browse')
	{
		// unactives
		document.getElementById("featured").classList.add('unactive');
		document.getElementById("favorites").classList.add('unactive');
		document.getElementById("yl").classList.add('unactive');
		
		// lists
		document.getElementById("browse-list").style.display = "block";
		document.getElementById("yl-list").style.display = "none";
		document.getElementById("featured-list").style.display = "none";
		document.getElementById("favorites-list").style.display = "none";
		browse_display();
	}
}