<link rel="stylesheet" href="style/stylesheet.css?id=1" type="text/css">
<link rel="stylesheet" href="style/menus.css?id=1" type="text/css">
<script type="text/javascript" src="js/jquery.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="style/jsDatePick_ltr.min.css" />
	<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>
<table cellpadding=0 cellspacing=0 border=0 width='100%'>
	<tr class="topheadertrbg">
		<td align="left" class="topheadertd">
			<!--Fast Track-->
			
			<table cellpadding=0 cellspacing=0 border=0 width="100%">
				<tr>
					<td align="left">
						<!--<img src="images/logo.jpg">-->
					</td>
					<td align="right" valign="bottom">
					
					</td>
				</tr>
			</table>
		</td>
	</tr>		
	<tr height="25px" class="menubg">
		<td>
							<?php if($_SESSION['sessionlogin']!=""){ ?>
			<table cellpadding=0 cellspacing=0 width=100% border=0>
				<tr>	
					<td style='padding-left:10px;'>
						
					</td>
					<td  align="right" class="headfont" valign="bottom">
					<b>User Id : <?=$_SESSION['sessionlogin']?></b>
					</td>
					<td  align="right" class="headfont" valign="bottom" width="17%">
					
					<b>Login Time : <?=$_SESSION['sessionlogintime']?></b></td>
					<td align='right' style='padding-right:20px;padding-bottom:5px;' valign="bottom" width="11%">

					
					<a href="logout.php" class="headerlink">Logout</a>

					</td>
				</tr>
			</table>
								<?php } ?>
		</td>		
	</tr>	
</table>
<script type="text/javascript">
$(document).ready(function() {
		$('.myMenu > li').bind('mouseover', openSubMenu);
		$('.myMenu > li').bind('mouseout', closeSubMenu);
		
		function openSubMenu() {
			$(this).find('ul').css('visibility', 'visible');	
		};
		
		function closeSubMenu() {
			$(this).find('ul').css('visibility', 'hidden');	
		};
				   
});

function fntosearchclick(val,e){
var unicode=e.keyCode?e.keyCode : e.charCode;
if(unicode==13){
	if(val==""){
		alert("Please enter any search value");
		return false;
	}
	window.location.href="topstoreachdisplay.php?toptxtval="+val;
}
}

function fntopbranch(cityval){
	window.location.href="dashboard.php?cityval="+cityval;
}
function fntopsearch(e){
	if(e.keyCode==13){
		var topname = document.getElementById("topschoolname").value;
		var toppincode = document.getElementById("toppincode").value;
		window.location.href="topstoreachdisplay.php?topschoolname="+topname+"&toppincode="+toppincode;
	}
	
}
</script>
