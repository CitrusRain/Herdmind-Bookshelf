<!DOCTYPE HTML>
<HTML>
<HEAD>
<!--
This is a mockup of the Herdmind front page as envisioned by Kyli Rouge|Supuhstar|Digit Shine
This mockup is copyright Herdmind.net ©2013
-->
<?php
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";        // Start session and determine subdomain
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php";      // Also includes config.php (must be done first) and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilderIndex.php"; // Builds body content for index
include $_SERVER['DOCUMENT_ROOT']."/_incl/classes2.php";   			// A bunch of classes used for data
include $_SERVER['DOCUMENT_ROOT']."/_incl/RetreiveData.php";   		// Any function that returns XML
include $_SERVER['DOCUMENT_ROOT']."/_incl/convenience.php";
?>

<?php
buildDefaultHeadContent($fandom ? $parsedFandom : null);
?>

<?php
//Testing smf connectivity. Will be stored in different file after it works.


//require_once $_SERVER['DOCUMENT_ROOT'].'/forum/APIs/smf_2_api.php';
//global $user;
//$user = smfapi_getUserByUsername($user_info['username']);

?>

</HEAD>



<?php

buildBodyTagWithAttributes(); // <BODY ...>

if( isset($_GET['mod'])) $mod = $_GET['mod'];
else $mod = "";

buildHeader($mod); // Allows for testing of different layouts

?>



