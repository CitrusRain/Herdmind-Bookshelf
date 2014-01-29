<?PHP
/* 
 * All search functions for Herdmind.net
 * 
 * @author Kyli Rouge
 * @since  2013-04-19
 */

require_once $_SERVER['DOCUMENT_ROOT']."/_incl/convenience.php";
include_once $_SERVER['DOCUMENT_ROOT']."/_incl/startSession.php";

/**
 * Returns an array of parsed search terms
 */
function parseSearchTerms($rawString)
{
	echo "<!--";
	$searchArray = explode(" ",$rawString);
	for ($i = 0; $i < count($searchArray); $i++)
	{
		if ($quotedTerms || startsWith($searchArray[$i], '"') || startsWith($searchArray[$i], '&quot;'))
		{
			if (!$quotedTerms)
			{
			echo "
Now entering quoted mode...";
				$quoteStart = $i;
				$searchArray[$i] = substr($searchArray[$i], startsWith($searchArray[$i], '"') ? 1 : 6);
					
			echo "
		Opening quote stripped ($searchArray[$i]).";
			}
			$quotedTerms++;
			echo "
	This is quoted term $i ($searchArray[$i]).";
			if (endsWith($searchArray[$i], '"') || endsWith($searchArray[$i], '&quot;'))
			{
				echo "
		This is the end of the quoted terms.";
				$searchArray[$i] = substr($searchArray[$i], 0, endsWith($searchArray[$i], '"') ? -1 : -6);
				echo "
		End quote stripped ($searchArray[$i]).";
				array_splice($searchArray,
						$quoteStart,
						$quotedTerms,
						new GenericTerm(implode(" ", array_slice($searchArray, $quoteStart, $quotedTerms)))
					); //replace the quoted terms with a single term representing all of them
				echo "
		Items $quoteStart to " . ($quoteStart + $quotedTerms) . " combined.";
				$quotedTerms = 0;
				echo "
Array dump:";
				var_dump($searchArray);
			}
		}
		else
		{
			$searchArray[$i] = parseSearchTerm($searchArray[$i]);
			echo "
Array dump:";
			var_dump($searchArray);
		}
	}
	echo "-->";
	return $searchArray;
}

function parseSearchTerm($rawTerm)
{
	$lowerTerm = strtolower($rawTerm);
	if (startsWith($lowerTerm, "topic:"))
	{
		return new Topic(substr($rawTerm, 6));// Remove everything before the ":"
	}
	else if (startsWith($lowerTerm, "score:"))
	{
		return new Score(substr($rawTerm, 6));
	}
	else if (startsWith($lowerTerm, "sort:"))
	{
		return new SortTerm(substr($rawTerm, 5));
	}
	return new GenericTerm($rawTerm);
}

/**
 * Searches the default database for items matching the given search terms and outputs the results to the page.
 */
function searchFor($parsedSearchTerms, $page = 0, $pageSize = 10)
{
	include $_SERVER['DOCUMENT_ROOT']."/_incl/config.php";
	var_dump($parsedSearchTerms);
	$query = "
		SELECT * 
		FROM  Fact";
		$hitOne = false;
		foreach($parsedSearchTerms as $term)
			if ($term instanceof GenericTerm)
			{
				$query .= "
			" . ($hitOne ? "AND" : "WHERE") . " `Contents` COLLATE utf8_general_ci LIKE '%$term%'"; // COLLATE utf8_general_ci == case insensitivity
				$hitOne = true;
			}
		$query .= "
		LIMIT " . ($page * $pageSize) . ", " . ((($page + 1) * $pageSize) - 1) . "
	";
	echo str_replace("\n", "<BR/>", $query);
	buildFacts(mysqli_query($db_connection, $query));
}

/**
 * Creates an English version of the given array of search terms. These must be parsed search terms.
 */
function searchToEnglish($searchArray)
{
	$ret = "";
	foreach($searchArray as $term)
		if($term instanceof GenericTerm)
			$ret .= "the text \"" . $term . "\", and ";
	
	foreach($searchArray as $term)
		if($term instanceof Topic)
			$ret .= "about \"" . $term . "\", and ";
	
	foreach($searchArray as $term)
		if($term instanceof Score)
			$ret .= "with a score " . $term . ", and ";
	
	if(endsWith($ret, ", and "))
		$ret = substr($ret, 0, -6);
	
	if(startsWith($ret, ", "))
		$ret = substr($ret, 2);
	
	return $ret;
}







class GenericTerm
{
	public function __construct($rawString)
	{
		$this->t = $rawString;
	}
	
	public function __toString()
	{
		return $this->t;
	}
}
class Topic
{
	public function __construct($topicString)
	{
		$this->t = str_replace("_", " ", $topicString);
	}
	
	public function __toString()
	{
		return $this->t;
	}
}
class SortTerm
{
	public function __construct($sortString)
	{
		$this->s = str_replace("_", " ", $sortString);
	}
	
	public function __toString()
	{
		return $this->s;
	}
}
class Score
{
	public function __construct($scoreString)
	{
		$scoreString = str_replace("&lt;", "<", str_replace("&gt;", ">", $scoreString));
		if ($scoreString[0] == "<")
			if ($scoreString[1] == "=")
			{
				$this->range = -2;
				$this->value = intval(substr($scoreString,2));
			}
			else
			{
				$this->range = -1;
				$this->value = intval(substr($scoreString,1));
			}
		else if ($scoreString[0] == ">")
			if ($scoreString[1] == "=")
			{
				$this->range = 2;
				$this->value = intval(substr($scoreString,2));
			}
			else
			{
				$this->range = 1;
				$this->value = intval(substr($scoreString,1));
			}
		else
		{
			$this->range = 0;
			$this->value = intval($scoreString);
		}
		
	}
	
	public function eq(){return $this->range == 0;}
	public function gt(){return $this->range > 0 && $this->range == 1;}
	public function lt(){return $this->range < 0 && $this->range == -1;}
	public function gteq(){return $this->range > 0 && $this->range != 1;}
	public function lteq(){return $this->range < 0 && $this->range != -1;}
	
	public function upper(){return $this->range > 0;}
	public function lower(){return $this->range < 0;}
	
	public function __toString()
	{
		return
		($this->eq()
			? "Exactly"
			: ($this->upper()
				? ($this->gt()
					? "Greater than"
					: "Greater than or equal to"
				)
				: ($this->lt()
					? "Less than"
					: "Less than or equal to"
				)
			)
		)
		. " "
		. $this->value;
	}
}
?>