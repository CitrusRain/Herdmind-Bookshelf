<?php
session_start();
?>
<!DOCTYPE HTML>
<!--
The page for general fanfacts

This page is copyright Herdmind.net ©2013
-->
<?php

include $_SERVER['DOCUMENT_ROOT']."/_incl/contentBuilder.php";      // Also includes config.php (must be done first) and styleSwitch.php
include $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";        // Start session and determine subdomain
include $_SERVER['DOCUMENT_ROOT']."/_incl/RetreiveData.php";   // Any function that returns XML
include $_SERVER['DOCUMENT_ROOT']."/_incl/convenience.php";
?>
<HTML>
<HEAD>
<script src="../_js/jquery.js"></script>
<?php
$factNum = $_GET["id"]; //Determine what fanfact to load

$FactXML = new SimpleXMLElement(GetFanfactByID($factNum, '', $userid, $db_connection)); //Get the fanfact in XML format

//Initialize variables that get populated in that darn unnessicary loop
$factText = '';
$xml = '';

//Do this in order to get the head content's facttext now instead of later
//Also, this part prepares the fanfact for printing
//Todo: figure out how to access this single fanfact without a loop and without getting an error
	foreach($FactXML->children() as $fact)
		{	
		
			if($factText == '')
			{
				//Store this for the head content, then print it.
				$factText = $fact->contents;
				buildDefaultHeadContent("Fanfact $factNum", "$factText", array("$fandom->fandomid","fanfact","headcanon","opinion"));

				//Get XML containing the page titles
				$rawxml = TitleFinder($fact->contents, $db_connection);
				
				$xml = new SimpleXMLElement($rawxml);

				//Insert the page titles into the fanfact
				$fact->contents = XMLTitleFiller($fact->contents, $xml);
			
			}
		}

?>

<!--Start chart-->
<?php

    $query = "SELECT DateOfScore, PosScore, NegScore, GuestPosScore, GuestNegScore, GrandTotal, Fanworks FROM HistoricalFactScores where FactID='$factNum' order by DateOfScore asc";

    $result = mysqli_query($db_connection, $query);
	$daysofdata = mysqli_num_rows($result);
	
	
	//Get member level to find what data they should be able to see.
//	$memberlevel = 2;//paid
//	$memberlevel = 0;//guest
	$memberlevel = 1;//member
	
	
	if($daysofdata < 2)
	{
	$TextOne = "Less than 2 days of data exist.";
	$TextTwo = "Graph not yet availible.";
	}
	
	if($daysofdata > 1)	
		{
    if ($result) {

		$output = "";
        $labels  = null ;
        $dataPos = null ;
        $dataNeg = null ;
        $dataTot = null ;
		
        $count = 0;
		
        while ($row = mysqli_fetch_assoc($result)) {
		
		$labels  = "" ;
		$dataPos = "" ;
		$dataNeg = "" ;
		$dataNegAbs = "" ;
		$dataTot = "" ;   

			$labels = substr($row["DateOfScore"],0,strpos($row["DateOfScore"],' '));		
			$dataPos = intval($row["PosScore"]) + intval($row["GuestPosScore"]);
            $dataNeg = intval($row["NegScore"]) + intval($row["GuestNegScore"]);
			$data4members = "";			

			if($memberlevel >= 1)
			{
				$dataPosM = $row["PosScore"];
				$dataNegM = $row["NegScore"];
				$dataNegMabs = abs(intval($row["NegScore"]));
				$dataPosG = $row["GuestPosScore"];
				$dataNegG = $row["GuestNegScore"];	
				$dataNegGabs = abs(intval($row["GuestNegScore"]));
				$data4members = " $dataPosM , $dataNegM , $dataNegMabs , $dataPosG , $dataNegG , $dataNegGabs ,";
			}
			$dataNegAbs = abs(intval($dataNeg));
            $dataTot = intval($dataPos) + intval($dataNeg);
			$dataFanworkCount = $row["Fanworks"];
			$dataViews = 0;
			
			if($count != 0) $output = $output." , ";
			
			$output = $output."[ '$labels' , $dataPos , $dataNeg , $dataNegAbs , ".$data4members." $dataFanworkCount , $dataTot , $dataViews]";
			
	    $count++;
        }

		
    } else {
        print('MySQL query failed with error: ' . mysql_error());
    }
	}

