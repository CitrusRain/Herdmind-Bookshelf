<?php

echo "<!--classes.php imported-->";

class Stylesheet
{
	function __construct($url, $name)
	{
		$this->url = $url;
		$this->name = $name;
	}
}

class Stream
{
	function __construct($ThreadArray, $FanfactArray)
	{
		$this->commentthreads = $ThreadArray;
		$this->fanfacts = $FanfactArray;
	}
}

/**
 * Contains convenience methods and constants for encoding and decoding backgrounds into the Herdmind database
 * 
 * @author Kyli Rouge
 * @since 2014-04-07
 * @version 1.0.0
 */
class BG
{
	const REPEAT_MASK = 1;   // 0000_0001
	const POSITION_MASK = 6; // 0000_0110
		const POSITION_LEFT = 0;   // 0000_0000
		const POSITION_CENTER = 2; // 0000_0010
		const POSITION_RIGHT = 4;  // 0000_0100
	const SIZE_MASK = 24;    // 0001_1000
		const SIZE_ORIGINAL = 0;   // 0000_0000
		const SIZE_COVER = 8;      // 0000_1000
		const SIZE_CONTAIN = 16;   // 0001_0000
		const SIZE_STRETCH = 24;   // 0001_1000
	
	/**
	 * Returns the repeat bit contained in the given encoded background state
	 * @return 1 (repeat) or 0 (do not repeat)
	 * @author Kyli Rouge
	 * @since 2014-04-07
	 * @version 1.0.0
	 */
	public static function repeats($bgState)
	{
		return $bgState & BG::REPEAT_MASK;
	}
	
	/**
	 * Returns the position bits contained in the given encoded background state
	 * @return one of the following:
	 * 		BG::POSITION_LEFT   (0) 
	 * 		BG::POSITION_CENTER (2)
	 * 		BG::POSITION_RIGHT  (4)
	 * @author Kyli Rouge
	 * @since 2014-04-07
	 * @version 1.0.0
	 */
	public static function getPosition($bgState)
	{
		return $bgState & BG::POSITION_MASK;
	}
	
	/**
	 * Returns the size bits contained in the given encoded background state
	 * @return one of the following:
	 * 		BG::SIZE_ORIGINAL (0)
	 * 		BG::SIZE_COVER    (8)
	 * 		BG::SIZE_CONTAIN  (16)
	 * 		BG::SIZE_STRETCH  (24)
	 * @author Kyli Rouge
	 * @since 2014-04-07
	 * @version 1.0.0
	 */
	public static function getSize($bgState)
	{
		return $bgState & BG::SIZE_MASK;
	}
	
	/**
	 * Returns the HTML classes for the given byte representation of a background's modifiers
	 * 
	 * @param $bgState   the background state, as a byte.
	 * 		Bit map:
	 * 			0: repeat?       (BG::REPEAT_MASK)
	 * 				0: no
	 * 				1: yes
	 * 			1-2: position    (BG::POSITION_MASK)
	 * 				00: left     (BG::POSITION_LEFT)
	 * 				01: center   (BG::POSITION_CENTER)
	 * 				10: right    (BG::POSITION_RIGHT)
	 * 				11: [unused]
	 * 			3-4: size        (BG::SIZE_MASK)
	 * 				00: original (BG::SIZE_ORIGINAl)
	 * 				01: cover    (BG::SIZE_COVER)
	 * 				10: contain  (BG::SIZE_CONTAIN)
	 * 				11: stretch  (BG::SIZE_STRETCH)
	 * 			5-7: [unused]
	 * @return a string containing all the classes to put in an HTML CLASS attribute to position the background
	 * @author Kyli Rouge
	 * @since 2014-04-07
	 * @version 1.0.0
	 */
	public static function decode($bgState)
	{
		$output =
			BG::repeats($bgState)
				? 'bg-repeat-yes'
				: 'bg-repeat-no '
		;

		switch (BG::getPosition($bgState))
		{
			case BG::POSITION_LEFT:
				$output .= ' bg-pos-left  ';
				break;
			case BG::POSITION_CENTER:
				$output .= ' bg-pos-center';
				break;
			case BG::POSITION_RIGHT:
				$output .= ' bg-pos-right ';
				break;
			default:
				$output .= '              ';
				break;
		}

		switch (BG::getSize($bgState))
		{
			case BG::SIZE_ORIGINAL:
				$output .= ' bg-size-original';
				break;
			case BG::SIZE_COVER:
				$output .= ' bg-size-cover   ';
				break;
			case BG::SIZE_CONTAIN:
				$output .= ' bg-size-contain ';
				break;
			case BG::SIZE_STRETCH:
				$output .= ' bg-size-stretch ';
				break;
			default:
				$output .= '                 ';
				break;
		}

		return $output;
	}
	
