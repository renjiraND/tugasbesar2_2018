selectNavigation(PROFILE);

function readURL(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();

		reader.onload = function(e) {
			document.getElementById('display-profile-picture').src=e.target.result
		}

		reader.readAsDataURL(input.files[0]);
	}
}

function addOnChangeProfilePictureName() {
	document.getElementById('file-input').onchange = function () {
		readURL(this);
  	document.getElementById('profile-picture-name').value=this.files[0].name;
	};
}
