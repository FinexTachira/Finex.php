const fila = document.querySelector(".main-carrousel")
const slid = document.querySelectorAll(".adviser")
const larr = document.getElementById("arrow-left")
const rarr = document.getElementById("arrow-right")
const page = Math.ceil(slid.length / 5)
const indi = document.querySelector(".indicators")

rarr.addEventListener("click", () => {
  fila.scrollLeft += fila.offsetWidth

  const ia = document.querySelector(".indicators .active")
  if (ia.nextSibling) {
    ia.nextSibling.classList.add("active")
    ia.classList.remove("active")
  }
})

larr.addEventListener("click", () => {
  fila.scrollLeft -= fila.offsetWidth

  const ia = document.querySelector(".indicators .active")
  if (ia.previousSibling) {
    ia.previousSibling.classList.add("active")
    ia.classList.remove("active")
  }
})

for (let i = 0; i < page; i++) {
  const indicator = document.createElement("button")
  if (i===0) {
    indicator.classList.add("active")
  }
  indi.appendChild(indicator)
  indicator.addEventListener("click", (e) => {
    fila.scrollLeft = i * fila.offsetWidth
    document.querySelector(".indicators .active").classList.remove("active")
    e.target.classList.add("active")
  })
}

slid.forEach((slider) => {
  slider.addEventListener("mouseenter", (e) => {
    const element = e.currentTarget
    setTimeout(() => {
      slid.forEach(slider => slider.classList.remove("hover"))
      element.classList.add("hover")
    }, 300)
  })
})

fila.addEventListener("mouseleave", () => {
  slid.forEach(slider => slider.classList.remove("hover"))
})

$(document).ready(() => {
  $('.bx-menu').on('click', () => {
    let menu = document.querySelector(".bx-menu")
    menu.classList.toggle("menu-full")
    let sidebar = document.querySelector(".Sidebar")
    sidebar.classList.toggle("mini")
    let main = document.querySelector(".main")
    main.classList.toggle("full")
  })

  let index = document.querySelector(".index")
  index.classList.add("focus-list")

  $.ajax({
    type: "GET",
    url: "https://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&order=market_cap_desc&per_page=1&page=1",
    dataType: "json",
    data: {},
  })

  .done((data) => {
    let btc = document.querySelector(".btc_price")
    btc.innerHTML=data[0].current_price+"$"
  })

  .fail((err) => {
    let btc = document.querySelector(".btc_price")
    console.log(err);
    btc.innerHTML="Sin internet"
  })

  setInterval(() => {
    $.ajax({
      type: "POST",
      url: "controllers/consultarSaldo.php",
      dataType: "json",
      data: {}
    })

    .done((data) => {
      document.querySelector(".saldo_my_wallet").innerHTML=parseFloat(data.saldo).toFixed(2)+"USD"
      document.querySelector(".usd_price").innerHTML=data.usdtasa+"VES"
      console.log(data)
      localStorage.setItem("usdtasa", data.usdtasa)
      localStorage.setItem("coptasa", data.coptasa)
      localStorage.setItem("vestasa", data.vestasa)
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