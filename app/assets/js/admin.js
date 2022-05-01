$(document).ready(() => {
  //functions
  //sale de Finex Server
  function go_out() {
    localStorage.clear()
    location.assign("../index.html")
  }

  //Identifica las credenciales que permiten las operaciones
  function consultAuth() {
    let auth = localStorage.getItem("admin_access")
    if (!auth) {
      alert("¡Primero autentiquese!")
      return false
    }
  }

  //Autentica un nuevo usuario
  function auth() {
    let ema = document.getElementById("ema").value
    let psw = document.getElementById("psw").value

    $.ajax({
      type: "POST",
      url: "controllers/admin/validate.php",
      dataType: "json",
      data: {ema,psw}
    })

    .done((data) => {
      if (data.validate === "1") {
        localStorage.setItem("admin_access", true)
        localStorage.setItem("admin_email", data.email)
        $(".form_validate").html("<span>Validado</span>")
        setInterval(() => {
          consultOrdenanzas()
          consultSaldoFinex()
        }, 1000)
      }else{
        alert("hay un dato erroneo")
      }
    })

    .fail((err) => {
      console.log(err.responseText)
    })
  }

  //handlers
  $("#out").on("click", go_out)
  $(".btn").on("click", consultAuth)
  $("#setAdmin").on("click", auth)

  //conditionals
  setInterval(() => {
    if(localStorage.getItem("admin_access") === "true") {
      $(".form_validate").html("<span>Validado</span>")
      consultOrdenanzas()
      consultSaldoFinex() 
    }
  }, 1000)

  !localStorage.getItem("access") ? location.assign("../index.html") : console.log("not redirected")

  //other
  function consultOrdenanzas() {
    $.ajax({
      type: "GET",
      url: "controllers/admin/consultOrdenanzas.php",
      dataType: "json",
      data: {}
    })

    .done((data) => {
      let buy  = $(".buy")
      let sell = $(".sell")

      buy.html(`<h4>Tasas de compra:</h4>
                  <span><b>USD a VES:</b> ${data.buy.usd_ves}</span><br>
                  <span><b>VES a COP:</b> ${data.buy.ves_cop}</span><br>
                  <span><b>COP a USD:</b> ${data.buy.cop_usd}</span><br>`)

      sell.html(`<h4>Tasas de venta:</h4>
                  <span><b>USD a VES:</b> ${data.sell.usd_ves}</span><br>
                  <span><b>VES a COP:</b> ${data.sell.ves_cop}</span><br>
                  <span><b>COP a USD:</b> ${data.sell.cop_usd}</span><br>`)
    })

    .fail((err) => {
      console.log(err)
    })
  }
  
  function consultSaldoFinex() {
    $.ajax({
      type: "POST",
      url: "controllers/admin/consultSaldoFinex.php",
      dataType: "json",
      data: {}
    })
  
    .done((data) => {
      let saldos = $(".saldos")
      saldos.html(` <h4>Saldos de Wallet Finex:</h4>
                      <span><b>USD:</b> ${data.usd}USD</span><br>
                      <span><b>COP:</b> ${data.cop}COP</span><br>
                      <span><b>VES:</b> ${data.ves}VES</span><br>`)
    })
  
    .fail((err) => {
        console.log(err.responseText)
    })
  }

  $(".comision").on("click", () => {
    let comision = prompt("Nuevo valor para comisiones (ej: 0.00500)")
    let email = localStorage.getItem("admin_email")

    if (!comision || comision === '0') {
      alert("El campo no puede estar vacío o ser igual a 0")
    } else {
      $.ajax({
        type: "POST",
        url: "controllers/admin/setNewComisionValue.php",
        dataType: "json",
        data: {email,comision}
      })
    
      .done((data) => {
        console.log(data)
        if (data.status == "fine") {
          alert("Nuevas comisiones de compra establecidas!")
        }else if (data.status == "bad") {
          alert("Hubo un error en la base de datos!")
        }else {
          alert("Hubo un error desconocido")
        }
      })
    
      .fail((err) => {
        console.log(err.responseText)
      })
    }
  })

  $(".buyOrd").on("click", () => {
    let tip_ord = "buy"
    let usu_def = localStorage.getItem("admin_email")
    let ves_cop = prompt("Nuevo valor para la tasa VES -> COP")
    let usd_ves = prompt("Nuevo valor para la tasa USD -> VES")
    let cop_usd = prompt("Nuevo valor para la tasa COP -> USD")

    if (!ves_cop || ves_cop == '0' || !usd_ves || usd_ves == '0' || !cop_usd || cop_usd == '0') {
      alert("No puede dejar ningun valor vacío o igual a 0")
    }else{
      $.ajax({
        type: "POST",
        url: "controllers/admin/setNewSellOrBuyRateOrd.php",
        dataType: "json",
        data: {tip_ord,usu_def,ves_cop,usd_ves,cop_usd}
      })

      .done((data) => {
        console.log(data)
        if (data.status == "fine") {
          alert("Nuevas comisiones de compra establecidas!")
        }else if (data.status == "bad") {
          alert("Hubo un error en la base de datos!")
        }else {
          alert("Hubo un error desconocido")
        }
      })

      .fail((err) => {
        console.log(err.responseText);
      })
    }
  })

  $(".sellOrd").on("click", () => {
    let tip_ord = "sell"
    let usu_def = localStorage.getItem("admin_email")
    let ves_cop = prompt("Nuevo valor para la tasa VES -> COP")
    let usd_ves = prompt("Nuevo valor para la tasa USD -> VES")
    let cop_usd = prompt("Nuevo valor para la tasa COP -> USD")

    if (!ves_cop || ves_cop == '0' || !usd_ves || usd_ves == '0' || !cop_usd || cop_usd == '0') {
      alert("No puede dejar ningun valor vacío o igual a 0")
    }else{
      $.ajax({
        type: "POST",
        url: "controllers/admin/setNewSellOrBuyRateOrd.php",
        dataType: "json",
        data: {tip_ord,usu_def,ves_cop,usd_ves,cop_usd}
      })

      .done((data) => {
        console.log(data)
        if (data.status == "fine") {
          alert("Nuevas comisiones de compra establecidas!")
        }else if (data.status == "bad") {
          alert("Hubo un error en la base de datos!")
        }else {
          alert("Hubo un error desconocido")
        }
      })

      .fail((err) => {
        console.log(err.responseText);
      })
    }
  })
})