$(document).ready(() => {
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
    type: "POST",
    url: "controllers/setProfile.php",
    dataType: "json",
    data: {
      ema: localStorage.getItem("email")
    }
  })

  .done((data) => {
    console.log(data)
    let a = data.nom_usr
    let b = a.split(" ")
    let firstName = b[0]
    delete b[0]
    let lastName
    !b[2] ? lastName = b[1] : lastName = b[1]+' '+b[2]
    let gender   = data.gnd_usr
    let birthday = data.bir
    gender == "male" ? gender = "Masculino" : gender = "Femenino"
    !gender ? gender = "<b>Genero:</b>" : gender = "<b>Genero:</b> "+gender
    !birthday ? birthday = "<b>Fecha de nacimiento:</b>" : birthday = "Fecha de nacimiento: "+birthday
    let cedula  = data.doc_usr
    let country = data.pai_usr
    !cedula ? cedula = "" : cedula
    !country ? country = "" : country
    let city = data.ciu_usr
    let c = data.fch_reg
    let d = c.split("-")
    let desde = "desde "+d[0]
    !city ? city = "Ciudad no registrada - " : city = city+" - "

    document.querySelector(".name").innerHTML=firstName
    document.querySelector(".nameNav").innerHTML=firstName
    document.querySelector(".last-names").innerHTML=lastName
    document.querySelector(".gender").innerHTML=gender
    document.querySelector(".birthday").innerHTML=birthday
    document.querySelector(".cedula").innerHTML=cedula
    document.querySelector(".country").innerHTML=country
    document.querySelector(".city").innerHTML=city
    document.querySelector(".desde").innerHTML=desde
  })

  .fail((err) => {
    console.log(err.responseText, "nanai")
  })
})