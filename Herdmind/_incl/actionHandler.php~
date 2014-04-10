<?php
error_reporting(E_ALL);
include $_SERVER['DOCUMENT_ROOT']."/_incl/config.php";				// Get database connection
include $_SERVER['DOCUMENT_ROOT']."/_incl/classes.php";				// Get classes ready
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";        // Start session and determine subdomain


/////////////////////
/////////////////////
/////////////////////
//TODO: Change ALL gets to posts.

//Check the post command for what function needs to be called, and call it.

echo "If you are seeing this page, you must hit the back button due to the proper AJAX functions not being made yet.";

/**
 * This is not a function, but could be made into one.
 * It uses the $_GET['func'] argument to determine what needs to be done, and calls the appropriate method.
**/


$func = mysqli_real_escape_string($db_connection, $_GET['func']);
echo "<hr/>(get) Function: ".$func."<br/>";

if($func == "FanfactVote")
{
echo recordVote();
}
elseif($func == "Comment")
{
echo saveComment();
}
elseif($func == "NewFanfact")
{
echo CreateFanfact();
}
elseif($func == "NewTopic")
{
echo CreateTopic();
}
elseif($func == "NewThread")
{
echo CreateThread();
}
elseif($func == "StarClick")
{
echo StarClick();
}
elseif($func == "Preview")
{
echo GeneratePreview();
}
elseif($func == "UploadAvatar")
{
echo uploadAvatar();
}
elseif($func == "UploadBanner")
{
echo uploadBanner();
}
/////////////////////
/////////////////////
/////////////////////

function GeneratePreview()
{
	global $db_connection;
	global $userid;
	$text = mysqli_real_escape_string($db_connection, $_POST['text']);
//	ob_end_clean();
	echo TitleFiller($text, $db_connection);

}


function uploadAvatar()
{
	global $db_connection;
	global $userid;	
	
$path = "../_img/uploaded/user/".$userid."/";

if ((($_FILES["file"]["type"] == "image/png")
|| ($_FILES["file"]["type"] == "image/jpeg"))
&& ($_FILES["file"]["size"] < 5242880))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "There was a problem with the image provided. Contact a global mod if the exact image is important.<br/>";// . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
 //   echo "Upload: " . $_FILES["file"]["name"] . "<br />";
   // echo "Type: " . $_FILES["file"]["type"] . "<br />";
  //  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    //echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
echo $_FILES["file"]["name"];
    if (file_exists($path . $_FILES["file"]["name"]))
      {
   //   echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {

	$filename = $_FILES["file"]["type"];
$pos = strpos($filename, "/");

// Note our use of ===.  Simply == would not work as expected
// because the position of 'a' was the 0th (first) character.
if ($pos === false) {
 //   echo "The /  was not found in the string '$filename'";
	$imagesrc = $path."noimg.png";
} else {
 //   echo "The / was found in the string '$filename'";
   // echo " and exists at position $pos";
	
	$filename = "avatar64.png";

	if(file_exists($path . $filename)) {
	    chmod($path . $filename,0755); //Change the file permissions if allowed
	    unlink($path . $filename); //remove the file
	}




//imagecopyresized($path.$filename, $_FILES["file"]["tmp_name"], 0, 0, 0, 0, 64, 64, $width, $height);

// Content type
//ob_end_clean();
//header('Content-Type: image/jpeg');

// Get new sizes
list($width, $height) = getimagesize($_FILES["file"]["tmp_name"]);
$newwidth = 64;
$newheight = 64;

// Load
$thumb = imagecreatetruecolor($newwidth, $newheight);

$file_parts = pathinfo($_FILES["file"]["tmp_name"]);
switch($file_parts['extension'])
{
    case "jpg":
	 $source = imagecreatefromjpeg($_FILES["file"]["tmp_name"]);
    break;

	 case "jpeg":
	 $source = imagecreatefromjpeg($_FILES["file"]["tmp_name"]);
    break;

    case "png":
    $source = imagecreatefrompng($_FILES["file"]["tmp_name"]);
    break;

    case "": // Handle file extension for files ending in '.'
    case NULL: // Handle no file extension
    break;
}



// Resize
imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

// Output
imagepng($thumb,$path . $filename);




//      move_uploaded_file($_FILES["file"]["tmp_name"], $path . $filename);

  //    echo "Stored in: " . $filename;

	 //Resizing the picture
//    include "../phpfunctions/imageResizer.php";

//smart_resize_image($imagesrc, 64,64, true);	

//ob_end_clean();
//header("Location: ../_incl/resizedImage.php?i=".$path.$filename."&w=64&h=64");

	}
      }
    }
  }
