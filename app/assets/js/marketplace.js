$(document).ready(() => {
  let u = window.location.href
  let b = u.split("/")
  let a = b.length
  let c = [
    "marketplace.php?buy",
    "marketplace.php?sell"
  ]
  let index
  let option

  if (b[a-1] == c[0]) {
    index  = document.querySelector(".buy")
    option = "buy"
  }else if (b[a-1] == c[1]) {
    index  = document.querySelector(".sell")
    option = "sell"

    let email = localStorage.getItem("email")

    $.ajax({
      type: "POST",
      url: "controllers/consultHowManyWallets.php",
      dataType: "json",
      data: {
        email
      }
    })

    .done((data) => {
      console.log(data)
      let element1 = "", element2 = "", element3 = ""
      element1 = `<option value="0">NO TIENES WALLETS REGISTRADAS</option>`
      for (let i = 0; i < data.length; i++) {
        if (data[i].tip_div != null && i == 0) {
          element1 = `<option value="${data[i].tip_div}">${data[i].tip_div}</option>`
        }else if (data[i].tip_div != null && i == 1) {
          element2 = `<option value="${data[i].tip_div}">${data[i].tip_div}</option>`
        }else if (data[i].tip_div != null && i == 2) {
          element3 = `<option value="${data[i].tip_div}">${data[i].tip_div}</option>`
        }
      }

      Swal.fire({
        title: '<h3>Nueva orden de venta</h3>',
        html: ` 
              <div class="part1">
                <label><b>Selecciona una de tus wallets:</b></label>
                <select id="markSell" class="markSell" onchange="localStorage.setItem('tipWal', value);">
                  ${element1+element2+element3}
                </select>
                <input type="number" id= "markSell" class="markSell" placeholder="Monto de activo a vender" onblur="localStorage.setItem('activo', value)">
              </div>
              <div class="part2">
                <label><b>Método de pago:</b></label>
                <select id="markSell" class="markSell" onchange="localStorage.setItem('metPag', value)">
                  <option value="P2P">P2P</option>
                </select>
              </div>
              `,
        showCancelButton: true,
        confirmButtonText: 'Continuar',
        cancelButtonText: 'Cancelar',
      }).then((result) => {
        if (result.isConfirmed) {
          let tipWal = localStorage.getItem("tipWal")
          tipWal === null ? tipWal = data[0].tip_div : tipWal
          let alltasas = `<option value="">No fue posible determinar la respuesta</option>`
          switch (tipWal) {
            case 'USD':
              alltasas =  `
                          <option value="COP">COP</option>
                          <option value="VES">VES</option>
                          `
              break;
            
            case 'COP':
              alltasas =  `
                          <option value="USD">USD</option>
                          <option value="VES">VES</option>
                          `
              break;
            
            case 'VES':
              alltasas =  `
                          <option value="USD">USD</option>
                          <option value="COP">COP</option>
                          `
              break;
            
            default:
              console.log("Not default value yet")
              break;
          }
          Swal.fire({
            title: 'Tasa de venta',
            html: `
                  <div class="part3">
                    <label><b>Activo a recibir:</b></label>
                    <select id="activoRec" class="markSell" onchange="localStorage.setItem('actiRec', value)">
                      ${alltasas}
                    </select>
                  </div>
                  <div class="part3">
                    <b>Tasas:</b>
                    <span>USD -> COP: ${localStorage.getItem("coptasa")}</span>
                    <span>USD -> VES: ${localStorage.getItem("usdtasa")}</span>
                    <span>VES -> COP: ${localStorage.getItem("vestasa")}</span>
                  </div>
                  `,
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar',
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire({
                title: 'Creando nueva orden de venta...',
                text: 'Este proceso podría tardar unos cuantos segundos, por favor espere',
                imageUrl: 'assets/img/wallets2.gif',
                imageWidth: 300,
                showCloseButton: true,
                showConfirmButton: false,
                didOpen: () => {
                  let tipWal  = localStorage.getItem("tipWal")
                  let metPag  = localStorage.getItem("metPag")
                  let monto   = localStorage.getItem("activo")
                  let email   = localStorage.getItem("email")
                  let actiRec = localStorage.getItem("actiRec")
                  let idtWal  = ""
                  let tasa
    
                  !tipWal  ? tipWal  = data[0].tip_div : tipWal
                  !metPag  ? metPag  = "P2P"           : metPag
                  
                  if (!actiRec) {
                    tipWal === "USD" ? actiRec = "COP" : actiRec = "USD"
                  }

                  switch (actiRec) {
                    case "USD":
                      tipWal === "COP" ? tasa = localStorage.getItem("coptasa") : tasa = localStorage.getItem("usdtasa")
                      break;

                    case "COP":
                      tipWal === "USD" ? tasa = localStorage.getItem("coptasa") : tasa = localStorage.getItem("vestasa")
                      break;

                    case "VES":
                      tipWal === "COP" ? tasa = localStorage.getItem("vestasa") : tasa = localStorage.getItem("usdtasa")
                      break;
                  }
    
                  for (let i = 0; i < data.length; i++) {
                    if (data[i].tip_div == tipWal) {
                      idtWal = data[i].idt_wal
                    }
                  }
      
                  localStorage.removeItem("tipWal")
                  localStorage.removeItem("metPag")
                  localStorage.removeItem("monto")
                  localStorage.removeItem("actiRec")
                  localStorage.removeItem("activo")
    
                  if (!monto) {
                    Swal.fire({
                      title: "Error",
                      text: "Por favor establezca un monto válido, no puede quedar vacío",
                      icon: "warning",
                      showCloseButton: true,
                    }).then(() => { location.assign(c[0]) })
                  }else{
                    $.ajax({
                      type: "POST",
                      url: "controllers/createNewSellOrder.php",
                      dataType: "json",
                      data: {
                        tipWal:tipWal,
                        metPag:metPag,
                        monto:monto,
                        email:email,
                        idtWal:idtWal,
                        actiRec:actiRec,
                        tasa:tasa
                      }
                    })
        
                    .done((data) => {
                      Swal.fire({
                        title: data.title,
                        text: data.text,
                        icon: data.icon,
                        showCloseButton: true,
                      }).then(() => { location.assign(c[0]) })
                    })
        
                    .fail((err) => {
                      console.log("nanai señor")
                      console.log(err.responseText)
                    })
                  }
                }
              })
            } else if (result.dismiss === Swal.DismissReason.cancel) {
              Swal.fire({
                title: 'Cancelada',
                text: 'La orden de venta fue cancelada',
                icon: 'error',
                showCloseButton: true,
              }).then(() => { location.assign(c[0]) })
            }
          })
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          Swal.fire({
            title: 'Cancelada',
            text: 'La orden de venta fue cancelada',
            icon: 'error',
            showCloseButton: true,
          }).then(() => { location.assign(c[0]) })
        }
      })
    })

    .fail((err) => {
      console.log(err.responseText, "nanai")
    })
  }else{
    location.assign(c[0])
  }
  index.classList.add("focus-list")

  $('.bx-menu').on('click', () => {
    let menu = document.querySelector(".bx-menu")
    menu.classList.toggle("menu-full")
    let sidebar = document.querySelector(".Sidebar")
    sidebar.classList.toggle("mini")
    let main = document.querySelector(".main")
    main.classList.toggle("full")
  })

  $("#show").on("click", (e) => {
    let val   = e.currentTarget.classList.value
    let a     = val.split(" ")
    let b     = a[0]
    console.log(b)
  })

  $(".item").on("click", (e) => {
    //changing the target of active
    let u = e.currentTarget
    let a = $(".item.active")
    u.classList.add("active")
    a[0].classList.remove("active")

    //searching the new value for the table
    let b =  u.childNodes[1].hash
    setOfertas(b)
  })

  setOfertas("")

  function setOfertas(tip) {
    $.ajax({
      type: "POST",
      url: "controllers/setOfertas.php",
      dataType: "json",
      data: {tip}
    })

    .done((data) => {
      $(".body-ofertas").html(data)
      selectPutos()
    })

    .fail((err) => {
      $(".body-ofertas").html(err.responseText)
      selectPutos()
    })
  }

  function selectPutos() {
    let puto = document.querySelectorAll("#puto")

    for (let i = 0; i < puto.length; i++) {
      puto[i].addEventListener("click", (e) => {
        let val   = e.currentTarget.classList.value
        let a     = val.split(" ")
        let b     = a[0]
        let email = localStorage.getItem("email")

        $.ajax({
          type: "POST",
          url: "controllers/info-buy.php",
          dataType: "json",
          data: {sell:b}
        })
    
        .done((data) => {
          console.log(data);
          let xyz = data.comi
          let zyx = xyz.split(",")
          let a = ""
          for (let i = 0; i < zyx.length; i++) {
            a += zyx[i]
          }
          let yzx = parseFloat(a)
          Swal.fire({
            title: data.title,
            html: data.text+"<br><span><b>comision:</b> "+yzx.toFixed(2)+data.divi+"</span>",
            icon: data.icon,
            showCancelButton: true,
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar',
          }).then((result) => {
            if (result.isConfirmed) {
              let xy    = data.monto
              let yz    = xy.split(",")
              let a = ""
              for (let i = 0; i < yz.length; i++) {
                a += yz[i]
              }
              let    zz = parseFloat(a)
              let monto = zz
              let date  = Date.now()
              let slWal = data.slWal
              let mnSll = data.mnSll
              let tpDiv = data.tpDiv
              let divis = data.divi
              let comis = yzx
              $.ajax({
                type: "POST",
                url: "controllers/buy.php",
                dataType: "json",
                data: {date,email,monto,b,slWal,mnSll,tpDiv,divis,comis}
              })
    
              .done((data) => {
                console.log(data)
                if (data.status == "done") {
                  Push.create("FINEX | CAPITAL", {
                    body: "¡Transferencia exitosa!",
                    icon: "assets/img/fav.png"
                  })
                  window.location = "marketplace.php"
                }else{
                  Push.create("FINEX | CAPITAL", {
                    body: "Falló la operación, "+data.status,
                    icon: "assets/img/fav.png"
                  })
                }
              })
    
              .fail((err) => {
                console.log(err)
                Push.create("FINEX | CAPITAL", {
                  body: "Falló la operación, error en el servidor",
                  icon: "assets/img/fav.png"
                })
              })
            } else {
              Swal.fire({
                title: "Cancelada",
                text: "Compra cancelada",
                icon: "error",
                confirmButtonText: 'OK'
              })
            }
          })
        })
    
        .fail((err) => {
          console.log(err.responseText)
        })
      })
    }
  }
})

/*
window.clientInformation.language  -> lenguje por defecto
window.clientInformation.platform  -> Plataforma de software
window.clientInformation.userAgent -> Version de la app
window.clientInformation.vendor    -> compañia (creo)
*/