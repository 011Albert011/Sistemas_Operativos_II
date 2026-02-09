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
      if($_SESSION["k_username"] && $_SESSION["k_tipo"]==0);
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
            <h1 class="tm-site-name">INTERCAMBIO ADM FCC</h1>
          </div>
     <nav class="tm-site-nav">
            <ul class="tm-site-nav-ul">
              <li class="tm-page-nav-item">
                <a href="UsuariosEnLaRed.php" class="tm-page-link active ">
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
                <a href="ReporteIntercambios.php" class="tm-page-link ">
                  <i class="fas fa-folder tm-page-link-icon"></i>
                  <span>REPORTES </span>
                </a>
              </li>
            </ul>
          </nav>
        </div>        
      </div>
      <div class="tm-right">
        <main class="tm-main">
         
            <!-- inicio de menu -->
      <!-- Usuarios Conectados -->
<nav class="tm-black-bg tm-drinks-nav" style="background-color: #1a1a1a; padding: 1rem; border-radius: 10px;">
  <ul>
    <li>
      <a href="#" class="tm-tab-link active" data-id="UsuariosConectados" style="color: #00bcd4; font-family: 'Georgia', serif; font-size: 1.5rem; letter-spacing: 1px;">USUARIOS CONECTADOS</a>
    </li>
  </ul>
</nav>

<div id="UsuariosConectados" class="tm-tab-content" style="margin-top: 2rem;">
  <div class="tm-list">
    <?php
      $link = mysqli_connect("localhost", "root", "");
      mysqli_select_db($link, "intercambios");

      $resultado = mysqli_query($link, "SELECT * FROM usuario WHERE tipo = 1");
      while($usuario = mysqli_fetch_array($resultado)) {
          $id_usuario = $usuario['id_usuario'];
          $nombre = $usuario['usuario'];
          $login = $usuario['login'];
    ?>
      <div class="tm-list-item" style="display: flex; align-items: center; gap: 1.5rem; margin-bottom: 1.5rem; background-color: #1e1e1e; padding: 1.5rem; border-radius: 12px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);">
        <img src="img/avatar.png" alt="Avatar" class="tm-list-item-img" style="width: 80px; height: 80px; border-radius: 50%; border: 2px solid #00bcd4;">

        <div class="tm-black-bg tm-list-item-text" style="background-color: transparent; color: #ddd; font-family: 'Segoe UI', sans-serif;">
          <h3 class="tm-list-item-name" style="font-size: 1.2rem; font-weight: bold; color: #ffffff;">
            <?php echo $id_usuario . ".- " . $nombre; ?>
            <span class="tm-list-item-price" style="font-size: 1rem; color: #00bcd4; margin-left: 10px;"><?php echo $login; ?></span>
          </h3>
          <p class="tm-list-item-description" style="margin-top: 0.5rem; color: #bbbbbb;">Usuario conectado en la pagina.</p>
        </div>
      </div>
    <?php } ?>
  </div>
</div>
            <!-- fin de menu -->
          </div>
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