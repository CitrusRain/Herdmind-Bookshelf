<?PHP
/* 
 * Basic convenience functions
 * 
 * @since 2013-03-13
 */

require_once "config.php";
//require_once "startSession.php"; Assume calling file included this


// require_once $_SERVER['DOCUMENT_ROOT'].'/_incl/APIs/smf_2_api.php';



// $user = smfapi_getUserByUsername($user_info['username']);
// $userid = $user['id_member'];



/**
 * Returns the given number of random topic indices as an array. These are guaranteed to be valid topic numbers.
 * 
 * @param $numTopics the number of random topic indices to return
 * @return an array of numbers representing topic indices
 * 
 * @author Kyli Rouge (content by Ryan Young)
 * @since 2013-03-13
 * @version 1.0.0
 */
function getRandomTopicIndices($numTopics)
{
	global $db_connection;
	
	$maturefilter = 0; //Still unimplemented feature that will be set in a site settings page. 0 = SFW; 1 = NSFW
	$subdomfilter = " b.subdomain = '$fandom' and ";
	
	$QueryOutput = mysqli_query($db_connection, "SELECT Distinct Page.PageID AS ID
	                                             FROM (Page JOIN SubmissionData ON Page.PageID = SubmissionData.SubmissionID) 
	                                             JOIN Branch AS b ON Page.Branch = b.BranchID 
	                                             WHERE ".$subdomfilter." SubmissionData.isPublic = '1' and SubmissionData.isRemoved = '0' 
	                                             AND ( SubmissionData.IsMature = '0' OR SubmissionData.IsMature = '".$maturefilter."') 
	                                             ORDER BY RAND() LIMIT  0, " . $numTopics);
	
	$ret = array();
	while ($randomTopics = mysqli_fetch_array($QueryOutput, MYSQL_ASSOC))
	{
		array_push($ret, $randomTopics['ID']);
	}
	return $ret;
}

function isUserLoggedIn()
{
	global $user;
	if ($user)
		return true;
	return false;
}

function getUserName()
{
	global $user;
	return $user;
}

function getUserID()
{
	global $userid;
	return $userid;
}

function startsWith($haystack, $needle)
{
	return !strncmp($haystack, $needle, strlen($needle));
}
function endsWith($haystack, $needle)
{
	//echo "\n<!-- \$haystack:$haystack\n\$needle:$needle) -->";
	$length = strlen($needle);
	if ($length == 0) {
		return true;
	}
	
	//echo "\n<!-- return \"" . substr($haystack, -$length) . "\" === \"$needle\" -->";
	return (substr($haystack, -$length) === $needle);
}
function contains($haystack, $needle)
{
	$length = strlen($needle);
	if ($length == 0)
		return true;
	
	for($i = 0, $c = strlen($haystack) - $length; $i < $c; $i++)
		if (substr($haystack, $i, $length) === $needle)
			return true;
	
	return false;
}


function getURL()
{
	$pageURL = 'http';
	if ($_SERVER["HTTPS"] == "on")
		$pageURL .= "s";
	
	$pageURL .= "://";
	if ($_SERVER["SERVER_PORT"] != "80")
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
	else
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	
	return $pageURL;
}

function post($fields)
{
	// use key 'http' even if you send the request to https://...
	$options = array(
		'http' => array(
			  'header'  => "Content-type: application/x-www-form-urlencoded\r\n"
			, 'method'  => 'POST'
			, 'content' => http_build_query($fields)
		),
	);
	$context  = stream_context_create($options);
	//$result = file_get_contents(getURL(), false, $context);

	echo "<!--
	";
	var_dump($result);
	echo "
	-->";
}
?>