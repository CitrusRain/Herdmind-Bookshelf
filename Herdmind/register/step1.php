<!DOCTYPE HTML>
<!--
Step 1 for the registration process for new users

This page is copyright Herdmind.net ©2013
-->
<?PHP
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php"; // Also includes config.php and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";   // Start session and determine subdomain - do this second

$email = $_SESSION['email']; if(!$email) $email = $_POST["email"];
$user  = $_POST["user"];
$pass  = $_POST["pass"];
$pass2 =  htmlentities($_POST["pass2"], ENT_QUOTES | ENT_HTML5);
$status = $_POST["status"];
?>
<HTML>
<HEAD>
<?PHP
buildDefaultHeadContent(
		"Step 1 - Register",
		"The first step of the registration process for new Herdmind users",
		array("Register", "Registration", "Account", "Creation", "New", "Users", "Step 1")
);
?>
<LINK REL="stylesheet" TYPE="text/css" HREF="style.css"/>

<SCRIPT TYPE="text/javascript" SRC="script.js">/* Page scripts */</SCRIPT>
</HEAD>



<BODY>
	<H2>Step 1 - Basic information</H2>
	<FORM ID="register" METHOD="POST" ACTION="step2.php" SEAMLESS="seamless" BORDER="0">
		<TABLE STYLE="margin: auto;" CLASS="pretty">
			<TR>
				<TH><LABEL FOR="email">eMail</LABEL></TH>
				<TD CLASS="hasNeeds">
					<INPUT TYPE="email" ID="email" NAME="email" PLACEHOLDER="email@example.com"<?PHP if ($email || $status[0] == "-") echo " VALUE=\"$email\" CLASS=\"" . ($status[0] == "-" ? "bad" : "good") . "\""; ?>/>
					<DIV CLASS="needs">
						<LABEL ID="email_needs_valid" FOR="email" CLASS="need<?PHP if ($status[0] == "-") echo " bad"; ?>">
							Must be a valid email address
							<DIV CLASS="expanding explanation">
								We use your email to confirm your identity, help reset your password, and more. We will never send you promotions, advertisements, or other such annoying things.
							</DIV>
						</LABEL>
					</DIV>
				</TD>
			</TR>
			<TR>
				<TD COLSPAN="0"><HR/></TD>
			</TR>
			<TR>
				<TH><LABEL FOR="user">Username</LABEL></TH>
				<TD CLASS="hasNeeds">
					<INPUT TYPE="text" ID="user" NAME="user" PLACEHOLDER="Username"<?PHP if ($user || $status[1] == "-") echo " VALUE=\"$user\" CLASS=\"" . ($status[1] == "-" ? "bad" : "good") . "\""; ?>/>
					<DIV CLASS="needs">
						<LABEL ID="user_needs_length" FOR="user" CLASS="need<?PHP if ($status[1] == "-" && !preg_match("/^.{1,16}$/", $user)) echo " bad"; ?>">
							Must be 1 to 16 characters long
							<DIV CLASS="expanding explanation">
								You will use your username to log in, and our database can only hold usernames that are up to 16 characters long.
							</DIV>
						</LABEL>
						<LABEL ID="user_needs_spaceless" FOR="user" CLASS="need<?PHP if ($status[1] == "-" && preg_match("/\s/", $user)) echo " bad"; ?>">
							Must not contain spaces
							<DIV CLASS="expanding explanation">
								Usernames will be used in URLs and other places which don't support spaces. Putting spaces in usernames will create confusion and, in some cases, severe bugs.
							</DIV>
						</LABEL>
					</DIV>
				</TD>
			</TR>
			<TR>
				<TD COLSPAN="0"><HR/></TD>
			</TR>
			<TR>
				<TH><LABEL FOR="pass">Password</LABEL></TH>
				<TD CLASS="hasNeeds">
					<INPUT TYPE="password" ID="pass" NAME="pass" PLACEHOLDER="Password"<?PHP if ($pass || $status[2] == "-") echo " VALUE=\"$pass\" CLASS=\"" . ($status[2] == "-" ? "bad" : "good") . "\""; ?>/>
					<DIV CLASS="needs bottom">
						<DIV CLASS="need" ID="pass_needs_strength" STYLE="z-index: 1;">
							<METER ID="pass_meter_strength" MIN="0" MAX="100" LOW="25" HIGH="50" OPTIMUM="100"></METER>
							<LABEL FOR="pass_meter_strength" ID="pass_label_strength"></LABEL>
							<DIV CLASS="expanding tips">
								<UL STYLE="padding:0 0 0 1em;margin:0;font-size:0.8em;">
									<LI>Don't make it generic or easy to guess (<Q>password</Q>, <Q>123456</Q>, &hellip;)</LI>
									<LI>Don't use part of your username or email</LI>
									<LI>Don't use the same character twice</LI>
									<LI>Use unusual characters like spaces</LI>
									<LI>Mix in numbers and capital letters</LI>
								</UL>
							</DIV>
						</DIV>
						<LABEL ID="pass_needs_length" FOR="pass" CLASS="need<?PHP if ($status[2] == "-") echo " bad"; ?>">
							Must be at least 6 characters.
							<DIV CLASS="expanding explanation">
								Do you like spam? We don't. To help us ensure your account doesn't get hacked, we ask that your password be strong, and the first step is to make it at least 6 characters.
							</DIV>
						</LABEL>
					</DIV>
				</TD>
			</TR>
			<TR>
				<TH><LABEL FOR="pass2">Verify</LABEL></TH>
				<TD CLASS="hasNeeds">
					<INPUT TYPE="password" ID="pass2" NAME="pass2" PLACEHOLDER="Password Repeated"<?PHP if ($pass2 || $status[3] == "-") echo " VALUE=\"$pass2\" CLASS=\"" . ($status[3] == "-" ? "bad" : "good") . "\""; ?>/>
					<DIV CLASS="needs bottom">
						<LABEL ID="pass2_needs_equal" FOR="pass2" CLASS="need<?PHP if ($status[3] == "-") echo " bad"; ?>">
							Must be identical to your password.
							<DIV CLASS="expanding explanation">
								This helps guarantee that you can remember your password. We don't want you losing it, after all!
							</DIV>
						</LABEL>
					</DIV>
				</TD>
			</TR>
		</TABLE>
		<DIV STYLE="text-align:center"><INPUT TYPE="submit" ID="submit" VALUE="Continue to step 2 &raquo;"/></DIV>
	</FORM>
</BODY>
</HTML>
