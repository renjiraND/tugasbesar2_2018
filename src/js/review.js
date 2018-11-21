selectNavigation(HISTORY);

function addValidation() {
	let element = document.getElementById('review');
	element.addEventListener('submit', function(e) {
		e.preventDefault();
		let box = document.getElementById('comment');
		let value=0;
		let radios = document.getElementsByName('stars');
		for (let i=0; i<radios.length; i++){
			if (radios[i].checked){value=radios[i].value; break;}
		}
		console.log(value);
		if (value == 0) {
			alert('You must give your rating!');
		} else if (box.value.length == 0) {
			alert('Comment box must be filled!');
		} else {
			element.submit();
		}

	}, false);
}

function activateStar(el) {
	el.src = "../res/misc/star.png";
}

function deactivateStar(el) {
	el.src = "../res/misc/star_no_fill.png";
}

function activateCurrentStar() {
	var value=0;
	var radios = document.getElementsByName('stars');
	for (var i=0; i<radios.length; i++){
		if (radios[i].checked){value=radios[i].value; break;}
	}
	value = "activate" + value + "Star";
	window[value]();
}

function activate0Star(){
	deactivateStar(document.getElementById('stars1'));
	deactivateStar(document.getElementById('stars2'));
	deactivateStar(document.getElementById('stars3'));
	deactivateStar(document.getElementById('stars4'));
	deactivateStar(document.getElementById('stars5'));
}

function activate1Star(){
	activateStar(document.getElementById('stars1'));
	deactivateStar(document.getElementById('stars2'));
	deactivateStar(document.getElementById('stars3'));
	deactivateStar(document.getElementById('stars4'));
	deactivateStar(document.getElementById('stars5'));
}

function activate2Star(){
	activateStar(document.getElementById('stars1'));
	activateStar(document.getElementById('stars2'));
	deactivateStar(document.getElementById('stars3'));
	deactivateStar(document.getElementById('stars4'));
	deactivateStar(document.getElementById('stars5'));
}

function activate3Star(){
	activateStar(document.getElementById('stars1'));
	activateStar(document.getElementById('stars2'));
	activateStar(document.getElementById('stars3'));
	deactivateStar(document.getElementById('stars4'));
	deactivateStar(document.getElementById('stars5'));
}

function activate4Star(){
	activateStar(document.getElementById('stars1'));
	activateStar(document.getElementById('stars2'));
	activateStar(document.getElementById('stars3'));
	activateStar(document.getElementById('stars4'));
	deactivateStar(document.getElementById('stars5'));
}
function activate5Star(){
	activateStar(document.getElementById('stars1'));
	activateStar(document.getElementById('stars2'));
	activateStar(document.getElementById('stars3'));
	activateStar(document.getElementById('stars4'));
	activateStar(document.getElementById('stars5'));
}