<!DOCTYPE HTML>
<!--
A user profile page

This page is copyright Herdmind.net ©2013
-->
<?php
/*

	A NOTE TO ANYONE READING THE PHP: I'm trying a new way of doing it, hoping that putting small PHP calls in the HTML will lead to faster processing than multiple echoes
		- Kyli

*/


include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php"; // Also includes config.php and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT']."/_incl/RetreiveData.php";   // File that returns data in XML format
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";   // Start session and determine subdomain - do this second

$user = isset($_GET["user"]) && is_numeric($_GET["user"]) ? max($_GET["user"], 0) : 0;

?>
<HTML>
<HEAD>
<?php
buildDefaultHeadContent("A Profile", "", array("Descriptive", "Keywords"));
?>

<STYLE>
DT {
	font-weight: bold;
}
	DT.major,
	DT.major+DD {
		font-size: 2em;
		text-align: center;
		text-indent: 0;
	}
	DT.inline {
		float: left;
	}
	DT.colon::after {
		content: ":";
		padding-right: 0.5em;
	}
	DT.noTerm {
		display: none;
	}
	DD {
		font-weight: normal;
		margin: 0;
		padding: 0;
		text-indent: 2em;
	}

FIGURE.topic {
	border-radius: 0.5em;
	display: table;
	margin: 0;
	width: 100%;
}
	FIGURE.topic>* {
		display: table;
		vertical-align: top;
		}@media all and (max-width: 40em) { FIGURE.topic>* {
			display: block;
			margin: 0.5em;
		}
	}
	FIGURE.topic>IMG {
		border: 0.1em solid #FFF;
		border-radius: 0.5em;
		background: rgba(255,255,255, 0.5);
		float: left;
		margin: 0 1em 0 0;
		width: 15%;
		min-width: 1in;
		}@media all and (max-width: 40em) { FIGURE.topic>IMG {
			float: none;
			margin: auto;
			max-width: 100%;
			width: 30em;
		}
	}
/*	FIGURE.topic>*:last-child {
		clear: both;
	}*/
#FACTS {
	margin-top:0.5em;
}
#FACTS:target {
	background: transparent;
	color:inherit;
}
</STYLE>
</HEAD>



<?php
buildBodyTagWithAttributes(); // <BODY ...>
buildHeader(); // Don't pass variables to this; it will automatically detect login cookies
?>

Todo:
<br/>
>get profile picture, username, and other details

<?php


//Determine what profile to load
global $userid;
$ProfileNum = $userid;
if(isset($_GET["id"])) 
{	
	if ($_GET["id"] === 'Me')
	{
		$ProfileNum = $userid;
	}
	else
	{
		$ProfileNum = $_GET["id"];
	}
}
if(isset($ProfileNum) && !(isset($_GET["id"])))
{
	echo "Not logged in, but trying to view own profile.";
}

$xmlstring = GetProfile($db_connection
					, $ProfileNum
					, $userid);

$profilexml = new SimpleXMLElement($xmlstring);



echo '<section id="RAW_XML_TEST" style="border:thin dashed lightgray;">
	<BUTTON ONCLICK="document.getElementById(\'RAW_XML_TEST\').remove()">Hide raw XML output</BUTTON><br/>';

echo $profilexml->getName() . "<br/>";

//Loop through each xml element and print it.
  $stack = array();
foreach($profilexml->children() as $child)
  {
  echo "-".$child->getName() . ": " . $child . "<br/>";
	
		foreach($child->children() as $child2)
		  {
		  echo "--".$child2->getName() . ": " . $child2 . "<br/>";
		}
  }
  
echo '</section>';


?>



<SECTION id='settings'>
<h3>Your settings</h3>

</SECTION>





<?php
buildFooter();
?>
</BODY>
</HTML>
