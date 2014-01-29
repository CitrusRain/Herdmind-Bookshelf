<!DOCTYPE HTML>
<!--
[PAGE SOURCE DESCRIPTION HERE]

This page is copyright Herdmind.net ©2013
-->
<?PHP
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php"; // Also includes config.php and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";   // Start session and determine subdomain - do this second



$work = isset($_GET["w"]) && preg_match('/^\d+$/', $_GET["w"]) ? $_GET["w"] : false; // if it's set and is only digits
?>
<HTML>
<HEAD>
<?PHP
buildDefaultHeadContent(
	"Work",
	"A work used as a citation, inspiration, or support for a fanfact",
	array(
		  "Fanwork"
		, "Citation"
		, "Inspiration"
		, "Supporting"
	)
);
?>
</HEAD>



<?PHP
buildBodyTagWithAttributes(); // <BODY ...>
buildHeader(); // Don't pass variables to this; it will automatically detect login cookies
?>



<SECTION>
	<H1>Work</H1>
</SECTION>



<?PHP
buildFooter();
?>
</BODY>
</HTML>
