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
buildDefaultHeadContent("Muffin Test", "Testin the muffin", array("Random", "Slider", "Test"));
?>
<SCRIPT TYPE="text/javascript" SRC="http://BHStudios.org/_include/jquery.anythingslider.js">/*Anything lider*/</SCRIPT>
</HEAD>



<?PHP
buildBodyTagWithAttributes(); // <BODY ...>
buildHeader(); // Don't pass variables to this; it will automatically detect login cookies
?>



<SECTION>
	<UL ID="MUFFIN_SLIDER">
		<LI>Loading...</LI>
	</UL>
	
	<SCRIPT TYPE="text/javascript">
	$(function(){
		$('#MUFFIN_SLIDER').anythingSlider({                       // add any non-default options here
			theme                 : "herdmind"
			, autoPlay            : true
			, allowRapidChange    : true
			, delay               : 7000
			, expand              : true
			, hashTags            : false
			, infiniteSlides      : false
			, buildNavigation     : false
			, buildStartStop      : false
		});									 
	});
</script>

	</SCRIPT>
</SECTION>



<?PHP
buildFooter();
?>
</BODY>
</HTML>
