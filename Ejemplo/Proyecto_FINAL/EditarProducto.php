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
                <a href="SubirProducto.php" class="tm-page-link ">
                  <i class="fas fa-upload tm-page-link-icon"></i>
                  <span>Subir Producto</span>
                </a>
              </li>
              <li class="tm-page-nav-item">
                <a href="#editar" class="tm-page-link active">
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

       <!-- Editar Productos -->
<nav class="tm-black-bg tm-drinks-nav" style="background-color: #1a1a1a; padding: 1rem; border-radius: 10px;">
  <ul>
    <li>
      <a href="#" class="tm-tab-link active" data-id="editar" style="color: #00bcd4; font-family: 'Georgia', serif; font-size: 1.5rem; letter-spacing: 1px;">EDITAR PRODUCTOS</a>
    </li>
  </ul>
</nav>

<div id="editar" class="tm-tab-content" style="margin-top: 2rem;">
  <div class="tm-list">

    <?php
    if (!isset($_SESSION['id_usuario'])) {
        die("Debes iniciar sesión.");
    }

    $conexion = mysqli_connect("localhost", "root", "", "intercambios");
    $id_usuario = $_SESSION['id_usuario'];

    if (isset($_POST['guardar'])) {
        $id_producto = $_POST['id_producto'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];

        if ($_FILES['imagen']['name'] != "") {
            $imagenNombre = $_FILES['imagen']['name'];
            $imagenTmp = $_FILES['imagen']['tmp_name'];
            $ruta = "imagenes_Usuarios/" . basename($imagenNombre);
            move_uploaded_file($imagenTmp, $ruta);

            $sql = "UPDATE producto SET nombre=?, descripcion=?, imagen=? WHERE id_producto=? AND id_usuario=?";
            $stmt = mysqli_prepare($conexion, $sql);
            mysqli_stmt_bind_param($stmt, "sssii", $nombre, $descripcion, $imagenNombre, $id_producto, $id_usuario);
        } else {
            $sql = "UPDATE producto SET nombre=?, descripcion=? WHERE id_producto=? AND id_usuario=?";
            $stmt = mysqli_prepare($conexion, $sql);
            mysqli_stmt_bind_param($stmt, "ssii", $nombre, $descripcion, $id_producto, $id_usuario);
        }

        mysqli_stmt_execute($stmt);
        echo "<p style='color: #4caf50; margin: 1rem 0;'>✅ Producto actualizado correctamente.</p>";
    }

    $resultado = mysqli_query($conexion, "SELECT * FROM producto WHERE id_usuario = $id_usuario");

    while ($fila = mysqli_fetch_assoc($resultado)) {
    ?>
      <div class="tm-list-item" style="display: flex; flex-wrap: wrap; gap: 2rem; background-color: #1e1e1e; padding: 2rem; border-radius: 12px; margin-bottom: 2rem; box-shadow: 0 4px 12px rgba(0,0,0,0.5);">
        <img src="imagenes_Usuarios/<?php echo $fila['imagen']; ?>" alt="Imagen del producto" style="max-width: 180px; border-radius: 10px; border: 2px solid #00bcd4;">

        <div style="flex: 1; min-width: 250px; color: #ddd; font-family: 'Segoe UI', sans-serif;">
          <form action="EditarProducto.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_producto" value="<?php echo $fila['id_producto']; ?>">

            <label style="font-weight: bold; display: block; margin-top: 0.5rem;">Nombre:</label>
            <input type="text" name="nombre" value="<?php echo $fila['nombre']; ?>" required
              style="width: 100%; padding: 0.6rem; margin-bottom: 1rem; border-radius: 8px; background-color: #2a2a2a; border: 1px solid #444; color: #fff;">

            <label style="font-weight: bold; display: block;">Descripción:</label>
            <textarea name="descripcion" rows="4" required
              style="width: 100%; padding: 0.6rem; margin-bottom: 1rem; border-radius: 8px; background-color: #2a2a2a; border: 1px solid #444; color: #fff;"><?php echo $fila['descripcion']; ?></textarea>

            <label style="font-weight: bold; display: block;">Cambiar imagen:</label>
            <input type="file" name="imagen"
              style="width: 100%; padding: 0.5rem; background-color: #2a2a2a; color: #fff; border-radius: 8px; border: 1px solid #444; margin-bottom: 1.5rem;">

            <button type="submit" name="guardar"
              style="background-color: #00bcd4; color: white; padding: 0.6rem 1.2rem; border: none; border-radius: 8px; font-size: 1rem; cursor: pointer;">
              Guardar cambios
            </button>
          </form>
        </div>
      </div>
    <?php } ?>
  </div>
</div>
<!-- Fin de edición de producto -->


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