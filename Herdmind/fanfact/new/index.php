<!DOCTYPE HTML>
<!--
[PAGE SOURCE DESCRIPTION HERE]

This page is copyright Herdmind.net ©2013
-->
<?PHP
include $_SERVER['DOCUMENT_ROOT'].'/_incl/startSession.php';        // Start session and determine subdomain - do this first to ensure contentBuilder knows the fandom
include $_SERVER['DOCUMENT_ROOT'].'/_incl/contentBuilder.php';      // Also includes config.php and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT'].'/_incl/contentBuilderIndex.php'; // Builds body content for index
include $_SERVER['DOCUMENT_ROOT'].'/_incl/classes2.php';   			// A bunch of classes used for data
include $_SERVER['DOCUMENT_ROOT'].'/_incl/RetreiveData.php';   		// Any function that returns XML
include $_SERVER['DOCUMENT_ROOT'].'/_incl/convenience.php';
?>
<HTML>
<HEAD>
<?PHP
buildDefaultHeadContent(
	'Creating a new fanfact&hellip;',
	'Create yor own fan fact for Herdmind!',
	array(
		'Fanfact',
		'Fan',
		'Fact',
		'Headcanon',
		'Create',
		'Invent',
		'Share'
	)
);
?>
</HEAD>



<?PHP
buildBodyTagWithAttributes(); // <BODY ...>
buildHeader(); // Don't pass variables to this; it will automatically detect login cookies
?>



<MAIN>
	<FORM ID="NEW_FACT_FORM">
		<SECTION ID="RECENT_PAGES">
			<OL CLASS="row">
				<LI class="all-3 small-6 tiny-12">
					<FIGURE>
						<FIGCAPTION>
							page title
						</FIGCAPTION>
						recently viewed page 1
					</FIGURE>
				</LI>
				
				<LI class="all-3 small-6 tiny-12">
					<FIGURE>
						<FIGCAPTION>
							page title
						</FIGCAPTION>
						recently viewed page 2
					</FIGURE>
				</LI>
				
				<LI class="all-3 small-6 tiny-12">
					<FIGURE>
						<FIGCAPTION>
							page title
						</FIGCAPTION>
						recently viewed page 3
					</FIGURE>
				</LI>
				
				<LI class="all-3 small-6 tiny-12">
					<FIGURE>
						<FIGCAPTION>
							page title
						</FIGCAPTION>
						recently viewed page 4
					</FIGURE>
				</LI>
			</OL>
		</SECTION>
		
		
		<SECTION ID="NEW_FACT">
			<OUTPUT>
				<DIV CLASS="fanfact" TABINDEX="-1">
					<TABLE CLASS="vote">
						<TBODY>
							<TR>
								<TD>
									<INPUT TYPE="button" DISABLED CLASS="upvote" VALUE="&#x25B2;"/>
								</TD>
							</TR>
							<TR>
								<TD>
									<INPUT TYPE="button" DISABLED CLASS="downvote" VALUE="&#x25BC;"/>
								</TD>
							</TR>
						</TBODY>
					 </TABLE>
					<DIV CLASS="fact">
						Preview (auto-updates with each keystroke)
					</DIV>
					<DIV CLASS="meta">
						<SPAN CLASS="factNum">1234</SPAN>
					</DIV>
				</DIV>
			</OUTPUT>
			
			<TEXTAREA NAME="contents" REQUIRED PLACEHOLDER="Type your fanfact here&hellip;"><!-- name is the same as in the old site --></TEXTAREA>
		</SECTION>
		
		
		<SECTION ID="PAGECODES">
			<HEADER>
				<INPUT TYPE="search" PLACEHOLDER="Search topics&hellip;" />
			</HEADER>
			<OUTPUT>Use AJAX here to fetch fanfacts using the <CODE>buildTopicLinkFromXML</CODE> function</OUTPUT>
		</SECTION>
		
		
		<SECTION ID="FANWORKS">
			<UL ID="FANWORKS_LIST">
				<LI>
					<FIGURE>
						Added fanwork 1
						<FIGURE>
							Fanwork title
						</FIGURE>
					</FIGURE>
				</LI>
				
				<LI>
					<FIGURE>
						Added fanwork 2
						<FIGURE>
							Fanwork title
						</FIGURE>
					</FIGURE>
				</LI>
				
				<LI>
					<FIGURE>
						Added fanwork 3
						<FIGURE>
							Fanwork title
						</FIGURE>
					</FIGURE>
				</LI>
				
				<LI>
					<FIGURE>
						Added fanwork 4
						<FIGURE>
							Fanwork title
						</FIGURE>
					</FIGURE>
				</LI>
				
				<LI>
					<FIGURE>
						Added fanwork 5
						<FIGURE>
							Fanwork title
						</FIGURE>
					</FIGURE>
				</LI>
			</UL>
		</SECTION>
		
		<SECTION ID="CONTROLS">
			<INPUT TYPE="button" ID="ATTACH_FANWORK" VALUE="Attach Fanwork" />
			<INPUT TYPE="submit" ID="SUBMIT_FANFACT" VALUE="Submit Fanfact" />
		</SECTION>
	</FORM>
</MAIN>



<?PHP
buildFooter();
?>
</BODY>
</HTML>
