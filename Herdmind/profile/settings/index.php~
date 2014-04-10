<!DOCTYPE HTML>
<!--
A user profile page

This page is copyright Herdmind.net ©2013
-->
<?php
/*

	A NOTE TO ANYONE READING THE PHP: I'm trying a new way of doing it, hoping that putting small PHP calls in the HTML will lead to faster processing than multiple echoes
		- Kyli

*/


include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php"; // Also includes config.php and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";   // Start session and determine subdomain - do this second
include $_SERVER['DOCUMENT_ROOT']."/_incl/RetreiveData.php";   // File that returns data in XML format

$user = isset($_GET["user"]) && is_numeric($_GET["user"]) ? max($_GET["user"], 0) : 0;

?>
<HTML>
<HEAD>
<?php
buildDefaultHeadContent("A Profile", "", array("Descriptive", "Keywords"));
?>

<STYLE>
DT {
	font-weight: bold;
}
	DT.major,
	DT.major+DD {
		font-size: 2em;
		text-align: center;
		text-indent: 0;
	}
	DT.inline {
		float: left;
	}
	DT.colon::after {
		content: ":";
		padding-right: 0.5em;
	}
	DT.noTerm {
		display: none;
	}
	DD {
		font-weight: normal;
		margin: 0;
		padding: 0;
		text-indent: 2em;
	}

FIGURE.topic {
	border-radius: 0.5em;
	display: table;
	margin: 0;
	width: 100%;
}
	FIGURE.topic>* {
		display: table;
		vertical-align: top;
		}@media all and (max-width: 40em) { FIGURE.topic>* {
			display: block;
			margin: 0.5em;
		}
	}
	FIGURE.topic>IMG {
		border: 0.1em solid #FFF;
		border-radius: 0.5em;
		background: rgba(255,255,255, 0.5);
		float: left;
		margin: 0 1em 0 0;
		width: 15%;
		min-width: 1in;
		}@media all and (max-width: 40em) { FIGURE.topic>IMG {
			float: none;
			margin: auto;
			max-width: 100%;
			width: 30em;
		}
	}
/*	FIGURE.topic>*:last-child {
		clear: both;
	}*/
#FACTS {
	margin-top:0.5em;
}
#FACTS:target {
	background: transparent;
	color:inherit;
}
</STYLE>
</HEAD>

<?php
buildBodyTagWithAttributes(); // <BODY ...>
buildHeader(); // Don't pass variables to this; it will automatically detect login cookies
?>

<?php


//Determine what profile to load
global $userid;
$ProfileNum = $userid;
if(isset($_GET["id"])) 
{	
	if ($_GET["id"] === 'Me')
	{
		$ProfileNum = $userid;
	}
	else
	{
		$ProfileNum = $_GET["id"];
	}
}
if(isset($ProfileNum) && !(isset($_GET["id"])))
{
	echo "Not logged in, but trying to view own profile.";
}

?>



<SECTION id='accountsettings'>
<h3>Account settings</h3>
<div>Privacy
	<ul>
		<li>Allow other users to see what you submitted</li>
		<li>Allow other users to see what you voted on</li>
	</ul>
</div>
<div>Emails
	<ul>
		<li>Recieve emails when... -Notifications -General stuff -etc</li>
		<li>Set email address</li>
	</ul>
</div>
<div>Reset/Delete account?
	<ul>
		<li>Blanks out everything. User can decide if their posts remain or get 
				their profile information removed from the space next to it.</li>
		<li>Submitted fanfacts will however stay.</li>
		<li>The difference between reset and delete is that reset just lets 
				them start over from scratch without signing up again. 
				(Allowing premium memberships to carry over.)</li>			
	</ul>		 
</div>
</section>

<SECTION id='profilesettings'>
<h3>Profile settings</h3>
<div>Avatar 
<?php echo '<img src="/_img/uploaded/user/'.$userid.'/avatar64.png" alt="Avatar Image Preview" >'; ?>
<input type="file" name="avatar" id="avatar" />
<button type='button' onclick='UploadAvatar()'>Upload</button>
	<ul>
		<li>upload image to /_img/uploaded/user/<b>(user id)</b>/avatar64.png</li>
	</ul>
</div>
<div>Premium
<?php echo '<img src="/_img/uploaded/user/'.$userid.'/premium-banner.png" alt="Banner Image Preview" >'; ?>
<input type="file" name="banner" id="banner" />
<button type='button' onclick='UploadBanner()'>Upload</button>
	<ul>
		<li>upload image to /_img/uploaded/user/<b>(user id)</b>/premium-header.png</li>
		<li>Set align/repeat</li>
	</ul>
</div>
<div>Spoilers
	<ul>
		<li>Hide all predictions?</li>
		<li>Hide/unhide by episode/comic/novel/movie release</li>
	</ul>
</div>
</SECTION>





<?php
buildFooter();
?>
</BODY>
</HTML>
