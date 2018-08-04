<?php
session_start();
?>
<?php include_once("include/topincludes.php");?>

<?php


	$errormsg = "";
if(isset($_POST)){
	if($_POST["hdnsubmit"]=="submit"){
		
		 if ($_POST['captcha'] == $_SESSION['cap_code']) {
			 
			$usernamestr = $_POST["username"];
			 $hdnhash = $_POST["hdnhash"];
			 
			$_SESSION['sessionlogintime'] = date("d-m-Y H:i:s");
			$pwdstr = $_POST["pwd"];		
			if($usernamestr=="patient" && $pwdstr=="patient"){
				$_SESSION['sessionlogin'] = "patient";
				
				 header('Location: dashboard.php?id=menu11&hdnhash='.$hdnhash);
			}else if($usernamestr=="doctor" && $pwdstr=="doctor"){
				$_SESSION['sessionlogin'] = "doctor";
				
				 header('Location: dashboard.php?id=menu12&hdnhash='.$hdnhash);
			}else{
				$errormsg = "Please check the Username/Password";
			}
		}else{
				$errormsg = "Please enter correct captcha";
		}
	}
}

?>
<html>
	<head>
		
	</head>
	<body style='margin:0'>
		<table cellpadding=0 cellspacing=0 border=0 width='100%'>
			<tr>
				<td colspan="2">
					<?php include_once("header.php");?>
				</td>
			</tr>
			
			<tr>
				<td align="center" class="admintoptxt" width="75%"><i>&nbsp;</i></td>			
				<td align='center' valign="top">
					<form method="post" name="loginfrm" id="loginfrm">
					<input type="hidden" name="hdnsubmit" id="hdnsubmit">
						<input type="hidden" name="hdnhash" id="hdnhash">
						
						<table cellpadding="5" cellspacing="0" border="0"  width="100%" style='border:solid #144182 1px;'>
							<tr height="550px">
								<td valign="top">								
									<table cellpadding="10" cellspacing="0" border="0" width="100%">
									<? if($errormsg!=""){?>
									<tr height="20px">
										<td align="center" style='color:red;'  colspan="2"><?=$errormsg?></td>
									</tr>
									<? } ?>
										<tr>											
											<td align="center"><input type="text" name="username" id="username" class="text1" value="Username" onblur="if(this.value==''){ this.value='Username';}" onfocus="if(this.value=='Username'){ this.value=''; }"></td>
										</tr>
										<tr>											
											<td align="center"><input type="password" name="pwd" id="pwd" class="text1" value="Password" onblur="if(this.value==''){ this.value='Password';}" onfocus="if(this.value=='Password'){ this.value=''; }"></td>
										</tr> 
										<tr>
											<td align="center">
												<table cellpadding="8" cellspacing="0" border="0"  width="100%">
													<tr>
														<td colspan="2" align="center"><img src="captcha.php" width="150"/></td>
													</tr>
													<tr>
														<td align="right" class="font1"><b>Enter Captcha</b></td>
														<td align="left"> <input type="text" name="captcha" id="captcha" maxlength="6" size="6" style='width:120px;'/></td>
													</tr>
												</table>											
											</td>
										</tr>
										<tr>
											<td colspan="2" align="center">
												<input type="button" name="sbtbtn" id="sbtbtn" value="Submit" class="button1" onclick="fnsubmit();">
											</td>
										</tr>
									</table>
							</td>
							</tr>
						</table>
					</form>
				</td>
			</tr>	
		</table>
		<script type="text/javascript">
			function fnsubmit(){
				if(document.loginfrm.username.value=="Username"){
					alert("Please enter Username");
					document.loginfrm.username.focus();
					return false;
				}
				if(document.loginfrm.pwd.value=="Password"){
					alert("Please enter Password");
					document.loginfrm.pwd.focus();
					return false;
				}
				if(document.loginfrm.captcha.value==""){
					alert("Please enter Captcha");
					document.loginfrm.captcha.focus();
					return false;
				}
				document.loginfrm.hdnsubmit.value="submit";
				document.loginfrm.submit();
			}
		</script>
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="web3.min.js"></script>
<script>

	web3 = new Web3(new Web3.providers.HttpProvider("http://localhost:8545"));
 
															  
		web3.eth.defaultAccount = web3.eth.accounts[0];			
		
        var CoursesContract = web3.eth.contract([
	{
		"constant": false,
		"inputs": [
			{
				"name": "_fName",
				"type": "string"
			},
			{
				"name": "_hashstring",
				"type": "string"
			}
		],
		"name": "setInstructor",
		"outputs": [],
		"payable": false,
		"stateMutability": "nonpayable",
		"type": "function"
	},
	{
		"constant": true,
		"inputs": [],
		"name": "getInstructor",
		"outputs": [
			{
				"name": "",
				"type": "string"
			},
			{
				"name": "",
				"type": "string"
			}
		],
		"payable": false,
		"stateMutability": "view",
		"type": "function"
	}
]);
						  
var Courses = CoursesContract.at("0x30e090e6632e63b50fb87ca339164d61f06912d8");
	
	Courses.getInstructor(function(error, result){
  if(!error){
	  document.getElementById("hdnhash").value = result[1];
    console.log(result);
    }
 else
   console.error(error);
 });

</script>
	</body>
</html>
<?php  connectionclose($con); ?>
