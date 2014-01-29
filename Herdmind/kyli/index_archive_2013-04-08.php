<!DOCTYPE HTML>
<HTML>
<HEAD>
<!--
This is a mockup of the Herdmind front page as envisioned by Kyli Rouge|Supuhstar|Digit Shine
This mockup is copyright Herdmind.net ©2013
-->
<?PHP
include $_SERVER['DOCUMENT_ROOT']."/kyli/_incl/contentBuilder.php";           // Also includes config.php (must be done first) and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT']."/kyli/_incl/startSession.php";        // Start session and determine subdomain - do this second
include $_SERVER['DOCUMENT_ROOT']."/kyli/_incl/contentBuilderIndex.php"; // Builds body content for index
include $_SERVER['DOCUMENT_ROOT']."/_incl/convenience.php";
?>

<?PHP
buildDefaultHeadContent(); // Empty, because the generic content represents the homepage well
?>
</HEAD>



<?PHP
buildBodyTagWithAttributes(); // <BODY ...>
buildHeader($_GET["login"], $_GET["mod"]); // Allows for testing of different layouts
?>



<?PHP
	//$fandom = $_GET["fandom"];//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! REMOVE BEFORE FINAL IMPLEMENTATION
	echo "<!-- $fandom -->";
		echo "
<HGROUP>
	<H1>";
		if (!$fandom) // If this is not a homepage for a registered fandom
		{
			if ($parsedFandom) // $parsedFandom is set to null only if we are on the main portal page (no domain)
				echo "We don't cover the " . $parsedFandom . " fandom";
			else
				echo "Welcome!";
		}
		else
			echo $parsedFandom;
		echo "</H1>
</HGROUP>";
	
	
	if(!$fandom or $fandom == '')
	{
		echo "
<P CLASS=\"focus\">Herdmind is a non-profit, fan-made database of non-canon <Q>fanfacts</Q>, which can be submitted and voted upon by any user.</P>
<SECTION>";
		$fandomPortals = // TODO: Change to database retrieval
			array(
				  new PortalItem("Doctor Who",
				                 "?fandom=tardis", //  "//tardis.herdmind.net"                 USE THIS IN FINAL IMPLEMENTATION
				                 "http://herdmind.net/CSS/herdmind/SubsiteButtons/button_tardis.png")
				, new PortalItem("My Little Pony: Friendship is Magic",
				                 "?fandom=pony", // "//pony.herdmind.net"                     USE THIS IN FINAL IMPLEMENTATION
				                 "http://herdmind.net/CSS/herdmind/SubsiteButtons/button_pony.png")
				, new PortalItem("Powerpuff Girls",
				                 "?fandom=ppg" //, "//ppg.herdmind.net"                       USE THIS IN FINAL IMPLEMENTATION
				                 /*"http://herdmind.net/CSS/herdmind/SubsiteButtons/button_ppg.png"*/)
			);
		buildPortalList($fandomPortals);
	}
	
	
	
	
	
	
	
	else // BEGIN Create Fandom Homepage
	{
		?>
<SECTION CLASS="wrappingColumns news">
	<SECTION>
		<H2>News</H2>
		<P>Our new site is up! We hope you enjoy using it as much as we enjoyed writing it! 8D</P>
		<DIV CLASS="signature">Herdmind Staff</DIV>
	</SECTION>

	<SECTION>
		<H2>Random Topics</H2>
		<?PHP buildTopicLinkList(getRandomTopicIndices(5)) ?>
	</SECTION>

	<SECTION>
		<H2>Oatmeal Muffin</H2>
		<A HREF="/oatmeal/">
			<IMG SRC="http://pony.herdmind.net/Images/featured/datamuffin.png" ALT="Oatmeal Muffin" CLASS="centered" STYLE="display:block;width:50%"/>
		</A>
	</SECTION>

	<SECTION>
		<H2>Trending Fanfacts</H2>
		<P>
			<?PHP
				$maturefilter = 0;
				//$subdomfilter = " b.subdomain = '".$cookie_params['path']."' and ";
				// (part of some code that grabs the subdomain and filters the results to the ones that relate to a branch that has a subdomain field of pony or tardis)
				$subdomfilter = " b.subdomain = '$fandom' ";
				
				
				//Random
				//$query =  "SELECT Distinct Page.PageID, Page.Name, Page.Picture, Page.PrimaryColor from (Page join SubmissionData on Page.PageID = SubmissionData.SubmissionID) join Branch as b on Page.Branch = b.BranchID where " . $subdomfilter . " SubmissionData.isPublic = '1'  and SubmissionData.isRemoved = '0' and ( SubmissionData.IsMature = '0' OR SubmissionData.IsMature = '" . $maturefilter . "') order by RAND() LIMIT  5";
				
				//Popular
				//FactID - DatePosted - Contents - sum(tal.Value) 				
				$query = "
				SELECT * FROM
				(
					SELECT DISTINCT Fact.FactID, Fact.DatePosted, Fact.Contents, sum(tal.Value) FROM 
					(
						(
							(
								(
									Fact LEFT JOIN SubmissionData AS s ON FactID = s.SubmissionID
								)
								LEFT JOIN FactScoreByTally AS tal ON Fact.FactID = tal.FactID
							)
							JOIN FactBranch AS fb ON Fact.FactID = fb.FactID
						)
						JOIN Branch AS b ON fb.BranchID = b.BranchID
					)
					WHERE $subdomfilter
					AND tal.DatePointScored > DATE_SUB(curdate(), INTERVAL 2 WEEK) 
					AND s.IsPublic='1' 
					AND s.IsMature='$maturefilter' 
					AND s.IsRemoved='0' 
					GROUP BY Fact.FactID 
					ORDER BY sum(tal.Value)
					DESC LIMIT 10
				)
				AS PopularFacts order by Rand()";
				
				echo TitleFiller(buildFacts(mysqli_query($db_connection, $query), 5),$db_connection);
				
			?>
		</P>
	</SECTION>

	<SECTION>
		<H2>New Fanfacts</H2>
		<P>
		<?php
		
				$maturefilter = 0;//Use this when we allow the user to show mature fanfacts
				
		
				//FactID - DatePosted - Contents - sum(tal.Value) 
				$query =  "
				SELECT * FROM 
				(
					SELECT DISTINCT Fact.FactID, Fact.DatePosted, Fact.Contents, sum(tal.Value) FROM 
					(
						(
							(
								(
									Fact LEFT JOIN SubmissionData AS s ON FactID = s.SubmissionID
								)
								LEFT JOIN FactScoreByTally AS tal ON Fact.FactID = tal.FactID
							)
							JOIN FactBranch AS fb ON Fact.FactID = fb.FactID
						)
						JOIN Branch AS b ON fb.BranchID = b.BranchID
					)
					WHERE b.subdomain = '$fandom'
					AND tal.DatePointScored > DATE_SUB(curdate(), INTERVAL 2 WEEK) 
					AND s.IsPublic='1'
					AND s.IsMature='$maturefilter'
					AND s.IsRemoved='0'
					GROUP BY Fact.FactID
					ORDER BY Fact.DatePosted
					DESC LIMIT 10
				)
				as RecentFacts order by Rand()";
		
				echo TitleFiller(buildFacts(mysqli_query($db_connection, $query), 5),$db_connection);
		?></P>
	</SECTION>
	<?PHP
	} // END Create Fandom Homepage
	?>
