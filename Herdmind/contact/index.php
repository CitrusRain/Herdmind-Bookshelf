<!DOCTYPE HTML>
<!--
[PAGE SOURCE DESCRIPTION HERE]

This page is copyright Herdmind.net ©2013
-->
<?PHP
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php"; // Also includes config.php and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";   // Start session and determine subdomain - do this second
?>
<HTML>
<HEAD>
<?PHP
buildDefaultHeadContent("Contact", "The contact page, enumerating the various methods by which one may contact the Herdmind team.", array("Contact", "email", "Google", "Google+", "Google Plus", "Plus"));
?>
</HEAD>



<?PHP
buildBodyTagWithAttributes(); // <BODY ...>
buildHeader(); // Don't pass variables to this; it will automatically detect login cookies
?>



<SECTION>
	<H1>Contact Herdmind!</H1>
	<UL CLASS="portal">
		<LI>
			<A HREF="mailto:Webmaster@Herdmind.net" STYLE="text-decoration:none;display:inline-block;color:#333;text-align:center; font:13px/16px arial,sans-serif;white-space:nowrap;">
				<IMG SRC="/_img/icon_eMail.png" ALT="eMail" STYLE="border:0;width:64px;height:64px;"><BR />
				<SPAN STYLE="font-weight:bold;">Herdmind</SPAN><BR />
				<SPAN>eMail</SPAN>
			</A>
		</LI>
		<LI>
			<A HREF="https://plus.google.com/115556066131792258384?prsrc=3" rel="publisher" TARGET="_top" STYLE="text-decoration:none;display:inline-block;color:#333;text-align:center; font:13px/16px arial,sans-serif;white-space:nowrap;">
				<IMG SRC="//ssl.gstatic.com/images/icons/gplus-64.png" ALT="g+" STYLE="border:0;width:64px;height:64px;"/><br />
				<SPAN STYLE="font-weight:bold;">Herdmind</SPAN><BR />
				<SPAN>on Google+</SPAN>
			</a>
		</LI>
	</UL>
</SECTION>



<?PHP
buildFooter();
?>
</BODY>
</HTML>
