$(document).ready(() => {
	setInterval(() => {
		let email = localStorage.getItem("email")
		$.ajax({
			type: "POST",
			url: "controllers/getNotificationsPush.php",
			dataType: "json",
			data: {email}
		})

		.done((data) => {
			pusherP2P(data.ema_frm,data.sal_dep,data.tip_div)
		})

		.fail((err) => {
			console.log(err.responseText)
		})
  }, 4000)
  
  // setInterval(() => {
	// 	let email = localStorage.getItem("email")
	// 	$.ajax({
	// 		type: "POST",
	// 		url: "controllers/getNotificationsPush.php",
	// 		dataType: "json",
	// 		data: {email}
	// 	})

	// 	.done((data) => {
	// 		pusherP2P(data.ema_frm,data.sal_dep,data.tip_div)
	// 	})

	// 	.fail((err) => {
	// 		console.log(err.responseText)
	// 	})
	// }, 4000)

	function pusherP2P(email,monto,divisa) {
		Push.create("FINEX | CAPITAL", {
			body: "El usuario "+email+" te depositó "+monto+divisa,
			icon: "assets/img/fav.png"
		})
  }
  
  function pusherBuy() {
    console.log("all fine")
  }
})