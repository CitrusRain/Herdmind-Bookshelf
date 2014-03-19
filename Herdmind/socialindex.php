<!DOCTYPE HTML>
<!--
A user profile page

This page is copyright Herdmind.net ©2013
-->
<?PHP

include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php"; // Also includes config.php and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT']."/_incl/RetreiveData.php";   // File that returns data in XML format
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";   // Start session and determine subdomain - do this second

$user = isset($_GET["user"]) && is_numeric($_GET["user"]) ? max($_GET["user"], 0) : 0;

?>
<HTML>
<HEAD>
<?PHP
buildDefaultHeadContent("Triple-type posting", "Trying a thing", array("Descriptive", "Keywords"));
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



<?PHP
buildBodyTagWithAttributes(); // <BODY ...>
buildHeader(); // Don't pass variables to this; it will automatically detect login cookies
?>

Todo:
<br/>
>get profile picture, username, and other details

<?PHP


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


<?PHP

//Print personal thread here.
 /*
$PersonalThread = GetThread($db_connection
					, $profilexml->personalthreadid
					, $userid);


echo '<section id="ForumThread" style="border:thin solid lightgray;">';

$pageEchoes = "";

foreach ($PersonalThread as $posts)
{
$pageEchoes = $pageEchoes."<b>".$posts->getPostSubject()."</b><br/>";
$pageEchoes = $pageEchoes.$posts->getPostBody();
$pageEchoes = $pageEchoes."<hr/>";
}

$pageEchoes = formatReference($pageEchoes,$user, $db_connection);
//echo TitleFiller($pageEchoes, $db_connection);
echo TitleFiller($pageEchoes, $db_connection);

*/

/*
echo $xml->getName() . "<br/>";

//Loop through each xml element and print it.
  $stack = array();
foreach($xml->children() as $child)
  {
  echo "-".$child->getName() . ": " . $child . "<br/>";
	
		foreach($child->children() as $child2)
		  {
		  echo "--".$child2->getName() . ": " . $child2 . "<br/>";
		}
		echo"<hr/>";
  }
*/  
  
  
//echo '</section>';


?>



<SECTION id='comments'>
(revised backend to match other areas rather than being as forum based)
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
<?PHP
//$xml = GetSubmissionsByMemberID($_GET["id"]);

$userhistory = new Member(
	  isset($_GET["id"]) && is_numeric($_GET["id"]) ? $_GET["id"] : 1
	, "username"
	, "xml->type"
	, "xml->bio"
	, "xml->avatar"
	, "xml->banner"
);

// This is here to ensure it's initialized no matter how facts are arranged
$facts = $userhistory->getSubmittedFacts();
$offset = $page * $factsPerPage;
?>
	<NAV CLASS="centered pages">
		<H3>
			<?PHP
			if ($numFacts)
			{
				?>Fact<?PHP
				if($factsPerPage > 1)
				{
					?>s<?PHP
				}
				?> <?PHP
				echo ($offset) + 1;
				if($factsPerPage > 1)
				{
					?>&ndash;<?PHP
					echo min(($offset) + $factsPerPage, $numFacts);
				}
				?> of <?PHP
				echo $numFacts;
			}
			else
			{
				?>There are no facts about <?PHP echo $topic->getPrimaryName();
			}
			?>
		</H3><?PHP
		if ($factsPerPage < $numFacts) // BEGIN Build Navigation Controls
		{
		?>

		<LABEL <?PHP
			if ($page > 0)
			{
				?>FOR="RB_PAGE<?PHP echo $page - 1; ?>"<?PHP
			}
			else
			{
				?>DISABLED="disabled"<?PHP
			}
		?>><?PHP
			if ($page > 0)
			{
				?><A HREF="/topic?t=<?PHP
				echo $topic->index;
				?>&amp;page=<?PHP
				echo $page - 1;
				if(isset($_GET["limit"]))
				{
					?>&amp;limit=<?PHP
					echo $_GET["limit"];
				}
				?>#FACTS"><?PHP
			}
			?>&laquo; Prev<?PHP
			if ($page > 0)
			{
				?></A><?PHP
			}
		?></LABEL>

		<?PHP
		
			for($i=0; $i < $pages; $i++)
			{
				echo "\r\n\t\t";
				if ($i != $page)
				{
					?><A HREF="/topic?t=<?PHP
					echo $topic->index;
					?>&amp;page=<?PHP
					echo $i;
					if(isset($_GET["limit"]))
					{
						?>&amp;limit=<?PHP
						echo $_GET["limit"];
					}
					?>#FACTS" CLASS="cursorDefault"><?PHP
				}
				?><INPUT
			TYPE="radio"
			NAME="page"
			VALUE="<?PHP echo $i; ?>"
			ID="RB_PAGE<?PHP echo $i; ?>"
			<?PHP
				if ($i == $page)
				{
					?>CHECKED="checked"
			DISABLED="disabled"
			<?PHP
				}
			?>/><?PHP
				if ($i != $page)
				{
					?></A><?PHP
				}
			}
		?>

		<LABEL <?PHP
				if ($page < $pages - 1)
				{
					?>FOR="RB_PAGE<?PHP echo $page + 1; ?>"<?PHP
				}
				else
				{
					?>DISABLED="disabled"<?PHP
				}
		?>><?PHP
			if ($page < $pages - 1)
			{
				?><A HREF="/topic?t=<?PHP echo $topic->index; ?>&page=<?PHP echo $page + 1; if(isset($_GET["limit"])) echo "&limit=" . $_GET["limit"]; ?>#FACTS"><?PHP
			}
			?>Next &raquo;<?PHP
			if ($page < $pages - 1)
			{
				?></A><?PHP
			}
		?></LABEL><?PHP
		} // END Build Navigation Controls
		?>

	</NAV>
	
	
	
	<UL CLASS="fanfacts">
	<?PHP
		for($i = 0, $limit = min(count($facts) - $offset, $factsPerPage); $i < $limit; $i++)
			echo TitleFiller($facts[$i + $offset], $db_connection);
	?>
	</UL>
</SECTION>





<?PHP
buildFooter();
?>
</BODY>
</HTML>
