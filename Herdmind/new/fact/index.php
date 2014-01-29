<!DOCTYPE HTML>
<!--
[PAGE SOURCE DESCRIPTION HERE]

This page is copyright Herdmind.net ©2013
-->
<?PHP
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";   // Start session and determine subdomain - do this first to ensure contentBuilder knows the fandom
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php"; // Also includes config.php and styleSwitch.php
?>
<HTML>
<HEAD>
<?PHP
buildDefaultHeadContent("New Fanfact", "The page for creating a new fanfact", array("Fanfact", "Custom", "new", "creator"));

$newNumber = getLatestFactNumber(); // Fetch the highest-numbered fanfact and add 1 to it

function getLatestFactNumber()
{
	return 0; ///////////////////////////////////////////////////////////////////////////////// TODO: Fetch dynamically from SQL
}
?>
</HEAD>



<?PHP
buildBodyTagWithAttributes(); // <BODY ...>
buildHeader(); // Don't pass variables to this; it will automatically detect login cookies
?>



<SECTION>
	<H1>Create Fanfact <SPAN CLASS="factNum"><?PHP echo $newNumber; ?></SPAN></H1>
</SECTION>



<?PHP
buildFooter();
?>
</BODY>
</HTML>
