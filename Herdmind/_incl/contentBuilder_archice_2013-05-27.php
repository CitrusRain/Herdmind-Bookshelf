<?PHP
/* 
 * A general-use file for building common page elements on Herdmind, such as the header and footer, or links to topics.
 * 
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! WARNING TO ALL DEVELOPERS VIEWING THIS FILE !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 * !!! ANY EDIT TO THIS FILE WILL AFFECT THE ENTIRE SITE! IT'S RECOMMENDED THAT YOU USE BACKUPS AND TEST COPIES, FIRST !!!
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 * 
 * @since 2013-03-01
 */

include $_SERVER['DOCUMENT_ROOT']."/_incl/config.php";
include $_SERVER['DOCUMENT_ROOT']."/_incl/styleSwitch.php";



/**
 * Builds the default content to go in every page's <HEAD> tag.
 * 
 * @param $tabText         [OPTIONAL] the text to go in the browser tab. If given, tab text will be "$tabText - Herdmind". Else,
 *                         		it will simply be "Herdmind"
 * @param $longDescription [OPTIONAL] the complete description of the page and its purpose
 * @param $keywords        [OPTIONAL] an array of keywords used by search engines to find this page
 * 
 * @author Kyli Rouge
 * @since 2013-03-14
 * @version 1.0.0 (2013-03-14)
 */
function buildDefaultHeadContent($tabText = null, $longDescription = null, $keywords = null) // !!!!!!!!!!!!!!!!!!!! CHANGE TITLE TAG BUILDING BEFORE FINAL IMPLEMENTATION
{
	echo "<TITLE>" . (isset($tabText) ? $tabText . " &ndash; " : "") . "Herdmind&nbsp;&beta;</TITLE>

<!-- BEGIN Meta data -->
<META HTTP-EQUIV=\"Content-Type\" CONTENT=\"text/html;charset=utf-8\" />
<META NAME=\"viewport\"    CONTENT=\"target-densitydpi=device-dpi, initial-scale=1.0, user-scalable=no\" /> <!-- If user is on mobile, suggest to not allow pinch-zoom -->
<META NAME=\"description\" CONTENT=\"";
	if ($longDescription)
		echo $longDescription;
	else
		echo "Herdmind, the headcanon database";
	echo "\"/>
<META NAME=\"keywords\"    CONTENT=\"Herdmind,Headcanon,Database";
	if ($keywords)
		if(is_array($keywords))
			foreach ($keywords as $keyword)
				echo "," . $keyword;
		else
			echo $keywords;
	else
		echo "webpage,generic";
	echo "\"/>
<META HTTP-EQUIV=\"X-UA-Compatible\" CONTENT=\"chrome=IE8\" /> <!-- INVALID: Consider altermatives. - If user is using IE 8 or older and has Chrome Frame, use Chrome Frame -->
<!-- END Meta data -->

<!-- BEGIN Representative images -->
<LINK REL=\"shortcut icon\"                TYPE=\"image/x-icon\"    HREF=\"/favicon.ico\" />
<!--LINK REL=\"apple-touch-icon\"             TYPE=\"image/png\"       HREF=\"/touchIcon.png\" /-->
<!--LINK REL=\"apple-touch-icon-precomposed\" TYPE=\"image/png\"       HREF=\"/touchIcon.png\" /-->
<!-- END Representative images -->

<SCRIPT TYPE=\"text/javascript\" SRC=\"//code.jquery.com/jquery.min.js\">/* jQuery */</SCRIPT>
";
	
	buildStyleSwitcherHeadContent("/_css/visual_Dynamo.css");
	buildSidebarHeadContent();
	buildDialogHeadContent();
}

/**
 * Builds the <HEAD> content necessary for the sidebar to properly function.
 * 
 * @author Kyli Rouge
 * @since 2013-03-18
 * @version 1.0.1 (2013-03-19)
 */
