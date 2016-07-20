function displayForm(strId){
	document.getElementById(strId).style.display = "block";
}

function redirectPage(strUrl) {
   window.location.href = strUrl;
}

function validateLogin(){

	if($('#UserN').val() == "" && $('#PWord').val() == ""){
		alert("Please Enter your user name and password");
	}
	else if($('#UserN').val() == ""){
		alert("Please enter your username");
	}
	else if($('#PWord').val() == ""){
		alert("Please enter your password");
	}
	else{

	$.ajax({

		  url: 'common.php',
		  type: 'POST',
		  data: {
		      action: 'checkLogin',
		      Name: $("#UserN").val(),
		      Pword: $("#PWord").val() 
		    },
		   dataType: 'json',
		  success: function(data){

		    if(data[1]){
		    	redirectPage("http://asikpo.myweb.cs.uwindsor.ca/Blog_Comments.php");
		    	//alert("Welcome to my blog");
		    	// $("#message").show();
		    	// $("#blogger").show();
		    }
		    else if(!data[1]){
		    	alert("Create a new account: user does not exist");
		    }
		  },
		   
		  error: function(request, response){
		    alert(request.responseText);
		  }

    	});
	}
}

function validateUser(strName){

		$.ajax({

		  url: 'common.php',
		  type: 'POST',
		  data: {
			      action: 'validateUser',
			      Name: strName
		        },

		   dataType: 'json',
		  
		  success: function(data){  
		    if(data[3] == "true"){
		    	return true;
		    }
		    else if(data[3] == "false"){
		    	return false;
		    }
		  },  
		  error: function(request, response){
		    alert(request.responseText);
		  }

    	});
}

function newUser(){

	if( $("#NewU").val() == "" || $("#NewP").val() == ""){
		alert("Username or password missing");
	}	
	else if( $("#Cp").val() != $("#NewP").val()){
  		alert("Password does not match");
  	}
  	else if(validateUser($("#NewU").val()) ){
  		alert("UserName already exist");	
  	}
  	else{	

		$.ajax({

			  url: 'common.php',
			  type: 'POST',
			  data: {
			      action: 'createNewUser',
			      Name: $("#NewU").val(),
			      Pword: $("#NewP").val(),
			      confirm:  $("#Cp").val()
			    },
			   dataType: 'json',
			  success: function(data){
			    
			    if(data[2] == "true"){
			    	alert("Account successfully created! Please sign in to start blogging!!!");
			    }
			    else if(data[2] == "false"){
			    	alert("couldn't create account");
			    }
			  },
			   
			  error: function(request, response){
			    alert(request.responseText);
			  }

			});
	}
}


function save(){

	if( $("#message").val()){

		$.ajax({

			  url: 'common.php',
			  type: 'POST',
			  data: {
			      action: 'saveMessage',
			      text: $("#message").val()
			    },
			   dataType: 'json',
			  success: function(data){
			    if(data[1] == "true"){
			    	// create a new div element to hold the message
			    	var NewMessageTag = document.createElement("div");
			    	var Paragraph = document.createElement("p");
			    	var PageBreakTag = document.createElement("br");
			    	NewMessageTag.setAttribute('class', 'Blog_message_Rules');
			    	Paragraph.setAttribute('class', 'paraSpace');
			    	// create the values that will appear in the new div element
			    	var message = document.createTextNode(data[2]);
			    	var AuthorAndDate = document.createTextNode(" Posted By: " + data[3] + " On " + data[4]);
			    	// add the values onto the the new div element
			    	NewMessageTag.appendChild(message);
			    	NewMessageTag.appendChild(Paragraph);
			    	NewMessageTag.appendChild(AuthorAndDate);
			    	//NewMessageTag.appendChild(ClosingDivTag);
			    	// add the new div element with it value onto the container that holds all messages	
			    	var Child = document.getElementById("CommentTag");
					var Parent = document.getElementById("MsgHolder");
					Parent.insertBefore(NewMessageTag, Child);
					//Parent.insertBefore(Paragraph, Child);
					Parent.insertBefore(PageBreakTag, Child);
			    	//alert("Message successfully saved");
			    }
			    else {
			    	alert("Couldn't save");
			    }
			  },
			   
			  error: function(request, response){
			    alert(request.responseText);
			  }

			});

			document.getElementById("comment_container").style.display = "none";
	}
}
