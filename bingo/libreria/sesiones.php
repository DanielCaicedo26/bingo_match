<?php 
session_start();

include('usuario.php');

$usuario = new Usuario();

if (isset($_POST['registrarse'])) {
    $usuario->setNombreUsuario($_POST['nombre_usuario']);
    $usuario->setCorreo($_POST['correo_registro']);
    $usuario->setContrasena($_POST['contrasena_registro']);

    // Comprobar si el correo ya está registrado
    $conexion = new Conexion();
    $stmt = $conexion->conectar()->prepare("SELECT * FROM usuarios WHERE correo = :correo");
    $stmt->execute([':correo' => $_POST['correo_registro']]);

    if ($stmt->rowCount() > 0) {
        echo "<script>alert('Este correo ya está registrado.')</script>";
    } else {
        $usuario->registrar();
        echo "<script>alert('Registro exitoso. Ahora puedes iniciar sesión.')</script>";
    }
}

if (isset($_POST['iniciar_sesion'])) {
    $correo = $_POST['correo_login'];
    $contrasena = $_POST['contrasena_login'];
    $usuarioInfo = $usuario->iniciarSesion($correo, $contrasena);

    if ($usuarioInfo) {
        $_SESSION['id_usuario'] = $usuarioInfo['id'];
        $_SESSION['nombre_usuario'] = $usuarioInfo['nombre_usuario'];
        $_SESSION['foto_perfil'] = $usuarioInfo['foto_perfil'];
        header("Location: :http://localhost/2901817PHP/2901817/bingo.git/bingo/login/iniciodeljuego/inicio.php");
        exit;
    } else {
        echo "<script>alert('No se encontró una cuenta con ese correo o la contraseña es incorrecta.')</script>";
    }
}
?>