function buildSidebarHeadContent()
{
	echo "
<SCRIPT TYPE=\"text/javascript\" SRC=\"/_js/sidebar.js\">/* Sidebar Scripts */</SCRIPT>
";
}

/**
 * Builds the <HEAD> content for handling HTML5 dialogs.
 * 
 * @author Kyli Rouge
 * @since 2013-03-24
 * @version 1.0.0 (2013-03-24)
 */
function buildDialogHeadContent()
{
	echo "<SCRIPT TYPE=\"text/javascript\" SRC=\"/_js/dialogs.js\">/* Dialog handling */</SCRIPT>
";
}

/**
 * Builds the <BODY> tag, with dynamic attributes depending on the user's cookies.
 * 
 * @author Kyli Rouge
 * @since 2013-03-19
 * @version 1.0.0 (2013-03-19)
 */
function buildBodyTagWithAttributes()
{
	$pinned = $_COOKIE["pinSidebar"];
	$pinned = isset($pinned) && $pinned != "false";
	echo "<BODY" . ($pinned ? " CLASS=\"withSidebar\"" : "") . ">";
}

/**
 * Builds the header of all Herdmind public-facing pages.
 * 
 * @param $loggedIn [OPTIONAL] Specified whether to build a header for a logged-in or logged-out user. If the user is logged in,
 *                  	then pass the value true. Else, you may omit this argument or set it to false.
 * 
 * @author Kyli Rouge
 * @since 2013-03-01
 * @version 1.0.0 (2013-03-01)
 */
function buildHeader($userName = null, $mod = false)
{
    global $parsedFandom; echo "<!-- fandom is $parsedFandom -->";
	$userName = $_GET["login"]; // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! REMOVE WHEN IMPLEMENTING !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	$mod = $_GET["mod"] == "true"; // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!! REMOVE WHEN IMPLEMENTING !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	echo "
<HEADER>
	<H1>
		<A HREF=\"/\">
			Herdmind
			<SPAN CLASS=\"slogan\">The $parsedFandom Headcanon Database</SPAN>
		</A>
	</H1>
	<DIV CLASS=\"warning alert hideIfMediaQuery\">Your browser is unsupported!</DIV>
	<NAV ID=\"USERNAV\">";
	if ($userName)
		echo "
		<UL ID=\"LOGGED_IN_USERNAV\">
			<LI><A HREF/forum?action=profile\" CLASS=\"button\">" . $userName . "</A></LI>
			<LI><A ONCLICK=\"showDialog($('#LOGGER')); return false;\" HREF=\"/login.php?logout=yesplease\">Log Out</A></LI>
		</UL>";
	else
		echo "
		<UL ID=\"LOGGED_OUT_USERNAV\">
			<LI><A ONCLICK=\"showDialog($('#LOGGER')); return false;\" HREF=\"/forum/?action=register\" CLASS=\"button\">Login | Register</A></LI>
		</UL>";
	echo "
	</NAV>
</HEADER>

";
}

/**
 * Builds the sidebar, customized for the given user.
 * 
 * @param $userName the name of the current user. Expected values are a string (username) and "false".
 * @param $mod      set whether this is for a moderator. Expected values are true and false.
 *                  This is ignored if $userName is false
 * 
 * @author Kyli Rouge
 * @since 2013-03-18
 * @version 1.0.1 (2013-03-20)
 */
