<?PHP
/* Dynamo Theme Generator
 * 
 * Generates Dynamo theme CSS by replacing any file that calls generateCustomColorCSS with a CSS file, usable in a <LINK> element
 * 
 * This file is made by Blue Husky Programming for Herdmind.net, and is copyrighted to both ©2013 CC-BY-SA
 */



function open()
{
	//header('Content-Description: File Transfer');               // Download when navigated to
	header("Content-type: text/css");                             // Identify as a CSS file
	header('Content-Transfer-Encoding: binary');                  // Transfer this file as binary
	header('Expires: 0');                                         // This file expires from cache immediately
	header('Cache-Control: max-age=' . 60*60*24);                 // Recommend one-day cache. This should help with calculation time
	header('Pragma: public');                                     // Everyone can see this
	// header('Content-Length: ' . filesize($this));              // The length of the file. Unneeded in CSS, as readers utilize EOF
	ob_clean();                                                   // Erase all existing data in the output buffer (only what we add after this will be in the file)
}
function seal()
{
	flush();
	exit;
}
	
/**
 * Generates a CSS file for the Dynamo visual style.
 * 
 * @param $mainColor    The main coloring for the general site layout. May be a string containing a valid CSS color or a Theme
 * @param $themeColor   The theme coloring for the general site layout. May be a string containing a valid CSS color or a Theme
 * @param $accentColors The coloring of the theme accents. May be a single or array of strings or Themes
 * @param $brandImage   The image to be placed in branding areas. Must be a string containing a valid CSS background image.
 * @param $aura         The colors of glow that will appear around certain objects (mainly inputs in focus). Must be a string
 *                      containing a valid CSS color.
 */
function generateCustomColorCSS($mainColor, $themeColor, $accentColors, $brandImage = null, $aura = null)
{
	open();
	$isTheme = $mainColor instanceof Theme;
	echo '@import url("visual_Dynamo.css");

HTML,
BODY {
	background-color: ' . ($isTheme ? $mainColor->bg : $mainColor) . ';
	/*background-size: cover;*/';
	if ($isTheme)
		echo '
	color: ' . $mainColor->fg . ';';
	echo '
}

.news>*{
	background-color: ';
	$match = array();
	if (preg_match('/^rgb\(\d{1,3},\d{1,3},\d{1,3}\)$/', ($isTheme ? $mainColor->bg : $mainColor), $match))
	{
		preg_match('/\d{1,3},\d{1,3},\d{1,3}/', $match[0], $match);
		echo "rgba($match[0], 0.5)";
	}
	elseif (preg_match('/^#(\d|A|B|C|D|E|F){6}$/i', ($isTheme ? $mainColor->bg : $mainColor), $match))
	{
		// echo "/*";
		// var_dump($match);
		preg_match_all('/(\d|A|B|C|D|E|F){2}/i', $match[0], $match);
		// var_dump($match);
		// echo "*/";
		$r = intval($match[0][0], 16);
		$g = intval($match[0][1], 16);
		$b = intval($match[0][2], 16);
		echo "rgba($r,$g,$b, 0.5)";
	}
	elseif (preg_match('/^#(\d|A|B|C|D|E|F){3}$/i', ($isTheme ? $mainColor->bg : $mainColor), $match))
	{
		// echo "/*";
		// var_dump($match);
		preg_match_all('/(\d|A|B|C|D|E|F)/i', $match[0], $match);
		// var_dump($match);
		// echo "*/";
		$r = intval($match[0][0], 16) * 17;// #RGB == #RRGGBB, so 0xR * 0x11 = 0xRR, so 0xR * 17 = 0xRR
		$g = intval($match[0][1], 16) * 17;
		$b = intval($match[0][2], 16) * 17;
		echo "rgba($r,$g,$b, 0.5)";
	}
	else
		echo ($isTheme ? $mainColor->bg : $mainColor);
	echo ';
}

';
	if ($isTheme && $mainColor->lf)
		echo '

:link {
	color: ' . $mainColor->lf . ';
}
:visited {
	color: ' . $mainColor->vf . ';
}';
	
	if ($aura)
		echo '

INPUT:focus {
	box-shadow: 0 0 0.4em ' . $aura . ';
}
:focus,
:active {
	outline-color: ' . $aura . ';
}';

	$isTheme = is_array($accentColors) ? $accentColors[0] instanceof Theme : $accentColors instanceof Theme;
	echo '
:target:not(.cssPopup):not(.cssPopupHolder):not(DIALOG) {
	background-color: ' . (
		is_array($accentColors) ? (
			$isTheme ? $accentColors[0]->bg : $accentColors[0]
		) : (
			$isTheme ? $accentColors->bg : $accentColors
		)
	) . ';';
	if ($isTheme)
		echo '
	color: ' . (is_array($accentColors) ? $accentColors[0]->fg : $accentColors->fg) . ';';
	if ($aura)
		echo '
	box-shadow: 0 0 0.2em ' . $aura . ';';
	echo '
}';/*

