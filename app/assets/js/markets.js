$(document).ready(() => {
  $('.bx-menu').on('click', () => {
    let menu = document.querySelector(".bx-menu")
    menu.classList.toggle("menu-full")
    let sidebar = document.querySelector(".Sidebar")
    sidebar.classList.toggle("mini")
    let main = document.querySelector(".main")
    main.classList.toggle("full")
  })

  let market = document.querySelector(".market")
  market.classList.add("focus-list")
  
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

  $.ajax({
    type: "GET",
    url: "https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=100&page=1",
    dataType: "json",
    data: {},
  })

  .done((data) => {
    var myMap = []
    var table = document.querySelector(".tabla")
    var tabla = document.createElement("table")
    var thead = document.createElement("thead")
    var th1   = document.createElement("th")
    var tth1  = document.createTextNode("N°")
    var th2   = document.createElement("th")
    var tth2  = document.createTextNode("Icono")
    var th3   = document.createElement("th")
    var tth3  = document.createTextNode("Nombre")
    var th4   = document.createElement("th")
    var tth4  = document.createTextNode("Precio")
    var th5   = document.createElement("th")
    var tth5  = document.createTextNode("Bajo")
    var th6   = document.createElement("th")
    var tth6  = document.createTextNode("Alto")
    var th7   = document.createElement("th")
    var tth7  = document.createTextNode("Capital")
    var tbody = document.createElement("tbody")

    th1.appendChild(tth1)
    th2.appendChild(tth2)
    th3.appendChild(tth3)
    th4.appendChild(tth4)
    th5.appendChild(tth5)
    th6.appendChild(tth6)
    th7.appendChild(tth7)
    thead.appendChild(th1)
    thead.appendChild(th2)
    thead.appendChild(th3)
    thead.appendChild(th4)
    thead.appendChild(th5)
    thead.appendChild(th6)
    thead.appendChild(th7)

    for (let i = 0; i < data.length; i++) {
      let image   = data[i].image
      let symbol  = data[i].symbol
      let name    = data[i].name
      let price   = data[i].current_price
      let low     = data[i].low_24h
      let high    = data[i].high_24h
      let capital = data[i].market_cap

      myMap.push({image,symbol,name,price,low,high,capital})

      var colum = document.createElement("tr")
      var td1   = document.createElement("td")
      var ttd1  = document.createTextNode(i+1)
      var td2   = document.createElement("td")
      var ttd2  = document.createElement("img")
      var td3   = document.createElement("td")
      var ttd3  = document.createTextNode(name)
      var td4   = document.createElement("td")
      var ttd4  = document.createTextNode(price+"$")
      var td5   = document.createElement("td")
      var ttd5  = document.createTextNode(low+"$")
      var td6   = document.createElement("td")
      var ttd6  = document.createTextNode(high+"$")
      var td7   = document.createElement("td")
      var ttd7  = document.createTextNode(capital+"$")
      ttd2.setAttribute("src", image)
      ttd2.setAttribute("class", "icon")
      td1.appendChild(ttd1)
      td2.appendChild(ttd2)
      td3.appendChild(ttd3)
      td4.appendChild(ttd4)
      td5.appendChild(ttd5)
      td6.appendChild(ttd6)
      td7.appendChild(ttd7)
      colum.appendChild(td1)
      colum.appendChild(td2)
      colum.appendChild(td3)
      colum.appendChild(td4)
      colum.appendChild(td5)
      colum.appendChild(td6)
      colum.appendChild(td7)
      tbody.appendChild(colum)
    }

    tabla.appendChild(thead)
    tabla.appendChild(tbody)
    table.appendChild(tabla)
    tabla.setAttribute("class", "myTabla")
    let divvv = document.querySelector(".centered")
    divvv.setAttribute("style", "display:none")
  })

  .fail(() => {
    let table = document.querySelector(".tabla")
    table.innerHTML =  `<div class='centered'>
                          <h2 class='litleGreen'>No tienes conexion a internet</h2>
                        </div>`
  })
})