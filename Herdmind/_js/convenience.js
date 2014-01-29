if(window.attachEvent)
    window.attachEvent('onload', hideAllJavascriptWarnings);
else if(window.addEventListener)
    window.addEventListener('load', hideAllJavascriptWarnings, true);

function hideAllJavascriptWarnings()
{
	$('.hideIfJavascript').remove();
}

function toggleClass(element, classname)
{
	$(element).toggleClass(classname);
}