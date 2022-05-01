<div class="header-modal">
  <div class="close-modal">
    <i class="bx bx-x-circle" id="close"></i>
  </div>
  <div class="title-modal">
    <h2>Perfil</h2>
  </div>
</div>

<div class="body-modal">
  <div class="major">
    <div class="name-box">
      <div class="names">
        <h1 class="big-green name"></h1>
      </div>
      <div class="surnames">
        <h6 class="little-white last-names"></h6>
      </div>
    </div>

    <div class="information-user">
      <div class="direction">
        <div class="header-dir">
          <h2>
            <i class="bx bx-map"></i>
            Dirección
          </h2>
          <br/>
          <p>
            <span class="city"></span>
            <?php
              $_SESSION['dir_usr'] ? print $_SESSION['dir_usr'] : print "<span>Dirección no registrada";
            ?>
          </p>
        </div>
      </div>

      <div class="info-modal">
        <h2>
          <i class="bx bxs-contact"></i>
          Información de contacto
        </h2>
        <br/>
        <div class="email-modal">
          <p>
            <b>Correo:</b> 
            <?php echo $_SESSION['ema_usr']; ?>
            <!-- <small>
              <a href='#'>
                <i class="bx bx-pencil"></i>
                cambiar
              </a>
            </small> -->
          </p>
        </div>
        <div class="phone-modal">
          <p>
            <b>Número de celular:</b> 
            <?php echo $_SESSION['tlf_usr']; ?>
            <!-- <small>
              <a href='#'>
                <i class="bx bx-pencil"></i>
                cambiar
              </a>
            </small> -->
          </p>
        </div>
      </div>

      <div class="otra-info">
        <div class="other-box">
          <h2>
            <i class="bx bxs-user-detail"></i>
            Otros
          </h2>
          <br/>
          <p class="gender"></p>
          <p class="birthday"></p>
        </div>
      </div>
    </div>
  </div>
  <div class="minor">
    <div class="container-img">
      <div class="img-usr">
        <img src="assets/img/user.png" alt="Perfil">
      </div>
      <div class="document">
        <h4>Documento legal</h4>
        <h5 class="cedula"></h5>
      </div>
      <div class="country">
        <h4 class="country"></h4>
      </div>
    </div>
    <div class="franja">
      <small class="desde"></small>
    </div>
    <div class="piso">
      <div class="last-session">
        
      </div>
    </div>
  </div>
</div>