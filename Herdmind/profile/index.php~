<!DOCTYPE HTML>
<!--
A user profile page

This page is copyright Herdmind.net ©2013
-->
<?php
/*

	A NOTE TO ANYONE READING THE PHP: I'm trying a new way of doing it, hoping that putting small PHP calls in the HTML will lead to faster processing than multiple echoes
		- Kyli

*/


include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php"; // Also includes config.php and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT']."/_incl/RetreiveData.php";   // File that returns data in XML format
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";   // Start session and determine subdomain - do this second

$user = isset($_GET["user"]) && is_numeric($_GET["user"]) ? max($_GET["user"], 0) : 0;

?>
<HTML>
<HEAD>
<?php
buildDefaultHeadContent("A Profile", "", array("Descriptive", "Keywords"));
?>

<STYLE>
DT {
	font-weight: bold;
}
	DT.major,
	DT.major+DD {
		font-size: 2em;
		text-align: center;
		text-indent: 0;
	}
	DT.inline {
		float: left;
	}
	DT.colon::after {
		content: ":";
		padding-right: 0.5em;
	}
	DT.noTerm {
		display: none;
	}
	DD {
		font-weight: normal;
		margin: 0;
		padding: 0;
		text-indent: 2em;
	}

FIGURE.topic {
	border-radius: 0.5em;
	display: table;
	margin: 0;
	width: 100%;
}
	FIGURE.topic>* {
		display: table;
		vertical-align: top;
		}@media all and (max-width: 40em) { FIGURE.topic>* {
			display: block;
			margin: 0.5em;
		}
	}
	FIGURE.topic>IMG {
		border: 0.1em solid #FFF;
		border-radius: 0.5em;
		background: rgba(255,255,255, 0.5);
		float: left;
		margin: 0 1em 0 0;
		width: 15%;
		min-width: 1in;
		}@media all and (max-width: 40em) { FIGURE.topic>IMG {
			float: none;
			margin: auto;
			max-width: 100%;
			width: 30em;
		}
	}
/*	FIGURE.topic>*:last-child {
		clear: both;
	}*/
#FACTS {
	margin-top:0.5em;
}
#FACTS:target {
	background: transparent;
	color:inherit;
}
</STYLE>
</HEAD>



<?php
buildBodyTagWithAttributes(); // <BODY ...>
buildHeader(); // Don't pass variables to this; it will automatically detect login cookies
?>

Todo:
<br/>
>get profile picture, username, and other details

<?php


//Determine what profile to load
global $userid;
$ProfileNum = $userid;
if(isset($_GET["id"])) 
{	
	if ($_GET["id"] === 'Me')
	{
		$ProfileNum = $userid;
	}
	else
	{
		$ProfileNum = $_GET["id"];
	}
}
if(isset($ProfileNum) && !(isset($_GET["id"])))
{
	echo "Not logged in, but trying to view own profile.";
}

$xmlstring = GetProfile($db_connection
					, $ProfileNum
					, $userid);

$profilexml = new SimpleXMLElement($xmlstring);



echo '<section id="RAW_XML_TEST" style="border:thin dashed lightgray;">
	<BUTTON ONCLICK="document.getElementById(\'RAW_XML_TEST\').remove()">Hide raw XML output</BUTTON><br/>';

echo $profilexml->getName() . "<br/>";

//Loop through each xml element and print it.
  $stack = array();
foreach($profilexml->children() as $child)
  {
  echo "-".$child->getName() . ": " . $child . "<br/>";
	
		foreach($child->children() as $child2)
		  {
		  echo "--".$child2->getName() . ": " . $child2 . "<br/>";
		}
  }
  
echo '</section>';


?>


<SECTION id='comments'>
<h3>Your Starred Items</h3>
<?php

$query = "SELECT st.UserID, st.DateSaved, st.LastViewed, st.SubmissionID, 
				st.CommunityPostID, st.IsSubscribed, st.IsStarred, sd.SubmissionType, 
				sd.SubmissionID as 'FactID'
				FROM StarList AS st
				JOIN SubmissionData AS sd ON st.SubmissionID = sd.ID
				WHERE st.UserID = '$ProfileNum' and st.IsStarred = '1'
				and sd.SubmissionType = 'Fact'";
				
$QueryResults = mysqli_query($db_connection, $query);
$count = 0;
$factidlist = array();
while ($line = mysqli_fetch_array($QueryResults, MYSQL_ASSOC)) {

$factidlist[$count] = $line['FactID'];
$count++;	
	
}

	 	$factxml = new SimpleXMLElement(GetFanfactsByIDList($factidlist));

		//Loop through each xml element and print it.
	 	$listing = array();  
	 	$size = 0;
		foreach($factxml->children() as $child)
		{
			$listing[$size++] = buildFactXML($child, false, true, "cardIn");
		}
	
		$output = "";
		for($i = 0, $limit = count($listing); $i < $limit; $i++)
			$output = $output.$listing[$i];		

	echo TitleFiller($output, $db_connection);
