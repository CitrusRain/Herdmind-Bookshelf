<!DOCTYPE HTML>
<!--
The search page

This page is copyright Herdmind.net ©2013
-->
<?PHP
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php"; // Also includes config.php and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";   // Start session and determine subdomain - do this second
include "functions.php";                                       // Search functions
?>
<HTML>
<HEAD>
<?PHP
$search = isset($_POST["search"]) ? $_POST["search"] : $_GET["search"];
if ($search)
{
	$parsedSearch = parseSearchTerms($search);
	buildDefaultHeadContent(
		"The Search for " . searchToEnglish($parsedSearch),
		"A search of Herdmind.net for anything relating to " . htmlentities(searchToEnglish($parsedSearch)),
		array("search",implode($parsedSearch, ","))
	);
}
else
{
	buildDefaultHeadContent(
		"Search",
		"Search Herdmind.net",
		array("search")
	);
}
?>
<STYLE> /* page-specific styles */
IFRAME {
	border: none;
	display: block;
	min-height: 20em;
	width: 100%;
}
#ADVANCED_SEARCH_FORM {
	-webkit-transition-property: opacity, max-height, padding;
	max-height: 10em;
	margin:1em 0;
	position:relative;
	z-index: 0;
}
#ADVANCED_SEARCH A {
	display: block;
	text-align:center;
}
#SEARCH_IFRAME {
	position:relative;
	z-index: 1;
}
</STYLE>
<STYLE> /* Will be moved to css files once finalized */
#SEARCH_PAGE_SEARCH {
	font-size: 1.5em;
	margin: 1em 0;
	text-align: center;
	
	
	/*transform: scale(1.5);
	-o-transform: scale(1.5);
	-ms-transform: scale(1.5);
	-moz-transform: scale(1.5);
	-webkit-transform: scale(1.5);*/
}
	#SEARCH_BAR_LARGE {
		border-radius: 1em 0 0 1em;
		border-right: none;
		width: 75%;
	}
	#SEARCH_BAR_BUTTON,
	#SEARCH_BAR_BUTTON_TINY {
		border-radius: 0 1em 1em 0;
	}
	#SEARCH_BAR_BUTTON_TINY {
		display: none;
	}
	#SEARCH_BAR_LARGE,
	#SEARCH_BAR_BUTTON,
	#SEARCH_BAR_BUTTON_TINY {
		border-width: 0.1em;
		font-size: inherit;
		margin: 0;
	}

.hidden {
	        animation: displayNone;
	     -o-animation: displayNone;
	    -ms-animation: displayNone;
	   -moz-animation: displayNone;
	-webkit-animation: displayNone;
	opacity: 0 !important;
	max-height: 0 !important;
	padding-top: 0 !important;
	padding-bottom: 0 !important;
}
@-webkit-keyframes displayNone
{
	100%{display:none}
}

INPUT[type=checkbox] {
	width: 1em;
	height: 1em;
	margin: 0;
	padding: 0;
}
	INPUT[type=checkbox]:checked {
		background: #6A50A7; /* Will be moved to dynamoThemeGenerator.php */
	}
	INPUT[type=checkbox]:checked::before {
		content: "✔";
		color: #FFF;
		vertical-align: top;
		line-height: 100%;
		text-align: center;
	}
TABLE.pretty {
	border-collapse: collapse;
}
	TABLE.pretty TH, TABLE.pretty TD {
		border: thin solid #6A50A7; /* Will be moved to dynamoThemeGenerator.php */
		padding: 0.25em 0.5em;
	}
	TABLE.pretty TH {
		background-color: #6A50A7; /* Will be moved to dynamoThemeGenerator.php */
		border-color: #FFF !important; /* Will be moved to dynamoThemeGenerator.php */
		color: #FFF; /* Will be moved to dynamoThemeGenerator.php */
	}
		TABLE.pretty TH:first-child {
			text-align: right;
		}
		TABLE.pretty TH:last-child {
			text-align: left;
		}
		TABLE.pretty THEAD TH {
			vertical-align: bottom;
		}
		TABLE.pretty TFOOT TH {
			vertical-align: top;
		}
</STYLE>

<STYLE> /* Will be moved to css files once finalized */

