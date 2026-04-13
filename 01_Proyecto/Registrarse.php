<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AutoHub - Registrarse</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="login-styles.css">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body class="register-page">
    <!-- Header -->
    <header class="header">
        <div class="container">
            <div class="logo ubicado">
                <h1>AutoHub</h1>
            </div>
        </div>
    </header>

    <!-- Login Container -->
    <div class="login-page">
        <div class="login-container">
            <div class="login-box">
                <!-- Tabs -->
                <div class="tabs">
                    <a href="login.php" class="tab-btn">Iniciar Sesión</a>
                    <a href="Registrarse.php" class="tab-btn active">Registrarse</a>
                </div>
                <div class="wrapper">
                <form action="" method="POST">
                    <h1>Registrarse</h1>
                    <div class="input-box">
                        <input type="text" name="Nombre" placeholder="Nombre" required="">
                        <i class='bx bxs-user'></i>
                    </div>
                    <div class="input-box">
                        <input type="email" name="Correo" placeholder="Correo electrónico" required>
                        <i class='bx bxs-envelope'></i>
                    </div>
                    <div class="input-box">
                        <input type="password" name="Password" placeholder="Contraseña" required minlength="6">
                        <i class='bx bxs-lock-alt'></i>
                    </div>
                    <button type="submit" class="btn">Crear Cuenta</button>
                    <div class="register-link"><p>¿Ya tienes una cuenta? <a href="login.php">Iniciar Sesión</a></p></div>
                </form>
                </div>
            </div>
            
            <!-- Php section -->
            <?php 
                
                //si es que se envia el formulario, lo que se guardo en las casillas lo gurdamos en "variables" para despues meterlas a la base de datos
                if($_SERVER["REQUEST_METHOD"] == "POST" ){
                    $Nombre = $_REQUEST['Nombre'];
                    $Correo = $_REQUEST['Correo'];
                    $Password = $_REQUEST['Password'];
                    
                    //creamos la conexion a la base de datos(lacal host, nombre de usuario, contraseña, y la base da datos)
                    $link= mysqli_connect("localhost", "root",  "","sistemasii");
                    if (!$link) {
                        die("Error de conexion: " . mysqli_connect_error());
                    }
                    //Revision (vemos si ya hay un usario con ese correo)
                    $revision = "SELECT * FROM Usuario WHERE Correo = '$Correo'";
                    $ResultadoR = mysqli_query($link,$revision);

                    
                    if (mysqli_num_rows($ResultadoR) > 0) {
                        echo "Error: El correo electronico ya está registrado.";
                    } else {
                        //Insertamos todo en la base
                        $query = "INSERT INTO usuario(Nombre, Correo, Password) 
                        VALUES ('$Nombre', '$Correo', '$Password')";  

                        if (mysqli_query($link, $query)){
                            header("Location: Login.php");
                            exit();
                        } else {
                            echo "Error al registrar: " . mysqli_error($link);
                        }
                    }
                }
            ?>

            <!-- Benefits Section -->
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