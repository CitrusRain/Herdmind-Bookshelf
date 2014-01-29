<!DOCTYPE HTML>
<!--
This is a mockup of Herdmind as envisioned by Kyli Rouge|Supuhstar|Digit Shine FOR TESTING NO-JS DIALOGS

This page is copyright Herdmind.net ©2013
-->
<HTML>
<HEAD>
<TITLE>[TAB TEXT] &ndash; Herdmind&nbsp;&beta;</TITLE>

<!-- BEGIN Meta data -->
<META HTTP-EQUIV="Content-Type" CONTENT="text/html;charset=utf-8" />
<META NAME="viewport"    CONTENT="target-densitydpi=device-dpi, initial-scale=1.0, user-scalable=no" /> <!-- If user is on mobile, suggest to not allow pinch-zoom -->
<META NAME="description" CONTENT="[LONG DESCRIPTION]"/>
<META NAME="keywords"    CONTENT="Herdmind,Headcanon,Database,Descriptive,Keywords"/>
<META HTTP-EQUIV="X-UA-Compatible" CONTENT="chrome=IE8" /> <!-- INVALID: Consider altermatives. - If user is using IE 8 or older and has Chrome Frame, use Chrome Frame -->
<!-- END Meta data -->

<!-- BEGIN Representative images -->
<LINK REL="shortcut icon"                TYPE="image/x-icon"    HREF="/favicon.ico" />
<!--LINK REL="apple-touch-icon"             TYPE="image/png"       HREF="/touchIcon.png" /-->
<!--LINK REL="apple-touch-icon-precomposed" TYPE="image/png"       HREF="/touchIcon.png" /-->
<!-- END Representative images -->

<SCRIPT TYPE="text/javascript" SRC="//code.jquery.com/jquery.min.js">/* jQuery */</SCRIPT>


<!-- BEGIN Style-Switcher Stylesheets -->
<LINK REL="stylesheet" ID="_switchSheetBackup" HREF="/_css/visual_Dynamo.css"/>
<LINK REL="stylesheet" ID="_switchSheet"       HREF="/_css/visual_Dynamo_Whitelestia.php"/>
<!-- END Style-Switcher Stylesheets -->

<!-- BEGIN Style-Switcher Scripts -->
<SCRIPT TYPE="text/javascript" SRC="/_js/styleSwitch2.js"> /* Style Switching Scripts */ </SCRIPT>
<!-- END Style-Switcher Scripts -->
<SCRIPT TYPE="text/javascript" SRC="/_js/sidebar.js">/* Sidebar Scripts */</SCRIPT>

<STYLE>
.cssPopup,
.cssPopupHolder {
	display: none;
	position: fixed !important;
	top:0;
	z-index: 2000000000;
}
.cssPopupHolder {
	border-radius: 0;
	width: 100%;
}
.cssPopup:target,
.cssPopupHolder:target {
	background-color: rgba(0,0,0, 0.5);
	display: block;
	max-height: 100%;
}
DIALOG {
	display: inline-block !important;
	max-height: 100%;
}
#LOGGER {
	text-align: right;
	padding-bottom: 1em;
}
	#LOGGER>* {
		text-align: center;
	}
	#LOGGER H2 {
		font-size: 2em;
	}
	#LOGGER_CLOSE {
		width: 2em;
		height: 1em;
		display: inline-block;
		text-align: center;
		vertical-align: top;
		line-height: 0.75em;
		border-top-left-radius: 0;
		border-top-right-radius: 0;
		border-top: 0;
	}

HR {
	border-color: rgba(128,128,128, 0.5);
	border-style: solid none none;
	border-width: thin;
	max-height: 0;
	padding: 0;
}
</STYLE>
</HEAD>



<BODY><!-- fandom is  -->
<HEADER>
	<H1>
		<A HREF="/">
			Herdmind
			<SPAN CLASS="slogan">The  Headcanon Database</SPAN>
		</A>
	</H1>
	<DIV CLASS="warning alert hideIfMediaQuery">Your browser is unsupported!</DIV>
	<NAV ID="USERNAV">
		<UL ID="LOGGED_OUT_USERNAV">
			<LI><A HREF="#LOGGER_HOLDER" CLASS="button">Login | Register</A></LI>
		</UL>
	</NAV>
</HEADER>




<SECTION>
	[BODY CONTENT HERE]
</SECTION>




