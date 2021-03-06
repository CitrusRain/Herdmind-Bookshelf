<?php
session_start();
?>
<!DOCTYPE HTML>
<!--
[PAGE SOURCE DESCRIPTION HERE]

This page is copyright Herdmind.net �2013
-->
<?php
include $_SERVER['DOCUMENT_ROOT'].'/_incl/contentBuilder.php';	  // Also includes config.php and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT'].'/_incl/contentBuilderIndex.php'; // Builds body content for index
include $_SERVER['DOCUMENT_ROOT'].'/_incl/startSession.php';		// Start session and determine subdomain - do this first to ensure contentBuilder knows the fandom
include $_SERVER['DOCUMENT_ROOT'].'/_incl/classes2.php';   			// A bunch of classes used for data
include $_SERVER['DOCUMENT_ROOT'].'/_incl/RetreiveData.php';   		// Any function that returns XML
include $_SERVER['DOCUMENT_ROOT'].'/_incl/convenience.php';
include $_SERVER['DOCUMENT_ROOT'].'/_incl/CookieTricks.php';
?>
<HTML>
<HEAD>
<?php
buildDefaultHeadContent(
	'Creating a new fanfact&hellip;',
	'Create your own fan fact for Herdmind!',
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
<STYLE TYPE="text/css">
*|* {
	box-sizing: border-box;
}
BODY {
	margin: 0;
}
BODY>MAIN {
	margin: 1em;
}
#PAGECODES > header {
	text-align: right;
	margin: 0 -1em;
}
#NEW_FACT textarea {
	width: 100%;
}
#RECENT_PAGES figure, #FANWORKS_LIST figure {
	border: thin solid rgba(0,0,0, .25);
	margin: .5em;
	padding: 0 1em 1em;
	/* background: #FFF; */
	border-radius: .2em;
}
#RECENT_PAGES ol {
	list-style-type: none;
	margin: 0 -.5em;
}
#RECENT_PAGES figure > figcaption,
#FANWORKS_LIST figure > figcaption {
	font-size: 1.5em;
	border-bottom: thin solid rgba(0,0,0, .5);
	padding: .5em 0;
	margin: 0 0 .5em;
}
#NEW_FACT output .fanfact {
	margin: 0;
	margin: .5em 0 1em;
}
#PAGECODES {
	/* background: #FFF; */
	border: thin solid rgba(0,0,0, .25);
	border-radius: .2em;
	margin: .5em 0;
	padding: 0 1em 1em;
}
#FANWORKS_LIST {
	margin: 0 -.5em;
}
#FANWORKS_LIST li {
	width: 12em;
	
}
#FANWORKS_LIST figure {
	/* margin: 0; */
	padding: 1em 1em 0;
}
#FANWORKS_LIST figure > figcaption {
	border-bottom: none;
	border-top: thin solid rgba(0,0,0, .2);
	margin: .5em 0 0;
}
#CONTROLS input,
#CONTROLS button {
	font-size: 1em;
}
</STYLE>


<script type="text/javascript" >
jQuery(function($){

   function updatePreview(){
   	var text = $("textarea#MyPost").val();
	   $("div#PreviewBox").html(text); 
	   
			if(text.indexOf("p[")>-1)
			{	
					 $("div#PreviewBox").html(text + " ...loading pages "); 	
			PreviewPost(text);
				
		} 
   } 


   var timer;

   $("textarea[name='contents']").bind("keyup", function(){
      clearTimeout(timer);
      timer = setTimeout(updatePreview, 1000);
   });

});

function addcode(insertval)
{
document.getElementById("MyPost").value = document.getElementById("MyPost").value + insertval;
updatePreview();
}

</script>


</HEAD>



<?php
buildBodyTagWithAttributes(); // <BODY ...>
buildHeader(); // Don't pass variables to this; it will automatically detect login cookies
?>



