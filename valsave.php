<?php session_start(); ?>
<?php include_once("include/topincludes.php");?>
<?php include_once("include/commonfn.php");?>
<?php include_once("include/filearray.php");?>
<?php include_once("include/dbconn.php");?>
<?php
$con=connectioncreation($servername,$user,$pword,$db);

$idval =replacenull($_REQUEST["hdnidvalue"]);
$dispidvalue =replacenull($_REQUEST["hdndispidvalue"]);
$modeval =replacenull($_REQUEST["hdnmodevalue"]);

$tablename  	= $tablearray[$idval];
$pagefields 	= $pagearray[$idval];
$uniquekeyfields = $uniquekeyarray[$idval];
$autofield  = $autoincfieldarray[$idval];


if($_SESSION['pagereload']=="Yes"){
	$_SESSION['pagereload']="No";
}

 if($_SESSION['pagereload']=="No"){
if($uniquekeyfields!=""){
		$keyvalchk =$_REQUEST[$uniquekeyfields];
		if($modeval=="edit"){
			$alrdyexistcond = " and Id!='$dispidvalue'";
		}
		
		$dispvalarray1 = getUserInfo("select * from $tablename where $uniquekeyfields='$keyvalchk' $alrdyexistcond",$con);
			
		if(count($dispvalarray1)>0){
			$modeval="alreadyexist";
		}

}

if($modeval=="save"){
	$empid = "";
	
	//echo $empid;
	if(count($autofield)>0){
	$empid = empidcreation($tablename,$autofield[0],$autofield[1],$con);	
	$pagefields[$autofield[0]]=$autofield[0];
	$_REQUEST[$autofield[0]]=$empid;
	}
	
	if($tablename=="serviceprovider"){
		$pagefields["location"] = "text";
		$_REQUEST["location"] = $_REQUEST["city"];
	}
	
	$insertid = insertquery($tablename,$pagefields,$_REQUEST,$_FILES,$con);

	if($insertid>0){
unset($pagefields);
unset($_REQUEST);
unset($_SESSION['pagereload']);
	?>
		
		<?php 
			 header("Location:dashboard.php?id=$idval&act=insertsuccess");
			  exit;
		?>
		<!--<META http-equiv="refresh" content="0;URL=dashboard.php?id=<?=$idval?>">--->
		
	<?
	
	}else if($modeval=="save"){
		  header("Location:dashboard.php?id=$idval&act=$modeval");
		  exit;
	}else{
		  header("Location:dashboard.php?id=$idval&act=fail");
		  exit;
	}
	
}else if($modeval=="edit"){
$updateid = updatequery($tablename,$pagefields,$_REQUEST," Id='$dispidvalue'",$con);
	
if($updateid>0){
	?>
		<!--<table cellpadding=0 cellspacing=0 width="100%">
			<tr>
				<td align="center">
					<h1>Record updated Successfully</h1>
				</td>
			</tr>
		</table>
		<META http-equiv="refresh" content="0;URL=dashboard.php?id=<?=$idval?>">-->
<?
			  header("Location:dashboard.php?id=$idval&act=updatesuccess");
			  exit;
	}else{
		?>
			<!--<table cellpadding=0 cellspacing=0 width="100%">
			<tr>
				<td align="center">
					<h1>Record not updated</h1>
				</td>
			</tr>
		</table>
		<META http-equiv="refresh" content="0;URL=dashboard.php?id=<?=$idval?>">-->
		
		<?
			 header("Location:dashboard.php?id=$idval&act=fail");
			 exit;
	}
}else if($modeval=="Delete"){
	$fieldval = Array("Status"=>"Status");
	$valueval = Array("Status"=>"Inactive");
	echo "sd";
	// $updateid = updatequery($tablename,$fieldval,$valueval," Id='$dispidvalue'",$con);
	
	$updateid = deletequery($tablename," Id='$dispidvalue'",$con);
	
	
	if($updateid>0){
	?>
		<!--<table cellpadding=0 cellspacing=0 width="100%">
			<tr>
				<td align="center">
					<h1>Record Moved to Inactive Successfully</h1>
				</td>
			</tr>
		</table>
		<META http-equiv="refresh" content="0;URL=dashboard.php?id=<?=$idval?>">-->
<?
		 	 header("Location:dashboard.php?id=$idval&act=delete");
			  exit;
	
	}else{
		?>
			<!--<table cellpadding=0 cellspacing=0 width="100%">
			<tr>
				<td align="center">
					<h1>Please try again.</h1>
				</td>
			</tr>
		</table>
		 <META http-equiv="refresh" content="0;URL=dashboard.php?id=<?=$idval?>">-->
		<?
			  header("Location:dashboard.php?id=$idval&act=fail");
			  exit;

	}

}else if($modeval=="alreadyexist"){
	?>
		<!--<table cellpadding=0 cellspacing=0 width="100%">
			<tr>
				<td align="center">
					<h1><?=$uniquekeyarray[$idval]?> Already exist.</h1>
				</td>
			</tr>
		</table>
		 <META http-equiv="refresh" content="0;URL=dashboard.php?id=<?=$idval?>">-->
	<?
		  header("Location:dashboard.php?id=$idval&act=alreadyexist");
		 	 exit;

}
}else{
	
	?>
		<!--<table cellpadding=0 cellspacing=0 width="100%">
			<tr>
				<td align="center">
					<h1>Please try again.</h1>
					<div align="center"><input type="button" value="Continue" onclick="Javascript:window.location.href='dashboard.php?id=<?=$idval?>'"></div>
				</td>
			</tr>
		</table>-->
	<?php
		  header("Location:dashboard.php?id=$idval&act=fail");
		 	 exit;

}
?>