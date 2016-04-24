# WebPortfolio
My Comment page. this page displays all the comments. 

<!DOCTYPE html>
<html>
<head>
<meta name='viewport' content='width=device-width' content='initial-scale=1' />
<title>Index page</title>
<link href='CSS/bootstrap.min.css' rel='stylesheet' type='text/css'/>
<link href='P.css' rel='stylesheet' type='text/css'/>
<script src='Errors.js'></script>
<script src='Common.js'></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
</head>
<body link='#E9F1EA'  	  
	  style='font-family:Arial; background:#C63D0F'>
	  
<div class="container">
	<p id='head'> Welcome to my blog </p>
	<div class="message_container">	  
		<? include_once("common.php");
			$arrMessages = loadMessages();
		//echo "<span>".var_dump($arrMessages)."</span>";
		 foreach ($arrMessages as $intKey => $strMsg) {
		 	$arrData = explode("/", $strMsg);	
		echo "<div class='Blog_message_Rules'>".$arrData[0]."<br>Posted By: ".$arrData[2]." On ".$arrData[1].
			  "</div><br>";
		 }?>
		 <span style="margin-left:0px; color:blue;" onclick="displayForm('comment_container')">[Write Comment]</span>&nbsp;&nbsp; <span style="color:blue;" onclick="redirectPage('http://asikpo.myweb.cs.uwindsor.ca')">[Log Out]</span>
		 <div id="comment_container">
		 	<textarea style="border-radius:10px; background:#e6e6e6;" id="message" class="form-control" rows="3"></textarea>
			<input type='submit' onclick="save()" style="margin-left:1px; margin-top: 3px;" class="btn btn-default" name='btnCreateAcct' value='Post'>
		 </div>
	</div>
</div>	
</body>
</html>