	/**
	 * Returns the byte for the given background modifiers
	 * 
	 * @param $repeats
	 * 		0: repeat
	 * 		1: do not repeat
	 * @param $position
	 * 		0: left     (BG::POSITION_LEFT)
	 * 		2: center   (BG::POSITION_CENTER)
	 * 		4: right    (BG::POSITION_RIGHT)
	 * @param $size
	 * 		0: original  (BG::SIZE_ORIGINAl)
	 * 		8: cover     (BG::SIZE_COVER)
	 * 		16: contain  (BG::SIZE_CONTAIN)
	 * 		24: stretch  (BG::SIZE_STRETCH)
	 * @return a byte containing bitwise data about the background
	 * @author Kyli Rouge
	 * @since 2014-04-07
	 * @version 1.0.0
	 */
	public static function encode($repeats, $position, $size)
	{
		return $repeats | $position | $size;
	}
}

/**
 * Represents a fanfact
 * 
 * @author Ryan
 * @since 2014-04-06
 */
 class Fanfact
 {	
 		function __construct($factid = 0, $submissionid = 0, $dateposted = 0,
 						$contents = 0, $score = 0, $isstarred = 0, $issubscribed = 0,
 						$uservote = 0, $commentcount = 0, 
 						$isMature = 0, $isRemoved = 0, $isPublic = 1)
 		{
 			$this->factid = $factid;
 			$this->submissionid = $submissionid;
 			$this->dateposted = $dateposted;
 			$this->contents =	$contents;
 			$this->score = $score;
 			$this->isstarred = $isstarred;
 			$this->issubscribed = $issubscribed;
 			$this->uservote = $uservote;
 			$this->commentcount = $commentcount;
 			$this->ismature = $isMature;
 			$this->isremoved = $isRemoved;
 			$this->ispublic = $isPublic;
 		}
 
		function __toString()
		{
			$out = "";
			$out = $out.'
			<DIV
				 CLASS="' . ($this->uservote ? ($this->uservote < 0 ? "down" : "up") . "voted " : "") . "fanfact" . ($classes ? " " . $classes : "") . "\" TABINDEX=\"-1\">
				 ".($shortlink ? "" :"<TABLE CLASS=\"vote\">
					<TBODY>
						<TR>
							<TD ROWSPAN=\"2\">
								<VAR CLASS=\"counter devalert\">$this->score</VAR>
							</TD>
							<TD>
								<INPUT TYPE=\"button\" CLASS=\"upvote\" VALUE=\"&#x25B2;\" onClick='".'takeVote("'.$this->factid.'","+1")'."'/>
							</TD>
						</TR>
						<TR>
							<TD>
								<INPUT TYPE=\"button\" CLASS=\"downvote\" VALUE=\"&#x25BC;\" onClick='".'takeVote("'.$this->factid.'","-1")'."'/>
							</TD>
						</TR>
					</TBODY>
				 </TABLE>")."
				 <DIV CLASS=\"fact\">$this->contents</DIV>
				 <DIV CLASS=\"meta\">
					<SPAN CLASS=\"factNum" . ($shortlink ? ' shortlink' : '') . "\">$this->factid</SPAN>$this->isstarred
					" . ($userid ? '<I id="star'.$this->submissionid.'" CLASS="fa fa-star' . ($this->isstarred != 0 ? '' : '-o') . ($standalone ? ' fa-2x' : '') . "\" DATA-FAVORITE='$userName' onclick='starClick(\"".$this->submissionid."\")'></I>" : '') .
					($moreData ? "<A HREF=\"/fanfact?fandom=".$fandom->fandomid."&id=$this->factid\" CLASS=\"callToAction\">More data</A>" : '') . "
					<!-- This number must be sent to an ajax call to star or unstar: $this->submissionid
					<br/><sub>Edit buildFactXML() in _incl/contentBuilder.php</sub> -->
				</DIV>
			</DIV>";			
			
			return $out;
		}
 
 }
 
 

