<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registro</title>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <style>
      /* Estilos personalizados */
      .register-container {
        max-width: 400px;
        margin: auto;
        margin-top: 50px;
      }
      .register-logo {
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
    <div class="container content">
      <div class="register-container">
        <div class="register-logo">
          <img src="public\svg\logo-1.svg" alt="Logo" />
        </div>
        <h2 class="text-center mb-4">Registro</h2>
        <form id="registerForm">
          <div class="mb-3 row">
            <div class="col">
              <label for="inputNombre" class="form-label">Nombres</label>
              <input
                type="text"
                class="form-control"
                id="inputNombre"
                name="inputNombre"
                placeholder="Nombres"
                required
              />
            </div>
            <div class="col">
              <label for="inputApellido" class="form-label">Apellidos</label>
              <input
                type="text"
                class="form-control"
                id="inputApellido"
                name="inputApellido"
                placeholder="Apellidos"
                required
              />
            </div>
          </div>

          <div class="mb-3">
            <label for="inputEmail" class="form-label"
              >Correo electrónico</label
            >
            <input
              type="email"
              class="form-control"
              id="inputEmail"
              name="inputEmail"
              placeholder="nombre@ejemplo.com"
              required
            />
          </div>
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
                  src="public\svg\eye-2.svg"
                  alt="Ocultar contraseña"
                  id="eye-icon-2"
                />
              </button>
            </div>
          </div>
          <div class="mb-3">
            <label for="inputTelefono" class="form-label">Teléfono</label>
            <input
              type="tel"
              class="form-control"
              id="inputTelefono"
              name="inputTelefono"
              placeholder="+51912345678"
              required
            />
          </div>
          <div class="mb-3">
            <label for="inputUrlGmail" class="form-label">Url Gmail</label>
            <img
              src="public\svg\question-1.svg"
              alt="Mostrar contraseña"
              id="question-1"
              style="cursor: pointer"
              onclick="redireccionar1();"
            />
            <textarea
              type="tel"
              class="form-control"
              id="inputUrlGmail"
              name="inputUrlGmail"
              placeholder="https://script.google.com/macros/s/..."
              rows="4"
              required
            ></textarea>
          </div>
          <div class="mb-3">
            <label for="inputCodigoWhatsapp" class="form-label"
              >Código de WhatsApp</label
            >
            <img
              src="public\svg\question-1.svg"
              alt="Mostrar contraseña"
              id="question-3"
              style="cursor: pointer"
              onclick="redireccionar3();"
            />
            <textarea
              class="form-control"
              id="inputCodigoWhatsapp"
              name="inputCodigoWhatsapp"
              placeholder="Pega el texto largo aquí..."
              rows="7"
              required
            ></textarea>
          </div>
          <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary">Registrarse</button>
          </div>
        </form>
        <div id="errorMessage" class="mt-3 error-message" style="display: none">
          Las contraseñas no coinciden.
        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
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
            eyeIcon1.src="public/svg/eye-1.svg";
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

        inputPass1.addEventListener("input", function () {
          const count = inputPass1.value.length;
          characterCount.textContent = count + "/20";
        });

        document
          .getElementById("registerForm")
          .addEventListener("submit", function (event) {
            event.preventDefault();
            const pass1 = document.getElementById("inputPass1").value;
            const pass2 = document.getElementById("inputPass2").value;
            if (pass1 !== pass2) {
              document.getElementById("errorMessage").style.display = "block";
            } else {
              fetch("http://localhost/proyecto/php/register.php", {
                method: "POST",
                body: new FormData(this),
              })
                .then((response) => response.text())
                .then((data) => {
                  if (data === "existing_email") {
                    alert("Correo ya existente.");
                  } else if (data === "success") {
                    alert("Registro exitoso.");
                    setTimeout(function () {
                      window.location.href = "proyecto/html/login.html";
                    }, 1000);
                  } else {
                    alert(data);
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
    <script>
      function redireccionar1() {
        var url = "https://tu-url1-aqui.com";
        window.open(url, "_blank");
      }
    </script>
    <script>
      function redireccionar2() {
        var url = "https://tu-url2-aqui.com";
        window.open(url, "_blank");
      }
    </script>
    <script>
      function redireccionar3() {
        var url = "https://tu-url3-aqui.com";
        window.open(url, "_blank");
      }
    </script>
  </body>
</html>
