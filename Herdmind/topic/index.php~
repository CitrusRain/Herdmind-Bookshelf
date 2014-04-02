<!DOCTYPE HTML>
<!--
A description of a Herdmind topic

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
include $_SERVER['DOCUMENT_ROOT']."/_incl/CookieTricks.php";   // We need to use cookie tricks on this page - import it.
//require_once $_SERVER['DOCUMENT_ROOT']."/_incl/classes.php";        // Pull in the classes, for Topics and Names

$page = isset($_GET["page"]) && is_numeric($_GET["page"]) ? max($_GET["page"], 0) : 0;
$factsPerPage = isset($_GET["limit"]) && is_numeric($_GET["limit"]) ? $_GET["limit"] : 5;




//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////// RAW XML DATA TEST - Topic info /////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////




//$xmlstring = GetTopicInfo($db_connection, $pageid, $userid);
$xmlstring = GetTopicInfo($db_connection
					, isset($_GET["t"]) && is_numeric($_GET["t"]) ? $_GET["t"] : 1
					, $userid);

$xml = new SimpleXMLElement($xmlstring);

//Loop through the xml and get the names.
  $stack = array();
foreach($xml->children() as $child)
  {
	if($child->getName() == "names")
	{
		foreach($child->children() as $name)
		  {
			if($name->getName() == "name")
			{
				array_push($stack, new Name($name->namecontents, $name->namescore));
			}
		  }
	}
}


//Loop through each xml element and print it.
  $stack = array();
foreach($xml->children() as $child)
  {
  	
	if($child->getName() == "names")
	{
		
		foreach($child->children() as $name)
		  {
			if($name->getName() == "name")
			{
				array_push($stack, new Name($name->namecontents, $name->namescore));
			}
		  }
	}
  }


//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////


$topic = new Topic(
	  isset($_GET["t"]) && is_numeric($_GET["t"]) ? $_GET["t"] : 1
	, $stack
	, $xml->type
	, $xml->reality
	, $xml->canonwith->branchname
	, $xml->description
	, $xml->picture
);



if(isset($_GET["t"])) SetRecentTopics($_GET["t"]);

$numFacts = count($topic->getFacts());
$pages = $numFacts / $factsPerPage;
?>
<HTML>
<HEAD>
<?php
if(empty($topic->index))
	buildDefaultHeadContent("Topic Viewer", "A listing of Herdmind topics", array("Descriptive", "Keywords"));
else
	buildDefaultHeadContent("Topic $topic->index", "Complete data about Herdmind Topic $topic->index", array("Descriptive", "Keywords"));
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


<SECTION ID="KYLI_META" STYLE="border:thin dashed lightgray;">
	<BUTTON ONCLICK="document.getElementById('KYLI_META').remove()">Hide developer's notes</BUTTON>
	<P>This <STRONG>mockup</STRONG> is Kyli's proposal for a new Herdmind topic page. It is currently <STRONG>not</STRONG> complete. [Requires name voting and bookmarks]</P>
	<P>This page was done with a new experimental approach, using minimal inline PHP logic interlaced with HTML code, rather than echoing out dynamic HTML code. This is an attempt to make the page load faster.</P>
	
	<H2>Testing</H2>
	<H3>URL Parameters:</H3>
	<UL>
		<LI><B><CODE>t</CODE></B>
			<UL>
				<LI><B>[OMISSION]</B>         &ndash; "Select a topic" page</LI>
				<LI><B>[valid number]</B>     &ndash; The fanfact page</LI>
				<LI><B>[OTHER]</B>            &ndash; "Topic <CODE>t</CODE> is not in our database" page</LI>
			</UL>
		</LI>
		<LI><B><CODE>page</CODE></B>
			<UL>
				<LI><B>[OMISSION]</B>         &ndash; First page of fanfacts</LI>
				<LI><B>[valid number]</B>     &ndash; The <CODE>page</CODE><SUP>th</SUP>given page of fanfacts</LI>
				<LI><B>[OTHER]</B>            &ndash; The first page of fanfacts</LI>
			</UL>
		</LI>
		<LI><B><CODE>limit</CODE></B>
			<UL>
				<LI><B>[OMISSION]</B>          &ndash; 5 fanfacts per page</LI>
				<LI><B>[valid number]</B>      &ndash; <CODE>limit</CODE> fanfacts per page</LI>
				<LI><B>[OTHER]</B>             &ndash; 5 fanfacts per page</LI>
			</UL>
		</LI>
	</UL>
