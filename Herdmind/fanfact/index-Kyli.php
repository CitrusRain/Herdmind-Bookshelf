<!DOCTYPE HTML>
<!--
[PAGE SOURCE DESCRIPTION HERE]

This page is copyright Herdmind.net ©2013
-->
<?PHP
include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php"; // Also includes config.php and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";   // Start session and determine subdomain - do this second
?>
<HTML>
<HEAD>
<?PHP
buildDefaultHeadContent("Fanfact 78", "Derpy Hooves is Doctor Whooves's companion in his adventures.", array("Fanfact", "Fantasy", "Idea"));
?>
<script src="//code.jquery.com/jquery.min.js" type="text/javascript"></script>
<script src="javascript/RGraph/libraries/RGraph.common.core.js"></script>
<script src="javascript/RGraph/libraries/RGraph.common.dynamic.js"></script>
<script src="javascript/RGraph/libraries/RGraph.common.tooltips.js"></script>
<script src="javascript/RGraph/libraries/RGraph.common.key.js"></script>
<script src="javascript/RGraph/libraries/RGraph.line.js"></script>
<script src="javascript/RGraph/libraries/RGraph.pie.js"></script>

<STYLE TYPE="text/css">
UL.topics>LI {
	display: inline-block;
	margin: 0;
	width: 100%;
}
.fanfact {
	margin: 0;
}
</STYLE>
</HEAD>



<?PHP
buildBodyTagWithAttributes(); // <BODY ...>
buildHeader(); // Don't pass variables to this; it will automatically detect login cookies
?>


<SECTION ID="KYLI_META" STYLE="border:thin dashed lightgray;">
	<BUTTON ONCLICK="KYLI_META.style.display = 'none';">Hide developer's notes</BUTTON>
	<P>
		This <STRONG>mockup</STRONG> is Kyli's proposal for a new Herdmind fanfact page. It is currently <STRONG>not</STRONG> complete, and only displays fact 78.
	</P>
</SECTION>



<SECTION STYLE="font-size: larger;">
	<?PHP
		echo buildFact(array(78, null, TitleFiller("[p1] is [p2]&apos;s companion in his adventures.", $db_connection), "52", "1"), true, false);
		echo buildTopicLinkList(array(1, 2), null, "wrappingColumns");
	?>
</SECTION>



