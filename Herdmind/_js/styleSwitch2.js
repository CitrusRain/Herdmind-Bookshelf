var sheetElement = document.getElementById("_switchSheet");
var backupSheetElement = document.getElementById("_switchSheetBackup");
var lastUsedStyleSheet = false;

sheetElement.disabled = false;
if (backupSheetElement)
	backupSheetElement.disabled = false;
else
	console.log("No backup sheet detected. Style switching may be twitchy.");

var useCookies = true;
// try
// {
	// const COOKIE_NAME = "herdmindLastSetStyle";
// }
// catch (e)
// {
	var COOKIE_NAME = "herdmindLastSetStyle";
// }

/* Set the style via cookies on page load. Uncomment this if the PHP cookie reading isn't working.
if(window.attachEvent)
    window.attachEvent('onload', setStyleFromCookie);
else if(window.addEventListener)
    window.addEventListener('load', setStyleFromCookie, true);
*/



function switchStyles(selectElement)
{
	if (sheetElement == null && (sheetElement = document.getElementById("_switchSheet")) == null)
		alert("The developers done messed up. Go tell them that this popup is annoying and it's their fault.");
	switchStyleTo(selectElement.value);
}

function switchStyleTo(newSheet)
{
	sheetElement.href = (newSheet == backupSheetElement.href) ? null : newSheet;
	
	setCookie(COOKIE_NAME, newSheet);
}



function setUseCookies(shouldUseCookies)
{
	useCookies = shouldUseCookies;
}

/*function setCookie(cookieContent)
{
	if (!useCookies)
		return;
	
    document.cookie = COOKIE_NAME + "=" +
	                  encodeURIComponent(cookieContent) +
	                  "; max-age=" + (60 * 60 * 24 * 28) + // Live for 28 days. Change the "28" to change the number of days.
	                  "; path=/" + 
	                  "; domain=herdmind.net";
}

function getCookie()
{
	var cookie = document.cookie;
    if (cookie.length)
	{
		var i = cookie.indexOf(COOKIE_NAME + "=") + COOKIE_NAME.length + 1;
		var end = cookie.indexOf(";", i);
        var cookie = cookie.substring(i, end > 0 ? end : cookie.length);
        return decodeURIComponent(cookie);
    }
    return "";
}*/

function setStyleFromCookie()
{
	var cookie = getCookie(COOKIE_NAME);
	if (cookie.length > 0)
		switchStyleTo(cookie);
	else
		console.log("No style cookie found. Either user has cookies disabled, has recently cleared their cookies, or they " + 
		            "haven't set their style before");
}