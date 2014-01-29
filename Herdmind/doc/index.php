<!DOCTYPE HTML>
<!--
Meta descriptions of Herdmind PHP functions




!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! ABSOLUTELY NEVER MAKE THIS PAGE PUBLICLY VIEWABLE !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!





This page is copyright Herdmind.net ©2013
-->
<?PHP
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php"; // Also includes config.php and styleSwitch.php
?>
<HTML>
<HEAD>
<?PHP
buildDefaultHeadContent("PHP Functions", null, null); // no SEO
?>
<!-- Because these are ONLY used on this page --><STYLE>
DETAILS SUMMARY DT {
	display: inline;
}
*:target {
	background-color: rgba(255,255,34, 0.25);
	border-left: 0.5em solid #27B;
	color: inherit;
	margin-left: -0.5em;
}

.codeList .file,
.codeList .func,
.codeList .var,
.codeList .param {
	font-family: monospace;
}
.codeList .func,
.codeList .param {
	font-weight: bold;
}
.codeList .var>UL,
.codeList .var>UL>LI,
.codeList .param>UL,
.codeList .param>UL>LI {
	display: inline;
}

.codeList .incl {
	color: #27B;
}
.codeList .value {
	color: #B72;
}
.codeList .datatype,
.codeList .ret {
	color: #027;
	font-weight: bold;
}

.codeList .func::before {
	color: #27B;
	content: "function ";
}
.codeList .param {
	color: #7B2;
}
.codeList .var {
	color: #270;
}
.codeList .var::before,
.codeList .param::before {
	content: "$";
}
.codeList .optional::after {
	font-family: sans-serif;
	font-weight: normal;
	color: inherit;
	content: " [OPTIONAL]";
	opacity: 0.5;
}



/*.codeList DL.types DD {
	display: inline;
}
.codeList DL.types DT::after {
	content: " – "
}*/



#SIDEBAR>UL>LI {
	white-space: normal !important;
	word-break: break-all !important;
}
#SIDEBAR LI>UL {
	width: auto !important;
}
#SIDEBAR LI:hover>UL {
	max-width: 100% !important;
}
</STYLE>
</HEAD>



<?PHP buildBodyTagWithAttributes(); ?>
<HEADER>
	<H1>
		<A HREF="/">
			Herdmind
			<SPAN CLASS="slogan">PHP API Documentation</SPAN>
		</A>
	</H1>
</HEADER>