/**
 * Represents a Herdmind topic
 * 
 * @author Kyli
 * @since June? 2013
 */
class Topic
{
	function __construct($topicIndex, $names, $type, $reality, $canon, $description, $picture, $submissionid = 0, $starred = 0)
	{
		$this->index = $topicIndex;
		$this->names = $names;
		$this->type = $type;
		$this->reality = $reality;
		$this->canon = $canon;
		$this->description = $description;
		$this->picture = $picture;
		$this->submissionid = $submissionid;
		$this->starred = $starred;
	}
	
	function getPrimaryName()
	{
		if (is_array($this->names))
			return $this->names[0];
		return $this->names;
	}
	
	function getAlternateNames()
	{
		if (is_array($this->names))
			return array_slice($this->names, 1);
		return null;
	}
	
	function getType()
	{
		if ($this->type)
			return $this->type;
		return "Unknown";
	}
	
	function getReality()
	{
		if ($this->reality)
			return $this->reality;
		return "Unknown";
	}
	
	function getCanon()
	{
		if ($this->canon)
			return $this->canon;
		return "Unknown";
	}
	
	function getDescription()
	{
		if ($this->description)
			return $this->description;
		return "Unknown";
	}
	
	function getPicture()
	{
		if ($this->picture)
			return $this->picture;
		return "Unknown";
	}
	
	function getFacts()
	{
	/*
	 * Structure of the array:
	 * 	 - [0] the number of the fanfact
	 * 	 - [1] the post date.
	 * 	 - [2] the fact text.
	 * 	 - [3] the sum of votes on the fact.
	 * 	 - [4] the sum of the current user's votes.
	 */
 
		global $db_connection;
		global $userid;
		if (isset($_GET['page']))
			$page = mysqli_real_escape_string($db_connection, $_GET['page']);
		else 
			$page = 0;
			
		if (isset($_GET['limit']))
			$factsperpage = mysqli_real_escape_string($db_connection, $_GET['limit']);
		else 
			$factsperpage = 0;

		$xmlstring = GetFanfacts($_GET["t"], ($page * $factsperpage), 500000, $userid, $db_connection);
		$factxml = new SimpleXMLElement($xmlstring);

		//Loop through each xml element and print it.
		$listing = array();  
		$size = 0;
		foreach($factxml->children() as $child)
		{
		//	$listing[$size++] = buildFact(array($child->factid,$child->dateposted,$child->contents,$child->score,$child->uservote,$child->isstarred), false, true, "cardIn");
			$listing[$size++] = buildFactXML($child, false, true, "cardIn");
		}

		return $listing;

	}
}



/**
 * Represents the name of a Herdmind topic
 * 
 * @author Kyli
 * @since June? 2013
 */
class Name
{
	function __construct($text, $votes)
	{
		$this->text = $text;
		$this->votes = $votes;
	}
	
	function getText()
	{
		return $this->text;
	}
	
	function getVoteCount()
	{
		return $this->votes;
	}
	
	function __toString()
	{
		return $this->getText();
	}
}



/*
*******************************************************************
*******************************************************************
***********************Forum***************************************
*******************************************************************
*******************************************************************
*/

class ForumThread
{
	function __construct($topicid, $memberid, $membername, $timeposted, $memberemail, $memberip, $postsubject, $postbody, $posticon)
	{
		$this->topicid = $topicid;
		$this->memberid = $memberid;
		$this->membername = $membername;
		$this->timeposted = $timeposted;
		$this->memberemail = $memberemail;
		$this->memberip = $memberip;
		$this->postsubject = $postsubject;
		$this->postbody = $postbody;
		$this->posticon = $posticon;
	}