else
  {
  		$imagesrc = $path."/noimg.png";

  echo "There was a problem with the image provided. Contact a global mod if the exact image is important.";
  }


}


function uploadBanner()
{
	global $db_connection;
	global $userid;	
	
$path = "../_img/uploaded/user/".$userid."/";

if ((($_FILES["file"]["type"] == "image/png")
|| ($_FILES["file"]["type"] == "image/jpeg"))
&& ($_FILES["file"]["size"] < 5242880))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "There was a problem with the image provided. Contact a global mod if the exact image is important.<br/>";// . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
 //   echo "Upload: " . $_FILES["file"]["name"] . "<br />";
   // echo "Type: " . $_FILES["file"]["type"] . "<br />";
  //  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    //echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
echo $_FILES["file"]["name"];
    if (file_exists($path . $_FILES["file"]["name"]))
      {
   //   echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {

	$filename = $_FILES["file"]["type"];
$pos = strpos($filename, "/");

// Note our use of ===.  Simply == would not work as expected
// because the position of 'a' was the 0th (first) character.
if ($pos === false) {
 //   echo "The /  was not found in the string '$filename'";
	$imagesrc = $path."noimg.png";
} else {
 //   echo "The / was found in the string '$filename'";
   // echo " and exists at position $pos";
	
	$filename = "premium-header.png";


	if(file_exists($path . $filename)) {
	    chmod($path . $filename,0755); //Change the file permissions if allowed
	    unlink($path . $filename); //remove the file
	}

      move_uploaded_file($_FILES["file"]["tmp_name"],
      $path . $filename);
      $imagesrc = $path . $filename;

	}
      }
    }
  }
else
  {
  		$imagesrc = $path."/noimg.png";

  echo "There was a problem with the image provided. Contact a global mod if the exact image is important.";
  }


}


function StarClick()
{
	global $db_connection;
	global $userid;
	$id = mysqli_real_escape_string($db_connection, $_POST['SubmissionID']);
	
	//Todo: if SubmissionID is 0 then it should check if a thread was faved and use that instead.

	ob_end_clean();		

	if($userid != 0 && $id !=0)
	{
		$findit = "select UserID, SubmissionID, IsStarred, IsSubscribed from StarList where UserID='$userid' and SubmissionID = '$id'";		
		$found = mysqli_query($db_connection, $findit);	
		$line = mysqli_fetch_array($found, MYSQL_ASSOC);
				
		//ob_end_clean();
		if(isset($line['IsStarred']))
		{
			if($line['IsStarred'] == 0)
			{
				$query = "Update StarList set IsStarred='1', IsSubscribed='1' where UserID='$userid' and SubmissionID='$id';";
				$result = mysqli_query($db_connection, $query);
				echo "add";
			}		  		
			elseif($line['IsStarred'] == 1) 
			{
				$query = "Update StarList set IsStarred='0' where UserID='$userid' and SubmissionID='$id';";
				$result = mysqli_query($db_connection, $query);
				echo "remove";
		  	}
	  	}
		else 
		{
			$query = "INSERT INTO StarList (`UserID`, `SubmissionID`) VALUES ('$userid', '$id')";
			$result = mysqli_query($db_connection, $query);
			echo "add";
		}		
	}
	else {
		echo "error: userid=$userid and submissionid=$id";	
	}

}


