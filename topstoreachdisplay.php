<?php session_start(); ?>
<?php/// include_once("websfn/curlwebservice.php");?>
<?php include_once("include/topincludes.php");?>
<?php include_once("include/commonfn.php");?>
<?php include_once("include/filearray.php");?>
<?php include_once("include/dbconn.php");?>
<?
//DB Connection Creation
$con=connectioncreation($servername,$user,$pword,$db);
$_SESSION['pagereload']="Yes";

$topschoolname =replacenull($_REQUEST["topschoolname"]);
$toppincode =replacenull($_REQUEST["toppincode"]);

$wherecondition = " ";

if($topschoolname!="Enter School Name"){
	$wherecondition = " and SM.SC_Name like '%$topschoolname%'";
}

if($toppincode!="Enter Pincode"){
	$wherecondition = " and SM.SC_Pincode like '%$toppincode%'";
}



$class1str = "tabbertabtop";
$class2str = "tabbertabtopprss";
$displaydiv1 = "";
$displaydiv2 = "style='display:none;'";


?>
<html>
	<head>
	</head>
	<body style='margin:0'>
		<table cellpadding=0 cellspacing=0 border=0 width='100%'>
			<tr>
				<td>
					<?php include_once("header.php");?>
				</td>
			</tr>
			<tr>
				<td valign="top">
				<form name="dashform" id="dashform" method="post" enctype="multipart/form-data"> 
					<table cellpadding=0 cellspacing=0 border=0 width='100%'>
						<tr height="550px">
							
							<td valign="top" style="border-bottom:solid #144182 1px">
								<table cellpadding=0 cellspacing=0 border=0 width='100%'>
									<tr height="60px">
										<td align="center" style='color:red;'><b><?=$errormsg?></b></td>
									</tr>									
									<tr>
										<td align='center' valign="top">
									<tr>
										<td align="left">
											<table cellpadding=1 cellspacing=0 border=0 width="50%">
											<tr>
												<td><div class="tabbertabtop" ><b>View School</b></div></td>
												
											</tr>
										</table>
										</td>
									</tr>
									<tr>
										<td>
											<div class="tabber">
												<div class="tabbertab" id="div1" align="center">
												<?php 
												$dispvalarray = getUserInfo("select SM.Id,SM.SC_Name,SM.SC_Location_Name from schoolmaster SM where 1=1 $wherecondition"); 			
//echo "select SM.Id,SM.SC_Name,SM.SC_Location_Name from schoolmaster SM where 1=1 $wherecondition";
												//echo "select SM.SC_Name,SM.SC_Location_Name from schoolmaster SM where 1=1 $wherecondition";												
												?>								
												<table cellpadding=5 cellspacing=1 class="dispclassfreesize" border=0 width="50%">
													<tr>
														<th><b>School Name</b></th>
														<th><b>location</b></th>
														<th>&nbsp;</th>
													</tr>
													<? if(sizeof($dispvalarray)>0){
														foreach($dispvalarray as $displkey=>$displvalue){ 
													 ?>
														<tr>
															<td align="center"><?=$displvalue["SC_Name"]?></td>
															<td  align="center"><?=$displvalue["SC_Location_Name"]?></td>
															<td  align="center"><a href="displaypage.php?dispid=<?=$displvalue["Id"]?>&id=menu978">View</a></td>
														</tr>
													<?
														}
													 }else{ ?>
														<tr>
															<td align="center" colspan="3"><b>No Records Found.</b></td>
															
														</tr>
													<? } ?>
												</table>		
												</div>												
												
											</div>
										</td>
									</tr>
									
								</table>
							</td>
						</tr>
					</table>
					<input type="hidden" name="hdnidvalue" id="hdnidvalue" value="<?=$idval?>"> 
					<input type="hidden" name="hdnmodevalue" id="hdnmodevalue" value="<?=$modeval?>"> 
					<input type="hidden" name="hdndispidvalue" id="hdndispidvalue" value="<?=$dispidval?>"> 
					
					</form> 
				</td>
			</tr>
		</table>
<script>
	function fndisplaydiv(divid1,divid2,class1,class2){
	document.getElementById(divid1).style.display="none";
	document.getElementById(divid2).style.display="block";
	document.getElementById(class1).className = 'tabbertabtop';
	document.getElementById(class2).className = 'tabbertabtopprss	';
}
</script>
	</body>
	
</html>