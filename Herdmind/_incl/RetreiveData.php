<!--Imported RetreiveData.php-->
<?php
// Returns things in XML format.

/**
 *
 * GetFactXML
 * GetFanfactById
 * GetFanfacts
 * TitleFinder
 *
 * GrabRandomTopics
 * GrabFanwork
 * GrabFanworksByFactID
 * GetTopicInfo
 * GetTopicNames
 * GetProfile
 * GetThread
 * 
 *
 * GetFandoms
 *
 * XMLWrapping
 *
**/


/**
 * Returns a list of fandoms as a class
 *
 * @param $TopBottom - 'top' gets the upper communities, 'bottom' gets the middle communities and it's fanon spinoffs 
 * 
 * @author Ryan Young
 * @since 2014/04/04
 * @version 1.0.1
 * 		- 2014-04-05 (1.0.1) - Kyli formatted whitespace
**/
function getCommunities($TopBottom)
{
	global $db_connection;
	global $fandom;

	$list = new FandomListing($TopBottom);
	//$level = "";
	if($TopBottom == "bottom")
	{
		$level = " level >= '1' ";
		$relate = " and (branchid = '".$fandom->fandomid."' || parentbranchid = '".$fandom->fandomid."') ";
	}
	else
	{
		$level = " level <= '1' ";
		$relate = "";
	}

	$query = "Select branchid, parentbranchid, branchname, level 
				from Branch where $level $relate order by level, branchname;";

	$QueryResults = mysqli_query($db_connection, $query);

	while ($line = mysqli_fetch_array($QueryResults, MYSQL_ASSOC))
	{	
		$list->addFandom(new Fandom($line['branchid'],$line['parentbranchid'],$line['branchname'],$line['level']));	
	}
	
	return $list;	
}

/**
 * Returns the fandoms above the one the user is viewing
 * 
 * @author Ryan Young
 * @since 2014/04/04
 * @version 1.0.1
 * 		- 2014-04-05 (1.0.1) - Kyli formatted whitespace
**/
function getCommunityPath()
{
	global $db_connection;
	global $fandom;

	//get current
	$query = "Select branchid, parentbranchid, branchname, level 
				from Branch where branchid = '".$fandom->fandomid."';";

	$QueryResults = mysqli_query($db_connection, $query);

	$line = mysqli_fetch_array($QueryResults, MYSQL_ASSOC);
			
	$current = new Fandom($line['branchid'],$line['parentbranchid'],$line['branchname'],$line['level']);	

	if($current->parentid != 0)
	{
		$current = getCommunityPathParent($current);
	}

	return $current;	
}

/**
 * Returns the fandoms above the one the user is viewing
 * 
 * @author Ryan Young
 * @since 2014/04/04
 * @version 1.0.0
**/
function getCommunityPathParent($child)
{
global $db_connection;

//get current
$query = "Select branchid, parentbranchid, branchname, level 
			from Branch where branchid = '".$child->parentid ."';";

$QueryResults = mysqli_query($db_connection, $query);

$line = mysqli_fetch_array($QueryResults, MYSQL_ASSOC);

$current = new Fandom($line['branchid'],$line['parentbranchid'],$line['branchname'],$line['level']);	

$current->addSubFandom($child);

if($current->parentid != 0)
{
	$current = getCommunityPathParent($current);
}

return $current;	

}


/**
 * Returns fanworks to populate a gallery.
 *
 * @param $QueryResults 		The results of a search - this is index sensitive
 * 
 * @author Ryan Young
 * @since May 31 2013
 * @version 1.0.0
**/
function GetGallery()
{
global $db_connection;
global $userid;

$ReturnString = "";
$query = "SELECT distinct SupportID, Type, LinkSrc, Title 
from (((SupportRef join SupportingWorks on SupportingWorks.ID = SupportRef.SupportID) join SubmissionData as s on SupportID = s.SubmissionID)
left join FanworkTags as FT on FT.FanworkID = SupportRef.SupportID) left join Tags as tag on FT.TagID = tag.TagID
where s.SubmissionType like 'Fanwork%' and s.SubmissionType != 'Fanwork - Connection' and s.IsPublic='1' and s.IsMature='0' and s.IsRemoved='0' $tagFilter 
order by s.TimeSubmitted desc limit $startat, $count;";


}

/**
 * Returns an XML string of fanfacts in the result set.
 *
 * @param $QueryResults 		The results of a search - this is index sensitive
 * 
 * @author Ryan Young
 * @since May 31 2013
 * @version 1.0.0
**/
function GetFactXML($QueryResults, $userid = null, $dbc = null)
{
global $db_connection;
global $userid;

$ReturnString = "";
while ($line = mysqli_fetch_array($QueryResults, MYSQL_ASSOC)) {

    $facts = array();
    $pos = 0;
    foreach ($line as $col_value) {
    
        $facts[$pos] = "$col_value";
        $pos++;
  //      echo $col_value;
    }	 
    
    
$selected = "select Value from FactScoreByTally where FactID = '".$facts[0]."' and UserPoint = '".$userid."';";
	$run = mysqli_query($db_connection, $selected) or die('Query failed: ' . mysqli_error());
$opt = array();
while ($line = mysqli_fetch_array($run, MYSQL_ASSOC)) {
    $opt = array();
    $pos = 0;
    foreach ($line as $col_value) {
    
        $opt[$pos] = "$col_value";
        $pos++;
    }	
}     

$selected = "select sum(Value) from FactScoreByTally where FactID = '".$facts[0]."';";

	$run = mysqli_query($db_connection, $selected) or die('Query failed: ' . mysqli_error());

while ($line = mysqli_fetch_array($run, MYSQL_ASSOC)) {
    $cnt = array();
    $pos = 0;
    foreach ($line as $col_value) {
    
        $cnt[$pos] = "$col_value";
        $pos++;
    }	
}     
$uservote = 0;
if(isset($opt[0]) && $opt[0] != "")
{
	$uservote = $opt[0];
}

//get post count
$postscount = "SELECT count(id_topic) as 'count', id_topic
FROM `CommunityPosts`
WHERE approved =1
AND id_topic = '$facts[0]'
AND id_topic_type = 'fanfact'
GROUP BY id_topic";
$postcount = mysqli_query($db_connection, $postscount) or die('Query failed: ' . mysqli_error($db_connection));
$count = 0;
$line = mysqli_fetch_array($postcount, MYSQL_ASSOC);

		if(!is_null($line))
		{
			$count = $line['count'];			
			}        


$sc = 0 + $cnt[0];

//Todo: make this not always be false. (use the standalone vars)
$UserIsViewing = false;

$starred = checkStar("submissionID", $facts[3], $UserIsViewing);

$starbool = false;
if(!(empty($starred)))
{	
//	echo "<br/>starred on ".$starred[1].", last viewed on ".$starred[2]."<br/>";
	$starbool = true;
}

$ReturnString = $ReturnString.'
	<fanfact>
		<score>'.$sc.'</score>
		<uservote>'.$uservote.'</uservote>
		<factid>'.$facts[0].'</factid>
		<contents>'.$facts[1].'</contents>
		<dateposted>'.$facts[2].'</dateposted>
		<submissionid>'.$facts[3].'</submissionid>
		<isstarred>'.$starbool.'</isstarred>
		<commentcount>'.$count.'</commentcount>
	</fanfact>';

$num = 1;
$opt[0] = 0;
    
}
return $ReturnString;

}


