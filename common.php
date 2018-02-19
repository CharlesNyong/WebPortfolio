<?php

include_once("Connection.php");

if($_POST["action"]){
	session_start();
	$_POST["action"]();
}

 //var_dump($_POST);
// if(isset($_POST["btnLogin"])){ // if the login button was pressed
//  	$strUserName = $_POST["UName"];
//   	$Password = $_POST["Pword"];
  	
//  	validateInput($strUserName, $Password);
//  	header("Location: Blog.php"); 	
// }
// else if(isset($_POST["btnCreateAcct"])){
// 	$strUserName = $_POST["Name"];
//   	$Password = $_POST["Word"];
//   	$Confirm = 	$_POST["ConfirmP"];
// 	createNewUser($strUserName, $Password, $Confirm);
// }

// if(isset($_POST["btnPost"])){
// 	$strUserName = $_SESSION["Username"];
//   	$Password = $_SESSION["Password"];
//   	//echo "<script type='text/javaScript'>DisplayMessage('Name: $strUserName')</script>";
// 	$blnSuccess = validateUser($strUserName); 
// 	 if($blnSuccess){		
// 	 	//call function to post blog messages
// 		$strMsg = $_POST["comment"];
// 		saveMessage($strUserName, $strMsg);
// 		// $arr = loadMessages();
// 		// $msg = $arr['Message'];
// 		// echo " 	<script type='text/javaScript'>
// 		// 		DisplayMessage('$msg')
// 		// 		</script>";	
// 	 }					
// }



function checkLogin(){
  	$strUserName = $_POST["Name"]; 
  	$Password = $_POST["Pword"];
  	$_SESSION["Username"] = $strUserName;
  	$_SESSION["Password"] = $Password;
	
	global $connection;
	$arrData = array();	
	$strSQL = "SELECT UserName, Password
		   FROM Users
		   WHERE UserName = '$strUserName' AND Password = '$Password' ";
			  
	$Result = mysqli_query($connection, $strSQL);
	//echo '<script type="text/javaScript">DisplayMessage("in function IncorrectLogin")</script>';
    //$arrRow = mysql_fetch_array($Result);
  
   		if(mysqli_num_rows($Result) > 0){
   			 $arrData[1] = true;
   		}
   		else{
     		 $arrData[1] = false;
     	}

     	echo json_encode($arrData);	
}

function validateUser(){
 	//include_once("Connection.php");
  $strUserName = $_POST["Name"];
  global $connection;
  //echo "<script type='text/javaScript'>DisplayMessage('$strUserName')</script>";
	//echo '<script type="text/javaScript">DisplayMessage("Called")</script>';
	$strSQL = "SELECT UserName FROM Users
			   WHERE UserName = '$strUserName' ";
		  
	$Result = mysqli_query($connection, $strSQL);
	
	if($Result){
		$arrData[3] = "true";	
	}
	else{
		$arrData[3] = "false";
	}

	echo json_encode($arrData);
}

function saveMessage(){
	//include_once("Connection.php");
	$strUserName = $_SESSION["Username"];
	$strBlogMessage = $_POST["text"];
	$date = date("Y-m-d H:i:s");
	global $connection;
	$arrData = array();
	//echo "<script type='text/javaScript'>DisplayMessage('Name: $strUserName Message: $strBlogMessage)</script>";
	$strSQL = "INSERT INTO Posts
				   VALUES ('$strUserName', '$strBlogMessage', '$date')";

	$Result = mysqli_query($connection, $strSQL);
	

	if ($Result) {
		$arrData[1] = "true";

		 $arrMessages = loadMessageByDate($date);
		//echo "<span>".var_dump($arrMessages)."</span>";
		 foreach ($arrMessages as $intKey => $strMsg) {
		 	$arrMsgValue = explode("/", $strMsg);	
			$arrData[2] = $arrMsgValue[0];
			$arrData[3] = $arrMsgValue[2];
			$arrData[4] = $arrMsgValue[1];
		 }
	}
	else{
		$arrData[1] = "false";
	}		

	echo json_encode($arrData);   
}

function loadMessages(){
	//include_once("Connection.php");
 	global $connection;
 	//$arrMessages = array();

	$strSQL = "SELECT UserName, Message, dtmDate FROM Posts";
	
 	$Result = mysqli_query($connection, $strSQL);

	while ($arrRow = mysqli_fetch_assoc($Result)) {
			$arrMessages[] = $arrRow['Message']. "/" .$arrRow['dtmDate']. "/" .$arrRow['UserName'];
	} 	
	 //$arrMessages["Name"] = "hello";
 	
 	return $arrMessages;
}

function loadMessageByDate($dtmDatePosted){
	global $connection;
 	$arrMessages = array();

	$strSQL = "SELECT UserName, Message, dtmDate FROM Posts
				WHERE dtmDate = '$dtmDatePosted' "; 

 	$Result = mysqli_query($connection, $strSQL);

	while ($arrRow = mysqli_fetch_assoc($Result)) {
			$arrMessages[] = $arrRow['Message']. "/" .$arrRow['dtmDate']. "/" .$arrRow['UserName'];
	} 	
	 //$arrMessages["Name"] = "hello"; 
 	//echo $strSQL;
 	return $arrMessages;
}
/* check to make sure that the new user doesn't have
an account already before storing in the database
*/
function createNewUser(){
	//include_once("Connection.php");
	$strUserName = $_POST["Name"];
	$Password = $_POST["Pword"];
	$Confirm = $_POST["confirm"];

	global $connection;
	$arrData = array();	

	$strSQL = "INSERT INTO Users
			   VALUES ('$strUserName', '$Password')";

	$Result = mysqli_query($connection, $strSQL);

		if($Result){
			$arrData[2] = "true";	
		}		   
	echo json_encode($arrData);
}

?>
