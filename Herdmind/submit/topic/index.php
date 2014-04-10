<?php
session_start();
?>
<!DOCTYPE HTML>
<!--
The page for general fanfacts

This page is copyright Herdmind.net ©2013
-->
<?PHP
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php";      // Also includes config.php (must be done first) and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";        // Start session and determine subdomain
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilderIndex.php"; // Builds body content for index
include $_SERVER['DOCUMENT_ROOT']."/_incl/RetreiveData.php";   // Any function that returns XML
include $_SERVER['DOCUMENT_ROOT']."/_incl/convenience.php";
include $_SERVER['DOCUMENT_ROOT']."/_incl/CookieTricks.php";   // We need to use cookie tricks on this page - import it.
buildDefaultHeadContent("Submit Topic", "The page for submitting a new Topic.");
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
Here is where a topic will be added.
*/?>
	
 New Topic:
		  
	<form method='POST'  enctype="multipart/form-data">
	
<span class='spanleft'>Name:</span>
<span class='spanright'><input name='title' id='title' type='text'></span>
<br/>
<span class='spanleft'><label for="file">Picture:</label></span>
<span class='spanright'><input type="file" name="file" id="file" /></span>
<br/>
<span class='spanleft'>Type:</span>
<span class='spanright'><select name='type' id='type'>
	<option value='Character'>Character</option>
	<option value='Species'>Species</option>
	<option value='Place'>Place</option>
	<option value='Event'>Event</option>
	<option value='Object'>Object</option>
	<option value='Other'>Other</option>
	</select></span>
<br/>
<span class='spanleft'>Fandom / Series:</span>
<span class='spanright'><select name='series' id='series'>
	<?php echo $branchlist; ?>
	<option value='1'>MLP:FIM</option>
	</select></span>
<br/>
<span class='spanleft'>Reality:</span>
<span class='spanright'><select name='reality' id='reality'>
	<option value=''>Select One</option>
	<option value='Canon'>Canon</option>
	<option value='Fanon'>Fanon</option>
	</select></span>
<br/>
<span class='spanleft'>Summary:</span>
<span class='spanright'><textarea name='summary' id='summary' cols='40'></textarea></span>

<br/><br/>
<div class='subblock'>
<span class='spanright'>
<div class="clear"></div>
<button type='button' onclick='SubmitTopic()'>Submit</button>
</form>
</span>
</div>
	
	
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
