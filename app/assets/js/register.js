localStorage.clear()

/* Toggles */
function toggleName () {
  var element = document.querySelector('.name')
  element.classList.toggle('focus')

  var ones = document.querySelector('#ones').value
  if (!ones) {
    element.classList.toggle('focused')
  }
}

function togglePhone () {
  var element = document.querySelector('.phone')
  element.classList.toggle('focus')

  var ones = document.querySelector('#twos').value
  if (!ones) {
    element.classList.toggle('focused')
  }
}

function toggleOne () {
  var element = document.querySelector('.one')
  element.classList.toggle('focus')

  var ones = document.querySelector('#threes').value
  if (!ones) {
    element.classList.toggle('focused')
  }
}

function togglePass () {
  var element = document.querySelector('.pass')
  element.classList.toggle('focus')

  var ones = document.querySelector('#fours').value
  if (!ones) {
    element.classList.toggle('focused')
  }
}
/* Toggles */

/* AJAX */
$(document).ready(function() {
  $('.Registrar').on('click', () =>{
    var name     =   $("#ones").val()
    var phone    =   $("#twos").val()
    var email    = $("#threes").val()
    var password =  $("#fours").val()

    $.ajax({
      type: "POST",
      url: "../../controllers/newRegister.php",
      dataType: "json",
      data: {name:name,phone:phone,email:email,password:password},
    })

    .done(function(data){
      console.log(data)
      if(data.icon == "success" || data.icon == "warning" || data.icon == "error"){
        Swal.fire({
          title: data.title,
          text: data.text,
          icon: data.icon,
          confirmButtonText: 'Aceptar',
          showCloseButton: true
        })
        if (data.icon=="success") {
          window.location.href = "../../views/pages/login.php"
        }
      }
      else {
        Swal.fire({
          title: 'Error',
          text: 'Se ha producido un error, intente más tarde',
          icon: 'warning',
          confirmButtonText: 'OK',
          showCloseButton: true
        })
      }
    })

    .fail(function(){
      Swal.fire({
        title: "Algo va mal :(",
        text: "No hemos podido determinar el origen del error, vuelve más tarde",
        icon: "error",
      })
    })
  })
})
/* AJAX */