	function getTopicID()
	{
		return $this->topicid;	
	}

	function getMemberID()
	{
		return $this->memberid;	
	}

	function getMemberName()
	{
		return $this->membername;	
	}

	function getTimePosted()
	{
		return $this->timeposted;	
	}

	function getMemberEmail()
	{
		return $this->memberemail;	
	}

	function getMemberIP()
	{
		return $this->memberip;	
	}

	function getPostSubject()
	{
		return $this->postsubject;	
	}

	function getPostBody()
	{
		return $this->postbody;	
	}

	function getPostIcon()
	{
		return $this->posticon;	
	}

	function __toString()
	{
		return $this->getTopicID();
	}


}


class Comments
{
	function __construct($messageid, $topicid, $topictype, $memberid, $membername, $timeposted, $memberemail, $memberip, $postsubject, $postbody, $posticon, $bannersetting, $bannertext = "")
	{
		$this->messageid = $messageid;
		$this->topicid = $topicid;
		$this->topictype = $topictype;
		$this->memberid = $memberid;
		$this->membername = $membername;
		$this->timeposted = $timeposted;
		$this->memberemail = $memberemail;
		$this->memberip = $memberip;
		$this->postsubject = $postsubject;
		$this->postbody = $postbody;
		$this->posticon = $posticon;
		$this->bannersetting = $bannersetting;
		$this->bannertext = $bannertext;
	}

	function getMessageID()
	{
		return $this->messageid;	
	}
	
	function getTopicID()
	{
		return $this->topicid;	
	}
	
	function getTopicType()
	{
		return $this->topictype;	
	}

	function getMemberID()
	{
		return $this->memberid;	
	}

	function getMemberName()
	{
		return $this->membername;	
	}

	function getTimePosted()
	{
		return $this->timeposted;	
	}

	function getMemberEmail()
	{
		return $this->memberemail;	
	}

	function getMemberIP()
	{
		return $this->memberip;	
	}

	function getPostSubject()
	{
		return $this->postsubject;	
	}

	function getPostBody()
	{
		return $this->postbody;	
	}

	function getPostIcon()
	{
		return $this->posticon;	
	}

	function __toString()
	{
		return $this->getMessageID();
	}


}


//Todo: make "comments" regard this as a parent class
class Thread
{
	function __construct($messageid, $memberid, $membername, $timeposted, $memberemail, $memberip, $postsubject, $postbody, $posticon)
	{
		$this->messageid = $messageid;
		$this->memberid = $memberid;
		$this->membername = $membername;
		$this->timeposted = $timeposted;
		$this->memberemail = $memberemail;
		$this->memberip = $memberip;
		$this->postsubject = $postsubject;
		$this->postbody = $postbody;
		$this->posticon = $posticon;
	}

	function getMessageID()
	{
		return $this->messageid;	
	}
	
	function getMemberID()
	{
		return $this->memberid;	
	}

	function getMemberName()
	{
		return $this->membername;	
	}

	function getTimePosted()
	{
		return $this->timeposted;	
	}

	function getMemberEmail()
	{
		return $this->memberemail;	
	}

	function getMemberIP()
	{
		return $this->memberip;	
	}

	function getPostSubject()
	{
		return $this->postsubject;	
	}

	function getPostBody()
	{
		return $this->postbody;	
	}

	function getPostIcon()
	{
		return $this->posticon;	
	}

	function __toString()
	{
		return $this->getMessageID();
	}


}



/**
 * Represents a Herdmind user's profile
 * 
 * @author Ryan
 * @since 2014-01-22
 */
class Member
{
	function __construct($memberid, $username, $type, $bio, $banner, $bannertext = "")
	{
		$this->id = $memberid;
		$this->username = $username;
		$this->type = $type;
		$this->biography = $bio;
		$this->banner = $banner;
		$this->bannertext = $bannertext;
	//	$this->submissions = $submissions;
	}
	
	function getID()
	{
		return $this->id;
	}
	
