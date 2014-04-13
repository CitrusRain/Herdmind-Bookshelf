/* 
 * A general-use file for performing various functions on Herdmind, such as interacting with vote buttons and other things that are saved to the database.
 * 
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! WARNING TO ALL DEVELOPERS VIEWING THIS FILE !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 * !!! ANY EDIT TO THIS FILE WILL AFFECT THE ENTIRE SITE! IT'S RECOMMENDED THAT YOU USE BACKUPS AND TEST COPIES, FIRST !!!
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 * 
 * @since 2013-12-04
 */
 
function AskToSubmit() { 
/*Todo: bring up a message 
	to prompt for any links found to be submitted
	as fanworks for a comment on a fanfact 
 */
 alert("AskToSubmit has been called to check for links that could be submitted as fanfacts.");
 alert(checkForLinks());
 }
 
function takeVote(factID, usersVote)
{
alert("Fact with the id of " + factID + " has been voted with a " + usersVote);

var url = "../_incl/actionHandler.php?func=FanfactVote";

var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    alert(innerHTML=xmlhttp.responseText);
    }
  }
xmlhttp.open("POST",url,true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("factID="+ factID + "&usersVote="+ usersVote +"&fandom="+"pony");

}



/* 
 * UploadAvatar
 * 
 * Submits the various data fields for approval as a new Topic
 * 
 */
function UploadAvatar()
{
var formData = new FormData();

formData.append("file", document.getElementById("avatar").files[0]);

var url = "/_incl/actionHandler.php?func=UploadAvatar";

var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    alert(innerHTML=xmlhttp.responseText);
    }
  }
xmlhttp.open("POST",url,true);
//xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
//xmlhttp.send("file="+ file + "");
xmlhttp.send(formData);

}



/* 
 * UploadBanner
 * 
 * Uploads the user's new premium banner
 * 
 */
function UploadBanner()
{
var formData = new FormData();

formData.append("file", document.getElementById("banner").files[0]);

var url = "/_incl/actionHandler.php?func=UploadBanner";

var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    alert(innerHTML=xmlhttp.responseText);
    }
  }
xmlhttp.open("POST",url,true);
//xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
//xmlhttp.send("file="+ file + "");
xmlhttp.send(formData);

}

function starClick(factID)
{
//alert("You have clicked a star.");

var url = "../_incl/actionHandler.php?func=StarClick";
document.getElementById("star-"+factID).className = "fa";  
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
  //  alert(innerHTML=xmlhttp.responseText);
	if(innerHTML=xmlhttp.responseText == "add")
		document.getElementById("star-"+factID).className = "fa fa-star";    
	else if(innerHTML=xmlhttp.responseText == "remove")
		document.getElementById("star-"+factID).className = "fa fa-star-o";    
    
    }
  }
xmlhttp.open("POST",url,true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("SubmissionID="+ factID + "&fandom="+"pony");

}
	
/* 
 * PostMessage
 * 
 * Submits the comment box data of #commentbox as a comment on a particular page
 * 
 * 2014-01-22 ~ updated from PostComment to work for more than just a fanfact's comment thread.
 */
function PostMessage(factNum, TopicType)
{
var comment = document.getElementById("commentbox").value;
var url = "../_incl/actionHandler.php?func=Comment";

var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    alert(innerHTML=xmlhttp.responseText);
	    if(TopicType == "fanfact")
	    {
			AskToSubmit();	    
	    }
    }
  }
xmlhttp.open("POST",url,true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("id="+ factNum + "&topictype="+ TopicType + "&comment="+ comment +"");

}

/* 
 * PostNew
 * 
 * Currently submits the comment box data of #commentbox as a new thread
 * Todo: merge with Fanfact submission
 * 
 * 2014-01-22 ~ updated from PostComment to work for more than just a fanfact's comment thread.
 */
function PostNew(fandomid)
{
//	alert("Good");
var comment = document.getElementById("MyPost").value;
var url = "../_incl/actionHandler.php?func=NewThread";

var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    alert(innerHTML=xmlhttp.responseText);
    alert("Please Refresh");
    }
  }
xmlhttp.open("POST",url,true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("comment="+ comment +"&fandomid="+fandomid);

}


/* 
 * SubmitFanfact
 * 
 * Submits the textarea data of #fanfact for approval as a new fanfact
 * 
 */
function SubmitFanfact(fandom, facttype)
{
	alert("Submitting...");
var facttext = document.getElementById("MyPost").value;
//var facttype = document.getElementById("FanfactType").value;
var url = "/_incl/actionHandler.php?func=NewFanfact";

var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    alert(innerHTML=xmlhttp.responseText);
    }
  }
xmlhttp.open("POST",url,true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("facttext="+ facttext + "&facttype="+ facttype +"&fandomid="+ fandom + "");

}


/* 
 * SubmitTopic
 * 
 * Submits the various data fields for approval as a new Topic
 * 
 */
function SubmitTopic()
{
var formData = new FormData();

formData.append("title", document.getElementById("title").value);
formData.append("file", document.getElementById("file").files[0]);
formData.append("type", document.getElementById("type").value);
formData.append("series", document.getElementById("series").value);
formData.append("reality", document.getElementById("reality").value);
formData.append("summary", document.getElementById("summary").value);
/*
var title = document.getElementById("title").value;
var file = document.getElementById("file").files[0];
alert(file);
var type = document.getElementById("type").value;
var series = document.getElementById("series").value;
var reality = document.getElementById("reality").value;
var summary = document.getElementById("summary").value;
*/

var url = "/_incl/actionHandler.php?func=NewTopic";

var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    alert(innerHTML=xmlhttp.responseText);
    }
  }
xmlhttp.open("POST",url,true);
//xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
//xmlhttp.send("title="+ title + "&file="+ file + "&type="+ type + "&series="+ series + "&reality="+ reality + "&summary="+ summary + "");
xmlhttp.send(formData);

}

function PreviewPost(PostContents)
{
var url = "../_incl/actionHandler.php?func=Preview";
alert("in");
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    alert (innerHTML=xmlhttp.responseText);
    //document.getElementById(PreviewBox).innerHTML(innerHTML=xmlhttp.responseText);
    }
  }
xmlhttp.open("POST",url,true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("text="+ PostContents);

}
