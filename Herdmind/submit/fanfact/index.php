<!DOCTYPE HTML>
<!--
The page for general fanfacts

This page is copyright Herdmind.net ©2013
-->
<?PHP
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";        // Start session and determine subdomain
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php";      // Also includes config.php (must be done first) and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilderIndex.php"; // Builds body content for index
include $_SERVER['DOCUMENT_ROOT']."/_incl/RetreiveData.php";   // Any function that returns XML
include $_SERVER['DOCUMENT_ROOT']."/_incl/convenience.php";
include $_SERVER['DOCUMENT_ROOT']."/_incl/CookieTricks.php";   // We need to use cookie tricks on this page - import it.
buildDefaultHeadContent("Submit Fanfact", "The page for submitting a new fanfact.");
//buildDefaultHeadContent($fandom ? $parsedFandom : null);
?>
<HTML>
<HEAD>
<script src="<?PHP echo $_SERVER['DOCUMENT_ROOT']; ?>/_js/jquery.js"></script>
<script src="<?PHP echo $_SERVER['DOCUMENT_ROOT']; ?>/_js/typeahead.js/typeahead.js"></script>
<?PHP


//Initialize variables for a preview.
$factText = 'Filler text. (Fills that one [p5] plush.)';
$xml = '';


				//Get XML containing the page titles
				$xml = new SimpleXMLElement(TitleFinder($factText, $db_connection));

				//Insert the page titles into the fanfact
				$PreviewFactText = XMLTitleFiller($factText, $xml);

?>
</HEAD>



<?PHP
buildBodyTagWithAttributes(); // <BODY ...>
buildHeader(); // Don't pass variables to this; it will automatically detect login cookies
?>

<SECTION STYLE="font-size: larger;">
	
<?php
/*
Here is where a fanfact will be added.
*/?>


	
	Enter Fanfact:
	<br/>
	<form method='POST'>
	<textarea id=fanfact></textarea>
	<select id=FandomSelection>
		<option value=1>MLP:FIM</option>
		<option value=13>MLP (all)</option>
		<option value=9>Doctor Who</option>
	</select>
	<button type='button' onclick='SubmitFanfact()'>Submit</button>
	</form>
<?php
echo "Most recent topics viewed: ". implode(";",GetRecentTopics());
echo PageCodeHelper();
?>
</SECTION>


<script> 
$('#fanfact').typeahead({
	name: 'fanfact',
	remote: '/search.php?query=%QUERY',
	minLength: 3, // send AJAX request only after user type in at least 3 characters
	limit: 10 // limit to show only 10 results
});

function PostComment()
{
	var comment = document.getElementById("commentbox").value;
	var factNum = "<?php echo $factNum; ?>";
	var userid = "<?php echo $userid; ?>";
	var type = "fanfact";
	var url = "../GetPostHandlers/PostComment.php";

	var xmlhttp;
	if (window.XMLHttpRequest)
	{// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else
	{// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			alert(innerHTML=xmlhttp.responseText);
		}
	}
	xmlhttp.open("POST",url,true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("id="+ factNum + "&topictype="+ type + "&userid="+ userid + "&username=Citrus&useremail=email@herdmind.net&comment="+ comment +"");
}
</script>
</SECTION>


<?PHP
buildFooter();
?>
</BODY>
</HTML>