/**
 * Returns an XML object of a single fact
 *
 * @param $factid		 		the id of the fanfact needed to be found
 * @param $subdomfilter			[OPTIONAL] helps to filter by fandom - must be formatted properly - goes right into the where clause
 * 
 * @author Ryan Young
 * @since May 31 2013
 * @version 1.0.0
**/
function GetFanfactByID($factid, $subdomfilter = "", $removedvar = 0, $removedvar2 = null)
{
global $db_connection;
global $userid;

$query ="select f.FactID, f.Contents, f.DatePosted, s.ID, s.SubmissionType, s.TimeSubmitted, s.IsPublic  
from ((Fact as f join SubmissionData as s on f.FactID = s.SubmissionID) join FactBranch as fb on fb.FactID = f.FactID )join Branch as b on fb.BranchID = b.BranchID 
where ".$subdomfilter." f.FactID = '$factid' and s.IsPublic = '1' and s.SubmissionType = 'Fact' order by s.TimeSubmitted desc limit 0, 1";

$run = mysqli_query($db_connection, $query) or die('Query failed: ' . mysqli_error());

$rt = GetFactXML($run, $userid, $db_connection);
	
return XMLWrapping($rt, "myxml");


}


/**
 * Returns an object of a regular post
 *
 * @param $threadid		 		the id of the fanfact needed to be found
 * @param $subdomfilter			[OPTIONAL] helps to filter by fandom - must be formatted properly - goes right into the where clause
 * 
 * @author Ryan Young
 * @since March 19 2014
 * @version 1.0.0
**/
function GetThreadByID($threadid)
{
global $db_connection;
global $userid;

$Thread;

$query ="SELECT id_msg, poster_time, id_member, id_msg_modified, 
					subject, poster_name, poster_email, poster_ip, 
					smileys_enabled, modified_time, modified_name,
					body, icon, approved, id_topic, id_topic_type, PremiumHeaderSettings, BannerText 
			FROM CommunityPosts join User on CommunityPosts.id_member = User.UserID WHERE
		 id_msg = '$threadid' and id_topic_type='Thread' and approved='1' limit 0, 1";

	$result = mysqli_query($db_connection, $query) or die('Query failed: ' . mysqli_error($db_connection));

	while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		$threadpost = array();
		$pos = 0;
		foreach ($line as $col_value) {
			$threadpost[$pos] = "$col_value";
			$pos++;
		}	
	
$Thread = new Comments($threadpost[0], $threadpost[14], $threadpost[15], 
							$threadpost[2], $threadpost[5], 
							$threadpost[1], $threadpost[6], $threadpost[7], 
							$threadpost[4], $threadpost[11], $threadpost[12], $threadpost[16] , $threadpost[17] );

/*$messageid, $topicid, $topictype,
 $memberid, $membername, $timeposted,
 $memberemail, $memberip, $postsubject,
  $postbody, $posticon
*/
return $Thread;
	}
	

}