	function getName()
	{
		return $this->username;
	}

	function getType()
	{
		if ($this->type)
			return $this->type;
		return "Member";
	}
	
	function getBio()
	{
		if ($this->biography)
			return $this->biography;
		return "(No Bio)";
	}
	
	function getAvatar()
	{
		if ($this->avatar)
			return $this->avatar;
		return "(no pic)";
	}
	
	function getBanner()
	{
		if ($this->banner)
			return $this->banner;
		return "Unknown";
	}
	
	
	function getSubmittedFacts()
	{
	/*
	 * Structure of the array:
	 * 	 - [0] the number of the fanfact
	 * 	 - [1] the post date.
	 * 	 - [2] the fact text.
	 * 	 - [3] the sum of votes on the fact.
	 * 	 - [4] the sum of the current user's votes.
	 */
 
		global $db_connection;


	 	$xmlstring = GetSubmissionListByMemberID($this->id);
	 	$factxml = new SimpleXMLElement($xmlstring);

		//Loop through each xml element and print it.
	 	$listing = array();  
	 	$size = 0;
		foreach($factxml->children() as $child)
		{
//			$listing[$size++] = $child;
//			$listing[$size++] = buildFact(array($child->factid,$child->dateposted,$child->contents,$child->score,$child->uservote,$child->isstarred), false, true, "cardIn");
			$listing[$size++] = buildFactXML($child, false, true, "cardIn");		
		}
	
//$listing = "joe";
		return $listing;

	}
}


//Array with keys
//keys are fandom id
/**
 * Represents Herdmind communities and subcommunities 
 * 
 * @author Ryan
 * @since 2014-04-04
 * @version 1.0.1
 * 		- 2014-04-05 (1.0.1) - Kyli changed $out = $out . "..." to $out .= "..."
 */
class FandomListing
{
	/*
		$mode = 
			top - includes the primary communities and their canon communities
			bottom - includes 1 canon community and it's fanon spinoffs.
	*/
	function __construct($mode)
	{
		$this->mode = $mode;
		$this->listing = array(); //Bucketsorted
		$this->listsize = 0;
	}

	function addFandom($fandom)
	{
		if(($fandom->level == 0) || ($fandom->level == 1 && $this->mode == "bottom"))//Make a bucket
		{	
			$this->listing["id".$fandom->fandomid] = $fandom;
			$this->listsize++;
		}
		elseif(($fandom->level == 1 && $this->mode == "top")
				|| ($fandom->level == 2 && $this->mode == "bottom")) //then add it to it's bucket 
		{
			if(isset($this->listing["id".$fandom->parentid]))
			{	$this->listing["id".$fandom->parentid]->addSubFandom($fandom);
			$this->listsize++; }	
		}
	}


	function __toString()
	{
		$out = "";
		if(!empty($this->listing))
		{
			foreach ($this->listing as $value)
			{
				$out .= " - ".((string)$value). "<br/>";
			}
		}
		return $out;
	}

}

//This holds a fandom as well as it's own subfandoms.
class Fandom
{
	
	function __construct($fandomid, $parentid, $fandomname, $level)
	{
		$this->fandomid = $fandomid;
		$this->parentid = $parentid;
		$this->fandomname = $fandomname;
		$this->level = $level;
		$this->subfandoms = array();
		$this->sublistsize = 0;
	}
	
	function addSubFandom($fandom)
	{	
		$this->subfandoms["id".$fandom->fandomid] = $fandom;
		$this->sublistsize++;		
	}

	function __toString()
	{
		$out = $this->level . ". ". $this->fandomname . 
		"<a href='?fandom=".$this->fandomid."'>[link]</a><br/>";
		if(!empty($this->subfandoms))
		{
			foreach ($this->subfandoms as $value)
			{
				$out = $out." - ".((string)$value);
			}
		/*	foreach ($this->subfandoms as $value)
			{
				$out = $out." - ".$value->level . ". ".$value->fandomname. 
				"<a href='?fandom=".$value->fandomid."'>[link]</a><br/>";
			}*/
		}
		return $out;
	}

}



?>