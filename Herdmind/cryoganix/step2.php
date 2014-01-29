<!DOCTYPE HTML>
<!--
Step 2 for the registration process for new users

This page is copyright Herdmind.net ©2013
-->
<?PHP
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php"; // Also includes config.php and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";   // Start session and determine subdomain - do this second

$email = $_POST["email"] or $_SESSION["reg_email"]; $_SESSION["reg_email"] = $email;
$user  = $_POST["user"] or $_SESSION["reg_user"];
$pass  = $_POST["pass"] or $_SESSION["reg_pass"];
$pass2 =  $_POST["pass2"] or $_SESSION["reg_pass2"];
if (
	   preg_match("/^.+@.+\..+$/", $email)
	&& preg_match("/^(\S){1,16}$/", $user)
	&& preg_match("/^.{6,}$/", $pass)
	&& $pass === $pass2
) // BEGIN success page
{

	$_SESSION["rx"] = '/^\s*(Princess\s+)?Twilight(\s+Sparkle)?\s*$/i';

?>
<HTML>
<HEAD>
<?PHP
buildDefaultHeadContent(
		"Step 2 - Human Verification",
		"The second step of the registration process for new Herdmind users",
		array("Register", "Registration", "Account", "Creation", "New", "Users", "Step 2", "Verification")
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
#recaptcha_area {
	margin: auto;
}
</STYLE>
</HEAD>



<BODY>
	<H2>Step 2 - Human Verification</H2>
	<FORM METHOD="post" ACTION="step3.php" CLASS="centered">
		<?PHP
			require_once($_SERVER['DOCUMENT_ROOT'].'/_incl/APIs/reCAPTCHA/recaptchalib.php');
			$publickey = "6Lc3NOISAAAAADUucveO2nFo83ie21n3Uel3Z8lK"; // got this from the signup page
			echo recaptcha_get_html($publickey);
		?>
		<TABLE CLASS="pretty">
			<TBODY>
				<TR>
					<TH><LABEL FOR="SECURITY_ANSWER">Which mane 6 character of FiM is lavender?</LABEL></TH>
					<TD><INPUT TYPE="text" NAME="SECURITY_ANSWER" ID="SECURITY_ANSWER"/></TD>
				</TR>
			</TBODY>
		</TABLE>
		<INPUT TYPE="submit" ID="submit" VALUE="Continue to step 3 &raquo;"/>
		<DIV STYLE="display:none">
			<INPUT TYPE="email"    NAME="email" VALUE="<?PHP echo $email; ?>"/>
			<INPUT TYPE="text"     NAME="user"  VALUE="<?PHP echo $user;  ?>"/>
			<INPUT TYPE="password" NAME="pass"  VALUE="<?PHP echo $pass;  ?>"/>
			<INPUT TYPE="password" NAME="pass2" VALUE="<?PHP echo $pass2; ?>"/>
		</DIV>
	</FORM>
</BODY>
</HTML>
<?PHP
} // END success page



else // BEGIN fail page
{
	$status = "++++";
	if (!preg_match("/^.+@.+\..+$/", $email))
		$status[0] = "-";
	if (!preg_match("/^(\S){1,16}$/", $user))
		$status[1] = "-";
	if (!preg_match("/^.{6,}$/", $pass))
		$status[2] = "-";
	if ($pass != $pass2)
		$status[3] = "-";
?>
<HTML>
<HEAD>
<TITLE>Problemo!</TITLE>
<!--META HTTP-EQUIV="refresh" CONTENT="0;url=step2.php"-->
<?PHP
echoDefaultHeadContent(
		"Invalid Response!",
		"The second step of the registration process was failed",
		array("Register", "Registration", "Account", "Creation", "New", "Users", "failure")
);
?>
</HEAD>
<BODY>
<SECTION CLASS="centered">
	<H2>Your information was invalid!</H2>
	<P>It must've been caps lock. Go back and try again!</P>
	<FORM METHOD="post" ACTION="step1.php">
		<INPUT TYPE="submit" VALUE="&laquo; Try again"/>
		<DIV STYLE="display:none">
			<INPUT TYPE="hidden"    NAME="email" VALUE="<?PHP echo $email; ?>"/>
			<INPUT TYPE="hidden"     NAME="user"  VALUE="<?PHP echo $user;  ?>"/>
			<INPUT TYPE="hidden" NAME="pass"  VALUE="<?PHP echo $pass;  ?>"/>
			<INPUT TYPE="hidden" NAME="pass2" VALUE="<?PHP echo $pass2; ?>"/>
			<INPUT TYPE="hidden" NAME="status" VALUE="<?PHP echo $status; ?>"/>
		</DIV>
	</FORM>
</SECTION>
</BODY>
</HTML>
<?PHP
} // END fail page
?>