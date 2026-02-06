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
                    <form action="" method="post">
                        <h1>Iniciar Sesión</h1>
                        <div class="input-box">
                            <input type="text" name="username" placeholder="Usuario o correo" required>
                            <i class='bx bxs-user'></i>
                        </div>
                        <div class="input-box">
                            <input type="password" name="password" placeholder="Contraseña" required>
                            <i class='bx bxs-lock-alt'></i>
                        </div>
                        <div class="remember-forgot">
                            <label><input type="checkbox" name="remember"> Recuérdame</label>
                            <a href="#">¿Olvidaste la contraseña?</a>
                        </div>
                        <button type="submit" class="btn">Iniciar Sesión</button>
                        <div class="register-link"><p>¿No tienes cuenta? <a href="Registrarse.php">Registrarte</a></p></div>
                    </form>
                </div>
            </div>
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