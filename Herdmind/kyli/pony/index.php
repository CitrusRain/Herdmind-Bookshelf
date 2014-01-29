<!DOCTYPE HTML>
<!--
This is a mockup of the Herdmind front page as envisioned by Kyli Rouge|Supuhstar|Digit Shine
This mockup is copyright Herdmind.net ©2013
-->
<?PHP
include $_SERVER['DOCUMENT_ROOT']."/kyli/_incl/contentBuilder.php";
include $_SERVER['DOCUMENT_ROOT']."/_incl/convenience.php";
?>
<HTML>
<HEAD>
<?PHP
buildDefaultHeadContent("MLP:FiM", "The MLP:FiM homepage for Herdmind",
                        array("MLP", "FiM", "My Little Pony", "Friendship is Magic", "Homepage"));
?>
</HEAD>



<?PHP
buildBodyTagWithAttributes(); // <BODY ...>
buildHeader();
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
				$subdomfilter = " b.subdomain = 'pony' and ";
				
				
				//Random
				//$query =  "SELECT Distinct Page.PageID, Page.Name, Page.Picture, Page.PrimaryColor from (Page join SubmissionData on Page.PageID = SubmissionData.SubmissionID) join Branch as b on Page.Branch = b.BranchID where " . $subdomfilter . " SubmissionData.isPublic = '1'  and SubmissionData.isRemoved = '0' and ( SubmissionData.IsMature = '0' OR SubmissionData.IsMature = '" . $maturefilter . "') order by RAND() LIMIT  5";
				
				//Popular
				//FactID - DatePosted - Contents - sum(tal.Value) 				
				$query = "
				SELECT * FROM
					(SELECT DISTINCT Fact.FactID, Fact.DatePosted, Fact.Contents, sum(tal.Value) FROM 
						(
							(
								(
									(Fact left join SubmissionData AS s ON FactID = s.SubmissionID)
									LEFT JOIN FactScoreByTally AS tal ON Fact.FactID = tal.FactID
								)
								JOIN FactBranch AS fb ON Fact.FactID = fb.FactID
							)
							JOIN Branch AS b ON fb.BranchID = b.BranchID
						)
						WHERE ".$subdomfilter." tal.DatePointScored > DATE_SUB(curdate(), INTERVAL 2 WEEK) 
						AND s.IsPublic='1' AND s.IsMature='0' AND s.IsRemoved='0' GROUP BY Fact.FactID ORDER BY sum(tal.Value) desc LIMIT 10
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
		
				$maturefilter = 0;
				//$subdomfilter = " b.subdomain = '".$cookie_params['path']."' and ";
				// (part of some code that grabs the subdomain and filters the results to the ones that relate to a branch that has a subdomain field of pony or tardis)
				$subdomfilter = " b.subdomain = 'pony' and ";
				
		
				//FactID - DatePosted - Contents - sum(tal.Value) 
				$query =  "Select * from (SELECT distinct  Fact.FactID, Fact.DatePosted, Fact.Contents, sum(tal.Value) FROM 
				((((Fact left join SubmissionData as s on FactID = s.SubmissionID )left join  FactScoreByTally as tal 
				on Fact.FactID = tal.FactID) join FactBranch as fb on Fact.FactID = fb.FactID)
				join Branch as b on fb.BranchID = b.BranchID)
				where ".$subdomfilter." tal.DatePointScored > DATE_SUB(curdate(), INTERVAL 2 WEEK) 
				and s.IsPublic='1' and s.IsMature='0' and s.IsRemoved='0' group by Fact.FactID order by Fact.DatePosted desc LIMIT 10) as RecentFacts order by Rand()";
		
				echo TitleFiller(buildFacts(mysqli_query($db_connection, $query), 5),$db_connection);
		?></P>
	</SECTION>
</SECTION>



<?PHP
buildFooter();
?>
</BODY>
</HTML>
