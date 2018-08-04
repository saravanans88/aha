<?php
	function connectioncreation($servername,$user,$pword,$db){
		$conn = mysqli_connect($servername,$user,$pword,$db) or die("unable to connect to the database");
		//$mysql= mysql_select_db($db,$conn);
		return $conn;
	}
	
	function selectexecute($query,$con){

		$querylimitresult = mysqli_query($con,$query);
		$execarray = Array();
		while($row = mysqli_fetch_array($querylimitresult)){
			$execarray[$row[0]]=$row[1];
		}		
		return $execarray;
	}
	
	function insertquery($table,$fields,$request,$files=array(),$con){
	
		$qry = "insert into ".$table;
		$qry .= "(";
		foreach($fields as $key=>$value){
			$qry .= $key.",";
		}
		$qry .= "createdby,datecreated,updatedby,dateupdated";
		$qry .= ")values(";
		foreach($fields as $key=>$value){
			if($value=="file"){
					$qry .= "'".$files[$key]["name"]."',";
					if($files[$key]['name'] != "" ){
							 move_uploaded_file($files[$key]["tmp_name"],"images/$key/" . $files[$key]["name"]);
							 echo "images/$key/" . $files[$key]["name"];
				
					}
			}else{
				$qry .= "'".$request[$key]."',";
			}
		}
		$user=$_SESSION['sessionlogin'];
		$qry .="'$user',now(),'".$_SESSION['sessionlogin']."',now()";
		$qry .= ")";
		
		//echo $qry."<br>";exit;
		$ins = mysqli_query($con,$qry);
		$insertid = mysqli_insert_id($con);
		return $insertid;
	}
	
	function getUserInfo($query,$con){
        //echo $query;	
        // connect to db
        $sql = mysqli_query($con,$query);
		$resultarray = Array();
		
        if(mysqli_num_rows($sql) > 0){
		$j=0;
			while ($row = mysqli_fetch_array($sql)) {
				$resultarray[$j] = $row;
				$j++;
			}
                
                // close connection to db
                return $resultarray;
        }
        // close connection to db
        return null;
    }
	
	function connectionclose($con){
		mysqli_close($con);
	}
	
	function selectexecutequery($table,$fields,$wherecond="",$con){
		$qry = "select ";
		foreach($fields as $key=>$value){
			if($value=="date"){
				$qry .= "DATE_FORMAT($key,'%Y-%m-%d')"." as $key,";
				//$qry .= $key.",";
			}else{
				$qry .= $key.",";
			}	
		}
		$qry = substr($qry,0,-1);
		$qry .= " from ".$table;
		
		if($wherecond!=""){
			$qry .= " where ".$wherecond;
		}
		
		$sql = mysqli_query($con,$qry);
		$resultarray = Array();
	    echo $qry;
        if(mysqli_num_rows($sql) > 0){
		$j=0;
			while ($row = mysqli_fetch_array($sql,MYSQLI_ASSOC)) {
				$resultarray[$j] = $row;
				$j++;
			}
                
                // close connection to db
                return $resultarray;
        }
        // close connection to db
        return null;
	}
	
	function updatequery($tablename,$fields,$request,$wherecond,$con){
	
		$qry = "update $tablename set ";
		foreach($fields as $key=>$value){
			if($value=="notquote"){
				$qry .= $key."=".$request[$key].",";
			}else if($value=="file"){
			
			}else{
				$qry .= $key."='".$request[$key]."',";
			}
		}
		
		$qry .="updatedby='".$_SESSION['sessionlogin']."',dateupdated=now()";
		//$qry = substr($qry,0,-1);
		
		if($wherecond!=""){
			$qry .= " where ".$wherecond;
		}
		//echo $qry;
		$upd = mysqli_query($con,$qry);
		$affectedupdcount = mysqli_affected_rows($con);
		return $affectedupdcount;
	}

	
	function deletequery($tablename,$wherecond,$con){
		$qry = "delete from ".$tablename." where ".$wherecond;
		//echo $qry;
		$del = mysqli_query($con,$qry);
		$affectedupdcount = mysqli_affected_rows($con);
		return $affectedupdcount;
		
	}
	
	
	
	function empidcreation($tablename,$fieldname,$prestr,$con){	
	$qry="SELECT substr($fieldname, 4, length($fieldname)) as Lastval FROM $tablename order by Id desc limit 0,1 "; 
	echo $qry;
	$sql = mysqli_query($con,$qry);
	$row = mysqli_fetch_array($sql,MYSQLI_ASSOC);
	//echo $qry; 
	$latestval = $row["Lastval"];
	$latestval = str_replace("-","",$latestval);
	$latestval = $latestval+1;
	$latestval = str_pad($latestval, 4, "0", STR_PAD_LEFT);
	//echo $latestval;
	$latestvallast  = $prestr."-".$latestval;
	//exit;
	return $latestvallast; 
	}
	
	function begin()
	{
		mysqli_query($con,"BEGIN");
	}
	
	function commit()
	{
		mysqli_query($con,"COMMIT");
	}
	
	function rollback()
	{
		mysqli_query($con,"ROLLBACK");
	}
	
	function totalnumberqry($qry){
		$sql = mysqli_query($con,$qry);		
        $totalnumber = mysqli_num_rows($sql);
	    return $totalnumber;
	}

?>