function buildSidebar($userName = null, $mod = false)
{
	$pinned = $_COOKIE["pinSidebar"] != "false";
	echo "
<NAV ID=\"SIDEBAR\">
	<H2><LABEL FOR=\"SIDEBAR_PIN\">Navigation</LABEL></H2>
	<UL>
		<LI>
			<FORM ID=\"SEARCH_FORM\" ACTION=\"/search\" METHOD=\"get\">
				<LABEL CLASS=\"hideWhenMediaQuery\" FOR=\"SEARCH_BAR\">Search: </LABEL>
				<INPUT ID=\"SEARCH_BAR\" NAME=\"search\" TYPE=\"search\" AUTOCOMPLETE=\"on\" PLACEHOLDER=\"Search\"/>
				<!--INPUT TYPE=\"submit\" VALUE=\"Search!\"/-->
			</FORM>
		</LI>
		<LI CLASS=\"expandable\"><A HREF=\"/\">Home</A>
			<UL>";
	if ($mod)
		echo "
				<LI><A HREF=\"/ApproveSubmission.php\">Approve Submissions</A></LI>
				<LI><A HREF=\"/Moderation.php\">Moderation</A></LI>
				<LI><A HREF=\"/ManageFlagged.php\">Manage Flagged</A></LI>
				<LI><A HREF=\"/private/Branch.php\">Fix branches</A></LI>
				<LI><A HREF=\"//beta.herdmind.net\">Beta portal</A></LI>";
	else
		echo "
				<LI><A HREF=\"//tardis.herdmind.net\">Doctor Who</A></LI>
				<LI><A HREF=\"//pony.herdmind.net\">Friendship is Magic</A></LI>
				<LI><A HREF=\"//ppg.herdmind.net\">Powerpuff Girls</A></LI>";
	echo "
				<LI><A HREF=\"//herdmind.net\">Site Portal</A></LI>
			</UL>
		</LI>";
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
		<LI>
			";
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
		                      , 	new Stylesheet("/_css/visual_Dynamo_Sexy.php"          , "Sexy Blue"     )
		                      , 	new Stylesheet("/_css/visual_Dynamo_Fez.php"           , "Fez"           )
		                      , "Girls"
		                      , 	new Stylesheet("/_css/visual_Dynamo_Blossom.php"       , "Blossom"       )
		                      , 	new Stylesheet("/_css/visual_Dynamo_Bubbles.php"       , "Bubbles"       )
		                      , 	new Stylesheet("/_css/visual_Dynamo_Buttercup.php"     , "Buttercup "    )
		                      , "Elements"
		                      , 	new Stylesheet("/_css/visual_Dynamo_Earth.php"         , "Earth (WIP)"   )
		                      , 	new Stylesheet("/_css/visual_Dynamo_Fire.php"          , "Fire (WIP)"    )
		                      , 	new Stylesheet("/_css/visual_Dynamo_Air.php"           , "Air (WIP)"     )
		                      , 	new Stylesheet("/_css/visual_Dynamo_Water.php"         , "Water (WIP)"   )
		                      )); // Build the GUI for switching stylesheets
		echo "
		</LI>
	</UL>
	<INPUT TYPE=\"checkbox\"" . ($pinned ? " CHECKED" : "") . " ID=\"SIDEBAR_PIN\" ONCHANGE=\"setSidebarPinned(this.checked)\"".
	" TITLE=\"Click here to " . ($pinned ? "un" : "") . "pin the sidebar\"/>
</NAV>";
}

/**
 * Builds the footer at the bottom of the page. As of this version, it is not dynamic and always builds the same thing.
 * 
 * @author Kyli Rouge
 * @since 2013-03-01
 * @version 1.0.0 (2013-03-13)
 */
