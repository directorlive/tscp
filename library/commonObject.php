<?

class commonObject
{	
	public function getInsertDataString($dataArray, $tableName)
	{
		$subQryArr = array();
		foreach($dataArray as $key => $value)
		{
			$subQryArr[] = $key." = '".addslashes($value)."'";
		}
		$subQry = implode(", ",$subQryArr);
		$insertQry = "insert into ".$tableName." set ".$subQry;
		return $insertQry;	
	}
	
	//Manthan Tripathi - 09-08-2012
	//To generate string for update query form array.
	//Note: $dataArray must contain the id. $idFieldName is the name of the field which contains the id.
	function getUpdateDataString($dataArray,$tableName,$idFieldName){
		$subQryArr = array();
		foreach($dataArray as $key => $value)
		{
			if(!($key==$idFieldName))
				$subQryArr[] = $key." = '".addslashes($value)."'";
		}
		$subQry = implode(", ",$subQryArr);
		$updateQry = "Update ".$tableName." set ".$subQry." where ".$idFieldName."='".$dataArray[$idFieldName]."'";
		return $updateQry;
	}
	
}


?>