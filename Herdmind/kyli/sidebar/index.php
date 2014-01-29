<!DOCTYPE HTML>
<!--
This is a mockup of the Herdmind front page as envisioned by Kyli Rouge|Supuhstar|Digit Shine
This mockup is copyright Herdmind.net ©2013
-->
<?PHP
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php";      // Also includes config.php (must be done first) and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";        // Start session and determine subdomain - do this second
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilderIndex.php"; // Builds body content for index

function buildHeaderSidebar($userName = null, $mod = true) // !!!!!!!! Set to true for testing. When implemented, SET TO FALSE !!!!!!!!
{
	$userName = $_GET["login"];
	echo "
<HEADER>
	<H1>
		<A HREF=\"/\">
			Herdmind
			<SPAN CLASS=\"slogan\">The Headcanon Database</SPAN>
		</A>
	</H1>
	<NAV ID=\"USERNAV\">";
	if ($userName)
		echo "
		<UL ID=\"LOGGED_IN_USERNAV\">
			<LI CLASS=\"expandable\"><A HREF=\"/login.php?logout=yesplease\">" . $userName . "</A></LI>
			<LI><A HREF=\"/login.php?logout=yesplease\">                     Log Out</A></LI>
		</UL>";
	else
		echo "
		<UL ID=\"LOGGED_OUT_USERNAV\">
			<LI><A HREF=\"http://herdmind.net/forum/?action=register\">Login | Register</A></LI>
		</UL>";
	echo "
	</NAV>
</HEADER>

";
	buildSidebar($userName, $mod);
}

function buildSidebar($userName = null, $mod = false)
{
	$pinned = $_COOKIE["pinSidebar"] != "false";
	echo "
<NAV ID=\"SIDEBAR\" CLASS=\"" . ($pinned ? "" : "un") . "pinned\">
	<INPUT TYPE=\"checkbox\"" . ($pinned ? "CHECKED" : "") . " ID=\"SIDEBAR_PIN\" ONCHANGE=\"setSidebarPinned(this.checked)\" TITLE=\"Click here to " . ($pinned ? "un" : "") . "pin the sidebar\"/>
	<UL>
		<LI>
			<FORM ID=\"SEARCH_FORM\">
				<LABEL CLASS=\"hideWhenMediaQuery\" FOR=\"SEARCH_BAR\" VALUE=\"Search: \">Search: </LABEL>
				<INPUT ID=\"SEARCH_BAR\" TYPE=\"search\" AUTOCOMPLETE=\"on\" PLACEHOLDER=\"Search\"/>
				<!--INPUT TYPE=\"submit\" VALUE=\"Search!\"/-->
			</FORM>
		</LI>
		<LI><A HREF=\"/\">Home</A></LI>";
	if ($userName)
		echo "
		<LI CLASS=\"expandable\"><A HREF=\"/forum/index.php?action=profile\">" . $userName . "</A>
			<UL>
				<LI><A HREF=\"/forum/index.php?action=profile\">       Profile           </A></LI>
				<LI><A HREF=\"/forum/index.php?action=unreadreplies\"> Unread Messages   </A></LI>
				<LI><A HREF=\"/forum/index.php?action=unreadreplies\"> New Replies       </A></LI>
				<LI><A HREF=\"/recentvotes.php\">                      Your Recent Votes </A></LI>
				<LI><A HREF=\"/login.php?logout=yesplease\">           Log Out           </A></LI>
			</UL>
		</LI>";
	echo "
		<LI CLASS=\"expandable\"><A HREF=\"/browse/\">Browse</A>
			<UL>
				<LI><A HREF=\"/browse/index.php?type=Character\"> Characters </A></LI>
				<LI><A HREF=\"/browse/index.php?type=Species\">   Species    </A></LI>
				<LI><A HREF=\"/browse/index.php?type=Place\">     Places     </A></LI>
				<LI><A HREF=\"/browse/index.php?type=Event\">     Events     </A></LI>
				<LI><A HREF=\"/browse/index.php?type=Object\">    Objects    </A></LI>
				<LI><A HREF=\"/browse/index.php?type=Other\">     Other      </A></LI>
			</UL>
		</LI>
		<LI><A HREF=\"/forum/\">Forums</A></LI>
	</UL>
</NAV>";
}