/**
 * Submits a new topic for approval.
 * 
 * @param $_POST['']			
 * @param $_POST['']	
 * 
 * @author Ryan Young
 * @since 2014-01-13
 * @version 1.0
**/
function CreateTopic()
{
	global $db_connection;
	global $userid;
	
	$title = mysqli_real_escape_string($db_connection, htmlentities($_POST['title']));
	$title = str_replace("'","&#39;",str_replace('"',"&#34;",$title));
	$type = mysqli_real_escape_string($db_connection, htmlentities($_POST['type']));
	$type = str_replace("'","&#39;",str_replace('"',"&#34;",$type));
	$series = mysqli_real_escape_string($db_connection, htmlentities($_POST['series']));
	$series = str_replace("'","&#39;",str_replace('"',"&#34;",$series));
	$reality = mysqli_real_escape_string($db_connection, htmlentities($_POST['reality']));
	$reality = str_replace("'","&#39;",str_replace('"',"&#34;",$reality));
	$summary = mysqli_real_escape_string($db_connection, htmlentities($_POST['summary']));
	$summary = str_replace("'","&#39;",str_replace('"',"&#34;",$summary));
$color = "";

$imagesrc = "../_img/uploaded/topics/noimg.png";


if( $title != "")
{

		
$query = "INSERT INTO Page (Name ,Type ,FanCan ,PageContents ,CreatedBy , PrimaryColor, Picture, Branch)values('$title','$type','$reality','$summary','$userid','$color','$imagesrc','$series')";
//echo "one<br/>";
//echo $query;
//echo "<br/>$mysql_database<br/>";
$result = mysqli_query($db_connection, $query) or die('Query failed: ' . mysqli_error($db_connection));
$pageid = mysqli_insert_id($db_connection);
$query =  "INSERT INTO PageTitles(PageID,Title,CreatedBy) values('".$pageid."','$title', '$userid')";
//echo "two<br/>";
$result = mysqli_query($db_connection, $query) or die('Query failed: ' . mysqli_error($db_connection));

$queryraffle = "insert into SubmissionData (SubmissionID, SubmissionType, UserID, BonusReason) values ('".$pageid."','Page','$userid','NoBonus') ";
//echo "This: <br/>".$queryraffle."<br/>";
$ret = mysqli_query($db_connection, $queryraffle) or die('Query failed: ' . mysqli_error($db_connection));

//echo $_FILES["file"]["name"];
if ((($_FILES["file"]["type"] == "image/png")
|| ($_FILES["file"]["type"] == "image/jpeg"))
&& ($_FILES["file"]["size"] < 5242880))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "There was a problem with the image provided. Contact a global mod if the exact image is important.<br/>";// . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
 //   echo "Upload: " . $_FILES["file"]["name"] . "<br />";
   // echo "Type: " . $_FILES["file"]["type"] . "<br />";
  //  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    //echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

    if (file_exists("../_img/uploaded/topics/" . $_FILES["file"]["name"]))
      {
   //   echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {

	$filename = $_FILES["file"]["type"];
$pos = strpos($filename, "/");

// Note our use of ===.  Simply == would not work as expected
// because the position of 'a' was the 0th (first) character.
if ($pos === false) {
 //   echo "The /  was not found in the string '$filename'";
	$imagesrc = "../_img/uploaded/topics/noimg.png";
} else {
 //   echo "The / was found in the string '$filename'";
   // echo " and exists at position $pos";
	
	$filename = $pageid.".".substr($filename, strlen($filename) - $pos + 2);

      move_uploaded_file($_FILES["file"]["tmp_name"],
      "../_img/uploaded/topics/" . $filename);
      $imagesrc = "../_img/uploaded/topics/" . $filename;
  //    echo "Stored in: " . $filename;

	 //Resizing the picture
  //  include "../phpfunctions/imageResizer.php"; //It's been copied to this file.

smart_resize_image($imagesrc, 200,200, true);	

	}
      }
    }
  }
else
  {
  		$imagesrc = "../_img/uploaded/topics/noimg.png";

  echo "There was a problem with the image provided. Contact a global mod if the exact image is important.";
  }
		
$query = "update Page set Picture = '$imagesrc' where PageID = '".$pageid."'";
$result = mysqli_query($db_connection, $query) or die('Query failed: ' . mysqli_error($db_connection));



	
}
}

