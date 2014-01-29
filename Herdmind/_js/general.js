function isJQueryLoaded()
{
	var ret = false;
	try
	{
		if ($)
			ret = true;
	}
	finally
	{
		return ret;
	}
}

function fixBodyClasses()
{
	if (isJQueryLoaded())
		if (location.hash == "#LOGGER" || location.hash == "#LOGGER_HOLDER")
			$("BODY").addClass("withDialog");
		else
			$("BODY").removeClass("withDialog");
}

function loadingOperations()
{
	fixBodyClasses();
	var sda = getCookie('showDevAlerts');
	setDevAlertsShown(sda && sda != "false");
}

function setDevAlertsShown(show)
{
	if (show)
		$(".noDevalert").removeClass("noDevalert").addClass("devalert");
	else
		$(".devalert").removeClass("devalert").addClass("noDevalert");
	setCookie('showDevAlerts', show);
}

function setCookie(name, value)
{
	var daysToLive = arguments[2];
    document.cookie = name + "=" + encodeURIComponent(value) +
	               "; max-age=" + (60 * 60 * 24 * (daysToLive == null || isNaN(daysToLive) ? 28 : daysToLive)) + 
	               "; path=/" + 
	               "; domain=herdmind.net";
}

function getCookie(name)
{
	var cookie = document.cookie;
    if (cookie.length)
	{
		var i = cookie.indexOf(name + "=") + name.length + 1;
		var end = cookie.indexOf(";", i);
        var cookie = cookie.substring(i, end > 0 ? end : cookie.length);
        return decodeURIComponent(cookie);
    }
    return null;
}

if(window.attachEvent)
    window.attachEvent('onload', loadingOperations);
else if(window.addEventListener)
    window.addEventListener('load', loadingOperations, true);