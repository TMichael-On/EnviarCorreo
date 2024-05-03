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
    <div class="content container">
      <div class="login-container">
        <div class="login-logo">
          <img src="public\svg\logo-1.svg" alt="Logo" />
        </div>
        <h2 class="text-center mb-4">Recuperar contraseña</h2>
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
      document
        .getElementById("loginForm")
        .addEventListener("submit", function (event) {
          event.preventDefault();
          const correo = document.getElementById("inputEmail").value;
          const characters =
            "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!#*-_";
          let result = "";
          const length = 12; // Aumentado de 6 a 12 para más seguridad
          const array = new Uint8Array(length);

          // Utiliza crypto.getRandomValues para una mejor generación de números aleatorios
          window.crypto.getRandomValues(array);

          for (let i = 0; i < length; i++) {
            result += characters.charAt(array[i] % characters.length);
          }
          const formData = new FormData();
          formData.append("inputEmail", correo);
          formData.append("inputPass1", result);
          fetch("http://localhost/proyecto/php/cambiar-contra.php", {
            method: "POST",
            body: formData,
          })
            .then((response) => response.text())
            .then((data) => {
              if (data === "dont_existing_email") {
                alert("Correo no existente.");
              } else if (data === "success") {
                enviarCorreo(correo, result);
                alert("Cambio exitoso, revise su correo.");
                setTimeout(function () {
                  window.location.href = "/proyecto/html/login.html";
                }, 1000);
              } else {
                alert(
                  "Ocurrió un error al cambiar la contraseña. Por favor, inténtalo de nuevo."
                );
              }
            })
            .catch((error) => {
              console.error("Error:", error);
              alert("Error al enviar la solicitud.");
            });
        });

      function enviarCorreo(emailDestinatario, nuevaContrasena) {
        const formData = new FormData();
        formData.append("email", emailDestinatario);
        formData.append("password", nuevaContrasena);

        fetch("http://localhost/proyecto/php/enviar-contra.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.text())
          .then((data) => console.log(data))
          .catch((error) => console.error("Error al enviar correo:", error));
      }
    </script>
  </body>
</html>
