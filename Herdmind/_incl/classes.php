<?PHP

echo "<!--classes.php imported-->";

class Stylesheet
{
	function __construct($url, $name)
	{
		$this->url = $url;
		$this->name = $name;
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

		$xmlstring = GetFanfacts($_GET["t"], ($page * $factsperpage), 500000, $userid, $db_connection);
		$factxml = new SimpleXMLElement($xmlstring);

		//Loop through each xml element and print it.
		$listing = array();  
		$size = 0;
		foreach($factxml->children() as $child)
		{
			$listing[$size++] = buildFact(array($child->factid,$child->dateposted,$child->contents,$child->score,$child->uservote), false, true, "cardIn");
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
	function __construct($messageid, $topicid, $topictype, $memberid, $membername, $timeposted, $memberemail, $memberip, $postsubject, $postbody, $posticon)
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
	function __construct($memberid, $username, $type, $bio, $avatar, $banner)
	{
		$this->id = $memberid;
		$this->username = $username;
		$this->type = $type;
		$this->biography = $bio;
		$this->avatar = $avatar;
		$this->banner = $banner;
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


/*		$xmlstring = GetSubmissionListByMemberID($this->id);
		$factxml = new SimpleXMLElement($xmlstring);

		//Loop through each xml element and print it.
		$listing = array();  
		$size = 0;
		foreach($factxml->children() as $child)
		{
			$listing[$size++] = $child;
			//$listing[$size++] = buildFact(array($child->factid,$child->dateposted,$child->contents,$child->score,$child->uservote), false, true, "cardIn");
		}
*/
$listing = "joe";
		return $listing;

	}
}




?>