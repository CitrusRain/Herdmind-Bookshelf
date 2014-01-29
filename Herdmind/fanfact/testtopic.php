<!DOCTYPE HTML>
<!--
[PAGE SOURCE DESCRIPTION HERE]

This page is copyright Herdmind.net ©2013
-->
<?PHP
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php"; // Also includes config.php and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT']."/_incl/RetreiveData.php";   // Any function that returns XML
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";   // Start session and determine subdomain - do this second
?>
<HTML>
<HEAD>
<?PHP
buildDefaultHeadContent("testtopic.php", "", array("Fanfact", "Fantasy", "Idea"));
?>
<script src="//code.jquery.com/jquery.min.js" type="text/javascript"></script>
<script src="javascript/RGraph/libraries/RGraph.common.core.js"></script>
<script src="javascript/RGraph/libraries/RGraph.common.dynamic.js"></script>
<script src="javascript/RGraph/libraries/RGraph.common.tooltips.js"></script>
<script src="javascript/RGraph/libraries/RGraph.common.key.js"></script>
<script src="javascript/RGraph/libraries/RGraph.line.js"></script>
<script src="javascript/RGraph/libraries/RGraph.pie.js"></script>

<STYLE TYPE="text/css">
UL.topics>LI {
	display: inline-block;
	margin: 0;
	width: 100%;
}
.fanfact {
	margin: 0;
}
</STYLE>
</HEAD>



<?PHP
buildBodyTagWithAttributes(); // <BODY ...>
buildHeader(); // Don't pass variables to this; it will automatically detect login cookies
?>


<SECTION ID="KYLI_META" STYLE="border:thin dashed lightgray;">
	<BUTTON ONCLICK="KYLI_META.style.display = 'none';">Hide developer's notes</BUTTON>
	<P>
		Testing the xml return code I got working on the normal site
	</P>
</SECTION>



<SECTION STYLE="font-size: larger;">
	<?PHP

$p = htmlspecialchars(mysqli_real_escape_string($db_connection, $_GET['p']), ENT_QUOTES, 'UTF-8');
	
$xmlstring = GetFanfacts($p, $subdomfilter, $start, $show, $userid, $db_connection);

$xml = new SimpleXMLElement($xmlstring);

echo $xml->getName() . "<br>";

$strlist = '';

foreach($xml->children() as $child)
  {
  echo $child->getName() . ": " . $child->contents . "<br>";
  if($child->getName() == "fanfact")
	$strlist = $strlist.buildFactXml($child);

  }
  
  echo TitleFiller($strlist, $db_connection);
	
		

//Create a related / similar topics function		
//Determine a way to auto detect related topics
echo buildTopicLinkList(array(180, 18), null, "wrappingColumns");
	?>
</SECTION>


<?PHP
buildFooter();
?>
</BODY>
</HTML>
