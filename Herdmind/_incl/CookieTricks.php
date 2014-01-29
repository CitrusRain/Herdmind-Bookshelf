<!--Imported CookieTricks-->
<?php
/* 
 * A general-use file for manipulating and using cookies
 * 
 *
 * 
 * @since 2014-01-13
 */

/**
 * Records what topic pages were most recently viewed by the user.
 * 
 * @param $TopicID		 	The id of the topic page.
 * 
 * @author Ryan Young
 * @since 2014-01-13
 * @version 1.0.0 (2014-01-13)
**/
function SetRecentTopics($TopicID)
{
	$BacklogCount = 5;
//	echo "<!-- Creating a cookie that stores your $BacklogCount most recently viewed topics. This will allow you to quickly find the proper page code if you decide to add a fanfact about it. -->";

	//Get cookie and explode it.
	$MuffinBox = explode(";", $_COOKIE["RecentTopicListMuffin"]);

	//Find any previous instance of this page id, and remove it so we don't have duplicates when we re-add it.
	$pos = array_search($TopicID, $MuffinBox);	// find item
	unset($MuffinBox[$pos]); 					// remove item
	$MuffinBox = array_values($MuffinBox); 		// reindex array

	//Add this topic ID
	array_push($MuffinBox, $TopicID);

	//If there are too many values in the array, remove the oldest
	while(count($MuffinBox)> $BacklogCount)
		array_shift($MuffinBox);

	//Make the array into a string again, so we can store it.
	$MuffinString = implode(";",$MuffinBox);	
	
	//Store the information in the cookie.
	setcookie ( "RecentTopicListMuffin" , $MuffinString , time()+60*60*24*3, "/" );

	//Print the values for debug purposes.
	echo "<!-- The recent page ids are $MuffinString -->";
}

/**
 * Retrieves what topic pages were most recently viewed by the user.
 * 
 * @return $array		 	An array of ids representing recently viewed topic pages.
 * 
 * @author Ryan Young
 * @since 2014-01-13
 * @version 1.0.0 (2014-01-13)
**/
function GetRecentTopics()
{
	//Get cookie and explode it.
	return explode(";", $_COOKIE["RecentTopicListMuffin"]);
}

?>