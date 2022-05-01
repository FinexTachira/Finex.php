$(document).ready(() => {
  $('.bx-menu').on('click', () => {
    let menu = document.querySelector(".bx-menu")
    menu.classList.toggle("menu-full")
    let sidebar = document.querySelector(".Sidebar")
    sidebar.classList.toggle("mini")
    let main = document.querySelector(".main_p2p")
    main.classList.toggle("full")
  })

  let p2p = document.querySelector(".p2p")
  p2p.classList.add("focus-list")

  $('#close').on('click', () => {
    let modal = document.querySelector(".modal_profile")
    modal.classList.remove("show")
    modal.classList.add("hide")
    setTimeout(() => {
      modal.classList.add("none")
    }, 1000)
  })

  $('.NameUser').on('click', () => {
    let modal = document.querySelector(".modal_profile")
    modal.classList.remove("none")
    modal.classList.remove("hide")
    modal.classList.add("show")
  })

  setInterval(() => {
    $.ajax({
      type: "POST",
      url: "controllers/consultarSaldo.php",
      dataType: "json"
    })

    .done((data) => {
      document.querySelector(".numbers").innerHTML=parseFloat(data.saldo).toFixed(2)+"USD"
      localStorage.setItem("usdtasa", data.usdtasa)
      localStorage.setItem("coptasa", data.coptasa)
      localStorage.setItem("vestasa", data.vestasa)
    })
  }, 2000);

  $("#Depositar").on('click', () => {
    let mont = $("#amount").val()
    let divi = $("#tip_div").val()
    let remi = $("#ema_who").val()
    let conc = $("#concepto").val()

    if (!mont || !divi || !remi || !conc) {
      Swal.fire({
        title: 'Error',
        text: 'No puedes dejar ningun campo vacío',
        icon: 'error'
      })
    }else{
      if (mont == 0) {
        Swal.fire({
          title: 'Error',
          text: 'El monto es igual a cero',
          icon: 'error'
        })
      } else {
        Swal.fire({
          title: '¿Continuar?',
          text: "Si acepta, se le depositará el monto del dinero al remitente que ha introducido, sino, su dinero quedará con usted :)",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Continuar',
          cancelButtonText: 'Cancelar',
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              type: "POST",
              url: "controllers/newTransaction.php",
              dataType: "json",
              data: {monto:mont,divisa:divi,remitente:remi,concepto:conc},
            })
        
            .done((data) => {
              console.log(data)
              Swal.fire({
                title: data.title,
                text: data.text,
                icon: data.icon,
                showCancelButton: false,
              }).then(() => {
                window.location = "P2P.php"
              })
            })
        
            .fail((err) => {
              console.log("nel", err.responseText)
            })
          }else if (
            result.dismiss === Swal.DismissReason.cancel
          ) {
            Swal.fire({
              title: 'Cancelado',
              text: 'Tu dinero se queda contigo :)',
              icon: 'error',
              showCancelButton: false,
            })
          }
        })
      }
    }
  })

  setInterval(() => {
    $.ajax({
      type: "GET",
      url: "controllers/setHistoryOfDeposit.php",
      dataType: "html"
    })

    .done((data) => {
      $(".body_history_p2p").html(data)
    })

    .fail((err) => {
      console.log(err.responseText)
    })
  }, 2000);

  setInterval(() => {
    $.ajax({
      type: "POST",
      url: "controllers/countingActiveOrders.php",
      dataType: "html"
    })

    .done((data) => {
      $(".orders").html(data)
    })

    .fail((err) => {
      console.log(err.responseText);
    })
  }, 2000);
})