<!DOCTYPE HTML>
<!--
Step 1 for the registration process for new users

This page is copyright Herdmind ©2013
-->
<?PHP
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php"; // Also includes config.php and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";   // Start session and determine subdomain - do this second

$email = $_POST["email"];
$user  = $_POST["user"];
$pass  = $_POST["pass"];
$pass2 = $_POST["pass2"];
?>
<HTML>
<HEAD>
<?PHP
buildDefaultHeadContent(
		"Registration Success!",
		"The success page of the registration process for new users",
		array("Register", "Registration", "Account", "Creation", "New", "Users", "Success"),
		true
);
?>
<LINK REL="stylesheet" TYPE="text/css" HREF="style.css"/>

<SCRIPT TYPE="text/javascript" SRC="script.js">/* Page scripts */</SCRIPT>
</HEAD>



<BODY>
	<H2>Success!</H2>
	<P CLASS="centered">Welcome to Herdmind, <?PHP echo $user; ?>!</P>
	<P CLASS="centered devalert">A verification email has been sent to <?PHP echo $email; ?>!</P>
</BODY>
</HTML>
