<!DOCTYPE HTML>
<!--
Step 1 for the registration process for new users

This page is copyright Herdmind ©2013
-->
<?php
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php"; // Also includes config.php and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";   // Start session and determine subdomain - do this second

$email = $_POST["email"];
$user  = $_POST["user"];
$pass  = $_POST["pass"];
//$pass2 = $_POST["pass2"];
?>
<HTML>
<HEAD>
<?php



/**
 * Note that the salt here is randomly generated.
 * Never use a static salt or one that is not randomly generated.
 *
 * For the VAST majority of use-cases, let password_hash generate the salt randomly for you
 */
$options = [
    'cost' => 11,
    'salt' => base64_encode(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM)),
];
$passhash = password_hash("$pass", PASSWORD_BCRYPT, $options)."\n";

$newuserquery = "INSERT INTO User (UserName, Email, Password, Salt)
						VALUES ('$user', '$email', '$passhash', '".$options['salt']."');";
	//echo $newuserquery;
mysqli_query($db_connection, $newuserquery);// or die mysqli_error($db_connection);
	



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
	<P CLASS="centered">Welcome to Herdmind, <?php echo $user; ?>!</P>
	<P CLASS="centered devalert">A verification email has been sent to <?php echo $email; ?>!</P>
</BODY>
</HTML>
