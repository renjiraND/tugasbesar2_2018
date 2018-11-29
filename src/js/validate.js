var uservalid;
var emailvalid;

function validateUserAjax(str) {
	if (str.length == 0) {
		document.getElementById("check-user").classList.add('hide');
		document.getElementById("inputuser").classList.add('fakecheck');
	} else {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText == "1"){
					document.getElementById("check-user").classList.remove('hide');
					document.getElementById("inputuser").classList.remove('fakecheck');
					uservalid = true;
				} else {
					document.getElementById("check-user").classList.add('hide');
					document.getElementById("inputuser").classList.add('fakecheck');
					uservalid = false;
				}
			}
		};
		xmlhttp.open("GET","../php/validate-ajax-user.php?q="+str,true);
		xmlhttp.send();
	}
	return;
}

function validateEmailAjax(str) {
	if (str.length == 0) {
		document.getElementById("check-email").classList.add('hide');
		document.getElementById("inputemail").classList.add('fakecheck');
	} else {
		var xmlhttp = new XMLHttpRequest();
		xmlhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText == "1"){
					document.getElementById("check-email").classList.remove('hide');
					document.getElementById("inputemail").classList.remove('fakecheck');
					emailvalid = true;
				} else {
					document.getElementById("check-email").classList.add('hide');
					document.getElementById("inputemail").classList.add('fakecheck');
					emailvalid = false;
				}
			}
		};
		xmlhttp.open("GET","../php/validate-ajax-email.php?q="+str,true);
		xmlhttp.send();
	}
	return;
}

function validateAll(){
	var name = document.forms["reg-form"]["input-name"].value;
	var user = document.forms["reg-form"]["input-username"].value;
	var email = document.forms["reg-form"]["input-email"].value;
	var pass = document.forms["reg-form"]["input-password"].value;
	var pass2 = document.forms["reg-form"]["input-password2"].value;
	var address = document.forms["reg-form"]["input-address"].value;
	var phone = document.forms["reg-form"]["input-phone-number"].value;
	var card = document.forms["reg-form"]["input-card-number"].value;
	if(validateName(name)){
		if(validateUser(user)){
			if(validateEmail(email)){
				if(validatePassword(pass,pass2)){
					if(validateAddress(address)){
						if(validatePhone(phone)){
							if (validateCard(card)){
								return true;
							}
						}
					}
				}
			}
		}
	}
	return false;
}

function validateLogin(){
	var user = document.forms["login-form"]["input-username"].value;
	var pass = document.forms["login-form"]["input-password"].value;
	if(user.length == 0){
		alert("Username is required.");
		return false;
	}
	if(pass.length == 0){
		alert("Password is required.");
		return false;
	}
	return true;	
}

function validateEdit(){
	var name = document.forms["new-profile"]["new-name"].value;
	var address = document.forms["new-profile"]["new-address"].value;
	var phone = document.forms["new-profile"]["new-phone"].value;
	var card = document.forms["new-profile"]["new-card"].value;
	if(validateName(name)){
		if(validateAddress(address)){
			if(validatePhone(phone)){
				if (validateCard(card)){
					return true;
				}
			}
		}
	}
	return false;
}

function validateName(name){
	if(name.length == 0){
		alert("Name is required.");
		return false;
	}
	if(name.length > 20){
		alert("Name length should not be more than 20 characters.");
		return false;
	}
	return true;
}

function validateUser(user){
	if(user.length == 0){
		alert("Username is required.");
		return false;
	}
	if(!uservalid){
		alert("Username is already taken.");
		return false;
	}
	return true;
}

function validateEmail(email){
	var emails = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	if(email.length == 0){
		alert("Email is required.");
		return false;
	}
	if(!(email.match(emails))){
		alert("Email is not valid.");
		return false;
	}
	if(!emailvalid){
		alert("Email is already used.")
	}
	return true;
}

function validatePassword(pass,pass2){
	if(pass.length == 0){
		alert("Password is required.");
		return false;
	}
	if(pass2.length == 0){
		alert("Please confirm your password.");
		return false;
	}
	if(pass != pass2){
		alert("Password doesn't match.");
		return false;
	}
	return true;
}

function validateAddress(address){
	if(address.length == 0){
		alert("Address is required.");
		return false;
	}
	return true;
}

function validatePhone(phone){
	var numbers = /^[0-9]+$/;
	if(phone.length == 0){
		alert("Phone number is required.");
		return false;
	}
	if(!(phone.match(numbers))){
		alert("Phone number should be number.");
		return false;
	}
	if(phone.length < 9 || phone.length > 12){
		alert("Phone number length should be between 9 and 12.");
		return false;
	}
	return true;
}

function validateCard(card){
	if(card.length == 0){
		alert("Card number is required.");
		return false;
	}

	var xmlHttp = new XMLHttpRequest();
	url = "http://localhost:4000/validate/?no=" + card;
    xmlHttp.open( "GET", url, false ); // false for synchronous request
    xmlHttp.send();
    if (xmlHttp.readyState == 4){
    	response = JSON.parse(xmlHttp.responseText);
    	if (response.validation == 0){
	    	alert(response.message);
	    	return false;
    	}
    }

	return true;
}
