<!DOCTYPE HTML>
<!--
About herdmind
Copyright Herdmind.net ©2013
-->
<?PHP
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php"; // Also includes config.php and styleSwitch.php
?>
<HTML>
<HEAD>

<!-- BEGIN Metadata -->
<TITLE>Herdmind</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" />
<!-- END Metadata -->

<?PHP
buildDefaultHeadContent("About", "Meta info for Herdmind", array("About"));
?>
</HEAD>



<BODY>
<?PHP
$simulateLogin = $_GET["login"]; // Allows for testing of different layouts
buildHeader(isset($simulateLogin) ? $simulateLogin === 'true' : false); // false == header for logged-out, true == header for logged-in
?>

<SECTION>
	<H1>About Herdmind Beta</H1>
</SECTION>

<SECTION>
	<H1>Vision</H1>
	<P>
		Herdmind is a site where users can collaborate their thoughts about different series and vote on each other&rsquo;s thoughts
	</P>
</SECTION>

<SECTION>
	<H1>Compatibility | Concerns</H1>
	<UL>
		<LI><B>Chrome</B> &ndash; latest version (assume autoupdating is enabled)</LI>
		<LI><B>Firefox</B> &ndash; 4&plus;</LI>
		<LI><B>IE</B> &ndash; 9&plus; (no style switching)</LI>
		<LI><B>Opera</B> &ndash; 11+</LI>
		<LI><B>Safari</B> &ndash; 5+</LI>
	</UL>
</SECTION>

<?PHP
buildFooter(); // Adds the footer
?>
</BODY>
</HTML>