function buildFooter($userName = null, $mod = false)
{
	$userName = $_GET["login"]; // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! REMOVE WHEN IMPLEMENTING !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	$mod = $_GET["mod"] == "true";
	echo buildSidebar($userName, $mod);
	echo buildLogger($userName, $mod);
	echo "
<FOOTER>
	<SECTION ID=\"LINKS\">
		<H2>Links:</H2>
		<UL CLASS=\"plain\">
			<LI><A HREF=\"/legal\">Legal</A></LI>
			<LI><A HREF=\"/contact\">Contact</A></LI>
		</UL>
	</SECTION>
	<SECTION>
		<!-- BEGIN Google+ Badge -->
		<div class=\"g-plus\" data-width=\"5em\" data-href=\"https://plus.google.com/115556066131792258384\" data-rel=\"publisher\"></div>

		<script type=\"text/javascript\">
		  (function() {
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = 'https://apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		  })();
		</script>
		<!-- END Google+ Badge -->
	</SECTION>
</FOOTER>";
}




/**
 * Builds a list of links to Herdmind fanfact topics, given an array of topic numbers.
 * 
 * @param $topicIndices an array of numbers, corresponding to Herdmind topics
 * @param $dbc          the connection to a Herdmind database
 * 
 * @author Kyli Rouge
 * @since 2013-03-12
 * @version 1.0.1 (2013-03-13)
 */
function buildTopicLinkList($topicIndices = array(), $dbc = null, $listClass = "")
{
	if ($dbc === null)
		$dbc = $db_connection;
	$ret = "
	<UL CLASS=\"topics " . $listClass . "\">";
	foreach($topicIndices as $topicIndex)
		$ret .= buildTopicLink($topicIndex, false, $dbc);
	$ret .= "
	</UL>";
	
	return $ret;
}

/**
 * Builds a single topic link, which contains the topic's thumnail and all its defined names, with the most voted at the top.
 * You needn't worry about changing this based on where it is placed, as resizing is taken care of in CSS.
 * 
 * @param $topicIndex the index of the topic that this link showcases
 * @param $listItem   [OPTIONAL] defines whether this is a part of a list or a standalone. If it is in a list, then set this to
 *                    	true. If it is not in a list, you may omit this argument or set it to false.
 * @param $dbc        the connection to a Herdmind database
 * 
 * @author Kyli Rouge
 * @since 2013-03-12
 * @version 1.1.0 (2013-03-13)
 */
function buildTopicLink($topicIndex, $standalone = true, $dbc = null)
{
	if ($dbc === null)
	{
		global $db_connection;
		$dbc = $db_connection;
	}
	$names = mysqli_fetch_array(
				mysqli_query($dbc,
				"SELECT PageTitles.Title
				AS Title, PageTitles.ID, COUNT( NSBT.UserPoint ) 
				FROM NameScoreByTally
				AS NSBT
				RIGHT OUTER JOIN PageTitles ON PageTitles.ID = NSBT.NameID
				WHERE PageTitles.PageID = '$topicIndex'
				GROUP BY PageTitles.ID
				ORDER BY COUNT( NSBT.UserPoint )
				DESC LIMIT 0, 1"
				), MYSQL_ASSOC); // Fetch all the alternate names for the topic in the format 
	
	if (!isset($names))
		$names = array("ERROR: No names pulled from database");
	
	$tagName = ($standalone ? "DIV" : "LI");
	$imgPath = "http://pony.herdmind.net/Images/headshots/" . $topicIndex . ".png";
	/* Doesn't work:
	if (!file_exists($imgPath))
		$imgPath = "http://pony.herdmind.net/Images/headshots/" . $topicIndex . ".jpg";
	if (!file_exists($imgPath))
		$imgPath = "http://placehold.it/256&text=No%20Image";*/
	$ret = "
		<" . $tagName . ">
			<A HREF=\"http://pony.herdmind.net/topic.php?pageid=" . $topicIndex . "\" CLASS=\"topic\">
				<FIGURE>
					<IMG CLASS=\"thumb\" SRC=\"" . $imgPath . "\"/>
					<FIGCAPTION>
						<UL>";
		// TODO: Make a foreach loop to add each alternate name
		$ret .= "
							<LI>" . $names['Title'] . "</LI>";
	$ret .= "
						</UL>
					</FIGCAPTION>
				</FIGURE>
			</A>
		</" . $tagName . ">";
	
	return $ret;
}



/**
 * Builds the log window. If $userName is false, null, or unspecified, then this is a Log In window. Else, this is a Log Out
 * window. Please forgive me for using a Table to lay out the components...
 * 
 * @param $userName The user's username
 * @param $mod      Specifies whether the user is a moderator. So far, this does nothing.
 * 
 * @author Kyli Rouge
 * @since 2013-03-24
 * @version 1.0.0 (2013-03-24)
 */
function buildLogger($userName, $mod)
{
	echo "


<DIV CLASS=\"dialogHolder\" ONCLICK=\"handleDialogHolderClicked\">
	<DIALOG ID=\"LOGGER\">
		<INPUT CLASS=\"close\" TYPE=\"button\" VALUE=\"&times;\" ONCLICK=\"hideDialog('#LOGGER')\" ID=\"CLOSE\"/>";
	if ($userName)
	{
		echo "
		<FORM ACTION=\"http://herdmind.net/login.php?logout=yesplease\">
			<TABLE>
				<TBODY>
					<TR><TH COLSPAN=\"2\"><H2>Log out</H2></TH></TR>
					<TR>
						<TD COLSPAN=\"2\">Are you sure you want to go, " . $userName . "?</TD>
					</TR>
					<TR>
						<TD><INPUT TYPE=\"SUBMIT\" ID=\"LOGOUT\" VALUE=\"Log out\"></TD>
						<TD><INPUT TYPE=\"RESET\" ID=\"CLOSE\" VALUE=\"Stay here\" ONCLICK=\"hideDialog('#LOGGER')\"></TD>
					</TR>
				</TBODY>
			</TABLE>";
	}
	else
	{
		echo "
		<FORM ACTION=\"#\"
		      METHOD=\"post\"
		      ACCEPT-CHARSET=\"ISO-8859-1\">
			<TABLE CLASS=\"collapsed\">
				<TBODY>
					<TR><TH COLSPAN=\"2\">Log in</TH></TR>
					<TR>
						<TH><LABEL FOR=\"LOGIN_USERNAME\">Username:&nbsp;</LABEL></TH>
						<TD><INPUT ID=\"LOGIN_USERNAME\" TYPE=\"text\" NAME=\"user\"/></TD>
					</TR>
					<TR>
						<TH><LABEL FOR=\"LOGIN_PASSWORD\">Password:&nbsp;</LABEL></TH>
						<TD><INPUT ID=\"LOGIN_PASSWORD\" TYPE=\"password\" NAME=\"password\"/></TD>
					</TR>
					<TR>
						<TD COLSPAN=\"2\">
							<INPUT TYPE=\"submit\" VALUE=\"Log in!\"/>
							|
							<A HREF=\"http://pony.herdmind.net/forum/index.php?action=register\" CLASS=\"alt\">Register</A>
						</TD>
					</TR>
				</TBODY>
			</TABLE>";
	}
	echo "
		</FORM>
	</DIALOG>
</DIV>";
}




function buildFacts($FactQueryResult, $HowMany = 1)
{
	$StringTheorum = '
		<UL CLASS="fanfacts">';
	
	for($i = 0; $i < $HowMany; $i++)
		$StringTheorum = $StringTheorum . buildFact(mysqli_fetch_array($FactQueryResult), false);
	
	$StringTheorum = $StringTheorum . '
		</UL>';
	
	return $StringTheorum;
}

/**
 * Builds a fact display. Assume the same query's column ordering is used for every call.
 * 
 * @param $fact       the fanfact, as an array.
 * 		Structure:
 * 			 - [0] the number of the fanfact
 * 			 - [1] the post date.
 * 			 - [2] the fact text.
 * 			 - [3] the sum of votes on the fact.
 * 			 - [4] the sum of the current user's votes.
 * @param $standalone [OPTIONAL] if true, this method assumes that this fact will not be part of a list. Defaults to true
 * 
 * @author Ryan Young, Kyli Rouge
 * @since 2013-03-27
 * @version 1.0.2 (2013-05-22)
 */
function buildFact($fact, $standalone = true, $moreData = true)
{
	//	TODO: Insert more of the result list here, and make it work for more queries.
	$factstring =
			'
			<' . ($standalone ? 'DIV' : 'LI') .
				' CLASS="' . ($fact[4] ? ($fact[4] < 0 ? "down" : "up") . "voted " : "") . "fanfact\">
				 <TABLE CLASS=\"vote\">
					<TBODY>
						<TR>
							<TD ROWSPAN=\"2\">
								<VAR CLASS=\"counter\">$fact[3]</VAR>
							</TD>
							<TD>
								<INPUT TYPE=\"button\" CLASS=\"upvote\" VALUE=\"&#x25B2;\"/>
							</TD>
						</TR>
						<TR>
							<TD>
								<INPUT TYPE=\"button\" CLASS=\"downvote\" VALUE=\"&#x25BC;\"/>
							</TD>
						</TR>
					</TBODY>
				 </TABLE>
				 <DIV CLASS=\"fact\">$fact[2]</DIV>" . ($moreData ? "
				 <A HREF=\"/fanfact?factid=$fact[0]\" CLASS=\"meta callToAction\">More data</A>" : "<DIV CLASS=\"meta\"><SPAN>$fact[0]</SPAN></DIV>") . '
			</' . ($standalone ? 'DIV' : 'LI') . '>';
	return $factstring;
}

/**
 * Grabs the highest voted name for a page, and replaces the page code with a link and title to that page.
 * 
 * @author Ryan Young
 * @since October 2012
 * @version 1.0.1 (4-10-2013)
 */
function TitleFiller($string, $dbc = null)
{
	$pos1 = strpos($string, "[p") + 2;
	$pos2 = strpos($string , "]");
	$cou = 0;
	while($pos1 != -1 && $pos2 != -1 && $cou < 50)
	{
		$pageid = substr($string,$pos1,$pos2-$pos1);
				
		$query =  "SELECT PageTitles.Title, PageTitles.ID, COUNT( NSBT.UserPoint ),
		p.Picture, p.Type, p.FanCan, b.BranchName
		FROM ((NameScoreByTally AS NSBT
		Right outer JOIN PageTitles ON PageTitles.ID = NSBT.NameID) join Page as p on p.PageID = PageTitles.PageID 
		) join Branch as b on p.Branch = b.BranchID 
		where PageTitles.PageID = '$pageid'
		Group by PageTitles.ID
		ORDER BY COUNT( NSBT.UserPoint ) desc LIMIT 0, 1";

		$rs = executeSQL($query, "Query failed during titlefiller", $dbc);

		$Title = htmlentities($rs[0],ENT_QUOTES);
		
		$string = str_replace("[p$pageid]","<div class=\"popname\">
			<a href=\"topic.php?pageid=$pageid\" class=\"apagetitle\">$Title</a><!-- These comments are here because there must be NO whitespace before, within, or after this fanfact, or else things like punctuation marks will not properly be placed flush with the fact
			--><div class=\"informinglink\"><!--
				--><img src=\"http://herdmind.net/". str_replace("../", "", $rs[3])."\" ALT=\"A picture of $Title\"/><!--
					--><DL><!--
						--><DT>Type</DT><!--
							--><DD>$rs[4]</DD><!--
						--><DT>Reality</DT><!--
							--><DD>$rs[5]</DD><!--
						--><DT>Series</DT><!--
							--><DD>$rs[6]</DD><!--
					--></DL><!--
			--></div><!--
		--></div>",$string);

		$pos1 = strpos($string, "[p") + 2;
		$pos2 = strpos($string , "]");
		$cou = $cou + 1;
	}

	return $string;
}



/**
*Helper function intended to be universal. But I confused myself and abandoned it after using it only a few times.
*Is called by several versions of TitleFiller()
*/
function executeSQL($query, $error = "Query failed", $dbc = null)
{
	$result = mysqli_query($dbc, $query) or die($error.': ' . mysqli_error($dbc));

	while ($line = mysqli_fetch_array($result, MYSQL_ASSOC))
	{
		$results = array();
		$pos = 0;
		foreach ($line as $col_value)
		{
			$results[$pos] = "$col_value";
			$pos++;
		}	 
		return $results;
	}
}
?>