///PIE
$query = "SELECT FactID, count(value) as score, value FROM FactScoreByTally where FactID='$factNum' group by Value order by Value;";

    $result = mysqli_query($db_connection, $query);
      if ($result) {

        $dataPos = 0 ;
        $dataNeg = 0 ;
      //  $dataSkip = 0 ;
		
		$noresults = true;
        while ($row = mysqli_fetch_assoc($result)) {
        	$noresults = false;
        	if($row["value"] == '-1') $dataNeg = $row["score"];
        //	elseif($row["value"] ==  '0') $dataSkip = $row["score"];
        	elseif($row["value"] ==  '1') $dataPos = $row["score"];
        }
    
		$dataNegAbs = abs(intval($dataNeg));
      $dataTot = intval($dataPos) + intval($dataNeg);    
	
		if($memberlevel >= 1)
			{
/*				$dataPosM = $row["PosScore"];
				$dataNegM = $row["NegScore"];
				$dataNegMabs = abs(intval($row["NegScore"]));
				$dataPosG = $row["GuestPosScore"];
				$dataNegG = $row["GuestNegScore"];	
				$dataNegGabs = abs(intval($row["GuestNegScore"]));*/
				$data4members = " $dataPosM , $dataNegM , $dataNegMabs , $dataPosG , $dataNegG , $dataNegGabs ,";
			}    
    	else {
    		$data4members = "";
    	}
 /*
 Remove to add today to line chart   
		  if($count != 0)
		   	$output = $output." , ";
		   
        	$output = $output."[ 'Now' , $dataPos , $dataNeg , $dataNegAbs ,
        			$data4members , 0, $dataTot , 0]";
*/        			
        			
//    $output = $output."[ '$labels' , $dataPos , $dataNeg , $dataNegAbs , "
 //   		.$data4members." $dataFanworkCount , $dataTot , $dataViews]";
			
    
}
	
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">

          // Load the Visualization API and the piechart package.
          google.load('visualization', '1.0', {'packages':['corechart']});

          // Set a callback to run when the Google Visualization API is loaded.
          google.setOnLoadCallback(drawLineChart);

          // Callback that creates and populates a data table,
          // instantiates the pie chart, passes in the data and
          // draws it.

       
		var optionsPieChart;
		var myPieView;
		
		var linechartdata;	
		var optionsLineChart;
		var myLineView;
		
		var JustLoading = true;
		var ShowArray;
		var HideArray;
		
  function drawPieChart() {
            // Create the data table.
			var piechartdata = new google.visualization.DataTable();
            piechartdata.addColumn('string', 'Answer');    
            piechartdata.addColumn('number', 'Votes');
            piechartdata.addRows([
              ['Yes', <?php echo $dataPos; ?>],
              ['No', <?php echo $dataNeg; ?>],
              ['Potato', 0]
            ]);
            // Set chart options
            var optionsPieChart = {'title':'Pie Chart',
                           'height':400};

		  //Make a view for the piechart so we can interact with what is visible.
			var myPieView = new google.visualization.DataView(piechartdata);
            
			
		  // Instantiate and draw our piechart, passing in some options.
            var piechart = new google.visualization.PieChart(document.getElementById('chart_div'));
            piechart.draw(myPieView, optionsPieChart);			   
}
///////////////
//////////Bar chart
/////////////						   
		function drawBarChart() {
		var data = google.visualization.arrayToDataTable([
          ['Votes', 'Yes', 'No' ],
          ['', <?php echo $dataPos; ?>,<?php echo $dataNeg; ?>]
        ]);

        var options = {
          title: 'Bar Chart',
          height: 400
        };

        var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        chart.draw(data, options);
		  }
						   