:link:active,
:visited:active,
:link:focus,
:visited:focus,
:link:hover,
:visited:hover {
	text-shadow: 0 0 0.25em ' . $aura . ';
}';*/
	
	if ($brandImage)
		echo '
.branded,
BODY>HEADER {
	background-image: ' . $brandImage . ';
	background-image:         linear-gradient(top, rgba(255,255,255, 0.1), rgba(0,0,0, 0.1)), ' . $brandImage . ';
	background-image:      -o-linear-gradient(top, rgba(255,255,255, 0.1), rgba(0,0,0, 0.1)), ' . $brandImage . ';
	background-image:     -ms-linear-gradient(top, rgba(255,255,255, 0.1), rgba(0,0,0, 0.1)), ' . $brandImage . ';
	background-image:    -moz-linear-gradient(top, rgba(255,255,255, 0.1), rgba(0,0,0, 0.1)), ' . $brandImage . ';
	background-image: -webkit-linear-gradient(top, rgba(255,255,255, 0.1), rgba(0,0,0, 0.1)), ' . $brandImage . ';';
	/*if ($aura)
		echo '
	text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.251), 0px 1px 0px rgba(255, 255, 255, 0.251), 0 0 0.5em ' . $aura . ';';*/
	echo '
}
';
	echo '
.themeBack,
BODY>HEADER,
FOOTER,
.portal LI :link,
.portal LI :visited,
.topic,/**/
.fanfact,
.informinglink,
#SIDEBAR,
DIALOG,
DIALOG:target,
:target DIALOG,
.cssPopup:target,
.cssPopupHolder:target .cssPopup {';
	if ($isTheme = $themeColor instanceof Theme)
		echo '
	background-color: ' . $themeColor->bg . ';
	color: ' . $themeColor->fg . ';';
	else
		echo '
	background-color: ' . $themeColor . ';
	color: inherit;';
	echo '
}
.popname .informinglink::after { /* special exception where a border makes up the background of an element */
	border-bottom-color: ' . ($isTheme ? $themeColor->bg : $themeColor) . ' !important;
}
.popname .informinglink::before {
	border-bottom-color: ' .
	($isTheme ?
		$themeColor->bg :
		(is_array($accentColors) ?
			($accentColors[0] instanceof Theme ?
				$accentColors[0]->bg :
				$accentColors[0]
			) :
			($accentColors instanceof Theme ?
				$accentColors->bg :
				$accentColors
			)
		)
	) . ' !important;
}
';
	if ($isTheme && $themeColor->lf)
		echo '
.themeBack :link,
FOOTER :link,
.portal LI :link,
.topic :link,/**/
.fanfact :link,
#SIDEBAR :link,
DIALOG :link {
	color: ' . $themeColor->lf . ';
}
.themeBack :visited,
FOOTER :visited,
.portal LI :visited,
.topic :visited,/**/
.fanfact :visited,
#SIDEBAR :visited
DIALOG :visited {
	color: ' . $themeColor->vf . ';
}
';
	echo '
