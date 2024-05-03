<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Recuperación de contraseña</title>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <style>
      .user-header {
        background-color: #f8f9fa;
        padding: 10px 0;
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
      }
    </style>
  </head>
  <body>
    <div class="user-header content
    ">
      <div class="row align-items-center">
        <div class="col-auto p-6">
          <img src="public\image\logo-1.png" alt="Logo" class="logo"/>
        </div>
        <div class="col">
          <button class="btn changepass-btn">Home</button>
        </div>
        <div class="col-auto">
          <span id="userSpan"></span>
        </div>
        <div class="col-auto">
          <div class="row">
            <div class="col-12">
              <button class="btn changepass-btn">Inicio</button>
            </div>
            <div class="col-12">
              <button class="btn logout-btn">Logout</button>
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
            <label for="inputPass1" class="form-label"
              >Contraseña [6-20 caracteres]</label
            >
            <div class="input-group">
              <input
                type="password"
                class="form-control"
                id="inputPass1"
                name="inputPass1"
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
                  src="public\svg\eye-1.svg"
                  alt="Mostrar contraseña"
                  id="eye-icon-1"
                />
              </button>
              <span class="input-group-text" id="characterCount">0/20</span>
            </div>
          </div>

          <div class="mb-3">
            <label for="inputPass2" class="form-label"
              >Confirma la contraseña</label
            >
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
                  src="public\svg\eye-1.svg"
                  alt="Mostrar contraseña"
                  id="eye-icon-2"
                />
              </button>
            </div>
          </div>
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">
              Enviar solicitud
            </button>
          </div>
        </form>
        <div id="message" class="mt-3"></div>
      </div>
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
      document.addEventListener("DOMContentLoaded", function () {
        const btnViewPass1 = document.getElementById("btn-view-pass1");
        const inputPass1 = document.getElementById("inputPass1");
        const eyeIcon1 = document.getElementById("eye-icon-1");

        btnViewPass1.addEventListener("click", function () {
          if (inputPass1.type === "password") {
            inputPass1.type = "text";
            eyeIcon1.src = "../svg/eye-2.svg";
          } else {
            inputPass1.type = "password";
            eyeIcon1.src = "../svg/eye-1.svg";
          }
        });

        const btnViewPass2 = document.getElementById("btn-view-pass2");
        const inputPass2 = document.getElementById("inputPass2");
        const eyeIcon2 = document.getElementById("eye-icon-2");

        btnViewPass2.addEventListener("click", function () {
          if (inputPass2.type === "password") {
            inputPass2.type = "text";
            eyeIcon2.src = "../svg/eye-2.svg";
          } else {
            inputPass2.type = "password";
            eyeIcon2.src = "../svg/eye-1.svg";
          }
        });
      });
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const inputPass1 = document.getElementById("inputPass1");
        const characterCount = document.getElementById("characterCount");

        inputPass1.addEventListener("input", function () {
          const count = inputPass1.value.length;
          characterCount.textContent = count + "/20";
        });

        document
          .getElementById("loginForm")
          .addEventListener("submit", function (event) {
            event.preventDefault();
            const pass1 = document.getElementById("inputPass1").value;
            const pass2 = document.getElementById("inputPass2").value;
            if (pass1 !== pass2) {
              document.getElementById("errorMessage").style.display = "block";
            } else {
              const correo = "inucendgasis@gmail.com";
              const formData = new FormData();
              formData.append("inputEmail", correo);
              formData.append("inputPass1", pass1);
              fetch("http://localhost/proyecto/php/cambiar-contra.php", {
                method: "POST",
                body: formData,
              })
                .then((response) => response.text())
                .then((data) => {
                  if (data === "dont_existing_email") {
                    alert("Correo no existente.");
                  } else if (data === "success") {
                    alert("Cambio exitoso.");
                    setTimeout(function () {
                      window.location.href = "/proyecto/html/login.html";
                    }, 1500);
                  } else {
                    alert(
                      "Ocurrió un error al registrar. Por favor, inténtalo de nuevo."
                    );
                  }
                })
                .catch((error) => {
                  console.error("Error:", error);
                  alert("Error al enviar la solicitud.");
                });
            }
          });
      });
    </script>
  </body>
</html>