<SECTION>
	<DIV STYLE="border:0.1em dashed currentColor">
		<H3>Legend</H3>
		<UL CLASS="codeList">
			<LI><CODE CLASS="var">variable</CODE>
				<UL>
					<LI><CODE CLASS="param">parameter</CODE></LI>
					<LI><CODE CLASS="optional param">optional parameter</CODE></LI>
				</UL>
			</LI>
			<LI><CODE CLASS="file">file</CODE></LI>
			<LI><CODE CLASS="func">function</CODE></LI>
			<LI><CODE CLASS="value">value</CODE></LI>
			<LI><CODE CLASS="datatype">datatype</CODE></LI>
		</UL>
	</DIV>
	
	<DL CLASS="codeList">
		<!-- EXAMPLE TO COPYPASTA:
		<DETAILS>
			<SUMMARY><DT CLASS="file">filename.ext</DT></SUMMARY>
				<DD>Long description of file purpose
					<DL>
						<DT CLASS="incl">Imports</DT>
							<DD CLASS="file">importedFilename.ext</DD>
							etc.
						<DETAILS>
							<SUMMARY><DT CLASS="func">functionName</DT></SUMMARY>
								<DD>Long description of function purpose
									<DL>
										<DT CLASS="param">parameter1</DT>
											<DD>Long description of parameter one purpose</DD>
										<DT CLASS="param">parameter2</DT>
											<DD>Long description of parameter one purpose</DD>
										etc.
										
										<DT>Returns <CODE CLASS="ret">datatype</CODE></DT>
											<DD>Long description of return value</DD>
										
										<DT>Created By</DT>
											<DD CLASS="auth">Author One</DD>
											<DD CLASS="auth">Author Two</DD>
											etc.
										<DT>Created On</DT>
											<DD><TIME DATETIME="YYYY-MM-DD">YYYY-MM-DD</TIME></DD>
										<DT>Version</DT>
											<DD CLASS="ver">M.m.b</DD>
											<DD><TIME DATETIME="YYYY-MM-DD">YYYY-MM-DD</TIME></DD>
									</DL>
								</DD>
						</DETAILS>
						etc.
					</DL>
				</DD>
		</DETAILS>
		etc.
		-->
		
		<DETAILS>
			<SUMMARY><DT CLASS="file">Automatically generated (not done)</DT></SUMMARY>
				<DD>Long description of file purpose
					<DL>
						<DT CLASS="incl">Imports</DT>
							<DD CLASS="file">importedFilename.ext</DD>
							
		<?php
		$file = file_get_contents('../_incl/contentBuilder.php', FILE_USE_INCLUDE_PATH);
		$file = file_get_contents('../_incl/RetreiveData.php', FILE_USE_INCLUDE_PATH);
		
		
		$string = $file;
		$pos1 = strpos($string, "/**") + 3;
		$pos2 = strpos($string , "**/");
		
		$cou = 0;
		while($pos1 != -1 && $pos2 != -1 && !(empty($pos2)))
		{
				
		$FunctionCall = substr($string, $pos2+3, strpos($string,'{')-$pos2);
		$getname1 = strpos($FunctionCall,'function')+9;
		$getname2 = strpos($FunctionCall,'(') ;
		$FunctionName = substr($FunctionCall, $getname1, $getname2 - $getname1);

		echo '<DETAILS>
				<SUMMARY><DT CLASS="func">'.$FunctionName.'</DT></SUMMARY>';
		
		$functioninf = substr($string,$pos1,$pos2-$pos1);
		
		$descriptivelines=explode("\n", str_replace(PHP_EOL,"\n",$functioninf));
		
		
		$dumbstars = strpos($functioninf, ' * ')+3;
		$functiondescript = substr($functioninf, $dumbstars, strpos($functioninf, '@')-$dumbstars);
		echo "<DD>".$functiondescript."
				<DL>";
		
		$OpenDD = false;
		foreach($descriptivelines as $line)
		{
			if($OpenDD && strpos($line,'@') >= 0)
				echo "</DD>";
			if(strpos($line,'$') >= 5)//this line has a parameter
			{		
				$param = strpos($line, '$')+1;
				$ParamName = substr($line, $param, strpos($line, ' ')-$param);
				$arr = explode(' ',trim($ParamName));
				$ParamName =  $arr[0];
				if(strpos($line,'[OPTIONAL]') >= 1)//this parameter is optional
				{
				echo '<DT CLASS="optional param">'.$ParamName.'</DT>';
				echo '<DD>'.substr($line, strpos($line,'[OPTIONAL]') + 10);
				}
				else{
				echo '<DT CLASS="param">'.$ParamName.'</DT>';
				echo '<DD>'.substr($line, strpos($line,$ParamName) + strlen($ParamName));
				}
			}
		}
		
		echo "	
				</DL>
			</DD>
		</DETAILS>";
		
//	echo "<section>This is functioninf<br/>$functioninf</section>";
		
		$string = str_replace("/**".$functioninf."**/", "done",$string);

		$pos1 = strpos($string, "/**") + 3;
		$pos2 = strpos($string , "**/");

		$cou = $cou + 1;
		}
		
		
		?>
					</DL>
				</DD>
		</DETAILS>
		
		
		
		<DETAILS ID="FILE__incl-contentBuilder-php">
			<SUMMARY><DT CLASS="file">/_incl/contentBuilder.php</DT></SUMMARY>
				<DD>Contains functions that assist you in building content for the site.
					<DL>
						<DT CLASS="incl">Includes</DT>
							<DD CLASS="file">/_incl/config.php</DD>
							<DD CLASS="file">/_incl/styleSwitch.php</DD>
						<DETAILS ID="FUNC_buildDefaultHeadContent">
							<SUMMARY><DT CLASS="func">buildDefaultHeadContent</DT></SUMMARY>
								<DD>Dynamically echoes out the default content that should go in every page's
									<CODE>&lt;HEAD&gt;</CODE>. This function also calls
									<CODE CLASS="func"><A HREF="#FUNC_buildSidebarHeadContent">buildSidebarHeadContent</A></CODE>, <CODE CLASS="func"><A HREF="#FUNC_buildDialogHeadContent">buildDialogHeadContent</A></CODE>, and <CODE CLASS="func"><A HREF="#FUNC_buildStyleSwitcherHeadContent">buildStyleSwitcherHeadContent</A></CODE>.
									<DL>
										<DT CLASS="optional param">tabText</DT>
											<DD>The text to go in the browser tab.
												<DL CLASS="types">
													<DT>unspecified</DT>
													<DT><CODE CLASS="value">null</CODE></DT>
													<DT><CODE CLASS="value">false</CODE></DT>
													<DT><CODE CLASS="value">0</CODE></DT>
														<DD>Echoes <Q CLASS="value"><CODE>Herdmind</CODE></Q></DD>
													<DT>any <CODE CLASS="datatype">string</CODE></DT>
														<DD>Echoes <Q CLASS="value"><CODE><CODE CLASS="var">tabText</CODE> - Herdmind</CODE></Q></DD>
												</DL>
											</DD>
										<DT CLASS="optional param">longDescription</DT>
											<DD>The complete description of the page and its purpose</DD>
										<DT CLASS="optional param">keywords</DT>
											<DD>An array of keywords used by search engines to find this page</DD>
										
										<DT>Created By</DT>
											<DD CLASS="auth">Kyli Rouge</DD>
										<DT>Created On</DT>
											<DD><TIME DATETIME="2013-03-14">2013-03-14</TIME></DD>
										<DT>Version</DT>
											<DD CLASS="ver">1.0.0</DD>
											<DD><TIME DATETIME="2013-03-14">2013-03-14</TIME></DD>
									</DL>
								</DD>
						</DETAILS>
						<DETAILS ID="FUNC_buildSidebarHeadContent">
							<SUMMARY><DT CLASS="func">buildSidebarHeadContent</DT></SUMMARY>
								<DD>Dynamically echoes out the <CODE>&lt;HEAD&gt;</CODE> content required to use the sidebar
									<DL>
										<DT>Created By</DT>
											<DD CLASS="auth">Kyli Rouge</DD>
										<DT>Created On</DT>
											<DD><TIME DATETIME="2013-03-18">2013-03-18</TIME></DD>
										<DT>Version</DT>
											<DD CLASS="ver">1.0.1</DD>
											<DD><TIME DATETIME="2013-03-18">2013-03-19</TIME></DD>
									</DL>
								</DD>
						</DETAILS>
						<DETAILS ID="FUNC_buildDialogHeadContent">
							<SUMMARY><DT CLASS="func">buildDialogHeadContent</DT></SUMMARY>
								<DD>Dynamically echoes out the <CODE>&lt;HEAD&gt;</CODE> content required to use dialogs
									<DL>
										<DT>Created By</DT>
											<DD CLASS="auth">Kyli Rouge</DD>
										<DT>Created On</DT>
											<DD><TIME DATETIME="2013-03-24">2013-03-24</TIME></DD>
										<DT>Version</DT>
											<DD CLASS="ver">1.0.0</DD>
											<DD><TIME DATETIME="2013-03-24">2013-03-24</TIME></DD>
									</DL>
								</DD>
						</DETAILS>
						<DETAILS ID="FUNC_buildBodyTagWithAttributes">
							<SUMMARY><DT CLASS="func">buildBodyTagWithAttributes</DT></SUMMARY>
								<DD>Dynamically echoes out the <CODE>&lt;BODY&gt;</CODE> tag and any attributes specified by
								<CODE CLASS="var">_POST</CODE>, <CODE CLASS="var">_GET</CODE>, <CODE CLASS="var">_COOKIE</CODE>,
								or the SQL database.
									<DL>
										<DT>Created By</DT>
											<DD CLASS="auth">Kyli Rouge</DD>
										<DT>Created On</DT>
											<DD><TIME DATETIME="2013-03-19">2013-03-19</TIME></DD>
										<DT>Version</DT>
											<DD CLASS="ver">1.0.0</DD>
											<DD><TIME DATETIME="2013-03-19">2013-03-19</TIME></DD>
									</DL>
								</DD>
						</DETAILS>
						<DETAILS ID="FUNC_buildHeader">
							<SUMMARY><DT CLASS="func">buildHeader</DT></SUMMARY>
								<DD>Dynamically echoes out the header, which contains the branding and user account controls
									<DL>
										<DT CLASS="optional param">userName</DT>
											<DD>Represents the user's login
												<DL CLASS="types">
													<DT>unspecified</DT>
													<DT><CODE CLASS="value">null</CODE></DT>
													<DT><CODE CLASS="value">false</CODE></DT>
													<DT><CODE CLASS="value">0</CODE></DT>
														<DD>The user is not logged in</DD>
													<DT>any <CODE CLASS="datatype">string</CODE></DT>
														<DD>The user is logged in, and this is er username</DD>
												</DL>
											</DD>
										<DT CLASS="optional param">mod</DT>
											<DD>Represent's the user's moderator status
												<DL CLASS="types">
													<DT>unspecified</DT>
													<DT><CODE CLASS="value">null</CODE></DT>
													<DT><CODE CLASS="value">false</CODE></DT>
													<DT><CODE CLASS="value">0</CODE></DT>
														<DD>The user is not a moderator</DD>
													<DT>anything else</DT>
														<DD>The user is a moderator</DD>
												</DL>
											</DD>
										
										<DT>Created By</DT>
											<DD CLASS="auth">Kyli Rouge</DD>
										<DT>Created On</DT>
											<DD><TIME DATETIME="2013-03-01">2013-03-01</TIME></DD>
										<DT>Version</DT>
											<DD CLASS="ver">1.0.0</DD>
											<DD><TIME DATETIME="2013-03-01">2013-03-01</TIME></DD>
									</DL>
								</DD>
						</DETAILS>
						<DETAILS ID="FUNC_buildSidebar">
							<SUMMARY><DT CLASS="func">buildSidebar</DT></SUMMARY>
								<DD>Dynamically echoes out the sidebar, which contains the search bar, site navigation, style
									switcher GUI, and sidebar pin controls. This function also calls
									<CODE CLASS="func"><A HREF="#FUNC_buildStyleSwitcherGUI">buildStyleSwitcherGUI</A></CODE>.
									<DL>
										<DT CLASS="optional param">userName</DT>
											<DD>Represents the user's login
												<DL CLASS="types">
													<DT>unspecified</DT>
													<DT><CODE CLASS="value">null</CODE></DT>
													<DT><CODE CLASS="value">false</CODE></DT>
													<DT><CODE CLASS="value">0</CODE></DT>
														<DD>The user is not logged in</DD>
													<DT>any <CODE CLASS="datatype">string</CODE></DT>
														<DD>The user is logged in, and this is er username</DD>
												</DL>
											</DD>
										<DT CLASS="optional param">mod</DT>
											<DD>Represents the user's moderator status
												<DL CLASS="types">
													<DT>unspecified</DT>
													<DT><CODE CLASS="value">null</CODE></DT>
													<DT><CODE CLASS="value">false</CODE></DT>
													<DT><CODE CLASS="value">0</CODE></DT>
														<DD>The user is not a moderator</DD>
													<DT>anything else</DT>
														<DD>The user is a moderator</DD>
												</DL>
											</DD>
										
										<DT>Created By</DT>
											<DD CLASS="auth">Kyli Rouge</DD>
										<DT>Created On</DT>
											<DD><TIME DATETIME="2013-03-18">2013-03-18</TIME></DD>
										<DT>Version</DT>
											<DD CLASS="ver">1.0.1</DD>
											<DD><TIME DATETIME="2013-03-20">2013-03-20</TIME></DD>
									</DL>
								</DD>
						</DETAILS>
						<DETAILS ID="FUNC_buildFooter">
							<SUMMARY><DT CLASS="func">buildFooter</DT></SUMMARY>
								<DD>Dynamically echoes out the footer, which contains copyright disclaimers and claimers and the
									Google+ badge. Also calls
									<CODE CLASS="func"><A HREF="#FUNC_buildSidebar">buildSidebar</A></CODE> and
									<CODE CLASS="func"><A HREF="#FUNC_buildLogger">buildLogger</A></CODE>.
									<DL>
										<DT CLASS="optional param">userName</DT>
											<DD>Represents the user's login
												<DL CLASS="types">
													<DT>unspecified</DT>
													<DT><CODE CLASS="value">null</CODE></DT>
													<DT><CODE CLASS="value">false</CODE></DT>
													<DT><CODE CLASS="value">0</CODE></DT>
														<DD>The user is not logged in</DD>
													<DT>any <CODE CLASS="datatype">string</CODE></DT>
														<DD>The user is logged in, and this is er username</DD>
												</DL>
											</DD>
										<DT CLASS="optional param">mod</DT>
											<DD>Represents the user's moderator status
												<DL CLASS="types">
													<DT>unspecified</DT>
													<DT><CODE CLASS="value">null</CODE></DT>
													<DT><CODE CLASS="value">false</CODE></DT>
													<DT><CODE CLASS="value">0</CODE></DT>
														<DD>The user is not a moderator</DD>
													<DT>anything else</DT>
														<DD>The user is a moderator</DD>
												</DL>
											</DD>
										
										<DT>Created By</DT>
											<DD CLASS="auth">Kyli Rouge</DD>
										<DT>Created On</DT>
											<DD><TIME DATETIME="2013-03-01">2013-03-01</TIME></DD>
										<DT>Version</DT>
											<DD CLASS="ver">1.1.0</DD>
											<DD><TIME DATETIME="2013-03-13">2013-03-13</TIME></DD>
									</DL>
								</DD>
						</DETAILS>
						<DETAILS ID="FUNC_buildTopicLink">
							<SUMMARY><DT CLASS="func">buildTopicLink</DT></SUMMARY>
								<DD>Dynamically echoes out a link to a topic, including an image and the topic's names.
									<DL>
										<DT CLASS="param">topicIndex</DT>
											<DD>An <CODE CLASS="datatype">int</CODE> representing the index of the target topic</DD>
										<DT CLASS="optional param">listItem</DT>
											<DD>Specifies whether this topic link is a part of a greater list.
												<DL CLASS="types">
													<DT>unspecified</DT>
													<DT><CODE CLASS="value">null</CODE></DT>
													<DT><CODE CLASS="value">false</CODE></DT>
													<DT><CODE CLASS="value">0</CODE></DT>
														<DD>This is not a part of a greater list</DD>
													<DT>anything else</DT>
														<DD>This is a part of a greater list</DD>
												</DL>
											</DD>
										<DT CLASS="optional param">dbc</DT>
											<DD>The connection to the Herdmind database.
												<DL CLASS="types">
													<DT><CODE CLASS="value">null</CODE></DT>
														<DD>Reverts to <CODE CLASS="var">db_connection</CODE></DD>
													<DT>anything else</DT>
														<DD>Assumes this is the database connection.</DD>
												</DL>
											</DD>
										
										<DT>Created By</DT>
											<DD CLASS="auth">Kyli Rouge</DD>
										<DT>Created On</DT>
											<DD><TIME DATETIME="2013-03-12">2013-03-12</TIME></DD>
										<DT>Version</DT>
											<DD CLASS="ver">1.0.1</DD>
											<DD><TIME DATETIME="2013-03-13">2013-03-13</TIME></DD>
									</DL>
								</DD>
						</DETAILS>
						<DETAILS ID="FUNC_buildTopicLinkList">
							<SUMMARY><DT CLASS="func">buildTopicLinkList</DT></SUMMARY>
								<DD>Dynamically echoes out a list of links to topics. This function also calls
									<CODE CLASS="func"><A HREF="#FUNC_buildTopicLink">buildTopicLink</A></CODE>.
									<DL>
										<DT CLASS="param">topicIndices</DT>
											<DD>An <CODE CLASS="datatype">array</CODE> of <CODE CLASS="datatype">int</CODE>s representing the indices of the target topics</DD>
										<DT CLASS="optional param">dbc</DT>
											<DD>The connection to the Herdmind database.
												<DL CLASS="types">
													<DT><CODE CLASS="value">null</CODE></DT>
														<DD>Reverts to <CODE CLASS="var">db_connection</CODE></DD>
													<DT>anything else</DT>
														<DD>Assumes this is the database connection.</DD>
												</DL>
											</DD>
										<DT CLASS="optional param">listClass</DT>
											<DD>Any extra classes to be applied to the list element, as a string, separated by spaces.
												<DL CLASS="types">
													<DT><CODE CLASS="datatype">string</CODE></DT>
														<DD>inserts this, unchanged, into the list tag.</DD>
												</DL>
											</DD>
										
										<DT>Created By</DT>
											<DD CLASS="auth">Kyli Rouge</DD>
										<DT>Created On</DT>
											<DD><TIME DATETIME="2013-03-12">2013-03-12</TIME></DD>
										<DT>Version</DT>
											<DD CLASS="ver">1.0.2</DD>
											<DD><TIME DATETIME="2013-05-22">2013-05-22</TIME></DD>
									</DL>
								</DD>
						</DETAILS>
						<DETAILS ID="FUNC_buildLogger">
							<SUMMARY><DT CLASS="func">buildLogger</DT></SUMMARY>
								<DD>Dynamically echoes out the log dialog
									<DL>
										<DT CLASS="optional param">userName</DT>
											<DD>Represents the user's login
												<DL CLASS="types">
													<DT>unspecified</DT>
													<DT><CODE CLASS="value">null</CODE></DT>
													<DT><CODE CLASS="value">false</CODE></DT>
													<DT><CODE CLASS="value">0</CODE></DT>
														<DD>The user is not logged in</DD>
													<DT>any <CODE CLASS="datatype">string</CODE></DT>
														<DD>The user is logged in, and this is er username</DD>
												</DL>
											</DD>
										<DT CLASS="optional param">mod</DT>
											<DD>Represent's the user's moderator status. Currently unused.</DD>
										
										<DT>Created By</DT>
											<DD CLASS="auth">Kyli Rouge</DD>
										<DT>Created On</DT>
											<DD><TIME DATETIME="2013-03-24">2013-03-24</TIME></DD>
										<DT>Version</DT>
											<DD CLASS="ver">1.0.0</DD>
											<DD><TIME DATETIME="2013-03-24">2013-03-24</TIME></DD>
									</DL>
								</DD>
						</DETAILS>
						<DETAILS ID="FUNC_buildFacts">
							<SUMMARY><DT CLASS="func">buildFacts</DT></SUMMARY>
								<DD>Dynamically echoes out a list of links to topics. This function also calls
									<CODE CLASS="func"><A HREF="#FUNC_buildFact">buildFact</A></CODE>.
									<DL>
										<DT CLASS="param">FactQueryResult</DT>
											<DD>The database query to fetch the fanfact</DD>
										<DT CLASS="optional param">HowMany</DT>
											<DD>An <CODE CLASS="datatype">int</CODE> representing how many facts should be in
											this list. Defaults to <CODE CLASS="value">1</CODE></DD>
										
										<DT>Created By</DT>
											<DD CLASS="auth">Ryan Young</DD>
										<DT>Created On</DT>
											<DD><TIME DATETIME="2013-03-27">2013-03-27</TIME></DD>
										<DT>Version</DT>
											<DD CLASS="ver">1.0.0</DD>
											<DD><TIME DATETIME="2013-03-27">2013-03-27</TIME></DD>
									</DL>
								</DD>
						</DETAILS>
						<DETAILS ID="FUNC_buildFact">
							<SUMMARY><DT CLASS="func">buildFact</DT></SUMMARY>
								<DD>Dynamically echoes out a list of links to topics. This function also calls
									<CODE CLASS="func"><A HREF="#FUNC_buildFact">buildFact</A></CODE>.
									<DL>
										<DT CLASS="param">fact</DT>
											<DD>An <CODE CLASS="datatype">array</CODE> containing data about the fanfact. It
												must be structured as such:
												
												<OL STYLE="list-style-type:none;">
													<LI VALUE=0>[<CODE CLASS="value">0</CODE>, <CODE CLASS="value"><Q>FactID</Q></CODE>]
														(<CODE CLASS="datatype">int</CODE>)
														The ID of the fanfact</LI>
													<LI VALUE=1>[<CODE CLASS="value">1</CODE>, <CODE CLASS="value"><Q>DatePosted</Q></CODE>]
														(<CODE CLASS="datatype">string</CODE>)
														The ISO 8601 time and date at which the fanfact was posted</LI>
													<LI VALUE=2>[<CODE CLASS="value">2</CODE>, <CODE CLASS="value"><Q>Contents</Q></CODE>]
														(<CODE CLASS="datatype">string</CODE>)
														The raw text of the fanfact</LI>
													<LI VALUE=3>[<CODE CLASS="value">3</CODE>, <CODE CLASS="value"><Q>sum(tal.Value)</Q></CODE>]
														(<CODE CLASS="datatype">int</CODE>)
														The sum of votes on fanfact</LI>
													<LI VALUE=4>[<CODE CLASS="value">4</CODE>]
														(<CODE CLASS="datatype">int</CODE>)The voted status of the fanfact.
														<OL>
															<LI VALUE="-1">downvoted</LI>
															<LI VALUE="0">not voted upon</LI>
															<LI VALUE="1">upvoted</LI>
														</OL>
													</LI>
												</OL>
											</DD>
										<DT CLASS="optional param">standalone</DT>
											<DD>A <CODE CLASS="datatype">boolean</CODE> specifying whether or not this fact stands alone (outside an ordered or unordered list). Defaults to <CODE CLASS="value">true</CODE></DD>
										<DT CLASS="optional param">moreData</DT>
											<DD>A <CODE CLASS="datatype">boolean</CODE> which specifies whether or not the meta information links to the fanfact page. If false, it states the fanfact's number. Defaults to <CODE CLASS="value">true</CODE></DD>
										<DT CLASS="optional param">classes</DT>
											<DD>A <CODE CLASS="datatype">string</CODE> containing any extra classes to apply to the fact element</DD>
										
										
										<DT>Created By</DT>
											<DD CLASS="auth">Ryan Young</DD>
											<DD CLASS="auth">Kyli Rouge</DD>
										<DT>Created On</DT>
											<DD><TIME DATETIME="2013-03-27">2013-03-27</TIME></DD>
										<DT>Version</DT>
											<DD CLASS="ver">1.0.2</DD>
											<DD><TIME DATETIME="2013-05-22">2013-05-22</TIME></DD>
									</DL>
								</DD>
						</DETAILS>
					</DL>
				</DD>
		</DETAILS>
		<DETAILS ID="FILE__search-functions-php">
			<SUMMARY><DT CLASS="file">/search/functions.php</DT></SUMMARY>
				<DD>Contains functions that assist you in building content for the site.
					<DL>
						<DT CLASS="incl">Includes</DT>
							<DD CLASS="file">/_incl/config.php</DD>
							<DD CLASS="file">/_incl/styleSwitch.php</DD>
						<DETAILS ID="FUNC_parseSearchTerms">
							<SUMMARY><DT CLASS="func">parseSearchTerms</DT></SUMMARY>
								<DD>Returns an array of parsed search terms. This function also calls
									<CODE CLASS="func"><A HREF="#FUNC_parseSearchTerm">parseSearchTerm</A></CODE>.
									<DL>
										<DT>Returns <CODE CLASS="ret">array</CODE></DT>
											<DD>
												Returns an array of specialized datatypes. These can be any of the following,
												depending on the given parameter. See
												<CODE CLASS="func"><A HREF="#FUNC_parseSearchTerm">parseSearchTerm</A></CODE>
												for more specifics on the array's contents.
											</DD>
										<DT CLASS="param">rawString</DT>
											<DD>A <CODE CLASS="datatype">string</CODE> containing raw search terms</DD>
										
										<DT>Created By</DT>
											<DD CLASS="auth">Kyli Rouge</DD>
										<DT>Created On</DT>
											<DD><TIME DATETIME="2013-04-19">2013-04-19</TIME></DD>
										<DT>Version</DT>
											<DD CLASS="ver">1.0.0</DD>
											<DD><TIME DATETIME="2013-04-19">2013-04-19</TIME></DD>
									</DL>
								</DD>
						</DETAILS>
						<DETAILS ID="FUNC_parseSearchTerm">
							<SUMMARY><DT CLASS="func">parseSearchTerm</DT></SUMMARY>
								<DD>Returns a singular parsed search term. This will never be a native PHP type
									<DL>
										<DT>Returns <CODE CLASS="ret">mixed</CODE></DT>
											<DD>
												Returns a representation of the given string as a specialized datatype. This can
												be any of the following, depending on the given parameter:
												<UL>
													<LI><CODE CLASS="datatype"><A HREF="#CLASS_GenericFact">GenericFact</A></CODE></LI>
													<LI><CODE CLASS="datatype"><A HREF="#CLASS_Score">Score</A></CODE></LI>
													<LI><CODE CLASS="datatype"><A HREF="#CLASS_Topic">Topic</A></CODE></LI>
												</UL>
											</DD>
										<DT CLASS="param">rawString</DT>
											<DD>A <CODE CLASS="datatype">string</CODE> containing the raw search term</DD>
										
										<DT>Created By</DT>
											<DD CLASS="auth">Kyli Rouge</DD>
										<DT>Created On</DT>
											<DD><TIME DATETIME="2013-04-19">2013-04-19</TIME></DD>
										<DT>Version</DT>
											<DD CLASS="ver">1.0.0</DD>
											<DD><TIME DATETIME="2013-04-19">2013-04-19</TIME></DD>
									</DL>
								</DD>
						</DETAILS>
					</DL>
			</SUMMARY>
		</DETAILS>
	</DL>