.themeBorder/*,
.fanfact*/,
.popname .informinglink {
	border-color: ' .
	($isTheme ?
		$themeColor->bg :
		(is_array($accentColors) ?
			($accentColors[0] instanceof Theme ?
				$accentColors[0]->bg :
				$accentColors[0]
			) :
			($accentColors instanceof Theme ?
				$accentColors->bg :
				$accentColors
			)
		)
	) . ';
}';
	if (is_array($accentColors))
	{
		$len = count($accentColors);
		for($i = 1, $im1 = 0; $i <= $len; $im1 = $i, $i++)
		{
			echo "
                   .accentBack:nth-of-type($len" . "n+$i),
                        SELECT:nth-of-type($len" . "n+$i),
                 SELECT OPTION:nth-of-type($len" . "n+$i),
                        BUTTON:nth-of-type($len" . "n+$i),
          INPUT[type='button']:nth-of-type($len" . "n+$i), *:nth-of-type($len" . "n+$i) INPUT[type='button'],
          INPUT[type='submit']:nth-of-type($len" . "n+$i), *:nth-of-type($len" . "n+$i) INPUT[type='submit'],
           INPUT[type='reset']:nth-of-type($len" . "n+$i), *:nth-of-type($len" . "n+$i) INPUT[type='reset'],
INPUT[type='checkbox']:checked:nth-of-type($len" . "n+$i), *:nth-of-type($len" . "n+$i) INPUT[type='checkbox']:checked,
   INPUT[type='radio']:checked:nth-of-type($len" . "n+$i), *:nth-of-type($len" . "n+$i) INPUT[type='radio']:checked,
                       .button:nth-of-type($len" . "n+$i),
                   #SIDEBAR LI:nth-of-type($len" . "n+$i)>:link,
                   #SIDEBAR LI:nth-of-type($len" . "n+$i)>:visited {";
			 
			 if ($accentColors[$im1] instanceof Theme)
				echo'
	background-color: ' . $accentColors[$im1]->bg . ';
	color: '            . $accentColors[$im1]->fg . ';
}';
			 else
				echo '
	background-color: ' . $accentColors[$im1] . ';
	color: inherit;
}';
		}
		echo '
';
		for($i = 1, $im1 = 0; $i <= $len; $im1 = $i, $i++)
		{
			echo "
                                                      .accentBorder:nth-of-type($len" . "n+$i),
INPUT:not([type='button']):not([type='submit']):not([type='reset']):nth-of-type($len" . "n+$i),
                                                                  *:nth-of-type($len" . "n+$i) INPUT:not([type='button']):not([type='submit']):not([type='reset']),
                                            .popname .informinglink:nth-of-type($len" . "n+$i) {";
			 if ($accentColors[$im1] instanceof Theme)
				echo '
	border-color: ' . $accentColors[$im1]->bg . ';
}';
			else
				echo '
	border-color: ' . $accentColors[$im1] . ';
}';
		}
	}
	else
	{
		echo '
.accentBack,
SELECT,
SELECT OPTION,
BUTTON,
INPUT[type="button"],
INPUT[type="submit"],
INPUT[type="reset"],
.button,
#SIDEBAR LI>:link,
#SIDEBAR LI>:visited {';
		if ($accentColors instanceof Theme)
			echo '
	background-color: ' . $accentColors->bg . ';
	color: ' . $accentColors->fg . ';';
		else
			echo '
	background-color: ' . $accentColors . ';
	color: inherit;';
		echo '
}

.accentBorder,
INPUT:not([type="button"]):not([type="submit"]):not([type="reset"]),
.popname .informinglink {
	border-color:' . ($accentColors instanceof Theme ? $accentColors->bg : $accentColors) . ';';
		echo '
}';
	}
	
	seal();
}

class Theme
{
	function __construct($background, $foreground, $linkForeground = null, $visitedForeground = null)
	{
		$this->bg = $background;
		$this->fg = $foreground;
		$this->lf = $linkForeground;
		$this->vf = $visitedForeground ? $visitedForeground : $linkForeground;
	}
	
	function getBackground()        { return $this->bg; }
	function getForeground()        { return $this->fg; }
	function getLinkForeground()    { return $this->lf; }
	function getVisitedForeground() { return $this->vf; }
}
?>
