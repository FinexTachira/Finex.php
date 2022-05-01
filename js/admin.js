let body = document.querySelector(".footer_input")
let key = "finex1234"
let obj  = []

body.oninput = (e) => {
  obj.push(e.data)
  obj.join("") === "adminFinex" ? auth() : obj
}

function auth() {
  if (localStorage.getItem("access") === 'false') {
    alert("Acceso root bloqueado")
    return false
  }
  for (let i = 1; i <= 3; i++) {
    let keyword = prompt(`Auntenticate (intento ${i})`)
    if(keyword === key) {
      localStorage.setItem("access", true)
      location.assign("app/admin.php")
      i = 4
    }else{
      alert("Contraseña incorrecta")
      if (i === 3) {
        alert("bloquearemos su acceso root")
        localStorage.setItem("access", false)
      }
    }
  }
}
