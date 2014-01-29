
function switchStyles()
{
	var temp = document.getElementById("STYLE_SELECTOR_SELECT");//for debugging
	temp = temp.value;
	switch_style(temp);
}

var retry = false;
function switchStyles ( selector ) // selector MUST be a DOM <SELECT> element
{
// You may use this script on your site free of charge provided
// you do not remove this notice or the URL below. Script from
// http://www.thesitewizard.com/javascripts/change-style-sheets.shtml

// A note form Blue Husky Studios: This script has been changed from its original writing, but the philosophy is the same
	var i, link_tag, hit = false;
	var css_title = selector.value;
	for (i = 0, link_tag = document.getElementsByTagName("link"); i < link_tag.length ; i++)
	{
		if ((link_tag[i].rel.indexOf("stylesheet") != -1) && link_tag[i].title)
		{
			link_tag[i].disabled = true;
			if (link_tag[i].title == css_title && css_title != "None")
			{
				link_tag[i].disabled = false;
				hit = true;
			}
			//else if (link_tag[i].title == "dock_" + css_title)
			//	link_tag[i].disabled = false;
		}
	}
	selector.value = css_title;//In case an automated process, like set_style_from_cookie, called this, and there is a manual style switcher on the page
}