//Pulled from     include "../phpfunctions/imageResizer.php"; in the old code.
//should be looked at for possible improvements.
function smart_resize_image( $file, $width = 0, $height = 0, $proportional = false, $output = 'file', $delete_original = true, $use_linux_commands = false )
  {
  ini_set('memory_limit', '-1');
    if ( $height <= 0 && $width <= 0 ) {
      return false;
    }

    $info = getimagesize($file);
    $image = '';

    $final_width = 0;
    $final_height = 0;
    list($width_old, $height_old) = $info;

    if ($proportional) {
      if ($width == 0) $factor = $height/$height_old;
      elseif ($height == 0) $factor = $width/$width_old;
      else $factor = min ( $width / $width_old, $height / $height_old);   

      $final_width = round ($width_old * $factor);
      $final_height = round ($height_old * $factor);

    }
    else {
      $final_width = ( $width <= 0 ) ? $width_old : $width;
      $final_height = ( $height <= 0 ) ? $height_old : $height;
    }

    switch ( $info[2] ) {
      case IMAGETYPE_GIF:
        $image = imagecreatefromgif($file);
      break;
      case IMAGETYPE_JPEG:
        $image = imagecreatefromjpeg($file);
      break;
      case IMAGETYPE_PNG:
        $image = imagecreatefrompng($file);
      break;
      default:
        return false;
    }
    
    $image_resized = imagecreatetruecolor( $final_width, $final_height );
        
    if ( ($info[2] == IMAGETYPE_GIF) || ($info[2] == IMAGETYPE_PNG) ) {
      $trnprt_indx = imagecolortransparent($image);
   
      // If we have a specific transparent color
      if ($trnprt_indx >= 0) {
   
        // Get the original image's transparent color's RGB values
        $trnprt_color    = imagecolorsforindex($image, $trnprt_indx);
   
        // Allocate the same color in the new image resource
        $trnprt_indx    = imagecolorallocate($image_resized, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);
   
        // Completely fill the background of the new image with allocated color.
        imagefill($image_resized, 0, 0, $trnprt_indx);
   
        // Set the background color for new image to transparent
        imagecolortransparent($image_resized, $trnprt_indx);
   
      
      } 
      // Always make a transparent background color for PNGs that don't have one allocated already
      elseif ($info[2] == IMAGETYPE_PNG) {
   
        // Turn off transparency blending (temporarily)
        imagealphablending($image_resized, false);
   
        // Create a new transparent color for image
        $color = imagecolorallocatealpha($image_resized, 0, 0, 0, 127);
   
        // Completely fill the background of the new image with allocated color.
        imagefill($image_resized, 0, 0, $color);
   
        // Restore transparency blending
        imagesavealpha($image_resized, true);
      }
    }

    imagecopyresampled($image_resized, $image, 0, 0, 0, 0, $final_width, $final_height, $width_old, $height_old);
  
    if ( $delete_original ) {
      if ( $use_linux_commands )
        exec('rm '.$file);
      else
        @unlink($file);
    }
    
    switch ( strtolower($output) ) {
      case 'browser':
        $mime = image_type_to_mime_type($info[2]);
        header("Content-type: $mime");
        $output = NULL;
      break;
      case 'file':
        $output = $file;
      break;
      case 'return':
        return $image_resized;
      break;
      default:
      break;
    }

    switch ( $info[2] ) {
      case IMAGETYPE_GIF:
        imagegif($image_resized, $output);
      break;
      case IMAGETYPE_JPEG:
        imagejpeg($image_resized, $output);
      break;
      case IMAGETYPE_PNG:
        imagepng($image_resized, $output);
      break;
      default:
        return false;
    }

    return true;
  }




