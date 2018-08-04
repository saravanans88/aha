<?php session_start(); ?>
<?php include_once("include/topincludes.php");?>
<?php include_once("include/commonfn.php");?>
<?php include_once("include/filearray.php");?>
<?php include_once("include/dbconn.php");?>
<?php
//error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);

//DB Connection Creation

$_SESSION['pagereload']="Yes";

$idval =replacenull($_REQUEST["id"]);
$dispidval =replacenull($_REQUEST["dispid"]);
$modeval =replacenull($_REQUEST["mode"],"save");
$actvalstr = replacenull($_REQUEST["act"],"save");
$hdnhash = $_GET["hdnhash"];



$class1str = "tabbertabtop";
$class2str = "tabbertabtopprss";
$displaydiv1 = "";
$displaydiv2 = "style='display:none;'";

$errormsg = "";


if($_REQUEST["act"]=="success"){
	$errormsg = "Patient Details added successfully";
}
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}



	
	$patientArray = array();
	
	if($_REQUEST["id"]=="menu12"){
		 $ch = curl_init();
		// set url
		curl_setopt($ch, CURLOPT_URL, "https://ipfs.io/ipfs/".$_GET["hdnhash"]);
		//return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// $output contains the output string
		$output = curl_exec($ch);
		// close curl resource to free up system resources
		curl_close($ch); 
		$patientArray = json_decode($output);
	}

if($_REQUEST["submit"]=="Submit"){
		$patientname = $_REQUEST["patientname"];
	    $nhsnumber = $_REQUEST["nhsnumber"];
	    $phoneno = $_REQUEST["phoneno"];
	    $dob = $_REQUEST["dob"];
	    $contact = $_REQUEST["contact"];
	    $address = $_REQUEST["address"];
	
	
	$output = array();
	$outputstring = "";
	
	
	if($hdnhash!=""){
		 $ch = curl_init();
		// set url
		curl_setopt($ch, CURLOPT_URL, "https://ipfs.io/ipfs/".$_GET["hdnhash"]);
		//return the transfer as a string
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		// $output contains the output string
		$output = curl_exec($ch);
		// close curl resource to free up system resources
		curl_close($ch); 
		$outputstring = $output;
		$output = json_decode($outputstring);
		
		
	}
	
	
	 $data = array();
	 $datapre = array();
	 $patientdata = array();
	 $patientdata["patientname"]=$patientname;
	 $patientdata["nhsnumber"]=$nhsnumber;
	 $patientdata["phoneno"]=$phoneno;
	 $patientdata["dob"]=$dob;
	 $patientdata["contact"]=$contact;
	 $patientdata["address"]=$address;
	
	

	$my_file = 'files/file.txt';
	chmod($my_file,777);
	$handle = fopen($my_file, 'w') or die('Cannot open file:  '.$my_file);
	
	if($outputstring!==""){
		$data[generateRandomString(12)] = $patientdata;
		array_push($output,$data);
		$datastr = json_encode($output);
	 fwrite($handle, $datastr);
	}else{
	 $data[generateRandomString(12)] = $patientdata;
	 array_push($datapre,$data);
	 $datastr = json_encode($datapre);
		
	 fwrite($handle, $datastr);
	}
	
	echo $datastr;
	

	 header('Location: save.php?name='.$patientname.'&hdnhash='.$_GET["hdnhash"]);
}


?>
<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript">
	
		window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"dob",
			dateFormat:"%Y-%m-%d",
			yearsRange:[1900,2020],
		});
			
			
		};
	
</script>
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
										<td align="left">
											<table cellpadding=1 cellspacing=0 border=0 width="50%">
											<tr>
												
												<td align="left">			
													<?php if($idval=="menu11"){ ?>
													<div class="<?=$class2str?>" id="classdiv2"><b>Add Patient Details</b></div>
													<?php }else{ ?>
													<div class="<?=$class2str?>" id="classdiv2"><b>view Patient Details</b></div>
													<?php } ?>
												</td>
											</tr>
										</table>
										</td>
									</tr>
									<tr>
										<td>
											<div class="tabber">
																							
												<div class="tabbertab" align="center" id="div2">	
												<?php if($idval=="menu11"){ ?>
													<table cellpadding="10" cellspacing="0" border="0" width="100%">
														<tr>
															<td align="right" class="font1" width="18%">
																Patient Name
															</td>
															<td align="left">
																<input type="text" name="patientname" id="patientname" class="text1" value="">
															<td>
																<td align="right" class="font1">
																Date Of Birth
															</td>
															<td align="left">
																<input type="text" name="dob" id="dob" class="text1" readonly value="">
															<td>
														</tr>
														<tr>
															<td align="right" class="font1">
																NHS Number
															</td>
															<td align="left">
																<input type="text" name="nhsnumber" id="nhsnumber" class="text1" value="">
															<td>
																<td align="right" class="font1">
																Emergency Contact
															</td>
															<td align="left">
																<input type="text" name="contact" id="contact" class="text1" value="">
															<td>
														</tr>
														<tr>
															<td align="right" class="font1">
																Phone Number
															</td>
															<td align="left">
																<input type="text" name="phoneno" id="phoneno" class="text1" value="">
															<td>
																<td align="right" class="font1">
																Address
															</td>
															<td align="left">
																<textarea name="address" id="address" style="width:210px;height:50px;"></textarea>
															<td>
														</tr>
														<tr>
															<td colspan="6" align="center">
																<input type="submit" name="submit" id="submit" value="Submit" class="button1" >
															</td>
														</tr>
													</table>
													<?php }else{ ?>
													<table cellpadding=5 cellspacing=1 class="dispclass" border=1>
														<tr>
															<th><b>S.No</b></th>
															<th><b>Patient Address</b></th>
															<th></th>
														</tr>
														<?php 
																$count = 1;
	$stdArray = array();
																foreach($patientArray as $key=>$val){ 
																	
																	foreach($val as $innerkey => $innervalue)
																	{
																		$stdArray[$innerkey] = (array) $innervalue;
																	} 
																	
																}
                                                               }
														foreach($stdArray as $key=>$val){ 
														?>
														<tr>
															<td align="center"><?php echo $count;  ?></td>
															<td align="center"><?php echo $key  ?></td>
															<td align="center"><a href="javascript:fncheck('<?=$key?>');">View</a></td>
														</tr>
														<?php 
																							  $count++;
														}
																							   ?>
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
					<input type="hidden" name="hdnhash" id="hdnhash" > 
					
					</form> 
				</td>
			</tr>
		</table>
		
		
	</body>
	<script>
		function fncheck(){
			alert("View request sent to respective patient.");
		}
	</script>
</html>