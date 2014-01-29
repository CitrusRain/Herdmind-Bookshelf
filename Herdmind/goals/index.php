<!DOCTYPE HTML>
<!--
Goals for programmers!

This page is copyright Herdmind.net ©2013
-->
<?PHP
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php";
?>
<HTML>
<HEAD>
<?PHP
buildDefaultHeadContent("Goals",
                        "This page dictates the goals, aspirations, and other misc ideas for Herdmind 2.0",
                        array("Herdmind", "Goals"));
?>
</HEAD>



<?PHP
buildBodyTagWithAttributes();
?>
<HEADER>
	<H1>
		<A HREF="/">
			Herdmind
			<SPAN CLASS="slogan">Beta Site Goals</SPAN>
		</A>
	</H1>
</HEADER>



<SECTION>
	<P>This page dictates the goals, aspirations, and other misc ideas for Herdmind 2.0</P>
</SECTION>



<SECTION>
	<H1 ID="PRIORITY_1">Must do</H1>
	<UL>
		<LI><DEL>Finish landing pages for Pony and Tardis</DEL></LI>
		<LI>Make Apple Touch Icon</LI>
	</UL>
</SECTION>

<SECTION>
	<H1 ID="PRIORITY_2">Should do</H1>
	<UL>
		<LI>Come up with universal color palette. Note that the current visual styles are <EM>not</EM> going to be the final styles, for copyright purposes.</LI>
		<LI>Come up with styles for <CODE>&lt;NAV&gt;</CODE> boxes</LI>
		<LI>Hide sensitive error messages from the public on pages that make database connections</LI>
	</UL>
</SECTION>

<SECTION>
	<H1 ID="PRIORITY_3">Want to do</H1>
	<UL>
		<LI>Click a fanfact's vote count to see ups and downs (like on Stack Exchange)</LI>
		<LI>Invent a pretty, integrated style switcher GUI</LI>
		<LI>Expand search input on focus, like Stack Exchange</LI>
	</UL>
</SECTION>

<SECTION>
	<H1 ID="PRIORITY_4">Keep in mind</H1>
	<UL>
		<LI>Object orientation
			<UL>
				<LI>Allows rapid editing of many pages at once</LI>
				<LI>Allows rapid coding of a single page</LI>
			</UL>
		</LI>
		<LI>Program with SEO in mind.</LI>
	</UL>
</SECTION>

<SECTION>
	<H1 ID="PRIORITY_5">Refrain from doing</H1>
	<UL>
	</UL>
</SECTION>

<SECTION>
	<H1 ID="PRIORITY_NULL">Never do</H1>
	<UL>
		<LI>Invalid HTML 5 or CSS 3 code.</LI>
	</UL>
</SECTION>



<?PHP
buildFooter();
?>

<NAV ID="SIDEBAR">
	<H2><LABEL FOR="SIDEBAR_PIN">Navigation</LABEL></H2>
	<OL>
		<LI><A HREF="#PRIORITY_1">Must do</A></LI>
		<LI><A HREF="#PRIORITY_2">Should do</A></LI>
		<LI><A HREF="#PRIORITY_3">Want to do</A></LI>
		<LI><A HREF="#PRIORITY_4">Keep in mind</A></LI>
		<LI><A HREF="#PRIORITY_5">Refrain from doing</A></LI>
		<LI><A HREF="#PRIORITY_NULL">Never do</A></LI>
	</OL>
		<?PHP 
		buildStyleSwitcherGUI(array(
								"Ponies"
							  , 	new Stylesheet("/_css/visual_Dynamo_Orangejack.php"    , "Orangejack"    )
							  , 	new Stylesheet("/_css/visual_Dynamo_Pinky.php"         , "Pinky"         )
							  , 	new Stylesheet("/_css/visual_Dynamo_Rainblue.php"      , "Rainblue"      )
							  , 	new Stylesheet("/_css/visual_Dynamo_Rarewhity.php"     , "Rarewhity"     )
							  , 	new Stylesheet("/_css/visual_Dynamo_Twirple.php"       , "Twirple"       )
							  , 	new Stylesheet("/_css/visual_Dynamo_Yellowshy.php"     , "Yellowshy"     )
							  , 	new Stylesheet("/_css/visual_Dynamo_Whitelestia.php"   , "Whitelestia"   )
							  , 	new Stylesheet("/_css/visual_Dynamo_LunaticBlue.php"   , "Lunatic Blue"  )
							  , "Doctors"
							  , 	new Stylesheet("/_css/visual_Dynamo_Sexy.php"          , "Sexy Blue (WIP)")
							  , 	new Stylesheet("/_css/visual_Dynamo_Fez.php"           , "Fez"           )
							  )); // Build the GUI for switching stylesheets
	?>
	<INPUT TYPE="checkbox" CHECKED="" ID="SIDEBAR_PIN" ONCHANGE="setSidebarPinned(this.checked)" TITLE="Click here to unpin the sidebar">
</NAV>
</BODY>
</HTML>
