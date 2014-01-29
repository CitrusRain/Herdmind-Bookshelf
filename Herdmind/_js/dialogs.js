function showDialog(dialogID)
{
	$(dialogID).attr("open", true);
	
	fixGUI();
	return false;
}

function hideDialog(dialogID)
{
	$(dialogID).attr("open", false);
	
	fixGUI();
	return false;
}

function fixGUI()
{
	if ($("dialog").attr("open"))
		$("body").addClass("withDialog");
	else
		$("body").removeClass("withDialog");
}
function handleDialogHolderClicked(event, dialogID)
{
	if (event.target.className.contains("dialogHolder"))
		hideDialog('#' + dialogID);
}