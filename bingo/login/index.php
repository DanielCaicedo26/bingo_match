<?php
session_start();
$conexion = new mysqli('localhost', 'root', '', 'usuariosDa');

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

if (isset($_POST['registrarse'])) {
    $nombre_usuario = $_POST['nombre_usuario'];
    $correo = $_POST['correo_registro'];
    $contrasena = password_hash($_POST['contrasena_registro'], PASSWORD_DEFAULT);

    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->bind_param('s', $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        echo "<script>alert('Este correo ya está registrado.')</script>";
    } else {
        $stmt = $conexion->prepare("INSERT INTO usuarios (nombre_usuario, correo, contrasena) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $nombre_usuario, $correo, $contrasena);
        if ($stmt->execute()) {
            echo "<script>alert('Registro exitoso. Ahora puedes iniciar sesión.')</script>";
        } else {
            echo "<script>alert('Error al registrar usuario.')</script>";
        }
    }
}

if (isset($_POST['iniciar_sesion'])) {
    $correo = $_POST['correo_login'];
    $contrasena = $_POST['contrasena_login'];

    $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE correo = ?");
    $stmt->bind_param('s', $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        if (password_verify($contrasena, $usuario['contrasena'])) {
            // Guardar la información en la sesión
            $_SESSION['id_usuario'] = $usuario['id'];
            $_SESSION['nombre_usuario'] = $usuario['nombre_usuario'];
            $_SESSION['foto_perfil'] = $usuario['foto_perfil'];

            // Redirigir a la página principal del juego
            header("Location: iniciodeljuego/inicio.php");
            exit;
        } else {
            echo "<script>alert('Contraseña incorrecta.')</script>";
        }
    } else {
        echo "<script>alert('No se encontró una cuenta con ese correo.')</script>";
    }
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión y Registro</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <!-- Formulario de Inicio de Sesión -->
            <div id="login-form" class="form-switching">
                <!-- Avatar -->
                <div class="avatar-container">
                    <img src="img/aataer-removebg-preview.png" alt="Avatar" class="avatar">
                </div>
                <h2>Inicio de Sesión</h2>
                <form method="post" action="index.php">
                    <div class="form-group">
                        <label for="login-email">Correo electrónico</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" class="form-control" id="login-email" name="correo_login" placeholder="Ingresa tu correo" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="login-password">Contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="login-password" name="contrasena_login" placeholder="Ingresa tu contraseña" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('login-password', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" name="iniciar_sesion">Iniciar sesión</button>
                    <button type="button" class="toggle-btn" onclick="toggleForm()">¿No tienes cuenta? Regístrate</button>
                </form>
            </div>

            <!-- Formulario de Registro -->
            <div id="register-form" class="form-switching hidden">
                <!-- Avatar -->
                <div class="avatar-container">
                    <img src="img/aataer-removebg-preview.png" alt="Avatar" class="avatar">
                </div>
                <h2>Registro</h2>
                <form method="post" action="index.php">
                    <div class="form-group">
                        <label for="register-username">Nombre de usuario</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-user"></i></span>
                            </div>
                            <input type="text" class="form-control" id="register-username" name="nombre_usuario" placeholder="Ingresa tu nombre de usuario" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="register-email">Correo electrónico</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input type="email" class="form-control" id="register-email" name="correo_registro" placeholder="Ingresa tu correo" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="register-password">Contraseña</label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="register-password" name="contrasena_registro" placeholder="Ingresa tu contraseña" required>
                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('register-password', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block" name="registrarse">Registrarse</button>
                    <button type="button" class="toggle-btn" onclick="toggleForm()">¿Ya tienes cuenta? Inicia sesión</button>
                </form>
            </div>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/@splinetool/viewer@1.9.27/build/spline-viewer.js"></script>
    <spline-viewer loading-anim-type="spinner-big-light" url="https://prod.spline.design/o9HE31cT8HAhjAeT/scene.splinecode"></spline-viewer>
    <script src="js/script.js"></script>

    
</body>
</html>