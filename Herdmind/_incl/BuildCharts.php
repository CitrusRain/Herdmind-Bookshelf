<?php

function FactLinegraphData($factid, $dbc = null, $NameOfOutputArray = 'LineGraph')
{

    $query = "SELECT DateOfScore, PosScore,NegScore,Score FROM HistoricalFactScores where FactID='$factid'";


    $result = mysqli_query($dbc, $query);

    if ($result) {
        $labels = array();
        $dataPos   = array();
        $dataNeg   = array();
        $dataTot   = array();
    
		$firsttime = '';
		
	$count = 0;
        while ($row = mysqli_fetch_assoc($result)) {
		
		if ($count == 0)
			$firsttime = $row["DateOfScore"];

			$time = $row["DateOfScore"];
			$dataPos[]   = "[".strtotime($time).",".$row["PosScore"]."]";
            $dataNeg[]   = "[".strtotime($time).",".abs($row["NegScore"])."]";
            $dataTot[]   = "[".strtotime($time).",".$row["Score"]."]";
	    $count++;
        }

        // Now you can aggregate all the data into one string
        $dataPos_string = "[" . join(", ", $dataPos) . "]";
        $dataNeg_string = "[" . join(", ", $dataNeg) . "]";
        $dataTot_string = "[" . join(", ", $dataTot) . "]";
        $labels_string = "['" . join("', '", $labels) . "']";
    } else {
      //  print('MySQL query failed with error: ' . mysql_error());
    }
    
	 echo 'var '.$NameOfOutputArray.'1 = '.$dataNeg_string.', ';
	 echo $NameOfOutputArray.'2 = '.$dataPos_string.', ';
	 echo $NameOfOutputArray.'3 = '.$dataTot_string.', ';
	 echo 'start = '.strtotime($firsttime).';';

}



?>