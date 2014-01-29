<?php
/**
 * Represents a Herdmind fanbase 
 * Note: usually refferred to as a "branch"
 * 
 * @author Ryan
 * @since 9-4-2013
 */
class Fanbase
{
	function __construct($ID, $Name, $Official, $Logo, $IsPublic)
	{
		$this->id 		= $ID;
		$this->title	= $Name;
		$this->official	= $Official;
		$this->logo 	= $Logo;
		$this->isPublic = $IsPublic;
		
		$this->Children = array();
		$this->ChildCount = 0;
	}
	
	function addChild($ID, $ParentID, $Name, $Official, $Logo, $IsPublic)
	{
		if($ParentID == $this->id) //Add to Children array
		{
			$this->Children[$this->ChildCount] = new Fanbase($ID, $Name, $Official, $Logo, $IsPublic);
			$this->ChildCount = $this->ChildCount + 1;
		}
		else //Put it below it's parent
		{
				//Find parent in array and add it.
				foreach ($this->Children as $value)
				{
					if($value->getID() == $ParentID)
					{
						$value->addChild($ID, $ParentID, $Name, $Official, $Logo, $IsPublic);
					}
				}
		}
	}
	
	function getID()
	{
		return $this->id;
	}
	
	function getTitle()
	{
		return $this->title;
	}
	
	function getOfficial()
	{
		return $this->official;
	}
	
	function getLogo()
	{
		return $this->logo;
	}
	
	function getChildren()
	{
		return $this->Children;
	}
	
	function getPublic()
	{
		return $this->isPublic;
	}
	
	function __toString()
	{
		$str = $this->title;
		foreach ($this->Children as $value)
		{
			if($str != "")
				$str = $str.",";
				
			$str = $str.$value;
		}
		return $str;
		//return $this->title;
	}
	
}

/**
 * Herdmind fanbase wrapper class
 * Note: usually refferred to as "branches"
 * 
 * @author Ryan
 * @since 9-4-2013
 */
  //Todo: redo this to use pointers for speed http://stackoverflow.com/questions/746224/are-there-pointers-in-php
class FanbaseList
{
	function __construct()
	{
		$this->AllFanbases = array();
		$this->TopCount = 0;
	}
	
	function add($ID, $ParentID, $Name, $Official, $Logo, $IsPublic)
	{
		if($ParentID == "") // Then this is a top level category
		{
			$this->AllFanbases[$this->TopCount] = new Fanbase($ID, $Name, $Official, $Logo, $IsPublic);
			$this->TopCount = $this->TopCount + 1;
		}
		else //Put it below it's parent
		{
				//Find parent in array and add it.
				foreach ($this->AllFanbases as $value)
				{
					if($value->getID() == $ParentID)
					{
						$value->addChild($ID, $ParentID, $Name, $Official, $Logo, $IsPublic);
					}
				}
				//Look deeper
		}
	}
	
	function toArray()
	{
		return $this->AllFanbases;
	}
	
	function __toString()
	{

		//$str = implode(",", array_keys($this->allFanbases));
		
		$str = "-";
		foreach ($this->AllFanbases as $value)
		{
			if($str != "")
				$str = $str.",";
				
			$str = $str.$value;
		}
		return $str;
	}
}
?>