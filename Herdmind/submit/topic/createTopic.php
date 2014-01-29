
<!--

	Creates the topic in the background.


-->
<?php
//error_reporting(E_ALL);
session_start();
require_once ('../config.php');
require_once '../forum/APIs/smf_2_api.php';
$user = smfapi_getUserByUsername($user_info['username']);

$userid = $user['id_member']; 

$title = mysql_real_escape_string(htmlentities($_POST['title']));
$title = str_replace("'","&#39;",str_replace('"',"&#34;",$title));
$type = mysql_real_escape_string(htmlentities($_POST['type']));
$type = str_replace("'","&#39;",str_replace('"',"&#34;",$type));
$reality = mysql_real_escape_string(htmlentities($_POST['reality']));
$reality = str_replace("'","&#39;",str_replace('"',"&#34;",$reality));
$summary = mysql_real_escape_string(htmlentities($_POST['summary']));
$summary = str_replace("'","&#39;",str_replace('"',"&#34;",$summary));
$link = mysql_real_escape_string(htmlentities($_POST['link']));
$link = str_replace("'","&#39;",str_replace('"',"&#34;",$link));

//$color = mysql_real_escape_string(htmlentities($_POST['maincolor']));
//$color = str_replace("'","&#39;",str_replace('"',"&#34;",$color));
$color = "";

$series = mysql_real_escape_string(htmlentities($_POST['series']));
$series = str_replace("'","&#39;",str_replace('"',"&#34;",$series));

$imagesrc = "../Images/noimg.png";


if( $title != "")
{

$pageid = mysql_real_escape_string(htmlentities($_POST['link']));
$pageid = str_replace("'","&#39;",str_replace('"',"&#34;",$pageid));
		
$query = "INSERT INTO $mysql_database.Page (Name ,Type ,FanCan ,PageContents ,CreatedBy , PrimaryColor, Picture, Branch)values('$title','$type','$reality','$summary','$userid','$color','$imagesrc','$series')";
//echo "one<br/>";
//echo $query;
//echo "<br/>$mysql_database<br/>";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());
$pageid = mysql_insert_id();
$query =  "INSERT INTO PageTitles(PageID,Title,CreatedBy) values('".$pageid."','$title', '$userid')";
//echo "two<br/>";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

$queryraffle = "insert into SubmissionData (SubmissionID, SubmissionType, UserID, BonusReason) values ('".$pageid."','Page','$userid','NoBonus') ";
//echo "three<br/>".$queryraffle."<br/>";
$ret = mysql_query($queryraffle) or die('Query failed: ' . mysql_error());

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

    if (file_exists("../Images/headshots/" . $_FILES["file"]["name"]))
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
	$imagesrc = "../Images/noimg.png";
} else {
 //   echo "The / was found in the string '$filename'";
   // echo " and exists at position $pos";
	
	$filename = $pageid.".".substr($filename, strlen($filename) - $pos + 2);

      move_uploaded_file($_FILES["file"]["tmp_name"],
      "../Images/headshots/" . $filename);
      $imagesrc = "../Images/headshots/" . $filename;
  //    echo "Stored in: " . $filename;

	 //Resizing the picture
    include "../phpfunctions/imageResizer.php";

smart_resize_image($imagesrc, 200,200, true);	

	}
      }
    }
  }
else
  {
  		$imagesrc = "../Images/noimg.png";

  echo "There was a problem with the image provided. Contact a global mod if the exact image is important.";
  }
		
$query = "update Page set Picture = '$imagesrc' where PageID = '".$pageid."'";
$result = mysql_query($query) or die('Query failed: ' . mysql_error());

	//print($query);		


//INSERT INTO Page (Name ,Type ,FanCan ,Branch ,PageContents ,CreatedBy ,Picture ,Picture2 ,PrimaryColor )
//VALUES (NULL ,  '', NULL , NULL , NULL , NULL , NULL ,  'Images/noimg.png',  'Images/noimg.png',  '#ffffff');
		
//echo "<div id='featured' class='front-block'>$title has been created as a new page!";
/* Redirect browser */
echo '<meta http-equiv="REFRESH" content="0;url=../".$pageid."">';
?>

	

</div></div>
            
	</div> <!-- content-wrapper -->

	
	  
      </div> <!-- body-wrapper -->



</body>
</html>
<?php
/* Make sure that code below does not get executed when we redirect. */
exit;

	}
	?>
