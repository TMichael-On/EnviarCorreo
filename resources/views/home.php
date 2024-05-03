<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vista de Usuario</title>
    <!-- Bootstrap CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <style>
      /* Estilos personalizados */
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
      .table {
        width: 100%;
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
    <div class="container content
    ">
      <!-- Encabezado -->
      <div class="user-header">
        <div class="row align-items-center">
          <div class="col-auto">
          <img src="public\svg\logo-1.svg" alt="Logo" class="logo"/>
          </div>
          <div class="col">
            <h1 class="home-title">Home</h1>
          </div>
          <div class="col-auto">
            <div class="row">
              <div class="col-12">
                <span class="">Apellidos, nombres</span>
              </div>
              <div class="col-12">
                <span class="">Correo</span>
              </div>
            </div>
          </div>
          <div class="col-auto">
            <div class="row">
              <div class="col-12">
                <button class="btn changepass-btn">Cambio contraseña</button>
              </div>
              <div class="col-12">
                <button class="btn logout-btn">Logout</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Cuerpo -->
      <div class="container">
        <label>Los correos se envían a las 9:00 a.m.</label>
        <button onclick="refrescarPagina()">Actualizar</button>
      </div>
      <div class="user-body">
        <div class="col" style="display: flex; align-items: baseline">
          <h5 style="margin-right: 10px">Fecha:</h5>
          <h2 style="margin-bottom: 0"><span id="currentDate"></span></h2>
        </div>
        <div class="row">
          <div class="col">
            <table class="table" id="dateExp">
              <thead>
                <tr>
                  <th scope="col">N°</th>
                  <th scope="col">Correo</th>
                  <th scope="col">Expediente</th>
                  <th scope="col">Proceso</th>
                  <th scope="col">Tarea</th>
                  <th scope="col">F. Asignado</th>
                  <th scope="col">F. Limite</th>
                  <th scope="col">F. Enviado</th>
                  <th scope="col">Estado</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col" style="display: flex; align-items: baseline">
        <h2 style="margin-bottom: 0">Expedientes:</h2>
      </div>
      <div class="user-body">
        <div class="row">
          <div class="col">
            <table class="table" id="userData">
              <thead>
                <tr>
                  <th scope="col">N°</th>
                  <th scope="col">Correo</th>
                  <th scope="col">Expediente</th>
                  <th scope="col">Proceso</th>
                  <th scope="col">Tarea</th>
                  <th scope="col">F. Asignado</th>
                  <th scope="col">F. Limite</th>
                  <th scope="col">F. Enviado</th>
                  <th scope="col">Estado</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>
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
    <!-- Bootstrap Bundle JS (Popper incluido) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const currentDateSpan = document.getElementById("currentDate");
        const today = new Date();
        const options = {
          weekday: "long",
          year: "numeric",
          month: "long",
          day: "numeric",
        };
        currentDateSpan.textContent = today.toLocaleDateString(
          "es-ES",
          options
        );
      });
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const user = 1;
        const url =
          "http://localhost/proyecto/php/cuadro-diario.php?id=" + user;

        fetch(url)
          .then((response) => response.json())
          .then((data) => {
            const userData = document.getElementById("dateExp");
            data.forEach((row, index) => {
              const newRow = document.createElement("tr");
              let estadoColor = "";
              if (row.estado === "0") {
                estadoColor = "orange";
              } else if (row.estado === "1") {
                estadoColor = "green";
              }

              newRow.innerHTML = `
                <td>${
                  index + 1
                }</td> <!-- Usar el índice + 1 como número de fila -->
                <td>${row.dest_correo}</td>
                <td>${row.expediente}</td>
                <td>${row.proceso}</td>
                <td>${row.tarea}</td>
                <td>${row.asignado}</td>
                <td>${row.limite}</td>
                <td>${row.enviado === "0000-00-00" ? "-" : row.enviado}</td>
                <td style="color: ${estadoColor};">${
                row.estado === "0" ? "En proceso" : "Enviado"
              }</td>
              `;
              userData.appendChild(newRow);
            });
          })
          .catch((error) => console.error("Error:", error));
      });
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        const userSpan = document.getElementById("userSpan");
        if (userSpan) {
          userSpan.textContent = "Apellido, Nombre";
        }
        const user = 1;
        const url =
          "http://localhost/proyecto/php/cuadro-general.php?id=" + user;
        fetch(url)
          .then((response) => response.json())
          .then((data) => {
            const userData = document.getElementById("userData");
            data.forEach((row, index) => {
              const newRow = document.createElement("tr");
              let estadoColor = "";
              if (row.estado === "0") {
                estadoColor = "orange";
              } else if (row.estado === "1") {
                estadoColor = "green";
              }

              newRow.innerHTML = `
                <td>${
                  index + 1
                }</td> <!-- Usar el índice + 1 como número de fila -->
                <td>${row.dest_correo}</td>
                <td>${row.expediente}</td>
                <td>${row.proceso}</td>
                <td>${row.tarea}</td>
                <td>${row.asignado}</td>
                <td>${row.limite}</td>
                <td>${row.enviado === "0000-00-00" ? "-" : row.enviado}</td>
                <td style="color: ${estadoColor};">${
                row.estado === "0" ? "En proceso" : "Enviado"
              }</td>
              `;
              userData.appendChild(newRow);
            });
          })
          .catch((error) => console.error("Error:", error));
      });
    </script>
    <script>
      function refrescarPagina() {
        // Esta función refresca la página
        window.location.reload();
      }
    </script>
  </body>
</html>