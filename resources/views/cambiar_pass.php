<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Recuperación de contraseña</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    .user-header {
      background-color: #f8f9fa;
      padding: 10px 0;
      height: 100px;
    }
    .user-header .logout-btn {
      text-decoration: underline;
    }
    .user-header .home-title {
      font-size: 1.5rem;
      font-weight: bold;
      margin: 0;
    }
    .user-header .logo {
      max-width: 50px;
      height: auto;
      margin-right: 10px;
    }
    .user-body {
      margin-top: 20px;
    }
    .login-container {
      max-width: 400px;
      margin: 50px auto;
    }
    .login-logo {
      text-align: center;
    }
    .success-message,
    .error-message {
      text-align: center;
    }
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }
    .content {
      flex: 1;
    }
    footer {
      background-color: #343a40;
      color: #ffffff;
      padding: 20px 0;
  position: fixed;
  bottom: 0;
  width: 100%;
    }

  </style>
</head>
<body>
<!-- Encabezado -->
      <div class="user-header">
        <div class="row align-items-center">
          <div class="col-auto">
          <img src="public\image\logo-1.png" onclick="home()" alt="Logo" class="logo"/>
          </div>
          <div class="col">
            <h1 class="home-title"  onclick="home()">Home</h1>
          </div>
          <div class="col-auto">
            <div class="row">
              <div class="col-12">
                <span class="user-name">Apellidos, Nombres</span>
              </div>
              <div class="col-12">
                <span class="user-mail">Correo</span>
              </div>
            </div>
          </div>
          <div class="col-auto">
            <div class="row">
              <div class="col-12">
                <button class="btn changepass-btn" onclick="home()">Home</button>
              </div>
              <div class="col-12">
                <button class="btn logout-btn" onclick="exit()">Logout</button>
              </div>
            </div>
          </div>
        </div>
      </div>
<div class="container">
  <div class="login-container">
    <div class="login-logo">
      <img src="public\image\logo-1.png" alt="Logo" class="logo w-25 h-25"/>
    </div>
    <h2 class="text-center mb-4">Cambiar contraseña</h2>
    <form id="loginForm">
      <div class="mb-3">
        <label for="inputPass1" class="form-label">Contraseña [6-20 caracteres]</label>
        <div class="input-group">
          <input
            type="password"
            class="form-control"
            id="inputPass1"
            placeholder="********"
            aria-describedby="btn-view-pass1"
            minlength="6"
            maxlength="20"
            required
          />
          <button
            class="btn btn-outline-secondary"
            type="button"
            id="btn-view-pass1"
          >
            <img
              src="public/svg/eye-1.svg"
              alt="Mostrar contraseña"
              id="eye-icon-1"
            />
          </button>
          <span class="input-group-text" id="characterCount">0/20</span>
        </div>
      </div>

      <div class="mb-3">
        <label for="inputPass2" class="form-label">Confirma la contraseña</label>
        <div class="input-group">
          <input
            type="password"
            class="form-control"
            id="inputPass2"
            placeholder="********"
            aria-describedby="btn-view-pass2"
            required
          />
          <button
            class="btn btn-outline-secondary"
            type="button"
            id="btn-view-pass2"
          >
            <img
              src="public/svg/eye-1.svg"
              alt="Mostrar contraseña"
              id="eye-icon-2"
            />
          </button>
        </div>
      </div>
      <div class="d-grid gap-2">
        <button type="submit" class="btn btn-primary">Enviar solicitud</button>
      </div>
    </form>
    <div id="message" class="mt-3"></div>
    <div id="errorMessage" class="error-message" style="display: none;">Las contraseñas no coinciden.</div>
  </div>
</div>
<footer class="footer text-center">
  <div class="container">
    Propiedad intelectual DYNAMICDEVGROUP  &copy; <?php echo date("Y"); ?>
     | Contacto 
     | +51 917 806 858
     | cdelacallecoz@gmail.com
     | https://dynamicdevgroup.site/
  </div>
</footer>