</SECTION>




<?php
if (isset($_GET['t']))
{//BEGIN Individual topic page
?>
<SECTION>
	<H1>Herdmind Topic <VAR CLASS="topicNum"><?php echo $topic->index; ?></VAR></H1>
	
	<FIGURE CLASS="topic cardIn">
		<IMG SRC="http://pony.herdmind.net/<? echo $topic->picture; ?>" ALT="<?php $textName = $topic->getPrimaryName()->getText(); echo $textName; ?>"/>
		<FIGCAPTION>
			<DL>
				<DT CLASS="major noTerm">Name</DT>
					<DD><?php echo $textName; ?> <SMALL CLASS="block smallFont">(by <?php echo $topic->getPrimaryName()->votes; ?> votes)</SMALL></DD>
				<?php
					$alts = $topic->getAlternateNames();
					if ($alts)
					{
						?><DT>Alternate names</DT>
					<?php
						foreach($alts as $name)
						{
							?><DD><?php echo $name->text; ?> <SMALL>(<?php echo $name->votes; ?> votes)</SMALL></DD><?php
						}
					}
				?>
				<DT>Description</DT>
					<DD><P><?php
						echo str_replace("
", "</P>
<P>", $topic->description);
						
						?></P></DD>
				<DT>Type</DT>
					<DD><?php echo $topic->type; ?></DD>
				<DT>Reality</DT>
					<DD><?php echo $topic->reality; ?></DD>
				<DT>Canon</DT>
					<DD><?php echo $topic->canon; ?></DD>
			</DL>
		</FIGCAPTION>
		<!--DIV><!-- will probably put something here eventually -></DIV-->
	</FIGURE>
</SECTION>

<SECTION ID="FACTS" STYLE="">
<?php
// This is here to ensure it's initialized no matter how facts are arranged
$facts = $topic->getFacts();
$offset = $page * $factsPerPage;
?>
	<NAV CLASS="centered pages">
		<H3>
			<?php
			if ($numFacts)
			{
				?>Fact<?php
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
				?><A HREF="/topic?t=<?php
				echo $topic->index;
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
					?><A HREF="/topic?t=<?php
					echo $topic->index;
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
				?><A HREF="/topic?t=<?php echo $topic->index; ?>&page=<?php echo $page + 1; if(isset($_GET["limit"])) echo "&limit=" . $_GET["limit"]; ?>#FACTS"><?php
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
}//END Individual topic page
else
{//BEGIN Topic list page


//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////


$branchid = '1';
/*
Some branchid values
1 MLP:FIM
9 Doctor Who
12 Equestria Girls
*/

$xmlstring = GetTopicPages($db_connection, $branchid, $userid);

			

/*
//Loop through the xml and get the data.
  $stack = array();
foreach($xml->children() as $child)
  {
	if($child->getName() == "names")
	{
		foreach($child->children() as $name)
		  {
			if($name->getName() == "name")
			{
				array_push($stack, new Name($name->namecontents, $name->namescore));
			}
		  }
	}
}

echo '<section id="RAW_XML_TEST" style="border:thin dashed lightgray;">
	<BUTTON ONCLICK="document.getElementById(\'RAW_XML_TEST\').remove()">Hide raw XML output</BUTTON><br/>';

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
  
echo '</section>';

*/

//////////////////////////////////////////////////////////////////////////////////////////



?>
<SPAN CLASS="devalert">List of topics to go here</SPAN>
<SECTION CLASS="autoCol" ID="TOPICS">
	<H1>Herdmind Topics</H1>
	<span class="devalert">[needs to be fandom sensitive]</span>
	<SECTION>
		<H2>Everything</H2>
			<?php echo buildTopicLinkListFromXML($xmlstring);?>
	</SECTION>
	<SECTION>
		<H2>Characters</H2>
	</SECTION>
	<SECTION>
		<H2>Places</H2>
	</SECTION>
</SECTION>
<?php
}//END Topic list page
?>



<?php
buildFooter();
?>
</BODY>
</HTML>
