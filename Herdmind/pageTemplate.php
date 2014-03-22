<!DOCTYPE HTML>
<!--
[PAGE SOURCE DESCRIPTION HERE]

This page is copyright Herdmind.net ©2013
-->
<?PHP
include $_SERVER['DOCUMENT_ROOT'].'/_incl/startSession.php';        // Start session and determine subdomain - do this first to ensure contentBuilder knows the fandom
include $_SERVER['DOCUMENT_ROOT'].'/_incl/contentBuilder.php';      // Also includes config.php and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT'].'/_incl/contentBuilderIndex.php'; // Builds body content for index
include $_SERVER['DOCUMENT_ROOT'].'/_incl/classes2.php';   			// A bunch of classes used for data
include $_SERVER['DOCUMENT_ROOT'].'/_incl/RetreiveData.php';   		// Any function that returns XML
include $_SERVER['DOCUMENT_ROOT'].'/_incl/convenience.php';
?>
<HTML>
<HEAD>
<?PHP
buildDefaultHeadContent('[TAB TEXT]', '[LONG DESCRIPTION]', array('Descriptive', 'Keywords'));
?>
</HEAD>



<?PHP
buildBodyTagWithAttributes(); // <BODY ...>
buildHeader(); // Don't pass variables to this; it will automatically detect login cookies
?>



<MAIN>
	<SECTION>
		[BODY CONTENT HERE]
	</SECTION>
</MAIN>



<?PHP
buildFooter();
?>
</BODY>
</HTML>