/**
 * Returns an object of a feed
 *
 * @param $type		 		the type of feed.
 										 Default is new
 										 New is going to be recent discussions and fanfacts.
 										 Popular is going to be trending discussions and fanfacts.
 										 Social is going to be based on friends and user interactions. 
 * 
 * @author Ryan Young
 * @since March 19 2014
 * @version 1.0.0
**/
//TODO: Get the newest in a thread as well as what was being commented on. (eg Thread or fanfact)
function GetCommentsFeed($type)
{
global $db_connection;
global $userid;
global $fandom;

$Thread = array();
$Fanfacts = array();
$ThreadCount = 0;
$FanfactCount = 0;

$maturefilter = 0;
$ShowFanfacts = true;
if($ShowFanfacts)
	{
/*		$query ="select f.FactID, f.Contents, f.DatePosted, s.ID, s.SubmissionType, s.TimeSubmitted, s.IsPublic  
from ((Fact as f join SubmissionData as s on f.FactID = s.SubmissionID) join FactBranch as fb on fb.FactID = f.FactID )join Branch as b on fb.BranchID = b.BranchID 
where ".$subdomfilter." f.FactID = '$factid' and s.IsPublic = '1' and s.SubmissionType = 'Fact' order by s.TimeSubmitted desc limit 0, 1";
*/
	$query =  "
					SELECT * FROM
					(
						SELECT DISTINCT f.FactID, f.Contents, f.DatePosted, s.ID, s.SubmissionType, s.TimeSubmitted, s.IsPublic FROM
						(
							(
								(
									(
										Fact as f LEFT JOIN SubmissionData AS s ON f.FactID = s.SubmissionID
									)
									LEFT JOIN FactScoreByTally AS tal ON f.FactID = tal.FactID
								)
								JOIN FactBranch AS fb ON f.FactID = fb.FactID
							)
							JOIN Branch AS b ON fb.BranchID = b.BranchID
						)
						WHERE b.branchid = '$fandom->fandomid'
						AND s.IsPublic='1'
						AND s.IsMature='$maturefilter'
						AND s.IsRemoved='0'
						GROUP BY f.FactID
						ORDER BY f.DatePosted
						DESC LIMIT 10
					)
					AS RecentFacts order by Rand()";
					
		$run = mysqli_query($db_connection, $query) or die('Query failed: ' . mysqli_error());
	
						$cnt = array();
						$pos = 0;
					while ($line = mysqli_fetch_array($run, MYSQL_ASSOC)) {
						
		//f.FactID, f.Contents, f.DatePosted, s.ID, s.SubmissionType, s.TimeSubmitted, s.IsPublic	
		//var_dump($line);			
		$Fanfacts[$FanfactCount] = new Fanfact($line['FactID'], $line['ID'], $line['DatePosted'],
 						$line['Contents'], 0, 0, 0,
 						0, 0, 
 						0, 0, $line['IsPublic']);
 	/*	function __construct($factid = 0, $submissionid = 0, $dateposted = 0,
 						$contents = 0, $score = 0, $isstarred = 0, $issubscribed = 0,
 						$uservote = 0, $commentcount = 0, 
 						$isMature = 0, $isRemoved = 0, $isPublic = 1)				
*/
		$FanfactCount++;
						
	
					} 
	}		

	$query ="SELECT 
					id_msg, 				poster_time, 				id_member, 		id_msg_modified, 
					subject, 			poster_name, 				poster_email,	poster_ip, 
					smileys_enabled, 	modified_time, 			modified_name,
					body, 				icon, 						approved, 		id_topic,
					id_topic_type, 	PremiumHeaderSettings, 	BannerText
					
					FROM CommunityPosts join User on CommunityPosts.id_member = User.UserID
					WHERE approved='1' and id_msg = id_topic
					AND fandom = '$fandom->fandomid'
					order by poster_time desc limit 0, 30";

	
		
	$result = mysqli_query($db_connection, $query) or die('Query failed: ' . mysqli_error($db_connection));

	while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		$threadpost = array();
		$pos = 0;
		foreach ($line as $col_value) {
			$threadpost[$pos] = "$col_value";
			$pos++;
		}	
		
$Thread[$ThreadCount] = new Comments($threadpost[0], $threadpost[14], $threadpost[15],
												 $threadpost[2], $threadpost[5], $threadpost[1], 
												 $threadpost[6], $threadpost[7],	$threadpost[4],
												 $threadpost[11], $threadpost[12], $threadpost[16], $threadpost[17] );
		$ThreadCount++;
	}

$Stream = new Stream($Thread,$Fanfacts);
//var_dump($Stream);
return $Stream;
	

}

/**
 * Returns an XML object of a list of facts
 *
 * @param $factids		 		an array of the ids of the fanfacts needed to be found
 *
 *	<fanfact>
 *		<score>'.$sc.'</score>
 *		<uservote>'.$opt[0].'</uservote>
 *		<factid>'.$facts[0].'</factid>
 *		<contents>'.$facts[1].'</contents>
 *		<dateposted>'.$facts[2].'</dateposted>
		<submissionid>'.$facts[3].'</submissionid>
		<isstarred>0</isstarred>
 *	</fanfact>
 *
 * @author Ryan Young
 * @since Feb 2014
 * @version 1.0.0
**/
function GetFanfactsByIDList($factids)
{
	global $db_connection;
	global $userid;

	$query ="select f.FactID, f.Contents, f.DatePosted, s.ID, s.SubmissionType, s.TimeSubmitted, s.IsPublic  
	from ((Fact as f join SubmissionData as s on f.FactID = s.SubmissionID) join FactBranch as fb on fb.FactID = f.FactID )join Branch as b on fb.BranchID = b.BranchID 
	where ";

	$query = $query."( f.FactID = '".$factids[0]."' ";

	foreach ($factids as $factid)
	{
		$query = $query." or f.FactID = '$factid' ";
	}

	$query = $query.") and s.IsPublic = '1' and s.SubmissionType = 'Fact' order by s.TimeSubmitted desc";
	//echo $query;
	$run = mysqli_query($db_connection, $query) or die('Query failed: ' . mysqli_error($db_connection));

	$rt = GetFactXML($run, $userid, $db_connection);
	//echo $rt."<br/>";
	$myinfo = XMLWrapping($rt, "myxml");

	
	return $myinfo;
}