<SECTION>
	<P>I have no idea why the graphs aren't here.</P>
	<canvas style="" id="cvs" width="600" height="300">[No canvas support]</canvas>
	<script>
	var gutterLeft = 30;
            var gutterRight = 30;

	var max = 59;
        	max = (Math.ceil(max/5.0) * 5)+5;

	var min = -7;
        	min = Math.floor(min/5.0) * 5;

        line1 = new RGraph.Line('cvs', [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, -1, -1, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -6, -6, -6, -6, -6, -6, -6, -6, -6, -6, -6, -6, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7]);
            line1.Set('chart.ymax', max);
            line1.Set('chart.ymin', min);
	line1.Set('chart.background.grid.autofit', true);
        line1.Set('chart.gutter.left', gutterLeft);
        line1.Set('chart.gutter.right', gutterRight);
	line1.Set('axis.color', 'red');
	line1.Set('axis.text.color', 'red');
	line1.Set('axis.x', 500);
	line1.Set('chart.tooltips',[0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, -1, -1, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -5, -6, -6, -6, -6, -6, -6, -6, -6, -6, -6, -6, -6, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7, -7]);
        line1.Set('chart.hmargin', 10);
        line1.Set('chart.tickmarks', 'filledcircle');
        line1.Set('chart.labels', ['2012-10-12', '2012-11-26', '2013-01-10', '2013-02-24', '2013-04-11']); 
	line1.Set('chart.key.position.x', ((line1.canvas.width - gutterLeft - gutterRight) / 2) + gutterLeft - 115);
	line1.Set('chart.noaxes', true);
            line1.Set('chart.ylabels', false);
            line1.Set('chart.noaxes', true);
                       
        line1.Draw();

        line2 = new RGraph.Line('cvs', [1, 2, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 8, 32, 38, 39, 39, 40, 40, 40, 40, 40, 41, 41, 43, 45, 45, 45, 45, 45, 45, 45, 45, 45, 45, 47, 48, 48, 48, 48, 48, 48, 48, 48, 48, 49, 49, 49, 49, 50, 52, 53, 54, 54, 54, 54, 54, 54, 54, 55, 56, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59]);
            line2.Set('chart.ymax', max);
            line2.Set('chart.ymin', min);
        line2.Set('chart.gutter.left', gutterLeft);
        line2.Set('chart.gutter.right', gutterRight);
        line2.Set('chart.colors', [ 'green']);
	line2.Set('axis.color', 'green');
	line2.Set('axis.text.color', 'green');
	line2.Set('chart.background.grid.autofit.numhlines', 0);
	line2.Set('chart.background.grid.autofit.numvlines', 0);
	line2.Set('chart.tooltips',[1, 2, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 8, 32, 38, 39, 39, 40, 40, 40, 40, 40, 41, 41, 43, 45, 45, 45, 45, 45, 45, 45, 45, 45, 45, 47, 48, 48, 48, 48, 48, 48, 48, 48, 48, 49, 49, 49, 49, 50, 52, 53, 54, 54, 54, 54, 54, 54, 54, 55, 56, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 57, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 58, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59, 59]);
        line2.Set('chart.hmargin', 10);
        line2.Set('chart.tickmarks', 'filledcircle');
        line2.Set('chart.fillstyle', 'blue');
        line2.Set('chart.labels', ['2012-10-12', '2012-11-26', '2013-01-10', '2013-02-24', '2013-04-11']);     
        line2.Set('chart.noaxes', true);       
            line2.Set('chart.ylabels', false);
        line2.Draw();

        line3 = new RGraph.Line('cvs', [1, 2, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 2, 7, 27, 33, 34, 34, 35, 35, 35, 35, 35, 36, 36, 38, 40, 40, 40, 40, 40, 40, 40, 39, 39, 39, 41, 42, 42, 42, 42, 42, 42, 42, 42, 41, 42, 42, 42, 42, 43, 45, 46, 47, 47, 47, 47, 47, 47, 47, 48, 49, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52]);
        line3.Set('chart.ymax', max);
        line3.Set('chart.ymin', min);
        line3.Set('chart.gutter.left', gutterLeft);
        line3.Set('chart.gutter.right', gutterRight);
	line3.Set('chart.background.grid.autofit.numhlines', 0);
	line3.Set('chart.background.grid.autofit.numvlines', 0);
	line3.Set('chart.colors', ['black', 'green', 'red']);
        line3.Set('chart.key', ['Score', 'Upvotes Only', 'Downvotes Only']);
   	line3.Set('chart.key.position', 'gutter');
        line3.Set('chart.key.position.gutter.boxed', false);
        line3.Set('chart.key.position.x', ((line3.canvas.width - gutterLeft - gutterRight) / 2) + gutterLeft - 115);
            

	line3.Set('axis.color', 'black');
	line3.Set('axis.text.color', 'black');
	line3.Set('chart.tooltips',[1, 2, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 2, 7, 27, 33, 34, 34, 35, 35, 35, 35, 35, 36, 36, 38, 40, 40, 40, 40, 40, 40, 40, 39, 39, 39, 41, 42, 42, 42, 42, 42, 42, 42, 42, 41, 42, 42, 42, 42, 43, 45, 46, 47, 47, 47, 47, 47, 47, 47, 48, 49, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 51, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52, 52]);
        line3.Set('chart.hmargin', 10);
        line3.Set('chart.tickmarks', 'filledcircle');
        line3.Set('chart.fillstyle', 'black');
        line3.Set('chart.labels', ['2012-10-12', '2012-11-26', '2013-01-10', '2013-02-24', '2013-04-11']); 
            line3.Set('chart.noaxes', true);
        line3.Draw();

	
</script>
	<canvas style="" id="piechart" width="300" height="300">[No canvas support]</canvas>
	<script>
    
        // The data to be shown on the Pie chart
        var dataforpi = [59,7,499,611,322];
    
        // Create the Pie chart. The arguments are the canvas ID and the data to be shown.
        var pie = new RGraph.Pie('piechart', [59, 7]);

        // Configure the chart to look as you want.
        pie.Set('chart.labels', ['Up', 'Down']);
        pie.Set('chart.linewidth', 5);
        pie.Set('chart.radius', 100);
      //  pie.Set('chart.stroke', 'white');
	pie.Set('chart.colors', ['green', 'red']);
        
        // Call the .Draw() chart to draw the Pie chart.
        pie.Draw();
    
</script>
</SECTION>



<?PHP
buildFooter();
?>
</BODY>
</HTML>
