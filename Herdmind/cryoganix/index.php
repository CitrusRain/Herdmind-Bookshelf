<!DOCTYPE HTML>
<!--
The registration page for new users

This page is copyright Herdmind.net ©2013
-->
<?PHP
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php"; // Also includes config.php and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";   // Start session and determine subdomain - do this second
?>
<HTML>
<HEAD>
<?PHP
buildDefaultHeadContent("Register", "The registration page for new Herdmind users", array("Register", "Registration", "Account", "Creation", "New", "Users"));
?>
<STYLE>
IFRAME#REGISTRATION_IFRAME {
	border: none;
	width: 100%;
	min-height: 512px;
}
</STYLE>
</HEAD>



<?PHP
buildBodyTagWithAttributes(); // <BODY ...>
buildHeader(); // Don't pass variables to this; it will automatically detect login cookies
?>



<SECTION>
	<H1>Registration Form</H1>
	<IFRAME SRC="step1.php" ID="REGISTRATION_IFRAME"><A HREF="step1.php">Click here to go to step 1.</A></IFRAME>
</SECTION>



<?PHP
buildFooter();
?>
</BODY>
</HTML>
