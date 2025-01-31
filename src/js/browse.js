// selectNavigation(BROWSE);

function addValidationToSearchBox() {
	let element = document.getElementById('form-search');
	element.addEventListener('submit', function(e) {
		e.preventDefault();
		let box = document.getElementById('search-value');
		if (box.value.length == 0) {
			alert('Search box must be filled!');
		} else {
			element.submit();
		}

	}, false);
}

function showNotification(id_order) {
	let element = document.getElementById('notification');
	element.classList.remove("hided");
	element = document.getElementById('backdrop');
	element.classList.remove("hided");
    element = document.getElementById('img_status');
    element.src = "../res/misc/check.png";
	let trans_element = document.getElementById('transaction_id');
	trans_element.innerHTML = id_order;
}

function showFailedNotification() {
    let element = document.getElementById('notification');
    element.classList.remove("hided");
    element = document.getElementById('backdrop');
    element.classList.remove("hided");
    element = document.getElementById('img_status');
    element.src = "../res/misc/close.png";
    element = document.getElementById('status');
    element.innerHTML = "<div class=\"text-bold text-size-very-small font-default\"> Pemesanan Gagal </div>";

}

function closeNotification() {
	let element = document.getElementById('notification');
	element.classList.add("hided");
	element = document.getElementById('backdrop');
	element.classList.add("hided");
}

function order(amount, username, idbook, card_number, categories) {
	if (amount === 'unordered') {
		alert('You must order at least 1 book!');
	} else {
		let headers = {'Content-Type': 'application/json'};
		body = {'amount': amount, 'username': username, 'idbook':idbook, 'card_number':card_number, 'categories':categories};
		let fetchData = {
			method: 'POST',
			body: JSON.stringify(body),
			headers: headers
		};
		//console.log(fetchData);
		fetch('../php/order.php', fetchData)
		.then((resp) => resp.json())
		.then(function(data) {
			if (data['status'] == '1') {
                showNotification(data['id_order']);
            }else{
				showFailedNotification();
			}
		})
		.catch(function(error) {
            showFailedNotification();
			console.log(error);
		});
	}
}

function check_order(price) {
	//price = "<?php echo $book['price'] ?>";
	if (price=='Not For Sale') {
		document.getElementById('ordersection').classList.add('hide');
	} else {
		document.getElementById('ordersection').classList.remove('hide');
	}
}
