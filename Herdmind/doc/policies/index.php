<!DOCTYPE HTML>
<!--
Documentation policies for Herdmind

This page is copyright Herdmind.net ©2013
-->
<?PHP
include $_SERVER['DOCUMENT_ROOT'].'/_incl/startSession.php';        // Start session and determine subdomain - do this first to ensure contentBuilder knows the fandom
include $_SERVER['DOCUMENT_ROOT'].'/_incl/contentBuilder.php';      // Also includes config.php and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT'].'/_incl/contentBuilderIndex.php'; // Builds body content for index
include $_SERVER['DOCUMENT_ROOT'].'/_incl/classes2.php';   			// A bunch of classes used for data
include $_SERVER['DOCUMENT_ROOT'].'/_incl/RetreiveData.php';   		// Any function that returns XML
include $_SERVER['DOCUMENT_ROOT'].'/_incl/convenience.php';
?>
<HTML>
<HEAD>
<LINK REL="stylesheet" TYPE="text/css" HREF="//prog.BHStudios.org/husk/_css/husk.css" />
<?PHP
buildDefaultHeadContent(array('Policies', 'Documentation'), 'Coding policies of Herdmind', array('Documentation', 'Policies'));
?>
<STYLE TYPE="text/css">
.policies H2 {
	font-size: 2em;
	/*text-transform: capitalize;*/
}
</STYLE>
</HEAD>



<?PHP
buildBodyTagWithAttributes(); // <BODY ...>
buildHeader(); // Don't pass variables to this; it will automatically detect login cookies
?>



<SECTION>
	<H1>Herdmind Coding Policies</H1>
	<UL CLASS="plain centered spaced policies row">
<?PHP
function buildPolicy($title, $description, $icon = false)
{
	?>

		<LI CLASS="policy huge-3 large-4 small-6 tiny-12">
			<H2><?PHP echo ($icon ? "<I CLASS='fa fa-$icon'></I><BR/>" : '') .  $title; ?></H2>
			<P><?PHP echo $description; ?></P>
		</LI><?PHP
}



buildPolicy('Documenting Helps Everyone', '<STRONG>Whenever editing PHP</STRONG>, you <EM>must</EM> reflect your changes in the documentation comment above it. Every edit should be at least reflected in the <CODE>@version</CODE> section. Remember, <STRONG>You\'re reading documentation right now!</STRONG>', 'pencil-square-o');
buildPolicy('Don\'t Reinvent the Wheel', '<STRONG>Don\'t copy-paste code</STRONG> and rewrite it when simply calling it without changing it will do.', 'refresh');
?>
	</UL>
</SECTION>



<?PHP
buildFooter();
?>
</BODY>
</HTML>
