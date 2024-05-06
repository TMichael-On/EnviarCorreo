<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inicio de sesión</title>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <style>
      /* Estilos personalizados */
      .login-container {
        max-width: 400px;
        margin: auto;
        margin-top: 50px;
      }
      .login-logo {
        text-align: center;
      }
      .success-message {
        color: green;
      }
      .error-message {
        color: red;
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
      }
    </style>
  </head>
  <body>
    <div class="container content">
      <div class="login-container">
        <div class="login-logo">
          <img src="public\image\logo-1.png" alt="Logo" class="logo w-25 h-25"/>
        </div>
        <h2 class="text-center mb-4">Login</h2>
        <form id="loginForm">
          <div class="mb-3">
            <label for="inputEmail" class="form-label"
              >Correo electrónico</label
            >
            <input
              type="email"
              class="form-control"
              id="inputEmail"
              placeholder="nombre@ejemplo.com"
              required
            />
          </div>
          <div class="mb-3">
            <label for="inputPassword" class="form-label">Contraseña</label>
            <input
              type="password"
              class="form-control"
              id="inputPassword"
              placeholder="Contraseña"
              required
            />
          </div>
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
              Iniciar sesión
            </button>
          </div>
        </form>
        <div id="message" class="mt-3"></div>
      </div>
    </div>
    <div class="col-auto" style="display: none">
      <span id="userSpan"></span>
    </div>    
  <footer class="footer text-center">
    <div class="container">
      Propiedad intelectual PT-Digital &copy; <?php echo date("Y"); ?>
       | Contacto 
       | +51 917 806 858
       | cdelacallecoz@gmail.com
    </div>
  </footer>

    <!-- Bootstrap Bundle JS (Popper incluido) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      const userSpan = document.getElementById("userSpan");
      document
        .getElementById("loginForm")
        .addEventListener("submit", function (event) {
          event.preventDefault();
          const correo = document.getElementById("inputEmail").value;
          const contra = document.getElementById("inputPassword").value;
          const ruta = "/acceso"; // Ruta del servidor
          const datos = {
            correo: correo,
            contra: contra
          };
          const opciones = {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(datos)
          };
          fetch(ruta, opciones)          
            .then((response) => response.json())
            .then((data) => {
              const messageElement = document.getElementById("message");
              if (data.token) {              
                const mensaje = "Inicio de sesión exitoso";
                messageElement.innerText = mensaje;
                messageElement.classList.remove("error-message");
                messageElement.classList.add("success-message");
                const token = data.token;
                fetch("/home", {
                  method: "GET",
                  headers: {
                    "Authorization": "Bearer " + token
                  }
                })
                .then(response => {
                  if (!response.ok) {
                    throw new Error("Error al cargar la página de inicio");
                  }
                  localStorage.setItem("token", data.token);    
                  setTimeout(function () {
                    window.location.href = "/home";
                  }, 1500);
                })
                .catch(error => {
                  console.error("Error:", error);
                });
              } else {
                messageElement.innerText = data.error;
                messageElement.classList.add("error-message");
              }
            })
            .catch((error) => console.error("Error:", error));
        });
    </script>
  </body>
</html>