/**
 * Returns XML data of fanfacts that contain $pageid.
 *
 * @param $pageid 		the page id to find
 * @param $start			the result to start on
 * @param $show			the number of results to show
 * @param $dbc          [OPTIONAL] the connection to a Herdmind database
 *
 *	<fanfact>
 *		<score>'.$sc.'</score>
 *		<uservote>'.$opt[0].'</uservote>
 *		<factid>'.$facts[0].'</factid>
 *		<contents>'.$facts[1].'</contents>
 *		<dateposted>'.$facts[2].'</dateposted>
		<submissionid>'.$facts[3].'</submissionid>
		<isstarred>0</isstarred>
 *	</fanfact>
 *	
 * 
 * @author Ryan Young
 * @since May 29 2013
 * @version 1.0.1
**/
function GetFanfacts($pageid, $start, $show, $userid, $dbc = null)
{
global $db_connection;

$ReturnString = '';

$limit = ' limit ';

if($start != "")
	$limit = $limit.$start;
else
	$limit = $limit.'0';

if($show != "" && $show != 0)
{
	$show = $show+1;
	$limit = $limit.", ".$show;
}
else
{
	$show = 6;
	$limit = $limit.", $show";
}

$query ="select count(f.FactID), f.Contents, s.ID, s.SubmissionType, s.TimeSubmitted, s.IsPublic from Fact as f join SubmissionData as s on f.FactID = s.SubmissionID where f.Contents like '%[p$pageid]%' and s.IsPublic = '1' and s.SubmissionType = 'Fact' $limit";

$run = mysqli_query($db_connection, $query) or die('Query failed: ' . mysqli_error($db_connection));

while ($line = mysqli_fetch_array($run, MYSQL_ASSOC)) {
    $opta = array();
    $pos = 0;
    foreach ($line as $col_value) {
    
        $opta[$pos] = "$col_value";
        $pos++;
    }	

} 
$query = "";



$query ="select f.FactID, f.Contents, f.DatePosted, s.SubmissionID, s.SubmissionType, s.TimeSubmitted, s.IsPublic, s.ID  
from ((Fact as f join SubmissionData as s on f.FactID = s.SubmissionID) join FactBranch as fb on fb.FactID = f.FactID )join Branch as b on fb.BranchID = b.BranchID 
where f.Contents like '%[p$pageid]%' and s.IsPublic = '1' and s.SubmissionType = 'Fact' order by s.TimeSubmitted desc $limit";

$rfacts = mysqli_query($db_connection, $query) or die('Query failed: ' . mysqli_error());
$grp = "A";
$count = 0;
while ($line = mysqli_fetch_array($rfacts, MYSQL_ASSOC)) {

if($count < $show - 1)
{
    $facts = array();
    $pos = 0;
    foreach ($line as $col_value) {
    
        $facts[$pos] = "$col_value";
        $pos++;
    }	 
    
    
$selected = "select Value from FactScoreByTally where FactID = '".$facts[0]."' and UserPoint = '$userid';";

	$run = mysqli_query($db_connection, $selected) or die('Query failed: ' . mysqli_error());

$uservote = 0;
if(isset($opt[0]) && $opt[0] != "")
{
	$uservote = $opt[0];
}
$ViewerVoted = "";
while ($line = mysqli_fetch_array($run, MYSQL_ASSOC)) {
   
    if(isset($line[0]))
    	$ViewerVoted = $line[0];
}     

$selected = "select sum(Value) from FactScoreByTally where FactID = '".$facts[0]."';";

	$run = mysqli_query($db_connection, $selected) or die('Query failed: ' . mysqli_error());

while ($line = mysqli_fetch_array($run, MYSQL_ASSOC)) {
    $cnt = array();
    $pos = 0;
    foreach ($line as $col_value) {
    
        $cnt[$pos] = "$col_value";
        $pos++;
    }	
}     


//Todo: make this not always be false. (use the standalone vars)
$UserIsViewing = false;

$starred = checkStar("submissionID", $facts[7], $UserIsViewing);

$starbool = false;
if(!(empty($starred)))
{	
	echo "<br/>starred on ".$starred[0].", last viewed on ".$starred[1]."<br/>";
	$starbool = true;
}

$sc = 0 + $cnt[0];

$ReturnString = $ReturnString.'
	<fanfact>
		<score>'.$sc.'</score>
		<uservote>'.$ViewerVoted.'</uservote>
		<factid>'.$facts[0].'</factid>
		<contents>'.$facts[1].'</contents>
		<dateposted>'.$facts[2].'</dateposted>
		<submissionid>'.$facts[7].'</submissionid>
		<isstarred>'.$starbool.'</isstarred>
	</fanfact>';
	
$num = 1;
$opt[0] = 0;


}
$count++;    
}

return <<<XML
<?xml version="1.0" encoding="ISO-8859-1"?>
<myxml>
	$ReturnString
</myxml>
XML;
}




/**
 * Returns XML data of submissions that a user has interacted with.
 *
 * @param $memberid 		the id of the member being viewed
 *
 *
 *<submissions>
 *		<fanfacts>
 *			<fanfact>
 *				<score>'.$sc.'</score>
 *				<uservote>'.$opt[0].'</uservote>
 *				<factid>'.$facts[0].'</factid>
 *				<contents>'.$facts[1].'</contents>
 *				<dateposted>'.$facts[2].'</dateposted>
 *				<submissionid>'.$facts[3].'</submissionid>
 *				<isstarred>0</isstarred>
 *				<ispublic></ispublic>
 *				<ismature></ismature>
 *				<isremoved></isremoved>
 *			</fanfact>
 *		</fanfacts>
 *		<fanworks></fanworks>
 *		<comments></comments>
 *</submissions> 
 *<starreditems>
 *		<topics>
 *		<fanfacts>
 * 	<fanworks>
 *		<comments>
 *</starreditems>
 *	
 * 
 * @author Ryan Young
 * @since Jan 22 2014
 * @version 1.0.0
**/
function GetSubmissionListByMemberID($memberid)
{
global $db_connection;
global $userid;

$NonPublic = "";
if($memberid != $userid)
{
$NonPublic = " and s.IsPublic = '1' ";
}

$ReturnString = '';


//Find fanfacts that the user submitted.
$query ="select f.FactID, f.Contents, f.DatePosted, s.SubmissionID, s.SubmissionType, s.TimeSubmitted, s.IsPublic  
from ((Fact as f join SubmissionData as s on f.FactID = s.SubmissionID) join FactBranch as fb on fb.FactID = f.FactID )join Branch as b on fb.BranchID = b.BranchID 
where s.UserID = '$memberid' $NonPublic and s.SubmissionType = 'Fact' order by s.TimeSubmitted desc";

$rfacts = mysqli_query($db_connection, $query) or die('Query failed: ' . mysqli_error());
$grp = "A";
$count = 0;
while ($line = mysqli_fetch_array($rfacts, MYSQL_ASSOC)) {


    $facts = array();
    $pos = 0;
    foreach ($line as $col_value) {
    
        $facts[$pos] = "$col_value";
        $pos++;
    }	 
    

//See if the person viewing the fanfacts voted for them, and if so, retreive the votes
 
$selected = "select Value from FactScoreByTally where FactID = '".$facts[0]."' and UserPoint = '$userid';";
$run = mysqli_query($db_connection, $selected) or die('Query failed: ' . mysqli_error());
$ViewerVoted = "";
while ($line = mysqli_fetch_array($run, MYSQL_ASSOC)) {
    
    if(isset($line[0]))
    	$ViewerVoted = $line[0];
    
}     

$selected = "select sum(Value) from FactScoreByTally where FactID = '".$facts[0]."';";

	$run = mysqli_query($db_connection, $selected) or die('Query failed: ' . mysqli_error());

while ($line = mysqli_fetch_array($run, MYSQL_ASSOC)) {
    $cnt = array();
    $pos = 0;
    foreach ($line as $col_value) {
    
        $cnt[$pos] = "$col_value";
        $pos++;
    }	
}     


$sc = 0 + $cnt[0];

$ReturnString = $ReturnString.'
	<fanfact>
		<score>'.$sc.'</score>
		<uservote>'.$ViewerVoted.'</uservote>
		<factid>'.$facts[0].'</factid>
		<contents>'.$facts[1].'</contents>
		<dateposted>'.$facts[2].'</dateposted>
		<submissionid>'.$facts[3].'</submissionid>
		<isstarred>0</isstarred>
	</fanfact>';

$num = 1;
$opt[0] = 0;

}

$count++;    


return <<<XML
<?xml version="1.0" encoding="ISO-8859-1"?>
<myxml>
	$ReturnString
</myxml>
XML;
}



