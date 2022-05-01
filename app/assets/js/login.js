localStorage.clear()

/* Toggles */
function toggleOne () {
  var element = document.querySelector('.one')
  element.classList.toggle('focus')

  var ones = document.querySelector('#ones').value
  if (!ones) {
    element.classList.toggle('focused')
  }
}

function togglePass () {
  var element = document.querySelector('.pass')
  element.classList.toggle('focus')

  var ones = document.querySelector('#twos').value
  if (!ones) {
    element.classList.toggle('focused')
  }
}
/* Toggles */

/* Random Number */
function codeLog () {
  const randNum = Math.round(Math.random() * 1000000)
  return randNum
}
/* Random Number */

/* AJAX */
$(document).ready(function() {
  $('.Login').on('click', () =>{
    var email    = $("#ones").val()
    var password = $("#twos").val()
    var state    = "login"

    $.ajax({
      type: "POST",
      url: "../../controllers/newLogin.php",
      dataType: "json",
      data: {
        email:email,
        password:password,
        state:state
      },
    })

    .done(function(data){
      console.log(data)
      if(data.icon == "success" || data.icon == "warning" || data.icon == "error"){
        if (data.icon == "success") {
          localStorage.setItem('phone', data.phone)
          localStorage.setItem('email', email)
          Swal.fire({
            title: data.title,
            text: data.text,
            timer: 3000,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading()
              var phoCode = codeLog()
              var emaCode = codeLog()
              var phone   = data.phone

              $.ajax({
                type: "POST",
                url: "../../models/Twilio.php",
                dataType: "json",
                data: {
                  phone:phone,
                  code: phoCode
                },
              })

              .done(function(data) {
                console.log(data)
              })

              .fail(() => {
                console.log("no man 1")
              })

              $.ajax({
                type: "POST",
                url: "../../models/Mailer.php",
                dataType: "json",
                data: {
                  email:email,
                  code: emaCode
                },
              })

              .done(function(data) {
                console.log(data)
              })

              .fail(() => {
                console.log("no man 2")
              })
            }
          }).then(() => {
            window.location = "2fa.php"
          })
        }
        else if (data.icon == "warning" || data.icon == "error") {
          Swal.fire({
            title: data.title,
            text: data.text,
            icon: data.icon,
            confirmButtonText: 'Aceptar',
            showCloseButton: true
          })
        }
      }
    })

    .fail(() => {
      Swal.fire({
        title: "Algo va mal :(",
        text: "No hemos podido determinar el origen del error, intenta más tarde",
        icon: "error",
      })
    })
  })
})
/* AJAX */