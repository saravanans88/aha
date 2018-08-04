<?php session_start(); ?>
<?php include_once("websfn/curlwebservice.php");?>
<?php include_once("include/topincludes.php");?>
<?php include_once("include/commonfn.php");?>
<?php include_once("include/filearray.php");?>
<?php include_once("include/dbconn.php");?>
<?
//DB Connection Creation
$con=connectioncreation($servername,$user,$pword,$db);
$_SESSION['pagereload']="Yes";

$idval =replacenull($_REQUEST["id"]);
$dispidval =replacenull($_REQUEST["dispid"]);

$tablename =replacenull($_REQUEST["tablename"]);
$fieldname =replacenull($_REQUEST["fieldname"]);
$idval =replacenull($_REQUEST["idval"]);

if($_REQUEST["hdnsubmit"]=="submit"){
	if($_FILES[$fieldname]['name'] != "" ){
		 move_uploaded_file($_FILES[$fieldname]["tmp_name"],"images/adv/" . $_FILES[$fieldname]["name"]);
	}
	
	
	$pagefields = array($fieldname=>$fieldname);
	$pagevalues = array($fieldname=>$_FILES[$fieldname]['name']);
	$updateid = updatequery($tablename,$pagefields,$pagevalues," Id='$idval'",$con);
	
	if($updateid>0){
		header("Location:uploadpage.php?tablename=$tablename&fieldname=$fieldname&idval=$idval&act=insertsuccess");
		exit;
	}
}
$errormsg= "";
if($_REQUEST["act"]=="insertsuccess"){
	$errormsg = "Image Uploaded Successfully.";
}

?>

<html>
	<head></head>
	<body>
		<form enctype="multipart/form-data" name="uploadfrm" method="post">
		<input type="hidden" name="hdnsubmit" id="hdnsubmit" value="">
		<div align="right"><a href="javascript:void(0);" onclick="fnclose();">Close</a></div>
		<div align="center" style='color:red;'><?=$errormsg?></div> 
		<table cellpadding=6 celspacing=0 border=0 width=100%>
			<tr>
				<td align="right" width="40%">Image</td>
				<td align="left"><input type="file" name="<?=$fieldname?>" id="<?=$fieldname?>"></td>
			</tr>
			<tr>
				<td align="center" colspan="2">
					<input type="button" name="sbtbtn"  id="sbtbtn" onclick="fnsubmit();" value="Submit">
				</td>
			</tr>
		</table>
		 </form>
		 
		 <script>
		 	function fnsubmit(){
				if(document.uploadfrm.<?=$fieldname?>.value==""){
					alert("Please select Image");
					document.uploadfrm.<?=$fieldname?>.focus();
					return false;
				}
				document.uploadfrm.hdnsubmit.value="submit";
				document.uploadfrm.submit();
			}
			function fnclose(){
				window.opener.location.reload();
				window.close();
			}
		 </script>
	</body>
</html>

<? connectionclose($con);?>