/**
 * Returns XML data with no parent tag around it that contains information about a page.
 * Reccomend calling it to get all the fanfact titles at once
 *
 * @param $orignalstring the string containing the page codes to be found
 * @param $dbc          [OPTIONAL] the connection to a Herdmind database
 *
 *	<topicinfo>
 *		<pageid>
 *		<pagename>
 *		<type>
 *	 	<reality>
 *		<series>
 *	</topicinfo>
 * 
 * @author Ryan Young
 * @since May 29 2013
 * @version 1.0.2 (2014/01/22)
**/
function TitleFinder($originalstring, $dbc = null){

global $db_connection;
global $userid;	
	
$string = $originalstring;
//$string = htmlentities($originalstring,ENT_QUOTES);
$pos1 = strpos($string, "[p") + 2;
$pos2 = strpos($string , "]", $pos1);
$cou = 0;
$pageids = '';
//while($pos1 != false && $pos1 != -1 && $pos2 != -1 && $cou < 50 && !(empty($pos2)))
while($pos1 != false && $pos2 != -1 && $pos2 != "" && $cou < 150)
{

echo "<!--(Insert fact code found at: $pos1 , $pos2 )-->";
$pageid = substr($string,$pos1,$pos2-$pos1);
if(is_numeric($pageid))
{

if ($cou > 0)
{
$pageids = $pageids." or ";
}

$pageids = $pageids." PageTitles.PageID = '".$pageid."'";

}

$string = str_replace("[p".$pageid."]", "done",$string);

$pos1 = strpos($string, "[p") + 2;
$pos2 = strpos($string , "]", $pos1);

$cou = $cou + 1;
}
//echo "<b>".$pageids."</b>";

$content = '';

if( $pageids != "" )
{
$query =  "SELECT q1.Title, q1.ID, q1.pointcount,
q1.Picture, q1.Type, q1.FanCan, q1.BranchName, q1.PageID from (select PageTitles.Title, PageTitles.ID, COUNT( NSBT.UserPoint ) as pointcount,
p.Picture, p.Type, p.FanCan, b.BranchName, p.PageID 
FROM ((NameScoreByTally AS NSBT
Right outer JOIN PageTitles ON PageTitles.ID = NSBT.NameID) join Page as p on p.PageID = PageTitles.PageID 
) join Branch as b on p.Branch = b.BranchID 
where ($pageids)
Group by PageTitles.ID
ORDER BY COUNT( NSBT.UserPoint ) desc ) as q1 group by q1.PageID LIMIT 0, $cou ;";

//echo "<b>$query</b>";
$result = mysqli_query($db_connection, $query) or die($error.': ' . mysqli_error($dbc));


while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
    $rs = array();
    $pos = 0;
    foreach ($line as $col_value) {
        $rs[$pos] = "$col_value";
        $pos++;
    }	 
$xmlnames = GetTopicNames($dbc, $rs[7], $userid);	
	$content = $content.'
	<topicinfo>
		<pageid>'.($rs[7]).'</pageid>
		<pagename>'.$rs[0].'</pagename>	
		'.$xmlnames.'
		<type>'.$rs[4].'</type>
		<reality>'.$rs[5].'</reality>
		<series>'.$rs[6].'</series>
		<picture>'.$rs[3].'</picture>
	</topicinfo>
	';
	
}
}
	return <<<XML
<?xml version="1.0" encoding="ISO-8859-1"?>
<pagetitles>
	$content
</pagetitles>
XML;

}



/**
 * Returns XML data with random topics.
 *
 * @param $count		the number of topics to grab
 * @param $dbc          the connection to a Herdmind database
 *
 *	<topicinfo>
 *		<pageid>
 *		<pagename>
 *		<type>
 *	 	<reality>
 *		<series>
 *	</topicinfo>
 * 
 * @author Ryan Young
 * @since May 29 2013
 * @version 1.0.1
**/
function GrabRandomTopics($count){

global $db_connection;
global $userid;

//Todo make it only grab random APPROVED TOPICS
$query =  "SELECT q1.Title, q1.ID, q1.pointcount,
q1.Picture, q1.Type, q1.FanCan, q1.BranchName, q1.PageID from (select PageTitles.Title, PageTitles.ID, COUNT( NSBT.UserPoint ) as pointcount,
p.Picture, p.Type, p.FanCan, b.BranchName, p.PageID 
FROM ((NameScoreByTally AS NSBT
Right outer JOIN PageTitles ON PageTitles.ID = NSBT.NameID) join Page as p on p.PageID = PageTitles.PageID 
) join Branch as b on p.Branch = b.BranchID 
where (b.BranchName like '%po%')
Group by PageTitles.ID
ORDER BY pointcount desc ) as q1 group by q1.PageID ORDER BY RAND() LIMIT 0, $count";

$result = mysqli_query($db_connection, $query) or die($error.': ' . mysqli_error($db_connection));

$content = '';

while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
    $rs = array();
    $pos = 0;
    foreach ($line as $col_value) {
        $rs[$pos] = "$col_value";
        $pos++;
    }	 

$xmlnames = GetTopicNames($db_connection, $rs[7], $userid);	
	$content = $content.'
	<topicinfo>
		<pageid>'.($rs[7]).'</pageid>
		<pagename>'.$rs[0].'</pagename>
		'. $xmlnames .'
		<type>'.$rs[4].'</type>
		<reality>'.$rs[5].'</reality>
		<series>'.$rs[6].'</series>
		<picture>'.$rs[3].'</picture>
	</topicinfo>
	';
	
}
	return "
<pagetitles>
".	$content ."
</pagetitles>";

}

