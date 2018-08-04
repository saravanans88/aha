<?php
$displayqryarr = $displayarray[$idval];
$pagelablesdisp = $pagelabelarray[$idval];
$pagefields = $pagearray[$idval];	
$pagelables = $pagelabelarray[$idval];
$selQueryarr = $selectarray[$idval];	
$mendatoryfields = $mendatoryarray[$idval];
$maxlengthfield = $txtfieldlength[$idval];
//echo $displayqryarr["Qry"];
$dispvalarray = getUserInfo($displayqryarr["Qry"],$con); 

//echo $displayqryarr["Qry"];
$displaylables = $displayqryarr["displayfields"];
//print_r($pagelables);
$displablesarr = explode(",",$displaylables);

?>
<div align="center" style="padding-top:18px;">
<table cellpadding=5 cellspacing=1 class="dispclass" border=1>
	<tr>
			<?php foreach($displablesarr as $keylbl=>$vallabl){
			
			 ?>
				<th><b><?=$pagelablesdisp[$vallabl]?></b></th>
			<?php } ?>
			<th>&nbsp;</th>
	</tr>
	<?php
	if(sizeof($dispvalarray)>0){
	foreach($dispvalarray as $displkey=>$displvalue){ 
	//print_r($displvalue);
	?>
		<tr>
			<?php foreach($displablesarr as $keylbl=>$vallabl){ ?>
			<td align="center"><?=$displvalue[$vallabl]?></td>
			<?php } ?>
			<td align="center">
				<a href="displaypage.php?dispid=<?=$displvalue["Id"]?>&id=<?=$idval?>">View</a>&nbsp;|
				<a href="dashboard.php?&id=<?=$idval?>&dispid=<?=$displvalue["Id"]?>&mode=edit">Edit</a>
				<?php //if($displvalue["Status"]=="Active"){?>
				&nbsp;|
				<!--<a href="valsave.php?hdnidvalue=<?=$idval?>&hdndispidvalue=<?=$displvalue["Id"]?>&hdnmodevalue=Delete">Delete</a>-->
				<a href="javascript:fndelete('<?=$idval?>','<?=$displvalue["Id"]?>');">Delete</a>
				&nbsp;
				<?php //} ?>
			</td>
		</tr>
	<?php }
}else{ ?>
		<tr>
			<td colspan="<?=sizeof($displablesarr)?>" align="center"><b>No Records Found</b></td>
		</tr>
<?php

}
	?>
	<tr>
	</tr>
</table>
</div>

<script>
	function fndelete(idval,dispidval){
		var conf = confirm("Do you want to Delete?");
		if(conf){
			window.location.href="valsave.php?hdnidvalue="+idval+"&hdndispidvalue="+dispidval+"&hdnmodevalue=Delete";
		}
	}
</script>