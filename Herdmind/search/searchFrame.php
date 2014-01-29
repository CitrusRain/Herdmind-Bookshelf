<!DOCTYPE HTML>
<!--
The search frame

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
BODY,
HTML,
*:root {
	margin: 0;
	padding: 0;
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

<SCRIPT>
window.top.history.pushState({search : "<?PHP echo str_replace("\"", "\\\"", $search); ?>"}, document.title, window.location.search);
window.top.document.title = document.title;
</SCRIPT>
<SCRIPT SRC="/_js/convenience.js"></SCRIPT>
</HEAD>



<BODY>
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
</BODY>
</HTML>