/**
 * Submits a new fanfact for approval.
 * 
 * @param $_POST['facttext']		the text that makes the fact
 * @param $_POST['fandomid']		the series to list it under
 * 
 * @author Ryan Young
 * @since 2014-01-09
 * @version 1.0
**/
function CreateFanfact()
{

	global $db_connection;
	global $userid;
	
	if($userid != "")
	{
		$contents = mysqli_real_escape_string($db_connection, htmlentities($_POST['facttext']));
		$facttype = mysqli_real_escape_string($db_connection, htmlentities($_POST['facttype']));
		$fandomid = mysqli_real_escape_string($db_connection, htmlentities($_POST['fandomid']));
		//print($contents);
		$contents = str_replace('"',"&#34;",$contents);
		$contents = str_replace("'","&#39;",$contents);
		
		$fandomid = str_replace('"',"&#34;",$fandomid);
		$fandomid = str_replace("'","&#39;",$fandomid);

		if( $contents != "")
		{
			$query =  "INSERT INTO Fact(Contents,CreatedBy,Type) values('$contents', '$userid','$facttype')";

			print($query);
			$result = mysqli_query($db_connection, $query) or die('Query failed: ' . mysqli_error($db_connection));

			if($result == 1)
			{
				$factid = mysqli_insert_id($db_connection);
				$queryraffle = "insert into SubmissionData (SubmissionID, SubmissionType, UserID, BonusReason, IsPublic) values ('".$factid."','Fact','$userid','NoBonus', '1') ";
				$ret = mysqli_query($db_connection, $queryraffle) or die('Query failed: ' . mysqli_error($db_connection));
				
				$query =  "INSERT INTO FactBranch (FactID, BranchID) VALUES ('".$factid."', '".$fandomid."');";
				$result = mysqli_query($db_connection, $query) or die('Query failed: ' . mysqli_error($db_connection));
			}
		
		}
	}
}

/**
 * Records that a user has hit the vote button.
 * 
 * @param $_POST['factID']		the id of the fact voted on
 * @param $_POST['usersVote']	the vote value
 * 
 * @author Ryan Young
 * @since 2013-11-32
 * @version 1.0
**/
function recordVote()
{

global $db_connection;
global $userid;
global $ipid;


//Get fact ID and vote value
$factid = mysqli_real_escape_string($db_connection, $_POST['factID']);
$usersVote = mysqli_real_escape_string($db_connection, $_POST['usersVote']);

//TODO:
//Make SURE that $usersVote is either a +1, -1, or 0


if($userid == "")
{
//IP address



$killold = "delete from FactScoreByTally where FactID = '".abs($factid)."' and UserPoint = '' and IPvoteID = '".$ipid."';";
	$run = mysqli_query($db_connection, $killold) or die('Query failed: ' . mysqli_error($db_connection));
	//Vote. //Userpoint is represented by UserID.
	$newvote = "INSERT INTO FactScoreByTally (FactID,DatePointScored,UserPoint,Value,IPvoteID)VALUES ('".abs($factid)."', NOW( ) ,  '', '".$usersVote."','".$ipid."')";
	
	$run = mysqli_query($db_connection, $newvote) or die('Query failed: ' . mysqli_error($db_connection));
}
else
{
//Logged in user
$tallymark = $userid; 

$killold = "delete from FactScoreByTally where FactID = '".abs($factid)."' and UserPoint = '$tallymark';";
	$run = mysqli_query($db_connection, $killold) or die('Query failed: ' . mysqli_error($db_connection));
	//Vote. //Userpoint is represented by UserID.
	$newvote = "INSERT INTO FactScoreByTally (FactID,DatePointScored,UserPoint,Value,IPvoteID)VALUES ('".abs($factid)."', NOW( ) ,  '$tallymark', '".$usersVote."','".$ipid."')";
	//				ON DUPLICATE KEY UPDATE 
	//			DatePointScored, Value, IPvoteID =VALUES(NOW( ),'".$posneg."1','".$ipid."')";
//echo $newvote;
	$run = mysqli_query($db_connection, $newvote) or die('Query failed: ' . mysqli_error($db_connection));
}

echo "Query is ".$newvote;


}

