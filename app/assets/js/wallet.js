$(document).ready(() => {
  $('.bx-menu').on('click', () => {
    let menu = document.querySelector(".bx-menu")
    menu.classList.toggle("menu-full")
    let sidebar = document.querySelector(".Sidebar")
    sidebar.classList.toggle("mini")
    let main = document.querySelector(".main")
    main.classList.toggle("full")
  })

  let wallet = document.querySelector(".wallet")
  wallet.classList.add("focus-list")
  
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

  $('.create').on('click', () => {
    Swal.fire({
      title: '<h3>Elija el tipo de Wallet a crear:</h3>',
      html: ` <select id="typeDiv" onchange="localStorage.setItem('div', value)">
                <option value="USD">USD - Dólar Americano</option>
                <option value="COP">COP - Peso Colombiano</option>
                <option value="VES">VES - Bolívar Venezolano</option>
              </select>`,
      showCancelButton: true,
      confirmButtonText: 'Crear',
      cancelButtonText: 'Cancelar',
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          title: 'Creando wallet...',
          text: 'Este proceso podría tardar unos cuantos segundos, por favor espere',
          imageUrl: 'assets/img/wallets.gif',
          imageWidth: 300,
          showCloseButton: true,
          showConfirmButton: false,
          didOpen: () => {
            let divis = localStorage.getItem("div")
            !divis ? divis = "USD" : divis
            let email = localStorage.getItem("email")
            let phone = localStorage.getItem("phone")
            let mixed = email+"_"+phone+"_"+divis

            localStorage.removeItem("div")
    
            $.ajax({
              type: "POST",
              url: "controllers/createNewWallet.php",
              dataType: "json",
              data: {mixed,type:divis,email}
            })

            .done((data) => {
              Swal.fire({
                title: data.title,
                text: data.text,
                icon: data.icon,
                showCloseButton: true,
              })
            })

            .fail((err) => {
              console.log("nanai señor")
              console.log(err.responseText)
            })
          }
        })
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
          title: 'Cancelado',
          text: 'El proceso de creación de Wallet fué interrumpido',
          icon: 'error',
          showCloseButton: true,
        })
      }
    })
  })

  let email = localStorage.getItem("email")
  let tip = ['USD','COP','VES']

  setTimeout(() => {
    for (let i = 0; i < tip.length; i++) {
      setSaldoWalltes(email,tip[i],i)
    }
  }, 100)

  setInterval(() => {
    for (let i = 0; i < tip.length; i++) {
      setSaldoWalltes(email,tip[i],i)
    }
  }, 2000)

  function setSaldoWalltes(email,tip,i) {
    $.ajax({
      type: "POST",
      url: "controllers/setSaldoWallets.php",
      dataType: "json",
      data: {email,tip}
    })
  
    .done((data) => {
      switch (i) {
        case 0:
          let spanUSD = document.querySelector("#wallet-usd")
          spanUSD.innerHTML=parseFloat(data.saldo).toFixed(2)
          if (!data.saldo) {
            spanUSD.innerHTML="No posee"
          }
        break;

        case 1:
          let spanCOP = document.querySelector("#wallet-cop")
          spanCOP.innerHTML=parseFloat(data.saldo).toFixed(2)
          if (!data.saldo) {
            spanCOP.innerHTML="No posee"
          }
        break;

        case 2:
          let spanVES = document.querySelector("#wallet-ves")
          spanVES.innerHTML=parseFloat(data.saldo).toFixed(2)
          if (!data.saldo) {
            spanVES.innerHTML="No posee"
          }
        break;
      }
    })
  
    .fail((err) => {
      console.log(err.responseText)
    })
  }

  setInterval(() => {
    $.ajax({
      type: "POST",
      url: "controllers/consultarSaldo.php",
      dataType: "json"
    })

    .done((data) => {
      document.querySelector(".the_saldo").innerHTML=parseFloat(data.saldo).toFixed(2)+"USD"
      localStorage.setItem("usdtasa", data.usdtasa)
      localStorage.setItem("coptasa", data.coptasa)
      localStorage.setItem("vestasa", data.vestasa)
    })
  }, 2000)

  $(".deposit").on("click", () => {
    Swal.fire({
      title: 'Proximamente...',
      html: ` <input type="button" class="btn-deposit paypal" value="Paypal"><br>
              <input type="button" class="btn-deposit bancolombia" value="Bancolombia"><br>
              <input type="button" class="btn-deposit nequi" value="Nequi"><br>
              <input type="button" class="btn-deposit bdv" value="Banco de Venezuela">`,
      icon: 'info',
      showCloseButton: true,
    })
  })

  $(".transfer").on("click", () => {
    Swal.fire({
      title: 'Convertir divisas',
      html: ` <div>
                <b>tasas:</b><br/>
                <span>VES - COP: ${localStorage.getItem("vestasa")}</span><br/>
                <span>USD - VES: ${localStorage.getItem("usdtasa")}</span><br/>
                <span>COP - USD: ${localStorage.getItem("coptasa")}</span><br/>
              </div>`,
      showCloseButton: true,
    })
  })
})