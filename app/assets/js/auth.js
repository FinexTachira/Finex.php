let access = localStorage.getItem("access")
access === "true" ? access : location.assign("../index.html")