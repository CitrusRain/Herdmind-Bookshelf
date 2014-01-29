<?php
/*
Content Builder Index

Builds content that appears exclusively on the front page
*/

/**
 * Builds a portal list, using PortalItems.
 * 
 * @param $listItems an array of PortalItems
 * 
 * @see PortalItem for how to create a PortalItem
 * 
 * @author Kyli Rouge
 * @since 2013-03-18
 * @version 1.0.0 (2013-03-18)
 */
function buildPortalList($listItems)
{
	echo '
<UL CLASS="portal">';
	foreach ($listItems as $item)
	{
		$item->build();
	}
	echo '
</UL>';
}

/**
 * A list item to go in a portal list.
 * To create a new portal item: new PortalItem("Fandom Name", "/link/url", "/image/path.png")
 * To buidl a new portal item, call the build function
 * 
 * @author Kyli Rouge
 * @since 2013-03-18
 * @version 1.0.0 (2013-03-18)
 */
class PortalItem
{
	/**
	 * Creates a new PortalItem.
	 * 
	 * @param $name A text string representing the name of the fandom.
	 * @param $url  A text string containing a valid URL pointing to the fandom
	 * @param $img  A text string containing a valid URL pointing to an image which represents the fandom.
	 * 
	 * @author Kyli Rouge
	 * @since 2013-03-18
	 * @version 1.0.0 (2013-03-18)
	 */
	function __construct($name, $url, $img = null)
	{
		$this->name = $name;
		$this->url = $url;
		$this->img = $img ? $img : "http://placehold.it/400x282&text=" . urlencode($name);
	}
	
	/**
	 * Builds a portal item.
	 * 
	 * @param $standalone [OPTIONAL] if false, then this will be in an LI. Else, this will be in a DIV. Defaults to false.
	 * 
	 * @author Kyli Rouge
	 * @since 2013-03-18
	 * @version 1.1.0 (2013-04-01)
	 */
	function build($standalone = false)
	{
		echo '
		<' . ($standalone ? 'DIV' : 'LI') . '>
			<A HREF="' . $this->url . '">
				<FIGURE>
					<IMG SRC="' . $this->img . '" ALT="Logo for the ' . $this->name . ' headcanon database"/>
					<FIGCAPTION>
						' . $this->name . '
					</FIGCAPTION>
				</FIGURE>
			</A>
		</' . ($standalone ? 'DIV' : 'LI') . '>';
	}
}

/* OLD CODE, archived 2013-04-02 for reference
 * Populates a meta list
 * 
 * @author Ryan Young
 * @since 2013-03-??
 * @version 1.0.0 (2013-03-??)
 *
function popMetaList($db_connection, $fandom)
{
//Should print 10 - prints 1.
		if($fandom != "")
		{
		$subdomfilter = " b.subdomain = '".$fandom."' and ";
		}
				
		$query =  "Select * from (SELECT Fact.DatePosted, Fact.Contents, Fact.FactID, sum(tal.Value) FROM 
		((((Fact left join SubmissionData as s on FactID = s.SubmissionID )left join  FactScoreByTally as tal 
		on Fact.FactID = tal.FactID) join FactBranch as fb on Fact.FactID = fb.FactID)
		join Branch as b on fb.BranchID = b.BranchID)
		 where ".$fandomfilter." tal.DatePointScored > DATE_SUB(curdate(), INTERVAL 2 WEEK) 
		and s.IsPublic='1' and s.IsMature='0' and s.IsRemoved='0' group by Fact.FactID order by sum(tal.Value) desc LIMIT 0, 10) as PopFact order by Rand()";

		$result = mysqli_query($db_connection,$query) or die('Query failed: ' . mysqli_error());

	echo $query;

		echo "<div class='content'>";

		$countofprinted = 0;

		while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
			//echo "\t<tr>\n";
			$results = array();
			$pos = 0;
			foreach ($line as $col_value) {
			
				$results[$pos] = "$col_value";
				echo "<br/> $pos = $results[$pos] ";
				$pos++;
			}
		   
		 $scoreQ = "select SUM(tty.value) as tally from FactScoreByTally as tty left join Fact on Fact.FactID = tty.FactID where tty.FactID = '$results[6]';";

		$scoreQ2 = mysqli_query($db_connection, $scoreQ) or die('Query failed: ' . mysqli_error());

		$line2 = mysqli_fetch_array($scoreQ2, MYSQL_ASSOC);
			$results2 = array();
			$pos1 = 0;
		foreach ($line2 as $col_value) {
			
				$results2[$pos1] = "$col_value";
				//echo "<br/> $pos = $results[$pos] ";
				$pos1++;
			}

		$query3 =  "SELECT PageTitles.Title, PageTitles.ID, COUNT( NSBT.UserPoint ) 
		FROM NameScoreByTally AS NSBT
		Right outer JOIN PageTitles ON PageTitles.ID = NSBT.NameID
		where PageTitles.PageID = '$results[0]'
		Group by PageTitles.ID
		ORDER BY COUNT( NSBT.UserPoint ) desc LIMIT 0, 1";

		
		$result1 = mysqli_query($db_connection,$query3) or die('Query failed: ' . mysql_error());
		while ($line3 = mysqli_fetch_array($result1, MYSQL_ASSOC)) {
			$topname = array();
			$pos2 = 0;
			foreach ($line3 as $col_value) {
			
				$topname[$pos2] = "$col_value";
				$pos2++;
			}
		}
		
		$pagetitle = $topname[0];

			echo "<div class='box'>";
			echo "<a href='./data.php?factid=$results[2]'>
					<sub>
					<img title='Details / Discussion' style='width:20px;' src='../CSS/images/details.png'>
					</sub>
				</a>";
			//echo "<span>".TitleFiller($results[1])."</span>";
			echo "<span>".$results[1]."</span>";
			//			Score: $results2[0] 
			/*echo "<br/><span style='float:right'><a href='./data.php?factid=$results[2]'>
					<sub>
					View details and discussion 
					<img title='Details / Discussion' style='width:20px;' src='../CSS/images/details.png'>
					</sub>
				</a></span>";*
			if($countofprinted == 1)
			{	
		//	echo "<a href='./topic.php?pageid=$results[2]'><img src='$results[2]' ></a>";	
			}
		$countofprinted++;
			echo "</div><br/>"; 
		}
		echo "</div>";


}*/

?>