?>
</SECTION>


<SECTION id='comments'>
<h3>Personal Thread</h3>
<?php
/*

Get and Print the comments

*/
//echo $user['member_name'];
$comments = GetComments($ProfileNum, "profile");
echo buildComments($comments, $ProfileNum, "profile");

/*
Create a form to submit new comment
*/
echo CommentBox($ProfileNum, "profile");
?>
</SECTION>


<SECTION ID="FACTS" STYLE="">
<?php
//$xml = GetSubmissionsByMemberID($_GET["id"]);

$userhistory = new Member(
	  isset($_GET["id"]) && is_numeric($_GET["id"]) ? $_GET["id"] : 1
	, "username"
	, "xml->type"
	, "xml->bio"
	, "xml->banner"
);

// This is here to ensure it's initialized no matter how facts are arranged
$facts = $userhistory->getSubmittedFacts();
$factsPerPage = 10;

$page = (isset($_GET["p"])) ? mysqli_real_escape_string($db_connection, $_GET["p"]) : 0;
$offset = $page * $factsPerPage;
$numFacts = count($facts);
$pages = $numFacts / $factsPerPage;

?>
	<NAV CLASS="centered pages">
		<H3>
			<?php
			if ($numFacts)
			{
				?>Submitted Fact<?php
				if($factsPerPage > 1)
				{
					?>s<?php
				}
				?> <?php
				echo ($offset) + 1;
				if($factsPerPage > 1)
				{
					?>&ndash;<?php
					echo min(($offset) + $factsPerPage, $numFacts);
				}
				?> of <?php
				echo $numFacts;
			}
			else
			{
				?>There are no facts about <?php echo $topic->getPrimaryName();
			}
			?>
		</H3><?php
		if ($factsPerPage < $numFacts) // BEGIN Build Navigation Controls
		{
		?>

		<LABEL <?php
			if ($page > 0)
			{
				?>FOR="RB_PAGE<?php echo $page - 1; ?>"<?php
			}
			else
			{
				?>DISABLED="disabled"<?php
			}
		?>><?php
			if ($page > 0)
			{
				?><A HREF="/profile?fandom=<?php 
				echo $fandom[0];?>&id=<?php
				echo $ProfileNum;
				?>&amp;page=<?php
				echo $page - 1;
				if(isset($_GET["limit"]))
				{
					?>&amp;limit=<?php
					echo $_GET["limit"];
				}
				?>#FACTS"><?php
			}
			?>&laquo; Prev<?php
			if ($page > 0)
			{
				?></A><?php
			}
		?></LABEL>

		<?php
		
			for($i=0; $i < $pages; $i++)
			{
				echo "\r\n\t\t";
				if ($i != $page)
				{
					?><A HREF="/profile?fandom=<?php 
					echo $fandom[0];?>&id=<?php
					echo $ProfileNum;
					?>&amp;page=<?php
					echo $i;
					if(isset($_GET["limit"]))
					{
						?>&amp;limit=<?php
						echo $_GET["limit"];
					}
					?>#FACTS" CLASS="cursorDefault"><?php
				}
				?><INPUT
			TYPE="radio"
			NAME="page"
			VALUE="<?php echo $i; ?>"
			ID="RB_PAGE<?php echo $i; ?>"
			<?php
				if ($i == $page)
				{
					?>CHECKED="checked"
			DISABLED="disabled"
			<?php
				}
			?>/><?php
				if ($i != $page)
				{
					?></A><?php
				}
			}
		?>

		<LABEL <?php
				if ($page < $pages - 1)
				{
					?>FOR="RB_PAGE<?php echo $page + 1; ?>"<?php
				}
				else
				{
					?>DISABLED="disabled"<?php
				}
		?>><?php
			if ($page < $pages - 1)
			{
				?><A HREF="/profile?fandom=<?php echo $fandom[0];?>&id=<?php echo $ProfileNum; ?>&page=<?php echo $page + 1; if(isset($_GET["limit"])) echo "&limit=" . $_GET["limit"]; ?>#FACTS"><?php
			}
			?>Next &raquo;<?php
			if ($page < $pages - 1)
			{
				?></A><?php
			}
		?></LABEL><?php
		} // END Build Navigation Controls
		?>

	</NAV>
	
	
	
	<UL CLASS="fanfacts">
	<?php
	
		for($i = 0, $limit = min(count($facts) - $offset, $factsPerPage); $i < $limit; $i++)
			echo TitleFiller($facts[$i + $offset], $db_connection);
	?>
	</UL>
</SECTION>





<?php
buildFooter();
?>
</BODY>
</HTML>