<NAV ID="SIDEBAR">
	<H2><LABEL FOR="SIDEBAR_PIN">Navigation</LABEL></H2>
	<UL>
		<LI>
			<FORM ID="SEARCH_FORM" ACTION="/search" METHOD="get">
				<LABEL CLASS="hideWhenMediaQuery" FOR="SEARCH_BAR">Search: </LABEL>
				<INPUT ID="SEARCH_BAR" NAME="search" TYPE="search" AUTOCOMPLETE="on" PLACEHOLDER="Search"/>
				<!--INPUT TYPE="submit" VALUE="Search!"/-->
			</FORM>
		</LI>
		<LI CLASS="expandable"><A HREF="/">Home</A>
			<UL>
				<LI><A HREF="//tardis.herdmind.net">Doctor Who</A></LI>
				<LI><A HREF="//pony.herdmind.net">Friendship is Magic</A></LI>
				<LI><A HREF="//ppg.herdmind.net">Powerpuff Girls</A></LI>
				<LI><A HREF="//herdmind.net">Site Portal</A></LI>
			</UL>
		</LI>
		<LI CLASS="expandable"><A HREF="/browse/">Browse</A>
			<UL>
				<LI><A HREF="/browse/index.php?type=Character"> Characters </A></LI>
				<LI><A HREF="/browse/index.php?type=Species">   Species    </A></LI>
				<LI><A HREF="/browse/index.php?type=Place">     Places     </A></LI>
				<LI><A HREF="/browse/index.php?type=Event">     Events     </A></LI>
				<LI><A HREF="/browse/index.php?type=Object">    Objects    </A></LI>
				<LI><A HREF="/browse/index.php?type=Other">     Other      </A></LI>
			</UL>
		</LI>
		<LI><A HREF="/forum/">Forums</A></LI>
		<LI>
			
		<SELECT ONCHANGE="return switchStyles(this);">
			<OPTION VALUE="/_css/visual_Dynamo.css">Select a style!</OPTION>
				<OPTGROUP LABEL="Ponies">
			<OPTION VALUE="/_css/visual_Dynamo_Orangejack.php" CLASS="Orangejack">Orangejack</OPTION>
				<OPTION VALUE="/_css/visual_Dynamo_Pinky.php" CLASS="Pinky">Pinky</OPTION>
				<OPTION VALUE="/_css/visual_Dynamo_Rainblue.php" CLASS="Rainblue">Rainblue</OPTION>
				<OPTION VALUE="/_css/visual_Dynamo_Rarewhity.php" CLASS="Rarewhity">Rarewhity</OPTION>
				<OPTION VALUE="/_css/visual_Dynamo_Twirple.php" CLASS="Twirple">Twirple</OPTION>
				<OPTION VALUE="/_css/visual_Dynamo_Yellowshy.php" CLASS="Yellowshy">Yellowshy</OPTION>
				<OPTION VALUE="/_css/visual_Dynamo_Whitelestia.php" SELECTED CLASS="Whitelestia">Whitelestia</OPTION>
				<OPTION VALUE="/_css/visual_Dynamo_LunaticBlue.php" CLASS="Lunatic Blue">Lunatic Blue</OPTION>
				</OPTGROUP>
			<OPTGROUP LABEL="Doctors">
			<OPTION VALUE="/_css/visual_Dynamo_Sexy.php" CLASS="Sexy Blue">Sexy Blue</OPTION>
				<OPTION VALUE="/_css/visual_Dynamo_Fez.php" CLASS="Fez">Fez</OPTION>
				</OPTGROUP>
			<OPTGROUP LABEL="Girls">
			<OPTION VALUE="/_css/visual_Dynamo_Blossom.php" CLASS="Blossom">Blossom</OPTION>
				<OPTION VALUE="/_css/visual_Dynamo_Bubbles.php" CLASS="Bubbles">Bubbles</OPTION>
				<OPTION VALUE="/_css/visual_Dynamo_Buttercup.php" CLASS="Buttercup ">Buttercup </OPTION>
				</OPTGROUP>
			<OPTGROUP LABEL="Elements">
			<OPTION VALUE="/_css/visual_Dynamo_Earth.php" CLASS="Earth (WIP)">Earth (WIP)</OPTION>
				<OPTION VALUE="/_css/visual_Dynamo_Fire.php" CLASS="Fire (WIP)">Fire (WIP)</OPTION>
				<OPTION VALUE="/_css/visual_Dynamo_Air.php" CLASS="Air (WIP)">Air (WIP)</OPTION>
				<OPTION VALUE="/_css/visual_Dynamo_Water.php" CLASS="Water (WIP)">Water (WIP)</OPTION>
				</OPTGROUP></SELECT>
		</LI>
	</UL>
	<INPUT TYPE="checkbox" ID="SIDEBAR_PIN" ONCHANGE="setSidebarPinned(this.checked)" TITLE="Click here to pin the sidebar"/>
</NAV>

<DIV CLASS="dialogHolder cssPopup" ID="LOGGER_HOLDER">
	<DIALOG ID="LOGGER">
		<A CLASS="close button" HREF="#" ID="LOGGER_CLOSE">&times;</A>
		<FORM ACTION="#" METHOD="post" ACCEPT-CHARSET="ISO-8859-1">
			<TABLE CLASS="collapsed">
				<TBODY>
					<TR><TH COLSPAN="2"><H2>Log in</H2></TH></TR>
					<TR>
						<TH><LABEL FOR="LOGIN_USERNAME">Username:&nbsp;</LABEL></TH>
						<TD><INPUT ID="LOGIN_USERNAME" TYPE="text" NAME="user"/></TD>
					</TR>
					<TR>
						<TH><LABEL FOR="LOGIN_PASSWORD">Password:&nbsp;</LABEL></TH>
						<TD><INPUT ID="LOGIN_PASSWORD" TYPE="password" NAME="password"/></TD>
					</TR>
					<TR>
						<TD COLSPAN="2"><HR/></TD>
					</TR>
					<TR>
						<TD COLSPAN="2">
							<INPUT TYPE="submit" VALUE="Log in!"/>
							|
							<A HREF="http://pony.herdmind.net/forum/index.php?action=register" CLASS="alt">Register</A>
						</TD>
					</TR>
				</TBODY>
			</TABLE>
		</FORM>
	</DIALOG>
</DIV>
<FOOTER>
	<SECTION ID="LINKS">
		<H2>Links:</H2>
		<UL CLASS="plain">
			<LI><A HREF="/legal">Legal</A></LI>
			<LI><A HREF="/contact">Contact</A></LI>
		</UL>
	</SECTION>
	<SECTION>
		<!-- BEGIN Google+ Badge -->
		<div class="g-plus" data-width="5em" data-href="https://plus.google.com/115556066131792258384" data-rel="publisher"></div>

		<script type="text/javascript">
		  (function() {
			var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			po.src = 'https://apis.google.com/js/plusone.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
		  })();
		</script>
		<!-- END Google+ Badge -->
	</SECTION>
</FOOTER></BODY>
</HTML>
