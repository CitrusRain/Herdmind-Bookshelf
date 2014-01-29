<!DOCTYPE HTML>
<!--
Step 1 for the registration process for new users

This page is copyright Herdmind.net ©2013
-->
<?PHP
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php"; // Also includes config.php and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";   // Start session and determine subdomain - do this second

/**** BEGIN reCAPTCHA validation ****/
require_once($_SERVER['DOCUMENT_ROOT'].'/_incl/APIs/reCAPTCHA/recaptchalib.php');
$privatekey = "6Lc3NOISAAAAAAQZbHTYSMSz0Ge-V1Bk2CB2jpKM";
$resp = recaptcha_check_answer (
		$privatekey,
		$_SERVER["REMOTE_ADDR"],
		$_POST["recaptcha_challenge_field"],
		$_POST["recaptcha_response_field"]
);
/**** END reCAPTCHA validation ****/
$email = $_POST["email"];
$user = $_POST["user"];
$pass = $_POST["pass"];
$pass2 = $_POST["pass2"];
$secAns = $_POST["SECURITY_ANSWER"];
//echo "\"" . $_SESSION["rx"] . "\" matches \"" . $secAns . "\"? " . preg_match($_SESSION["rx"], $secAns);
if (   $resp->is_valid
	&& preg_match($_SESSION["rx"], $secAns)
	&& preg_match("/^.+@.+\..+$/", $email)
	&& preg_match("/^(\S){1,16}$/", $user)
	&& preg_match("/^.{6,}$/", $pass)
	&& $pass === $pass2
) // BEGIN success page
{
?>
<HTML>
<HEAD>
<?PHP
buildDefaultHeadContent(
		"Step 3 - Agreement",
		"The third step of the registration process for new Herdmind users",
		array("Register", "Registration", "Account", "Creation", "New", "Users", "Step 3", "Agreement")
);
?>
<LINK REL="stylesheet" TYPE="text/css" HREF="style.css"/>

<STYLE>
:root,
HTML,
BODY {
	margin: 0 !important;
	padding: 0 !important;
}
H2 {
	margin-top: 0;
}
</STYLE>
</HEAD>



<BODY>
<SECTION CLASS="centered">
	<H2>Step 3 - License Agreement</H2>
	<PRE CLASS="devalert">
		Don't be a douche.
	</PRE>
	<FORM METHOD="post" ACTION="landing.php">
		<INPUT TYPE="submit" ID="submit" VALUE="Agree and Register &raquo;"/>
		<DIV STYLE="display:none">
			<INPUT TYPE="email"    NAME="email" VALUE="<?PHP echo $email; ?>"/>
			<INPUT TYPE="text"     NAME="user"  VALUE="<?PHP echo $user;  ?>"/>
			<INPUT TYPE="password" NAME="pass"  VALUE="<?PHP echo $pass;  ?>"/>
		</DIV>
	</FORM>
</SECTION>
</BODY>
</HTML>
<?PHP
} // END success page
else // BEGIN fail page
{
?>
<HTML>
<HEAD>
<TITLE>Problemo!</TITLE>
<!--META HTTP-EQUIV="refresh" CONTENT="0;url=step2.php"-->
<?PHP
buildDefaultHeadContent(
		"Invalid Response!",
		"The second step of the registration process was failed",
		array("Register", "Registration", "Account", "Creation", "New", "Users", "failure")
);
?>
</HEAD>
<BODY>
<SECTION CLASS="centered">
	<H2>You did not provide the correct security answer!</H2>
	<P>Don't worry; it happens to everyone. Just go back and try again!</P>
	<FORM METHOD="post" ACTION="step2.php">
		<INPUT TYPE="submit" VALUE="&laquo; Try again"/>
		<DIV STYLE="display:none">
			<INPUT TYPE="email"    NAME="email" VALUE="<?PHP echo $email; ?>"/>
			<INPUT TYPE="text"     NAME="user"  VALUE="<?PHP echo $user;  ?>"/>
			<INPUT TYPE="password" NAME="pass"  VALUE="<?PHP echo $pass;  ?>"/>
			<INPUT TYPE="password" NAME="pass2" VALUE="<?PHP echo $pass2; ?>"/>
		</DIV>
	</FORM>
</SECTION>
</BODY>
</HTML>
<?PHP
} // END fail page
?>