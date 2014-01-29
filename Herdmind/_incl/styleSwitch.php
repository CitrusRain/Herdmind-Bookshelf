<?PHP
/* 
 * A stylesheet switcher
 * 
 * @author Kyli Rouge
 * @since 2013-03-01
 */

$backupSheet;
$cookie = $_COOKIE["herdmindLastSetStyle"];
require $_SERVER['DOCUMENT_ROOT']."/_incl/classes.php";

/**
 * Builds the head content for the Herdmind style switcher
 * 
 * @param $backupStylesheet the base stylesheet. This must be guaranteed to exist, as it will be applied in case the user-selected style fails
 * 
 * @author Kyli Rouge
 * @since 2013-03-01
 * @version 1.2.0 (2013-03-13)
 */
function buildStyleSwitcherHeadContent($backupStylesheet)
{
	global $backupSheet, $cookie;
	$backupSheet = $backupStylesheet;
	echo '

<!-- BEGIN Style-Switcher Stylesheets -->
<LINK REL="stylesheet" ID="_switchSheetBackup" HREF="' . $backupSheet . '"/>
<LINK REL="stylesheet" ID="_switchSheet"       HREF="' . (isset($cookie) ? $cookie : $backupSheet) . '"/>
<!-- END Style-Switcher Stylesheets -->

<!-- BEGIN Style-Switcher Scripts -->
<SCRIPT TYPE="text/javascript" SRC="/_js/styleSwitch2.js"> /* Style Switching Scripts */ </SCRIPT>
<!-- END Style-Switcher Scripts -->

';
}

/**
 * Builds the GUI for switching stylesheets.
 * 
 * Example:
		buildStyleSwitcherGUI(array(
		                        "Ponies"
		                      , 	new Stylesheet("/_css/visual_ProposalOrangejack.css"   , "Orangejack"   )
		                      , 	new Stylesheet("/_css/visual_ProposalPinkie.css"       , "Pinkie"       )
		                      , 	new Stylesheet("/_css/visual_ProposalRainblue.css"     , "Rainblue"     )
		                      , 	new Stylesheet("/_css/visual_ProposalRarewhity.css"    , "Rarewhity"    )
		                      , 	new Stylesheet("/_css/visual_ProposalTwirple.css"      , "Twirple"      )
		                      , 	new Stylesheet("/_css/visual_ProposalYellowshy.css"    , "Yellowshy"    )
		                      , "Vivid"
		                      , 	new Stylesheet("/_css/visual_Proposal_DigitalBlue.css" , "Digital Blue" )
		                      , 	new Stylesheet("/_css/visual_Proposal_SillyMagenta.css", "Silly Magenta")
		                      ));
 * 
 * @param $altSheetsAndNames The alternate stylesheets. This must be an array of Stylesheet objects andor strings. Stylesheets
 * 	                         represent the location of the sheet and its name, whereas strings represent a new group of
 *                           Stylesheets.
 * 
 * @author Kyli Rouge
 * @since 2013-03-01
 * @version 1.2.0 (2013-03-20)
 */
function buildStyleSwitcherGUI($altSheetsAndNames)
{
	global $cookie, $backupSheet;
	$firstGroup = true;
	echo '
		<SELECT ONCHANGE="return switchStyles(this);">
			<OPTION VALUE="' . $backupSheet . '">Select a style!</OPTION>
				';
	foreach ($altSheetsAndNames as $sheet)
		if ($sheet instanceof Stylesheet) // If we're given a Stylesheet, add it to the list
			echo '<OPTION VALUE="' . $sheet->url . '"' . ($cookie == $sheet->url ? ' SELECTED' : '') . ' CLASS="' .
				$sheet->name . '">' . $sheet->name . '</OPTION>
				';
		else // If we're given anything else, assume it's the name of a new group of Stylesheet objects
		{
			if ($firstGroup) // If there aren't previous groups, make note that the first has occurred and don't end a group.
				$firstGroup = false;
			else            // End the previous group, since we now know this isn't the first.
				echo '</OPTGROUP>
			';
			echo '<OPTGROUP LABEL="' . $sheet . '">
			';
		}
	//else
	//	echo '<OPTGROUP LABEL="The programmer messed up."></OPTGROUP><OPTGROUP LABEL="It\'s their fault, not yours."></OPTGROUP>';
	if (!$firstGroup) // If the first group had been started at some point, we know there is exactly one unclosed group, even if it isn't necessarily the first.
		echo '</OPTGROUP>';
	echo '</SELECT>';
}
?>