/**
 * Returns XML data with a single fanwork. (currently dummy data)
 *
 * @param $dbc          the connection to a Herdmind database (this will be first for now on)
 * @param $workid		the id of the fanwork to grab data for
 *
 *	<fanwork>
 *		<workid>
 *		<content>
 *			<youtube>
 *			<image>
 *			<fanfic>
 *		</content>
 *		<tags>
 *			<tag>
 *		</tags>
 *		<relatedfacts>
 *			<factid>
 *		</relatedfacts>
 *	</fanwork>
 * 
 * @author Ryan Young
 * @since June 6 2013
 * @version 0.0.0
**/
function GrabFanwork($dbc, $workid)
{
$content = '';

$content = '
<fanwork>
	<workid>12</workid>
	<content>
		<image>http://herdmind.net/Images/fanart/12.jpg</image>
	</content>
	<tags>
		<tag>Derpy Hooves</tag>
		<tag>CMC</tag>
		<tag>Dinky Doo</tag>
	</tags>
	<relatedfacts>
 		<factid>132</factid>
 		<factid>106</factid>
	</relatedfacts>
</fanwork>
';

return <<<XML
<?xml version="1.0" encoding="ISO-8859-1"?>
<pagetitles>
	$content
</pagetitles>
XML;

}


/**
 * Returns XML data with a list of fanworks. (currently dummy data)
 *
 * @param $dbc          the connection to a Herdmind database (this will be first for now on)
 * @param $factid		the id of the fanfact to grab related fanwork data for
 *
 *	<support>
 *		<fanwork>
 *			<workid>
 *			<content>
 *				<youtube>
 *				<image>
 *				<fanfic>
 *			</content>
 *			<tags>
 *				<tag>
 *			</tags>
 *			<relatedfacts>
 *				<factid>
 *			</relatedfacts>
 *		</fanwork>
 *	</support>
 * 
 * @author Ryan Young
 * @since June 6 2013
 * @version 0.0.0
**/
function GrabFanworksByFactID($dbc, $factid)
{
$content = '';

$content = '
<support>
	<fanwork>
		<workid>12</workid>
		<content>
			<image>http://herdmind.net/Images/fanart/12.jpg</image>
		</content>
	</fanwork>
	<fanwork>
		<workid>12</workid>
		<content>
			<image>http://herdmind.net/Images/fanart/12.jpg</image>
		</content>
	</fanwork>
</support>
';

return <<<XML
<?xml version="1.0" encoding="ISO-8859-1"?>
<pagetitles>
	$content
</pagetitles>
XML;

}

/**
 * Returns XML data for a topic.
 *
 * @param $dbc          the connection to a Herdmind database
 * @param $pageid 		the page id to find
 * @param $userid			[OPTIONAL] the id of the user
 *
 *	<topic>
 *		<picture>
 *		<names>
 *			<selectedname>
 *	 			<namecontents>
 *	 			<nameid>
 *			</selectedname>
 *			<name>
 *	 			<namecontents>
 *	 			<nameid>
 *	 			<namescore>
 *			</name>
 *		</names>
 *		<description>
 *		<type>
 *		<reality>
 *		<canonwith>
 *			<branchname>
 *			<branchid>
 *		</canonwith>
 *		<topicid>
 *	</topic>
 *	
 * 
 * @author Ryan Young
 * @since June 10 2013
 * @version 1.0.0
**/
function GetTopicInfo($dbc, $pageid, $userid = '0')
{	
$query =  "SELECT  	PageID ,  		Name ,  		Type ,  
					FanCan , 		Page.Branch,	b.BranchName , 
					PageContents ,  CreatedBy ,  	Picture ,  
					Picture2 , 		PrimaryColor, 	WikiRef
					FROM  Page join Branch as b on Page.Branch = b.BranchID where PageID = '$pageid'   LIMIT 0 , 1";
//echo $query;
$result = mysqli_query($dbc, $query) or die('Query failed: ' . mysqli_error($dbc));

while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
    $pageresults = array();
	$pos = 0;
    foreach ($line as $col_value) {
        $pageresults[$pos] = "$col_value";
        $pos++;
    }	
}

$xmlstring = '
	<topic>
		<picture>'.$pageresults[8].'</picture>
		'.GetTopicNames($dbc, $pageid, $userid).'
		<description>'.$pageresults[6].'</description>
		<type>'.$pageresults[2].'</type>
		<reality>'.$pageresults[3].'</reality>
			<canonwith>
				<branchname>'.$pageresults[5].'</branchname>
				<branchid>'.$pageresults[4].'</branchid>
			</canonwith>
		<topicid>'.$pageid.'</topicid>
	</topic>';
	
	//echo $xmlstring;
	return <<<XML
<?xml version="1.0" encoding="ISO-8859-1"?>
$xmlstring
XML;

}


/**
 * Returns XML string of names on a topic
 *
**/
function GetTopicNames($dbc = null, $pageid, $userid = '0')
{
	global $db_connection;
	global $userid;
	$xmlnames = '
		<names>';

	$query =  "SELECT PageTitles.Title, PageTitles.ID FROM NameScoreByTally AS NSBT
	Right outer JOIN PageTitles ON PageTitles.ID = NSBT.NameID
	where PageTitles.PageID = '$pageid' and NSBT.UserPoint = '$userid'";

	$result = mysqli_query($db_connection, $query) or die('Query failed: ' . mysqli_error($db_connection));

	while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		$userpick = array();
		$pos = 0;
		foreach ($line as $col_value) {
			$userpick[$pos] = "$col_value";
			$pos++;
		}	
		
		$xmlnames = $xmlnames.'		
			<selectedname>
	 			<namecontents>'.$userpick[0].'</namecontents>
	 			<nameid>'.$userpick[1].'</nameid>
			</selectedname>
			';
	}

	$query =  "SELECT PageTitles.Title, PageTitles.ID, COUNT( NSBT.UserPoint ) 
	FROM NameScoreByTally AS NSBT
	Right outer JOIN PageTitles ON PageTitles.ID = NSBT.NameID
	where PageTitles.PageID = '$pageid'
	Group by PageTitles.ID
	ORDER BY COUNT( NSBT.UserPoint ) desc";

	$namelist = mysqli_query($db_connection, $query) or die('Query failed: ' . mysqli_error($db_connection).' Could not retrieve alias list for this page.');
	$Aliases = array();
	$aliasCount = 0;
	while ($line = mysqli_fetch_array($namelist, MYSQL_ASSOC)) {
		$names = array();
		$pos = 0;
		foreach ($line as $col_value) {
			$names[$pos] = "$col_value";
			$pos++;
		}	 
		$xmlnames = $xmlnames.'		
			<name>
	 			<namecontents>'.$names[0].'</namecontents>
	 			<nameid>'.$names[1].'</nameid>
				<namescore>'.$names[2].'</namescore>
			</name>
			';
		$Aliases[$aliasCount] = $names;
	$aliasCount++;
	}
	$aliasCount--;

	$xmlnames = $xmlnames.'			
		</names>
		';
	
	return $xmlnames;	
}


