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

/* AJAX */
$(document).ready(function() {
  $(".Auth").on("click", () => {
    let phoCode = $("#ones").val()
    let emaCode = $("#twos").val()
    let phone   = localStorage.getItem("phone")
    let email   = localStorage.getItem("email")

    $.ajax({
      type: "POST",
      url: "../../controllers/validate.php",
      dataType: "json",
      data: {
        phone:phone,
        email:email,
        phoCode:phoCode,
        emaCode:emaCode
      },
    })

    .done((data) => {
      if(data.icon == "success" || data.icon == "warning" || data.icon == "error"){
        if (data.icon == "success") {
          Swal.fire({
            title: data.title,
            text: data.text,
            timer: 1200,
            timerProgressBar: true,
            didOpen: () => {
              Swal.showLoading()
            }
          }).then(() => {
            window.location = "../../index.php"
          })
        }else{
          Swal.fire({
            title: data.title,
            text: data.text,
            icon: data.icon,
            confirmButtonText: 'OK',
            showCloseButton: true
          })
        }
      }
    })

    .fail((err) => {
      console.log("Im sorry", err)
    })
  })
})
/* AJAX */