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
    btc.innerHTML="Sin internet"
  })

  setInterval(() => {
    $.ajax({
      type: "POST",
      url: "controllers/consultarSaldo.php",
      dataType: "html"
    })

    .done((data) => {
      document.querySelector(".numbers").innerHTML=data
    })
  }, 2000);
})