<MAIN>
	<FORM ID="NEW_FACT_FORM">
		<SECTION ID="RECENT_PAGES">
			<OL CLASS="flush row">
			
				<?php 
				
				$CookieTray = GetRecentTopicsReverse();
				
				foreach($CookieTray as $cookie)
				{				
					$aTopic = GetTopicInfo($db_connection, $cookie); 
						
					$topic = new SimpleXMLElement($aTopic);
					
					$imgPath = "http://herdmind.net/" . $topic->picture;
				
					$names = $topic->names;
					
					if(($names->selectedname->namecontents) == "")
						$NameToUse = $names->name[0]->namecontents;		
					else 
						$NameToUse = $names->selectedname->namecontents;	
					
					
					
					echo "
						<LI class='all-3 small-6 tiny-12'>
							<FIGURE CLASS='themeBack'  onclick='addcode(\"p[".$topic->topicid."]\");'>
								<FIGCAPTION>
									" . $NameToUse . "
								</FIGCAPTION>
								<IMG CLASS=\"thumb\" SRC=\"" . $imgPath . "\"/>
							</FIGURE>
						</LI>";
								
				}
				?>			
			
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
					<DIV CLASS="fact" ID='PreviewBox'>
						Preview (auto-updates with each keystroke)
					</DIV>
					<DIV CLASS="meta">
						<SPAN CLASS="factNum">1234</SPAN>
					</DIV>
				</DIV>
			</OUTPUT>
			<!-- name is the same as in the old site -->
			<TEXTAREA NAME="contents" ID="MyPost" REQUIRED PLACEHOLDER="Type your fanfact here&hellip;"></TEXTAREA>	
		</SECTION>
		
		
		<SECTION ID="PAGECODES" CLASS="themeBack">
			<HEADER>
				<INPUT TYPE="search" PLACEHOLDER="Search topics&hellip;" />
			</HEADER>
			<OUTPUT>Use AJAX here to fetch fanfacts using the <CODE>buildTopicLinkFromXML</CODE> function</OUTPUT>
		</SECTION>
		
		
		<SECTION ID="FANWORKS">
			<UL ID="FANWORKS_LIST" CLASS="plain flex-row flex-horiz-right flex-wrap">
				<LI>
					<FIGURE CLASS="themeBack">
						Added fanwork 1
						<FIGCAPTION>
							Fanwork title
						</FIGCAPTION>
					</FIGURE>
				</LI>
				
				<LI>
					<FIGURE CLASS="themeBack">
						Added fanwork 2
						<FIGCAPTION>
							Fanwork title
						</FIGCAPTION>
					</FIGURE>
				</LI>
				
				<LI>
					<FIGURE CLASS="themeBack">
						Added fanwork 3
						<FIGCAPTION>
							Fanwork title
						</FIGCAPTION>
					</FIGURE>
				</LI>
				
				<LI>
					<FIGURE CLASS="themeBack">
						Added fanwork 4
						<FIGCAPTION>
							Fanwork title
						</FIGCAPTION>
					</FIGURE>
				</LI>
				
				<LI>
					<FIGURE CLASS="themeBack">
						Added fanwork 5
						<FIGCAPTION>
							Fanwork title
						</FIGCAPTION>
					</FIGURE>
				</LI>
			</UL>
		</SECTION>
		
		<SECTION ID="CONTROLS" CLASS="text-right">
			<BUTTON ID="ATTACH_FANWORK" ><I CLASS="fa fa-plus"></I> Attach Fanwork</BUTTON>
			<button id='SUBMIT_FANFACT' class='big bg-good' type='button' onclick='SubmitFanfact("<?php echo $fandom->fandomid; ?>",\"Fanfact\")'>Submit Fanfact</button>
			<button id='SUBMIT_FANFACT' class='big bg-good' type='button' onclick='SubmitFanfact("<?php echo $fandom->fandomid; ?>",\"Speculation\")'>Submit Speculation</button>
			<button id='SUBMIT_FANFACT' class='big bg-good' type='button' onclick='SubmitFanfact("<?php echo $fandom->fandomid; ?>",\"Confirmed\")'>Submit Confirmed</button>
		</SECTION>
	</FORM>
</MAIN>



<?php
buildFooter();
?>
</BODY>
</HTML>