<!-- Bootstrap Bundle JS (Popper incluido) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
      document.addEventListener("DOMContentLoaded", function () {
      const token = localStorage.getItem("token");
      const headers = {
        "Authorization": "Bearer " + token
      };

      // Realizamos la solicitud fetch con el encabezado de autorización
      fetch("/buscarById", {
        headers: headers
      })
      .then((response) => response.json())
      .then((data) => {
        if (data) {
          const userSpan = document.querySelector(".user-name");
          if (userSpan) {
            userSpan.textContent = `${data.apellidos}, ${data.nombres}`;
          } else {
            console.error("El elemento con la clase 'user-name' no se encontró en el DOM");
          }
          const userMail = document.querySelector(".user-mail");
          if (userMail) {
            userMail.textContent = `${data.correo}`;
          } else {
            console.error("El elemento con la clase 'user-mail' no se encontró en el DOM");
          }
        } else {
          console.error("No se pudieron obtener los datos del usuario");
        }
      })
      .catch((error) => {
        console.error("Error al realizar la solicitud:", error);
      });
    });
    </script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const btnViewPass1 = document.getElementById("btn-view-pass1");
    const inputPass1 = document.getElementById("inputPass1");
    const eyeIcon1 = document.getElementById("eye-icon-1");

    btnViewPass1.addEventListener("click", function () {
      if (inputPass1.type === "password") {
        inputPass1.type = "text";
        eyeIcon1.src = "public/svg/eye-2.svg";
      } else {
        inputPass1.type = "password";
        eyeIcon1.src = "public/svg/eye-1.svg";
      }
    });

    const btnViewPass2 = document.getElementById("btn-view-pass2");
    const inputPass2 = document.getElementById("inputPass2");
    const eyeIcon2 = document.getElementById("eye-icon-2");

    btnViewPass2.addEventListener("click", function () {
      if (inputPass2.type === "password") {
        inputPass2.type = "text";
        eyeIcon2.src = "public/svg/eye-2.svg";
      } else {
        inputPass2.type = "password";
        eyeIcon2.src = "public/svg/eye-1.svg";
      }
    });
  });
</script>
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const inputPass1 = document.getElementById("inputPass1");
    const characterCount = document.getElementById("characterCount");
    const errorMessage = document.getElementById("errorMessage");

    inputPass1.addEventListener("input", function () {
      const count = inputPass1.value.length;
      characterCount.textContent = count + "/20";
    });

    document.getElementById("loginForm").addEventListener("submit", function (event) {
      event.preventDefault();
      const pass1 = document.getElementById("inputPass1").value;
      const pass2 = document.getElementById("inputPass2").value;

      if (pass1.length < 6 || pass1.length > 20) {
        errorMessage.textContent = "La contraseña debe tener entre 6 y 20 caracteres.";
        errorMessage.style.display = "block";
        return;
      }
      if (pass1 !== pass2) {
        errorMessage.textContent = "Las contraseñas no coinciden.";
        errorMessage.style.display = "block";
        return;
      }
      const token = localStorage.getItem("token");
      var headers = {'Content-Type': 'application/json'};
      if (token) {
          headers['Authorization'] = `Bearer ${token}`;
      }
      const ruta = "/actualizar";
      const datos = {
        "contra": pass1
      };
      const opciones = {
        method: 'POST',
        headers: headers,
        body: JSON.stringify(datos)
      };
      fetch(ruta, opciones)
        .then((data) => {          
          data.json().then(response => {	
            if (response.message) {
              alert("Cambio de contraseña exitoso.");
              setTimeout(function () {
                window.location.href = "/login";
              }, 1500);
            } else {
              alert("Error: " + response.error);
            }
          })
        })
        .catch((error) => {
          alert("Error al enviar la solicitud: ", error.message);
        });
    });
  });
</script>


<script>
  function home() {
    window.location.href = "/home";
  }
</script>
<script>
  function exit() {
    localStorage.removeItem("token");
    window.location.href = "/login";
  }
</script>
</body>
</html>