/**
 * Get profile information
 *
 * @param $dbc				the database connection
 * @param $viewuserid	the user id of the profile being visited
 * @param $userid			the user id of the signed in viewer
 */
 
function GetProfile($dbc, $viewuserid, $userid = '0')
 {	
	global $forumprefix;
 	$xmlprofile = '<userprofile>';
 	
 	$query =  "SELECT 
id_member,	member_name, 	date_registered,
posts, 		id_group, 		last_login, 
gender, 		birthdate, 		location, 
signature
 		 FROM ".$forumprefix."_members as members
					where id_member = '$viewuserid'";

	$result = mysqli_query($dbc, $query) or die('Query failed: ' . mysqli_error($dbc));

	while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		$profiledata = array();
		$pos = 0;
		foreach ($line as $col_value) {
			$profiledata[$pos] = "$col_value";
			$pos++;
		}	
		
		$xmlprofile = $xmlprofile.'
	 			<memberid>'.$profiledata[0].'</memberid>
	 			<memberalias>'.$profiledata[1].'</memberalias>
	 			<note>There are more fields I can insert here.</note>
			';
	}
 	
 	$xmlprofile = $xmlprofile.'</userprofile>';
 	
 	return $xmlprofile;	
 }



/**
 * Get comments
 *
 */
function GetComments($threadid, $TopicType)
 {	
	global $forumprefix;
	global $userid;
	global $db_connection;
	
 	$ForumThread = array();
 	$ThreadCount = 0;
 	
 	$xmlthread = '<thread>';

 	$Comments = NULL;
 	
 	$query =  "SELECT id_msg, id_topic, id_topic_type, id_member, poster_name, poster_time, poster_email,
 					poster_ip, subject, body, icon, approved, PremiumHeaderSettings, BannerText FROM CommunityPosts as posts
 							join User on posts.id_member = User.UserID
					where id_topic = '$threadid' and id_topic_type = '$TopicType' and approved = '1'";

	$result = mysqli_query($db_connection, $query) or die('Query failed: ' . mysqli_error($db_connection));

	while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		$threadpost = array();
		$pos = 0;
		foreach ($line as $col_value) {
			$threadpost[$pos] = "$col_value";
			$pos++;
		}	
		/*
		$xmlthread = $xmlthread.'		
			<userpost>
	 			<topicid>'.$threadpost[0].'</topicid>
	 			<memberid>'.$threadpost[1].'</memberid>
	 			<membername>'.$threadpost[2].'</membername>
	 			<timeposted>'.$threadpost[3].'</timeposted>
	 			<memberemail>'.$threadpost[4].'</memberemail>
	 			<memberip>'.$threadpost[5].'</memberip>
	 			<postsubject>'.$threadpost[6].'</postsubject>
	 			<postbody>'.$threadpost[7].'</postbody>
	 			<posticon>'.$threadpost[8].'</posticon>
			</userpost>
			';*/

		$Comments[$ThreadCount] = new Comments($threadpost[0], $threadpost[1], $threadpost[2], $threadpost[3], $threadpost[4], $threadpost[5], $threadpost[6], $threadpost[7], $threadpost[8] , $threadpost[9] , $threadpost[10]
		, $threadpost[12], $threadpost[13] );
		
	 	$ThreadCount =	$ThreadCount + 1;
	
	}
 	
// 	$xmlthread = $xmlthread.'</thread>';
 	
 	//return $xmlthread;
 	return $Comments;	
 }


/**
 * Get thread
 *
 */
function GetThread($dbc, $threadid, $userid = '0')
 {	
	global $forumprefix;
 	$ForumThread = array();
 	$ThreadCount = 0;
 	
 	$xmlthread = '<thread>';
 	
 	$query =  "SELECT id_topic, id_member, poster_name, poster_time, poster_email,
 					poster_ip, subject, body, icon, approved, PremiumHeaderSettings, BannerText  FROM ".$forumprefix."_messages as posts
 					join User on posts.id_member = User.UserID
					where id_topic = '$threadid' and approved = '1'";

	$result = mysqli_query($dbc, $query) or die('Query failed: ' . mysqli_error($dbc));

	while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		$threadpost = array();
		$pos = 0;
		foreach ($line as $col_value) {
			$threadpost[$pos] = "$col_value";
			$pos++;
		}	
		/*
		$xmlthread = $xmlthread.'		
			<userpost>
	 			<topicid>'.$threadpost[0].'</topicid>
	 			<memberid>'.$threadpost[1].'</memberid>
	 			<membername>'.$threadpost[2].'</membername>
	 			<timeposted>'.$threadpost[3].'</timeposted>
	 			<memberemail>'.$threadpost[4].'</memberemail>
	 			<memberip>'.$threadpost[5].'</memberip>
	 			<postsubject>'.$threadpost[6].'</postsubject>
	 			<postbody>'.$threadpost[7].'</postbody>
	 			<posticon>'.$threadpost[8].'</posticon>
			</userpost>
			';*/

		$ForumThread[$ThreadCount] = new ForumThread($threadpost[0], $threadpost[1], $threadpost[2], $threadpost[3], $threadpost[4], $threadpost[5], $threadpost[6], $threadpost[7], $threadpost[8]
				,$threadpost[10], $threadpost[11] );
		
	 	$ThreadCount =	$ThreadCount + 1;
	
	}
 	
// 	$xmlthread = $xmlthread.'</thread>';
 	
 	//return $xmlthread;
 	return $ForumThread;	
 }

