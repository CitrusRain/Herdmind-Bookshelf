<!DOCTYPE HTML>
<?php
$user = $_POST["user"];

require_once($_SERVER['DOCUMENT_ROOT'].'/_incl/APIs/reCAPTCHA/recaptchalib.php');
$privatekey = "6Lc3NOISAAAAAAQZbHTYSMSz0Ge-V1Bk2CB2jpKM";
$resp = recaptcha_check_answer (
		$privatekey,
		$_SERVER["REMOTE_ADDR"],
		$_POST["recaptcha_challenge_field"],
		$_POST["recaptcha_response_field"]
);
if (!$resp->is_valid) {
	// What happens when the CAPTCHA was entered incorrectly
	$redirect = "step2.php";
	echo ("<!--

" . $resp->error . "

-->");
}
else
{
	// code here to handle a successful verification
	$redirect = "step3.php";
}
?>
<HTML>
<HEAD>
<TITLE>Redirecting...</TITLE>
<!--META HTTP-EQUIV="refresh" CONTENT="0;url=<?PHP echo $redirect; ?>"-->
</HEAD>
<BODY>
<SECTION>
	<P><A HREF="<?PHP echo $redirect; ?>">Click here to be brought to the next page</A>.</P>
</SECTION>
</BODY>
</HTML>