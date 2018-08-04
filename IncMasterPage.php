<?php
$sbtbuttonvalue="Submit";
$selectfields = Array();

if($modeval=="edit"){
	$tablename  = $tablearray[$idval];
	$selectfields = selectexecutequery($tablename,$pagefields,"Id='$dispidval'",$con);
	$sbtbuttonvalue = "Update";
}



					//print_r($selQueryarr);
?>
<script type="text/javascript">
	<?php if($idval=="menu22" || $idval=="menu33"){ ?>
		window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"fromdate",
			dateFormat:"%Y-%m-%d",
			yearsRange:[1900,2020],
		});
			new JsDatePick({
			useMode:2,
			target:"todate",
			dateFormat:"%Y-%m-%d",
			yearsRange:[1900,2020],
		});
			
		};
	<? } ?>
</script>

<table cellpadding="5" cellspacing="0" border="0" width="100%">
	<?php 

	$irow=0;
	foreach($pagefields as $key=>$value){ 
	$irow=$irow+1;
	if($irow==1){
	?>
	<tr>
	<? } ?>
		<td align="right" class="font1" width="18%">
		<?php if($key!="Status" || ($modeval=="edit" && $key=="Status")){ ?>
		<?=$pagelables[$key]?>
			<?php
				if(in_array($key,$mendatoryfields)) {  ?>
				<sup style="color:red;">*</sup>
				<?
				}
				}
			?>
		</td>
		<td align="left">
			<?php if($value=="text"){  ?>
				<input type="text" name="<?=$key?>" id="<?=$key?>" class="text1" value="<?=$selectfields[0][$key]?>" maxlength="<?=$maxlengthfield[$key]?>">
			<?php } else if($value=="password"){  ?>
				<input type="password" name="<?=$key?>" id="<?=$key?>" class="text1" value="<?=$selectfields[0][$key]?>" maxlength="<?=$maxlengthfield[$key]?>">
			<?php } else if($value=="email"){  ?>
				<input type="text" name="<?=$key?>" id="<?=$key?>" class="text1" value="<?=$selectfields[0][$key]?>" maxlength="<?=$maxlengthfield[$key]?>">
			<?php }else if($value=="number"){  ?>
				<input type="text" name="<?=$key?>" id="<?=$key?>" class="text1" value="<?=$selectfields[0][$key]?>" maxlength="<?=$maxlengthfield[$key]?>">
			<?php }else if($value=="select"){ 
			
			if(($key!="Status" || $key!="SC_Active")|| ($modeval=="edit" && $key=="Status")){ 
				//echo $selQueryarr[$key];
			?>
				<select name="<?=$key?>" id="<?=$key?>" class="select1">
					<option value="">Select <?=$pagelables[$key]?></option>
					<?php 
					
					
						//$selvalarray = Array();						
						$selvalarray = selectexecute($selQueryarr[$key],$con); 
						foreach($selvalarray as $selkey=>$selval){ ?>
					<option value="<?=$selkey?>" <?php if($selectfields[0][$key]==$selkey){ echo "selected"; } ?>><?=$selval?></option>
					<?php
						}
					?>
				</select>
			<?php
				}
			}else if($value=="date"){ ?>
				<input type="text" name="<?=$key?>" id="<?=$key?>" class="text1" readonly value="<?=$selectfields[0][$key]?>">
			<?php }else if($value=="textarea"){ ?>
				<textarea name="<?=$key?>" id="<?=$key?>" cols="25" rows="6"><?=$selectfields[0][$key]?></textarea>
			<?php }else if($value=="mail"){ ?>
				<input type="text" name="<?=$key?>" id="<?=$key?>" class="text1" value="<?=$selectfields[0][$key]?>">
			<?php }else if($value=="amount"){ ?>
				<input type="text" name="<?=$key?>" id="<?=$key?>" class="text1" value="<?=$selectfields[0][$key]?>">
			<?php } else if($value=="file"){
			
			if($modeval=="edit"){ ?>
				<img src="images/adv/<?=$selectfields[0][$key]?>" width="250"><br>
				<a href="javascript:void(0);" onclick="fnuploadimg('<?=$tablename?>','<?=$key?>','<?=$dispidval?>');">Edit Image</a>
				<input type="hidden" name="<?=$key?>" id="<?=$key?>" class="text1" value="<?=$selectfields[0][$key]?>">
			<?
				
			}else{
			
			 ?>
				<input type="file" name="<?=$key?>" id="<?=$key?>" class="text1" value="<?=$selectfields[0][$key]?>">
			<?php 
			}} ?>
		</td>
		<?php if($irow==2){ 
		$irow=0;
		?>
	</tr>
	<?php } ?>
	<?php } ?>
	<tr>
		<td colspan="4" align="center"><input type="button" name="sbtbtn" id="sbtbtn" value="<?=$sbtbuttonvalue?>" class="button1" onclick="validate();"></td>
	</tr>
</table>

<script>
	function validate(){
		<?php 
		foreach($pagefields as $key=>$value){ 
			if(in_array($key,$mendatoryfields)) {
			if($key!="Status" || ($modeval=="edit" && $key=="Status")){
		?>
			if(document.dashform.<?=$key?>.value==""){
				alert("Please enter <?=$pagelables[$key]?> value");
				document.dashform.<?=$key?>.focus();
				return false;
			}

			if("<?=$value?>"=="text"){
		//	alert(isNaN(document.dashform.<?=$key?>.value));
				if(isNaN(document.dashform.<?=$key?>.value)==false){
					alert("Please enter <?=$value?> value");
					document.dashform.<?=$key?>.focus();
					return false;
				}
			}
		
		
			if("<?=$value?>"=="alphatext"){
		//	alert(isNaN(document.dashform.<?=$key?>.value));
				if(document.dashform.<?=$key?>.value==""){
					alert("Please enter alphabet value");
					document.dashform.<?=$key?>.focus();
					return false;
				}
			}			
			
			if("<?=$value?>"=="number"){
				if(isNaN(document.dashform.<?=$key?>.value)==true){
					alert("Please enter number value");
					document.dashform.<?=$key?>.focus();
					return false;
				}
			}
			if("<?=$value?>"=="email"){
				if(document.dashform.<?=$key?>.value!=""){
					if(validateEmail(document.dashform.<?=$key?>.value)==false){
						alert("Please enter valid Email");
						document.dashform.<?=$key?>.focus();
						return false;
					}
				}
			}
		<?php 
			}
			
			}
		} ?>
		
		var sbtbtnval  = "<?=$sbtbuttonvalue?>";
		var conf = confirm("Do You want to "+sbtbtnval);
		if(conf){
			document.dashform.action="valsave.php";
			document.dashform.submit();
		}
	}
	function fnuploadimg(table,keyval,idval){
		window.open('uploadpage.php?tablename='+table+'&fieldname='+keyval+'&idval='+idval, 'upload', 'width=800');
	}
	function validateEmail(emailField){
        var re = /\S+@\S+\.\S+/;
	    return re.test(emailField);
}
</script>
