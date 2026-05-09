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
                $error_msg = '';

                if($_SERVER["REQUEST_METHOD"] == "POST" ){
                    $Nombre = trim($_REQUEST['Nombre'] ?? '');
                    $Correo = trim($_REQUEST['Correo'] ?? '');
                    $Password = $_REQUEST['Password'] ?? '';

                    $link = mysqli_connect("localhost", "root",  "","sistemasii");
                    if (!$link) {
                        die("Error de conexion: " . mysqli_connect_error());
                    }

                    $Correo = filter_var($Correo, FILTER_VALIDATE_EMAIL) ? $Correo : '';
                    if (!$Correo) {
                        $error_msg = "Ingresa un correo electrónico válido.";
                    }

                    if (!$error_msg) {
                        $revision = "SELECT Id_Usuario FROM Usuario WHERE Correo = ? LIMIT 1";
                        // prepara la consulta para verificar si el correo ya existe
                        if ($stmt = mysqli_prepare($link, $revision)) {
                            // enlaza el parametro de correo
                            mysqli_stmt_bind_param($stmt, "s", $Correo);
                            // ejecuta la consulta preparada
                            mysqli_stmt_execute($stmt);
                            // almacena el resultado para contar filas
                            mysqli_stmt_store_result($stmt);

                            if (mysqli_stmt_num_rows($stmt) > 0) {
                                $error_msg = "Error: El correo electronico ya está registrado.";
                            }

                            // cierra la consulta preparada
                            mysqli_stmt_close($stmt);
                        }
                    }

                    if (!$error_msg) {
                        // crea un hash seguro de la contrasena usando bcrypt
                        $hashedPassword = password_hash($Password, PASSWORD_BCRYPT);
                        $query = "INSERT INTO Usuario (Nombre, Correo, Password) VALUES (?, ?, ?)";
                        // prepara la consulta para insertar el nuevo usuario
                        if ($stmt = mysqli_prepare($link, $query)) {
                            // enlaza los parametros: nombre, correo, contrasena hasheada
                            mysqli_stmt_bind_param($stmt, "sss", $Nombre, $Correo, $hashedPassword);
                            if (mysqli_stmt_execute($stmt)) {
                                // cierra la consulta preparada
                                mysqli_stmt_close($stmt);
                                mysqli_close($link);
                                header("Location: Login.php");
                                exit();
                            } else {
                                $error_msg = "Error al registrar: " . mysqli_error($link);
                            }
                            // cierra la consulta preparada
                            mysqli_stmt_close($stmt);
                        } else {
                            $error_msg = "Error interno de servidor.";
                        }
                    }

                    mysqli_close($link);
                }
            ?>
            <?php if (!empty($error_msg)): ?>
                <div class="mensaje-error">
                    <?php echo htmlspecialchars($error_msg, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); ?>
                </div>
            <?php endif; ?>

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