</SECTION>


<NAV ID="SIDEBAR">
	<H2><LABEL FOR="SIDEBAR_PIN">Navigation</LABEL></H2>
	<UL>
		<LI CLASS="expandable"><A HREF="#FILE__incl-contentBuilder-php"><CODE CLASS="file">/_incl/contentBuilder.php</CODE></A>
			<UL>
				<LI><A HREF="#FUNC_buildDefaultHeadContent"><CODE CLASS="func">buildDefaultHeadContent</CODE></A></LI>
				<LI><A HREF="#FUNC_buildSidebarHeadContent"><CODE CLASS="func">buildSidebarHeadContent</CODE></A></LI>
				<LI><A HREF="#FUNC_buildDialogHeadContent"><CODE CLASS="func">buildDialogHeadContent</CODE></A></LI>
				<LI><A HREF="#FUNC_buildBodyTagWithAttributes"><CODE CLASS="func">buildBodyTagWithAttributes</CODE></A></LI>
				<LI><A HREF="#FUNC_buildHeader"><CODE CLASS="func">buildHeader</CODE></A></LI>
				<LI><A HREF="#FUNC_buildSidebar"><CODE CLASS="func">buildSidebar</CODE></A></LI>
				<LI><A HREF="#FUNC_buildFooter"><CODE CLASS="func">buildFooter</CODE></A></LI>
				<LI><A HREF="#FUNC_buildTopicLink"><CODE CLASS="func">buildTopicLink</CODE></A></LI>
				<LI><A HREF="#FUNC_buildTopicLinkList"><CODE CLASS="func">buildTopicLinkList</CODE></A></LI>
				<LI><A HREF="#FUNC_buildLogger"><CODE CLASS="func">buildLogger</CODE></A></LI>
				<LI><A HREF="#FUNC_buildFacts"><CODE CLASS="func">buildFacts</CODE></A></LI>
				<LI><A HREF="#FUNC_buildFact"><CODE CLASS="func">buildFact</CODE></A></LI>
			</UL>
		</LI>
		<LI CLASS="expandable"><A HREF="#FILE__search-functions-php"><CODE CLASS="file">/search/functions.php</CODE></A>
			<UL>
				<LI><A HREF="#FUNC_parseSearchTerms"><CODE CLASS="func">parseSearchTerms</CODE></A></LI>
				<LI><A HREF="#FUNC_parseSearchTerm"><CODE CLASS="func">parseSearchTerm</CODE></A></LI>
			</UL>
		</LI>
		<LI>
			<?PHP 
				buildStyleSwitcherGUI(array(
										"Ponies"
									  , 	new Stylesheet("/_css/visual_Dynamo_Orangejack.php"    , "Orangejack"    )
									  , 	new Stylesheet("/_css/visual_Dynamo_Pinky.php"         , "Pinky"         )
									  , 	new Stylesheet("/_css/visual_Dynamo_Rainblue.php"      , "Rainblue"      )
									  , 	new Stylesheet("/_css/visual_Dynamo_Rarewhity.php"     , "Rarewhity"     )
									  , 	new Stylesheet("/_css/visual_Dynamo_Twirple.php"       , "Twirple"       )
									  , 	new Stylesheet("/_css/visual_Dynamo_Yellowshy.php"     , "Yellowshy"     )
									  , 	new Stylesheet("/_css/visual_Dynamo_Whitelestia.php"   , "Whitelestia"   )
									  , 	new Stylesheet("/_css/visual_Dynamo_LunaticBlue.php"   , "Lunatic Blue"  )
									  , "Doctors"
									  , 	new Stylesheet("/_css/visual_Dynamo_Sexy.php"          , "Sexy Blue (WIP)")
									  , 	new Stylesheet("/_css/visual_Dynamo_Fez.php"           , "Fez"           )
									  )); // Build the GUI for switching stylesheets
			?>
		</LI>
	</UL>
	<INPUT TYPE="checkbox" CHECKED="" ID="SIDEBAR_PIN" ONCHANGE="setSidebarPinned(this.checked)" TITLE="Click here to unpin the sidebar">
</NAV>
</BODY>
</HTML>