/**
 * Get Topic Pages
 *
 */
function GetTopicPages($dbc, $branchid = '0', $userid = '0', $Mature='0')
 {	
 
$xmltopics = '<topics>';
 	
 	$query =  "SELECT PageID, Name, Type, FanCan, Branch, CreatedBy, Picture, DatePosted,
 						SD.IsPublic, SD.IsMature, SD.IsRemoved FROM Page join SubmissionData as SD
 						on Page.PageID = SD.SubmissionID
					where SD.SubmissionType = 'Page' and 
						Branch = '$branchid' and (SD.IsPublic = '1' or CreatedBy = '$userid')
						and SD.IsMature = '$Mature' and SD.IsRemoved = '0'";

	$result = mysqli_query($dbc, $query) or die('Query failed: ' . mysqli_error($dbc));

	while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		$topiclist = array();
		$pos = 0;
		foreach ($line as $col_value) {
			$topiclist[$pos] = "$col_value";
			$pos++;
		}	

$xmlnames = GetTopicNames($dbc, $topiclist[0], $userid);		
		
		$xmltopics = $xmltopics.'		
			<topic>
	 			<pageid>'.$topiclist[0].'</pageid>
	 			<name>'.$topiclist[1].'</name>
	 			'.$xmlnames.'
	 			<type>'.$topiclist[2].'</type>
	 			<fancan>'.$topiclist[3].'</fancan>
	 			<branch>'.$topiclist[4].'</branch>
	 			<createdby>'.$topiclist[5].'</createdby>
	 			<picture>'.$topiclist[6].'</picture>
	 			<dateposted>'.$topiclist[7].'</dateposted>
	 			<ispublic>'.$topiclist[8].'</ispublic>
	 			<ismature>'.$topiclist[9].'</ismature>
	 			<isremoved>'.$topiclist[10].'</isremoved>
			</topic>
			';
	}
 	
 	$xmltopics = $xmltopics.'</topics>';
 	
 	return $xmltopics;	 
 
 }
 
 
/**
 * Get Fandoms
 *
 * Depreciated
 */
function GetFandoms($db_connection)
 {	
	$Fandoms = new FanbaseList();
 	
 	$query =  "SELECT Branch.BranchID, ParentBranchID, BranchName, official, logo, BranchPublic, levelsdown 
				from Branch join FandomBranchHack as fbh on Branch.BranchID = fbh.BranchID
					order by levelsdown,official desc, ParentBranchID,  BranchName";

	$result = mysqli_query($db_connection, $query) or die('Query failed: ' . mysqli_error($db_connection));

	while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		$topiclist = array();
		$pos = 0;
		foreach ($line as $col_value) {
			$topiclist[$pos] = "$col_value";
			$pos++;
		}	
		
		$Fandoms->add($topiclist[0], $topiclist[1], $topiclist[2], $topiclist[3], $topiclist[4], $topiclist[5]);
	}
 	
	return $Fandoms;
 	 
 }

 /*
 Get fanfacts by newest post.
 */
 function getThreadList()
 {
 global $db_connection;
 $xmlreturn = "";
 $subdomfilter = "";
 
 $query = "SELECT f.FactID, f.Contents, f.DatePosted, s.ID, s.SubmissionType, s.TimeSubmitted, s.IsPublic, count(`id_msg`), `id_topic_type`, `poster_time`, `id_member`, `poster_name`, `body`, `approved` FROM (((`CommunityPosts` as cp join Fact as f on f.FactID = cp.id_topic) join SubmissionData as s on f.FactID = s.SubmissionID) join FactBranch as fb on fb.FactID = f.FactID )join Branch as b on fb.BranchID = b.BranchID WHERE ".$subdomfilter." s.IsPublic = '1' and approved = 1 and id_topic_type = 'fanfact' group by id_topic order by poster_time desc";
 
 $result = mysqli_query($db_connection, $query) or die('Query failed: ' . mysqli_error($db_connection));
		
$rt = GetFactXML($result, $userid, $db_connection);
/*
	while ($line = mysqli_fetch_array($result, MYSQL_ASSOC)) {
		$threadlist = array();
		$pos = 0;
		foreach ($line as $col_value) {
			$threadlist[$pos] = "$col_value";
			$pos++;
		}	
		
		$xmlreturn = $xmlreturn.'		
			<thread>
	 			
	 			<postcount>'.$threadlist[7].'</postcount>
			</thread>';
	}
	
	$xmlreturn = XMLWrapping($xmlreturn, "threads");
			*/
//	return $xmlreturn;
	return $rt;
 }
 
/*
 Determine if something has been starred.
	$type - determines if it is a discussion piece or a submission piece
	$id - the id of the item
	$UserIsViewing - optional - updates the "last viewed" if it's actual page is being viewed
 */
 function checkStar($type, $id, $UserIsViewing = false)
 {
 global $db_connection;
 global $userid;
 $output = false;
 
//echo "type=".$type." & id=".$id."</br>"; 
 
$query = "Select DateSaved, LastViewed from StarList where UserID = '$userid' and isStarred='1' and ";

if ($type == "submissionID")
	$query = $query." SubmissionID = '$id';";
else if ($type == "postID")
	$query = $query." CommunityPostID = '$id';";
	 
	// echo $query."<br/>";
	 $result = mysqli_query($db_connection, $query) or die('Query failed: ' . mysqli_error($db_connection));

$line = mysqli_fetch_array($result, MYSQL_ASSOC);

		if(!is_null($line))
		{
			$output = $line['DateSaved'];			
			}


	return $output;
	 
 } 
 
 /**
 * adds xml information around a string
 *
 * @param $StringToMakeXML 		The string to put the xml header and footer around
 * @param $ParentTagName		[OPTIONAL] Names the parent tag. Optional. (defaults to myxml)
 * 
 * @author Ryan Young
 * @since May 31 2013
 * @version 1.0.0
**/
function XMLWrapping($StringToMakeXML, $ParentTagName = 'myxml')
{
return <<<XML
<?xml version="1.0" encoding="ISO-8859-1"?>
<$ParentTagName>
	$StringToMakeXML
</$ParentTagName>
XML;
}
 
?>
