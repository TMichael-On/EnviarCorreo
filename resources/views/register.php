<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Registro</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    /* Estilos personalizados */
    .register-container {
      align-items: center;
      max-width: 400px;
      margin: auto;
      margin-top: 50px;
    }

    .register-logo {
      text-align: center;
      cursor: pointer;
    }

    .register-logo img {
      max-width: 50px;
      height: auto;
      margin-right: 10px;
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

    .label {
      border: none;
      padding: 10px;
      cursor: pointer;
      color: blue;
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <div class="container content">
    <div class="register-container">
      <div class="register-logo">
        <img src="public\image\logo-1.png" onclick="login()" alt="Logo" />
      </div>
      <h2 class="text-center mb-4">Registro</h2>
      <form id="registerForm">
        <div class="mb-3 row">
          <div class="col">
            <label for="inputNombre" class="form-label">Nombres</label>
            <input type="text" class="form-control" id="inputNombre" name="inputNombre" placeholder="Nombres" required />
          </div>
          <div class="col">
            <label for="inputApellido" class="form-label">Apellidos</label>
            <input type="text" class="form-control" id="inputApellido" name="inputApellido" placeholder="Apellidos" required />
          </div>
        </div>

        <div class="mb-3">
          <label for="inputEmail" class="form-label">Correo electrónico</label>
          <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="nombre@ejemplo.com" required />
        </div>
        <div class="mb-3">
          <label for="inputPass1" class="form-label">Contraseña [6-20 caracteres]</label>
          <div class="input-group">
            <input type="password" class="form-control" id="inputPass1" name="inputPass1" placeholder="********" aria-describedby="btn-view-pass1" minlength="6" maxlength="20" required />
            <button class="btn btn-outline-secondary" type="button" id="btn-view-pass1">
              <img src="public\svg\eye-1.svg" alt="Mostrar contraseña" id="eye-icon-1" />
            </button>
            <span class="input-group-text" id="characterCount">0/20</span>
          </div>
        </div>

        <div class="mb-3">
          <label for="inputPass2" class="form-label">Confirma la contraseña</label>
          <div class="input-group">
            <input type="password" class="form-control" id="inputPass2" placeholder="********" aria-describedby="btn-view-pass2" required />
            <button class="btn btn-outline-secondary" type="button" id="btn-view-pass2">
              <img src="public\svg\eye-2.svg" alt="Ocultar contraseña" id="eye-icon-2" />
            </button>
          </div>
        </div>
        <div class="mb-3">
          <label for="inputUrlGmail" class="form-label">Url Gmail</label>
          <img src="public\svg\question-1.svg" alt="Mostrar contraseña" id="question-1" style="cursor: pointer" onclick="redireccionar1();" />
          <textarea type="tel" class="form-control" id="inputUrlGmail" name="inputUrlGmail" placeholder="https://script.google.com/macros/s/..." rows="4" required></textarea>
        </div>
        <div class="d-grid gap-2">
          <button type="submit" class="btn btn-primary">Registrarse</button>
        </div>
      </form>

      <label class="label" onclick="login()">Login</label>
      <div id="errorMessage" class="mt-3 error-message" style="display: none">
        Las contraseñas no coinciden.
      </div>
    </div>
  </div>

  <footer class="footer text-center">
    <div class="container">
      Propiedad intelectual DYNAMICDEVGROUP &copy; <?php echo date("Y"); ?>
      | Contacto
      | +51 917 806 858
      | cdelacallecoz@gmail.com
      | https://dynamicdevgroup.site/
    </div>
  </footer>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const inputPass1 = document.getElementById("inputPass1");
      const characterCount = document.getElementById("characterCount");

      inputPass1.addEventListener("input", function() {
        const count = inputPass1.value.length;
        characterCount.textContent = count + "/20";
      });

      document.getElementById("registerForm").addEventListener("submit", function(event) {
        event.preventDefault();

        // Recolectar los datos del formulario
        const nombre = document.getElementById("inputNombre").value;
        const apellido = document.getElementById("inputApellido").value;
        const email = document.getElementById("inputEmail").value;
        const pass1 = document.getElementById("inputPass1").value;
        const pass2 = document.getElementById("inputPass2").value;
        // Eliminado: const telefono = document.getElementById("inputTelefono").value;
        const urlGmail = document.getElementById("inputUrlGmail").value;        
        // Verificar si las contraseñas coinciden
        if (pass1 !== pass2) {
          document.getElementById("errorMessage").style.display = "block";
        } else {
          // Definir los datos a enviar
          const datos = {
            nombres: nombre,
            apellidos: apellido,
            correo: email,
            contra: pass1,
            urlGmail: urlGmail
          };

          const ruta = "/guardar";
          const opciones = {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(datos)
          };
          fetch(ruta, opciones)
            .then(response => {
              if (response.ok) {
                response.json().then(data => {                  
                  if (data.error_validation) {
                    alert("Correo ya existente.");
                  } else if (data.success) {
                    alert("Registro exitoso.");
                    login(); // Llamar a la función login directamente aquí
                  }
                })
              } else{
                alert(
                  "Ocurrió un error al cambiar la contraseña. Por favor, inténtalo de nuevo."
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
  <script>
    function redireccionar1() {
      var url = "/documentos/urlGmail.pdf";
      window.open(url, "_blank");
    }
  </script>
  <script>
    function login() {
      window.location.href = "/login";
    }
  </script>
</body>

</html>