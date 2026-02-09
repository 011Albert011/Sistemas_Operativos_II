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
                <a href="#productos" class="tm-page-link active">
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
       <!-- MIS PRODUCTOS -->
<div id="productos" class="tm-page-content">

  <nav class="tm-black-bg tm-drinks-nav" style="background-color: #1a1a1a; padding: 1rem; border-radius: 10px;">
    <ul>
      <li>
        <a href="#" class="tm-tab-link active" data-id="MisProductos" style="color: #00bcd4; font-family: 'Georgia', serif; font-size: 1.5rem; letter-spacing: 1px;">
          MIS PRODUCTOS
        </a>
      </li>
    </ul>
  </nav>

  <div id="MisProductos" class="tm-tab-content" style="margin-top: 2rem;">
    <div class="tm-list">

      <?php
      $link = mysqli_connect("localhost", "root", "");
      mysqli_select_db($link, "intercambios");

      $resultado = mysqli_query($link, "SELECT * FROM producto WHERE id_usuario = '".$_SESSION['id_usuario']."'");
      while($producto = mysqli_fetch_array($resultado)) {
          $id_usuario = $producto['id_usuario'];
          $id_producto = $producto['id_producto'];
          $nombre = $producto['nombre'];
          $descripcion = $producto['descripcion'];
          $imagen = $producto['imagen'];
      ?>
        <div class="tm-list-item" style="display: flex; flex-wrap: wrap; gap: 2rem; background-color: #1e1e1e; padding: 2rem; border-radius: 12px; margin-bottom: 2rem; box-shadow: 0 4px 12px rgba(0,0,0,0.5);">
          
          <img src="imagenes_Usuarios/<?php echo $imagen; ?>" alt="Imagen del producto" style="max-width: 180px; border-radius: 10px; border: 2px solid #00bcd4;">

          <div style="flex: 1; min-width: 250px; color: #ddd; font-family: 'Segoe UI', sans-serif;">
            <h3 style="color: #fff; font-size: 1.2rem; margin-bottom: 0.5rem;"><?php echo $id_producto . ".- " . $nombre; ?></h3>
            <p style="font-size: 0.95rem; color: #aaa; margin-bottom: 1rem;"><?php echo $descripcion; ?></p>
            <p style="font-size: 0.85rem; color: #888;">ID Usuario: <?php echo $id_usuario; ?></p>
          </div>
        </div>
      <?php } ?>

    </div>
  </div>

</div>
<!-- FIN MIS PRODUCTOS -->

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