<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoHub - Iniciar Sesión</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="login-styles.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="header-content">
                <div class="logo ubicado">
                    <h1>AutoHub</h1>
                </div>
            </div>
    </header> 

    <!-- Login Container -->
    <div class="login-page">
        <div class="login-container">
            <div class="login-box">
                <div class="tabs">
                    <a href="login.php" class="tab-btn active">Iniciar Sesión</a>
                    <a href="Registrarse.php" class="tab-btn">Registrarse</a>
                </div>
                <div class="wrapper">
                    <form action="" method="POST">
                        <h1>Iniciar Sesión</h1>
                        <div class="input-box">
                            <input type="text" name="Nombre" placeholder="Usuario" required>
                            <i class='bx bxs-user'></i>
                        </div>
                        <div class="input-box">
                            <input type="password" name="Password" placeholder="Contraseña" required>
                            <i class='bx bxs-lock-alt'></i>
                        </div>
                        <button type="submit" class="btn">Iniciar Sesión</button>
                        <div class="register-link"><p>¿No tienes cuenta? <a href="Registrarse.php">Registrarte</a></p></div>
                    </form>
                </div>
            </div>

            <!-- Php section -->
            <?php 
                
                //si es que se envia el formulario, lo que se guardo en las casillas lo gurdamos en "variables" para despues meterlas a la base de datos
                if($_SERVER["REQUEST_METHOD"] == "POST" ){
                    $Nombre = $_REQUEST['Nombre'];
                    $Password = $_REQUEST['Password'];
                    
                    //creamos la conexion a la base de datos
                    $link= mysqli_connect("localhost", "root",  "","sistemasii");
                    if (!$link) {
                        die("Error de conexion: " . mysqli_connect_error());
                    }
                    
                    //CONSULTA
                    $consulta = "SELECT * FROM Usuario where Nombre='$Nombre' AND Password='$Password'";
                    $resultado = mysqli_query($link,$consulta);

                    //VERIFICENTRO(checamos si esta el usuario en la base de datos jaja)
                    if(mysqli_num_rows($resultado) > 0){
                        $Usuario = mysqli_fetch_array($resultado);

                        header("Location: indexprincipal.php");
                        exit();
                    }else{
                        echo"Usuario o contraseña incorrectos";
                    }
                }
            ?>

            <div class="benefits-section">
                <div class="benefit-item">
                    <div class="benefit-icon">🚚</div>
                    <h4>Envío Rápido</h4>
                    <p>Entrega en 24-48 horas</p>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">💳</div>
                    <h4>Pago Seguro</h4>
                    <p>Múltiples formas de pago</p>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">🔄</div>
                    <h4>Cambios Fáciles</h4>
                    <p>Hasta 30 días de garantía</p>
                </div>
                <div class="benefit-item">
                    <div class="benefit-icon">💬</div>
                    <h4>Soporte 24/7</h4>
                    <p>Estamos aquí para ayudarte</p>
                </div>
            </div>
        </div>
    </div> 

    <script src="login-script.js"></script>
</body>
</html>
