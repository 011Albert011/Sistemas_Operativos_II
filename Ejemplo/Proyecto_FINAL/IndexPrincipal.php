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
            <h1 class="tm-site-name">INTERCAMBIO FCC</h1>
          </div>
          <nav class="tm-site-nav">
            <ul class="tm-site-nav-ul">
              <li class="tm-page-nav-item">
                <a href="#about" class="tm-page-link">
                  <i class="fas fa-trophy tm-page-link-icon"></i>
                  <span>Sobre nosotros</span>
                </a>
              </li>
              <li class="tm-page-nav-item">
                <a href="Usuarios.php" class="tm-page-link">
                  <i class="fas fa-users tm-page-link-icon"></i>
                  <span>Usarios en la red</span>
                </a>
              </li>
            <li class="tm-page-nav-item">
             <a href="Registrarse.php" class="tm-page-link">
                <i class="fas fa-check tm-page-link-icon"></i>
                <span>Registrarse</span>
             </a>
            </li>
              <li class="tm-page-nav-item">
                <a href="Login.php" class="tm-page-link"> 
                  <i class="fas fa-star tm-page-link-icon"></i>
                  <span>Logear</span>
                </a>
              </li>
            </ul> 
         </nav>
        </div>        
      </div>

       <!-- Sobre nosotros -->
<div class="tm-right">
  <main class="tm-main">
    <div id="about" class="tm-page-content">
      <div class="tm-black-bg tm-mb-20 tm-about-box-1" style="padding: 2rem; border-radius: 15px; background-color: #1a1a1a; color: #e0e0e0; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.6);">
        
        <h2 class="tm-text-primary tm-about-header" style="font-family: 'Georgia', serif; font-size: 2rem; color: #00bcd4; margin-bottom: 1.5rem; text-align: center; letter-spacing: 2px;">
          EQUIPO 10
        </h2>

        <div class="tm-list-item tm-list-item-2" style="display: flex; flex-wrap: wrap; align-items: center; gap: 1.5rem;">
          <img src="img/buap.png" alt="Imagen equipo" class="tm-list-item-img tm-list-item-img-big" style="max-width: 300px; border-radius: 12px; border: 2px solid #00bcd4;">

          <div class="tm-list-item-text-2" style="flex: 1; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 1rem; line-height: 1.6; color: #ccc;">
            <p style="margin-bottom: 1rem;">
              Esta aplicación ha sido desarrollada para facilitar el <strong>intercambio de productos</strong> entre usuarios registrados. Cada producto puede tener imágenes, descripción de su estado y más, para asegurar un trato transparente y justo.
            </p>

            <p style="font-weight: bold; color: #fff; margin-bottom: 0.5rem;">Integrantes del equipo:</p>
            <ul style="list-style-type: square; padding-left: 1.5rem; color: #ccc;">
              <li>Aguila de Ita Angel Manuel</li>
              <li>Barojas Serrano Itzel</li>
              <li>Rodriguez Banda Cesar Ellian</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>
<!-- final sobre nosotros -->


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