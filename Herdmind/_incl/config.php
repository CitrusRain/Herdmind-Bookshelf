<?php
//$str = $_SERVER['DOCUMENT_ROOT']."/_incl/";
//include $_SERVER['DOCUMENT_ROOT']."/_incl/.gitignore/mysqlconnect.php";
include dirname(__FILE__)."/.gitignore/theMySqlStuff.php";
//echo "<hr>";
//Set other global parameters 

//These make sure comments are sorted.
//I don't remember how. Might be depreciated.
global $ThreadBoardID_Topics;
global $ThreadBoardID_Fanfacts;
global $ThreadBoardID_Fanworks;
global $ThreadBoardID_Profiles;

$ThreadBoardID_Topics = 0;
$ThreadBoardID_Fanfacts = 3;
$ThreadBoardID_Fanworks = 0;
$ThreadBoardID_Profiles = 2;




?>