TABLE.pretty {
	border-collapse: collapse;
}
	TABLE.pretty TH, TABLE.pretty TD {
		border: thin solid #6A50A7; /* Will be moved to dynamoThemeGenerator.php */
		padding: 0.25em 0.5em;
	}
	TABLE.pretty TH {
		background-color: #6A50A7; /* Will be moved to dynamoThemeGenerator.php */
		border-color: #FFF !important; /* Will be moved to dynamoThemeGenerator.php */
		color: #FFF; /* Will be moved to dynamoThemeGenerator.php */
	}
		TABLE.pretty TH:first-child {
			text-align: right;
		}
		TABLE.pretty TH:last-child {
			text-align: left;
		}
		TABLE.pretty THEAD TH {
			vertical-align: bottom;
		}
		TABLE.pretty TFOOT TH {
			vertical-align: top;
		}
	
@media all and (max-width:40em) {
	#SEARCH_PAGE_SEARCH {
		margin: 0;
	}
		#SEARCH_BAR_BUTTON {
			display: none;
		}
		#SEARCH_BAR_BUTTON_TINY {
			display: inline-block;
		}
}
</STYLE>

<!--SCRIPT>
function fixHist(searchtitle)
{
	window.history.pushState({search : "<?PHP echo htmlentities($search); ?>"}, searchtitle, window.location);
	document.title = searchtitle;
}
</SCRIPT-->
<SCRIPT SRC="/_js/convenience.js"></SCRIPT>
</HEAD>



<?PHP
buildBodyTagWithAttributes(); // <BODY ...>
buildHeader(); // Don't pass variables to this; it will automatically detect login cookies
?>



