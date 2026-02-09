<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wave Cafe HTML Template by Tooplate</title>
    <link rel="stylesheet" href="fontawesome/css/all.min.css"> <!-- https://fontawesome.com/ -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet" /> <!-- https://fonts.google.com/ -->
    <link rel="stylesheet" href="css/tooplate-wave-cafe.css">
    <?PHP  session_start(); 
      if($_SESSION["k_username"] && $_SESSION["k_tipo"]==1);
      else header("Location: indexPrincipal.php");
    ?>
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
            <h1 class="tm-site-name">INTERCAMBIO FCC</h1>
          </div>
          <nav class="tm-site-nav">
            <ul class="tm-site-nav-ul">
              <li class="tm-page-nav-item">
                <a href="UsuariosEnLaRed.php" class="tm-page-link">
                  <i class="fas fa-users tm-page-link-icon"></i>
                  <span>Usarios</span>
                </a>
              </li>
              <li class="tm-page-nav-item">
                <a href="#subir" class="tm-page-link active">
                  <i class="fas fa-upload tm-page-link-icon"></i>
                  <span>Subir Producto</span>
                </a>
              </li>
              <li class="tm-page-nav-item">
                <a href="EditarProducto.php" class="tm-page-link ">
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
              </li>
            </ul>
          </nav>
        </div>        
      </div>
      <div class="tm-right">
        <main class="tm-main">

   <!-- Subir nuevo producto -->
<nav class="tm-black-bg tm-drinks-nav" style="background-color: #1a1a1a; padding: 1rem; border-radius: 10px;">
  <ul>
    <li>
      <a href="#" class="tm-tab-link active" data-id="subir" style="color: #00bcd4; font-family: 'Georgia', serif; font-size: 1.5rem; letter-spacing: 1px;">SUBIR NUEVO PRODUCTO</a>
    </li>
  </ul>
</nav>

<div id="subir" class="tm-tab-content" style="margin-top: 2rem;">
  <div class="tm-list-item" style="display: flex; align-items: flex-start; gap: 2rem; margin-bottom: 2rem; background-color: #1e1e1e; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5); flex-wrap: wrap;">
    <img src="img/agregar.png" alt="Imagen" class="tm-list-item-img" style="max-width: 180px; border-radius: 8px; border: 2px solid #00bcd4;">

          <div class="tm-black-bg tm-list-item-text" style="background-color: transparent; color: #ddd; font-family: 'Segoe UI', sans-serif; flex: 1; min-width: 250px;">
          <form action="" method="POST" enctype="multipart/form-data" style="font-size: 1rem;">
              <label for="nombre" style="font-weight: bold; display: block; margin-bottom: 0.3rem;">Nombre del producto:</label>
              <input type="text" name="nombre" id="nombre" required
                  style="width: 100%; padding: 0.6rem; border-radius: 8px; border: 1px solid #444; background-color: #2a2a2a; color: #fff; margin-bottom: 1rem;">

              <label for="descripcion" style="font-weight: bold; display: block; margin-bottom: 0.3rem;">Descripción:</label>
              <textarea name="descripcion" id="descripcion" rows="4" required
                  style="width: 100%; padding: 0.6rem; border-radius: 8px; border: 1px solid #444; background-color: #2a2a2a; color: #fff; margin-bottom: 1rem;"></textarea>

              <label for="imagen" style="font-weight: bold; display: block; margin-bottom: 0.3rem;">Imagen:</label>
              <input type="file" name="imagen" id="imagen" accept="image/*" required
                  style="padding: 0.5rem; background-color: #2a2a2a; color: #fff; border-radius: 8px; border: 1px solid #444; margin-bottom: 1.5rem; width: 100%;">

              <button type="submit" name="subir"
                  style="background-color: #00bcd4; color: white; padding: 0.6rem 1.2rem; border: none; border-radius: 8px; font-size: 1rem; cursor: pointer;">
                  Subir producto
              </button>
          </form>

          <?php
          if (isset($_POST['subir'])) {
              $nombre = trim($_POST['nombre']);
              $descripcion = $_POST['descripcion'];
              $id_usuario = $_SESSION['id_usuario'];
              
              $link = mysqli_connect("localhost", "root", "", "intercambios");
              
              // procesamos la imagen
              $imagenNombre = $_FILES['imagen']['name'];
              $imagenTmp = $_FILES['imagen']['tmp_name'];
              $rutaDestino = "imagenes_Usuarios/" . basename($imagenNombre);
              
              if (!file_exists("imagenes_Usuarios")) {
                  mkdir("imagenes_Usuarios", 0777, true);
              }
              
              if (move_uploaded_file($imagenTmp, $rutaDestino)) {
                  try {
                      // aqui llamamos el procedimiento almacenado
                      $stmt = mysqli_prepare($link, "CALL InsertarProducto(?, ?, ?, ?, @resultado)");
                      mysqli_stmt_bind_param($stmt, "sssi", $nombre, $descripcion, $imagenNombre, $id_usuario);
                      mysqli_stmt_execute($stmt);
                      
                      
                      $resultado = mysqli_query($link, "SELECT @resultado AS resultado");
                      $row = mysqli_fetch_assoc($resultado);
                      
                      echo "<p style='color: #4caf50; margin-top: 1rem;'>✅ ".$row['resultado']."</p>";
                      
                      mysqli_stmt_close($stmt);
                  } catch (mysqli_sql_exception $e) {
                      // capturar el error del trigger
                      if ($e->getCode() == 1644) { 
                          echo "<p style='color:red;'>".$e->getMessage()."</p>";
                      } else {
                          echo "<p style='color: #f44336; margin-top: 1rem;'>❌ Error: ".$e->getMessage()."</p>";
                      }
                  }
              } else {
                  echo "<p style='color: #f44336; margin-top: 1rem;'>❌ Error al subir la imagen.</p>";
              }
          }
          ?>
      </div>
    </div>
  </div>
</div>
<!-- Fin de subir producto -->



        </main>
      </div>    
    </div>
  </div>
    
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