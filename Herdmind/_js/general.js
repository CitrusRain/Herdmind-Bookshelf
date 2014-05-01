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
	
	
//Add a textarea to edit a comment with
function EditComment(DivID, RawID) {	
$('#Edit'+RawID).hide();
var post = $("#"+DivID).text();
var div =  $("#"+DivID); 
var textArea = $('<textarea id="EditBox'+RawID+'" />');
var cancelButton = $("<button name='cancelbutton' type='button' onclick='StopEditingComment(\""+RawID+"\", \""+post+"\" )' id='Cancel"+RawID+"'>Cancel</button>");
var submitButton = $("<button name='editsubmitbutton' type='button' onclick='UpdateEditedMessage(\""+RawID+"\")' id='Post"+RawID+"'>Save</button>");
div.empty(); 
textArea.text(post);
div.append(textArea);
div.parent().append(cancelButton);
div.parent().append(submitButton);
div.dialog({modal: true, width:850, height:500, title:"Editing post"});
}
function StopEditingComment(RawID, post, message = "") {	
var DivID = "comment" + RawID;
var div =  $("#"+DivID); 
div.empty(); 
div.append(post);
$('#Cancel'+RawID).remove();
$('#Post'+RawID).remove();
div.parent().append(message);
$('#Edit'+RawID).show();
}


function checkForLinks()
{
    var output = "";
    var match;
    var v = $("#commentbox").val();
    if (match = v.match(/((https?:)?\/\/)?(((www\.)?youtube.com\/watch\?\W*?v=)|(youtu.be\/))[a-z0-9\-]+/gi))
        output += match.length + " YouTube link(s) detected: \r\n\t{" + match + "} \r\n";
    
    if (match = v.match(/((https?:)?\/\/)?(www\.)?vimeo.com\/\d+/gi))
        output += match.length + " Vimeo link(s) detected: \r\n\t{" + match + "} \r\n";
    
    if (match = v.match(/((https?:)?\/\/)?(www\.)?[a-z0-9_-]+.([a-z]){2,}\/post\/show\/\d+\/[a-z0-9_-]+/gi))
        output += match.length + " e621-based booru link(s) detected: \r\n\t{" + match + "} \r\n";
    if (match = v.match(/((https?:)?\/\/)?(www\.)?derpibooru.org\/\d+((\?|&)\w+?=[a-z0-9_-]*)*/gi))
        output += match.length + " Derpibooru link(s) detected: \r\n\t{" + match + "} \r\n";
    if (match = v.match(/((https?:)?\/\/)?(www\.)?bronibooru.com\/posts\/\d+((\?|&)\w+?=[a-z0-9_-]*)*/gi))
        output += match.length + " Bronibooru link(s) detected: \r\n\t{" + match + "} \r\n";
    
    if (match = v.match(/((https?:)?\/\/)?((([a-z0-9\-]+\.)?deviantart.com\/art\/[a-z0-9\-]*?-\d+?)|(fav.me\/\w+))/gi)) // username has only letters, numbers and hyphens
        output += match.length + " deviantART link(s) detected: \r\n\t{" + match + "} \r\n";
    
    if (match = v.match(/((https?:)?\/\/)?((www|i)\.)?imgur.com\/(gallery\/)?[a-z0-9]+(\.[a-z]{2,})?/gi))
        output += match.length + " Imgur link(s) detected: \r\n\t{" + match + "} \r\n";
    
    if (match = v.match(/((https?:)?\/\/)?(www\.)?fanfiction.net\/s\/\d+\/\d+(\/[a-z0-9_-]*)?/gi))
        output += match.length + " Fanfiction link(s) detected: \r\n\t{" + match + "} \r\n";
    if (match = v.match(/((https?:)?\/\/)?(www\.)?fimfiction.net\/story\/\d+(\/\d+)?(\/[a-z0-9_-]*){0,2}/gi))
        output += match.length + " FiMFiction link(s) detected: \r\n\t{" + match + "} \r\n";
    
    return output;
}

if(window.attachEvent)
    window.attachEvent('onload', loadingOperations);
else if(window.addEventListener)
    window.addEventListener('load', loadingOperations, true);