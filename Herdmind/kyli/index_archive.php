<!DOCTYPE HTML>
<!--
This is a mockup of the Herdmind front page as envisioned by Kyli Rouge|Supuhstar|Digit Shine
This mockup is copyright Herdmind.net ©2013
-->
<?PHP
include "_incl/contentBuilder.php";
?>
<HTML>
<HEAD>
<TITLE>Herdmind</TITLE>

<!-- BEGIN Stylesheets -->
<LINK REL="stylesheet"                    HREF="_css/visual_Proposal.css"/>
<LINK REL="stylesheet" TITLE="Rarewhity"  HREF="_css/visual_ProposalRarewhity.css"  DISABLED="true"/>
<LINK REL="stylesheet" TITLE="Orangejack" HREF="_css/visual_ProposalOrangejack.css" DISABLED="true"/>
<LINK REL="stylesheet" TITLE="Pinkie"     HREF="_css/visual_ProposalPinkie.css"     DISABLED="true"/>
<LINK REL="stylesheet" TITLE="Rainblue"   HREF="_css/visual_ProposalRainblue.css"   DISABLED="true"/>
<LINK REL="stylesheet" TITLE="Twirple"    HREF="_css/visual_ProposalTwirple.css"    DISABLED="true"/>
<LINK REL="stylesheet" TITLE="Yellowshy"  HREF="_css/visual_ProposalYellowshy.css"  DISABLED="true"/>
<!-- END Stylesheets -->

<!-- BEGIN Scripts -->
<SCRIPT TYPE="text/javascript" SRC="_js/styleSwitch.js"></SCRIPT>
<!-- END Scripts -->
</HEAD>



<BODY>
<?PHP
$simulateLogin = $_GET["login"]; // Allows for testing of different layouts
if (isset($simulateLogin))
	buildHeader($simulateLogin === 'true');
else
	buildHeader(true); // false == header for logged-out, true == header for logged-in
?>



<?PHP
startPortalList();
	buildPortalItem("Doctor Who", "http://tardis.herdmind.net/", "http://herdmind.net/CSS/herdmind/SubsiteButtons/button_tardis.png");
	buildPortalItem("My Little Pony: Friendship is Magic", "http://pony.herdmind.net/", "http://herdmind.net/CSS/herdmind/SubsiteButtons/button_pony.png");
endPortalList();
?>



<FOOTER>
	<P CLASS="disclaimer">My Little Pony &copy; Hasbro</P>
	<P CLASS="disclaimer">Doctor Who, Sarah Jane Adventures, Torchwood, and the like &copy; BBC</P>
	<P CLASS="disclaimer">Herdmind is a non-profit, fan-made service which claims no ownership of the intellectual properties
	listed above.</P>
</FOOTER>

<SECTION ID="META">
	<BUTTON ONCLICK="META.style.display = 'none';">Hide developer's notes</BUTTON>
	<P>
		This work-in-progress is Kyli's proposal for a new Herdmind front page. It's <EM>completely</EM> W3C compliant and looks and
		works exactly the same on all modern browsers. It features a dynamic layout, capable of going down to 128 pixels wide on a
		default setup without causing unusability.
	</P>
	<H2>Testing</H2>
	<P>
		Colors can easily be changed, as demonstrated here:
		<SELECT ONCHANGE="return switchStyles(this);">
			<OPTION VALUE="None"      >Select a color!</OPTION>
			<OPTION VALUE="Orangejack">Orangejack</OPTION>
			<OPTION VALUE="Pinkie"    >Pinkie Pink</OPTION>
			<OPTION VALUE="Rainblue"  >Rainblue</OPTION>
			<OPTION VALUE="Rarewhity" >Rarewhity</OPTION>
			<OPTION VALUE="Twirple"   >Twirple</OPTION>
			<OPTION VALUE="Yellowshy" >Yellowshy</OPTION>
		</SELECT>
	</P>
	<P>
		To change the header options, set the URL parameter "<CODE>login</CODE>" to "<CODE>true</CODE>" or "<CODE>false</CODE>".
	</P>
	<P>
		Oldest <EM>tested</EM> working browsers are Chrome 25, Firefox 18, IE 9, Opera 11, and Safari 5.
	</P>
</SECTION>
</BODY>
</HTML>