////////////////////////////////////////////////////////////////////////////////////////////////////////						   
	function drawLineChart() {					   
         linechartdata = new google.visualization.DataTable();
         linechartdata.addColumn('string', 'Date');
			
			linechartdata.addColumn('number', 'Upvotes');
			linechartdata.addColumn('number', 'Downvotes');//Negative Numbers
			linechartdata.addColumn('number', 'Downvotes');//Absolute Values
			
			
			<?php
			
			
			//Set variables that say "hide this to get this"
			$example = "myLineView.setColumns([0,1,3,4,6]);";
			
			if($memberlevel >= 1) // Member.
			{
				//Add data for members to view.
			?>
				linechartdata.addColumn('number', 'Member Upvotes');
				linechartdata.addColumn('number', 'Member Downvotes');//Negative Values
				linechartdata.addColumn('number', 'Member Downvotes');//Absolute Values
				linechartdata.addColumn('number', 'Guest Upvotes');
				linechartdata.addColumn('number', 'Guest Downvotes');//Negative Values
				linechartdata.addColumn('number', 'Guest Downvotes');//Absolute Values
				<?php
				//Set variables that say "hide this to get this"
				$CountVotesMemberGuest = "myLineView.setColumns([0,4,6,7,9]);";
				$CountVotesMemberGuestButton = "<button type='button' onclick='Q1()'>View Votes by Membership</button>";
				
			}
			else //guest.
			{
				?>
				
				<?php
			}
			
			if ($memberlevel >= 2) //Paid!
			{
			
			
			}
			
			?>
			
			linechartdata.addColumn('number', 'Fanworks');
            linechartdata.addColumn('number', 'Sum of Votes');
            linechartdata.addColumn('number', 'Views');
            linechartdata.addRows([	<?php echo $output; ?> ]);
			
			
            // Set chart options
            var optionsLineChart = {
			'colors':['green','red', 'blue', 'black'],
						'title':'Line chart',
                           'height':400,
						   hAxis: { textPosition: 'none' }
						   };
			
			
		
		  //Make a view for the linechart so we can interact with what is visible.
			myLineView = new google.visualization.DataView(linechartdata);
			
            // Instantiate and draw our linechart, passing in some options.
            var linechart = new google.visualization.LineChart(document.getElementById('chart_div'));
            linechart.draw(myLineView, optionsLineChart);
            
            /*
			Colors:
			Green, Red, Blue, Black
			Green = Upvotes
			Red = 	Downvotes (both positive version and negative version,
							as only one is to be visible at a given time,
							we don't need to have red listed twice)
			Blue = 	Fanworks (This will be listed BEFORE Sum of Votes because Sum of Votes will be toggleable
							This is because the chart looks cleaner without it, and when the negative votes exceed 
							positive votes, it looks nicer to have the absolute values of negative votes)
			Black =	Sum of Votes				
			*/
		
			if( JustLoading )
			{				   
		  //Make a view for the linechart so we can interact with what is visible.
			myLineView = new google.visualization.DataView(linechartdata);
		
				myLineView.setColumns([0,1,3,4,6]);
				JustLoading = false;
			}
			
			
            // Instantiate and draw our linechart, passing in some options.
            var linechart = new google.visualization.LineChart(document.getElementById('chart_div'));
            linechart.draw(myLineView, optionsLineChart);
		}			
			
			
        

		function showTotals() {
			
			myLineView = new google.visualization.DataView(linechartdata);
				myLineView.setColumns([0,1,2,5]);
				drawLineChart();
			}
			
			function showCounts() {
			
			myLineView = new google.visualization.DataView(linechartdata);
				myLineView.setColumns([0,1,3,4,6]);
				drawLineChart();
			}
			
			function showAll() {
			
			myLineView = new google.visualization.DataView(linechartdata);
				drawLineChart();
			}
			
			function Q1() {
			
			myLineView = new google.visualization.DataView(linechartdata);
			<?php echo $CountVotesMemberGuest; ?>
				drawLineChart();
			}
			
        </script>

<!--End chart-->


</HEAD>



<?php
buildBodyTagWithAttributes(); // <BODY ...>
buildHeader(); // Don't pass variables to this; it will automatically detect login cookies
?>

<SECTION STYLE="font-size: larger;">
	<?php
	
		//Do an unneccicary loop to get the fact
		foreach($FactXML->children() as $fact)
		{	
			//Build the fact
			echo buildFactXML($fact, true, false);
		}
		
		
	?>
</SECTION>

<!--Testing new chart library-->
<SECTION>
	
	Charts go here. Comments are below.
	    <div id="chart_div" ></div>
		When set as guest:<br/>
		<button type='button' onclick='showTotals()'>Show Totals On Linechart</button>
		<button type='button' onclick='showCounts()'>Show Counts On Linechart</button>
		<button type='button' onclick='showAll()'>Show everything</button>
		<br/>When set as member:<br/>
		<?php echo $CountVotesMemberGuestButton; ?>
			
<center>
		<button type='button' onclick='drawPieChart()'>Show Pie Chart</button>
		<button type='button' onclick='drawBarChart()'>Show Bar Graph</button>
		<?php
			if($daysofdata > 1)
				echo "<button type='button' onclick='drawLineChart()'>Show Score History</button>";
		?>
</center>
	
</SECTION>


<SECTION id='comments'>
<?php
/*

Get and Print the comments

*/
//echo $user['member_name'];
$comments = GetComments($factNum, "fanfact");
echo buildComments($comments, $factNum, "fanfact");


/*
Create a form to submit new comment
*/
//echo CommentBox($factNum, "fanfact");
?>
</SECTION>

<SECTION>
Related topics:
<?php
//echo buildTopicLinkListFromXML($rawxml, "wrappingColumns");
?>
</SECTION>

<?php
buildFooter();
?>
</BODY>
</HTML>
