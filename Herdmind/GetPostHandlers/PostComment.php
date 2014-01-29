<?php
//This page is the first version of making a post.
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";        // Start session and determine subdomain
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php";      // Also includes config.php (must be done first) and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilderIndex.php"; // Builds body content for index
include $_SERVER['DOCUMENT_ROOT']."/_incl/RetreiveData.php";   // Any function that returns XML
include $_SERVER['DOCUMENT_ROOT']."/_incl/convenience.php";


global $db_connection;
	
//$testQuery = "INSERT INTO `citrus_BETABASE`.`Dummy`(`two`) VALUES ('Im in');";
//$result = mysqli_query($db_connection, $testQuery) or die('Query failed: ' . mysqli_error($db_connection));

echo "Getting information...";
$comment = mysqli_real_escape_string($db_connection, htmlentities($_POST['comment']));
$comment = str_replace("'","&#39;",str_replace('"',"&#34;",$comment));


/* TODO: MAKE THIS BE BY A POST METHOD VIA AJAX */
$id = mysqli_real_escape_string($db_connection, htmlentities($_POST['id']));
$id = str_replace("'","&#39;",str_replace('"',"&#34;",$id));

$pagetype = mysqli_real_escape_string($db_connection, htmlentities($_POST['topictype']));
$pagetype = str_replace("'","&#39;",str_replace('"',"&#34;",$pagetype));


echo " ...DONE<br/>";

echo "Filling arrays...";

$msgOptions = array(); 
$msgOptions[0] = $comment;
$msgOptions[1] = $id;
$msgOptions[2] = $pagetype;

$ip = mysqli_real_escape_string($db_connection, htmlentities($_SERVER['REMOTE_ADDR']));
$ip = str_replace("'","&#39;",str_replace('"',"&#34;",$id));

/*
Array Elements of $msgOptions
Key 				Optional 	Expected type 		Description
body 				no 			Escaped String 		The message itself
id	 				no 								the id of what's being commented on
pagetype 				no 						 		fanfact, fanwork, profile - what kind of page the comment appears on
*/

echo " ...DONE<br/>";

echo " Posting...";


$CommentingQuery = "INSERT INTO `CommunityPosts` (
`id_topic` ,
`id_topic_type` ,
`poster_time` ,
`id_member` ,
`id_msg_modified` ,
`subject` ,
`poster_name` ,
`poster_email` ,
`poster_ip` ,
`smileys_enabled` ,
`modified_time` ,
`modified_name` ,
`body` ,
`icon` ,
`approved`
)
VALUES (
'".$msgOptions[1]."', '".$msgOptions[2]."', NOW(), '0', '0', '', 'Name', 'Email', '$ip', '1', '0', '', '".$msgOptions[0]."', 'xx', '1'
);";

	
	$result = mysqli_query($db_connection, $CommentingQuery) or die('Query failed: ' . mysqli_error($db_connection));

echo " ...DONE<br/>";

echo (isset($result) ? "Success! Now hit back and then hit refresh." : "Failed.");

?>