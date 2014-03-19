<!DOCTYPE HTML>
<!--
The page for general fanfacts

This page is copyright Herdmind.net ©2013
-->
<?php
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";        // Start session and determine subdomain
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php";      // Also includes config.php (must be done first) and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT']."/_incl/RetreiveData.php";   // Any function that returns XML
include $_SERVER['DOCUMENT_ROOT']."/_incl/convenience.php";
?>
<HTML>
<HEAD>
<script src="../_js/jquery.js"></script>
<?php
$factNum = $_GET["id"]; //Determine what fanfact to load

$WhatOpSubmitted = GetThreadByID($factNum); //Get the Original Post


//Initialize variables that get populated in that darn unnessicary loop
$factText = '';
$xml = '';


buildDefaultHeadContent("Thread $factNum", "$factText", array("$fandom","fanfact","headcanon","opinion"));


?>



</HEAD>


<?php
buildBodyTagWithAttributes(); // <BODY ...>
buildHeader(); // Don't pass variables to this; it will automatically detect login cookies
?>

<SECTION STYLE="font-size: larger;">
	<?php
		echo buildComments(array($WhatOpSubmitted));
	?>
</SECTION>

<SECTION id='comments'>
<?php
/*

Get and Print the comments

*/
$comments = GetComments($factNum, "threadcomment");
echo buildComments($comments, $factNum, "threadcomment");


/*
Create a form to submit new comment
*/
//echo CommentBox($factNum, "fanfact");
?>
</SECTION>

<SECTION>
Related topics:
<?php
//echo buildTopicLinkListFromXML($rawxml, "wrappingColumns");
?>
</SECTION>

<?php
buildFooter();
?>
</BODY>
</HTML>
