const BROWSE = 'browse';
const HISTORY = 'history';
const PROFILE = 'profile';
const ARR_NAV = [BROWSE, HISTORY, PROFILE];

function selectNavigation(section) {
	let element;
	for (let i = 0; i < ARR_NAV.length; i++) {
		element = document.getElementById(ARR_NAV[i]);
		if (ARR_NAV[i] === section) {
			element.classList.add('bg-color-orange');
		} else {
			element.classList.remove('bg-color-orange');
		}
	}
}