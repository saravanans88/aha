<?php
$name = $_REQUEST["name"];
?>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <script src="buffer.js"></script>
    <script src="https://unpkg.com/ipfs-api@9.0.0/dist/index.js"
    integrity="sha384-5bXRcW9kyxxnSMbOoHzraqa7Z0PQWIao+cgeg327zit1hz5LZCEbIMx/LWKPReuB"
    crossorigin="anonymous"></script>
	 
  </head>

  <body>
	  <input type="hidden" name="hiddenhash" id="hiddenhash" value="<?=$_GET["hdnhash"]?>">
	  <input type="hidden" name="hiddenname" id="hiddenname" value="<?=$name?>">
	   <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="web3.min.js"></script>
	  <script type="text/javascript">
 function storehash(hash){
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
	
	
 Courses.setInstructor(document.getElementById("hiddenname").value, hash);
	// Courses.setInstructor('d', 'ds');

	
	Courses.getInstructor(function(error, result){
  if(!error){
    $("#instructor").html(result[0]+' ('+result[1]+' years old)');
	  document.getElementById("hiddenhash").value = result[1];
	  // alert(document.getElementById("hiddenhash").value);
    console.log(result);
	  
	  
    }
 else
   console.error(error);
 });
}
   
      const reader = new FileReader();
      reader.onloadend = function() {
        const ipfs = window.IpfsApi('localhost', 5001) // Connect to IPFS
        const buf = buffer.Buffer(reader.result) // Convert data into buffer
        ipfs.files.add(buf, (err, result) => { // Upload buffer to IPFS
          if(err) {
            console.error(err)
            return
          }
          let url = `https://ipfs.io/ipfs/${result[0].hash}`
		   let urlhash = `${result[0].hash}`
          console.log(`Url --> ${url}`)
          
          document.getElementById("hiddenhash").value =urlhash;
			 
			
			storehash(urlhash);
        })
      }
	  
	  
	    var xhr = new XMLHttpRequest();
		xhr.open('get', 'files/file.txt');
		xhr.responseType = 'blob'; // we request the response to be a Blob
		xhr.onload = function(e){
		  reader.readAsArrayBuffer(this.response);
		}
		xhr.send();
		
		  
		  setTimeout(myFunction, 4000);
		  function myFunction() {
			location.href = "dashboard.php?act=success&id=menu11&hdnhash="+document.getElementById("hiddenhash").value;
		}
		  
   
  </script>
	  <table cellpadding=0 cellspacing=0 border=0 width='100%'>
		<tr>
			<td>
				<?php include_once("header.php");?>
			</td>
		</tr>
		 <tr>
				<td valign="top">
					<table cellpadding=0 cellspacing=0 border=0 width='100%'>
						<tr height="120px">
							<td valign="top">
								
							</td>
						</tr>
						<tr height="120px">
							<td valign="top" align="center">
								<h1>Patient Details Added Successfully. </h1>
								<h3>Don't Refresh he page. It will redirect to Dashboard</h3>
								<input type="button" name="submit" id="submit" value="Back" onclick="myFunction()">
							</td>
						</tr>
					</table>
			 </td>
		  </tr>
	  </table>
  </body>
</html>