<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wave Cafe HTML Template by Tooplate</title>
    <link rel="stylesheet" href="fontawesome/css/all.min.css"> <!-- https://fontawesome.com/ -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet" /> <!-- https://fonts.google.com/ -->
    <link rel="stylesheet" href="css/tooplate-wave-cafe.css">
<!--
Tooplate 2121 Wave Cafe
https://www.tooplate.com/view/2121-wave-cafe
-->
</head>
<body>
  <div class="tm-container">
    <div class="tm-row">
      <!-- Site Header -->
      <div class="tm-left">
        <div class="tm-left-inner">
          <div class="tm-site-header">
            <i class="fas fa-cube fa-3x tm-site-logo"></i>
            <h1 class="tm-site-name">INTERCAMBIO ADM FCC</h1>
          </div>
          <nav class="tm-site-nav">
            <ul class="tm-site-nav-ul">
              <li class="tm-page-nav-item">
                <a href="UsuariosEnLaRed.php" class="tm-page-link ">
                  <i class="fas fa-users tm-page-link-icon"></i>
                  <span>Usarios</span>
                </a>
              </li>
              <li class="tm-page-nav-item">
                <a href="SubirProducto.php" class="tm-page-link">
                  <i class="fas fa-upload tm-page-link-icon"></i>
                  <span>Subir Producto</span>
                </a>
              </li>
              <li class="tm-page-nav-item">
                <a href="EditarProducto.php" class="tm-page-link">
                  <i class="fas fa-edit tm-page-link-icon"></i>
                  <span>Editar Producto</span>
                </a>
              </li>
              <li class="tm-page-nav-item">
                <a href="EliminarProducto.php" class="tm-page-link">
                  <i class="fas fa-trash tm-page-link-icon"></i>
                  <span>Eliminar</span>
                </a>
              </li>
              <li class="tm-page-nav-item">
                <a href="MisProductos.php" class="tm-page-link">
                  <i class="fas fa-folder tm-page-link-icon"></i>
                  <span>Mis productos</span>
                </a>
              </li>

              <li class="tm-page-nav-item">
                <a href="IndexPrincipal.php" class="tm-page-link">
                  <i class="fas fa-circle-notch tm-page-link-icon"></i>
                  <span>Salir</span>
                </a>
				              <li class="tm-page-nav-item   ">
                <a href="MisProductos.php" class="tm-page-link active">
                  <i class="fas fa-folder tm-page-link-icon"></i>
                  <span>REPORTES </span>
                </a>
              </li>
              </li>
            </ul>
          </nav>
        </div>        
      </div>
      <div class="tm-right">
        <main class="tm-main">
         
<!-- INICIO REPORTEEEEE -->
<?php
session_start();
$link = mysqli_connect("localhost", "root", "", "intercambios");

// Verificar conexión
if (!$link) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Obtener los datos de intercambio con los nombres de los usuarios
$query = "SELECT 
            i.id, 
            u1.usuario AS nombre_envia, 
            u2.usuario AS nombre_recibe, 
            i.nombre_producto, 
            i.fecha 
          FROM intercambio i
          JOIN usuario u1 ON i.id_usuario_envia = u1.id_usuario
          JOIN usuario u2 ON i.id_usuario_recibe = u2.id_usuario
          ORDER BY i.fecha DESC";

$resultado = mysqli_query($link, $query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Intercambios</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Segoe+UI&display=swap');

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
            padding: 30px 50px;
            margin: 0;
        }

    
.report-title-container {
    background-color: #34495e; 
    padding: 1rem 2rem;
    border-radius: 10px;
    text-align: center;
    margin-bottom: 30px;
    box-shadow: 0 4px 12px rgba(52, 73, 94, 0.6); 
}

        .report-title {
            font-family: 'Georgia', serif;
            color: #00bcd4;
            font-size: 1.8rem;
            letter-spacing: 1px;
            margin: 0;
            font-weight: normal;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px; /* espacio entre filas */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 16px 20px;
            text-align: center;
        }

        thead th {
            background-color: #34495e;
            color: #ecf0f1;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            border-bottom: 2px solid #2c3e50;
        }

        tbody tr {
            background-color: #ffffff;
            transition: background-color 0.3s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.08);
            border-radius: 6px;
        }

        tbody tr:hover {
            background-color: #ecf0f1;
        }

        tbody td {
            color: #555;
            font-size: 1rem;
        }
    </style>
</head>
<body>

<div class="report-title-container">
    <h1 class="report-title">REPORTE DE INTERCAMBIOS</h1>
</div>