/**
 * Records a thread that has no votes
 * 
 * Don't remember how it works. Whoops.
 * TODO: update documentation when possible
 * 
 * @author Ryan Young
 * @since 2014-03-19
 * @version 1.0
**/
function CreateThread()
{

global $db_connection;
global $userid;
global $userName;
global $ipid;

echo "Getting information...";
$fandomid = mysqli_real_escape_string($db_connection, $_POST['fandomid']);

$comment = mysqli_real_escape_string($db_connection, htmlentities($_POST['comment']));
//$comment = str_replace("'","&#39;",str_replace('"',"&#34;",$comment));


$ip = mysqli_real_escape_string($db_connection, htmlentities($_SERVER['REMOTE_ADDR']));
//$ip = str_replace("'","&#39;",str_replace('"',"&#34;",$id));

/*
Array Elements of $msgOptions
Key 				Optional 	Expected type 		Description
body 				no 			Escaped String 		The message itself
id	 				no 								the id of what's being commented on
pagetype 				no 						 		fanfact, fanwork, profile - what kind of page the comment appears on
*/

echo " ...DONE<br/>";

echo " Posting...";


$CommentingQuery = "INSERT INTO `CommunityPosts` (
`poster_time` ,
`id_topic_type` ,
`id_member` ,
`id_msg_modified` ,
`subject` ,
`poster_name` ,
`poster_email` ,
`poster_ip` ,
`smileys_enabled` ,
`modified_time` ,
`modified_name` ,
`body` ,
`icon` ,
`approved` ,
`fandom`
)
VALUES (
 NOW(), 'Thread', '".$userid."', '0', '', '".$userName."', '', '".$ip."', '1', '0', '', '".$comment."', 'xx', '1', '$fandomid'
);";
echo $CommentingQuery;
	
	$result = mysqli_query($db_connection, $CommentingQuery) or die('Query failed: ' . mysqli_error($db_connection));

mysqli_query($db_connection, "UPDATE `CommunityPosts` SET `id_topic` = '".$db_connection->insert_id."' WHERE `CommunityPosts`.`id_msg` = '".$db_connection->insert_id."';");

echo " ...DONE<br/>";

echo (isset($result) ? "Success!" : "Failed.");
}


/**
 * Records a user's comment
 * 
 * Don't remember how it works. Whoops.
 * TODO: update documentation when possible
 * 
 * @author Ryan Young
 * @since 2013-11-32
 * @version 1.0
**/
function saveComment()
{
global $db_connection;
global $userid;
global $userName;
global $ipid;

echo "Getting information...";
$fandomid = mysqli_real_escape_string($db_connection, $_POST['fandomid']);


$comment = mysqli_real_escape_string($db_connection, htmlentities($_POST['comment']));
//$comment = str_replace("'","&#39;",str_replace('"',"&#34;",$comment));

$id = mysqli_real_escape_string($db_connection, $_POST['id']);
//$id = mysqli_real_escape_string($db_connection, htmlentities($_POST['id']));
//$id = str_replace("'","&#39;",str_replace('"',"&#34;",$id));

$pagetype = mysqli_real_escape_string($db_connection, htmlentities($_POST['topictype']));
//$pagetype = str_replace("'","&#39;",str_replace('"',"&#34;",$pagetype));


echo " ...DONE<br/>";

echo "Filling arrays...";

$msgOptions = array(); 
$msgOptions[0] = $comment;
$msgOptions[1] = $id;
$msgOptions[2] = $pagetype;

$ip = mysqli_real_escape_string($db_connection, htmlentities($_SERVER['REMOTE_ADDR']));
//$ip = str_replace("'","&#39;",str_replace('"',"&#34;",$id));

/*
Array Elements of $msgOptions
Key 				Optional 	Expected type 		Description
body 				no 			Escaped String 		The message itself
id	 				no 								the id of what's being commented on
pagetype 				no 						 		fanfact, fanwork, profile - what kind of page the comment appears on
*/

echo " ...DONE<br/>";

echo " Posting...";


$CommentingQuery = "INSERT INTO `CommunityPosts` (
`id_topic` ,
`id_topic_type` ,
`poster_time` ,
`id_member` ,
`id_msg_modified` ,
`subject` ,
`poster_name` ,
`poster_email` ,
`poster_ip` ,
`smileys_enabled` ,
`modified_time` ,
`modified_name` ,
`body` ,
`icon` ,
`approved` ,
`fandom`
)
VALUES (
'".$msgOptions[1]."', '".$msgOptions[2]."', NOW(), '".$userid."', '0', '', '".$userName."', '', '".$ip."', '1', '0', '', '".$msgOptions[0]."', 'xx', '1', '$fandomid'
);";
echo $CommentingQuery;
	
	$result = mysqli_query($db_connection, $CommentingQuery) or die('Query failed: ' . mysqli_error($db_connection));



echo " ...DONE<br/>";

echo (isset($result) ? "Success!" : "Failed.");
}

?>