<?php
	//$fandom = $_GET["fandom"];//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! REMOVE BEFORE FINAL IMPLEMENTATION
		echo "
	<H1>";
		if (!$fandom) // If this is not a homepage for a registered fandom
		{
			if ($parsedFandom) // $parsedFandom is set to null only if we are on the main portal page (no domain)
				echo "Sorry!</H1><P>We don't cover the " . $parsedFandom . " fandom</P>";
			else
				echo "Welcome!</H1>";
		}
		else
			echo $parsedFandom . "</H1>";


	if(!$fandom or $fandom == '')
	{
		echo "
<P CLASS=\"focus\">Herdmind is a non-profit, fan-made database of non-canon <Q>fanfacts</Q>, which can be submitted and voted upon by any user.</P>
<SECTION>";

		$PortalList = GetFandoms($db_connection);
		
		$portals = $PortalList->toArray();
        echo "<!--";
		var_dump( $portals);
		
		foreach ($portals as $value)
			{
				var_dump( $value);
			}
        echo "-->";
		
		$tardis = $portals[0]; //portals[0] will really be the first top level fandom in aphabetical order
		
		$fandomPortals = // TODO: Change to database retrieval
			array(
				  new PortalItem( $tardis->getTitle(),
				                 "?fandom=tardis", //  "//tardis.herdmind.net"                 USE THIS IN FINAL IMPLEMENTATION
				                 "//beta.herdmind.net/_incl/resizedImage.php?w=512&i=/_img/fandom-logos/Who_4k.png")
				                 //$tardis->getLogo())                 USE THIS IN FINAL IMPLEMENTATION
				, new PortalItem("My Little Pony: Friendship is Magic",
				                 "?fandom=pony", // "//pony.herdmind.net"                     USE THIS IN FINAL IMPLEMENTATION
				                 "//beta.herdmind.net/_incl/resizedImage.php?w=512&i=/_img/fandom-logos/MLP_4k.png") //////////////////////////// TODO: CHANGE BEFORE GOING LIVE
                                 //"//herdmind.net/CSS/herdmind/SubsiteButtons/button_pony.png")
				, new PortalItem("Powerpuff Girls",
				                 "?fandom=ppg", // "//ppg.herdmind.net"                       USE THIS IN FINAL IMPLEMENTATION
				                 "//beta.herdmind.net/_incl/resizedImage.php?w=512&i=/_img/fandom-logos/PPG_4k.png")
				                 //"http://beta.herdmind.net/_img/Herdmind-logo_PPG.png")//"http://herdmind.net/CSS/herdmind/SubsiteButtons/button_ppg.png")
			);
		buildPortalList($fandomPortals);
		
	}







	else // BEGIN Create Fandom Homepage
	{
		?>
<SECTION CLASS="wrappingColumns news">
	<SECTION CLASS="blue cardIn">
		<H2>News</H2>
		<P>Our new site is up! We hope you enjoy using it as much as we enjoyed writing it! 8D</P>
		<DIV CLASS="signature">Herdmind Staff</DIV>
	</SECTION>

	<SECTION CLASS="magenta cardIn">
		<H2>Random Topics</H2>
		<?php echo buildTopicLinkListFromXML(GrabRandomTopics(5, $db_connection)); ?>
		<SPAN CLASS="devalert">[needs to be fandom sensitive]</SPAN>
	</SECTION>

	<SECTION CLASS="orange cardIn">
		<H2>Oatmeal Muffin</H2>
		<A HREF="/oatmeal/">
			<IMG SRC="http://pony.herdmind.net/Images/featured/datamuffin.png" ALT="Oatmeal Muffin" CLASS="centered" STYLE="display:block;width:50%"/>
		</A>
	</SECTION>

	<SECTION CLASS="green cardIn">
		<H2>Trending Fanfacts</H2>
		<?php
			$maturefilter = 0;
			//$subdomfilter = " b.subdomain = '".$cookie_params['path']."' and ";


			//Random
			//$query =  "SELECT Distinct Page.PageID, Page.Name, Page.Picture, Page.PrimaryColor from (Page join SubmissionData on Page.PageID = SubmissionData.SubmissionID) join Branch as b on Page.Branch = b.BranchID where " . $subdomfilter . " SubmissionData.isPublic = '1'  and SubmissionData.isRemoved = '0' and ( SubmissionData.IsMature = '0' OR SubmissionData.IsMature = '" . $maturefilter . "') order by RAND() LIMIT  5";

			//Popular
			//FactID - DatePosted - Contents - sum(tal.Value)
			$query = "
			SELECT * FROM
			(
				SELECT DISTINCT Fact.FactID, Fact.DatePosted, Fact.Contents, sum(tal.Value) as RecentSum FROM
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
				ORDER BY sum(tal.Value)
				DESC LIMIT 10
			)
			AS PopularFacts left join (
			SELECT DISTINCT Fact.FactID, sum(tal.Value) as TotalSum FROM
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
				AND s.IsPublic='1'
				AND s.IsMature='$maturefilter'
				AND s.IsRemoved='0'
				GROUP BY Fact.FactID
			) as AllTimePopularFacts on PopularFacts.FactID = AllTimePopularFacts.FactID			
			 order by Rand()";
			// echo $query;
			echo "<!--The reason for this being wrong is the 2 week filter. It is only counting votes made in the past 2 weeks.-->";
			try
			{
				$mysqliQuery = mysqli_query($db_connection, $query);
				$builtFacts = buildTrendingFacts($mysqliQuery, 5);
				$filledTitles = TitleFiller($builtFacts,$db_connection);
				echo $filledTitles;
			}
			catch (Exception $e)
			{
				?><DIV CLASS="devalert">
					An error ocurred during creation of the trending fanfacts:<BR/>
					<CODE>
						<?php echo $e->getMessage(); ?>
					</CODE>
				</DIV><?php
			}

		?>
	</SECTION>

	<SECTION CLASS="purple cardIn">
		<H2>New Fanfacts</H2>
		<?php

				$maturefilter = 0;//Use this when we allow the user to show mature fanfacts

				//FactID - Contents - DatePosted - SubmissionID - sum(tal.Value)
				$query =  "
				SELECT * FROM
				(
					SELECT DISTINCT Fact.FactID, Fact.Contents, Fact.DatePosted, s.SubmissionID, sum(tal.Value) FROM
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
					AND s.IsPublic='1'
					AND s.IsMature='$maturefilter'
					AND s.IsRemoved='0'
					GROUP BY Fact.FactID
					ORDER BY Fact.DatePosted
					DESC LIMIT 10
				)
				AS RecentFacts order by Rand()"; // TODO: Fix, fetches improper vote count, does not report current user's vote

				echo TitleFiller(buildFactsXML(GetFactXML(mysqli_query($db_connection, $query)), 5),$db_connection);
		?>
	</SECTION>
	<?php
	} // END Create Fandom Homepage
	?>
</SECTION>


<?php
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
	<UL>
	<LI>	This page auto-updated from github.</LI>
	</UL>
</SECTION>
</BODY>
</HTML>