function buildSidebarHeadContent()
{
	echo "
<SCRIPT TYPE=\"text/javascript\">
var cookie = document.cookie;
var COOKIE_NAME = \"pinSidebar\";
function setSidebarPinned(pinned)
{
	document.getElementById(\"SIDEBAR\").className = pinned ? \"pinned\" : \"unpinned\";
	document.getElementById(\"SIDEBAR_PIN\").title = \"Click here to \" + (pinned ? \"un\" : \"\" ) + \"pin the sidebar\";
	
    document.cookie = COOKIE_NAME + \"=\" +
	                  encodeURIComponent(pinned ? \"true\" : \"false\") +
	                  \"; max-age=\" + (60 * 60 * 24 * 28) + // Live for 28 days. Change the \"28\" to change the number of days.
	                  \"; path=/\" + 
	                  \"; domain=herdmind.net\";
}
</SCRIPT>
";
}
?>
<HTML>
<HEAD>

<!-- BEGIN Metadata -->
<TITLE>Herdmind</TITLE>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" />
<!-- END Metadata -->

<?PHP
buildDefaultHeadContent(); // Empty, because the generic content represents the homepage well
buildSidebarHeadContent(); // Will be combined with buildDefaultHeadContent on final implementation
?>
</HEAD>



<BODY>
<?PHP
buildHeaderSidebar();
?>



<SECTION>
	<P>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent non velit diam, et pharetra velit. Curabitur venenatis congue lacus a venenatis. Sed egestas, augue et auctor viverra, nibh tellus fringilla leo, a venenatis dui diam nec justo. Nullam in nunc justo. Donec non sapien ut felis vulputate sagittis quis sit amet diam. Cras sed sem tellus, sit amet elementum metus. Morbi vulputate lacus id metus porttitor eu malesuada tortor blandit. Duis scelerisque, sem vel varius pretium, justo magna imperdiet orci, quis rutrum eros lacus vel mauris. Fusce ligula ipsum, fringilla ac tincidunt eu, elementum eu dolor. Nunc non diam in quam pretium dignissim a non sem. Mauris rutrum dignissim metus ut tincidunt. Pellentesque mollis ipsum eget purus tincidunt suscipit. Nam neque eros, mattis vel imperdiet vitae, mollis ac mi. Praesent quis dui enim. Curabitur tincidunt blandit interdum. </P>

	<P>Morbi laoreet, risus eu adipiscing consequat, felis mauris imperdiet neque, et tempor lorem orci quis tortor. Nulla facilisi. Phasellus blandit eleifend nisi, quis imperdiet sem viverra vitae. Quisque erat velit, fermentum et blandit eget, rhoncus vel ipsum. Praesent at molestie nisl. Maecenas eleifend egestas quam. Curabitur convallis sodales sem, faucibus cursus orci condimentum non. Nam condimentum ligula sed enim imperdiet id laoreet nulla feugiat. Donec massa nunc, egestas ut pharetra sed, fringilla sed urna. Nulla sed ipsum purus, vel luctus quam. In aliquet tempor semper. Integer at purus eu tellus auctor auctor. </P>

	<P>Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Etiam ante augue, lobortis ac facilisis at, pellentesque tincidunt nibh. Vestibulum risus augue, feugiat ac vehicula vel, molestie a ante. Integer rhoncus erat sit amet erat congue consequat molestie nulla sollicitudin. Maecenas nec dui mi, posuere consequat risus. Curabitur at odio non nibh porttitor tincidunt. Nullam commodo neque et libero ullamcorper ornare. Suspendisse potenti. Integer mauris augue, facilisis ac placerat eget, consectetur in nunc. Maecenas porttitor egestas consequat. Etiam non augue mauris, gravida adipiscing felis. </P>

	<P>Suspendisse ac venenatis libero. Vivamus pharetra tempor velit vel accumsan. Morbi in ipsum quis leo rutrum lacinia pulvinar id nisl. Praesent gravida urna nec magna hendrerit vulputate. Pellentesque viverra commodo erat, in molestie est ultrices vitae. Quisque dictum congue felis eget vestibulum. Proin laoreet mollis quam consequat egestas. Morbi tincidunt nulla at orci venenatis lobortis. Donec hendrerit metus et massa sollicitudin convallis. Fusce sed diam vel nulla feugiat interdum id eu nisi. Proin aliquet, dui et molestie consectetur, augue orci ornare lorem, sit amet pellentesque nisi quam vitae felis. Ut lacinia venenatis nulla, nec rhoncus ipsum luctus quis. Nullam ut purus lorem, sed gravida justo. Suspendisse a massa sit amet lectus malesuada feugiat. Quisque est metus, porta eu ultricies et, vestibulum ut arcu. In hac habitasse platea dictumst. </P>

	<P>Mauris mattis, lorem ac sollicitudin laoreet, sapien justo consequat nisi, vitae cursus magna elit nec ligula. Morbi tincidunt lectus in mauris consequat suscipit. Ut sit amet lacinia lorem. Integer a orci eu lacus sollicitudin venenatis non non est. Phasellus mollis est sed felis aliquam convallis. Morbi semper ipsum quis dolor rhoncus malesuada. Mauris vel urna iaculis turpis dignissim laoreet. Praesent luctus tempus tortor a viverra. Vivamus vel augue ligula, eu tincidunt elit. Fusce viverra, enim sit amet auctor laoreet, purus ligula porta metus, ut tristique nisi ipsum ut neque. Mauris porta ullamcorper massa, ut pulvinar nisi porta nec. Aenean ac felis metus, quis fringilla nisl. Quisque convallis, tellus at ornare suscipit, nisl eros elementum mi, vitae vulputate tortor libero quis lectus. Nunc in massa vitae nisl dictum ullamcorper. Integer non ante at ligula hendrerit fermentum.</P>
<SECTION>



<?PHP
buildFooter(); // Adds the footer
?>

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
		<?PHP
		buildStyleSwitcherGUI(array("Ponies",
		                      	array("/_css/visual_ProposalOrangejack.css","Orangejack"),
		                      	array("/_css/visual_ProposalPinkie.css","Pinkie"),
		                      	array("/_css/visual_ProposalRainblue.css","Rainblue"),
		                      	array("/_css/visual_ProposalRarewhity.css","Rarewhity"),
		                      	array("/_css/visual_ProposalTwirple.css","Twirple"),
		                      	array("/_css/visual_ProposalYellowshy.css","Yellowshy"),
		                      	array("/_css/visual_ProposalSomblack.css","Somblack"),
								"Vivid",
		                      	array("/_css/visual_Proposal_DigitalBlue.css","Digital Blue"),
		                      	array("/_css/visual_Proposal_SillyMagenta.css","Silly Magenta")
		                      )); // Build the GUI for switching stylesheets
		?>
	</P>
	<P>
		To change the header options, set the URL parameter "<CODE>login</CODE>" to "<CODE>true</CODE>" or "<CODE>false</CODE>".
	</P>
	<P>
		Oldest <EM>tested</EM> working desktop browsers are Chrome 25, Firefox 18, IE 9, Opera 11, and Safari 5. Mobile browsers
		are Chrome and Opera.
	</P>
</SECTION>
</BODY>
</HTML>