</SECTION>


<?PHP
buildFooter(); // Adds the footer
?>

<SECTION ID="KYLI_META" STYLE="border:thin dashed lightgray;">
	<BUTTON ONCLICK="KYLI_META.style.display = 'none';">Hide developer's notes</BUTTON>
	<P>
		This work-in-progress is Kyli's proposal for a new Herdmind front page. It's <EM>completely</EM> W3C compliant and looks
		and works exactly the same on all modern browsers. It features a dynamic layout, capable of going down to 128 pixels
		wide on a default setup without causing unusability.
	</P>
	<H2>Testing</H2>
	<H3>URL Parameters:</H3>
	<UL>
		<LI><B><CODE>login</CODE></B>
			<UL>
				<LI><B>[OMISSION]</B>         &ndash; User is not logged in</LI>
				<LI><B><CODE>false</CODE></B> &ndash; User is not logged in</LI>
				<LI><B>[OTHER]</B>            &ndash; User is logged in with this username</LI>
			</UL>
		</LI>
		<LI><B><CODE>mod</CODE></B>
			<UL>
				<LI><B>[OMISSION]</B>         &ndash; User is not a moderator</LI>
				<LI><B><CODE>true</CODE></B>  &ndash; User is a moderator</LI>
				<LI><B>[OTHER]</B>            &ndash; User is not a moderator</LI>
			</UL>
		</LI>
		<LI><B><CODE>fandom</CODE></B>
			<UL>
				<LI><B>[OMISSION]</B>          &ndash; Default portal homepage</LI>
				<LI><B><CODE>pony</CODE></B>   &ndash; My Little Pony: Friendship is Magic homepage</LI>
				<LI><B><CODE>mlp</CODE></B>    &ndash; My Little Pony: Friendship is Magic homepage</LI>
				<LI><B><CODE>fim</CODE></B>    &ndash; My Little Pony: Friendship is Magic homepage</LI>
				
				<LI><B><CODE>tardis</CODE></B> &ndash; Doctor Who homepage</LI>
				<LI><B><CODE>who</CODE></B>    &ndash; Doctor Who homepage</LI>
				<LI><B><CODE>dw</CODE></B>     &ndash; Doctor Who homepage</LI>
				
				<LI><B><CODE>ppg</CODE></B>    &ndash; Powerpuff Girls homepage</LI>
				<LI><B>[OTHER]</B>             &ndash; &ldquo;Fandom not found&ldquo; page</LI>
			</UL>
		</LI>
	</UL>
	
	<H3>Supported Browsers:</H3>
	<P>
		Oldest <EM>tested</EM> working desktop browsers are Chrome 25, Firefox 18, IE 9, Opera 11, and Safari 5. Mobile browsers
		are Chrome and Opera.
	</P>
	
	<H4>Desktop</H4>
	<UL>
		<LI><B>Chrome</B> &ndash; latest version (assume autoupdating is enabled)</LI>
		<LI><B>Firefox</B> &ndash; 4&plus;</LI>
		<LI><B>IE</B> &ndash; 9&plus; (no style switching)</LI>
		<LI><B>Opera</B> &ndash; 11+</LI>
		<LI><B>Safari</B> &ndash; 5+</LI>
	</UL>
	
	<H4>Mobile</H4>
	<UL>
		<LI><B>Chrome</B> &ndash; latest version (assume autoupdating is enabled)</LI>
		<LI><B>Opera Mobile</B> &ndash; 12+</LI>
	</UL>
</SECTION>
</BODY>
</HTML>
