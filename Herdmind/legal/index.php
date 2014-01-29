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
buildDefaultHeadContent("Legal", "The legalities of Herdmind", array("Legal", "Disclaimer", "Copyright"));
?>
</HEAD>



<?PHP
buildBodyTagWithAttributes(); // <BODY ...>
buildHeader(); // Don't pass variables to this; it will automatically detect login cookies
?>



<SECTION>
	<H1 ID="DISCLAIMERS">Disclaimers</H1>
	<P>Herdmind is a non-profit, fan-made service. As such, Herdmind refuses any claims to all series fantasized about within this site. These include, but are not necessarily limited to, the following:</P>
	<UL>
		<LI>Hasbro's <I>My Little Pony</I> franchise</LI>
		<LI>The BBC's <I>Doctor Who</I> franchise and spinoffs such as <I>Sarah Jane Adventures</I> and <I>Torchwood</I></LI>
		<LI>Turner Broadcasting's <I>Power Puff Girls</I> franchise</LI>
		<LI>Nickelodeon's <I>Avatar: The Last Airbender</I> franchise and spinoffs/sequels such as <I>Legend of Korra</I></LI>
	</UL>
</SECTION>

<SECTION>
	<H1 ID="COPYRIGHTS">Copyrights</H1>
	<P>The site's backend code, its non-canon speculations known as <Q>fanfacts</Q>, and any other unique content are copyright Herdmind &copy;2013</P>
</SECTION>



<?PHP
buildFooter();
?>
</BODY>
</HTML>
