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
            <h1 class="tm-site-name">Intercambio FCC</h1>
          </div>
          <nav class="tm-site-nav">
            <ul class="tm-site-nav-ul">
              <li class="tm-page-nav-item">
                <a href="IndexPrincipal.php" class="tm-page-link">
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
      <div class="tm-right">
        <main class="tm-main">

          <!-- Registrarse Page -->
          
            <div class="tm-black-bg tm-contact-text-container">
              <h2 class="tm-text-primary">Registrate</h2>
              <p>Registrate y disfruta enviado imagenes.</p>
            </div>
            <div class="tm-black-bg tm-contact-form-container tm-align-right">
              <form action="" method="POST" id="contact-form">
                <div class="tm-form-group">
                  <input type="text" name="usuario" class="tm-form-control" placeholder="Name" required="" />
                </div>
                <div class="tm-form-group">
                  <input type="text" name="login" class="tm-form-control" placeholder="Login" required="" />
                </div>
                <div class="tm-form-group">
                  <input type="text" name="descripcion" class="tm-form-control" placeholder="Descripcion de tu perfil" required="" />
                </div>
                <div class="tm-form-group">
                  <?PHP $tipo = 1; echo "<input type='hidden' name='tipo' value='$tipo'>"; ?>
                  <input type="password" name="password" class="tm-form-control" placeholder="Contraseña" required="" />        
                <div><br>
                  <button type="submit" class="tm-btn-primary tm-align-right">
                    Registrarse
                  </button>
                </div>
              </form>
            </div>

            <?PHP 
			
            if($_SERVER["REQUEST_METHOD"] == "POST" ){
            $nombre = $_REQUEST['usuario'];
            $login = $_REQUEST['login'];
            $descripcionU = $_REQUEST['descripcion'];
            $contraseña = $_REQUEST['password'];
            $tipo = $_REQUEST['tipo'];
            
            $link= mysqli_connect("localhost", "root",  "");
            mysqli_select_db($link , "intercambios");
            
            $resultado=mysqli_query($link,"select * from usuario");
            $usuario=mysqli_fetch_array($resultado);
            
            $query = "INSERT INTO usuario(login, password, tipo , usuario , descripcionU) 
              VALUES ('" . $login . "', '" . $contraseña . "', '" . $tipo . "', '" . $nombre . "', '" . $descripcionU . "')";
              
            if (mysqli_query($link, $query)){
              header("Location: Login.php");
              exit();
              }else {
              echo "Error en la base de datos ".mysqli_error($link);
              }
              
            
            }	  
            ?>
            <div class="col-md-6 col-lg-7 px-0">
              <div class="map_container">
                <div class="map">
                  <div id="googleMap"></div>
                </div>
              </div>
            </div>
          
          <!-- end Contact Page -->
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