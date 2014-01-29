// var cookie = document.cookie;
function setSidebarPinned(pinned)
{
	if (pinned)
		$("body").addClass("withSidebar");
	else
		$("body").removeClass("withSidebar");
	
	$("SIDEBAR_PIN").title = "Click here to " + (pinned ? "un" : "" ) + "pin the sidebar";
	
	setCookie("pinSidebar", pinned);
    /*document.cookie = "pinSidebar=" +
	                  encodeURIComponent(pinned ? "true" : "false") +
	                  "; max-age=" + (60 * 60 * 24 * 28) + // Live for 28 days. Change the "28" to change the number of days.
	                  "; path=/" + 
	                  "; domain=herdmind.net";*/
}