<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Usuario que envió</th>
            <th>Usuario que recibió</th>
            <th>Producto</th>
            <th>Fecha</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($fila = mysqli_fetch_assoc($resultado)) { ?>
            <tr>
                <td><?php echo $fila['id']; ?></td>
                <td><?php echo htmlspecialchars($fila['nombre_envia']); ?></td>
                <td><?php echo htmlspecialchars($fila['nombre_recibe']); ?></td>
                <td><?php echo htmlspecialchars($fila['nombre_producto']); ?></td>
                <td><?php echo $fila['fecha']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

</body>
</html>


  <!-- Background video -->
  <div class="tm-video-wrapper">
      <i id="tm-video-control-button" class="fas fa-pause"></i>
      <video autoplay muted loop id="tm-video">
          <source src="video/ls.mp4" type="video/mp4">
      </video>
  </div>

  <script src="js/jquery-3.4.1.min.js"></script>    
  <script>

    function setVideoSize() {
      const vidWidth = 1920;
      const vidHeight = 1080;
      const windowWidth = window.innerWidth;
      const windowHeight = window.innerHeight;
      const tempVidWidth = windowHeight * vidWidth / vidHeight;
      const tempVidHeight = windowWidth * vidHeight / vidWidth;
      const newVidWidth = tempVidWidth > windowWidth ? tempVidWidth : windowWidth;
      const newVidHeight = tempVidHeight > windowHeight ? tempVidHeight : windowHeight;
      const tmVideo = $('#tm-video');

      tmVideo.css('width', newVidWidth);
      tmVideo.css('height', newVidHeight);
    }

    function openTab(evt, id) {
      $('.tm-tab-content').hide();
      $('#' + id).show();
      $('.tm-tab-link').removeClass('active');
      $(evt.currentTarget).addClass('active');
    }    

    function initPage() {
      let pageId = location.hash;

      if(pageId) {
        highlightMenu($(`.tm-page-link[href^="${pageId}"]`)); 
        showPage($(pageId));
      }
      else {
        pageId = $('.tm-page-link.active').attr('href');
        showPage($(pageId));
      }
    }

    function highlightMenu(menuItem) {
      $('.tm-page-link').removeClass('active');
      menuItem.addClass('active');
    }

    function showPage(page) {
      $('.tm-page-content').hide();
      page.show();
    }

    $(document).ready(function(){

      /***************** Pages *****************/

      initPage();

      $('.tm-page-link').click(function(event) {
            const href = $(this).attr('href');

            // Si el enlace no es un ancla (no empieza con #), permite el comportamiento predeterminado
            if (!href.startsWith('#')) {
                return; // Sal del evento y permite que el navegador siga el enlace
            }

            // Si es un ancla y el ancho de la ventana es mayor a 991px, previene el comportamiento predeterminado
            if (window.innerWidth > 991) {
                event.preventDefault();
            }

            highlightMenu($(event.currentTarget));
            showPage($(event.currentTarget.hash));
        });

        function highlightMenu(menuItem) {
    $('.tm-page-link').removeClass('active');
    menuItem.addClass('active');
}

$(document).ready(function() {
    // Detecta la página actual y marca el enlace correspondiente como activo
    const currentPath = window.location.pathname;
    $('.tm-page-link').each(function() {
        const href = $(this).attr('href');
        if (currentPath.endsWith(href)) {
            $(this).addClass('active');
        }
    });

    // Maneja clics en los enlaces
    $('.tm-page-link').click(function(event) {
        const href = $(this).attr('href');

        // Si el enlace no es un ancla (no empieza con #), permite el comportamiento predeterminado
        if (!href.startsWith('#')) {
            return;
        }

        // Si es un ancla y el ancho de la ventana es mayor a 991px, previene el comportamiento predeterminado
        if (window.innerWidth > 991) {
            event.preventDefault();
        }

        highlightMenu($(event.currentTarget));
        showPage($(event.currentTarget.hash));
    });
});


      
      /***************** Tabs *******************/

      $('.tm-tab-link').on('click', e => {
        e.preventDefault(); 
        openTab(e, $(e.target).data('id'));
      });

      $('.tm-tab-link.active').click(); // Open default tab


      /************** Video background *********/

      setVideoSize();

      // Set video background size based on window size
      let timeout;
      window.onresize = function(){
        clearTimeout(timeout);
        timeout = setTimeout(setVideoSize, 100);
      };

      // Play/Pause button for video background      
      const btn = $("#tm-video-control-button");

      btn.on("click", function(e) {
        const video = document.getElementById("tm-video");
        $(this).removeClass();

        if (video.paused) {
          video.play();
          $(this).addClass("fas fa-pause");
        } else {
          video.pause();
          $(this).addClass("fas fa-play");
        }
      });
    });
      
  </script>
</body>
</html>