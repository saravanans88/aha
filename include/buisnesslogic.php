<?php include_once("topincludes.php");?>
<?php include_once("commonfn.php");?>
<?php include_once("dbconn.php");?>
<?php
$act =replacenull($_REQUEST["act"]);
$con=connectioncreation($servername,$user,$pword,$db);
if($act=="frontsearch"){
		$schoolname =replacenull($_REQUEST["schoolname"]);
		$pincode =replacenull($_REQUEST["pincode"]);
		$institute =replacenull($_REQUEST["institute"]);
		$location =replacenull($_REQUEST["location"]);
		$page =replacenull($_REQUEST["page"]);
		$limit =replacenull($_REQUEST["limit"]);
		$schoolid =replacenull($_REQUEST["schoolid"]);
		
		
		
		if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
		else
		$start = 0;								//if no page var is given, set start to 0
		
		$wherecond="";
		
		if($schoolid!=""){
			$wherecond=" and sm.id='$schoolid'";
		}else{
		
			if($institute!=""){
				$wherecond .=" and sm.IN_Board_Code='".$institute."'";
			}
				
			if($location!=""){
				$wherecond .=" and sm.LN_Code='".$location."'";
			}
			
			if($schoolname!="" || $pincode!=""){
			
				$wherecond .="  ";
				if($schoolname!=""){
					$wherecond .=" and sm.SC_Name like '%".$schoolname."%' ";
				}
				
				if($pincode!=""){
					$wherecond .=" and sm.SC_Pincode='".$pincode."' ";
				}
			}
		}
		
	
		$searchresult = getUserInfo("select sm.id,lm.LN_Location_Name,IM.IN_Board_Name,sm.SC_Name,sm.SC_Medium,sm.SC_Phone_1,sm.SC_Phone_2,sm.SC_Address_1,sm.SC_Address_2,sm.SC_Address_3 ,sm.SC_Email_ID,sm.SC_FAX,sm.SC_Pincode,sm.SC_URL,sm.SC_Google_Map_loc,sm.SC_Image_loc,scd.SD_timing,scd.SD_Spl_Rating,scd.SD_Spl_Rating_Remarks,scd.SD_low_std,scd.SD_High_std,scd.SD_edu_pattern,scd.SD_uniform_boy,scd.SD_Uniform_Boy_Image,scd.SD_uniform_girl,scd.SD_Uniform_Giri_Image,scd.SD_van_facility,scd.SD_extra_curr1,scd.SD_extra_curr2,scd.SD_extra_curr3,scd.SD_spl_tieup,scd.SD_teacher_pupil_ratio,scd.SD_lab_facility,scd.SD_sports_facility,scd.SD_technology_usage,scd.SD_academics,scd.SD_addl_remarks from schooldatamaster scd,schoolmaster sm,locationmaster lm,institutemaster IM where lm.LN_Code=sm.LN_Code and IM.IN_Board_Code=sm.IN_Board_Code and sm.SC_Code=scd.SC_Code   and sm.SC_Active='Y' $wherecond limit $start,$limit");
		
		$girluniformimg = $val["SD_Uniform_Giri_Image"];
		if($val["SD_Uniform_Giri_Image"]==""){
			$girluniformimg="no";
		}

		$jsonstr = '{"schooldata":[';
		foreach($searchresult as  $key=>$val){
		
		$splratingvals  = $val["SD_Spl_Rating"];
		
		$splratingremarksstr = "<img src='images/star-grey.png'><img src='images/star-grey.png'><img src='images/star-grey.png'><img src='images/star-grey.png'><img src='images/star-grey.png'>";
		
		if($splratingvals>0){
			for($i=0;$i<$splratingvals;$i++){
				$splratingremarksstr = "<img src='images/star.png'><img src='images/star.png'><img src='images/star.png'><img src='images/star.png'><img src='images/star.png'>";
			}
		}
		
		
			$jsonstr .='{"id":"'.$val["id"].'","Location":"'.$val["LN_Location_Name"].'", "Board":"'.$val["IN_Board_Name"].'", "Schoolname":"'.$val["SC_Name"].'", "Medium":"'.$val["SC_Medium"].'", "Phone":"'.$val["SC_Phone_1"].'", "Address":"'.$val["SC_Address_1"].",".$val["SC_Address_2"].",".$val["SC_Address_3"].'", "Email":"'.$val["SC_Email_ID"].'", "Fax":"'.$val["SC_FAX"].'", "Pincode":"'.$val["SC_Pincode"].'", "URL":"'.$val["SC_URL"].'", "Googlemaploc":"'.$val["SC_Google_Map_loc"].'", "Schoolimg":"'.$val["SC_Image_loc"].'", "Timing":"'.$val["SD_timing"].'", "Splrating":"'.$splratingremarksstr.'", "Splratingremarks":"'.$val["SD_Spl_Rating_Remarks"].'", "Lowestd":"'.$val["SD_low_std"].'", "Higherstd":"'.$val["SD_High_std"].'", "EducationPattern":"'.$val["SD_edu_pattern"].'", "BoyUniform":"'.$val["SD_uniform_boy"].'", "BoyUniformimg":"'.$val["SD_Uniform_Boy_Image"].'", "GirlUniform":"'.$val["SD_uniform_girl"].'", "GirlUniformimg":"'.$girluniformimg.'", "Vanfacility":"'.$val["SD_van_facility"].'", "Extracurricular":"'.$val["SD_extra_curr1"].'", "Spltieup":"'.$val["SD_spl_tieup"].'", "Teacheroupilratio":"'.$val["SD_teacher_pupil_ratio"].'", "Labfacility":"'.$val["SD_lab_facility"].'", "Sportsfacility":"'.$val["SD_sports_facility"].'", "Technologyusage":"'.$val["SD_technology_usage"].'", "Academics":"'.$val["SD_academics"].'", "AdditionalRemarks":"'.$val["SD_addl_remarks"].'"},';
		}
		
		$jsonstr = substr($jsonstr,0,-1);
		$jsonstr .=']}';
		
	echo $jsonstr; 
	//echo "s";
}
?>
<?php connectionclose($con); ?>
