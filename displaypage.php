<?php session_start(); ?>
<?php include_once("include/topincludes.php");?>
<?php include_once("include/commonfn.php");?>
<?php include_once("include/filearray.php");?>
<?php include_once("include/dbconn.php");?>
<?
//DB Connection Creation
$con = connectioncreation($servername,$user,$pword,$db);
$idval =replacenull($_REQUEST["id"]);
$dispidval =replacenull($_REQUEST["dispid"]);
$pagefields = array();
$empidfields = array();
$oldpagefields=array();
$pagefields = $pagearray[$idval];
$tablename  = $tablearray[$idval];
$pagelables = $pagelabelarray[$idval];
$pagelablesdisp = $pagelabelarray[$idval];

$oldpagefields = $pagefields;



if($idval=="menu11"){
	$pagefields = array_merge($empidfields,$pagefields);
}

$wherecond ="Id='$dispidval'";
if(count($fullviewdispfieldswherearray[$idval])>0){
	$pagefields = $fullviewdispfieldswherearray[$idval];
	$tablepfx = $pagefields["wherefield"];
	unset($pagefields["wherefield"]);
	$wherecond ="$tablepfx.Id='$dispidval'";
}



if(count($fullviewdisptablearray[$idval])>0){
	$tablename = $fullviewdisptablearray[$idval];
}


$selectfields = selectexecutequery($tablename,$pagefields,"$wherecond".$fullviewdispwherearray[$idval],$con);

?>
<!DOCTYPE html>
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
							<td valign="top" >
									
										<table cellpadding="6" cellspacing="0" border="0" width="100%">
										<tr height="60px">
										<td align="center" style='color:red;'><b><?=$errormsg?></b></td>
									</tr>
											<tr>
												<td align="left" style="border-bottom:solid #144182 1px">
													
													<table cellpadding=1 cellspacing=0 border=0 width="50%">
														<tr>
															<td width="50%" align="left"><div class="tabbertabtop"><b>View <?=$headerarray[$idval]?></b></div></td>
															
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td align="center">
												<div align="right">
													<input type="button" name="btnback" id="btnback" value="Back" onclick="javascript:history.back(-1);" class="button1"><br><br>
												</div>
													<table cellpadding="4" cellspacing="0" border="0" width="90%"  class="dispclass" >
														<?php foreach($selectfields as $key=>$value){
										$irow=0;
																foreach($value as $innerkey=>$innervalue){
																$irow=$irow+1;
													if($irow==1){
														?>
														<tr>
													<?php } 
													if($oldpagefields[$innerkey]=="file"){
																?>
																<td width="18%" align="right"><b><?=$pagelables[$innerkey]?></b></td><td> : </td><td align="left" width="30%">						
																
																<img src="images/<?=$innerkey?>/<?=$innervalue?>" width="200">						
																</td>
																<?
															}else{
													?>
															<td width="18%" align="right"><b><?=$pagelables[$innerkey]?></b></td><td> : </td><td align="left">
															<? if($pagelables[$innerkey]=="Status"){ 
															
																if($innervalue=="Y"){
																	echo "Active";
																}else{
																	echo "In Active";
																}
															
															 }else{  ?>
																<?=$innervalue?>
															<? } ?>
															
															
															</td>
												<?php 
												}
												if($irow==2){ 
												$irow=0;
												?>
														</tr>
														<?php 
														}
														}
														} ?>
													</table>
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