<SECTION>
	<FORM ID="SEARCH_PAGE_SEARCH" ACTION="/search/searchFrame.php" TARGET="SEARCH_IFRAME" METHOD="get">
		<INPUT ID="SEARCH_BAR_LARGE" NAME="search" TYPE="search" AUTOCOMPLETE="on" PLACEHOLDER="Search"
		<?PHP if($search) echo 'VALUE="' . htmlspecialchars($search) . '"'; ?>/><INPUT ID="SEARCH_BAR_BUTTON" TYPE="submit"
		VALUE="Search"/><INPUT ID="SEARCH_BAR_BUTTON_TINY" TYPE="submit" VALUE="?"/><!-- It's critical to the layout that no whitepace exists between these inputs -->
	</FORM>
	<SECTION ID="ADVANCED_SEARCH">
		<A HREF="#ADVANCED_SEARCH_FORM"><!--ONCLICK="$('#ADVANCED_SEARCH_FORM').toggleClass('hidden')"-->Advanced Search (Mockup)<!--SPAN CLASS="warning hideIfJavascript"> (Requires Javascript)</SPAN--></A>
		<!--SCRIPT>
			hideAllJavascriptWarnings();
			function iframeLoaded() {
				fixHist(this.document.title);
				var SEARCH_IFRAME = document.getElementById('SEARCH_IFRAME');
				if(SEARCH_IFRAME) {
					// here you can meke the height, I delete it first, then I make it again
					SEARCH_IFRAME.height = "";
					SEARCH_IFRAME.height = SEARCH_IFRAME.contentWindow.document.body.scrollHeight + "px";
				}
			}
		</SCRIPT-->
	</SECTION>
	<FORM ID="ADVANCED_SEARCH_FORM" CLASS="expandWhenTarget">
		<A HREF="#" CLASS="close button">&times;</A>
		<TABLE CLASS="pretty centered">
			<TBODY>
				<TR>
					<TH><LABEL FOR="ADV_GENERICS">Generic Terms:</LABEL></TH>
					<TD>
						<LABEL FOR="ADV_SCORE_NOT">not</LABEL>
						<INPUT TYPE="checkbox" ID="ADV_SCORE_NOT"/>
					</TD>
					<TD>
						<SELECT>
							<OPTION VALUE="NO_ORDER">Not exactly in this order</OPTION>
							<OPTION VALUE="IN_ORDER">Exactly in this order</OPTION>
						</SELECT>
						<INPUT TYPE="text" ID="ADV_GENERIC" NAME="ADV_SCORE"/>
					</TD>
					<TD>
						<INPUT TYPE="button" VALUE="+" TITLE="Add this to the search"/>
					</TD>
				</TR>
				<TR>
					<TH><LABEL FOR="ADV_SCORE">Score:</LABEL></TH>
					<TD>
						<LABEL FOR="ADV_SCORE_NOT">not</LABEL>
						<INPUT TYPE="checkbox" ID="ADV_SCORE_NOT"/>
					</TD>
					<TD>
						<SELECT>
							<OPTION VALUE=":>=">Greater than or equal to</OPTION>
							<OPTION VALUE=":>">Greater than</OPTION>
							<OPTION VALUE=":">Exactly</OPTION>
							<OPTION VALUE=":<">Less than</OPTION>
							<OPTION VALUE=":<=">Less than or equal to</OPTION>
						</SELECT>
						<INPUT TYPE="number" ID="ADV_SCORE" NAME="ADV_SCORE"/>
					</TD>
					<TD>
						<INPUT TYPE="button" VALUE="+" TITLE="Add this to the search"/>
					</TD>
				</TR>
				
				<TR>
					<TH><LABEL FOR="ADV_TOPIC">Topic:</LABEL></TH>
					<TD>
						<LABEL FOR="ADV_TOPIC_NOT">not</LABEL>
						<INPUT TYPE="checkbox" ID="ADV_TOPIC_NOT"/>
					</TD>
					<TD>
						<SELECT ID="ADV_TOPIC" NAME="ADV_TOPIC">
							<OPTION VALUE="">This is gonna have to be populated with PHP</OPTION>
						</SELECT>
					</TD>
					<TD>
						<INPUT TYPE="button" VALUE="+" TITLE="Add this to the search"/>
					</TD>
				</TR>
				
				<TR>
					<TH><LABEL FOR="ADV_TOPIC">Sort by:</LABEL></TH>
					<TD>
						<LABEL FOR="SORT_REVERSE">reverse</LABEL>
						<INPUT TYPE="checkbox" ID="SORT_REVERSE"/>
					</TD>
					<TD>
						<SELECT ID="ADV_TOPIC" NAME="ADV_TOPIC">
							<OPTION VALUE="score">Score</OPTION>
							<OPTION VALUE="topic">Topic</OPTION>
							<OPTION VALUE="date">Post date</OPTION>
						</SELECT>
					</TD>
					<TD>
						<INPUT TYPE="button" VALUE="+" TITLE="Add this to the search"/>
					</TD>
				</TR>
			</TBODY>
		</TABLE>
	</FORM>
	<!--IFRAME SRC="searchFrame.php?search=<?PHP echo htmlspecialchars($search); ?>" SEAMLESS="seamless" BORDER="0"
	ID="SEARCH_IFRAME" ONLOAD="iframeLoaded();">
		Sorry, we require you use a browser that supports <CODE>iframe</CODE>s to search for <CODE><?PHP echo $search; ?></CODE>
	</IFRAME-->
	
	<SECTION ID="SEARCH_RESULTS">
		<?PHP
		if ($search)
		{
			echo "
		<TABLE CLASS=\"pretty\">
			<TBODY>";
			foreach($parsedSearch as $term)
			{
				if ($term instanceof Topic)
					echo "
				<TR><TH>Topic</TH> <TD><CODE>" . $term . "</CODE></TD></TR>";
				else if ($term instanceof Score)
					echo "
				<TR><TH>Score</TH> <TD><CODE>" . $term . "</CODE></TD></TR>";
				else if ($term instanceof SortTerm)
					echo "
				<TR><TH>Sort</TH>  <TD><CODE>" . $term . "</CODE></TD></TR>";
				else
					echo "
				<TR><TH>Generic term</TH> <TD>" . $term . "</TD></TR>";
			}
			echo "
			</TBODY>
		</TABLE>
	";
			searchFor($parsedSearch, 0, 10);
		}
		else
		{
			echo "<!--LABEL FOR=\"SEARCH_BAR_LARGE\">Type your search into the above search bar to perform a search!</LABEL-->";
		}
		?>
	</SECTION>
</SECTION>



<?PHP
buildFooter();
?>
</BODY>
</HTML>
